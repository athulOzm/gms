<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jobs_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //job Category form
    public function job_type_entry() {
        return $this->db->insert('job_type');
    }

//    ======== its for mechanic_job_list ============
    public function mechanic_job_list($offset, $limit, $user_id, $user_type) {
        $query1 = $this->db->select('*')
                        ->from('job_details j')
                        ->where('j.assign_to', $user_id)
                        ->group_by('j.job_id')
                        ->get()->result();
//        d($query1);
        if (empty($query1)) {
            $not = "Not found";
            return $not;
        } else {
            foreach ($query1 as $job_id) {
                $jobid_arr[] = $job_id->job_id;
            }
            $status = '(a.status = 1 OR a.status = 3)';
            $this->db->select('a.*, b.customer_name, c.vehicle_id, c.vehicle_registration');
            $this->db->from('job a');
            $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
            $this->db->join('vehicle_information c', 'c.vehicle_id = a.vehicle_id');
//        if (empty($jobid_arr)) {
            $this->db->where_in('a.job_id', $jobid_arr);
            $this->db->where($status);
//        }
            $this->db->order_by('a.job_id', 'desc');
            $this->db->limit($offset, $limit);
            $query2 = $this->db->get();
//            echo $this->db->last_query();
            return $query2->result();
        }
    }

