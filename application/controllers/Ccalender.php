<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ccalender extends CI_Controller {

    public $menu;

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('session');
        $this->load->model('Calender_model');
        $this->load->model('Jobs_model');
        $this->auth->check_admin_auth();
    }

    // Job Form
    public function add_booking() {
        $data['title'] = display('add_booking');
        $data['followup'] = $this->Calender_model->followups_data();
        $data['vehicles'] = $this->Calender_model->vehicle_list();
        $data['customers'] = $this->Calender_model->customer_list();

        $content = $this->parser->parse('calender/add_booking', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ========== its for  insert_quotation =============
    public function insert_booking() {
        $title = $this->input->post('title');
        $bookingtime = $this->input->post('bookingtime');
        $customer_id = $this->input->post('customer_id');
        $vehicle_reg = $this->input->post('registration_no');
        $booking_by = $this->session->userdata('user_id');

        $bookingdata = array(
            'booking_time' => $bookingtime,
            'title' => $title,
            'booking_by' => $booking_by,
            'customer_id' => $customer_id,
            'registration_no' => $vehicle_reg,
            'status' => 0,
        );
        // dd($bookingdata);
        if ($this->Calender_model->booking_create($bookingdata)) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
        } else {
            $this->session->set_userdata(array('error_message' => display('please_try_again')));
        }

        redirect(base_url('Ccalender/manage_booking'));
    }

//    ============= its for  manage quotation ============
    public function manage_booking() {
        $data['title'] = display('manage_booking');
        $config["base_url"] = base_url('Ccalender/manage_booking/');
        $config["total_rows"] = $this->Calender_model->count_booking();
        $config["per_page"] = 15;
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
        $data['manage_booking'] = $this->Calender_model->manage_booking($limit, $page);
        $data['links'] = $this->pagination->create_links();
        $data['pagenum'] = $page;

        $content = $this->parser->parse('calender/manage_booking', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // calendar
    public function calendar() {
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
//        echo $user_id. " ". $user_type; die();
        $data['title'] = display('calender');
        $data['followup'] = $this->Calender_model->followups_data();
        $data['booking'] = $this->Calender_model->booking_data($user_id, $user_type);
        $data['courtesy'] = $this->Calender_model->courtesy_booking_data($user_id, $user_type);
        $data['vehicles'] = $this->Calender_model->vehicle_list();
        $data['customers'] = $this->Calender_model->customer_list();
        $content = $this->parser->parse('calender/calendar', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // Booking Confirmation

    public function bookin_confirmation() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $btime = $this->input->post('btime');
        if ($status == 1) {
            $st = 0;
        } else {
            $st = 1;
        }

        $bcheck = $this->db->select('*')->from('booking_tbl')->where('id', $id)->where('booking_time', $btime)->where('status', 1)->get()->num_rows();
        $data = array(
            'status' => $st,
        );
        if ($bcheck < 2) {
            $this->db->where('id', $id);
            $this->db->update('booking_tbl', $data);
            $returndata = array(
                'result' => true,
                'status' => $data['status'],
            );
        } else {
            $returndata = array(
                'result' => false,
            );
        }
        echo json_encode($returndata);
    }

    // booking delete 
    public function delete_booking($id = null) {
        if ($this->Calender_model->booking_delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('error_message', display('please_try_again'));
        }
        redirect(base_url('Ccalender/manage_booking'));
    }

    // Bookign Edit Data
    public function booking_edit_data($id = null) {
        $data['title'] = display('edit_booking');
        $data['vehicles'] = $this->Calender_model->vehicle_list();
        $data['customers'] = $this->Calender_model->customer_list();

        $data['booking'] = $this->Calender_model->booking_editdata($id);
        $content = $this->parser->parse('calender/booking_edit', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // Update Booking
    public function update_booking() {
        $title = $this->input->post('title');
        $bookingtime = $this->input->post('bookingtime');
        $customer_id = $this->input->post('customer_id');
        $registration_no = $this->input->post('registration_no');

        $bookingdata = array(
            'id' => $this->input->post('id'),
            'booking_time' => $bookingtime,
            'title' => $title,
            'customer_id' => $customer_id,
            'registration_no' => $registration_no,
        );
        if ($this->Calender_model->booking_update($bookingdata)) {
            $this->session->set_userdata(array('message' => display('successfully_updated')));
        } else {
            $this->session->set_userdata(array('error_message' => display('please_try_again')));
        }

        redirect(base_url('Ccalender/manage_booking'));
    }

// Courtesy Vehicle Booking form
    public function add_courtesy_booking() {
        $data['title'] = display('add_courtesy_booking');
        $data['vehicles'] = $this->Calender_model->vehicle_list();
        $data['customers'] = $this->Calender_model->customer_list();
        $content = $this->parser->parse('calender/add_courtesy_booking', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // Insert Courtesy Booking
    public function insert_courtesy_booking() {
        $title = $this->input->post('title');
        $vehicle_reg = $this->input->post('vehicle_reg');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $booking_by = $this->session->userdata('user_id');
//        dd($vehicle_reg);
        $bookingdata = array(
            'vehicle_reg' => $vehicle_reg,
            'customer_id' => $this->input->post('customer_id'),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'title' => $title,
            'booking_by' => $booking_by,
            'status' => 1,
        );
//        dd($bookingdata);
        if ($this->Calender_model->courtesy_booking_create($bookingdata)) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
        } else {
            $this->session->set_userdata(array('error_message' => display('please_try_again')));
        }

        redirect(base_url('Ccalender/add_courtesy_booking'));
    }

    // Manage Courtesy Booking
    public function manage_courtesy_booking() {
        $data['title'] = display('manage_courtesy_booking');
        $config["base_url"] = base_url('Ccalender/manage_courtesy_booking/');
        $config["total_rows"] = $this->Calender_model->count_courtesybooking();
//        dd($config["total_rows"]);
//        $config["total_rows"] = $this->db->count_all('courtesy_booking');
        $config["per_page"] = 15;
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
        $data['manage_booking'] = $this->Calender_model->manage_courtesy_booking($limit, $page);
        $data['links'] = $this->pagination->create_links();
        $data['pagenum'] = $page;

        $content = $this->parser->parse('calender/manage_courtesy_booking', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // courtesy booking delete 
    public function delete_courtesy_booking($id = null) {
        if ($this->Calender_model->courtesy_booking_delete($id)) {
            #set success message
            $this->session->set_flashdata('message', display('delete_successfully'));
        } else {
            #set exception message
            $this->session->set_flashdata('error_message', display('please_try_again'));
        }
        redirect(base_url('Ccalender/manage_courtesy_booking'));
    }

    // Courtesy Bookign Edit Data
    public function courtesy_booking_edit_data($id = null) {
        $data['title'] = display('edit_courtesy_booking');
        $data['booking'] = $this->Calender_model->courtesy_booking_editdata($id);
        $data['customers'] = $this->Calender_model->customer_list();
        $data['vehicles'] = $this->Calender_model->vehicle_list();
        $content = $this->parser->parse('calender/courtesy_booking_edit', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // Update Courtesy Booking
    public function update_courtesy_booking() {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $vehicle_reg = $this->input->post('vehicle_reg');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $booking_by = $this->session->userdata('user_id');

        $bookingdata = array(
            'id' => $id,
            'customer_id' => $this->input->post('customer_id'),
            'vehicle_reg' => $vehicle_reg,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'title' => $title,
        );

        if ($this->Calender_model->courtesy_booking_update($bookingdata)) {
            $this->session->set_userdata(array('message' => display('successfully_updated')));
        } else {
            $this->session->set_userdata(array('error_message' => display('please_try_again')));
        }

        redirect(base_url('Ccalender/manage_courtesy_booking'));
    }

    public function courtesy_booking_check() {
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $reg_no = $this->input->post('reg_no');
        $booked = $this->db->select('*')
                ->from("courtesy_booking")
                ->where('vehicle_reg', $reg_no)
                ->where("start_date <=", $startdate)
                ->where("end_date >=", $enddate)
                ->get()
                ->result();
//        echo $this->db->last_query();
        $html = "";
        if ($booked) {

            $html .= "<table id=\"dataTableExample2\" class=\"table table-bordered table-striped table-hover\"><caption class=\"text-center\" style=\"font-size:15px;color:red\">Already Booked Information</caption>
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                       <tbody>";
            $i = 1;
            foreach ($booked as $key => $book) {
                $html .= "<tr>
                                <td>$i</td>
                                <td>$book->start_date</td>
                                <td>$book->end_date</td>
                            </tr>";
                $i++;
            }
            $html .= "</tbody>
                    </table>";
        }


        echo $html;
    }

//    ========== its for customer_wise_vehicle_info ===========
    public function customer_wise_vehicle_info() {
        $customer_id = $this->input->post('customer_id');
        $customer_wise_vehicle_info = $this->db->select('*')->from('vehicle_information')->where('customer_id', $customer_id)->get()->result();
        echo json_encode($customer_wise_vehicle_info);
    }

    //    ========== its for  instant Booking from dashboard =============
    public function instant_insert_booking() {
        $title = $this->input->post('title');
        $seldate = $this->input->post('selectdate');
        $bookingtime = date("Y-m-d", strtotime(!empty($seldate) ? $seldate : date('Y-m-d')));
//        $btime = $bookingtime . ' ' . $this->input->post('btime');
        $btime = $this->input->post('btime');
        $booking_by = $this->session->userdata('user_id');
        $b_type = $this->input->post('btype');
        $customer_id = $this->input->post('customer_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $reg_no = $this->input->post('vehicle_reg');
        $booking_customer_id = $this->input->post('booking_customer_id');
        $registration_no = $this->input->post('registration_no');


        $bookingdata = array(
            'booking_time' => $btime,
            'title' => $title,
            'booking_by' => $booking_by,
            'customer_id' => $booking_customer_id,
            'registration_no' => $registration_no,
            'status' => 1,
        );
//        dd($bookingdata);        exit();
        $courtesy_bookingdata = array(
            'customer_id' => $customer_id,
            'vehicle_reg' => $reg_no,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'booking_by' => $booking_by,
            'title' => $title,
            'status' => 1,
        );
        if ($b_type == 1) {
            $this->db->insert('booking_tbl', $bookingdata);
            $status['status'] = true;
            $status['message'] = 'Booking Successfully Added';
        }
        if ($b_type == 2) {
            $this->db->insert('courtesy_booking', $courtesy_bookingdata);
            $status['status'] = true;
            $status['message'] = 'Booking Successfully Added';
        }

//        echo json_encode($status);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect('Ccalender/calendar');
    }

    // Normal booking check from calendar
    public function n_booking_check() {
        $date = $this->input->post('date');
        $time = $this->input->post('time');
        $bookingtime = date("Y-m-d", strtotime(!empty($date) ? $date : date('Y-m-d')));
        $btime = $bookingtime . ' ' . $time;
        $booked = $this->db->select('*')
                ->from("booking_tbl")
                ->where("booking_time", $btime)
                ->get()
                ->result();
        if (!empty($booked)) {
            $status['status'] = true;
            $status['message'] = 'Booking Successfully Added';
        } else {
            $status['status'] = false;
            $status['message'] = 'Sorry to Say';
        }

        echo json_encode($status);
    }

    //    ========== its for bookingonkeyup_search =========
    public function bookingonkeyup_search() {
        $keyword = $this->input->post('keyword');
        $data['manage_booking'] = $this->Calender_model->bookingonkeyup_search($keyword);
//        echo '<pre>';        print_r($data['vehicle_list']);die();
        $this->load->view('calender/booking_search', $data);
    }

    //    ========== its for courtesybookingonkeyup_search =========
    public function courtesybookingonkeyup_search() {
        $keyword = $this->input->post('keyword');
        $data['manage_booking'] = $this->Calender_model->courtesybookingonkeyup_search($keyword);
//        echo '<pre>';        print_r($data['vehicle_list']);die();
        $this->load->view('calender/courtesybooking_search', $data);
    }

    //    ========== its for courtesybookingdate_search =========
    public function courtesybookingdate_search() {
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
//        echo $startdate." ss ".$enddate;exit();
        $data['manage_booking'] = $this->Calender_model->courtesybookingdate_search($startdate, $enddate);
//        echo '<pre>';        print_r($data['vehicle_list']);die();
        $this->load->view('calender/courtesybooking_search', $data);
    }

}
