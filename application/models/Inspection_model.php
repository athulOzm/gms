<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inspection_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

//    =========== its for job category wise job type ===============
    public function job_category_wise_type($category_id) {
        $query = $this->db->select('a.*')
                        ->from('job_type a')
                        ->where('job_category_id', $category_id)
                        ->get()->result();
        return $query;
    }

//    =========== its for get_inspectionlist ============
    public function get_inspectionlist($offset, $limit) {
        $query = $this->db->select('*')
                        ->from('inspection')
                        ->order_by('inspection_id', 'desc')
                        ->limit($offset, $limit)
                        ->get()->result();
        return $query;
    }

//    ========== its for inspection_edit ============
    public function inspection_edit($inspection_id) {
        $query = $this->db->select('*')
                        ->from('inspection a')
                        ->where('a.inspection_id', $inspection_id)
                        ->get()->result();
        return $query;
    }

//    ========== its for inspection_list_edit ============
    public function inspection_list_edit($inspection_id) {
        $query = $this->db->select('*')
                        ->from('inspection_list a')
                        ->where('a.inspection_id', $inspection_id)
                        ->group_by('a.category_id')
                        ->get()->result();
        return $query;
    }

//=========== its for get_jobcategory ===============
    public function get_jobcategory($inspection_id) {
        $query = $this->db->select('a.*, b.job_category_name')
                        ->from('inspection_list a')
                        ->join('job_category b', 'b.job_category_id = a.category_id')
                        ->where('a.inspection_id', $inspection_id)
                        ->group_by('a.category_id')
                        ->get()->result();
        return $query;
    }

//    ============== its for get_package_data =============
    public function get_package_data($job_type_id, $job_id) {
        $query = $this->db->select('*')
                        ->from('package_tbl a')
                        ->where('a.job_type_id', $job_type_id)
                        ->where('a.job_id', $job_id)
                        ->get()->row();
        return $query;
    }
//    ============== its for package_info =============
    public function package_info($inspection_job_typeid = 13) {
        $query = $this->db->select('a.*, CONCAT_WS(" ",b.first_name, b.last_name) as name')
                        ->from('package_tbl a')
                        ->join('users b', 'b.user_id = a.created_by')
                        ->where('a.job_id', $inspection_job_typeid)
                        ->get()->row();
//        echo $this->db->last_query();
        return $query;
    }

}