//    ========== its for job_list ==============
    public function job_list($offset, $limit, $user_id, $user_type) {
//        echo '<br>' . $user_type;
        $this->db->select('a.*, b.customer_name, c.vehicle_registration');
        $this->db->from('job a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->join('vehicle_information c', 'c.vehicle_id = a.vehicle_id', 'left');
        if ($user_type == 3) {
            $this->db->where('a.customer_id', $user_id);
        }
        $this->db->order_by('a.job_id', 'desc');
        $this->db->limit($offset, $limit);
        $query = $this->db->get()->result();
//        echo $this->db->last_query();
        return $query;
    }

//    ========== its for get_workorder ============
    public function get_workorder($job_id) {
        $query = $this->db->select('*')
                        ->from('job a')
                        ->where('a.job_id', $job_id)
                        ->get()->result();
        return $query;
    }

//============== its for get_job_details =============
    public function get_job_details($job_id, $user_id, $user_type) {
        $this->db->select('*');
        $this->db->from('job_details a');
        $this->db->where('job_id', $job_id);
        if ($user_type == 2) {
            $this->db->where('assign_to', $user_id);
        }
        $query = $this->db->get()->result();
        return $query;
    }

//    ========== its for job used product query =============
    public function job_usedproduct($job_id) {
        $this->db->select('a.*, b.group_price_id');
        $this->db->from('job_products_used a');
        $this->db->join('group_pricing_tbl b', 'b.group_price_id = a.product_id', 'left');
        $this->db->where('a.job_id', $job_id);
        $query = $this->db->get()->result();
        return $query;
    }

//    ========== its for job_typelist ==============
    public function job_typelist($offset, $limit) {
        $query = $this->db->select('a.*, b.job_category_name')
                        ->from('job_type a')
                        ->join('job_category b', 'b.job_category_id = a.job_category_id', 'left')
                        ->order_by('a.job_type_id', 'desc')
                        ->limit($offset, $limit)
                        ->get()->result();
        return $query;
    }

//    ======== its for get job type list =========
    public function get_jobtypelist() {
        $query = $this->db->select('a.*')
                        ->from('job_type a')
//                        ->join('job_category b', 'b.job_category_id = a.job_category_id')
                        ->order_by('a.job_type_name', 'asc')
                        ->get()->result();
        return $query;
    }

//    ======== its for get employee list =========
    public function get_employeelist() {
        $query = $this->db->select('a.*, CONCAT_WS(" ", first_name, last_name) as full_name')
                        ->from('employee_history a')
                        ->order_by('a.id', 'desc')
                        ->get()->result();
        return $query;
    }

//    ======== its for get product list =========
    public function get_productlist() {
        $query = $this->db->select('a.*')
                        ->from('product_information a')
                        ->order_by('a.product_name', 'asc')
                        ->get()->result();
        return $query;
    }

//    ============ its for job_categorylist ==========
    public function job_categorylist($offset, $limit) {
        $query = $this->db->select('*')
                        ->from('job_category a')
//                        ->join('service_type b', 'b.service_type_id = a.service_type_id')
                        ->order_by('a.job_category_id', 'desc')
                        ->limit($offset, $limit)
                        ->get()->result();
        return $query;
    }

//    ========== its for get_job_info ============
    public function get_job_info($job_id) {
        $query = $this->db->select('a.*, b.company_name, b.customer_name, b.customer_email, b.customer_mobile, b.customer_phone, b.customer_address, c.vehicle_registration')
                        ->from('job a')
                        ->join('customer_information b', 'b.customer_id = a.customer_id')
                        ->join('vehicle_information c', 'c.vehicle_id = a.vehicle_id')
                        ->where('a.job_id', $job_id)
                        ->get()->result();
        return $query;
    }

//    ========== its for get_jobdetails_info ============
    public function get_jobdetails_info($job_id) {
        $query = $this->db->select('a.*, b.job_type_name')
                        ->from('job_details a')
                        ->join('job_type b', 'b.job_type_id = a.job_type_id')
                        ->where('a.job_id', $job_id)
                        ->where('a.status', 3)
                        ->get()->result();
        return $query;
    }

    public function get_invoice_info($job_id) {
        $query = $this->db->select('a.*, d.*, b.company_name, b.customer_name, b.customer_email, b.customer_mobile, b.customer_phone, b.customer_address, b.payment_period, c.vehicle_registration')
                        ->from('job a')
                        ->join('customer_information b', 'b.customer_id = a.customer_id')
                        ->join('vehicle_information c', 'c.vehicle_id = a.vehicle_id')
                        ->join('invoice d', 'd.job_id = a.job_id')
                        ->where('a.job_id', $job_id)
                        ->get()->result();
        return $query;
    }

//    ========== its for get_invoicedetails ============
    public function get_invoicedetails($job_id) {
        $query = $this->db->select('*')
                        ->from('invoice_details a')
                        ->join('invoice b', 'b.invoice_id = a.invoice_id')
                        ->join('job_type c', 'c.job_type_id = a.product_id')
                        ->where('b.job_id', $job_id)
//                        ->where('a.status', 3)
                        ->get()->result();
//        echo $this->db->last_query();
        return $query;
    }

//    public function get_invoicedetails($job_id) {
//        $query = $this->db->select('*, a.spent_time as invoice_details_spenttime, d.spent_time as jobdetails_spenttime')
//                        ->from('invoice_details a')
//                        ->join('invoice b', 'b.invoice_id = a.invoice_id')
//                        ->join('job_type c', 'c.job_type_id = a.product_id')
//                        ->join('job_details d', 'd.row_id = a.product_id','left')
//                        ->where('b.job_id', $job_id)
////                        ->where('a.status', 3)
//                        ->get()->result();
////        echo $this->db->last_query();
//        return $query;
//    }
//    ========== its for get_job_products_used ============
    public function get_job_products_used($job_id) {
        $query = $this->db->select('a.*, b.product_name, a.created_date, c.group_name, c.group_price_id')
                        ->from('job_products_used a')
                        ->join('product_information b', 'b.product_id = a.product_id', 'left')
                        ->join('group_pricing_tbl c', 'c.group_price_id = a.product_id', 'left')
                        ->where('a.job_id', $job_id)
                        ->get()->result();
        return $query;
    }

    public function get_acceptjobtypelist() {
        $query = $this->db->select('*')
                        ->from('job')
                        ->where('status !=', 2)
                        ->get()->result();
        return $query;
    }

    // follow up list
    public function followup_list() {
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $this->db->select('a.*,b.*,c.customer_name');
        $this->db->from('follow_ups a');
        $this->db->join('job b', 'b.work_order_no = a.order_id', 'left');
        $this->db->join('customer_information c', 'c.customer_id = b.customer_id', 'left');
        if ($user_type == 3) {
            $this->db->where('b.customer_id', $user_id);
        }
        $query = $this->db->get()->result();
        return $query;
    }

//    ========= its for customer wise vehicle information ============
    public function customer_wise_vehicle_info($customer_id) {
        $query = $this->db->select('*')->from('vehicle_information')->where('customer_id', $customer_id)->get()->result();
        return $query;
    }

//    ========= its for customer wise job information ============
    public function customer_wise_job_info($customer_id) {
        $query = $this->db->select('*')->from('job')->where('customer_id', $customer_id)->get()->result();
        return $query;
    }

//    ============ its for get job category ==========
    public function get_jobcategory() {
        $query = $this->db->select('*')
                        ->from('job_category a')
                        ->order_by('a.job_category_name', 'asc')
                        ->get()->result();
        return $query;
    }

//    ========= its for job category wise job type ===========
    public function get_jobcategory_wise_type($job_category) {
        $query = $this->db->select('a.*')
                        ->from('job_type a')
                        ->where('a.job_category_id', $job_category)
                        ->order_by('a.job_type_name', 'asc')
                        ->get()->result();
        return $query;
    }

//============ its for get recurring job  =============
    public function get_recurring_job() {
        $query = $this->db->select('*')
                        ->from('invoice a')
                        ->where('is_recurring', 1)
                        ->get()->result();
        return $query;
    }

//    =========== its for recurring_invoicedetails ============
    public function recurring_invoicedetails($invoice_id) {
        $query = $this->db->select('*')
                        ->from('invoice_details a')
                        ->where('invoice_id', $invoice_id)
                        ->get()->result();
        return $query;
    }

////    ============= its for completed_job ==========
//    public function completed_job($user_type, $user_id) {
//        $date = date('Y-m-d');
//        $month = date("m", strtotime($date));
//        $this->db->select('count(job_id) as ttl_completejob');
//        $this->db->from('job');
//        if ($user_type == 3) {
//            $this->db->where('customer_id', $user_id);
//        }
//        $this->db->where('status', 3);
//        $this->db->where('month(create_date)', $month);
//        $query = $this->db->get();
////        echo $this->db->last_query();die();
//        return $query->result();
//    }
//
////    ============= its for declined_job ==========
//    public function declined_job($user_type, $user_id) {
////        echo $user_type.' x '.$user_id;
//        $this->db->select('count(job_id) as ttl_declinedjob');
//        $this->db->from('job');
//        if ($user_type == 3) {
//            $this->db->where('customer_id', $user_id);
//        }
//        $this->db->where('status', 2);
//        $query = $this->db->get();
//        return $query->result();
//    }
//    ============= its for main job complete and declined status ===========
    public function job_complet_declinedstatus($user_type, $user_id) {
        if ($user_type == 3) {
            $sql = "SELECT (SELECT COUNT(job_id) FROM job WHERE status = 3 AND customer_id = '$user_id' AND create_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) ttl_completejob,
                    (SELECT COUNT(job_id) FROM job WHERE status = 2 AND customer_id = '$user_id' AND create_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) ttl_declinedjob,
                    (SELECT COUNT(job_id) FROM job WHERE status = 1 AND customer_id = '$user_id' AND create_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) ttl_acceptedjob";
        } else {
            $sql = "SELECT (SELECT COUNT(job_id) FROM job WHERE status = 3 AND create_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) ttl_completejob,
                    (SELECT COUNT(job_id) FROM job WHERE status = 2 AND create_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) ttl_declinedjob,
                    (SELECT COUNT(job_id) FROM job WHERE status = 1 AND create_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) ttl_acceptedjob";
        }
        $query = $this->db->query($sql);
        return $query->result();
    }
//    ============= its for main job complete and declined status year month wise===========
    public function job_complet_declinedstatus_yearmonth($user_type, $user_id, $month, $year) {
        $monthyear = '';
        if($month && $year){
            $monthyear =  "month(create_date) = '$month' AND year(create_date) = '$year'";
        }else{
             $monthyear =  "year(create_date) = '$year'";
        }
//        echo $monthyear; die();
        if ($user_type == 3) {
            $sql = "SELECT (SELECT COUNT(job_id) FROM job WHERE status = 3 AND customer_id = '$user_id' AND  $monthyear) ttl_completejob,
                    (SELECT COUNT(job_id) FROM job WHERE status = 2 AND customer_id = '$user_id' AND  $monthyear) ttl_declinedjob,
                    (SELECT COUNT(job_id) FROM job WHERE status = 1 AND customer_id = '$user_id' AND  $monthyear) ttl_acceptedjob";
        } else {
            $sql = "SELECT (SELECT COUNT(job_id) FROM job WHERE status = 3 AND  $monthyear) ttl_completejob,
                    (SELECT COUNT(job_id) FROM job WHERE status = 2 AND  $monthyear) ttl_declinedjob,
                    (SELECT COUNT(job_id) FROM job WHERE status = 1 AND  $monthyear) ttl_acceptedjob";
        }
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return $query->result();
    }
    
//    public function job_complet_declinedstatus_yearmonth($user_type, $user_id, $month, $year) {
//        if ($user_type == 3) {
//            $sql = "SELECT (SELECT COUNT(job_id) FROM job WHERE status = 3 AND customer_id = '$user_id' AND  month(create_date) = $month AND year(create_date) = $year) ttl_completejob,
//                    (SELECT COUNT(job_id) FROM job WHERE status = 2 AND customer_id = '$user_id' AND  month(create_date) = $month AND year(create_date) = $year) ttl_declinedjob,
//                    (SELECT COUNT(job_id) FROM job WHERE status = 1 AND customer_id = '$user_id' AND  month(create_date) = $month AND year(create_date) = $year) ttl_acceptedjob";
//        } else {
//            $sql = "SELECT (SELECT COUNT(job_id) FROM job WHERE status = 3 AND  month(create_date) = $month AND year(create_date) = $year) ttl_completejob,
//                    (SELECT COUNT(job_id) FROM job WHERE status = 2 AND  month(create_date) = $month AND year(create_date) = $year) ttl_declinedjob,
//                    (SELECT COUNT(job_id) FROM job WHERE status = 1 AND  month(create_date) = $month AND year(create_date) = $year) ttl_acceptedjob";
//        }
//        $query = $this->db->query($sql);
//        //echo $this->db->last_query();
//        return $query->result();
//    }

}
