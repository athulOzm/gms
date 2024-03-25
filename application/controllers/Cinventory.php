<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cinventory extends CI_Controller {

    public $menu;

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
//        $this->load->library('lcustomer');
        $this->load->library('session');
        $this->load->model('Employee');
        $this->load->model('Web_settings');
        $this->auth->check_admin_auth();
    }

    //Default loading for Customer System.
    public function index() {
        $content = $this->lcustomer->customer_add_form();
        $this->template->full_admin_html_view($content);
    }
    
//    ========= its for buying_report ===========
    public function buying_report() {
        $data['title'] = display('buying_report');
        $data['currency_details'] = $this->Web_settings->retrieve_setting_editdata();
        $config["base_url"] = base_url('Cinventory/buying_report/');
        $config["total_rows"] = $this->Employee->buying_report_count();
//        dd($config["total_rows"]);
//        $config["total_rows"] = $this->db->count_all('employee_history');
        $config["per_page"] = 50;
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
        $data['buying_report'] = $this->Employee->buying_report($limit, $page);
        $data['links'] = $this->pagination->create_links();
        $data['pagenum'] = $page;

        $content = $this->parser->parse('report/buying_report', $data, true);
        $this->template->full_admin_html_view($content);
    }

}