<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_dashboard extends CI_Controller {

    private $user_id;
    private $user_type;

    function __construct() {
        parent::__construct();
        $this->template->current_menu = 'home';
        $this->load->model('Web_settings');
        $this->load->model('Reports');
        $this->load->model('Customers');
        $this->user_id = $this->session->userdata('user_id');
        $this->user_type = $this->session->userdata('user_type');
    }

    public function index() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $CI->load->library('occational');
        if (!$this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
        $this->auth->check_admin_auth();
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        $CI->load->model('Customers');
        $CI->load->model('Products');
        $CI->load->model('Suppliers');
        $CI->load->model('Invoices');
        $CI->load->model('Purchases');
        $CI->load->model('Reports');
        $CI->load->model('Accounts');
        $CI->load->model('Web_settings');
        $CI->load->model('Jobs_model');
        $CI->load->model('Vehicles');
        $CI->load->model('Payment');
        $CI->load->model('Calender_model');
        $CI->load->model('Service');
        $CI->load->model('Employee');
        $total_customer = $CI->Customers->count_customer();
//        $completed_job = $CI->Jobs_model->completed_job($this->user_type, $this->user_id);
//        $declined_job = $CI->Jobs_model->declined_job($this->user_type, $this->user_id);
        $job_complet_declinedstatus = $CI->Jobs_model->job_complet_declinedstatus($this->user_type, $this->user_id);
        $total_vehicle = $CI->Vehicles->total_vehicle($this->user_type, $this->user_id);
        $total_product = $CI->Products->count_product();
        $total_suppliers = $CI->Suppliers->count_supplier();
        $total_sales = $CI->Invoices->count_invoice();
        $total_purchase = $CI->Purchases->count_purchase();
        $todays_sales_report = $CI->Invoices->todays_sales_report();
        $this->Accounts->accounts_summary(1);
        $total_expese = $this->Accounts->sub_total;
        $monthly_sales_report = $CI->Reports->monthly_sales_report();
        $sales_report = $CI->Reports->todays_total_sales_report();
        $purchase_report = $CI->Reports->todays_total_purchase_report();
        $todays_sale_product = $CI->Reports->todays_sale_product();
        $total_profit = ($sales_report[0]['total_sale'] - $sales_report[0]['total_supplier_rate']);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $best_sales_product = $CI->Invoices->best_sales_products();
        if ($this->user_type == 3) {
            $customer_infodata = $CI->Reports->customer_infodata($this->user_id);
        }
        $current_date = date('Y-m-d');
        if ($this->user_type == 3) {
            $upcoming_service = $this->Service->owner_upcoming_service($this->user_id, $current_date);
        } else {
            $upcoming_service = $this->Service->upcoming_service($current_date);
        }
        $jobtype_productivity = $this->Employee->jobtype_productivity($user_type, $user_id);
        $get_allproducts = $this->Products->get_allproducts();

//        echo '<pre>';        print_r($get_allproducts);die();
//        ============ its for calender ============
//        echo $user_id. " ". $user_type; die();
        $data['title'] = display('calender');
        $followup = $this->Calender_model->followups_data();
        $booking = $this->Calender_model->booking_data($user_id, $user_type);
        $courtesy = $this->Calender_model->courtesy_booking_data($user_id, $user_type);
        $vehicles = $this->Calender_model->vehicle_list();
        $customers = $this->Calender_model->customer_list();
//        ============ its for calender close============

        $data = array(
            'title' => display('dashboard'),
            'total_customer' => $total_customer,
            'total_product' => $total_product,
            'total_suppliers' => $total_suppliers,
            'total_sales' => $total_sales,
            'total_purchase' => $total_purchase,
            'ttl_completejob' => $job_complet_declinedstatus[0]->ttl_completejob,
            'ttl_declinedjob' => $job_complet_declinedstatus[0]->ttl_declinedjob,
            'ttl_acceptedjob' => $job_complet_declinedstatus[0]->ttl_acceptedjob,
            'ttl_vehicle' => $total_vehicle[0]->ttl_vehicle,
            'todays_sales_report' => $todays_sales_report,
            'purchase_amount' => number_format($sales_report[0]['total_supplier_rate'], 2, '.', ','),
            'sales_amount' => number_format($sales_report[0]['total_amt'], 2, '.', ','),
            'total_expese' => $total_expese,
            'todays_sale_product' => $todays_sale_product,
            'todays_total_purchase' => number_format($purchase_report[0]['ttl_purchase_amount'], 2, '.', ','),
            'total_profit' => number_format($total_profit, 2, '.', ','),
            'monthly_sales_report' => $monthly_sales_report,
            'best_sales_product' => $best_sales_product,
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
            'completed_services' => @$customer_infodata->completed_services,
            'total_payment' => @$customer_infodata->total_payment,
            'total_bill' => @$customer_infodata->total_bill,
            'total_vehicle' => @$customer_infodata->total_vehicle,
            'followup' => $followup,
            'booking' => $booking,
            'courtesy' => $courtesy,
            'vehicles' => $vehicles,
            'customers' => $customers,
            'upcoming_service' => $upcoming_service,
            'jobtype_productivity' => $jobtype_productivity,
            'get_allproducts' => $get_allproducts,
        );

        $content = $CI->parser->parse('include/admin_home', $data, true);
        $this->template->full_admin_html_view($content);
    }
//    ============= its for jobstatus_monthyear ===========
    public function jobstatus_monthyear(){ 
        $CI = & get_instance();
        $CI->load->model('Jobs_model');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $data['job_complet_declinedstatus_yearmonth'] = $this->Jobs_model->job_complet_declinedstatus_yearmonth($this->user_type, $this->user_id, $month, $year);
//        d($job_complet_declinedstatus_yearmonth);
        $this->load->view('include/yearmonth_jobstatus',$data);
    }
//    ============= its for jobstatus_monthyear ===========
    public function productstatus_monthyear(){ 
        $CI = & get_instance();
        $CI->load->model('Products');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
//        echo $month." ".$year;
        $data['get_allproducts'] = $this->Products->productstatus_monthyear($month, $year);
//        d($data['get_allproducts']);
        $this->load->view('include/productstatus_monthyear',$data);
    }

//    ============ its for see_all_best_sales =============
    public function see_all_best_sales() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $CI->load->library('occational');
        if (!$this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');

        $best_saler_product_list = $CI->Invoices->best_saler_product_list();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $this->Reports->retrieve_company();
//        dd($company_info);
        $data = array(
            'title' => display('dashboard'),
            'best_saler_product_list' => $best_saler_product_list,
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
            'company_info' => $company_info,
        );

        $content = $CI->parser->parse('report/best_saler_product_list', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============ its for todays_customer_receipt =============
    public function todays_customer_receipt() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $CI->load->library('occational');
        if (!$this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $today = date('Y-m-d');

        $company_info = $CI->Customers->retrieve_company();
        $all_customer = $this->db->select('*')->from('customer_information')->get()->result();
        $todays_customer_receipt = $CI->Invoices->todays_customer_receipt($today);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
//        echo '<pre>';        print_r($todays_customer_receipt);die();
        $data = array(
            'title' => "Received From Customer",
            'all_customer' => $all_customer,
            'todays_customer_receipt' => $todays_customer_receipt,
            'today' => $today,
            'company_info' => $company_info,
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
            'software_info' => $currency_details,
            'company' => $company_info,
        );

        $content = $CI->parser->parse('report/todays_customer_receipt', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============ its for todays_customer_receipt =============
    public function filter_customer_wise_receipt() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $CI->load->library('occational');
        if (!$this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $customer_id = $this->input->post('customer_id');
        $from_date = $this->input->post('from_date');
        $today = date('Y-m-d');

        $company_info = $CI->Customers->retrieve_company();
        $all_customer = $this->db->select('*')->from('customer_information')->get()->result();
        $filter_customer_wise_receipt = $CI->Invoices->filter_customer_wise_receipt($customer_id, $from_date);
        $todays_customer_receipt = $CI->Invoices->todays_customer_receipt($today);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
//        echo '<pre>';        print_r($filter_customer_wise_receipt);die();
        $data = array(
            'title' => "Received From Customer",
            'all_customer' => $all_customer,
            'todays_customer_receipt' => $filter_customer_wise_receipt,
            'today' => $today,
            'company_info' => $company_info,
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
            'software_info' => $currency_details,
            'company' => $company_info,
        );

        $content = $CI->parser->parse('report/todays_customer_receipt', $data, true);
        $this->template->full_admin_html_view($content);
    }

    //Today All Report
    public function all_report() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        if (!$this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
        $user_type = $this->session->userdata('user_type');
        $content = $CI->lreport->retrieve_all_reports();
        $this->template->full_admin_html_view($content);
    }

    #==============Todays_sales_report============#

    public function todays_sales_report() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $this->auth->check_admin_auth();

        #
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/todays_sales_report/');
        $config["total_rows"] = $this->Reports->todays_sales_report_count();
        $config["per_page"] = 50;
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

        $content = $CI->lreport->todays_sales_report($links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

    // ========================= User Sales Report ==================
    #==============Todays_sales_report============#

    public function user_sales_report() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $star_date = (!empty($this->input->get('from_date')) ? $this->input->get('from_date') : date('Y-m-d'));
        $end_date = (!empty($this->input->get('to_date')) ? $this->input->get('to_date') : date('Y-m-d'));
        $this->auth->check_admin_auth();
        #
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/user_sales_report/');
        $config["total_rows"] = $this->Reports->user_sales_count($star_date, $end_date);
        $config["per_page"] = 50;
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

        $content = $CI->lreport->user_sales_report($links, $config["per_page"], $page, $star_date, $end_date);
        $this->template->full_admin_html_view($content);
    }

    #================todays_purchase_report========#

    public function todays_purchase_report() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $this->auth->check_admin_auth();

        #
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/todays_purchase_report/');
        $config["total_rows"] = $this->Reports->todays_sales_report_count();
        $config["per_page"] = 50;
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

        $content = $CI->lreport->todays_purchase_report($links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

    #=============Total purchase_report_category_wise ===================#

    public function purchase_report_category_wise() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $this->auth->check_admin_auth();

        #        #pagination starts        #
        $config["base_url"] = base_url('Admin_dashboard/purchase_report_category_wise/');
        $config["total_rows"] = $this->Reports->purchase_report_category_wise_count();
        $config["per_page"] = 50;
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

        #        #pagination ends        # 

        $content = $CI->lreport->purchase_report_category_wise($links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

//    ========= its for filter_purchase_report_category_wise ==============
    public function filter_purchase_report_category_wise() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $category = $this->input->post('category');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $content = $this->lreport->filter_purchase_report_category_wise($category, $from_date, $to_date);
        $this->template->full_admin_html_view($content);
    }

//    ============== sales report category wise =================
    public function sales_report_category_wise() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $this->auth->check_admin_auth();

        #
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/sales_report_category_wise/');
        $config["total_rows"] = $this->Reports->sales_report_category_wise_count();
        $config["per_page"] = 50;
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

        $content = $CI->lreport->sales_report_category_wise($links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

//    ========= its for filter_sales_report_category_wise ==============
    public function filter_sales_report_category_wise() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $category = $this->input->post('category');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $content = $this->lreport->filter_sales_report_category_wise($category, $from_date, $to_date);
        $this->template->full_admin_html_view($content);
    }

    #=============Total profit report===================#

    public function total_profit_report() {
        $CI = & get_instance();
        $CI->load->library('lreport');
        $CI->load->model('Reports');
        $this->auth->check_admin_auth();

        #        #pagination starts        #
        $config["base_url"] = base_url('Admin_dashboard/total_profit_report/');
        $config["total_rows"] = $this->Reports->total_profit_report_count();
        $config["per_page"] = 50;
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
        $content = $this->lreport->total_profit_report($links, $config["per_page"], $page);

        $this->template->full_admin_html_view($content);
    }

    #============Date wise sales report==============#

    public function retrieve_dateWise_SalesReports() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        $alldata = $this->input->get('all');
        if (!empty($alldata)) {
            $perpagdata = $this->Reports->count_retrieve_dateWise_SalesReports($from_date, $to_date);
        } else {
            $perpagdata = 50;
        }
        $config["base_url"] = base_url('Admin_dashboard/retrieve_dateWise_SalesReports/');
        $config["total_rows"] = $this->Reports->count_retrieve_dateWise_SalesReports($from_date, $to_date);
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        $config['suffix'] = '?' . http_build_query($_GET, '', '&');
        $config['first_url'] = $config["base_url"] . $config['suffix'];
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

        $content = $CI->lreport->retrieve_dateWise_SalesReports($from_date, $to_date, $links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

// ===================== Due Report Start=============================

    public function retrieve_dateWise_DueReports() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $from_date = (!empty($this->input->get('from_date')) ? $this->input->get('from_date') : date('Y-m-d'));
        $to_date = (!empty($this->input->get('to_date')) ? $this->input->get('to_date') : date('Y-m-d'));
        $alldata = $this->input->get('all');
        if (!empty($alldata)) {
            $perpagdata = $this->Reports->count_retrieve_dateWise_SalesReports($from_date, $to_date);
        } else {
            $perpagdata = 50;
        }
        $config["base_url"] = base_url('Admin_dashboard/retrieve_dateWise_DueReports/');
        $config["total_rows"] = $this->Reports->count_retrieve_dateWise_SalesReports($from_date, $to_date);
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        $config['suffix'] = '?' . http_build_query($_GET, '', '&');
        $config['first_url'] = $config["base_url"] . $config['suffix'];
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

        $content = $CI->lreport->retrieve_dateWise_DueReports($from_date, $to_date, $links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

    // ====================  Due Report End ============================
    #==============Date wise purchase report=============#

    public function retrieve_dateWise_PurchaseReports() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $start_date = $this->input->get('from_date');
        $end_date = $this->input->get('to_date');
        #exit;
        #pagination starts
        #
         $alldata = $this->input->get('all');
        if (!empty($alldata)) {
            $perpagdata = $this->Reports->count_retrieve_dateWise_PurchaseReports($start_date, $end_date);
        } else {
            $perpagdata = 50;
        }
        $config["base_url"] = base_url('Admin_dashboard/retrieve_dateWise_PurchaseReports/');
        $config["total_rows"] = $this->Reports->count_retrieve_dateWise_PurchaseReports($start_date, $end_date);
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        $config['suffix'] = '?' . http_build_query($_GET, '', '&');
        $config['first_url'] = $config["base_url"] . $config['suffix'];
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
        $content = $CI->lreport->retrieve_dateWise_PurchaseReports($start_date, $end_date, $links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

    #==============Product sales report date wise===========#

    public function product_sales_reports_date_wise() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Reports');

        #
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/product_sales_reports_date_wise/');
        $config["total_rows"] = $this->Reports->retrieve_product_sales_report_count();
        $config["per_page"] = 50;
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
        $content = $this->lreport->get_products_report_sales_view($links, $config["per_page"], $page);

        $this->template->full_admin_html_view($content);
    }

    #==============Date wise purchase report=============#

    public function retrieve_dateWise_profit_report() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Reports');
        $start_date = $this->input->get('from_date');
        $end_date = $this->input->get('to_date');

        #
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/retrieve_dateWise_profit_report/');
        $config["total_rows"] = $this->Reports->retrieve_dateWise_profit_report_count($start_date, $end_date);
        $config["per_page"] = 50;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        $config['suffix'] = '?' . http_build_query($_GET, '', '&');
        $config['first_url'] = $config["base_url"] . $config['suffix'];
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
        $content = $this->lreport->retrieve_dateWise_profit_report($start_date, $end_date, $links, $config["per_page"], $page);

        $this->template->full_admin_html_view($content);
    }

    #==============Product sales search reports============#

    public function product_sales_search_reports() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Reports');
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');

        #
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/product_sales_search_reports/');
        $config["total_rows"] = $this->Reports->retrieve_product_search_sales_report_count($from_date, $to_date);
        $config["per_page"] = 50;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        $config['suffix'] = '?' . http_build_query($_GET, '', '&');
        $config['first_url'] = $config["base_url"] . $config['suffix'];
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
        $content = $this->lreport->get_products_search_report($from_date, $to_date, $links, $config["per_page"], $page);

        $this->template->full_admin_html_view($content);
    }

    #============User login=========#

    public function login() {
        if ($this->auth->is_logged()) {
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard', TRUE, 302);
        }
        $data['title'] = display('admin_login_area');
        $content = $this->parser->parse('user/admin_login_form', $data, true);
        $this->template->full_admin_html_view($content);
    }

    #==============Valid user check=======#

    public function do_login() {
        $error = '';
        $setting_detail = $this->Web_settings->retrieve_setting_editdata();

        if ($setting_detail[0]['captcha'] == 0 && $setting_detail[0]['secret_key'] != null && $setting_detail[0]['site_key'] != null) {

            $this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_validate_captcha');
            $this->form_validation->set_message('validate_captcha', 'Please check the the captcha form');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata(array('error_message' => display('please_enter_valid_captcha')));
                $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
            } else {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                if ($username == '' || $password == '' || $this->auth->login($username, $password) === FALSE) {
                    $error = display('wrong_username_or_password');
                }
                if ($error != '') {
                    $this->session->set_userdata(array('error_message' => $error));
                    $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
                } else {
                    $this->output->set_header("Location: " . base_url(), TRUE, 302);
                }
            }
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if ($username == '' || $password == '' || $this->auth->login($username, $password) === FALSE) {
                $error = display('wrong_username_or_password');
            }
            if ($error != '') {
                $this->session->set_userdata(array('error_message' => $error));
                $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
            } else {
                $this->output->set_header("Location: " . base_url(), TRUE, 302);
            }
        }
    }

    //Valid captcha check
    function validate_captcha() {
        $setting_detail = $this->Web_settings->retrieve_setting_editdata();
        $captcha = $this->input->post('g-recaptcha-response');
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $setting_detail[0]['secret_key'] . ".&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        if ($response . 'success' == false) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    #===============Logout=======#

    public function logout() {
        if ($this->auth->logout())
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }

    #=============Edit Profile======#

    public function edit_profile() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('luser');
        $content = $CI->luser->edit_profile_form();
        $this->template->full_admin_html_view($content);
    }

    #=============Update Profile========#

    public function update_profile() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Users');
        $this->Users->profile_update();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Admin_dashboard/edit_profile'));
    }

    #=============Change Password=========# 

    public function change_password_form() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $content = $CI->parser->parse('user/change_password', array('title' => display('change_password')), true);
        $this->template->full_admin_html_view($content);
    }

    #============Change Password===========#

    public function change_password() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Users');

        $error = '';
        $email = $this->input->post('email');
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('password');
        $repassword = $this->input->post('repassword');

        if ($email == '' || $old_password == '' || $new_password == '') {
            $error = display('blank_field_does_not_accept');
        } else if ($email != $this->session->userdata('user_email')) {
            $error = display('you_put_wrong_email_address');
        } else if (strlen($new_password) < 6) {
            $error = display('new_password_at_least_six_character');
        } else if ($new_password != $repassword) {
            $error = display('password_and_repassword_does_not_match');
        } else if ($CI->Users->change_password($email, $old_password, $new_password) === FALSE) {
            $error = display('you_are_not_authorised_person');
        }

        if ($error != '') {
            $this->session->set_userdata(array('error_message' => $error));
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/change_password_form', TRUE, 302);
        } else {
            $this->session->set_userdata(array('message' => display('successfully_changed_password')));
            $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/change_password_form', TRUE, 302);
        }
    }

    #==============Closing form==========#

    public function closing() {
        $CI = & get_instance();
        $CI->load->model('Reports');
        $data = array('title' => "Reports | Daily Closing");
        $data = $this->Reports->accounts_closing_data();
//        echo '<pre>';        print_r($data); die();
        $content = $this->parser->parse('accounts/closing_form', $data, true);
        $this->template->full_admin_html_view($content);
    }

    //Closing report
    public function closing_report() {
        $CI = & get_instance();
        $CI->load->library('laccounts');
        $content = $this->laccounts->daily_closing_list();
        $this->template->full_admin_html_view($content);
    }

    // Date wise closing reports 
    public function date_wise_closing_reports() {
        $CI = & get_instance();
        $CI->load->library('laccounts');
        $CI->load->model('Accounts');
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');

        #
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/date_wise_closing_reports/');
        $config["total_rows"] = $this->Accounts->get_date_wise_closing_report_count($from_date, $to_date);
        $config["per_page"] = 50;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        $config['suffix'] = '?' . http_build_query($_GET, '', '&');
        $config['first_url'] = $config["base_url"] . $config['suffix'];
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

        $content = $this->laccounts->get_date_wise_closing_reports($links, $config["per_page"], $page, $from_date, $to_date);

        $this->template->full_admin_html_view($content);
    }

    //password recovery 
    public function password_recovery() {
        $CI = & get_instance();
        $CI->load->model('Settings');
        $this->form_validation->set_rules('rec_email', display('email'), 'required|valid_email|max_length[100]|trim');
        $userData = array(
            'email' => $this->input->post('rec_email')
        );
        if ($this->form_validation->run()) {
            $user = $this->Settings->password_recovery($userData);
            $ptoken = date('ymdhis');
            if ($user->num_rows() > 0) {
                $email = $user->row()->username;
                $precdat = array(
                    'username' => $email,
                    'security_code' => $ptoken,
                );

                $this->db->where('username', $email)
                        ->update('user_login', $precdat);
                $send_email = '';
                if (!empty($email)) {
                    $send_email = $this->setmail($email, $ptoken);
                }
                if ($send_email) {
                    $user_data['success'] = 'check Your email';
                    $user_data['status'] = true;
                } else {
                    $user_data['exception'] = 'Sorry Email Not Send';
                    $user_data['status'] = false;
                }
            } else {
                $user_data['exception'] = 'Email Not found';
                $user_data['status'] = false;
            }
        } else {
            $user_data['exception'] = 'please try again';
            $user_data['status'] = false;
        }

        echo json_encode($user_data);
    }

    public function setmail($email, $ptoken) {
        $msg = "Click on this url for change your password :" . base_url() . 'Admin_dashboard/recovery_form/' . $ptoken;

// send email
        mail($email, "passwordrecovery", $msg);
        return true;
    }

    public function recovery_form($token_id) {
        $CI = & get_instance();
        $CI->load->model('Settings');
        $tokeninfo = $this->Settings->token_matching($token_id);
        if ($tokeninfo->num_rows() > 0) {
            $data['token'] = $token_id;
            $data['title'] = display('recovery_form');
            $this->load->view('user/user_recovery_form', $data);
        } else {
            redirect(base_url('Admin_dashboard/login'));
        }
    }

    public function recovery_update() {
        $token = $this->input->post('token');
        $newpassword = $this->input->post('newpassword');
        $userdata = array(
            'password' => md5("gef" . $newpassword),
            'security_code' => '001'
        );
        $this->db->where('security_code', $token)
                ->update('user_login', $userdata);
        redirect(base_url('Admin_dashboard/login'));
    }

    // Shipping cost report
    public function retrieve_dateWise_Shippingcost() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $from_date = (!empty($this->input->get('from_date')) ? $this->input->get('from_date') : date('Y-m-d'));
        $to_date = (!empty($this->input->get('to_date')) ? $this->input->get('to_date') : date('Y-m-d'));
        $alldata = $this->input->get('all');
        if (!empty($alldata)) {
            $perpagdata = $this->Reports->count_retrieve_dateWise_SalesReports($from_date, $to_date);
        } else {
            $perpagdata = 50;
        }
        $config["base_url"] = base_url('Admin_dashboard/retrieve_dateWise_Shippingcost/');
        $config["total_rows"] = $this->Reports->count_retrieve_dateWise_SalesReports($from_date, $to_date);
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        $config['suffix'] = '?' . http_build_query($_GET, '', '&');
        $config['first_url'] = $config["base_url"] . $config['suffix'];
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

        $content = $CI->lreport->retrieve_dateWise_shippingcost($from_date, $to_date, $links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

    //sales return list
    public function sales_return() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Reports');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $start = (!empty($from_date) ? $from_date : date('Y-m-d'));
        $end = (!empty($to_date) ? $to_date : date('Y-m-d'));
        #
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/sales_return/');
        $config["total_rows"] = $this->Reports->sales_return_count($start, $end);
        $config["per_page"] = 10;
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
        $content = $this->lreport->sales_return_data($links, $config["per_page"], $page, $start, $end);
        $this->template->full_admin_html_view($content);
    }

    // supplier return report
    public function supplier_return() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Reports');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $start = (!empty($from_date) ? $from_date : date('Y-m-d'));
        $end = (!empty($to_date) ? $to_date : date('Y-m-d'));
        #
        #pagination starts
        #
        $config["base_url"] = base_url('Admin_dashboard/supplier_return/');
        $config["total_rows"] = $this->Reports->count_supplier_return($start, $end);
        $config["per_page"] = 10;
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
        $content = $this->lreport->supplier_return_data($links, $config["per_page"], $page, $start, $end);
        $this->template->full_admin_html_view($content);
    }

    ///  TAX Report start
    public function retrieve_dateWise_tax() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $from_date = (!empty($this->input->get('from_date')) ? $this->input->get('from_date') : date('Y-m-d'));
        $to_date = (!empty($this->input->get('to_date')) ? $this->input->get('to_date') : date('Y-m-d'));
        $alldata = $this->input->get('all');
        if (!empty($alldata)) {
            $perpagdata = $this->Reports->count_retrieve_dateWise_SalesReports($from_date, $to_date);
        } else {
            $perpagdata = 50;
        }
        $config["base_url"] = base_url('Admin_dashboard/retrieve_dateWise_tax/');
        $config["total_rows"] = $this->Reports->count_retrieve_dateWise_SalesReports($from_date, $to_date);
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        $config['suffix'] = '?' . http_build_query($_GET, '', '&');
        $config['first_url'] = $config["base_url"] . $config['suffix'];
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

        $content = $CI->lreport->retrieve_dateWise_tax($from_date, $to_date, $links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

    //    =========== its for customer register ============
    public function customer_register() {
        $data['title'] = display('customer_register');

        $this->load->view('user/customer_register', $data);
//        $content = $this->parser->parse('user/customer_register', $data, true);
//        $this->template->full_admin_html_view($content);
    }

    //Insert Product and upload
    public function insert_customer() {
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
        $createby = 'out'; //$this->session->userdata('user_id');
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
            'sales_discount_status' => $this->input->post('sales_discount_status'),
            'markup_discount' => $this->input->post('markup_discount'),
            'role_id' => $this->input->post('role_id'),
            'is_outside' => 1,
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
//        $user_access_info = array(
//            'user_id' => $customer_id,
//            'roleid' => $this->input->post('role_id'),
//            'createby' => $this->user_id,
//            'createdate' => $createdate,
//        );
//        $this->db->insert('sec_userrole', $user_access_info);

        if ($result == TRUE) {
            //Previous balance adding -> Sending to customer model to adjust the data.
            $this->db->insert('acc_coa', $customer_coa);
            $this->Customers->previous_balance_add($this->input->post('previous_balance'), $customer_id);


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
            redirect(base_url('Admin_dashboard/customer_register'));
        }
    }

}
