<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Units extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

//    =========== its for unit check and insert start ===============
    public function insert_unit($data) {
        $this->db->select('*');
        $this->db->from('units');
        $this->db->where('status', 1);
        $this->db->where('unit_name', $data['unit_name']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $this->db->insert('units', $data);
            return TRUE;
        }
    }

//    =========== its for unit check and insert close ===============
//    =========== its for unit list show start ===============
    public function unit_list() {
        $this->db->select('*');
        $this->db->from('units');
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

//    =========== its for unit list show close ===============
//    =========== its for unit editable data show start ===============
    public function retrieve_unit_editdata($unit_id) {
        $this->db->select('*');
        $this->db->from('units');
        $this->db->where('unit_id', $unit_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

//    =========== its for unit editable data show close ===============
//    =========== its for unit update start  ===============
    public function unit_update($data, $unit_id) {
        $this->db->where('unit_id', $unit_id);
        $this->db->update('units', $data);
        return TRUE;
    }

//    =========== its for unit update close  ===============
//    =========== its for unit unit delete start  ===============
    public function unit_delete($unit_id) {
        $this->db->where('unit_id', $unit_id);
        $this->db->delete('units');
        return TRUE;
    }

//    =========== its for unit unit delete close  ===============
//    //customer List
//    public function category_list() {
//        $this->db->select('*');
//        $this->db->from('product_category');
//        $this->db->where('status', 1);
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        }
//        return false;
//    }
//
//    //customer List
//    public function category_list_product() {
//        $this->db->select('*');
//        $this->db->from('product_category');
//        $this->db->where('status', 1);
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        }
//        return false;
//    }
//
//    //customer List
//    public function category_list_count() {
//        $this->db->select('*');
//        $this->db->from('product_category');
//        $this->db->where('status', 1);
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->num_rows();
//        }
//        return false;
//    }
//
//    //Category Search Item
//    public function category_search_item($category_id) {
//        $this->db->select('*');
//        $this->db->from('product_category');
//        $this->db->where('category_id', $category_id);
//        $this->db->limit('500');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        }
//        return false;
//    }
//
//    //Count customer
//    public function category_entry($data) {
//        $this->db->select('*');
//        $this->db->from('product_category');
//        $this->db->where('status', 1);
//        $this->db->where('category_name', $data['category_name']);
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return FALSE;
//        } else {
//            $this->db->insert('product_category', $data);
//            return TRUE;
//        }
//    }
//
//    //Retrieve customer Edit Data
//    public function retrieve_category_editdata($category_id) {
//        $this->db->select('*');
//        $this->db->from('product_category');
//        $this->db->where('category_id', $category_id);
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        }
//        return false;
//    }
//
//    //Update Categories
//    public function update_category($data, $category_id) {
//        $this->db->where('category_id', $category_id);
//        $this->db->update('product_category', $data);
//        return true;
//    }
//
//    // Delete customer Item
//    public function delete_category($category_id) {
//        $this->db->where('category_id', $category_id);
//        $this->db->delete('product_category');
//        return true;
//    }
}
