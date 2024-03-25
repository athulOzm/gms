<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ccronjob extends CI_Controller {

    public $menu;
    private $user_id;
    private $user_type;
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('session');
        $this->load->model('Jobs_model');
        $this->load->model('Products');
        $this->load->model('Vehicles');
        $this->load->model('Web_settings');
//        $this->auth->check_admin_auth();
        $this->user_id = $this->session->userdata('user_id');
        $this->user_type = $this->session->userdata('user_type');
    }

   
//    ========= its for get recurring job ===============
    public function get_recurring_invoice() {
        $today = date('Y-m-d');
        $recurring_invoice = $this->Jobs_model->get_recurring_job();
//        d($recurring_invoice);die();
        foreach ($recurring_invoice as $recurring) {
            $data['job_id'] = $recurring->job_id;
            $data['invoice_id'] = $recurring->invoice_id;
            $data['customer_id'] = $recurring->customer_id;
            $data['date'] = $recurring->date;
            $data['total_amount'] = $recurring->total_amount;
            $data['prevous_due'] = $recurring->prevous_due;
            $data['shipping_cost'] = $recurring->shipping_cost;
            $data['invoice'] = $recurring->invoice;
            $data['invoice_discount'] = $recurring->invoice_discount;
            $data['total_discount'] = $recurring->total_discount;
            $data['total_tax'] = $recurring->total_tax;
            $data['sales_by'] = $recurring->sales_by;
            $data['invoice_details'] = $recurring->invoice_details;
            $data['labour_cost'] = $recurring->labour_cost;
            $data['is_recurring'] = $recurring->is_recurring;
            $data['recurring_time'] = $recurring->recurring_time;
            $data['create_date'] = $recurring->create_date;
            $last_recurring_time = strtotime($recurring->create_date);
            $recurring_time = $recurring->recurring_time;
            
            $next_recurring = strtotime("$recurring_time", $last_recurring_time);
            $next_recurring_date = date('Y-m-d', $next_recurring);
            if ($today == $next_recurring_date) {
//                $today_recurring_invoice = $this->db->select('*')->from('invoice')->where('create_date', $next_recurring_date)->get()->result();
//                echo $data['invoice_id'];  
                $data['today_recurring_date'] = $next_recurring_date;
                $invoice_details = $this->Jobs_model->recurring_invoicedetails($data['invoice_id']);
//                d($invoice_details);
                $this->recurring_invoice_send($recurring_invoice, $invoice_details, $data);
            } else {
                
            }
        }
    }

