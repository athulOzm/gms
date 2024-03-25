<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cquotation extends CI_Controller {

    public $menu;
    private $user_id;
    private $user_type;

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('session');
        $this->load->model('Vehicles');
        $this->load->model('Quotation_model');
        $this->load->model('Jobs_model');
        $this->load->model('Web_settings');
        $this->load->model('Products');
        $this->auth->check_admin_auth();
        $this->user_id = $this->session->userdata('user_id');
        $this->user_type = $this->session->userdata('user_type');
    }

    // Job Form
    public function index() {
        $data['title'] = display('add_quotation');
        if ($this->user_type == 3) {
            $data['customers'] = $this->Vehicles->owner_customer_info($this->user_id);
        } else {
            $data['customers'] = $this->Vehicles->customer_list();
        }
        $data['get_groupprice'] = $this->Products->get_groupprice();
        $data['vehicles'] = $this->Quotation_model->customer_wise_vehicle_info();
        $data['get_jobtypelist'] = $this->Jobs_model->get_jobtypelist();
        $data['get_employeelist'] = $this->Jobs_model->get_employeelist();
        $data['get_productlist'] = $this->Jobs_model->get_productlist();
        $data['quotation_no'] = $this->quot_number_generator();
        $content = $this->parser->parse('quotation/quotation_form', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ========== its for  insert_quotation =============
    public function insert_quotation() {
        $quot_id = $this->auth->generator(15);

        if (isset($_POST['add-quotation'])) {
            $customershow = 0;
            $status = 1;
            $data = array(
                'quotation_id' => $quot_id,
                'customer_id' => $this->input->post('customer_id'),
                'vehicle_reg' => $this->input->post('registration_no'),
                'quotdate' => $this->input->post('qdate'),
                'totalamount' => $this->input->post('grandtotal'),
                'quot_no' => $this->input->post('quotation_no'),
                'create_by' => $this->session->userdata('user_id'),
                'quot_description' => $this->input->post('details'),
                'status' => $status,
                'terms' => $this->input->post('terms'),
                'cust_show' => $customershow,
                'dis_per' => $this->input->post('dis_per'),
                'total_discount' => $this->input->post('total_dis'),
            );

            $result = $this->Quotation_model->quotation_entry($data);

            if ($result == TRUE) {
                $job_id = $this->input->post('job_type_id');
                $lnotes = $this->input->post('lnotes');
                $lrate = $this->input->post('lrate');
                for ($i = 0, $n = count($job_id); $i < $n; $i++) {
                    $service = $job_id[$i];
                    $labrate = $lrate[$i];
                    $labnotes = $lnotes[$i];
                    $quotlabour = array(
                        'quot_id' => $quot_id,
                        'job_type_id' => $service,
                        'rate' => $labrate,
                        'note' => $labnotes,
                    );
                    $this->db->insert('quot_labour_used', $quotlabour);
                }

                $item = $this->input->post('product_id');
                $availableqty = $this->input->post('available_qty');
                $item_rate = $this->input->post('price');
                $item_qty = $this->input->post('qty');
                for ($j = 0, $n = count($item); $j < $n; $j++) {
                    $product_id = $item[$j];
                    $available_qty = $availableqty[$j];
                    $rate = $item_rate[$j];
                    $qty = $item_qty[$j];
                    $quotitem = array(
                        'quot_id' => $quot_id,
                        'product_id' => $product_id,
                        'available_qty' => $available_qty,
                        'rate' => $rate,
                        'used_qty' => $qty,
                    );
                    $this->db->insert('quot_products_used', $quotitem);
                }
                $this->session->set_userdata(array('message' => display('successfully_added')));
                redirect(base_url('Cquotation/manage_quotation'));
            } else {
                $this->session->set_userdata(array('error_message' => display('already_inserted')));
                redirect(base_url('Cquotation'));
            }
        } elseif (isset($_POST['customer_sent'])) {
            $customershow = 1;
            $status = 2;
            $data = array(
                'quotation_id' => $quot_id,
                'customer_id' => $this->input->post('customer_id'),
                'vehicle_reg' => $this->input->post('registration_no'),
                'quotdate' => $this->input->post('qdate'),
                'totalamount' => $this->input->post('grandtotal'),
                'quot_no' => $this->input->post('quotation_no'),
                'create_by' => $this->session->userdata('user_id'),
                'quot_description' => $this->input->post('details'),
                'status' => $status,
                'terms' => $this->input->post('terms'),
                'cust_show' => $customershow,
                'dis_per' => $this->input->post('dis_per'),
                'total_discount' => $this->input->post('total_dis'),
            );
            //dd($data);
            $result = $this->Quotation_model->quotation_entry($data);

            if ($result == TRUE) {
                $job_id = $this->input->post('job_type_id');
                $lnotes = $this->input->post('lnotes');
                $lrate = $this->input->post('lrate');
                for ($i = 0, $n = count($job_id); $i < $n; $i++) {
                    $service = $job_id[$i];
                    $labrate = $lrate[$i];
                    $labnotes = $lnotes[$i];
                    $quotlabour = array(
                        'quot_id' => $quot_id,
                        'job_type_id' => $service,
                        'rate' => $labrate,
                        'note' => $labnotes,
                    );
                    $this->db->insert('quot_labour_used', $quotlabour);
                }

                $item = $this->input->post('product_id');
                $availableqty = $this->input->post('available_qty');
                $item_rate = $this->input->post('price');
                $item_qty = $this->input->post('qty');
                for ($j = 0, $n = count($item); $j < $n; $j++) {
                    $product_id = $item[$j];
                    $available_qty = $availableqty[$j];
                    $rate = $item_rate[$j];
                    $qty = $item_qty[$j];
                    $quotitem = array(
                        'quot_id' => $quot_id,
                        'product_id' => $product_id,
                        'available_qty' => $available_qty,
                        'rate' => $rate,
                        'used_qty' => $qty,
                    );
                    $this->db->insert('quot_products_used', $quotitem);
                }
                $this->session->set_userdata(array('message' => display('successfully_added')));
//                redirect(base_url('Cquotation/manage_quotation'));
            } else {
                $this->session->set_userdata(array('error_message' => display('already_inserted')));
                redirect(base_url('Cquotation'));
            }

//            =========its for quotation send customer ===========
            $this->quotation_pdf_generate($quot_id);
        }
    }

    //    ============ its for invoice pdf generate =======
    public function quotation_pdf_generate($quot_id) {
//        echo getcwd();die();
        $this->load->library('pdfgenerator');
        $id = $quot_id;

//        $data['get_tax'] = $this->db->select('*')->from('tax_information')->get()->result();
//        $data['get_invoice_info'] = $this->Jobs_model->get_invoice_info($job_id);
//        $data['get_invoicedetails'] = $this->Jobs_model->get_invoicedetails($job_id);
//        $data['get_job_products_used'] = $this->Jobs_model->get_job_products_used($job_id);
        $data['quot_main'] = $this->Quotation_model->quot_main_edit($quot_id);
        $data['quot_labour'] = $this->Quotation_model->quot_labour_detail($quot_id);
        $data['quot_product'] = $this->Quotation_model->quot_product_detail($quot_id);
        $data['customer_info'] = $this->Quotation_model->customerinfo($data['quot_main'][0]['customer_id']);
        $data['company_info'] = $this->Quotation_model->retrieve_company();
//        dd($data['customer_info']);
        $name = $data['customer_info'][0]['customer_name'];
        $email = $data['customer_info'][0]['customer_email'];
//        echo $name . "<br> " . $email;        die();
        $html = $this->load->view('quotation/quotation_invoice_pdf', $data, true);
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents('assets/data/pdf/quotation/' . $id . '.pdf', $output);
        $file_path = getcwd() . '/assets/data/pdf/quotation/' . $id . '.pdf';
        $send_email = '';
        if (!empty($email)) {
            $send_email = $this->setmail($email, $file_path, $id, $name);
        }
        $this->session->set_userdata(array('message' => display('successfully_added!')));
//        redirect("Cjob/show_job_invoice/" . $id);
        redirect('Cquotation');
    }

    public function setmail($email, $file_path, $id = null, $name = null) {
//        echo $email. " ".$name;die();
        $setting_detail = $this->db->select('*')->from('email_config')->get()->row();
        $subject = 'Quotation Information';
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
                $this->session->set_flashdata(array('message' => display('successfully_added')));
//                redirect("Cjob/show_job_invoice/" . $id);
                redirect('Cquotation');
            } else {
                $this->session->set_flashdata(array('exception' => display('please_configure_your_mail.')));
                return false;
            }
        } else {
            $this->session->set_userdata(array('message' => display('successfully_added!')));
//            redirect("Cjob/show_job_invoice/" . $id);
            redirect('Cquotation');
        }
    }

    //Email testing for email
    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //========= its for customer ownquotation count ============
    public function customer_ownquotation_count($user_id, $user_type) {
         $this->db->select('count(a.quotation_id) ttl_quotation');
        $this->db->from('quotation a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        if ($this->session->userdata('user_type') == 3) {
            $this->db->where('a.customer_id', $this->session->userdata('user_id'));
            $this->db->where('a.cust_show', 1);
        }
        $this->db->order_by('a.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
//    ============= its for  manage quotation ============
    public function manage_quotation() {
        $data['currency_details'] = $this->Web_settings->retrieve_setting_editdata();
        $data['title'] = display('manage_quotation');
        $config["base_url"] = base_url('Cquotation/manage_quotation/');
        if($this->user_type == 3){
             $ttl_count = $this->customer_ownquotation_count($this->user_id, $this->user_type);
            $config["total_rows"] = $ttl_count[0]->ttl_quotation;
//            dd($config["total_rows"]);
        }else{
        $config["total_rows"] = $this->db->count_all('quotation');
        }
        $config["per_page"] = 20;
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
        $data['quotation_list'] = $this->Quotation_model->quotation_list($limit, $page);
        $data['links'] = $this->pagination->create_links();
        $data['pagenum'] = $page;

        $content = $this->parser->parse('quotation/quotation_list', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // job info
    public function get_job_info() {
        $jobtype_id = $this->input->post('jobtype_id');
        $get_job_info = $this->db->select('*')
                ->from('job_type ')
                ->where('job_type_id', $jobtype_id)
                ->get()
                ->row();
        echo json_encode($get_job_info);
    }

    public function quot_number_generator() {
        $this->db->select_max('quot_no', 'quot_no');
        $query = $this->db->get('quotation');
        $result = $query->result_array();
        $quot_no = $result[0]['quot_no'];
        if ($quot_no != '') {
            $quot_no = $quot_no + 1;
        } else {
            $quot_no = 1000;
        }
        return $quot_no;
    }

    // quotation delete 
    public function delete_quotation($quot_id = null) {
        if ($this->Quotation_model->quotation_delete($quot_id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect(base_url('Cquotation/manage_quotation'));
    }

    // ======================== Quotation Edit information =====================
    public function quotation_edit_data($quot_id = null) {
        $data['title'] = display('quotation_edit');
        $data['get_groupprice'] = $this->Products->get_groupprice();
        $data['quot_main'] = $this->Quotation_model->quot_main_edit($quot_id);
        $data['quot_labour'] = $this->Quotation_model->quot_labour_edit($quot_id);
        $data['quot_product'] = $this->Quotation_model->quot_product_edit($quot_id);
        $data['customers'] = $this->Vehicles->customer_list();
        $data['vehicles'] = $this->Quotation_model->customer_wise_vehicle_info();
        $data['get_jobtypelist'] = $this->Jobs_model->get_jobtypelist();
        $data['get_employeelist'] = $this->Jobs_model->get_employeelist();
        $data['get_productlist'] = $this->Jobs_model->get_productlist();
        $data['customer_info'] = $this->Quotation_model->customerinfo($data['quot_main'][0]['customer_id']);
        $content = $this->parser->parse('quotation/quotation_edit', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // Quotation update
    public function update_quotation() {
        if (isset($_POST['add-quotation'])) {
            $customershow = 0;
            $status = 1;
        } elseif (isset($_POST['customer_sent'])) {
            $customershow = 1;
            $status = 2;
        }
        $quot_id = $this->input->post('quotation_id');

        $data = array(
            'quotation_id' => $quot_id,
            'customer_id' => $this->input->post('customer_id'),
            'vehicle_reg' => $this->input->post('registration_no'),
            'quotdate' => $this->input->post('qdate'),
            'totalamount' => $this->input->post('grandtotal'),
            'quot_no' => $this->input->post('quotation_no'),
            'create_by' => $this->session->userdata('user_id'),
            'quot_description' => $this->input->post('details'),
            'status' => $status,
            'terms' => $this->input->post('terms'),
            'cust_show' => $customershow,
            'dis_per' => $this->input->post('dis_per'),
            'total_discount' => $this->input->post('total_dis'),
        );

        $result = $this->Quotation_model->quotation_update($data);

        if ($result == TRUE) {
            //used product
            $this->db->where('quot_id', $quot_id);
            $this->db->delete('quot_products_used');
            // used labour
            $this->db->where('quot_id', $quot_id);
            $this->db->delete('quot_labour_used');

            $job_id = $this->input->post('job_type_id');
            $lnotes = $this->input->post('lnotes');
            $lrate = $this->input->post('lrate');
            for ($i = 0, $n = count($job_id); $i < $n; $i++) {
                $service = $job_id[$i];
                $labrate = $lrate[$i];
                $labnotes = $lnotes[$i];
                $quotlabour = array(
                    'quot_id' => $quot_id,
                    'job_type_id' => $service,
                    'rate' => $labrate,
                    'note' => $labnotes,
                );
                $this->db->insert('quot_labour_used', $quotlabour);
            }

            $item = $this->input->post('product_id');
            $availableqty = $this->input->post('available_qty');
            $item_rate = $this->input->post('price');
            $item_qty = $this->input->post('qty');
            for ($j = 0, $n = count($item); $j < $n; $j++) {
                $product_id = $item[$j];
                $available_qty = $availableqty[$i];
                $rate = $item_rate[$j];
                $qty = $item_qty[$j];
                $quotitem = array(
                    'quot_id' => $quot_id,
                    'product_id' => $product_id,
                    'available_qty' => $available_qty,
                    'rate' => $rate,
                    'used_qty' => $qty,
                );
                $this->db->insert('quot_products_used', $quotitem);
            }
            $this->session->set_userdata(array('message' => display('successfully_updated')));
            redirect(base_url('Cquotation/manage_quotation'));
        } else {
            $this->session->set_userdata(array('error_message' => display('please_try_again')));
            redirect(base_url('Cquotation'));
        }
    }

    // Quotation View Details
    public function quotation_details_data($quot_id = null) {
        $data['currency_details'] = $this->Web_settings->retrieve_setting_editdata();
        $data['title'] = display('quotation_details');
        $data['quot_main'] = $this->Quotation_model->quot_main_edit($quot_id);
        $data['quot_labour'] = $this->Quotation_model->quot_labour_detail($quot_id);
        $data['quot_product'] = $this->Quotation_model->quot_product_detail($quot_id);
//        $data['quot_product'] = $this->Quotation_model->quot_product_edit($quot_id);
        $data['customer_info'] = $this->Quotation_model->customerinfo($data['quot_main'][0]['customer_id']);
        $data['company_info'] = $this->Quotation_model->retrieve_company();
        $data['messagesss'] = $this->Quotation_model->quotation_chat($quot_id);
        $content = $this->parser->parse('quotation/quotation_details', $data, true);
        $this->template->full_admin_html_view($content);
    }

    public function quotation_customer_chat() {
        $quot_id = $this->input->post('quot_id');
        $message = $this->input->post('message');
        $data = array(
            'quotation_id' => $quot_id,
            'message' => $message,
            'sent_by' => $this->session->userdata('user_id'),
        );
        $this->db->insert('quotation_chat', $data);
        $ret_data = true;
        echo json_encode($ret_data);
    }

    public function quotation_customer_status() {
        $quot_id = $this->input->post('quot_id');
        $jobinf = $this->db->select('*')->from('quotation')->where('quotation_id', $quot_id)->get()->row();
        $quotjobtype = $this->db->select('*')->from('quot_labour_used')->where('quot_id', $quot_id)->get()->result_array();
        $quotproduct = $this->db->select('*')->from('quot_products_used')->where('quot_id', $quot_id)->get()->result_array();
        $status = $this->input->post('id');
//       d($quotjobtype);
        $data = array(
            'status' => $status,
        );
        $this->db->where('quotation_id', $quot_id);
        $this->db->update('quotation', $data);

        if ($status == 3) {
            $job_data = array(
                'customer_id' => $jobinf->customer_id,
                'quotation_id' => $quot_id,
                'is_quotation' => 1,
                'work_order_no' => $jobinf->id . '-' . time(),
                'vehicle_id' => $jobinf->vehicle_reg,
                'job_description' => $jobinf->quot_description,
                'alert_via' => 'email',
                'create_by' => $this->session->userdata('user_id'),
                'create_date' => date('Y-m-d H:i:s'),
                'status' => 0,
            );
//        d($job_data);
            $this->db->insert('job', $job_data);

            $job_id = $this->db->insert_id();
            foreach ($quotjobtype as $jobs) {
                $job_details_data = array(
                    'job_id' => $job_id,
                    'job_type_id' => $jobs['job_type_id'],
                    'assign_to' => '',
                    'rate' => $jobs['rate'],
                    'client_notes' => 'rate',
                    'status' => 0,
                );
//        d($job_details_data);
                $this->db->insert('job_details', $job_details_data);
            }
            foreach ($quotproduct as $products) {
                $job_products = array(
                    'job_id' => $job_id,
                    'product_id' => $products['product_id'],
                    'rate' => $products['rate'],
                    'used_qty' => $products['used_qty'],
                    'mechanic_note' => '',
                );
//        d($job_products);
                $this->db->insert('job_products_used', $job_products);
            }
        }

        $ret_data = true;
        echo json_encode($ret_data);
    }

    // Quotation View Details
    public function quotation_download($quot_id = null) {
        $data['currency_details'] = $this->Web_settings->retrieve_setting_editdata();
        $data['title'] = display('quotation_details');
        $data['quot_main'] = $this->Quotation_model->quot_main_edit($quot_id);
        $data['quot_labour'] = $this->Quotation_model->quot_labour_detail($quot_id);
        $data['quot_product'] = $this->Quotation_model->quot_product_detail($quot_id);
        $data['customer_info'] = $this->Quotation_model->customerinfo($data['quot_main'][0]['customer_id']);
        $data['company_info'] = $this->Quotation_model->retrieve_company();
        $data['messagesss'] = $this->Quotation_model->quotation_chat($quot_id);
        $data['currency_details'] = $this->Web_settings->retrieve_setting_editdata();

        $this->load->library('pdfgenerator');
        $dompdf = new DOMPDF();
        $page = $this->load->view('quotation/quotation_download', $data, true);
//       dd($page);
        $file_name = time();
        $dompdf->load_html($page);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents("assets/data/pdf/quotation/$file_name.pdf", $output);
        $filename = $file_name . '.pdf';
        $file_path = base_url() . 'assets/data/pdf/quotation/' . $filename;

        $this->load->helper('download');
        force_download('./assets/data/pdf/quotation/' . $filename, NULL);
        redirect("Cquotation/manage_quotation");
    }

    //    ========== its for jobonkeyup_search =========
    public function quotaionnkeyup_search() {
        $keyword = $this->input->post('keyword');
        $data['quotation_list'] = $this->Quotation_model->quotationonkeyup_search($keyword);
//        echo '<pre>';        print_r($data['vehicle_list']);die();
        $this->load->view('quotation/quotaionnkeyup_search', $data);
    }

}
