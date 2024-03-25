<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cjob extends CI_Controller {

    public $menu;
    private $user_id;
    private $user_type;

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('session');
        $this->load->library('Smsgateway');
        $this->load->model('Jobs_model');
        $this->load->model('Products');
        $this->load->model('Vehicles');
        $this->load->model('Web_settings');
        $this->load->model('Quotation_model');
        $this->auth->check_admin_auth();
        $this->user_id = $this->session->userdata('user_id');
        $this->user_type = $this->session->userdata('user_type');
    }

    // Job Form
    public function index() {
        $data['title'] = display('add_job_order');
        if ($this->user_type == 3) {
            $data['customers'] = $this->Vehicles->owner_customer_info($this->user_id);
        } else {
            $data['customers'] = $this->Vehicles->customer_list();
        }
//        $data['customers'] = $this->Vehicles->customer_list();
        $data['get_jobtypelist'] = $this->Jobs_model->get_jobtypelist();
        $data['get_employeelist'] = $this->Jobs_model->get_employeelist();
        $data['get_productlist'] = $this->Jobs_model->get_productlist();
        $content = $this->parser->parse('job/job_form', $data, true);
        $this->template->full_admin_html_view($content);
    }

    /*
      |__________________________________________________________
      |Job confirmation
      |__________________________________________________________
     */

//    ============ its for jobtype_wise_info ============
    public function jobtype_wise_info() {
        $jobtype_id = $this->input->post('jobtype_id');
        $get_jobtype_info = $this->db->select('a.job_type_rate')
                ->from('job_type a')
//                ->join('product_purchase_details b', 'a.product_id = b.product_id')
                ->where('a.job_type_id', $jobtype_id)
                ->get()
                ->row();
        echo json_encode($get_jobtype_info);
    }

//============== its for insert_job =============
    public function insert_job() {
        $customer_id = $this->input->post('customer_id');
        $work_order_no = $this->input->post('work_order_no');
        $address = $this->input->post('address');
        $registration_no = $this->input->post('registration_no');
        $phone = $this->input->post('phone');
        $reference = $this->input->post('reference');
        $mobile = $this->input->post('mobile');
        $schedule_datetime = $this->input->post('schedule_datetime');
        $website = $this->input->post('website');
        $delivery_datetime = $this->input->post('delivery_datetime');
        $details = $this->input->post('details');
        $alert_via = $this->input->post('alert_via');
        $job_type_id = $this->input->post('job_type_id');
        $jobtype_rate = $this->input->post('jobtype_rate');
        $mechanics_id = $this->input->post('mechanics_id');
        $customer_note = $this->input->post('customer_note');
//        dd($this->user_type);
        if ($this->user_type == 1) {
            $status = 1;
        } else {
            $status = 0;
        }
//        dd($alert_via);
        $job_data = array(
            'customer_id' => $customer_id,
            'work_order_no' => $work_order_no,
            'vehicle_id' => $registration_no,
            'schedule_date_time' => $schedule_datetime,
            'delivery_date_time' => $delivery_datetime,
            'customer_ref' => $reference,
            'job_description' => $details,
            'alert_via' => $alert_via,
            'create_by' => $this->user_id,
            'create_date' => date('Y-m-d H:i:s'),
            'status' => $status, //0,
        );
//        dd($job_data);
        $this->db->insert('job', $job_data);
        $job_id = $this->db->insert_id();
        if ($job_id && $job_type_id) {
            for ($i = 0; $i < count($job_type_id); $i++) {
                $job_details_data = array(
                    'job_id' => $job_id,
                    'job_type_id' => $job_type_id[$i],
                    'assign_to' => $mechanics_id[$i],
                    'rate' => $jobtype_rate[$i],
                    'client_notes' => $customer_note[$i],
                    'status' => 0,
                );
                $this->db->insert('job_details', $job_details_data);
            }
        }
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cjob/manage_job'));
    }

//========= its for mechanic own job count ============
    public function own_mechanicjob_count($user_id, $user_type) {
        $query1 = $this->db->select('*')
                        ->from('job_details j')
                        ->where('j.assign_to', $user_id)
                        ->group_by('j.job_id')
                        ->get()->result();
        if (empty($query1)) {
            $not = "Not found";
            return $not;
        } else {
            foreach ($query1 as $job_id) {
                $jobid_arr[] = $job_id->job_id;
            }
            $status = '(a.status = 1 OR a.status = 3)';
            $this->db->select('count(a.job_id) ttl_count');
            $this->db->from('job a');
            $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
            $this->db->join('vehicle_information c', 'c.vehicle_id = a.vehicle_id');
            $this->db->where_in('a.job_id', $jobid_arr);
            $this->db->where($status);

            $this->db->order_by('a.job_id', 'desc');
            $query2 = $this->db->get()->result();
            //echo $this->db->last_query();
            return $query2;
        }
    }

//========= its for customer own job count ============
    public function own_customerjob_count($user_id) {
        $this->db->where('customer_id', $user_id);
        $num_rows = $this->db->count_all_results('job');
        return $num_rows;
    }

//    ============= its for manage_job ============
    public function manage_job() {
        $data['title'] = display('manage_job');
        $config["base_url"] = base_url('Cjob/manage_job/');
//        $config["total_rows"] = $this->db->count_all('job');  //dd($config["total_rows"]);
        if ($this->user_type == 1) {
            $config["total_rows"] = $this->db->count_all('job');
        } elseif ($this->user_type == 2) {
            $ttl_count = $this->own_mechanicjob_count($this->user_id, $this->user_type);
            $config["total_rows"] = $ttl_count[0]->ttl_count;
        } elseif ($this->user_type == 3) {
            $config["total_rows"] = $this->own_customerjob_count($this->user_id);
        }
//        dd($config["total_rows"]);
        $config["per_page"] = 25;
        $config["uri_segment"] = 3;
        $config["last_link"] = "Last";
        $config["first_link"] = "First";
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close'] = '</span></li>';
        #Paggination end#


        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $limit = $config["per_page"];
        if ($this->user_type == 2) {
            $data['job_list'] = $this->Jobs_model->mechanic_job_list($limit, $page, $this->user_id, $this->user_type);
        } else {
            $data['job_list'] = $this->Jobs_model->job_list($limit, $page, $this->user_id, $this->user_type);
        }
//        dd($data['job_list']);
        $data['links'] = $this->pagination->create_links();
        $data['pagenum'] = $page;

        $content = $this->parser->parse('job/manage_job', $data, true);
        $this->template->full_admin_html_view($content);
    }

//============= its for job_generate_invoice =============
    public function job_generate_invoice($job_id) {
        $data['title'] = display('job_to_invoice');
        $data['get_tax'] = $this->db->select('*')->from('tax_information')->get()->result();
        $data['get_job_info'] = $this->Jobs_model->get_job_info($job_id);
        $data['get_jobdetails_info'] = $this->Jobs_model->get_jobdetails_info($job_id);
        $data['get_job_products_used'] = $this->Jobs_model->get_job_products_used($job_id);
//        $data['get_groupproduct_used'] = $this->Jobs_model->get_groupproduct_used($job_id);

        $content = $this->parser->parse('job/job_generate_invoice', $data, true);
        $this->template->full_admin_html_view($content);
    }

    //This function is used to Generate Key
    public function generator($lenth) {
        $number = array("1", "2", "3", "4", "5", "6", "7", "8", "9");
        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 8);
            $rand_number = $number["$rand_value"];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }

    //NUMBER GENERATOR
    public function number_generator() {
        $this->db->select_max('invoice', 'invoice_no');
        $query = $this->db->get('invoice');
        $result = $query->result_array();
        $invoice_no = $result[0]['invoice_no'];
        if ($invoice_no != '') {
            $invoice_no = $invoice_no + 1;
        } else {
            $invoice_no = 1000;
        }
        return $invoice_no;
    }

