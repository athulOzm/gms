<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customers extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //Count customer
    public function count_customer() {
        return $this->db->count_all("customer_information");
    }

    //customer List
    public function customer_list_count() {
        $where = 'status = 1 or status = 2';
        $this->db->select('customer_information.*,sum(customer_transection_summary.amount) as customer_balance');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        $this->db->where($where);
        $this->db->group_by('customer_transection_summary.customer_id');
        $this->db->order_by('customer_information.create_date', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    //customer List
    public function customer_list($per_page = null, $page = null) {
        $where = 'status = 1 or status = 2';
        $this->db->select('customer_information.*,
			CAST(sum(customer_transection_summary.amount) AS DECIMAL(16,2)) as customer_balance
			');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id', 'left');
        $this->db->where($where);
        $this->db->group_by('customer_transection_summary.customer_id');
        $this->db->order_by('customer_information.create_date', 'DESC');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //customer List
    public function archive_customer_list_count() {
        $where = 'status = 3';
        $this->db->select('customer_information.*,sum(customer_transection_summary.amount) as customer_balance');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        $this->db->where($where);
        $this->db->group_by('customer_transection_summary.customer_id');
        $this->db->order_by('customer_information.create_date', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    //customer List
    public function archive_customer_list($per_page = null, $page = null) {
        $where = 'status = 3';
        $this->db->select('customer_information.*,
			CAST(sum(customer_transection_summary.amount) AS DECIMAL(16,2)) as customer_balance
			');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id', 'left');
        $this->db->where($where);
        $this->db->group_by('customer_transection_summary.customer_id');
        $this->db->order_by('customer_information.create_date', 'ASC');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // customer list pdf 
    public function customer_list_pdf() {
        $this->db->select('customer_information.*,
            CAST(sum(customer_transection_summary.amount) AS DECIMAL(16,2)) as customer_balance
            ');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        $this->db->group_by('customer_transection_summary.customer_id');
        $this->db->order_by('customer_information.create_date', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //all customer List
    public function all_customer_list() {
        $this->db->select('customer_information.*,sum(customer_transection_summary.amount) as customer_balance');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        $this->db->group_by('customer_transection_summary.customer_id');
        $this->db->order_by('customer_information.create_date', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Credit customer List
    public function credit_customer_list($per_page, $page) {
        $this->db->select('customer_information.*,
            sum(customer_transection_summary.amount) as customer_balance
            ');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        //$this->db->where('customer_information.status',2);
        $this->db->group_by('customer_transection_summary.customer_id');
        $this->db->having('customer_balance < 0');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

//    public function credit_customer_list($per_page, $page) {
//        $this->db->select('customer_information.*,
//			sum(customer_transection_summary.amount) as customer_balance
//			');
//        $this->db->from('customer_information');
//        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
//        //$this->db->where('customer_information.status',2);
//        $this->db->group_by('customer_transection_summary.customer_id');
//        $this->db->having('customer_balance < 0', NULL, FALSE);
//        $this->db->limit($per_page, $page);
//        $query = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        }
//        return false;
//    }
    //All Credit customer List
    public function all_credit_customer_list() {
        $this->db->select('customer_information.*,
            sum(customer_transection_summary.amount) as customer_balance
            ');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        //$this->db->where('customer_information.status',2);
        $this->db->group_by('customer_information.customer_id');
        $this->db->having('customer_balance < 0');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Credit customer List
    public function credit_customer_list_count() {
        $this->db->select('customer_information.*,
            sum(customer_transection_summary.amount) as customer_balance
            ');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        //$this->db->where('customer_information.status',2);
        $this->db->group_by('customer_information.customer_id');
        $this->db->having('customer_balance < 0');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    //Paid Customer list
    public function paid_customer_list($per_page = null, $page = null) {
        $this->db->select('customer_information.*,
            sum(customer_transection_summary.amount) as customer_balance
            ');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        //$this->db->where('customer_information.status',2);
        $this->db->group_by('customer_information.customer_id');
        $this->db->having('customer_balance >= 0');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //All Paid Customer list
    public function all_paid_customer_list() {
        $this->db->select('customer_information.*,
            sum(customer_transection_summary.amount) as customer_balance
            ');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        //$this->db->where('customer_information.status',2);
        $this->db->group_by('customer_information.customer_id');
        $this->db->having('customer_balance >= 0');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Paid Customer list
    public function paid_customer_list_count() {
        $this->db->select('customer_information.*,
            sum(customer_transection_summary.amount) as customer_balance
            ');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        //$this->db->where('customer_information.status',2);
        $this->db->group_by('customer_information.customer_id');
        $this->db->having('customer_balance >= 0');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    //Customer Search List
    public function customer_search_item($customer_id) {
        $this->db->select('customer_information.*,
			CAST(sum(customer_transection_summary.amount) AS DECIMAL(16,2)) as customer_balance');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        $this->db->where('customer_information.customer_id', $customer_id);
        $this->db->group_by('customer_transection_summary.customer_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Customer Search List
    public function all_activeInactive_data($status) {
        $this->db->select('customer_information.*,
			CAST(sum(customer_transection_summary.amount) AS DECIMAL(16,2)) as customer_balance');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        $this->db->where('customer_information.status', $status);
        $this->db->group_by('customer_transection_summary.customer_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Credit Customer Search List
    public function credit_customer_search_item($customer_id) {
//        $this->db->distinct('customer_id');
//        $this->db->select('*');
//        $this->db->from('customer_information');
//        $this->db->where('customer_id', $customer_id);
//        $query = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        }
//        return false;
        $this->db->select('customer_information.*,
			sum(customer_transection_summary.amount) as customer_balance
			');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        $this->db->where('customer_information.status', 2);
        $this->db->group_by('customer_transection_summary.customer_id');
        $this->db->where('customer_information.customer_id', $customer_id);
        $this->db->having('customer_balance != 0', NULL, FALSE);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            $this->session->set_userdata(array('error_message' => display('this_is_not_credit_customer')));
            redirect('Ccustomer/credit_customer');
        }
    }

    //Paid Customer Search List
    public function paid_customer_search_item($customer_id) {

        $this->db->select('customer_information.*,sum(customer_transection_summary.amount) as customer_balance');
        $this->db->from('customer_information');
        $this->db->join('customer_transection_summary', 'customer_transection_summary.customer_id= customer_information.customer_id');
        $this->db->having('customer_balance >= 0', NULL, FALSE);
        $this->db->where('customer_information.customer_id', $customer_id);
        $this->db->group_by('customer_transection_summary.customer_id');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Count customer
    public function customer_entry($data) {
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('customer_name', $data['customer_name']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $this->db->insert('customer_information', $data);

            $this->db->select('*');
            $this->db->from('customer_information');
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $json_customer[] = array('label' => $row->customer_name, 'value' => $row->customer_id);
            }
            $cache_file = './my-assets/js/admin_js/json/customer.json';
            $customerList = json_encode($json_customer);
            file_put_contents($cache_file, $customerList);
            return TRUE;
        }
    }

    //Customer Previous balance adjustment
    public function previous_balance_add($balance, $customer_id) {
        $this->load->library('auth');
        $cusifo = $this->db->select('*')->from('customer_information')->where('customer_id', $customer_id)->get()->row();
        $headn = $customer_id . '-' . $cusifo->customer_name;
        $coainfo = $this->db->select('*')->from('acc_coa')->where('HeadName', $headn)->get()->row();
        $customer_headcode = $coainfo->HeadCode;
        $transaction_id = $this->auth->generator(10);
        $data = array(
            'transaction_id' => $transaction_id,
            'customer_id' => $customer_id,
            'invoice_no' => "NA",
            'receipt_no' => NULL,
            'amount' => $balance,
            'description' => "Previous adjustment with software",
            'payment_type' => "NA",
            'cheque_no' => "NA",
            'date' => date("Y-m-d"),
            'status' => 1,
            'd_c' => "d"
        );

// Customer debit for previous balance
        $cosdr = array(
            'VNo' => $transaction_id,
            'Vtype' => 'PR Balance',
            'VDate' => date("Y-m-d"),
            'COAID' => $customer_headcode,
            'Narration' => 'Customer debit For Transaction No' . $transaction_id,
            'Debit' => $balance,
            'Credit' => 0,
            'IsPosted' => 1,
            'CreateBy' => $this->session->userdata('user_id'),
            'CreateDate' => date('Y-m-d H:i:s'),
            'IsAppove' => 1
        );
        $inventory = array(
            'VNo' => $transaction_id,
            'Vtype' => 'PR Balance',
            'VDate' => date("Y-m-d"),
            'COAID' => 10107,
            'Narration' => 'Inventory credit For Old sale For' . $customer_id,
            'Debit' => 0,
            'Credit' => $balance, //purchase price asbe
            'IsPosted' => 1,
            'CreateBy' => $this->session->userdata('user_id'),
            'CreateDate' => date('Y-m-d H:i:s'),
            'IsAppove' => 1
        );

        $this->db->insert('customer_ledger', $data);
        if (!empty($balance)) {
            $this->db->insert('acc_transaction', $cosdr);
            $this->db->insert('acc_transaction', $inventory);
        }
    }

    //Retrieve company Edit Data
    public function retrieve_company() {
        $this->db->select('*');
        $this->db->from('company_information');
        $this->db->limit('1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Retrieve customer Edit Data
    public function retrieve_customer_editdata($customer_id) {
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('customer_id', $customer_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Retrieve customer Personal Data 
    public function customer_personal_data($customer_id) {
        $this->db->select('*');
        $this->db->from('customer_information');
        $this->db->where('customer_id', $customer_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Retrieve customer Invoice Data 
    public function customer_invoice_data($customer_id) {
        $this->db->select('*');
        $this->db->from('customer_ledger');
        $this->db->where(array('customer_id' => $customer_id, 'receipt_no' => NULL, 'status' => 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Retrieve customer Receipt Data 
    public function customer_receipt_data($customer_id) {
        $this->db->select('*');
        $this->db->from('customer_ledger');
        $this->db->where(array('customer_id' => $customer_id, 'invoice_no' => NULL, 'status' => 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

//Retrieve customer All data 
    public function customerledger_tradational($customer_id) {
        $this->db->select('
			customer_ledger.*,
			invoice.invoice as invoce_n, invoice.job_id
			');
        $this->db->from('customer_ledger');
        $this->db->join('invoice', 'customer_ledger.invoice_no = invoice.invoice_id', 'LEFT');
        $this->db->where(array('customer_ledger.customer_id' => $customer_id, 'customer_ledger.status' => 1));
        $this->db->order_by('customer_ledger.id', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Retrieve customer total information
    public function customer_transection_summary($customer_id) {
        $result = array();
        $this->db->select_sum('amount', 'total_credit');
        $this->db->from('customer_ledger');
        $this->db->where(array('customer_id' => $customer_id, 'receipt_no' => NULL, 'status' => 1));
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result[] = $query->result_array();
        }

        $this->db->select_sum('amount', 'total_debit');
        $this->db->from('customer_ledger');
        $this->db->where(array('customer_id' => $customer_id, 'invoice_no' => NULL, 'status' => 1));
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result[] = $query->result_array();
        }
        return $result;
    }

    //Update Categories
    public function update_customer($data, $customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->update('customer_information', $data);
        $this->db->select('*');
        $this->db->from('customer_information');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $json_customer[] = array('label' => $row->customer_name, 'value' => $row->customer_id);
        }
        $cache_file = './my-assets/js/admin_js/json/customer.json';
        $customerList = json_encode($json_customer);
        file_put_contents($cache_file, $customerList);
        return true;
    }

    // custromer transection delete
    public function delete_transection($customer_id) {
        $this->db->where('relation_id', $customer_id);
        $this->db->delete('transection');
    }

    // custromer invoicedetails delete
    public function delete_invoicedetails($customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->delete('invoice_details');
    }

// customer login info
    public function customer_logininfo($customer_id) {
        $this->db->select('*');
        $this->db->from('user_login');
        $this->db->where('user_id', $customer_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // custromer invoice delete
    public function delete_invoic($customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->delete('invoice');
    }

    // custromer user delete
    public function delete_user($customer_id) {
        $this->db->where('user_id', $customer_id);
        $this->db->delete('users');
    }

    // custromer user login delete
    public function delete_user_login($customer_id) {
        $this->db->where('user_id', $customer_id);
        $this->db->delete('user_login');
    }

    // delete customer ledger 
    public function delete_customer_ledger($customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->delete('customer_ledger');
    }

    // Delete customer Item
    public function delete_customer($customer_id, $customer_head) {
        $this->db->where('HeadName', $customer_head);
        $this->db->delete('acc_coa');
        $this->db->where('customer_id', $customer_id);
        $this->db->delete('customer_information');

        $this->db->select('*');
        $this->db->from('customer_information');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $json_customer[] = array('label' => $row->customer_name, 'value' => $row->customer_id);
        }
        $cache_file = './my-assets/js/admin_js/json/customer.json';
        $customerList = json_encode($json_customer);
        file_put_contents($cache_file, $customerList);
        return true;
    }

    public function customer_search_list($cat_id, $company_id) {
        $this->db->select('a.*,b.sub_category_name,c.category_name');
        $this->db->from('customers a');
        $this->db->join('customer_sub_category b', 'b.sub_category_id = a.sub_category_id');
        $this->db->join('customer_category c', 'c.category_id = b.category_id');
        $this->db->where('a.sister_company_id', $company_id);
        $this->db->where('c.category_id', $cat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function headcode() {
        $query = $this->db->query("SELECT MAX(HeadCode) as HeadCode FROM acc_coa WHERE HeadLevel='4' And HeadCode LIKE '1020301-%' ORDER BY row_id DESC LIMIT 1");
        return $query->row();
    }

    //autocomplete part
    public function customer_search($customer_id) {
        $query = $this->db->select('*')->from('customer_information')
                ->group_start()
                ->like('customer_name', $customer_id)
                ->or_like('customer_mobile', $customer_id)
                ->group_end()
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // csv customer list
    public function customer_csv_file() {
        $query = $this->db->select('customer_name,customer_email,customer_address,customer_mobile')
                ->from('customer_information')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

}
