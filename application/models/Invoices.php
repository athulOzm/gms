<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoices extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('lcustomer');
        $this->load->library('session');
        $this->load->model('Customers');
        $this->auth->check_admin_auth();
    }

    //Count invoice
    public function count_invoice() {
        return $this->db->count_all("invoice");
    }

    //Count todays_sales_report
    public function todays_sales_report() {
        $today = date('Y-m-d');
        $this->db->select('b.customer_name, b.customer_id, a.invoice_id');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->where('a.date', $today);
        $query = $this->db->get()->result();
        return $query;
    }

//    ======= its for  best_sales_products ===========
    public function best_sales_products() {
        $this->db->select('b.product_id, b.product_name, sum(a.quantity) as quantity');
        $this->db->from('invoice_details a');
        $this->db->join('product_information b', 'b.product_id = a.product_id');
        $this->db->group_by('b.product_id');
        $this->db->order_by('quantity', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

//    ======= its for  best_sales_products ===========
    public function best_saler_product_list() {
        $this->db->select('b.product_id, b.product_name, sum(a.quantity) as quantity');
        $this->db->from('invoice_details a');
        $this->db->join('product_information b', 'b.product_id = a.product_id');
        $this->db->group_by('b.product_id');
        $this->db->order_by('quantity', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

//    ======= its for  todays_customer_receipt ===========
    public function todays_customer_receipt($today = null) {
//        echo $today;die();
        $this->db->select('a.customer_name, a.customer_id, SUM(b.amount) as total_amount');
        $this->db->from('customer_information a');
        $this->db->join('customer_ledger b', 'b.customer_id = a.customer_id');
        $this->db->where('b.date', $today);
//        $this->db->where('b.receipt_from', 'receipt');        
        $this->db->where('b.receipt_no is  NOT NULL');
        $this->db->group_by('b.customer_id');
        $this->db->order_by('a.customer_name', 'Asc');
        $query = $this->db->get();
        return $query->result();
    }

//    ======= its for  todays_customer_receipt ===========
    public function filter_customer_wise_receipt($custome_id = null, $from_date = null) {
        $this->db->select('a.customer_name, a.customer_id, SUM(b.amount) as total_amount');
        $this->db->from('customer_information a');
        $this->db->join('customer_ledger b', 'b.customer_id = a.customer_id');
        $this->db->where('a.customer_id', $custome_id);
        $this->db->where('b.date', $from_date);
        $this->db->where('b.receipt_no is  NOT NULL');
//        $this->db->where('b.receipt_from', 'receipt');
//        $this->db->group_by('b.customer_id');
//        $this->db->order_by('a.customer_name', 'Asc');
        $query = $this->db->get();
        return $query->result();
    }

    //invoice List
    public function invoice_list($perpage, $page, $user_id, $user_type) {
        $this->db->select('a.*,b.customer_name');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->order_by('a.invoice', 'desc');
        if ($user_type == 3) {
            $this->db->where('a.customer_id', $user_id);
        }
        $this->db->limit($perpage, $page);
        $query = $this->db->get();
//        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // pdf list
    public function invoice_list_pdf() {
        $this->db->select('a.*,b.customer_name');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->order_by('a.invoice', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function user_invoice_data($user_id) {
        return $this->db->select('*')->from('users')->where('user_id', $user_id)->get()->row();
    }

    // search invoice by customer id
    public function invoice_search($customer_id, $per_page, $page) {
        $this->db->select('a.*,b.customer_name');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->where('a.customer_id', $customer_id);
        $this->db->order_by('a.invoice', 'desc');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // invoice search by invoice id
    public function invoice_list_invoice_id($invoice_no) {
        $this->db->select('a.*,b.customer_name');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');

        $this->db->where('invoice_id', $invoice_no);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // date to date invoice list
    public function invoice_list_date_to_date($from_date, $to_date, $perpage, $page) {
        $dateRange = "a.date BETWEEN '$from_date' AND '$to_date'";
        $this->db->select('a.*,b.customer_name');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->where($dateRange, NULL, FALSE);
        $this->db->order_by('a.invoice', 'desc');
        $this->db->limit($perpage, $page);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // Invoiec list date to date 
    public function invoice_list_date_to_date_count($from_date, $to_date) {
        $dateRange = "a.date BETWEEN '$from_date%' AND '$to_date%'";
        $this->db->select('a.*,b.customer_name');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->where($dateRange, NULL, FALSE);
        $this->db->order_by('a.invoice', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    //invoice List
    public function invoice_list_count($user_id, $user_type) {
        $this->db->select('a.*,b.customer_name');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        if ($user_type == 3) {
            $this->db->where('a.customer_id', $user_id);
        }
        $this->db->order_by('a.invoice', 'desc');
        $this->db->limit('500');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

// count invoice search by customer
    public function invoice_search_count($customer_id) {
        $this->db->select('a.*,b.customer_name');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->where('a.customer_id', $customer_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    //invoice Search Item
    public function search_inovoice_item($customer_id) {
        $this->db->select('a.*,b.customer_name');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->where('b.customer_id', $customer_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //POS invoice entry
    public function pos_invoice_setup($product_id) {
        $product_information = $this->db->select('*')
                ->from('product_information')
                ->join('supplier_product', 'product_information.product_id = supplier_product.product_id')
                ->where('product_information.product_id', $product_id)
                ->get()
                ->row();

        if ($product_information != null) {

            $this->db->select('SUM(a.quantity) as total_purchase');
            $this->db->from('product_purchase_details a');
            $this->db->where('a.product_id', $product_id);
            $total_purchase = $this->db->get()->row();

            $this->db->select('SUM(b.quantity) as total_sale');
            $this->db->from('invoice_details b');
            $this->db->where('b.product_id', $product_id);
            $total_sale = $this->db->get()->row();

            $available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);

            $data2 = (object) array(
                        'total_product' => $available_quantity,
                        'supplier_price' => $product_information->supplier_price,
                        'price' => $product_information->price,
                        'supplier_id' => $product_information->supplier_id,
                        'product_id' => $product_information->product_id,
                        'product_name' => $product_information->product_name,
                        'product_model' => $product_information->product_model,
                        'unit' => $product_information->unit,
                        'tax' => $product_information->tax,
                        'image' => $product_information->image,
            );



            return $data2;
        } else {
            return false;
        }
    }

    //POS customer setup
    public function pos_customer_setup() {
        $query = $this->db->select('*')
                ->from('customer_information')
                ->where('customer_name', 'Walking Customer')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Count invoice
    public function invoice_entry() {
        $this->load->model('Web_settings');
        $tablecolumn = $this->db->list_fields('tax_collection');
        $num_column = count($tablecolumn) - 4;
        $invoice_id = $this->generator(10);
        $invoice_id = strtoupper($invoice_id);
        $createby = $this->session->userdata('user_id');
        $createdate = date('Y-m-d H:i:s');
        $quantity = $this->input->post('product_quantity');
        $available_quantity = $this->input->post('available_quantity');
        $currency_details = $this->Web_settings->retrieve_setting_editdata();

        $result = array();
        foreach ($available_quantity as $k => $v) {
            if ($v < $quantity[$k]) {
                $this->session->set_userdata(array('error_message' => display('you_can_not_buy_greater_than_available_qnty')));
                redirect('Cinvoice');
            }
        }


        $product_id = $this->input->post('product_id');
        if ($product_id == null) {
            $this->session->set_userdata(array('error_message' => display('please_select_product')));
            redirect('Cinvoice/pos_invoice');
        }

        if (($this->input->post('customer_name_others') == null) && ($this->input->post('customer_id') == null ) && ($this->input->post('customer_name') == null )) {
            $this->session->set_userdata(array('error_message' => display('please_select_customer')));
            redirect(base_url() . 'Cinvoice');
        }


        if (($this->input->post('customer_id') == null ) && ($this->input->post('customer_name') == null )) {
            $customer_id = $this->auth->generator(15);
            //Customer  basic information adding.
            $coa = $this->headcode();
            if ($coa->HeadCode != NULL) {
                $headcode = $coa->HeadCode + 1;
            } else {
                $headcode = "102030101";
            }
            $c_acc = $customer_id . '-' . $this->input->post('customer_name_others');
            $createby = $this->session->userdata('user_id');
            $createdate = date('Y-m-d H:i:s');
            $data = array(
                'customer_id' => $customer_id,
                'customer_name' => $this->input->post('customer_name_others'),
                'customer_address' => $this->input->post('customer_name_others_address'),
                'customer_mobile' => $this->input->post('customer_mobile'),
                'customer_email' => "",
                'status' => 2
            );
            $customer_coa = [
                'HeadCode' => $headcode,
                'HeadName' => $c_acc,
                'PHeadName' => 'Customer Receivable',
                'HeadLevel' => '4',
                'IsActive' => '1',
                'IsTransaction' => '1',
                'IsGL' => '0',
                'HeadType' => 'A',
                'IsBudget' => '0',
                'IsDepreciation' => '0',
                'DepreciationRate' => '0',
                'CreateBy' => $createby,
                'CreateDate' => $createdate,
            ];

            $this->db->insert('customer_information', $data);
            $this->db->insert('acc_coa', $customer_coa);
            $this->db->select('*');
            $this->db->from('customer_information');
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $json_customer[] = array('label' => $row->customer_name, 'value' => $row->customer_id);
            }
            $cache_file = './my-assets/js/admin_js/json/customer.json';
            $customerList = json_encode($json_customer);
            file_put_contents($cache_file, $customerList);


            //Previous balance adding -> Sending to customer model to adjust the data.
            $this->Customers->previous_balance_add(0, $customer_id);
        } else {
            $customer_id = $this->input->post('customer_id');
        }


        //Full or partial Payment record.
        $paid_amount = $this->input->post('paid_amount');
        if ($this->input->post('paid_amount') >= 0) {

            $this->db->set('status', '1');
            $this->db->where('customer_id', $customer_id);

            $this->db->update('customer_information');

            $transection_id = $this->auth->generator(15);


            // Insert to customer_ledger Table 
            $data4 = array(
                'transaction_id' => $transection_id,
                'customer_id' => $customer_id,
                'invoice_no' => $invoice_id,
                'date' => (!empty($this->input->post('invoice_date')) ? $this->input->post('invoice_date') : date('Y-m-d')),
                'amount' => $this->input->post('n_total') - (!empty($this->input->post('previous')) ? $this->input->post('previous') : 0),
                'description' => 'Purchase by customer',
                'status' => 1,
                'd_c' => 'd'
            );
            $this->db->insert('customer_ledger', $data4);

            //Insert to customer_ledger Table 
            $data2 = array(
                'transaction_id' => $transection_id,
                'customer_id' => $customer_id,
                'receipt_no' => $this->auth->generator(10),
                'date' => (!empty($this->input->post('invoice_date')) ? $this->input->post('invoice_date') : date('Y-m-d')),
                'amount' => $this->input->post('paid_amount'),
                'payment_type' => 1,
                'invoice_no' => $invoice_id,
                'description' => 'Paid by customer',
                'status' => 1,
                'd_c' => 'c'
            );
            $this->db->insert('customer_ledger', $data2);

            // Account table info
            $data3 = array(
                'transaction_id' => $transection_id,
                'relation_id' => $customer_id,
                'transection_type' => 2,
                'date_of_transection' => (!empty($this->input->post('invoice_date')) ? $this->input->post('invoice_date') : date('Y-m-d')),
                'transection_category' => 2,
                'amount' => $this->input->post('paid_amount'),
                'transection_mood' => 1,
                'is_transaction' => 0,
                'description' => 'Paid by customer'
            );

            $this->db->insert('transection', $data3);

            for ($j = 0; $j < $num_column; $j++) {
                $taxfield = 'tax' . $j;
                $taxvalue = 'total_tax' . $j;
                $taxdata[$taxfield] = $this->input->post($taxvalue);
            }
            $taxdata['customer_id'] = $customer_id;
            $taxdata['date'] = (!empty($this->input->post('invoice_date')) ? $this->input->post('invoice_date') : date('Y-m-d'));
            $taxdata['relation_id'] = $invoice_id;
            $this->db->insert('tax_collection', $taxdata);

            // Inserting for Accounts adjustment.
            ############ default table :: customer_payment :: inflow_92mizdldrv #################
        }

        //Data inserting into invoice table
        $datainv = array(
            'invoice_id' => $invoice_id,
            'customer_id' => $customer_id,
            'date' => (!empty($this->input->post('invoice_date')) ? $this->input->post('invoice_date') : date('Y-m-d')),
            'total_amount' => $this->input->post('grand_total_price'),
            'total_tax' => $this->input->post('total_tax'),
            'invoice' => $this->number_generator(),
            'invoice_details' => (!empty($this->input->post('inva_details')) ? $this->input->post('inva_details') : 'Gui Pos'),
            'invoice_discount' => $this->input->post('invoice_discount'),
            'total_discount' => $this->input->post('total_discount'),
            'prevous_due' => $this->input->post('previous'),
            'shipping_cost' => $this->input->post('shipping_cost'),
            'sales_by' => $this->session->userdata('user_id'),
            'status' => 1
        );
        //	print_r($datainv);exit;

        $this->db->insert('invoice', $datainv);
        $prinfo = $this->db->select('product_id,Avg(rate) as product_rate')->from('product_purchase_details')->where_in('product_id', $product_id)->group_by('product_id')->get()->result();
        $purchase_ave = [];
        $i = 0;
        foreach ($prinfo as $avg) {
            $purchase_ave [] = $avg->product_rate * $quantity[$i];
            $i++;
        }
        $sumval = array_sum($purchase_ave);

        $cusifo = $this->db->select('*')->from('customer_information')->where('customer_id', $customer_id)->get()->row();
        $headn = $customer_id . '-' . $cusifo->customer_name;
        $coainfo = $this->db->select('*')->from('acc_coa')->where('HeadName', $headn)->get()->row();
        $customer_headcode = $coainfo->HeadCode;
// Cash in Hand debit
        $cc = array(
            'VNo' => $invoice_id,
            'Vtype' => 'INV',
            'VDate' => $createdate,
            'COAID' => 1020101,
            'Narration' => 'Cash in Hand For Invoice No' . $invoice_id,
            'Debit' => $this->input->post('paid_amount'),
            'Credit' => 0,
            'IsPosted' => 1,
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
            'IsAppove' => 1
        );


        ///Inventory credit
        $coscr = array(
            'VNo' => $invoice_id,
            'Vtype' => 'INV',
            'VDate' => $createdate,
            'COAID' => 10107,
            'Narration' => 'Inventory credit For Invoice No' . $invoice_id,
            'Debit' => 0,
            'Credit' => $sumval, //purchase price asbe
            'IsPosted' => 1,
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
            'IsAppove' => 1
        );
        $this->db->insert('acc_transaction', $coscr);

        // Customer Transactions
        //Customer debit for Product Value
        $cosdr = array(
            'VNo' => $invoice_id,
            'Vtype' => 'INV',
            'VDate' => $createdate,
            'COAID' => $customer_headcode,
            'Narration' => 'Customer debit For Invoice No' . $invoice_id,
            'Debit' => $this->input->post('grand_total_price'),
            'Credit' => 0,
            'IsPosted' => 1,
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
            'IsAppove' => 1
        );
        $this->db->insert('acc_transaction', $cosdr);

        ///Customer credit for Paid Amount
        $cuscredit = array(
            'VNo' => $invoice_id,
            'Vtype' => 'INV',
            'VDate' => $createdate,
            'COAID' => $customer_headcode,
            'Narration' => 'Customer credit for Paid Amount For Invoice No' . $invoice_id,
            'Debit' => 0,
            'Credit' => $this->input->post('paid_amount'),
            'IsPosted' => 1,
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
            'IsAppove' => 1
        );
        if (!empty($this->input->post('paid_amount'))) {
            $this->db->insert('acc_transaction', $cuscredit);
            $this->db->insert('acc_transaction', $cc);
        }
        $customerinfo = $this->db->select('*')->from('customer_information')->where('customer_id', $customer_id)->get()->row();

        $rate = $this->input->post('product_rate');
        $p_id = $this->input->post('product_id');
        $total_amount = $this->input->post('total_price');
        $discount_rate = $this->input->post('discount_amount');
        $discount_per = $this->input->post('discount');
        $tax_amount = $this->input->post('tax');
        $invoice_description = $this->input->post('desc');

        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $total_price = $total_amount[$i];
            $supplier_rate = $this->supplier_rate($product_id);
            $disper = $discount_per[$i];
            $discount = is_numeric($product_quantity) * is_numeric($product_rate) * is_numeric($disper) / 100;
            $tax = $tax_amount[$i];
            $description = $invoice_description[$i];

            $data1 = array(
                'invoice_details_id' => $this->generator(15),
                'invoice_id' => $invoice_id,
                'product_id' => $product_id,
                'quantity' => $product_quantity,
                'rate' => $product_rate,
                'discount' => $discount,
                'description' => $description,
                'discount_per' => $disper,
                'tax' => $tax,
                'paid_amount' => $this->input->post('paid_amount'),
                'due_amount' => $this->input->post('due_amount'),
                'supplier_rate' => $supplier_rate[0]['supplier_price'],
                'total_price' => $total_price,
                'status' => 1
            );
            if (!empty($quantity)) {
                $this->db->insert('invoice_details', $data1);
            }
        }
        $message = 'Mr.' . $customerinfo->customer_name . ',
        ' . 'You have purchase  ' . $this->input->post('grand_total_price') . ' ' . $currency_details[0]['currency'] . ' You have paid .' . $this->input->post('paid_amount') . ' ' . $currency_details[0]['currency'];

        $this->send_sms($customerinfo->customer_mobile, $message);

        return $invoice_id;
    }

    //Get Supplier rate of a product
    public function supplier_rate($product_id) {
        $this->db->select('supplier_price');
        $this->db->from('supplier_product');
        $this->db->where(array('product_id' => $product_id));
        $query = $this->db->get();
        return $query->result_array();
    }

    //Retrieve invoice Edit Data
    public function retrieve_invoice_editdata($invoice_id) {
        $this->db->select('a.*, sum(c.quantity) as sum_quantity, a.total_tax as taxs,a. prevous_due,b.customer_name,c.*,c.tax as total_tax,c.product_id,d.product_name,d.product_model,d.tax,d.unit');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->join('invoice_details c', 'c.invoice_id = a.invoice_id');
        $this->db->join('product_information d', 'd.product_id = c.product_id');
        $this->db->where('a.invoice_id', $invoice_id);
        $this->db->group_by('d.product_id');
//        $this->db->where('c.quantity >', 0);
        $query = $this->db->get();
//         echo '<pre>';
// print_r($query->result_array());exit();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //update_invoice
    public function update_invoice() {
        $tablecolumn = $this->db->list_fields('tax_collection');
        $num_column = count($tablecolumn) - 4;
        $invoice_id = $this->input->post('invoice_id');
        $createby = $this->session->userdata('user_id');
        $createdate = date('Y-m-d H:i:s');
        $customer_id = $this->input->post('customer_id');
        $quantity = $this->input->post('product_quantity');
        $product_id = $this->input->post('product_id');
        $abs = $this->db->select('transaction_id')->from('customer_ledger')
                        ->where('invoice_no', $invoice_id)
                        ->get()->result();
//        echo '<pre>';        print_r($abs);die();
        $transection_id = $this->auth->generator(15);
        foreach ($abs as $ab) {
            $tran = $ab->transaction_id;

            $this->db->where('transaction_id', $tran);
            $this->db->delete('customer_ledger');

            $this->db->where('transaction_id', $tran);
            $this->db->delete('transection');
            $this->db->where('VNo', $invoice_id);
            $this->db->delete('acc_transaction');
            // tax collection delete
            $this->db->where('relation_id', $invoice_id);
            $this->db->delete('tax_collection');
        }
//        echo '<pre>';        print_r($tran);die();

        $datarcpt = array(
            'transaction_id' => $transection_id,
            'customer_id' => $this->input->post('customer_id'),
            'receipt_no' => $this->auth->generator(10),
            'date' => $this->input->post('invoice_date'),
            'amount' => $this->input->post('paid_amount'),
            'payment_type' => 1,
            'description' => 'Paid by customer',
            'invoice_no' => $invoice_id,
            'status' => 1,
            'd_c' => 'c',
        );


        $data = array(
            'invoice_id' => $invoice_id,
            'customer_id' => $this->input->post('customer_id'),
            'date' => $this->input->post('invoice_date'),
            'total_amount' => $this->input->post('grand_total_price'),
            'total_tax' => $this->input->post('total_tax'),
            'invoice_details' => $this->input->post('inva_details'),
            'invoice_discount' => $this->input->post('invoice_discount'),
            'total_discount' => $this->input->post('total_discount'),
            'prevous_due' => $this->input->post('previous'),
            'shipping_cost' => $this->input->post('shipping_cost'),
        );
        $data2 = array(
            'transaction_id' => $transection_id,
            'customer_id' => $this->input->post('customer_id'),
            'invoice_no' => $invoice_id,
            'date' => $this->input->post('invoice_date'),
            'amount' => $this->input->post('n_total') - $this->input->post('previous'),
            'payment_type' => 1,
            'description' => 'Purchase by customer',
            'status' => 1,
            'd_c' => 'd'
        );

        $data3 = array(
            'transaction_id' => $transection_id,
            'relation_id' => $this->input->post('customer_id'),
            'transection_type' => 2,
            'date_of_transection' => $this->input->post('invoice_date'),
            'transection_category' => 2,
            'amount' => $this->input->post('paid_amount'),
            'transection_mood' => 1,
            'is_transaction' => 0,
            'description' => 'Paid by customer'
        );
        $prinfo = $this->db->select('product_id,Avg(rate) as product_rate')->from('product_purchase_details')->where_in('product_id', $product_id)->group_by('product_id')->get()->result();
        $purchase_ave = [];
        $i = 0;
        foreach ($prinfo as $avg) {
            $purchase_ave [] = $avg->product_rate * $quantity[$i];
            $i++;
        }
        $sumval = array_sum($purchase_ave);

        $cusifo = $this->db->select('*')->from('customer_information')->where('customer_id', $customer_id)->get()->row();
        $headn = $customer_id . '-' . $cusifo->customer_name;
        $coainfo = $this->db->select('*')->from('acc_coa')->where('HeadName', $headn)->get()->row();
        $customer_headcode = $coainfo->HeadCode;
// Cash in Hand debit
        $cc = array(
            'VNo' => $invoice_id,
            'Vtype' => 'INV',
            'VDate' => $createdate,
            'COAID' => 1020101,
            'Narration' => 'Cash in Hand For Invoice No' . $invoice_id,
            'Debit' => $this->input->post('paid_amount'),
            'Credit' => 0,
            'IsPosted' => 1,
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
            'IsAppove' => 1
        );


        ///Inventory credit
        $coscr = array(
            'VNo' => $invoice_id,
            'Vtype' => 'INV',
            'VDate' => $createdate,
            'COAID' => 10107,
            'Narration' => 'Inventory credit For Invoice No' . $invoice_id,
            'Debit' => 0,
            'Credit' => $sumval, //purchase price asbe
            'IsPosted' => 1,
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
            'IsAppove' => 1
        );
        $this->db->insert('acc_transaction', $coscr);

        // Customer Transactions
        //Customer debit for Product Value
        $cosdr = array(
            'VNo' => $invoice_id,
            'Vtype' => 'INV',
            'VDate' => $createdate,
            'COAID' => $customer_headcode,
            'Narration' => 'Customer debit For Invoice No' . $invoice_id,
            'Debit' => $this->input->post('grand_total_price'),
            'Credit' => 0,
            'IsPosted' => 1,
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
            'IsAppove' => 1
        );
        $this->db->insert('acc_transaction', $cosdr);

        ///Customer credit for Paid Amount
        $coscr = array(
            'VNo' => $invoice_id,
            'Vtype' => 'INV',
            'VDate' => $createdate,
            'COAID' => $customer_headcode,
            'Narration' => 'Customer credit for Paid Amount For Invoice No' . $invoice_id,
            'Debit' => 0,
            'Credit' => $this->input->post('paid_amount'),
            'IsPosted' => 1,
            'CreateBy' => $createby,
            'CreateDate' => $createdate,
            'IsAppove' => 1
        );
        if (!empty($this->input->post('paid_amount'))) {
            $this->db->insert('acc_transaction', $coscr);
            $this->db->insert('acc_transaction', $cc);
        }

        if ($invoice_id != '') {
            $this->db->where('invoice_id', $invoice_id);
            $this->db->update('invoice', $data);

            //Update Another table


            $this->db->insert('customer_ledger', $data2);
            $this->db->insert('customer_ledger', $datarcpt);
            $this->db->insert('transection', $data3);
        }

        for ($j = 0; $j < $num_column; $j++) {
            $taxfield = 'tax' . $j;
            $taxvalue = 'total_tax' . $j;
            $taxdata[$taxfield] = $this->input->post($taxvalue);
        }
        $taxdata['customer_id'] = $customer_id;
        $taxdata['date'] = (!empty($this->input->post('invoice_date')) ? $this->input->post('invoice_date') : date('Y-m-d'));
        $taxdata['relation_id'] = $invoice_id;
        $this->db->insert('tax_collection', $taxdata);

        // Inserting for Accounts adjustment.
        ############ default table :: customer_payment :: inflow_92mizdldrv #################
        //Insert to customer_ledger Table 
        //$this->db->insert($account_table,$account_adjustment);


        $invoice_d_id = $this->input->post('invoice_details_id');
        $cartoon = $this->input->post('cartoon');
        $quantity = $this->input->post('product_quantity');
        $rate = $this->input->post('product_rate');
        $p_id = $this->input->post('product_id');
        $total_amount = $this->input->post('total_price');
        $discount_rate = $this->input->post('discount_amount');
        $discount_per = $this->input->post('discount');
        $invoice_description = $this->input->post('desc');
        $this->db->where('invoice_id', $invoice_id);
        $this->db->delete('invoice_details');

        for ($i = 0, $n = count($p_id); $i < $n; $i++) {
            $cartoon_quantity = $cartoon[$i];
            $product_quantity = $quantity[$i];
            $product_rate = $rate[$i];
            $product_id = $p_id[$i];
            $total_price = $total_amount[$i];
            $supplier_rate = $this->supplier_rate($product_id);
            $discount = $discount_rate[$i];
            $dis_per = $discount_per[$i];
            $desciption = $invoice_description[$i];
            if (!empty($tax_amount[$i])) {
                $tax = $tax_amount[$i];
            } else {
                $tax = $this->input->post('tax');
            }


            $data1 = array(
                'invoice_details_id' => $this->generator(15),
                'invoice_id' => $invoice_id,
                'product_id' => $product_id,
                'quantity' => $product_quantity,
                'rate' => $product_rate,
                'discount' => $discount,
                'total_price' => $total_price,
                'discount_per' => $dis_per,
                'tax' => $this->input->post('total_tax'),
                'paid_amount' => $this->input->post('paid_amount'),
                'supplier_rate' => $supplier_rate[0]['supplier_price'],
                'due_amount' => $this->input->post('due_amount'),
                'description' => $desciption,
            );
            $this->db->insert('invoice_details', $data1);



            $tran = $this->db->select('*')->from('customer_ledger')->where('invoice_no', $invoice_id)->get()->result();


            foreach ($tran as $value) {
                
            }
            $transection_id = $value->transaction_id;


            $customer_id = $this->input->post('customer_id');
            $account_adjustment = array(
                'transection_id' => $transection_id,
                'tracing_id' => $customer_id,
                'date' => $this->input->post('invoice_date'),
                'amount' => $this->input->post('paid_amount'),
                'payment_type' => 1,
                'description' => 'Paid by customer',
                'status' => 1
            );
        }

        return $invoice_id;
    }

    //Retrieve invoice_html_data
    public function retrieve_invoice_html_data($invoice_id) {
        $this->db->select('a.total_tax,
						a.*,
						b.*,
						c.*,
						d.product_id,
						d.product_name,
						d.product_details,
						d.product_model');
        $this->db->from('invoice a');

        $this->db->join('invoice_details c', 'c.invoice_id = a.invoice_id');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->join('product_information d', 'd.product_id = c.product_id');
        $this->db->where('a.invoice_id', $invoice_id);
        $this->db->where('c.quantity >', 0);
        $query = $this->db->get();
//        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // Delete invoice Item
    public function retrieve_product_data($product_id) {
        $this->db->select('supplier_price,price,supplier_id,tax');
        $this->db->from('product_information a');
        $this->db->join('supplier_product b', 'a.product_id=b.product.id');
        $this->db->where(array('a.product_id' => $product_id, 'a.status' => 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
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

    // Delete invoice Item
    public function delete_invoice($invoice_id) {
        $customer_ledger = $this->db->select('transaction_id')->from('customer_ledger')
                        ->where('invoice_no', $invoice_id)
                        ->get()->result();
        $transaction_id = $customer_ledger[0]->transaction_id;
//        echo '<pre>';        print_r($customer_ledger); 
        //Delete Invoice table
        $this->db->where('invoice_id', $invoice_id)->delete('invoice');
        //Delete invoice_details table
        $this->db->where('invoice_id', $invoice_id)->delete('invoice_details');
        //Delete transaction from customer_ledger table
        $this->db->where('transaction_id', $transaction_id)->delete('customer_ledger');
        //Delete transaction from transaction table
        $this->db->where('transaction_id', $transaction_id)->delete('transection');
        return true;
    }

    public function invoice_search_list($cat_id, $company_id) {
        $this->db->select('a.*,b.sub_category_name,c.category_name');
        $this->db->from('invoices a');
        $this->db->join('invoice_sub_category b', 'b.sub_category_id = a.sub_category_id');
        $this->db->join('invoice_category c', 'c.category_id = b.category_id');
        $this->db->where('a.sister_company_id', $company_id);
        $this->db->where('c.category_id', $cat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // GET TOTAL PURCHASE PRODUCT
    public function get_total_purchase_item($product_id) {
        $this->db->select('SUM(quantity) as total_purchase');
        $this->db->from('product_purchase_details');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // GET TOTAL SALES PRODUCT
    public function get_total_sales_item($product_id) {
        $this->db->select('SUM(quantity) as total_sale');
        $this->db->from('invoice_details');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Get total product
    public function get_total_product($product_id, $supplier_id) {
        $this->db->select('SUM(a.quantity) as total_purchase,b.*');
        $this->db->from('product_purchase_details a');
        $this->db->join('supplier_product b', 'a.product_id=b.product_id');
        $this->db->where('a.product_id', $product_id);
        $this->db->where('b.supplier_id', $supplier_id);
        $total_purchase = $this->db->get()->row();

        $this->db->select('SUM(b.quantity) as total_sale');
        $this->db->from('invoice_details b');
        $this->db->where('b.product_id', $product_id);
        $total_sale = $this->db->get()->row();

        $this->db->select('a.*,b.*');
        $this->db->from('product_information a');
        $this->db->join('supplier_product b', 'a.product_id=b.product_id');
        $this->db->where(array('a.product_id' => $product_id, 'a.status' => 1));
        $this->db->where('b.supplier_id', $supplier_id);
        $product_information = $this->db->get()->row();

        $available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);

        $CI = & get_instance();
        $CI->load->model('Web_settings');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();

        $data2 = array(
            'total_product' => $available_quantity,
            'supplier_price' => $product_information->supplier_price,
            'price' => $product_information->price,
            'supplier_id' => $product_information->supplier_id,
            'unit' => $product_information->unit,
            'tax' => $product_information->tax,
            'discount_type' => $currency_details[0]['discount_type'],
        );

        return $data2;
    }

// product information retrieve by product id
    public function get_total_product_invoic($product_id) {
        $this->db->select('SUM(a.quantity) as total_purchase');
        $this->db->from('product_purchase_details a');
        $this->db->where('a.product_id', $product_id);
        $total_purchase = $this->db->get()->row();

        $this->db->select('SUM(b.quantity) as total_sale');
        $this->db->from('invoice_details b');
        $this->db->where('b.product_id', $product_id);
        $total_sale = $this->db->get()->row();

        $this->db->select('a.*,b.*');
        $this->db->from('product_information a');
        $this->db->join('supplier_product b', 'a.product_id=b.product_id');
        $this->db->where(array('a.product_id' => $product_id, 'a.status' => 1));
        $product_information = $this->db->get()->row();

        $available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);

        $CI = & get_instance();
        $CI->load->model('Web_settings');
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $tablecolumn = $this->db->list_fields('tax_collection');
        $num_column = count($tablecolumn) - 4;
        $taxfield = '';
        $taxvar = [];
        for ($i = 0; $i < $num_column; $i++) {
            $taxfield = 'tax' . $i;
            $data2[$taxfield] = $product_information->$taxfield;
            $taxvar[$i] = $product_information->$taxfield;
            $data2['taxdta'] = $taxvar;
            //
        }


        $data2['total_product'] = $available_quantity;
        $data2['supplier_price'] = $product_information->supplier_price;
        $data2['price'] = $product_information->price;
        $data2['supplier_id'] = $product_information->supplier_id;
        $data2['unit'] = $product_information->unit;
        $data2['tax'] = $product_information->tax;
        $data2['discount_type'] = $currency_details[0]['discount_type'];
        $data2['txnmber'] = $num_column;


        return $data2;
    }

    //This function is used to Generate Key
    public function generator($lenth) {
        $number = array("1", "2", "3", "4", "5", "6", "7", "8", "9");

        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 8);
            $rand_number = $number["$rand_value"];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }

    //NUMBER GENERATOR
    public function number_generator() {
        $this->db->select_max('invoice', 'invoice_no');
        $query = $this->db->get('invoice');
        $result = $query->result_array();
        $invoice_no = $result[0]['invoice_no'];
        if ($invoice_no != '') {
            $invoice_no = $invoice_no + 1;
        } else {
            $invoice_no = 1000;
        }
        return $invoice_no;
    }

    public function headcode() {
        $query = $this->db->query("SELECT MAX(HeadCode) as HeadCode FROM acc_coa WHERE HeadLevel='4' And HeadCode LIKE '1020301%'");
        return $query->row();
    }

    //csv invoice
    public function invoice_csv_file() {
        $query = $this->db->select('a.invoice,a.invoice_id,b.customer_name,a.date,a.total_amount')
                ->from('invoice a')
                ->join('customer_information b', 'b.customer_id = a.customer_id', 'left')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function category_dropdown() {
        $data = $this->db->select("*")
                ->from('product_category')
                ->get()
                ->result();

        $list[''] = 'Select ' . display('category_name');
        if (!empty($data)) {
            foreach ($data as $value)
                $list[$value->category_id] = $value->category_name;
            return $list;
        } else {
            return false;
        }
    }

    public function customer_dropdown() {
        $data = $this->db->select("*")
                ->from('customer_information')
                ->get()
                ->result();

        $list[''] = 'Select Customer';
        if (!empty($data)) {
            foreach ($data as $value)
                $list[$value->customer_id] = $value->customer_name;
            return $list;
        } else {
            return false;
        }
    }

    public function walking_customer() {
        return $data = $this->db->select('*')->from('customer_information')->like('customer_name', 'walking', 'after')->get()->result_array();
    }

    public function allproduct() {
        $this->db->select('*');
        $this->db->from('product_information');
        $query = $this->db->get();
        $itemlist = $query->result();
        return $itemlist;
    }

    public function searchprod($cid = null, $pname = null) {
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->like('category_id', $cid);
        $this->db->like('product_name', $pname);
        $query = $this->db->get();
        $itemlist = $query->result();
        return $itemlist;
    }

    public function send_sms($phone = null, $msg = null) {
        $config_data = $this->db->select('*')->from('sms_settings')->get()->row();
        if ($config_data->isinvoice == 0) {
            return true;
        } else {
            $recipients = $phone;
            $url = $config_data->url; //"http://sms.bdtask.com/smsapi"; 
            $senderid = $config_data->sender_id; //"8801847169884";
            $apikey = $config_data->api_key; //"C20029865c42c504afc711.77492546";
            $message = $msg;
            //echo "$url?api_key=$apikey&type=text&contacts=$recipients&senderid=$senderid&msg=$message";
            $urltopost = $config_data->url; //"http://sms.bdtask.com/smsapi";
            $datatopost = array(
                "api_key" => $apikey,
                "type" => 'text',
                "senderid" => $senderid,
                "msg" => $message,
                "contacts" => $recipients
            );

            $ch = curl_init($urltopost);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datatopost);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
//print_r($result);
            if ($result === false) {
                echo sprintf('<span>%s</span>CURL error:', curl_error($ch));
                return;
            }
            curl_close($ch);
            return $result;
        }
    }

    public function service_invoice_taxinfo($invoice_id) {
        return $this->db->select('*')
                        ->from('tax_collection')
                        ->where('relation_id', $invoice_id)
                        ->get()
                        ->result_array();
    }

    //invoice List
    public function recurring_invoice_count() {
        $this->db->select('a.*,b.customer_name');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->order_by('a.invoice', 'desc');
        $this->db->where('is_recurring', 1);
        $this->db->limit('500');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }
        return false;
    }

    //invoice List
    public function recurring_invoice_list($perpage, $page) {
        $this->db->select('a.*,b.customer_name');
        $this->db->from('invoice a');
        $this->db->join('customer_information b', 'b.customer_id = a.customer_id');
        $this->db->order_by('a.invoice', 'desc');
        $this->db->where('is_recurring', 1);
        $this->db->limit($perpage, $page);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

}