//    ============= its for job_to_invoice_save =============
    public function job_to_invoice_save() {
        $createby = $this->session->userdata('user_id');
        $createdate = date('Y-m-d H:i:s');
        $invoice_id = $this->generator(10);
        $invoice_id = strtoupper($invoice_id);
        $transection_id = $this->auth->generator(15);
        $job_id = $this->input->post('job_id');
        $customer_id = $this->input->post('customer_id');
        $invoice_date = date('Y-m-d');
        $product_id = $this->input->post('product_id');
        $spent_time = $this->input->post('spent_time');
        $quantity = $this->input->post('quantity');
        $rate = $this->input->post('rate');
        $amount = $this->input->post('amount');
        $sub_total = $this->input->post('sub_total');
        $discount = $this->input->post('discount');
        $gst_percent = $this->input->post('gst_percent');
        $total = $this->input->post('total');
        $labour_cost = $this->input->post('labour_cost');
        $paid_amount = 0; // $this->input->post('paid_amount');
//        dd($product_id);
//        =========== its from when job complete and invoice status select and submit ============
        $job_info = array(
            'status' => $this->session->userdata('status'),
            'show_hide_status' => $this->session->userdata('show_hide_status'),
            'schedule_date_time' => $this->session->userdata('schedule_date_time'),
            'delivery_date_time' => $this->session->userdata('delivery_date_time'),
            'alert_via' => $this->session->userdata('alert_via'),
        );
//        dd($job_info);
        $this->db->where('job_id', $job_id);
        $this->db->update('job', $job_info);
        $jobinfo_sess_destroy = array(
            'status' => '',
            'show_hide_status' => '',
            'schedule_date_time' => '',
            'delivery_date_time' => '',
            'alert_via' => ''
        );
        $this->session->unset_userdata($jobinfo_sess_destroy);
//        ================ close ===========
        if ($paid_amount >= 0) {
            // Insert to customer_ledger Table 
            $customer_ledger_debit = array(
                'transaction_id' => $transection_id,
                'customer_id' => $customer_id,
                'invoice_no' => $invoice_id,
                'date' => $invoice_date, //(!empty($this->input->post('invoice_date'))?$this->input->post('invoice_date'):date('Y-m-d')),
                'amount' => $total, //$this->input->post('n_total')-(!empty($this->input->post('previous'))?$this->input->post('previous'):0),
                'description' => 'Purchase by customer',
                'status' => 1,
                'd_c' => 'd'
            );
            $this->db->insert('customer_ledger', $customer_ledger_debit);

            //Insert to customer_ledger Table 
            $customer_ledger_credit = array(
                'transaction_id' => $transection_id,
                'customer_id' => $customer_id,
                'receipt_no' => $this->auth->generator(10),
                'date' => $invoice_date, //(!empty($this->input->post('invoice_date'))?$this->input->post('invoice_date'):date('Y-m-d')),
                'amount' => $paid_amount, //$this->input->post('paid_amount'),
                'payment_type' => 1,
                'invoice_no' => $invoice_id,
                'description' => 'Paid by customer',
                'status' => 1,
                'd_c' => 'c'
            );
            $this->db->insert('customer_ledger', $customer_ledger_credit);
            // Account table info
            $transection_data = array(
                'transaction_id' => $transection_id,
                'relation_id' => $customer_id,
                'transection_type' => 2,
                'date_of_transection' => $invoice_date, //(!empty($this->input->post('invoice_date'))?$this->input->post('invoice_date'):date('Y-m-d')),
                'transection_category' => 2,
                'amount' => $paid_amount, //$this->input->post('paid_amount'),
                'transection_mood' => 1,
                'is_transaction' => 0,
                'description' => 'Paid by customer'
            );
            $this->db->insert('transection', $transection_data);
        }

        $cusifo = $this->db->select('*')->from('customer_information')->where('customer_id', $customer_id)->get()->row();
        $headn = $customer_id . '-' . $cusifo->customer_name;
        $coainfo = $this->db->select('*')->from('acc_coa')->where('HeadName', $headn)->get()->row();
        $customer_headcode = $coainfo->HeadCode;
//        echo $customer_headcode; die();
// Cash in Hand debit
        $cc = array(
            'VNo' => $invoice_id,
            'Vtype' => 'INV',
            'VDate' => $createdate,
            'COAID' => 1020101,
            'Narration' => 'Cash in Hand For Invoice No' . $invoice_id,
            'Debit' => $paid_amount, //$this->input->post('paid_amount'),
            'Credit' => 0,
            'IsPosted' => 1,
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
            'IsAppove' => 1
        );


        ///Inventory credit
        $coscr = array(
            'VNo' => $invoice_id,
            'Vtype' => 'INV',
            'VDate' => $createdate,
            'COAID' => 10107,
            'Narration' => 'Inventory credit For Invoice No' . $invoice_id,
            'Debit' => 0,
            'Credit' => '', //$sumval, //purchase price asbe
            'IsPosted' => 1,
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
            'IsAppove' => 1
        );
        $this->db->insert('acc_transaction', $coscr);

        // Customer Transactions
        //Customer debit for Product Value
        $cosdr = array(
            'VNo' => $invoice_id,
            'Vtype' => 'INV',
            'VDate' => $createdate,
            'COAID' => $customer_headcode,
            'Narration' => 'Customer debit For Invoice No' . $invoice_id,
            'Debit' => $total, //$this->input->post('grand_total_price'),
            'Credit' => 0,
            'IsPosted' => 1,
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
            'IsAppove' => 1
        );
        $this->db->insert('acc_transaction', $cosdr);

        ///Customer credit for Paid Amount
        $cuscredit = array(
            'VNo' => $invoice_id,
            'Vtype' => 'INV',
            'VDate' => $createdate,
            'COAID' => $customer_headcode,
            'Narration' => 'Customer credit for Paid Amount For Invoice No' . $invoice_id,
            'Debit' => 0,
            'Credit' => $paid_amount, //$this->input->post('paid_amount'),
            'IsPosted' => 1,
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
            'IsAppove' => 1
        );
        if (!empty($paid_amount)) {
            $this->db->insert('acc_transaction', $cuscredit);
            $this->db->insert('acc_transaction', $cc);
        }

        //Data inserting into invoice table
        $invoice_data = array(
            'job_id' => $job_id,
            'invoice_id' => $invoice_id,
            'customer_id' => $customer_id,
            'date' => $invoice_date, //(!empty($this->input->post('invoice_date')) ? $this->input->post('invoice_date') : date('Y-m-d')),
            'total_amount' => $total,
            'labour_cost' => $labour_cost,
            'create_date' => date('Y-m-d'),
            'total_tax' => $gst_percent, //$this->input->post('total_tax'),
            'invoice' => $this->number_generator(),
            'invoice_details' => '', //(!empty($this->input->post('inva_details')) ? $this->input->post('inva_details') : 'Gui Pos'),
            'invoice_discount' => $discount,
            'total_discount' => '', //$this->input->post('total_discount'),
            'prevous_due' => '', //$this->input->post('previous'),
            'shipping_cost' => '', //$this->input->post('shipping_cost'),
            'sales_by' => $this->session->userdata('user_id'),
            'status' => 1,
        );
        //	print_r($datainv);exit;
        $this->db->insert('invoice', $invoice_data);
//        =========== its for invoice details =============
        for ($i = 0, $n = count($product_id); $i < $n; $i++) {
            $spenttime = $spent_time[$i];
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $products = $product_id[$i];
            $total_price = $amount[$i];
            $supplier_rate = ''; //$this->supplier_rate($product_id);
            $disper = ''; //$discount_per[$i];
            $discount = $discount; //is_numeric($product_quantity) * is_numeric($product_rate) * is_numeric($disper) / 100;
            $tax = ''; //$tax_amount[$i];
            $description = ''; //$invoice_description[$i];

            $invoice_details_data = array(
                'invoice_details_id' => $this->generator(15),
                'invoice_id' => $invoice_id,
                'product_id' => $products,
                'spent_time' => $spenttime,
                'quantity' => $product_quantity,
                'rate' => $product_rate,
                'discount' => $discount,
                'description' => $description,
                'discount_per' => $disper,
                'tax' => $tax,
                'paid_amount' => 0, //$this->input->post('paid_amount'),
                'due_amount' => 0, //$this->input->post('due_amount'),
                'supplier_rate' => '', //$supplier_rate[0]['supplier_price'],
                'total_price' => $total_price,
                'status' => 1
            );
            if (!empty($quantity)) {
                $this->db->insert('invoice_details', $invoice_details_data);
            }
        }
        $job_invoice_data = array(
            'is_invoice' => 1,
        );
        $this->db->where('job_id', $job_id)->update('job', $job_invoice_data);
        $this->session->set_userdata(array('message' => display('invoice_generated_successfully!')));
        $this->invoice_pdf_generate($job_id);
        redirect(base_url('Cjob/show_job_invoice/' . $job_id));
    }

