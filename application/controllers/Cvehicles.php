<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cvehicles extends CI_Controller {

    private $user_id = '';
    private $user_type = '';

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('session');
        $this->auth->check_admin_auth();
        $this->load->model('Vehicles');
        $this->user_id = $this->session->userdata('user_id');
        $this->user_type = $this->session->userdata('user_type');
    }

    // ================ by default create unit page load. =============
    public function add_vehicles() {
        $data['title'] = display('add_new_vehicles');
        $data['customers'] = $this->Vehicles->customer_list();
        $data['get_vehicletype'] = $this->Vehicles->get_vehicletype();
        $content = $this->parser->parse('vehicles/add_form', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ========== its for insert_vehicle =============
    public function insert_vehicle() {
        $customer_id = $this->input->post('customer_id');
        $vehicle_registration = $this->input->post('vehicle_registration');
        $year = $this->input->post('year');
        $seats = $this->input->post('seats');
        $make = $this->input->post('make');
        $cc_rating = $this->input->post('cc_rating');
        $model = $this->input->post('model');
        $fuel_type = $this->input->post('fuel_type');
        $color = $this->input->post('color');
        $assembly_type = $this->input->post('assembly_type');
        $second_color = $this->input->post('second_color');
        $country_of_origin = $this->input->post('country_of_origin');
        $sub_model = $this->input->post('sub_model');
        $gross_vehicle_mass = $this->input->post('gross_vehicle_mass');
        $body_style = $this->input->post('body_style');
        $tare_weight = $this->input->post('tare_weight');
        $vin = $this->input->post('vin');
        $axle = $this->input->post('axle');
//        $plate = $this->input->post('plate');
        $wheelbase = $this->input->post('wheelbase');
        $engine_no = $this->input->post('engine_no');
        $front_axle_group_rating = $this->input->post('front_axle_group_rating');
        $vehicle_type = $this->input->post('vehicle_type');
        $rear_axle_group_rating = $this->input->post('rear_axle_group_rating');

        $vehicle_information = array(
            'customer_id' => $customer_id,
            'vehicle_registration' => $vehicle_registration,
            'year' => $year,
            'make' => $make,
            'model' => $model,
            'color' => $color,
            'second_color' => $second_color,
            'sub_model' => $sub_model,
            'body_style' => $body_style,
            'vin' => $vin,
            'plate' => '',//$plate,
            'engine_no' => $engine_no,
            'vehicle_type' => $vehicle_type,
            'seat' => $seats,
            'cc_rating' => $cc_rating,
            'fuel_type' => $fuel_type,
            'assembly_type' => $assembly_type,
            'country_of_origin' => $country_of_origin,
            'gross_vehicle_mass' => $gross_vehicle_mass,
            'tyre_weight' => $tare_weight,
            'wheelbase' => $wheelbase,
            'axle' => $axle,
            'front_axle_rating' => $front_axle_group_rating,
            'rear_axle_rating' => $rear_axle_group_rating,
            'create_by' => $this->user_id,
            'create_date' => date('Y-m-d'),
        );
//        dd($vehicle_information);
        $this->db->insert('vehicle_information', $vehicle_information);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cvehicles/add_vehicles'));
    }

    // ================ its for vehicle list =============
    public function manage_vehicle() {
        $data['title'] = display('manage_vehicles');
        $config["base_url"] = base_url('admin/Cvehicles/manage_vehicle/');
        $config["total_rows"] = $this->db->count_all('vehicle_information');
        $config["per_page"] = 15;
        $config["uri_segment"] = 4;
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
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = $config["per_page"];
        if ($this->user_type == 1) {
            $data['vehicle_list'] = $this->Vehicles->vehicle_list($limit, $page);
        } elseif ($this->user_type == 3) {
            $data['vehicle_list'] = $this->Vehicles->own_vehicle_list($limit, $page, $this->user_id);
        }
        $data['links'] = $this->pagination->create_links();
        $data['pagenum'] = $page;

//        $data['customers'] = $this->Vehicles->customer_list();
//        $data['get_vehicletype'] = $this->Vehicles->get_vehicletype();
        $content = $this->parser->parse('vehicles/vehicle_list', $data, true);
        $this->template->full_admin_html_view($content);
    }

//     ======== its for edit_vehicle_form ============
    public function edit_vehicle_form($vehicle_id) {
        $data['get_vehicletype'] = $this->Vehicles->get_vehicletype();
        $data['customers'] = $this->Vehicles->customer_list();
        $data['edit_vehicle_data'] = $this->Vehicles->edit_vehicle_data($vehicle_id);

        $content = $this->parser->parse('vehicles/edit_vehicle_form', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============= its for update_vehicle ============
    public function update_vehicle() {
        $vehicle_id = $this->input->post('vehicle_id');
        $customer_id = $this->input->post('customer_id');
        $vehicle_registration = $this->input->post('vehicle_registration');
        $year = $this->input->post('year');
        $seats = $this->input->post('seats');
        $make = $this->input->post('make');
        $cc_rating = $this->input->post('cc_rating');
        $model = $this->input->post('model');
        $fuel_type = $this->input->post('fuel_type');
        $color = $this->input->post('color');
        $assembly_type = $this->input->post('assembly_type');
        $second_color = $this->input->post('second_color');
        $country_of_origin = $this->input->post('country_of_origin');
        $sub_model = $this->input->post('sub_model');
        $gross_vehicle_mass = $this->input->post('gross_vehicle_mass');
        $body_style = $this->input->post('body_style');
        $tare_weight = $this->input->post('tare_weight');
        $vin = $this->input->post('vin');
        $axle = $this->input->post('axle');
//        $plate = $this->input->post('plate');
        $wheelbase = $this->input->post('wheelbase');
        $engine_no = $this->input->post('engine_no');
        $front_axle_group_rating = $this->input->post('front_axle_group_rating');
        $vehicle_type = $this->input->post('vehicle_type');
        $rear_axle_group_rating = $this->input->post('rear_axle_group_rating');

        $vehicle_information = array(
            'customer_id' => $customer_id,
            'vehicle_registration' => $vehicle_registration,
            'year' => $year,
            'make' => $make,
            'model' => $model,
            'color' => $color,
            'second_color' => $second_color,
            'sub_model' => $sub_model,
            'body_style' => $body_style,
            'vin' => $vin,
            'plate' => '',//$plate,
            'engine_no' => $engine_no,
            'vehicle_type' => $vehicle_type,
            'seat' => $seats,
            'cc_rating' => $cc_rating,
            'fuel_type' => $fuel_type,
            'assembly_type' => $assembly_type,
            'country_of_origin' => $country_of_origin,
            'gross_vehicle_mass' => $gross_vehicle_mass,
            'tyre_weight' => $tare_weight,
            'wheelbase' => $wheelbase,
            'axle' => $axle,
            'front_axle_rating' => $front_axle_group_rating,
            'rear_axle_rating' => $rear_axle_group_rating,
            'update_by' => $this->user_id,
            'update_date' => date('Y-m-d'),
        );
//        dd($vehicle_information);
        $this->db->where('vehicle_id', $vehicle_id)->update('vehicle_information', $vehicle_information);
        $this->session->set_userdata(array('message' => display('update_successfully')));
        redirect(base_url('Cvehicles/add_vehicles'));
    }

//    =============== its for vehicle delete ===========
    public function vehicle_delete($vehicle_id) {
        $check_job_vehicle = $this->db->select('*')->from('job')->where('vehicle_id', $vehicle_id)->get()->result();
        if ($check_job_vehicle) {
            $this->session->set_userdata(array('error_message' => display('child_record_already_exists')));
            redirect(base_url('Cvehicles/manage_vehicle'));
        } else {
            $this->db->where('vehicle_id', $vehicle_id)->delete('vehicle_information');
            $this->session->set_userdata(array('message' => display('delete_successfully')));
            redirect(base_url('Cvehicles/manage_vehicle'));
        }
    }

//    =========== its for single_vehicle_show =============
    public function single_vehicle_show($vehicle_id){
        $data['title'] = display('vehicle_information');
        $data['single_vehicle_show'] = $this->Vehicles->single_vehicle_show($vehicle_id);

        $content = $this->parser->parse('vehicles/single_vehicle_show', $data, true);
        $this->template->full_admin_html_view($content);
    }
//    =========== its for own vehicle wise job =============
    public function vehicle_wise_job($vehicle_id){
        $data['title'] = display('vehicle_information');
        $data['single_vehicle_show'] = $this->Vehicles->single_vehicle_show($vehicle_id);
        $data['vehicle_wise_job'] = $this->Vehicles->vehicle_wise_job($vehicle_id);

        $content = $this->parser->parse('vehicles/vehicle_wise_job', $data, true);
        $this->template->full_admin_html_view($content);
    }
//    ============= its for vehicle_search =============
    public function vehicle_search(){
         $keyword = $this->input->post('keyword');
        $data['vehicle_list'] = $this->Vehicles->get_search_result($keyword);
//        echo '<pre>';        print_r($data['vehicle_list']);die();
        $this->load->view('vehicles/vehicle_search', $data);
    }
}
