<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ccustomer extends CI_Controller {

    public $menu;
    private $user_id;

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('lcustomer');
        $this->load->library('Smsgateway');
        $this->load->library('session');
        $this->load->model('Customers');
        $this->load->model('Vehicles');
        $this->load->model('Permission_model');
        $this->load->model('Web_settings');
        $this->auth->check_admin_auth();
        $this->user_id = $this->session->userdata('user_id');
    }

    //Default loading for Customer System.
    public function index() {
        //Calling Customer add form which will be loaded by help of "lcustomer,located in library folder"
        $content = $this->lcustomer->customer_add_form();
        //Here ,0 means array position 0 will be active class
        $this->template->full_admin_html_view($content);
    }

    //customer_search_item
    public function customer_search_item() {
        $customer_id = $this->input->post('customer_id');
        $content = $this->lcustomer->customer_search_item($customer_id);
        $this->template->full_admin_html_view($content);
    }
//    ========== its for all_activeInactive_data ============
    public function all_activeInactive_data() {
        $status = $this->input->post('status');
        
         $CI = & get_instance();
        $CI->load->model('Customers');
        $CI->load->model('Web_settings');
        $customers_list = $CI->Customers->all_activeInactive_data($status);
        $all_customer_list = $CI->Customers->all_customer_list();
        $i = 0;
        $total = 0;
        if ($customers_list) {
            foreach ($customers_list as $k => $v) {
                $i++;
                $customers_list[$k]['sl'] = $i;
                $total += $customers_list[$k]['customer_balance'];
            }
            $currency_details = $CI->Web_settings->retrieve_setting_editdata();
            $data = array(
                'title' => display('manage_customer'),
                'subtotal' => number_format($total, 2, '.', ','),
                'all_customer_list' => $all_customer_list,
                'links' => "",
                'pagenum' => "",
                'customers_list' => $customers_list,
                'currency' => $currency_details[0]['currency'],
                'position' => $currency_details[0]['currency_position'],
            );
            $this->load->view('customer/active_inactivecustomer', $data);
//            $customerList = $CI->parser->parse('customer/customer', $data, true);
//            return $customerList;
        }
//        else {
//            redirect('Ccustomer/manage_customer');
//        }
        
//        $content = $this->lcustomer->all_activeInactive_data($status);
//        $this->template->full_admin_html_view($content);
    }

    //credit customer_search_item
    public function credit_customer_search_item() {
        $customer_id = $this->input->post('customer_id');
        $content = $this->lcustomer->credit_customer_search_item($customer_id);
        $this->template->full_admin_html_view($content);
    }

    //paid customer_search_item
    public function paid_customer_search_item() {
        $customer_id = $this->input->post('customer_id');
        $content = $this->lcustomer->paid_customer_search_item($customer_id);
        $this->template->full_admin_html_view($content);
    }

    //Manage customer
    public function manage_customer() {
        $this->load->model('Customers');
        $alldata = $this->input->post('all');
        #        #pagination starts        # 
        if (!empty($alldata)) {
            $perpagdata = $this->Customers->customer_list_count();
        } else {
            $perpagdata = 10;
        }
        $config["base_url"] = base_url('Ccustomer/manage_customer/');
        $config["total_rows"] = $this->Customers->customer_list_count();
//        dd($config["total_rows"]);
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        $pagenum = $page;
        #
        #pagination ends
        #  
        $content = $this->lcustomer->customer_list($links, $config["per_page"], $page, $pagenum);
        $this->template->full_admin_html_view($content);
    }

    //Product Add Form
    public function credit_customer() {
        $this->load->model('Customers');
        $alldata = $this->input->post('all');
        if (!empty($alldata)) {
            $perpagdata = $this->Customers->credit_customer_list_count();
        } else {
            $perpagdata = 10;
        }
        #
        #pagination starts
        #
        $config["base_url"] = base_url('Ccustomer/credit_customer/');
        $config["total_rows"] = $this->Customers->credit_customer_list_count();
//        print_r($config["total_rows"]);die();
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lcustomer->credit_customer_list($links, $config["per_page"], $page);

        $this->template->full_admin_html_view($content);
        ;
    }

    //Paid Customer list. The customer who will pay 100%.
    public function paid_customer() {
        $this->load->model('Customers');
        $alldata = $this->input->post('all');
        if (!empty($alldata)) {
            $perpagdata = $this->Customers->paid_customer_list_count();
        } else {
            $perpagdata = 10;
        }

        #
        #pagination starts
        #
        $config["base_url"] = base_url('Ccustomer/paid_customer/');
        $config["total_rows"] = $this->Customers->paid_customer_list_count();
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lcustomer->paid_customer_list($links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
        ;
    }

    //Insert Product and upload
    public function insert_customer() {
//        $this->input->post('previous_balance');
        $previous_balance = '0.00';
//        echo $this->input->post('role_id'); die();
        $customer_id = $this->auth->generator(15);
        $vouchar_no = $this->auth->generator(10);
        $notifications = $this->input->post('notifications');
        $notification_name = '';
        $notification_names = '';
        if ($notifications) {
            foreach ($notifications as $key => $value) {
                $notification_name .= $value . ',';
            }
            $notification_names = rtrim($notification_name, ',');
        }
        //Customer  basic information adding.
        $coa = $this->Customers->headcode();
//        if ($coa->HeadCode != NULL) {
//            $headcode = $coa->HeadCode + 1;
//        } else {
//            $headcode = "102030101";
//        }
        if ($coa->HeadCode != NULL) {
            $hc = explode("-", $coa->HeadCode);
            $nxt = $hc[1] + 1;
            $headcode = $hc[0] . "-" . $nxt;
        } else {
            $headcode = "1020301-1";
        }

        $c_acc = $customer_id . '-' . $this->input->post('customer_name');
        $createby = $this->session->userdata('user_id');
        $createdate = date('Y-m-d H:i:s');
        $data = array(
            'customer_id' => $customer_id,
            'customer_name' => $this->input->post('customer_name'),
            'customer_phone' => $this->input->post('customer_phone'),
            'customer_mobile' => $this->input->post('customer_mobile'),
            'customer_email' => $this->input->post('customer_email'),
            'customer_skype' => $this->input->post('customer_skype'),
            'customer_address' => $this->input->post('customer_address'),
            'company_name' => $this->input->post('company_name'),
            'company_number' => $this->input->post('company_number'),
            'vat_number' => $this->input->post('vat_number'),
            'company_type' => $this->input->post('company_type'),
            'postal_address' => $this->input->post('postal_address'),
            'physical_address' => $this->input->post('physical_address'),
            'website' => $this->input->post('website'),
            'director_name' => $this->input->post('director_name'),
            'director_mobile' => $this->input->post('director_mobile'),
            'director_phone' => $this->input->post('director_phone'),
            'director_address' => $this->input->post('director_address'),
            'trade_reference_1' => $this->input->post('trade_reference_1'),
            'trade_reference_2' => $this->input->post('trade_reference_2'),
            'trade_reference_3' => $this->input->post('trade_reference_3'),
            'status' => $this->input->post('status'),
            'notes' => $this->input->post('notes'),
            'notifications' => $notification_names,
            'payment_method' => $this->input->post('payment_method'),
            'payment_period' => $this->input->post('payment_period'),
            'sales_discount_status' => $this->input->post('sales_discount_status'),
            'markup_discount' => $this->input->post('markup_discount'),
            'role_id' => $this->input->post('role_id'),
            'is_outside' => 0,
        );
//        echo '<pre>';        print_r($data);die();
        $customer_coa = [
            'HeadCode' => $headcode,
            'HeadName' => $c_acc,
            'PHeadName' => 'Customer Receivable',
            'HeadLevel' => '4',
            'IsActive' => '1',
            'IsTransaction' => '1',
            'IsGL' => '0',
            'HeadType' => 'A',
            'IsBudget' => '0',
            'IsDepreciation' => '0',
            'DepreciationRate' => '0',
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
        ];

        $result = $this->Customers->customer_entry($data);
//        ========== its for login info =============
        $login_details = array(
            'user_id' => $customer_id,
            'username' => $this->input->post('user_name'),
            'password' => md5("gef" . $this->input->post('password')),
            'user_type' => '3',
            'status' => '1',
        );
        $this->db->insert('user_login', $login_details);
//        =========== its for user info ============
        $user_details = array(
            'user_id' => $customer_id,
            'first_name' => $this->input->post('customer_name'),
            'last_name' => '',
            'gender' => '',
            'date_of_birth' => '',
            'logo' => '',
            'status' => '1',
        );
        $this->db->insert('users', $user_details);
//        ============ its for user access role assign ========
        $user_access_info = array(
            'user_id' => $customer_id,
            'roleid' => $this->input->post('role_id'),
            'createby' => $this->user_id,
            'createdate' => $createdate,
        );
        $this->db->insert('sec_userrole', $user_access_info);

        if ($result == TRUE) {
            //Previous balance adding -> Sending to customer model to adjust the data.
            $this->db->insert('acc_coa', $customer_coa);
            $this->Customers->previous_balance_add($previous_balance, $customer_id);


            $this->session->set_userdata(array('message' => display('successfully_added')));
            if (isset($_POST['add-customer'])) {
                redirect(base_url('Ccustomer'));
                exit;
            } elseif (isset($_POST['add-customer-another'])) {
                redirect(base_url('Ccustomer'));
                exit;
            }
        } else {
            $this->session->set_userdata(array('error_message' => display('already_exists')));
            redirect(base_url('Ccustomer'));
        }
    }

    // =================== customer Csv Upload ===============================
    //CSV Customer Add From here
    function uploadCsv_Customer() {
        $count = 0;
        $fp = fopen($_FILES['upload_csv_file']['tmp_name'], 'r') or die("can't open file");

        if (($handle = fopen($_FILES['upload_csv_file']['tmp_name'], 'r')) !== FALSE) {

            while ($csv_line = fgetcsv($fp, 1024)) {
                //keep this if condition if you want to remove the first row
                for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
                    $insert_csv = array();
                    $insert_csv['customer_name'] = (!empty($csv_line[0]) ? $csv_line[0] : null);
                    $insert_csv['customer_email'] = (!empty($csv_line[1]) ? $csv_line[1] : '');
                    $insert_csv['customer_mobile'] = (!empty($csv_line[2]) ? $csv_line[2] : '');
                    $insert_csv['customer_address'] = (!empty($csv_line[3]) ? $csv_line[3] : '');
                    $insert_csv['previousbalance'] = (!empty($csv_line[4]) ? $csv_line[4] : 0);
                }

                $customer_id = $this->auth->generator(15);

                //Customer  basic information adding.
                $coa = $this->Customers->headcode();
                if ($coa->HeadCode != NULL) {
                    $headcode = $coa->HeadCode + 1;
                } else {
                    $headcode = "102030101";
                }
                $c_acc = $customer_id . '-' . $insert_csv['customer_name'];
                $createby = $this->session->userdata('user_id');
                $createdate = date('Y-m-d H:i:s');
                $transaction_id = $this->auth->generator(10);
                $customerdata = array(
                    'customer_id' => $customer_id,
                    'customer_name' => $insert_csv['customer_name'],
                    'customer_email' => $insert_csv['customer_email'],
                    'customer_mobile' => $insert_csv['customer_mobile'],
                    'customer_address' => $insert_csv['customer_address'],
                    'status' => 1
                );

                $customer_ledger = array(
                    'transaction_id' => $transaction_id,
                    'customer_id' => $customer_id,
                    'invoice_no' => "NA",
                    'receipt_no' => NULL,
                    'amount' => $insert_csv['previousbalance'],
                    'description' => "Previous adjustment with software",
                    'payment_type' => "NA",
                    'cheque_no' => "NA",
                    'date' => date("Y-m-d"),
                    'status' => 1,
                    'd_c' => "d"
                );
                $customer_coa = [
                    'HeadCode' => $headcode,
                    'HeadName' => $c_acc,
                    'PHeadName' => 'Customer Receivable',
                    'HeadLevel' => '4',
                    'IsActive' => '1',
                    'IsTransaction' => '1',
                    'IsGL' => '0',
                    'HeadType' => 'A',
                    'IsBudget' => '0',
                    'IsDepreciation' => '0',
                    'DepreciationRate' => '0',
                    'CreateBy' => $createby,
                    'CreateDate' => $createdate,
                ];
                // Customer debit for previous balance
                $cosdr = array(
                    'VNo' => $transaction_id,
                    'Vtype' => 'PR Balance',
                    'VDate' => date("Y-m-d"),
                    'COAID' => $headcode,
                    'Narration' => 'Customer debit For Transaction No' . $transaction_id,
                    'Debit' => $insert_csv['previousbalance'],
                    'Credit' => 0,
                    'IsPosted' => 1,
                    'CreateBy' => $this->session->userdata('user_id'),
                    'CreateDate' => date('Y-m-d H:i:s'),
                    'IsAppove' => 1
                );


                if ($count > 0) {
                    $this->db->insert('customer_information', $customerdata);
                    $this->db->insert('customer_ledger', $customer_ledger);
                    $this->db->insert('acc_coa', $customer_coa);
                    $this->db->insert('acc_coa', $cosdr);
                }
                $count++;
            }
        }
        $this->db->select('*');
        $this->db->from('customer_information');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $json_customer[] = array('label' => $row->customer_name, 'value' => $row->customer_id);
        }
        $cache_file = './my-assets/js/admin_js/json/customer.json';
        $customerList = json_encode($json_customer);
        file_put_contents($cache_file, $customerList);
        fclose($fp) or die("can't close file");
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Ccustomer/manage_customer'));
    }

    //customer Update Form
    public function customer_update_form($customer_id) {
        $content = $this->lcustomer->customer_edit_data($customer_id);
        $this->template->full_admin_html_view($content);
    }

    //Customer Ledger
    public function customer_ledger($customer_id) {
        $content = $this->lcustomer->customer_ledger_data($customer_id);
        $this->template->full_admin_html_view($content);
    }

    //Customer Final Ledger
    public function customerledger($customer_id) {
        $content = $this->lcustomer->customerledger_data($customer_id);
        $this->template->full_admin_html_view($content);
    }

    //Customer Previous Balance
    public function previous_balance_form() {
        $content = $this->lcustomer->previous_balance_form();
        $this->template->full_admin_html_view($content);
    }

    // customer Update
    public function customer_update() {
        $this->load->model('Customers');
        $customer_id = $this->input->post('customer_id');
        $old_headnam = $customer_id . '-' . $this->input->post('oldname');
        $c_acc = $customer_id . '-' . $this->input->post('customer_name');
        $customer_name = $this->input->post('customer_name');
        $customer_phone = $this->input->post('customer_phone');
        $customer_mobile = $this->input->post('customer_mobile');
        $customer_email = $this->input->post('customer_email');
        $customer_skype = $this->input->post('customer_skype');
        $customer_address = $this->input->post('customer_address');
        $company_name = $this->input->post('company_name');
        $company_number = $this->input->post('company_number');
        $vat_number = $this->input->post('vat_number');
        $company_type = $this->input->post('company_type');
        $postal_address = $this->input->post('postal_address');
        $physical_address = $this->input->post('physical_address');
        $website = $this->input->post('website');
        $director_name = $this->input->post('director_name');
        $director_mobile = $this->input->post('director_mobile');
        $director_phone = $this->input->post('director_phone');
        $director_address = $this->input->post('director_address');
        $trade_reference_1 = $this->input->post('trade_reference_1');
        $trade_reference_2 = $this->input->post('trade_reference_2');
        $trade_reference_3 = $this->input->post('trade_reference_3');
        $status = $this->input->post('status');
        $notes = $this->input->post('notes');
        $role_id = $this->input->post('role_id');
        $notifications = $this->input->post('notifications');
        $notification_name = '';
        $notification_names = '';
        if ($notifications) {
            foreach ($notifications as $key => $value) {
                $notification_name .= $value . ',';
            }
            $notification_names = rtrim($notification_name, ',');
        }
        $payment_period = $this->input->post('payment_period');
        $payment_method = $this->input->post('payment_method');
        $sales_discount_status = $this->input->post('sales_discount_status');
        $markup_discount = $this->input->post('markup_discount');
        $data = array(
            'customer_name' => $customer_name,
            'customer_phone' => $customer_phone,
            'customer_mobile' => $customer_mobile,
            'customer_email' => $customer_email,
            'customer_skype' => $customer_skype,
            'customer_address' => $customer_address,
            'company_name' => $company_name,
            'company_number' => $company_number,
            'vat_number' => $vat_number,
            'company_type' => $company_type,
            'postal_address' => $postal_address,
            'physical_address' => $physical_address,
            'website' => $website,
            'director_name' => $director_name,
            'director_mobile' => $director_mobile,
            'director_phone' => $director_phone,
            'director_address' => $director_address,
            'trade_reference_1' => $trade_reference_1,
            'trade_reference_2' => $trade_reference_2,
            'trade_reference_3' => $trade_reference_3,
            'status' => $status,
            'notes' => $notes,
            'notifications' => $notification_names,
            'payment_period' => $payment_period,
            'payment_method' => $payment_method,
            'sales_discount_status' => $sales_discount_status,
            'markup_discount' => $markup_discount,
            'role_id' => $role_id,
        );


        $result = $this->Customers->update_customer($data, $customer_id);
        $check_exist_headcode = $this->db->from('acc_coa')->where('HeadName', $old_headnam)->get()->row();
//         dd($check_exist_headcode);
        if (empty($check_exist_headcode)) {
            //Customer  basic information adding.
            $coa = $this->Customers->headcode();
//            if ($coa->HeadCode != NULL) {
//                $headcode = $coa->HeadCode + 1;
//            } else {
//                $headcode = "102030101";
//            }
            if ($coa->HeadCode != NULL) {
                $hc = explode("-", $coa->HeadCode);
                $nxt = $hc[1] + 1;
                $headcode = $hc[0] . "-" . $nxt;
            } else {
                $headcode = "1020301-1";
            }
            $c_acc = $customer_id . '-' . $this->input->post('customer_name');
            $createby = $this->session->userdata('user_id');
            $createdate = date('Y-m-d H:i:s');

            $customer_coa = [
                'HeadCode' => $headcode,
                'HeadName' => $c_acc,
                'PHeadName' => 'Customer Receivable',
                'HeadLevel' => '4',
                'IsActive' => '1',
                'IsTransaction' => '1',
                'IsGL' => '0',
                'HeadType' => 'A',
                'IsBudget' => '0',
                'IsDepreciation' => '0',
                'DepreciationRate' => '0',
                'CreateBy' => $createby,
                'CreateDate' => $createdate,
            ];
            $this->db->insert('acc_coa', $customer_coa);
        } else {
            $customer_coa = [
                'HeadName' => $c_acc
            ];
            $this->db->where('HeadName', $old_headnam);
            $this->db->update('acc_coa', $customer_coa);
        }
        if ($result == TRUE) {
            $oldpass = $this->input->post('oldpassword');
            $npassword = md5("gef" . $this->input->post('password'));
            $login_details = array(
                'username' => $this->input->post('user_name'),
                'password' => (!empty($this->input->post('password')) ? $npassword : $oldpass),
                'user_type' => '3',
                'status' => '1',
            );

            $this->db->where('user_id', $customer_id);
            $this->db->update('user_login', $login_details);
//        =========== its for user info ============
            $user_details = array(
                'first_name' => $this->input->post('customer_name'),
                'last_name' => '',
                'gender' => '',
                'date_of_birth' => '',
                'logo' => '',
                'status' => '1',
            );
            $this->db->where('user_id', $customer_id);
            $this->db->update('users', $user_details);


//        ============ its for user access role assign ========
            $check_user_access = $this->db->select('*')->where('user_id', $customer_id)->get('sec_userrole')->row();
//            dd($check_user_access);
            if ($check_user_access) {
                $user_access_info = array(
                    'roleid' => $this->input->post('role_id'),
                    'createby' => $this->user_id,
                    'createdate' => date('Y-m-d H:i:s'),
                );
                $this->db->where('user_id', $customer_id);
                $this->db->update('sec_userrole', $user_access_info);
            } else {
                $user_access_info = array(
                    'user_id' => $customer_id,
                    'roleid' => $this->input->post('role_id'),
                    'createby' => $this->user_id,
                    'createdate' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('sec_userrole', $user_access_info);
            }

            $this->session->set_userdata(array('message' => display('successfully_updated')));
            redirect(base_url('Ccustomer/manage_customer'));
            exit;
        } else {
            $this->session->set_userdata(array('error_message' => display('please_try_again')));
            redirect(base_url('Ccustomer'));
        }
    }

    // product_delete
    public function customer_delete($customer_id) {
        $this->load->model('Customers');
        // $customer_id = $_POST['customer_id'];
        $customerinfo = $this->db->select('customer_name')->from('customer_information')->where('customer_id', $customer_id)->get()->row();
        $customer_head = $customer_id . '-' . $customerinfo->customer_name;
//        $status_data = array(
//            'status' => 3,
//        );
        $this->Customers->delete_customer($customer_id, $customer_head);
        $this->Customers->delete_transection($customer_id);
        $this->Customers->delete_customer_ledger($customer_id);
        $this->Customers->delete_customer_ledger($customer_id);
        $this->Customers->delete_invoic($customer_id);
        $this->Customers->delete_user($customer_id);
        $this->Customers->delete_user_login($customer_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect(base_url('Ccustomer/manage_customer'));
    }

// customer pdf download
    public function customer_downloadpdf() {
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Customers');
        $CI->load->model('Web_settings');
        $CI->load->library('pdfgenerator');
        $customer_list = $CI->Customers->customer_list_pdf();
        if (!empty($customer_list)) {
            $i = 0;
            if (!empty($customer_list)) {
                foreach ($customer_list as $k => $v) {
                    $i++;
                    $customer_list[$k]['sl'] = $i + $CI->uri->segment(3);
                }
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Invoices->retrieve_company();
        $data = array(
            'title' => display('customer_list'),
            'customer_list' => $customer_list,
            'currency' => $currency_details[0]['currency'],
            'logo' => $currency_details[0]['logo'],
            'position' => $currency_details[0]['currency_position'],
            'company_info' => $company_info
        );
        $this->load->helper('download');
        $content = $this->parser->parse('customer/customer_list_pdf', $data, true);
        $time = date('Ymdhi');
        $dompdf = new DOMPDF();
        $dompdf->load_html($content);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents('assets/data/pdf/' . 'customer' . $time . '.pdf', $output);
        $file_path = 'assets/data/pdf/' . 'customer' . $time . '.pdf';
        $file_name = 'customer' . $time . '.pdf';
        force_download(FCPATH . 'assets/data/pdf/' . $file_name, null);
    }

    //Export CSV
    public function exportCSV() {
        // file name 
        $this->load->model('Customers');
        $filename = 'customer_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // get data 
        $usersData = $this->Customers->customer_csv_file();

        // file creation 
        $file = fopen('php://output', 'w');

        $header = array('CustomerName', 'Email', 'Address', 'Mobile');
        fputcsv($file, $header);
        foreach ($usersData as $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }

//    ============= its for custom_sms ==========
    public function custom_sms() {
        $data['title'] = display('custom_sms');
        $data['customers'] = $this->Vehicles->customer_list();

        $content = $this->parser->parse('customer/custom_sms', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============= its for custom_email ==========
    public function custom_email() {
        $data['title'] = display('custom_email');
        $data['customers'] = $this->Vehicles->customer_list();

        $content = $this->parser->parse('customer/custom_email', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ======== its  for send_custom_email ===========
    public function send_custom_email() {
        $email = $this->input->post('customer_email');
        $message = $this->input->post('message');
        $setting_detail = $this->db->select('*')->from('email_config')->get()->row();
        $subject = 'Mail Information';
        $customer_info = $this->db->select('*')->from('customer_information')->where('customer_email', $email)->get()->row();
        $data['customer_name'] = $customer_info->customer_name;

        // configure for upload 
        $config = array(
            'upload_path' => "./assets/data/email_file/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => TRUE,
//            'file_name' => "SPF" . time(),
            'max_size' => '0',
            'encrypt_name' => TRUE,
        );
//        echo $_FILES['attach']['name'];
        $image_data = array();
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('attach')) {
            $image_data = $this->upload->data();
//                print_r($image_data); die();
            $attach = $image_data['file_name'];
            $config['image_library'] = 'gd2';
            $config['source_image'] = $image_data['full_path']; //get original image
            $config['maintain_ratio'] = TRUE;
            $config['height'] = '*';
            $config['width'] = '*';
//                $config['quality'] = 50;
            $this->load->library('image_lib', $config);
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
            }
        } else {
            $attach = '';
        }
//        echo "D";
//        dd($attach);
//            ========= its for cv upload =========

        $custom_mail_data = array(
            'email_to' => $email,
            'message' => $message,
            'attach' => $attach,
        );
        $this->db->insert('custom_mail_tbl', $custom_mail_data);
        $last_mail_id = $this->db->insert_id();

        $config = Array(
            'protocol' => $setting_detail->protocol,
            'smtp_host' => $setting_detail->smtp_host,
            'smtp_port' => $setting_detail->smtp_port,
            'smtp_user' => $setting_detail->smtp_user,
            'smtp_pass' => $setting_detail->smtp_pass,
            'mailtype' => $setting_detail->mailtype,
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );
//        d($email);
//        dd($setting_detail);
        $data['get_mail_information'] = $this->db->select('*')->from('custom_mail_tbl')->where('id', $last_mail_id)->get()->row();
        if ($data['get_mail_information']->attach) {
            $file_path = getcwd() . '/assets/data/email_file/' . $data['get_mail_information']->attach;
        } else {
            $file_path = '';
        }
        $mesg = $this->load->view('customer/send_custom_email', $data, TRUE);
//        dd($file_path);
        $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
        $this->email->set_header('Content-type', 'text/html');

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($setting_detail->smtp_user, "Support Center");
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->attach($file_path);
// $this->email->message("Dear $name ,\nYour order submitted successfully!"."\n\n"
// . "\n\nThanks\nMetallica Gifts");
// $this->email->message($mesg. "\n\n http://metallicagifts.com/mcg/verify/" . $verificationText . "\n" . "\n\nThanks\nMetallica Gifts");
        $this->email->message($mesg);
        $this->email->send();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Ccustomer/custom_email'));
    }

//    ============ its for customer_status ============
    public function customer_status() {
        $customer_id = $this->input->post('customer_id');
        $status = $this->input->post('status');
        $status_data = array(
            'status' => $status,
        );
        $this->db->where('customer_id', $customer_id)->update('customer_information', $status_data);
        $this->session->set_userdata('message', display('successfully_updated'));
//        redirect($_SERVER['HTTP_REFERER']);
    }
    
//    ======== its for customer_archive ==============
    public function customer_archive(){
        $this->load->model('Customers');
        $alldata = $this->input->post('all');
        #
        #pagination starts
        # 
        if (!empty($alldata)) {
            $perpagdata = $this->Customers->archive_customer_list_count();
        } else {
            $perpagdata = 10;
        }
        $config["base_url"] = base_url('Ccustomer/customer_archive/');
        $config["total_rows"] = $this->Customers->archive_customer_list_count();
//        dd($config["total_rows"]);
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        $pagenum = $page;
        #
        #pagination ends
        #  
        $content = $this->lcustomer->archive_customer_list($links, $config["per_page"], $page, $pagenum);
        $this->template->full_admin_html_view($content);
        
    }
//    ============ its for custom sms send ============
    public function custom_sms_send(){
        $gateway_id = 1; //$this->input->post('gateway');
        $to = $this->input->post('to');
        $teamplate = $this->input->post('message');
        //gate gateway_information
        $sms_gateway_info = $this->Web_settings->sms_gateway($gateway_id);
//        echo $sms_gateway_info[0]->provider_name;
//        dd($sms_gateway_info);
        // sent to gateway
        $this->smsgateway->send([
            'apiProvider' => $sms_gateway_info[0]->provider_name,
            'username' => $sms_gateway_info[0]->user,
            'password' => $sms_gateway_info[0]->password,
            'from' => $sms_gateway_info[0]->authentication,
            'to' => $to,
            'message' => $teamplate
        ]);

        // save delivary data
        $custom_smsdata = array(
            'gateway' => $sms_gateway_info[0]->provider_name,
            'from' => $sms_gateway_info[0]->authentication,
            'to' => $to,
            'message' => $teamplate,
            'created_date' => date("Y-m-d h:i:s"),
            'created_by' => $this->user_id,
        );
        $this->db->insert('custom_sms_tbl', $custom_smsdata);

        $this->session->set_flashdata('message', 'SMS send successfully!');
        redirect('Ccustomer/custom_sms');
    }


    //    ========== its for customeronkeyup_search =========
//    public function customeronkeyup_search() {
//        $keyword = $this->input->post('keyword');
//        $data['quotation_list'] = $this->Customers->quotationonkeyup_search($keyword);
////        echo '<pre>';        print_r($data['vehicle_list']);die();
//        $this->load->view('quotation/quotaionnkeyup_search', $data);
//    }

}
