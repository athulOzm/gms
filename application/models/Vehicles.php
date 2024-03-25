<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vehicles extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //    ============ its for vehicle_list ==========
    public function vehicle_list($offset, $limit) {
        $query = $this->db->select('a.*, b.customer_name')
                        ->from('vehicle_information a')
                        ->join('customer_information b', 'b.customer_id = a.customer_id')
                        ->order_by('a.vehicle_id', 'desc')
                        ->limit($offset, $limit)
                        ->get()->result();
        return $query;
    }

    //    ============ its for own_vehicle_list ==========
    public function own_vehicle_list($offset, $limit, $user_id) {
        $query = $this->db->select('a.*, b.customer_name')
                        ->from('vehicle_information a')
                        ->join('customer_information b', 'b.customer_id = a.customer_id')
                        ->where('a.customer_id', $user_id)
                        ->order_by('a.vehicle_id', 'desc')
                        ->limit($offset, $limit)
                        ->get()->result();
        return $query;
    }

    //vehicles List count
    public function vehicles_list_count() {
        $this->db->select('*');
        $this->db->from('vehicle_information');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    //vehicles Search Item
    public function vehicles_search_item($vehicle_id) {
        $this->db->select('*');
        $this->db->from('vehicle_information');
        $this->db->where('vehicle_id', $vehicle_id);
        $this->db->limit('500');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Count vehicles
    public function vehicles_entry($data) {
        $this->db->select('*');
        $this->db->from('product_vehicles');
        $this->db->where('vehicles_name', $data['vehicles_name']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $this->db->insert('vehicle_information', $data);
            return TRUE;
        }
    }

    //Retrieve vehicles Edit Data
    public function retrieve_vehicles_editdata($vehicle_id) {
        $this->db->select('*');
        $this->db->from('vehicle_information');
        $this->db->where('vehicle_id', $vehicle_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Update vehicles
    public function update_vehicles($data, $vehicle_id) {
        $this->db->where('vehicle_id', $vehicle_id);
        $this->db->update('vehicle_information', $data);
        return true;
    }

    // Delete vehicles Item
    public function delete_vehicles($vehicle_id) {
        $this->db->where('vehicle_id', $vehicle_id);
        $this->db->delete('vehicle_information');
        return true;
    }

    // Customer list
    public function customer_list() {
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('status', 1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // owner customer info 
    public function owner_customer_info($user_id) {
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('customer_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

//    ================ its for get_vehicletype ============= 
    public function get_vehicletype() {
        $query = $this->db->select('*')
                        ->from('vehicle_type_tbl')
                        ->order_by('vehicle_type', 'asc')
                        ->get()->result();
        return $query;
    }

//    ============== its for edit_vehicle_data ===========
    public function edit_vehicle_data($vehicle_id) {
        $query = $this->db->select('*')
                        ->from('vehicle_information a')
                        ->where('a.vehicle_id', $vehicle_id)
                        ->get()->result();
        return $query;
    }

//    ========== its for get vehicls ===== 
    public function get_vehicles() {
        $query = $this->db->select('*')
                        ->from('vehicle_information a')
                        ->get()->result();
        return $query;
    }

//    ============= its for single_vehicle_show ============
    public function single_vehicle_show($vehicle_id) {
        $query = $this->db->select('a.*, b.customer_name')
                        ->from('vehicle_information a')
                        ->join('customer_information b', 'b.customer_id = a.customer_id')
                        ->where('a.vehicle_id', $vehicle_id)
                        ->get()->result();
        return $query;
    }

//    ============ its for own vehicle wise job ===========
    public function vehicle_wise_job($vehicle_id) {
        $query = $this->db->select('a.*, b.customer_name, c.vehicle_registration')
                        ->from('job a')
                        ->join('customer_information b', 'b.customer_id = a.customer_id')
                        ->join('vehicle_information c', 'c.vehicle_id = a.vehicle_id')
                        ->where('a.vehicle_id', $vehicle_id)
                        ->get()->result();
        return $query;
    }

    //    ========== its for b_level_menu_search ================
    public function get_search_result($keyword) {
        $query = $this->db->select('a.*, b.customer_name');
        $this->db->from('vehicle_information a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->like('b.customer_name', $keyword, 'both');
        $this->db->or_like('a.vehicle_registration', $keyword, 'both');
        $this->db->order_by('a.vehicle_id', 'desc');
        $this->db->limit(100);
        $query = $this->db->get()->result();
        return $query;
    }

//    ============ its for total_vehicle ===========
      public function total_vehicle($user_type, $user_id) {
//        echo $user_type.' x '.$user_id;
        $this->db->select('count(vehicle_id) as ttl_vehicle');
        $this->db->from('vehicle_information');
        if ($user_type == 3) {
            $this->db->where('customer_id', $user_id);
        }
//        $this->db->where('status', 3);
       $query = $this->db->get();
        return $query->result();
    }
}
