<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lpurchase {

    //Purchase add form
    public function purchase_add_form() {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $all_supplier = $CI->Purchases->select_all_supplier();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();

        $data = array(
            'title' => display('add_purchase'),
            'all_supplier' => $all_supplier,
            'invoice_no' => $CI->auth->generator(10),
            'discount_type' => $currency_details[0]['discount_type'],
        );
        $purchaseForm = $CI->parser->parse('purchase/add_purchase_form', $data, true);
        return $purchaseForm;
    }

    // Retrieve Purchase List
    public function purchase_list($links, $per_page, $page) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $purchases_list = $CI->Purchases->purchase_list($per_page, $page);
        if (!empty($purchases_list)) {
            $j = 0;
            foreach ($purchases_list as $k => $v) {
                $purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
                $j++;
            }

            $i = 0;
            foreach ($purchases_list as $k => $v) {
                $i++;
                $purchases_list[$k]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title' => display('manage_purchase'),
            'purchases_list' => $purchases_list,
            'links' => $links,
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
        );
//        echo '<pre>';        print_r($data); die();

        $purchaseList = $CI->parser->parse('purchase/purchase', $data, true);
        return $purchaseList;
    }

    //purchase search by supplier
    public function purchase_search_supplier($supplier_id, $links, $per_page, $page) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $purchases_list = $CI->Purchases->purchase_search($supplier_id, $per_page, $page);
        if (!empty($purchases_list)) {
            $j = 0;
            foreach ($purchases_list as $k => $v) {
                $purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
                $j++;
            }

            $i = 0;
            foreach ($purchases_list as $k => $v) {
                $i++;
                $purchases_list[$k]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title' => display('manage_purchase'),
            'purchases_list' => $purchases_list,
            'links' => $links,
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
        );

        $purchaseList = $CI->parser->parse('purchase/purchase', $data, true);
        return $purchaseList;
    }

// purchase info by invoice no
    public function purchase_list_invoice_no($invoice_no) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $purchases_list = $CI->Purchases->purchase_list_invoice_id($invoice_no);
        if (!empty($purchases_list)) {
            $j = 0;
            foreach ($purchases_list as $k => $v) {
                $purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
                $j++;
            }

            $i = 0;
            foreach ($purchases_list as $k => $v) {
                $i++;
                $purchases_list[$k]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title' => display('manage_purchase'),
            'purchases_list' => $purchases_list,
            'links' => '',
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
        );

        $purchaseList = $CI->parser->parse('purchase/purchase', $data, true);
        return $purchaseList;
    }

    //Purchase Item By Search
    public function purchase_by_search($supplier_id) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->library('occational');
        $purchases_list = $CI->Purchases->purchase_by_search($supplier_id);
        $j = 0;
        if (!empty($purchases_list)) {
            foreach ($purchases_list as $k => $v) {
                $purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
                $j++;
            }
            $i = 0;
            foreach ($purchases_list as $k => $v) {
                $i++;
                $purchases_list[$k]['sl'] = $i;
            }
        }
        $data = array(
            'title' => display('manage_purchase'),
            'purchases_list' => $purchases_list
        );
        $purchaseList = $CI->parser->parse('purchase/purchase', $data, true);
        return $purchaseList;
    }

    //Insert Purchase
    public function insert_purchase($data) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->Purchases->purchase_entry($data);
        return true;
    }

    //purchase Edit Data
    public function purchase_edit_data($purchase_id) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Suppliers');
        $CI->load->model('Web_settings');

        $purchase_detail = $CI->Purchases->retrieve_purchase_editdata($purchase_id);
        $supplier_id = $purchase_detail[0]['supplier_id'];
        $supplier_list = $CI->Suppliers->supplier_list("110", "0");
        $supplier_selected = $CI->Suppliers->supplier_search_item($supplier_id);

        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }
        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title' => display('purchase_edit'),
            'purchase_id' => $purchase_detail[0]['purchase_id'],
            'chalan_no' => $purchase_detail[0]['chalan_no'],
            'supplier_name' => $purchase_detail[0]['supplier_name'],
            'supplier_id' => $purchase_detail[0]['supplier_id'],
            'grand_total' => $purchase_detail[0]['grand_total_amount'],
            'purchase_details' => $purchase_detail[0]['purchase_details'],
            'purchase_date' => $purchase_detail[0]['purchase_date'],
            'total_discount' => $purchase_detail[0]['total_discount'],
            'purchase_info' => $purchase_detail,
            'supplier_list' => $supplier_list,
            'supplier_selected' => $supplier_selected,
            'discount_type' => $currency_details[0]['discount_type'],
        );

        $chapterList = $CI->parser->parse('purchase/edit_purchase_form', $data, true);
        return $chapterList;
    }

    //Search purchase
    public function purchase_search_list($cat_id, $company_id) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $category_list = $CI->Purchases->retrieve_category_list();
        $purchases_list = $CI->Purchases->purchase_search_list($cat_id, $company_id);
        $data = array(
            'title' => display('manage_purchase'),
            'purchases_list' => $purchases_list,
            'category_list' => $category_list
        );
        $purchaseList = $CI->parser->parse('purchase/purchase', $data, true);
        return $purchaseList;
    }

    //Purchase details data
    public function purchase_details_data($purchase_id) {

        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');

        $purchase_detail = $CI->Purchases->purchase_details_data($purchase_id);

        if (!empty($purchase_detail)) {
            $i = 0;
            foreach ($purchase_detail as $k => $v) {
                $i++;
                $purchase_detail[$k]['sl'] = $i;
            }

            foreach ($purchase_detail as $k => $v) {
                $purchase_detail[$k]['convert_date'] = $CI->occational->dateConvert($purchase_detail[$k]['purchase_date']);
            }
        }

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Purchases->retrieve_company();
        $data = array(
            'title' => display('purchase_ledger'),
            'purchase_id' => $purchase_detail[0]['purchase_id'],
            'purchase_details' => $purchase_detail[0]['purchase_details'],
            'supplier_name' => $purchase_detail[0]['supplier_name'],
            'final_date' => $purchase_detail[0]['convert_date'],
            'sub_total_amount' => number_format($purchase_detail[0]['grand_total_amount'], 2, '.', ','),
            'chalan_no' => $purchase_detail[0]['chalan_no'],
            'purchase_all_data' => $purchase_detail,
            'company_info' => $company_info,
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
        );

        $chapterList = $CI->parser->parse('purchase/purchase_detail', $data, true);
        return $chapterList;
    }

    // purchase list date to date
    public function purchase_list_date_to_date($start, $end) {
        $CI = & get_instance();
        $CI->load->model('Purchases');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $purchases_list = $CI->Purchases->purchase_list_date_to_date($start, $end);
        if (!empty($purchases_list)) {
            $j = 0;
            foreach ($purchases_list as $k => $v) {
                $purchases_list[$k]['final_date'] = $CI->occational->dateConvert($purchases_list[$j]['purchase_date']);
                $j++;
            }

            $i = 0;
            foreach ($purchases_list as $k => $v) {
                $i++;
                $purchases_list[$k]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'title' => display('manage_purchase'),
            'purchases_list' => $purchases_list,
            'links' => '',
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
        );

        $purchaseList = $CI->parser->parse('purchase/purchase', $data, true);
        return $purchaseList;
    }

}

?>