//    public function invoice_view($job_id){
//         $data['get_tax'] = $this->db->select('*')->from('tax_information')->get()->result();
//        $data['get_invoice_info'] = $this->Jobs_model->get_invoice_info($job_id);
//        $data['get_invoicedetails'] = $this->Jobs_model->get_invoicedetails($job_id);
//        $data['get_job_products_used'] = $this->Jobs_model->get_job_products_used($job_id);
//        
//        $name = $data['get_invoice_info'][0]->customer_name;
//        $email = $data['get_invoice_info'][0]->customer_email;
//        
//        $content = $this->parser->parse('job/job_invoice_pdf', $data, true);
//        $this->template->full_admin_html_view($content);
//    }
//    ============ its for invoice pdf generate =======
    public function invoice_pdf_generate($job_id) {
        $data['currency_details'] = $this->Web_settings->retrieve_setting_editdata();
        $this->load->library('pdfgenerator');
        $id = $job_id;

        $data['get_tax'] = $this->db->select('*')->from('tax_information')->get()->result();
        $data['get_invoice_info'] = $this->Jobs_model->get_invoice_info($job_id);
        $data['get_invoicedetails'] = $this->Jobs_model->get_invoicedetails($job_id);
        $data['get_job_products_used'] = $this->Jobs_model->get_job_products_used($job_id);
        $data['get_jobinfo'] = $this->Jobs_model->get_workorder($job_id);
        $name = $data['get_invoice_info'][0]->customer_name;
        $email = $data['get_invoice_info'][0]->customer_email;
        $mobile = $data['get_invoice_info'][0]->customer_mobile;
        $alert_via = $data['get_jobinfo'][0]->alert_via;

        if ($alert_via == 'sms') {
            $gateway_id = 1;
            $sms_gateway_info = $this->Web_settings->sms_gateway($gateway_id);
            //dd($sms_gateway_info);
            $this->smsgateway->send([
                'apiProvider' => $sms_gateway_info[0]->provider_name,
                'username' => $sms_gateway_info[0]->user,
                'password' => $sms_gateway_info[0]->password,
                'from' => $sms_gateway_info[0]->authentication,
                'to' => $mobile,
                'message' => "Dear $name, Now your order is Completed!",
            ]);

            // save delivary data
            $custom_smsdata = array(
                'gateway' => $sms_gateway_info[0]->provider_name,
                'from' => $sms_gateway_info[0]->authentication,
                'to' => $mobile,
                'message' => "Dear $name, Now your order is Completed!",
                'created_date' => date("Y-m-d h:i:s"),
                'created_by' => $this->user_id,
            );
            $this->db->insert('custom_sms_tbl', $custom_smsdata);
        } elseif ($alert_via == 'email') {
            $html = $this->load->view('job/job_invoice_pdf', $data, true);
            $dompdf = new DOMPDF();
            $dompdf->load_html($html);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents('assets/data/pdf/invoice/' . $id . '.pdf', $output);
            $file_path = getcwd() . '/assets/data/pdf/invoice/' . $id . '.pdf';
            $send_email = '';
            if (!empty($email)) {
                $send_email = $this->setmail($email, $file_path, $id, $name);
            }
        }

        $this->session->set_userdata(array('message' => display('invoice_generated_successfully!')));
        redirect("Cjob/show_job_invoice/" . $id);
    }

    public function setmail($email, $file_path, $id = null, $name = null) {
//        echo $email. " ".$name;die();
        $setting_detail = $this->db->select('*')->from('email_config')->get()->row();
        $subject = 'Invoice Information';
        $message = strtoupper($name) . '-' . $id;
        $config = Array(
            'protocol' => $setting_detail->protocol,
            'smtp_host' => $setting_detail->smtp_host,
            'smtp_port' => $setting_detail->smtp_port,
            'smtp_user' => $setting_detail->smtp_user,
            'smtp_pass' => $setting_detail->smtp_pass,
            'mailtype' => $setting_detail->mailtype,
            'charset' => 'utf-8',
        );
//        echo '<pre>'; print_r($config);die();
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($setting_detail->smtp_user);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->attach($file_path);
        $check_email = $this->test_input($email);
        if (filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
            if ($this->email->send()) {
                $this->session->set_userdata(array('message' => display('invoice_generated_successfully')));
                redirect("Cjob/show_job_invoice/" . $id);
            } else {
                $this->session->set_flashdata(array('error_message' => display('please_configure_your_mail.')));
                return false;
            }
        } else {
            $this->session->set_userdata(array('message' => display('invoice_generated_successfully!')));
            redirect("Cjob/show_job_invoice/" . $id);
        }
    }

    //Email testing for email
    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function mail_send_check() {
        $id = 1010;
        $name = 'Md. Shahab uddin';
        $email = 'shahabuddinp91@gmail.com';
        $data = '';
        $setting_detail = $this->db->select('*')->from('email_config')->get()->row();
        $subject = 'Invoice Information';
        $message = $name . '-' . $id;
        $config = Array(
            'protocol' => $setting_detail->protocol,
            'smtp_host' => $setting_detail->smtp_host,
            'smtp_port' => $setting_detail->smtp_port,
            'smtp_user' => $setting_detail->smtp_user,
            'smtp_pass' => $setting_detail->smtp_pass,
            'mailtype' => $setting_detail->mailtype,
            'charset' => 'utf-8',
        );
//        echo "<pre>";        print_r($config);die();

        $mesg = $this->load->view('job/test_mail', $data, TRUE);

        $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
        $this->email->set_header('Content-type', 'text/html');

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($setting_detail->smtp_user, "Support Center");
        $this->email->to($email);
        $this->email->subject("Welcome to Garage");
// $this->email->message("Dear $name ,\nYour order submitted successfully!"."\n\n"
// . "\n\nThanks\nMetallica Gifts");
// $this->email->message($mesg. "\n\n http://metallicagifts.com/mcg/verify/" . $verificationText . "\n" . "\n\nThanks\nMetallica Gifts");
        $this->email->message($mesg);
        $this->email->send();
    }