//    ========== its for recurring invoice send =============
    public function recurring_invoice_send($recurring_invoice, $invoice_details, $data) {
//        dd($data);
        $createby = 1; //$this->user_id;
        $createdate = date('Y-m-d H:i:s');
        $invoice_id = $this->generator(10);
        $invoice_id = strtoupper($invoice_id);
        $transection_id = $this->auth->generator(15);
        $job_id = $data['job_id'];
        $customer_id = $data['customer_id'];
        $invoice_date = date('Y-m-d');
        $total = $data['total_amount'];
        $labour_cost = $data['labour_cost'];
        $is_recurring = $data['is_recurring'];
        $recurring_time = $data['recurring_time'];
        $gst_percent = $data['total_tax'];
        $discount = $data['invoice_discount'];
        $today_recurring_date = strtotime($data['today_recurring_date']);
        $today_previous_recurring_strtotime = strtotime("-$recurring_time", $today_recurring_date);
        $today_previous_recurring_date = date('Y-m-d', $today_previous_recurring_strtotime);
        $paid_amount = 0;
//        dd($today_previous_recurring_date);
        if ($paid_amount >= 0) {
            $previous_recurring_data = array(
                'is_recurring' => 0,
            );
            $this->db->where('create_date', $today_previous_recurring_date)->update('invoice', $previous_recurring_data);
            
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
            'is_recurring' => $is_recurring,
            'recurring_time' => $recurring_time,
            'create_date' => date('Y-m-d'),
            'total_tax' => $gst_percent, //$this->input->post('total_tax'),
            'invoice' => $this->number_generator(),
            'invoice_details' => '', //(!empty($this->input->post('inva_details')) ? $this->input->post('inva_details') : 'Gui Pos'),
            'invoice_discount' => $discount,
            'total_discount' => '', //$this->input->post('total_discount'),
            'prevous_due' => '', //$this->input->post('previous'),
            'shipping_cost' => '', //$this->input->post('shipping_cost'),
            'sales_by' => 1, //$this->session->userdata('user_id'),
            'status' => 1,
        );
        //	print_r($datainv);exit;
        $this->db->insert('invoice', $invoice_data);
//        =========== its for invoice details =============
        foreach ($invoice_details as $details) {
            $product_id = $details->product_id;
            $quantity = $details->quantity;
            $spent_time = $details->spent_time;
            $rate = $details->rate;
            $discount = $details->discount;
            $description = $details->description;
            $discount_per = $details->discount_per;
            $tax = $details->tax;
            $paid_amount = $details->paid_amount;
            $due_amount = $details->due_amount;
            $supplier_rate = $details->supplier_rate;
            $amount = $details->total_price;

            $invoice_details_data = array(
                'invoice_details_id' => $this->generator(15),
                'invoice_id' => $invoice_id,
                'product_id' => $product_id,
                'spent_time' => $spent_time,
                'quantity' => $quantity,
                'rate' => $rate,
                'discount' => $discount, //$discount,
                'description' => $description,
                'discount_per' => $discount_per,
                'tax' => $tax,
                'paid_amount' => $paid_amount, //$this->input->post('paid_amount'),
                'due_amount' => $due_amount, //$this->input->post('due_amount'),
                'supplier_rate' => $supplier_rate, //$supplier_rate[0]['supplier_price'],
                'total_price' => $amount,
                'status' => 1
            );
//            d($invoice_details_data);
            $this->db->insert('invoice_details', $invoice_details_data);
        }
        $job_invoice_data = array(
            'is_invoice' => 1,
        );
        $this->db->where('job_id', $job_id)->update('job', $job_invoice_data);
        $this->invoice_pdf_generate($job_id);
        $this->session->set_userdata(array('message' => display('invoice_generated_successfully!')));
//        redirect(base_url('Cjob/show_job_invoice/' . $job_id));
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


    public function invoice_pdf_generate($job_id) {
//        echo getcwd();die();
        $this->load->library('pdfgenerator');
        $id = $job_id;

        $data['get_tax'] = $this->db->select('*')->from('tax_information')->get()->result();
        $data['get_invoice_info'] = $this->Jobs_model->get_invoice_info($job_id);
        $data['get_invoicedetails'] = $this->Jobs_model->get_invoicedetails($job_id);
        $data['get_job_products_used'] = $this->Jobs_model->get_job_products_used($job_id);

        $name = $data['get_invoice_info'][0]->customer_name;
        $email = $data['get_invoice_info'][0]->customer_email;
//         echo $name. " ".$email; die();
//         echo '<pre>'; print_r($data);die();
//        $datas['appSetting'] = $this->website_model->read_setting();
//        $data['languageList'] = $this->languageList();
//        $datas['ticket'] = $this->website_model->getTicket($id);
//        $datas['item_number'] = $paypalInfo['item_number'];
//        $datas['txn_id'] = $paypalInfo["tx"];
//        $datas['payment_amt'] = $paypalInfo["amt"];
//        $datas['currency_code'] = $paypalInfo["cc"];
//        $datas['status'] = $paypalInfo["st"];
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
//        $this->session->set_userdata(array('message' => display('invoice_generated_successfully!')));
//        redirect("Cjob/show_job_invoice/" . $id);
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
                $this->session->set_flashdata(array('message' => display('invoice_generated_successfully')));
//                redirect("Cjob/show_job_invoice/" . $id);
                return true;
            } else {
                $this->session->set_flashdata(array('error_message' => display('please_configure_your_mail.')));
                return false;
            }
        } else {
            $this->session->set_userdata(array('message' => display('invoice_generated_successfully!')));
//            redirect("Cjob/show_job_invoice/" . $id);
            return true;
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

}
