<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

//    ============= its for allmechanic ===============
    public function allmechanic($offset, $limit) {
        $this->db->select('*');
        $this->db->from('employee_history a');
        $this->db->order_by('id', 'desc');
        $this->db->limit($offset, $limit);
        $query = $this->db->get()->result();
        return $query;
    }

//    =========== its for buying report ======
    public function buying_report($per_page = null, $page = null) {
        $this->db->select('b.product_name, b.product_model, SUM(a.quantity) as quantity, SUM(a.total_amount) as total_amount, c.purchase_date, d.supplier_price');
        $this->db->group_by('b.product_id');
        $this->db->from('product_purchase_details a');
        $this->db->join('product_information b', 'b.product_id = a.product_id');
        $this->db->join('product_purchase c', 'c.purchase_id = a.purchase_id');
        $this->db->join('supplier_product d', 'd.product_id = a.product_id');

        $this->db->limit($per_page, $page);
        $query = $this->db->get();
        return $query->result();
    }

    public function buying_report_count() {
        $this->db->select('count(b.product_id) as allproductcount');
        $this->db->group_by('b.product_id');
        $this->db->from('product_purchase_details a');
        $this->db->join('product_information b', 'b.product_id = a.product_id');
        $this->db->join('product_purchase c', 'c.purchase_id = a.purchase_id');
        $this->db->join('supplier_product d', 'd.product_id = a.product_id');
        $query = $this->db->get();
        return $query->num_rows();
    }

//    ============ its for jobtype productivity ==============
    public function jobtype_productivity($user_type,$user_id) {
        if($user_type == 2){
            $where = "AND assign_to = '$user_id'";
             $sql = "SELECT (SELECT COUNT(job_id) FROM job_details WHERE status = 0 $where) as pending,
                    (SELECT COUNT(job_id) FROM job_details WHERE status = 1 $where) as in_progress, 
                    (SELECT COUNT(job_id) FROM job_details WHERE status = 2 $where) as declined,
                    (SELECT COUNT(job_id) FROM job_details WHERE status = 3 $where) as completed,
                    (SELECT COUNT(job_id) FROM job_details WHERE assign_to = '$user_id') as total_job";
        }else{
            $sql = "SELECT (SELECT COUNT(job_id) FROM job_details WHERE status = 0 ) as pending,
                    (SELECT COUNT(job_id) FROM job_details WHERE status = 1) as in_progress, 
                    (SELECT COUNT(job_id) FROM job_details WHERE status = 2) as declined,
                    (SELECT COUNT(job_id) FROM job_details WHERE status = 3) as completed,
                    (SELECT COUNT(job_id) FROM job_details) as total_job";
        }
//        dd($where);
       
        $query = $this->db->query($sql);
        return $query->result();
    }

}