//============= its for show_job_invoice =============
    public function show_job_invoice($job_id) {
        $data['title'] = display('job_to_invoice');
        $data['get_tax'] = $this->db->select('*')->from('tax_information')->get()->result();
        $data['get_invoice_info'] = $this->Jobs_model->get_invoice_info($job_id);
        $data['get_invoicedetails'] = $this->Jobs_model->get_invoicedetails($job_id);
        $data['get_job_products_used'] = $this->Jobs_model->get_job_products_used($job_id);
        $data['currency_details'] = $this->Web_settings->retrieve_setting_editdata();

//        dd($data['get_invoicedetails']);
        $this->session->set_userdata(array('message' => display('invoice_generated_successfully')));
        $content = $this->parser->parse('job/job_invoice_details', $data, true);
//        $content = $this->parser->parse('job/job_invoice_pdf', $data, true);
        $this->template->full_admin_html_view($content);
    }

    public function show_job_invoice_old($job_id) {
        $data['title'] = display('job_to_invoice');
        $data['get_tax'] = $this->db->select('*')->from('tax_information')->get()->result();
        $data['get_invoice_info'] = $this->Jobs_model->get_invoice_info($job_id);
        $data['get_invoicedetails'] = $this->Jobs_model->get_invoicedetails($job_id);
        $data['get_job_products_used'] = $this->Jobs_model->get_job_products_used($job_id);

//        $this->session->set_flashdata(array('message' => display('invoice_generated_successfully')));
        $content = $this->parser->parse('job/show_job_invoice', $data, true);
//        $content = $this->parser->parse('job/job_invoice_pdf', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============== its for job_confirmation_form ===========
    public function job_confirmation_form($job_id) {
//        echo $this->user_id; die();
        $data['title'] = display('job_confirmation');
        $data['customers'] = $this->Vehicles->customer_list();
        $data['get_jobtypelist'] = $this->Jobs_model->get_jobtypelist();
        $data['get_employeelist'] = $this->Jobs_model->get_employeelist();
        $data['get_productlist'] = $this->Jobs_model->get_productlist();
        $data['get_groupprice'] = $this->Products->get_groupprice();
        $data['get_workorder'] = $this->Jobs_model->get_workorder($job_id);
        $customer_id = $data['get_workorder'][0]->customer_id;
        $data['customer_wise_vehicle_info'] = $this->db->select('*')->from('vehicle_information')
                        ->where('customer_id', $customer_id)
                        ->get()->result();
        $data['customer_info'] = $this->db->select('a.customer_phone, a.customer_mobile')->from('customer_information a')
                        ->where('customer_id', $customer_id)->get()->result();
        $data['get_job_details'] = $this->Jobs_model->get_job_details($job_id, $this->user_id, $this->user_type);
        $data['job_usedproduct'] = $this->Jobs_model->job_usedproduct($job_id);


        $content = $this->parser->parse('job/job_form_confirmation', $data, true);
        $this->template->full_admin_html_view($content);
    }

//========== its for find_spent_time ==============
    public function find_spent_time() {
        $startdatetime = $this->input->post('startdatetime');
        $enddatetime = $this->input->post('enddatetime');

        $datetime1 = new DateTime($startdatetime);
        $datetime2 = new DateTime($enddatetime);
        $interval = $datetime1->diff($datetime2);
//        echo $interval->format('%Y-%m-%d %H:%i:%s');
        $hours = $interval->h;
        $hours = $hours + ($interval->days * 24);
        echo $hours;
    }

//    ============== its for show job information ===========
    public function show_job($job_id) {
//        echo $this->user_id; die();
        $data['title'] = display('show_job_information');
        $data['customers'] = $this->Vehicles->customer_list();
        $data['get_jobtypelist'] = $this->Jobs_model->get_jobtypelist();
        $data['get_employeelist'] = $this->Jobs_model->get_employeelist();
        $data['get_productlist'] = $this->Jobs_model->get_productlist();
        $data['get_workorder'] = $this->Jobs_model->get_workorder($job_id);
        $customer_id = $data['get_workorder'][0]->customer_id;
        $data['customer_wise_vehicle_info'] = $this->db->select('*')->from('vehicle_information')
                        ->where('customer_id', $customer_id)
                        ->get()->result();
        $data['customer_info'] = $this->db->select('a.customer_phone, a.customer_mobile, website, a.customer_address')->from('customer_information a')
                        ->where('customer_id', $customer_id)->get()->result();
        $data['get_job_details'] = $this->Jobs_model->get_job_details($job_id, $this->user_id, $this->user_type);
        $data['job_usedproduct'] = $this->Jobs_model->job_usedproduct($job_id);


        $content = $this->parser->parse('job/show_job', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    =========== its for change_jobperformed =============
    public function change_jobperformed() {
        $job_id = $this->input->post('job_id');
        $performed_status = $this->input->post('performed_status');
        $job_type = $this->input->post('job_type');
        $jobtype_rate = $this->input->post('jobtype_rate');
        $mechanics_id = $this->input->post('mechanics_id');
        $startdatetime = $this->input->post('startdatetime');
        $enddatetime = $this->input->post('enddatetime');
        $mechanics_note = $this->input->post('mechanics_note');
        $jobdetails_rowid = $this->input->post('jobdetails_rowid');
//        echo $job_id; die();
        if ($jobdetails_rowid == 'rowid_new') {
            $performed_data = array(
                'job_id' => $job_id,
                'job_type_id' => $job_type,
                'rate' => $jobtype_rate,
                'assign_to' => $mechanics_id,
                'start_datetime' => $startdatetime,
                'end_datetime' => $enddatetime,
                'mechanic_notes' => $mechanics_note,
                'status' => $performed_status,
            );
//        echo '<pre>'; print_r($performed_data);exit();
            $this->db->insert('job_details', $performed_data);
        } else {
            $performed_data = array(
                'job_type_id' => $job_type,
                'rate' => $jobtype_rate,
                'assign_to' => $mechanics_id,
                'start_datetime' => $startdatetime,
                'end_datetime' => $enddatetime,
                'mechanic_notes' => $mechanics_note,
                'status' => $performed_status,
            );
//        echo '<pre>'; print_r($performed_data);exit();
            $this->db->where('row_id', $jobdetails_rowid)->update('job_details', $performed_data);
        }

        $this->session->set_userdata(array('message' => display('update_successfully')));
        redirect(base_url('Cjob/manage_job/' . $job_id));
    }

//========== its for product used for job entry ========
    public function addProductused() {
        $job_id = $this->input->post('job_id');
        $product_id = $this->input->post('product_id');
        $available_qty = $this->input->post('available_qty');
        $used_qty = $this->input->post('used_qty');
        $price = $this->input->post('price');
        $mechanic_note = $this->input->post('mechanic_notes');
//        dd($product_id);
        $this->db->where('job_id', $job_id)->delete('job_products_used');
        if ($job_id) {
            for ($i = 0; $i < count($product_id); $i++) {
                $productused_data = array(
                    'job_id' => $job_id,
                    'product_id' => $product_id[$i],
                    'available_qty' => $available_qty[$i],
                    'rate' => $price[$i],
                    'used_qty' => $used_qty[$i],
                    'mechanic_note' => $mechanic_note[$i],
                );
                $this->db->insert('job_products_used', $productused_data);
            }
        }
        $this->session->set_userdata(array('message' => display('update_successfully')));
        redirect(base_url('Cjob/job_confirmation_form/' . $job_id));
    }

//    ============ its for recommendation add or update ==============
    public function addrecomendation() {
        $set_default_terms = $this->input->post('set_default_terms');
        $job_id = $this->input->post('job_id');

        $recommendation_data = array(
            'recommendation' => $set_default_terms,
        );
//        dd($recommendation_data);die();
        $this->db->where('job_id', $job_id)->update('job', $recommendation_data);

        $this->session->set_userdata(array('message' => display('update_successfully')));
        redirect(base_url('Cjob/manage_job/' . $job_id));
    }

//    ============= its for save jobdetails ===============
    public function save_jobdetails() {
//        echo $this->user_id."<br>";
//        echo $this->user_type;
//                die();
        $job_id = $this->input->post('job_id');
        $odometer = $this->input->post('odometer');
        $hubo_meter = $this->input->post('hubo_meter');
        $hour_meter = $this->input->post('hour_meter');
        $cof_wof_date = $this->input->post('cof_wof_date');
        $registration_date = $this->input->post('registration_date');
        $fuel_burn = $this->input->post('fuel_burn');

        $job_type = $this->input->post('job_type');
        $jobtype_rate = $this->input->post('jobtype_rate');
        $mechanics_id = $this->input->post('mechanics_id');
        $startdatetime = $this->input->post('startdatetime');
        $mechanics_note = $this->input->post('mechanics_note');
        $declined = $this->input->post('declined');
//        dd($startdatetime);
        $product_id = $this->input->post('product_id');
        $available_qty = $this->input->post('available_qty');
        $used_qty = $this->input->post('used_qty');
        $price = $this->input->post('price');
        $mechanic_notes = $this->input->post('mechanic_notes');
        $set_default_terms = $this->input->post('set_default_terms');

        $c_enddatetime = $this->input->post('c_enddatetime');
        $c_spenttime = $this->input->post('spent_time');
        $c_job_type = $this->input->post('c_job_type');
        $c_jobtype_rate = $this->input->post('c_jobtype_rate');
//        $c_enddatetime = $this->input->post('c_enddatetime');
        $performed_status = '';

        $check_jobdetails = $this->db->select('a.job_id')->from('job_details a')->where('a.job_id', $job_id)->get()->row();
        if ($check_jobdetails) {
            if ($this->user_type == 2) {
                $this->db->where('job_id', $job_id)->where('assign_to', $this->user_id)->delete('job_details');
            } else {
                $this->db->where('job_id', $job_id)->delete('job_details');
            }
        }
        if ($job_id) {
            for ($i = 0; $i < count($job_type); $i++) {
                if ($startdatetime[$i] == '' || $startdatetime[$i] == ' ') {
                    $performed_status = 0;
                } elseif ($startdatetime[$i] != ' ' && empty($c_enddatetime[$i])) {
                    $performed_status = 1;
                } elseif ($startdatetime[$i] != ' ' && $c_enddatetime[$i] == ' ') {
                    $performed_status = 1;
                } elseif ($startdatetime[$i] != ' ' && $c_enddatetime[$i] != ' ') {
                    $performed_status = 3;
                }
//                dd($performed_status);

                $number = $i + 1;
//                 $test = "checked_hdn_".$number;
                $checked_hdn = $this->input->post("checked_hdn_" . $number);
                if ($checked_hdn == 2) {
                    $performed_status = 2;
                }
//                print_r($declined);
//                echo $declined[$i]; echo "<br>";
//                if (!empty($declined[$i])) {
//                    $performed_status = $declined[$i];
//                }
                $job_details = array(
                    'job_id' => $job_id,
                    'job_type_id' => $job_type[$i],
                    'rate' => $jobtype_rate[$i],
                    'assign_to' => $mechanics_id[$i],
                    'start_datetime' => $startdatetime[$i],
                    'end_datetime' => $c_enddatetime[$i],
                    'spent_time' => $c_spenttime[$i],
                    'mechanic_notes' => $mechanics_note[$i],
                    'status' => $performed_status,
                );
//                echo '<pre>';                print_r($job_details);
                $this->db->insert('job_details', $job_details);
            }
        }
//            dd($job_details);
//        ============ its for job product used =============         
        $check_jobdetails = $this->db->select('a.job_id')->from('job_products_used a')->where('a.job_id', $job_id)->get()->row();
        if ($check_jobdetails) {
            $this->db->where('job_id', $job_id)->delete('job_products_used');
        }
        if ($job_id) {
            for ($i = 0; $i < count($product_id); $i++) {
                $productused_data = array(
                    'job_id' => $job_id,
                    'product_id' => $product_id[$i],
                    'available_qty' => $available_qty[$i],
                    'rate' => $price[$i],
                    'used_qty' => $used_qty[$i],
                    'mechanic_note' => $mechanic_notes[$i],
                );
                $this->db->insert('job_products_used', $productused_data);
            }
        }
//        ========= its for job table record update ==========
        $job_data = array(
            'recommendation' => $set_default_terms,
            'odometer' => $odometer,
            'hubo_meter' => $hubo_meter,
            'hour_meter' => $hour_meter,
            'cof_wof_date' => $cof_wof_date,
            'registration_date' => $registration_date,
            'fuel_burn' => $fuel_burn,
        );
        $this->db->where('job_id', $job_id)->update('job', $job_data);
//        =============its for job completed status submit ============
        for ($i = 0; $i < count($c_job_type); $i++) {
            $job_completed_data = array(
                'end_datetime' => $c_enddatetime[$i],
                'spent_time' => $c_spenttime[$i],
            );
            $this->db->where('job_type_id', $c_job_type[$i]);
            $this->db->where('job_id', $job_id);
            $this->db->Update('job_details', $job_completed_data);
        }

        $this->session->set_userdata(array('message' => display('update_successfully')));
        redirect(base_url('Cjob/job_confirmation_form/' . $job_id));
    }

//============= its for job delete =============
    public function job_delete($job_id) {
        if ($job_id) {
            $this->db->where('job_id', $job_id)->delete('job');
            $this->db->where('job_id', $job_id)->delete('job_details');
            $this->db->where('job_id', $job_id)->delete('job_products_used');
        }

        $this->session->set_userdata(array('message' => display('delete_successfully')));
        redirect(base_url('Cjob/manage_job/' . $job_id));
    }

//======= its for order_status_check ============
    public function order_status_check() {
        $job_id = $this->input->post('job_id');
        $status = $this->input->post('status');
        $checking_data = $this->db->select('*')->from('job_details')->where('job_id', $job_id)->where('status', 0)->get()->result();
        if ($checking_data && $status == 3) {
            echo 1;
        } else {
            echo 0;
        }
    }

//    ========== its for get_customer_info ===========
    public function get_customer_info() {
        $customer_id = $this->input->post('customer_id');
        $get_customer_info = $this->db->select('*')->from('customer_information')->where('customer_id', $customer_id)->get()->row();
        echo json_encode($get_customer_info);
    }

//    ========== its for customer_wise_vehicle_info ===========
    public function customer_wise_vehicle_info() {
        $customer_id = $this->input->post('customer_id');
        $customer_wise_vehicle_info = $this->db->select('*')->from('vehicle_information')->where('customer_id', $customer_id)->get()->result();
        echo json_encode($customer_wise_vehicle_info);
    }

    //job type Form
    public function add_job_type() {
        $data['title'] = display('job_type_add');
        $data['job_category'] = $this->db->select('*')->from('job_category')->order_by('job_category_name')->get()->result();
        $content = $this->parser->parse('job/type_form', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============== its for insert_job_type ==========
    public function insert_job_type() {
        $job_category_id = $this->input->post('job_category_id');
        $job_type_name = $this->input->post('job_type_name');
        $job_type_rate = $this->input->post('job_type_rate');
        $standard_timing = $this->input->post('standard_timing');
        $check_jobtype = $this->db->select('*')
                        ->where('job_category_id', $job_category_id)
                        ->where('job_type_name', $job_type_name)
                        ->get('job_type')->row();
        if ($check_jobtype) {
            $this->session->set_userdata(array('error_message' => display('already_exists')));
            redirect(base_url('Cjob/add_job_type'));
        } else {
            $job_type_data = array(
                'job_category_id' => $job_category_id,
                'job_type_name' => $job_type_name,
                'job_type_rate' => $job_type_rate,
                'standard_timing' => $standard_timing,
                'create_by' => $this->user_id,
                'create_date' => date('Y-m-d'),
                'status' => 1,
            );
//        dd($job_type_data);
            $this->db->insert('job_type', $job_type_data);
        }
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cjob/add_job_type'));
    }

    //manage job type 
    public function manage_job_type() {
        $data['title'] = display('manage_types');
        $config["base_url"] = base_url('Cjob/manage_job_type/');
        $config["total_rows"] = $this->db->count_all('job_type');
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        $config["last_link"] = "Last";
        $config["first_link"] = "First";
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['full_tag_open'] = '<div class = "pagging text-center"><nav><ul class = "pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class = "page-item active"><span class = "page-link">';
        $config['cur_tag_close'] = '<span class = "sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['next_tagl_close'] = '<span aria-hidden = "true">&raquo;
        </span></span></li>';
        $config['prev_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['prev_tagl_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['last_tagl_close'] = '</span></li>';
        #Paggination end#


        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $limit = $config["per_page"];
        $data['job_typelist'] = $this->Jobs_model->job_typelist($limit, $page);
        $data['links'] = $this->pagination->create_links();
        $data['pagenum'] = $page;

        $content = $this->parser->parse('job/type_list', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ================ its for job_type_edit ----------------
    public function job_type_edit($job_type_id) {
        $data['title'] = display('job_type_edit');
        $data['job_category'] = $this->db->select('*')->from('job_category')->order_by('job_category_name')->get()->result();
        $data['edit_job_type'] = $this->db->select('*')->from('job_type')->where('job_type_id', $job_type_id)->get()->result();
//        echo '<pre>';        print_r($data['edit_job_type']);

        $content = $this->parser->parse('job/jobtype_edit_form', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============= its for update_job_type =============
    public function update_job_type() {
        $job_type_id = $this->input->post('job_type_id');
        $job_category_id = $this->input->post('job_category_id');
        $job_type_name = $this->input->post('job_type_name');
        $job_type_rate = $this->input->post('job_type_rate');
        $standard_timing = $this->input->post('standard_timing');

        $job_type_data = array(
            'job_category_id' => $job_category_id,
            'job_type_name' => $job_type_name,
            'job_type_rate' => $job_type_rate,
            'standard_timing' => $standard_timing,
            'update_by' => $this->user_id,
            'update_date' => date('Y-m-d'),
            'status' => 1,
        );
//        dd($job_type_data);
        $this->db->where('job_type_id', $job_type_id)->update('job_type', $job_type_data);
        $this->session->set_userdata(array('message' => display('update_successfully')));
        redirect(base_url('Cjob/manage_job_type'));
    }

//    ============= its for job_type_delete ============
    public function job_type_delete($job_type_id) {
        $inspection_data = $this->db->select('fk_inspection_id')->where('job_type_id', $job_type_id)->get('job_type')->row();
        $inspection_id = $inspection_data->fk_inspection_id;
        $this->db->where('job_type_id', $job_type_id)->delete('job_type');
        if ($inspection_id) {
            $this->db->where('inspection_id', $inspection_id)->delete('inspection');
            $this->db->where('inspection_id', $inspection_id)->delete('inspection_list');
        }
        $this->session->set_userdata(array('message' => display('delete_successfully')));
        redirect(base_url('Cjob/manage_job_type'));
    }

//    =============== its for add_job_category form============
    public function add_job_category() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $data['title'] = display('add_job_category');
//        $data['get_service_types'] = $this->db->select('*')->from('service_type')->where('status', 1)->get()->result();

        $config["base_url"] = base_url('Cjob/add_job_category/');
        $config["total_rows"] = $this->db->count_all('job_category');
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        $config["last_link"] = "Last";
        $config["first_link"] = "First";
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['full_tag_open'] = '<div class = "pagging text-center"><nav><ul class = "pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class = "page-item active"><span class = "page-link">';
        $config['cur_tag_close'] = '<span class = "sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['next_tagl_close'] = '<span aria-hidden = "true">&raquo;
        </span></span></li>';
        $config['prev_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['prev_tagl_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['last_tagl_close'] = '</span></li>';
        #Paggination end#


        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $limit = $config["per_page"];
        $data['job_categorylist'] = $this->Jobs_model->job_categorylist($limit, $page);
        $data['links'] = $this->pagination->create_links();
        $data['pagenum'] = $page;

        $content = $this->parser->parse('job/job_category', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ================= its for job_category_save ================
    public function job_category_save() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $job_category = $this->input->post('job_category');
        $check_jobcategory = $this->db->select('*')->where('job_category_name', $job_category)->get('job_category')->row();
        if ($check_jobcategory) {
            $this->session->set_userdata(array('error_message' => display('already_exists')));
            redirect(base_url('Cjob/add_job_category'));
        } else {
            $job_category_data = array(
//            'service_type_id' => $service_type,
                'job_category_name' => $job_category,
                'create_by' => $this->user_id,
                'create_date' => date('Y-m-d'),
                'status' => 1,
            );
            $this->db->insert('job_category', $job_category_data);
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('Cjob/add_job_category'));
        }
    }

//    ============= its for job_category_edit =============
    public function job_category_edit() {
//        $data['get_service_types'] = $this->db->select('*')->from('service_type')->where('status', 1)->get()->result();
        $job_category_id = $this->input->post('job_category_id');
        $data['job_category_edit'] = $this->db->select('*')->from('job_category a')->where('a.job_category_id', $job_category_id)
                        ->get()->row();

        $this->load->view('job/job_category_edit', $data);
    }

//    ============= its for job category update ============
    public function job_category_update() {
        $job_category_id = $this->input->post('job_category_id');
        $job_category = $this->input->post('job_category');

        $job_category_data = array(
            'job_category_name' => $job_category,
            'update_by' => $this->user_id,
            'update_date' => date('Y-m-d'),
            'status' => 1,
        );
        $this->db->where('job_category_id', $job_category_id);
        $this->db->update('job_category', $job_category_data);
        $this->session->set_userdata(array('message' => display('update_successfully')));
        redirect(base_url('Cjob/add_job_category'));
    }

//    ========= its for job category delete =================
    public function jobcategory_delete($id) {
        $check_jobtype = $this->db->select('*')->from('job_type')->where('job_category_id', $id)->get()->row();

        if ($check_jobtype) {
            $this->session->set_userdata(array('error_message' => 'Its dependent on job type'));
        } else {
            $this->db->where('job_category_id', $id)->delete('job_category');
            $this->session->set_userdata(array('message' => display('delete_successfully')));
        }
        redirect(base_url('Cjob/add_job_category'));
    }

    // product info
    public function get_product_info() {
        $product_id = $this->input->post('product_id');
        $get_product_info = $this->db->select('a.*, SUM(b.quantity) as totalstock, b.quantity')
                ->from('product_information a')
                ->join('product_purchase_details b', 'a.product_id = b.product_id', 'left')
                ->where('a.product_id', $product_id)
                ->get()
                ->row();
//        d($get_product_info);
        echo json_encode($get_product_info);
    }

//    ========= its for available quantity check ===========
    public function available_quantity_check() {
        $product_id = $this->input->post('product_id');
        $this->db->select('SUM(a.quantity) as total_purchase');
        $this->db->from('product_purchase_details a');
        $this->db->where('a.product_id', $product_id);
        $total_purchase = $this->db->get()->row();

        $this->db->select('SUM(b.quantity) as total_sale');
        $this->db->from('invoice_details b');
        $this->db->where('b.product_id', $product_id);
        $total_sale = $this->db->get()->row();
//
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->where(array('product_id' => $product_id, 'status' => 1));
        $product_information = $this->db->get()->row();
//
//        $available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale) / $product_information->cartoon_quantity;
        $available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);
//
        $result = array(
            'available_qty' => $available_quantity,
//            'supplier_price' => $product_information->supplier_price,
            'price' => $product_information->price,
//            'supplier_id' => $product_information->supplier_id,
//            'tax' => $product_information->tax,
//            'cartoon_quantity' => $product_information->cartoon_quantity,
        );

        echo json_encode($result);
    }

//    ===== its for job confirmation edit mode available quantity check ==============
    public function jobconfirm_editmode_quantitycheck($product_id) {
        $groupproduct_check = $this->db->select('*')->from('group_pricing_tbl a')->where('a.group_price_id', $product_id)->get()->row();
//        dd($groupproduct_check);
        if (empty($groupproduct_check)) {
            $this->db->select('SUM(a.quantity) as total_purchase');
            $this->db->from('product_purchase_details a');
            $this->db->where('a.product_id', $product_id);
            $total_purchase = $this->db->get()->row();

            $this->db->select('SUM(b.quantity) as total_sale');
            $this->db->from('invoice_details b');
            $this->db->where('b.product_id', $product_id);
            $total_sale = $this->db->get()->row();
//
            $this->db->select('*');
            $this->db->from('product_information');
            $this->db->where(array('product_id' => $product_id, 'status' => 1));
            $product_information = $this->db->get()->row();

            $available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);
            echo $available_quantity;
        } else {
            $this->db->select('*');
            $this->db->from('product_information');
            $this->db->where(array('product_id' => $product_id, 'status' => 1));
            $product_information = $this->db->get()->row();
            echo $available_quantity = 'N/A';
        }
    }

//    ========= its for available quantity check  only job performed===========
    public function available_quantity_check_job() {
        $product_id = $this->input->post('product_id');

        $groupproduct_check = $this->db->select('*')->from('group_pricing_tbl a')->where('a.group_price_id', $product_id)->get()->row();
//        dd($groupproduct_check);
        if (empty($groupproduct_check)) {
            $this->db->select('SUM(a.quantity) as total_purchase');
            $this->db->from('product_purchase_details a');
            $this->db->where('a.product_id', $product_id);
            $total_purchase = $this->db->get()->row();

            $this->db->select('SUM(b.quantity) as total_sale');
            $this->db->from('invoice_details b');
            $this->db->where('b.product_id', $product_id);
            $total_sale = $this->db->get()->row();
//
            $this->db->select('*');
            $this->db->from('product_information');
            $this->db->where(array('product_id' => $product_id, 'status' => 1));
            $product_information = $this->db->get()->row();
//
//        $available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale) / $product_information->cartoon_quantity;
            $available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);
//
            $result = array(
                'available_qty' => $available_quantity,
//            'supplier_price' => $product_information->supplier_price,
                'price' => $product_information->price,
            );
            echo json_encode($result);
        } else {
            $this->db->select('*');
            $this->db->from('product_information');
            $this->db->where(array('product_id' => $product_id, 'status' => 1));
            $product_information = $this->db->get()->row();

//            $allpdts = '';
//            $get_groupwise_allproducts = $this->db->select('*')->from('group_pricing_details')
//                            ->where('group_price_id', $product_id)->get()->result();
//            foreach ($get_groupwise_allproducts as $allproducts) {
//                $allpdts .= $allproducts->product_id . ',';
//            }
//            $allpdt = rtrim($allpdts, ',');
            $result = array(
                'price' => $groupproduct_check->groupprice,
                'na' => 'N/A',
            );
            echo json_encode($result);
//            d($allpdt);
        }
    }

//    ============ its for quantity_checked ============
    public function quantity_checked() {
        $cancel = '';
        $ok = '';
        $product_id = $this->input->post('product_id');
        //echo $product_id;
        $available_qty = $this->input->post('available_qty');
        $used_qty = $this->input->post('used_qty');
        $allpdts = '';
        $get_groupwise_allproducts = $this->db->select('*')->from('group_pricing_details')
                        ->where('group_price_id', $product_id)->get()->result();
        if ($get_groupwise_allproducts) {
            foreach ($get_groupwise_allproducts as $allproducts) {
                $allpdts .= $allproducts->product_id . ',';

                $this->db->select('SUM(a.quantity) as total_purchase');
                $this->db->from('product_purchase_details a');
                $this->db->where('a.product_id', $allproducts->product_id);
                $total_purchase = $this->db->get()->row();
//            echo $total_purchase->total_purchase."<br>";

                $this->db->select('SUM(b.quantity) as total_sale');
                $this->db->from('invoice_details b');
                $this->db->where('b.product_id', $allproducts->product_id);
                $total_sale = $this->db->get()->row();
//            echo $this->db->last_query();
//            echo "DD".$total_sale->total_sale; echo "<br>";
                $available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);
//             echo $available_quantity."<br>";
                if ($available_quantity >= $used_qty) {
                    $ok .= 0;
                } else {
                    $cancel .= 1;
                }
            }
            $allpdt = rtrim($allpdts, ',');
            //d($allpdt);
            echo $cancel;
        } else {
            if ($used_qty > $available_qty) {
                echo 2;
            }
        }
    }

    /*
      |__________________________________________________
      |Work order update
      |____________________________________________________
     */

    public function workorder_update() {
        $order_id = $this->input->post('job_id');
        $order_status = $this->input->post('order_status');
        $show_hide_status = $this->input->post('show_hide_status');

        if (empty($show_hide_status)) {
            $show_hide_status = 0;
        } else {
            $show_hide_status = 1;
        }
        $data = array(
            'status' => $order_status,
            'show_hide_status' => $show_hide_status,
            'schedule_date_time' => $this->input->post('schedule_datetime'),
            'delivery_date_time' => $this->input->post('delivery_datetime'),
            'alert_via' => $this->input->post('alert_via'),
        );
        if ($order_status == 3) {
            $this->session->set_userdata($data);
//            $this->job_complete_invoice($order_id);
            redirect('Cjob/job_complete_invoice/' . $order_id);
        } else {
            $this->db->where('job_id', $order_id);
            $this->db->update('job', $data);
            $this->send_jobdorder_status($order_id, $order_status);
        }
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect($_SERVER['HTTP_REFERER']);
    }

//    =========== its for send order accept or declined message =============
    public function send_jobdorder_status($order_id, $order_status) {
        $get_orderinfo = $this->db->select('*')->from('job')->where('job_id', $order_id)->get()->row();
        $customer_id = $get_orderinfo->customer_id;
        $get_customerinfo = $this->db->select('*')->from('customer_information')->where('customer_id', $customer_id)->get()->row();
        //dd($get_customerinfo);
        if ($order_status == 1) {
            $status = 'Accepted';
        } elseif ($order_status == 2) {
            $status = 'Declined';
        }
        $id = $order_id;
        $name = $get_customerinfo->customer_name;
        $email = $get_customerinfo->customer_email;
        $data = '';

        if ($get_orderinfo->alert_via == 'sms') {
            $gateway_id = 1;
            $sms_gateway_info = $this->Web_settings->sms_gateway($gateway_id);
            //dd($sms_gateway_info);
            $this->smsgateway->send([
                'apiProvider' => $sms_gateway_info[0]->provider_name,
                'username' => $sms_gateway_info[0]->user,
                'password' => $sms_gateway_info[0]->password,
                'from' => $sms_gateway_info[0]->authentication,
                'to' => $get_customerinfo->customer_mobile,
                'message' => "Dear $name, Now your order is $status!",
            ]);

            // save delivary data
            $custom_smsdata = array(
                'gateway' => $sms_gateway_info[0]->provider_name,
                'from' => $sms_gateway_info[0]->authentication,
                'to' => $get_customerinfo->customer_mobile,
                'message' => "Dear $name, Now your order is $status!",
                'created_date' => date("Y-m-d h:i:s"),
                'created_by' => $this->user_id,
            );
            $this->db->insert('custom_sms_tbl', $custom_smsdata);
        } elseif ($get_orderinfo->alert_via == 'email') {
            $setting_detail = $this->db->select('*')->from('email_config')->get()->row();
            //dd($setting_detail);
            $subject = 'Job Order Status Information';
            $message = $name . '-' . $id;
            $config = Array(
                'protocol' => $setting_detail->protocol,
                'smtp_host' => $setting_detail->smtp_host,
                'smtp_port' => $setting_detail->smtp_port,
                'smtp_user' => $setting_detail->smtp_user,
                'smtp_pass' => $setting_detail->smtp_pass,
                'mailtype' => $setting_detail->mailtype,
                'charset' => 'utf-8',
            );
            // echo "<pre>";        print_r($status);die();
//        $mesg = $this->load->view('job/test_mail', $data, TRUE);
            $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
            $this->email->set_header('Content-type', 'text/html');

            $this->load->library('email', $config);
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from($setting_detail->smtp_user, "Support Center");
            $this->email->to($email);
            $this->email->subject("Welcome to Garage Management");
            $this->email->message("Dear <strong>$name</strong> ,\n Now, your order is <strong>$status</strong>!" . "\n\n"
                    . "\n\nThanks\nGarage management");
// $this->email->message($mesg. "\n\n http://metallicagifts.com/mcg/verify/" . $verificationText . "\n" . "\n\nThanks\nGarage management");
//        $this->email->message($mesg);
            $this->email->send();
        }
    }

    //============= its for job_complete_invoice =============
    public function job_complete_invoice($job_id) {
        $data['title'] = display('job_to_invoice');
        $data['get_tax'] = $this->db->select('*')->from('tax_information')->get()->result();
        $data['get_job_info'] = $this->Jobs_model->get_job_info($job_id);
        $quot_id = $data['get_job_info'][0]->quotation_id;
//      echo $data['get_job_info'][0]->is_quotation;die();
        $data['quot_labour'] = $this->Quotation_model->quot_labour_detail($quot_id);
        $data['get_jobdetails_info'] = $this->Jobs_model->get_jobdetails_info($job_id);
        $data['get_job_products_used'] = $this->Jobs_model->get_job_products_used($job_id);

        $content = $this->parser->parse('job/job_generate_invoice', $data, true);
        $this->template->full_admin_html_view($content);
    }

    //Job follow up
    public function follow_up() {
        $data['title'] = display('follow_up');
        $data['customers'] = $this->Vehicles->customer_list();
        $data['get_jobtypelist'] = $this->Jobs_model->get_acceptjobtypelist();
        $data['followuplist'] = $this->Jobs_model->followup_list();
        $content = $this->parser->parse('job/follow_up', $data, true);
        $this->template->full_admin_html_view($content);
    }

    /// Follow Up Entry
    public function insert_followup($value = '') {
        $follow_up = array(
            'order_id' => $this->input->post('job_order'),
            'to_whom' => $this->input->post('to_whom'),
            'date' => $this->input->post('fdate'),
            'note' => $this->input->post('note'),
            'v_reg' => $this->input->post('v_regno'),
        );
        $this->db->insert('follow_ups', $follow_up);
        $this->session->set_userdata(array('message' => display('successfully_added')));

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function joborder_info() {
        $order_id = $this->input->post('job_order');
        $details = $this->db->select('a.*, b.vehicle_registration, c.customer_name')
                ->from('job a')
                ->join('vehicle_information b', 'a.vehicle_id = b.vehicle_id')
                ->join('customer_information c', 'a.customer_id = c.customer_id')
                ->where('a.work_order_no', $order_id)
                ->get()
                ->row();
        $data = array(
            'customer_name' => $details->customer_name,
            'vehicle_regno' => $details->vehicle_registration,
        );
        echo json_encode($data);
    }

//    ===== its for get_odometer ==============
    public function get_odometer() {
        $job_id = $this->input->post('job_id');
        $vehicle_id = $this->input->post('vehicle_id');
//        $total_rows = $this->db->select('count(job_id) as total_row')->from('job')->where('vehicle_id', $vehicle_id)->get()->row();
        $get_jobinfo = $this->db->select('*')->from('job')->where('vehicle_id', $vehicle_id)->order_by('job_id', 'desc')->limit(1, 1)->get()->result();
        echo $get_jobinfo[0]->odometer;
//        $total_row = $total_rows->total_row;
//        $previous_index = $total_row-2;
//        $previous_row_job_id = $get_jobinfo[$previous_index]->job_id;
//        echo $previous_row_odometer = $get_jobinfo[$previous_index]->odometer;
    }

//    ============== its for get_hubometer =============
    public function get_hubometer() {
        $job_id = $this->input->post('job_id');
        $vehicle_id = $this->input->post('vehicle_id');
        $get_jobinfo = $this->db->select('*')->from('job')->where('vehicle_id', $vehicle_id)->order_by('job_id', 'desc')->limit(1, 1)->get()->result();
        echo $get_jobinfo[0]->hubo_meter;
    }

//    ============== its for get_hourmeter =============
    public function get_hourmeter() {
        $job_id = $this->input->post('job_id');
        $vehicle_id = $this->input->post('vehicle_id');
        $get_jobinfo = $this->db->select('*')->from('job')->where('vehicle_id', $vehicle_id)->order_by('job_id', 'desc')->limit(1, 1)->get()->result();
        echo $get_jobinfo[0]->hour_meter;
    }

//    ============== its for get_fuelburn =============
    public function get_fuelburn() {
        $job_id = $this->input->post('job_id');
        $vehicle_id = $this->input->post('vehicle_id');
        $get_jobinfo = $this->db->select('*')->from('job')->where('vehicle_id', $vehicle_id)->order_by('job_id', 'desc')->limit(1, 1)->get()->result();
        echo $get_jobinfo[0]->fuel_burn;
    }

//    ============= its for get_registrationdate ==========
    public function get_registrationdate() {
        $job_id = $this->input->post('job_id');
        $vehicle_id = $this->input->post('vehicle_id');
        $regi_date = $this->input->post('regi_date');
        $get_jobinfo = $this->db->select('*')->from('job')->where('vehicle_id', $vehicle_id)->order_by('job_id', 'desc')->limit(1, 1)->get()->result();
//        echo $get_jobinfo[0]->registration_date;
        if (strtotime($regi_date) < strtotime($get_jobinfo[0]->registration_date)) {
            echo 0;
        } else {
            echo 1;
        }
    }

//    ============= its for get_cofwofdate ==========
    public function get_cofwofdate() {
        $job_id = $this->input->post('job_id');
        $vehicle_id = $this->input->post('vehicle_id');
        $cofwof_date = $this->input->post('cofwof_date');
        $get_jobinfo = $this->db->select('*')->from('job')->where('vehicle_id', $vehicle_id)->order_by('job_id', 'desc')->limit(1, 1)->get()->result();
//        echo $get_jobinfo[0]->cof_wof_date;
        if (strtotime($cofwof_date) < strtotime($get_jobinfo[0]->cof_wof_date)) {
            echo 0;
        } else {
            echo 1;
        }
    }

//=============== its for is_recurring invoice =================
    public function recurring_invoice_save() {
        $job_id = $this->input->post('job_id');
        $invoice_id = $this->input->post('invoice_id');
        $recurring_time = $this->input->post('recurring_time');
        $recurring_period = $this->input->post('recurring_period');
        $recurring_data = array(
            'is_recurring' => 1,
            'recurring_time' => $recurring_time . " " . $recurring_period,
        );
//        dd($recurring_data);
        $this->db->where('invoice_id', $invoice_id)->update('invoice', $recurring_data);
        $this->session->set_userdata(array('message' => display('update_successfully')));
        redirect($_SERVER['HTTP_REFERER']);
    }

//    ========= its for text auto load huge data when scroll ==========
    public function get_data() {
        $data['title'] = 'Auto Load';
        $content = $this->parser->parse('job/test_form', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ========== its for _get_all_record ==============
    public function get_all_record() {
        $limit = $this->input->post('limit');
        $start = $this->input->post('start');
        $data['all_record'] = $this->db->select('*')->from('language')->order_by('id', 'desc')->limit($limit, $start)->get()->result();
        $data['start'] = $start;
        $this->load->view('job/test_form_list', $data);
    }

}
