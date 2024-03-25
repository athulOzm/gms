<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calender_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Booking insert
    public function booking_create($data = array()) {
        return $this->db->insert('booking_tbl', $data);
    }

//    ========== its for quotation_list ==============
    public function manage_booking($offset, $limit) {
        $this->db->select('a.*, b.first_name,last_name');
        $this->db->from('booking_tbl a');
        $this->db->join('users b', 'b.user_id = a.booking_by', 'left');
        if ($this->session->userdata('user_type') == 3) {
            $this->db->where('a.customer_id', $this->session->userdata('user_id'));
        }
        $this->db->order_by('a.id', 'desc');
        $this->db->limit($offset, $limit);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

// count booking info
    public function count_booking() {
        $this->db->select('a.*, b.first_name,last_name');
        $this->db->from('booking_tbl a');
        $this->db->join('users b', 'b.user_id = a.booking_by', 'left');
        if ($this->session->userdata('user_type') == 3) {
            $this->db->where('a.customer_id', $this->session->userdata('user_id'));
        }
        $this->db->order_by('a.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }
    
//          $this->db->select('a.*, b.first_name,last_name');
//        $this->db->from('courtesy_booking a');
//        $this->db->join('users b', 'b.user_id = a.booking_by', 'left');
//        if ($this->session->userdata('user_type') == 3) {
//            $this->db->where('a.customer_id', $this->session->userdata('user_id'));
//        }
//        $this->db->order_by('a.id', 'desc');
    
// count courtesy booking info
    public function count_courtesybooking() {
        $this->db->select('a.*, b.first_name,last_name');
        $this->db->from('courtesy_booking a');
        $this->db->join('users b', 'b.user_id = a.booking_by', 'left');
        if ($this->session->userdata('user_type') == 3) {
            $this->db->where('a.customer_id', $this->session->userdata('user_id'));
        }
        $this->db->order_by('a.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    public function followups_data() {
        $query = $this->db->select('*')
                ->from('follow_ups')
                ->get()
                ->result_array();
        return $query;
    }

    // Booking data for calendar
    public function booking_data($user_id, $user_type) {
        $this->db->select('*');
        $this->db->from('booking_tbl');
        $this->db->where('status', 1);
        if ($user_type == 3) {
            $this->db->where('customer_id', $user_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    // courtesy Booking Data
    public function courtesy_booking_data($user_id, $user_type) {
        $this->db->select('*');
        $this->db->from('courtesy_booking');
        $this->db->where('status', 1);
        if ($user_type == 3) {
            $this->db->where('customer_id', $user_id);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

// booking Delete
    public function booking_delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('booking_tbl');
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

// Booking Edit Data
    public function booking_editdata($id) {
        $query = $this->db->select('*')
                ->from('booking_tbl')
                ->where('id', $id)
                ->get()
                ->result_array();
        return $query;
    }

    // Booking update
    public function booking_update($data = array()) {
        $this->db->where('id', $data['id']);
        $this->db->Update('booking_tbl', $data);
        return true;
    }

    //Vehicle list for Courtesy booking
    public function vehicle_list() {
        $query = $this->db->select('*')
                ->from('vehicle_information')
//                ->where('customer_id', 'KV9SJO95VKZTT13')
                ->get()
                ->result_array();
        return $query;
    }

    // Courtesy Booking insert
    public function courtesy_booking_create($data = array()) {
        return $this->db->insert('courtesy_booking', $data);
    }

    //    ========== its for quotation_list ==============
    public function manage_courtesy_booking($offset, $limit) {
        $this->db->select('a.*, b.first_name,last_name');
        $this->db->from('courtesy_booking a');
        $this->db->join('users b', 'b.user_id = a.booking_by', 'left');
        if ($this->session->userdata('user_type') == 3) {
            $this->db->where('a.customer_id', $this->session->userdata('user_id'));
        }
        $this->db->order_by('a.id', 'desc');
        $this->db->limit($offset, $limit);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // courtesy booking Delete
    public function courtesy_booking_delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('courtesy_booking');
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    // Courtesy Booking Edit Data
    public function courtesy_booking_editdata($id) {
        $query = $this->db->select('*')
                ->from('courtesy_booking')
                ->where('id', $id)
                ->get()
                ->result_array();
        return $query;
    }

    // Booking update
    public function courtesy_booking_update($data = array()) {
        $this->db->where('id', $data['id']);
        $this->db->Update('courtesy_booking', $data);
        return true;
    }

    // Customer list
    public function customer_list() {
        $this->db->select('*');
        $this->db->from('customer_information');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //    ========== its for quotation_list ==============
    public function bookingonkeyup_search($keyword) {
        $this->db->select('a.*, b.first_name,last_name');
        $this->db->from('booking_tbl a');
        $this->db->join('users b', 'b.user_id = a.booking_by', 'left');
        if ($this->session->userdata('user_type') == 3) {
            $this->db->where('a.booking_by', $this->session->userdata('user_id'));
        }
        $this->db->like('a.title', $keyword);
        $this->db->order_by('a.id', 'desc');
        $this->db->limit(100);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //    ========== its for courtesybookingonkeyup_search ==============
    public function courtesybookingonkeyup_search($keyword) {
        $this->db->select('a.*, b.first_name,last_name');
        $this->db->from('courtesy_booking a');
        $this->db->join('users b', 'b.user_id = a.booking_by', 'left');
        if ($this->session->userdata('user_type') == 3) {
            $this->db->where('a.booking_by', $this->session->userdata('user_id'));
        }
        $this->db->like('a.title', $keyword, 'both');
        $this->db->or_like('a.vehicle_reg', $keyword, 'both');
        $this->db->order_by('a.id', 'desc');
        $this->db->limit(100);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //    ========== its for courtesybookingdate_search ==============
    public function courtesybookingdate_search($startdate, $enddate) {
        $this->db->select('a.*, b.first_name,last_name');
        $this->db->from('courtesy_booking a');
        $this->db->join('users b', 'b.user_id = a.booking_by', 'left');
        if ($this->session->userdata('user_type') == 3) {
            $this->db->where('a.customer_id', $this->session->userdata('user_id'));
        }
        $this->db->where('a.start_date >=', $startdate);
        $this->db->where('a.end_date <=', $enddate);
        $this->db->order_by('a.id', 'desc');
        $this->db->limit(100);
        $query = $this->db->get();
//        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

}
