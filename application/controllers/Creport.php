<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Creport extends CI_Controller {

    private $user_id = '';

    function __construct() {
        parent::__construct();
        $CI = & get_instance();
        $this->load->library('auth');
        $this->user_id = $this->session->userdata('user_id');
        $CI->load->model('Web_settings');
        $this->load->model('Products');
        $this->load->model('reports');
    }

    public function index() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Reports');
        $today = date('Y-m-d');
        $product_id = $this->input->post('product_id') ? $this->input->post('product_id') : "";
        $date = $this->input->post('stock_date') ? $this->input->post('stock_date') : $today;
        // ==============pagination satar ==================]
        $alldata = $this->input->post('all');
        if (!empty($alldata)) {
            $perpagdata = $this->Reports->count_stockrep_data($product_id, $date);
        } else {
            $perpagdata = 50;
        }

        $config["base_url"] = base_url('Creport/index');
        $config["total_rows"] = $this->Reports->count_stockrep_data($product_id, $date);
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        $content = $this->lreport->stock_report_single_item($product_id, $date, $links, $config["per_page"], $page);
        #
        // ========================pagination end ===========================
        // $limit = 15;
        // $start_record = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        // $date = ($this->uri->segment(3)) ? $this->uri->segment(3) : $date;
        // $link = $this->pagination($limit, "Creport/index/$date");
        // $content = $CI->lreport->stock_report_single_item($product_id, $date, $limit, $start_record, $link);

        $this->template->full_admin_html_view($content);
    }

    public function out_of_stock() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');

        $content = $CI->lreport->out_of_stock();

        $this->template->full_admin_html_view($content);
    }

    //Stock report supplir report
    public function stock_report_product_wise() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Reports');
        $today = date('Y-m-d');

        $product_id = $this->input->post('product_id') ? $this->input->post('product_id') : "";
        $supplier_id = $this->input->post('supplier_id') ? $this->input->post('supplier_id') : "";

        $date = $this->input->post('stock_date') ? $this->input->post('stock_date') : $today;
        $alldata = $this->input->post('all');
        if (!empty($alldata)) {
            $perpagdata = $this->Reports->product_counter_by_supplier($supplier_id);
        } else {
            $perpagdata = 50;
        }
        //print_r($date);exit;
        #
        #pagination starts
        #
        $config["base_url"] = base_url('Creport/stock_report_product_wise/');
        $config["total_rows"] = $this->Reports->product_counter_by_supplier($supplier_id);
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lreport->stock_report_supplier_wise($product_id, $supplier_id, $date, $links, $config["per_page"], $page);


        $this->template->full_admin_html_view($content);
    }

// date wise product report
    public function stock_date_to_date_product_wise() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Reports');
        $today = date('Y-m-d');
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        $alldata = $this->input->get('all');
        if (!empty($alldata)) {
            $perpagdata = $this->Reports->product_counter_by_productdatetodate($from_date, $to_date);
        } else {
            $perpagdata = 50;
        }
        //print_r($date);exit;
        #exit;
        #pagination starts
        #
        $config["base_url"] = base_url('Creport/stock_date_to_date_product_wise/');
        $config["total_rows"] = $this->Reports->product_counter_by_productdatetodate($from_date, $to_date);
        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        $config['suffix'] = '?' . http_build_query($_GET, '', '&');
        $config['first_url'] = $config["base_url"] . $config['suffix'];
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lreport->stock_report_product_date_date_wise($from_date, $to_date, $links, $config["per_page"], $page);


        $this->template->full_admin_html_view($content);
    }

    //Stock report supplir report
    public function stock_report_supplier_wise() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
        $CI->load->model('Reports');
        $today = date('Y-m-d');

        $product_id = $this->input->post('product_id') ? $this->input->post('product_id') : "";
        $supplier_id = $this->input->post('supplier_id') ? $this->input->post('supplier_id') : "";
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $alldata = $this->input->post('all');
        if (!empty($alldata)) {
            $perpagdata = $this->Reports->stock_report_product_bydate_count($product_id, $supplier_id, $from_date, $to_date);
        } else {
            $perpagdata = 50;
        }
        #
        #pagination starts
        #
        $config["base_url"] = base_url('Creport/stock_report_supplier_wise');
        $config["total_rows"] = $this->Reports->stock_report_product_bydate_count($product_id, $supplier_id, $from_date, $to_date);

        $config["per_page"] = $perpagdata;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lreport->stock_report_product_wise($product_id, $supplier_id, $from_date, $to_date, $links, $config["per_page"], $page);

        $this->template->full_admin_html_view($content);
    }

    //Get product by supplier
    public function get_product_by_supplier() {
        $supplier_id = $this->input->post('supplier_id');

        $product_info_by_supplier = $this->db->select('a.*,b.*')
                ->from('product_information a')
                ->join('supplier_product b', 'a.product_id=b.product_id')
                ->where('b.supplier_id', $supplier_id)
                ->get()
                ->result();

        if ($product_info_by_supplier) {
            echo "<select class=\"form-control\" id=\"supplier_id\" name=\"supplier_id\">
	                <option value=\"\">" . display('select_one') . "</option>";
            foreach ($product_info_by_supplier as $product) {
                echo "<option value='" . $product->product_id . "'>" . $product->product_name . '-(' . $product->product_model . ')' . " </option>";
            }
            echo " </select>";
        }
    }

    #===============Report paggination=============#

    public function pagination($per_page, $page) {
        $CI = & get_instance();
        $CI->load->model('Reports');
        $product_id = $this->input->post('product_id');

        $config = array();
        $config["base_url"] = base_url() . $page;
        $config["total_rows"] = $this->Reports->product_counter($product_id);
        $config["per_page"] = $per_page;
        $config["uri_segment"] = 4;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";



        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = $config["per_page"];
        return $links = $this->pagination->create_links();
    }

    //pdf stock report
    public function stock_report_downloadpdf() {
        $CI = & get_instance();
        $CI->load->model('Reports');
        $CI->load->model('Web_settings');
        $CI->load->model('Invoices');
        $CI->load->library('pdfgenerator');
        $stok_report = $CI->Reports->stock_report_pdf();
        $sub_total_in = 0;
        $sub_total_out = 0;
        $sub_total_stock = 0;
        $sub_total_stokpurchase = 0;
        $sub_total_stoksale = 0;
        if (!empty($stok_report)) {
            $i = $page;
            foreach ($stok_report as $k => $v) {
                $i++;
                $stok_report[$k]['sl'] = $i;
            }

            foreach ($stok_report as $k => $v) {
                $i++;
//echo '<pre>';print_r($v);
                $stok_report[$k]['stok_quantity_cartoon'] = ($stok_report[$k]['totalPurchaseQnty'] - $stok_report[$k]['totalSalesQnty']);
                $stok_report[$k]['SubTotalOut'] = ($sub_total_out + $stok_report[$k]['totalSalesQnty']);
                $sub_total_out = $stok_report[$k]['SubTotalOut'];
                $stok_report[$k]['SubTotalIn'] = ($sub_total_in + $stok_report[$k]['totalPurchaseQnty']);
                $sub_total_in = $stok_report[$k]['SubTotalIn'];
                $stok_report[$k]['SubTotalStock'] = ($sub_total_stock + $stok_report[$k]['stok_quantity_cartoon']);
                $sub_total_stock = $stok_report[$k]['SubTotalStock'];

                $stok_report[$k]['total_sale_price'] = $stok_report[$k]['stok_quantity_cartoon'] * $stok_report[$k]['price'];

                $stok_report[$k]['sales_price'] = $stok_report[$k]['price'];

                $sub_total_stoksale += $stok_report[$k]['total_sale_price'];
            }
        }
//         echo '<pre>';        print_r($stok_report); die();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Reports->retrieve_company();
        $data = array(
            'title' => display('stock_report'),
            'stok_report' => $stok_report,
            'product_model' => $stok_report[0]['product_model'],
            'date' => $date,
            'sub_total_in' => number_format($sub_total_in, 2, '.', ','),
            'sub_total_out' => number_format($sub_total_out, 2, '.', ','),
            'sub_total_stock' => number_format($sub_total_stock, 2, '.', ','),
            'company_info' => $company_info,
            'stock_purchase' => number_format($sub_total_stokpurchase, 2, '.', ','),
            'stock_sale' => number_format($sub_total_stoksale, 2, '.', ','),
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
            'software_info' => $currency_details,
            'company' => $company_info,
        );
        $this->load->helper('download');
        $content = $this->parser->parse('report/stock_report_pdf', $data, true);
        $time = date('Ymdhi');
        $dompdf = new DOMPDF();
        $dompdf->load_html($content);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents('assets/data/pdf/' . 'stock_report' . $time . '.pdf', $output);
        $file_path = 'assets/data/pdf/' . 'stock_report' . $time . '.pdf';
        $file_name = 'stock_report' . $time . '.pdf';
        force_download(FCPATH . 'assets/data/pdf/' . $file_name, null);
    }

//    ============ its for stock_take ===========
    public function stock_take() {
        $data['title'] = display('stock_take');
        $data['get_products'] = $this->Products->get_products();

        $content = $this->parser->parse('report/stock_take', $data, true);
        $this->template->full_admin_html_view($content);
    }
//    ============ its for stock_take_list ===========
    public function stock_take_list() {
        $data['title'] = display('stock_take_list');
        $data['currency_details'] = $this->Web_settings->retrieve_setting_editdata();
        $config["base_url"] = base_url('Creport/stock_take_list/');
        $config["total_rows"] = $this->db->count_all('stock_adjustment');
        $config["per_page"] = 50;
        $config["uri_segment"] = 3;
        $config["last_link"] = "Last";
        $config["first_link"] = "First";
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['full_tag_open'] = '<div class = "pagging text-center"><nav><ul class = "pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class = "page-item active"><span class = "page-link">';
        $config['cur_tag_close'] = '<span class = "sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['next_tagl_close'] = '<span aria-hidden = "true">&raquo;
        </span></span></li>';
        $config['prev_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['prev_tagl_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class = "page-item"><span class = "page-link">';
        $config['last_tagl_close'] = '</span></li>';
        #Paggination end#


        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $limit = $config["per_page"];
        $data['get_stocktakelist'] = $this->reports->get_stocktakelist($limit, $page);
        $data['links'] = $this->pagination->create_links();
        $data['pagenum'] = $page;

        $content = $this->parser->parse('report/stock_take_list', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ========== its for stock adjustment insert ================
    public function insert_stockadjustment() {
//        echo $this->user_id; die();
        $adjustment_id = "AD" . $this->auth->generator(10);
        $purchase_detail_id = "PD" . $this->auth->generator(10);
        $created_date = date('Y-m-d h:i:s');
        $adjustment_type = $this->input->post('adjustment_type');
        $date = $this->input->post('date');
        $details = $this->input->post('details');
        $product_id = $this->input->post('product_id');
        $product_quantity = $this->input->post('product_quantity');
        $product_rate = $this->input->post('product_rate');
        $total_price = $this->input->post('total_price');
        $voucher_type = 'adjustment';
        $grand_total_price = $this->input->post('grand_total_price');

        $adjustment_data = array(
            'adjustment_id' => $adjustment_id,
            'adjustment_type' => $adjustment_type,
            'date' => $date,
            'details' => $details,
            'grand_total' => $grand_total_price,
            'created_by' => $this->user_id,
            'created_date' => $created_date,
        );
        $this->db->insert('stock_adjustment', $adjustment_data);
        $in_qty = $out_qty = 0;
        for ($i = 0, $n = count($product_id); $i < $n; $i++) {
            if ($adjustment_type == 1) {
                $in_qty = $product_quantity[$i];
            } else {
                $in_qty = 0;
            }
            if ($adjustment_type == 2) {
                $out_qty = $product_quantity[$i];
            } else {
                $out_qty = 0;
            }
            $stock_data = array(
                'voucher_no' => $adjustment_id,
                'product_id' => $product_id[$i],
                'in_qty' => $in_qty,
                'out_qty' => $out_qty,
                'rate' => $product_rate[$i],
                'voucher_type' => $voucher_type,
                'date' => $date,
                'created_by' => $this->user_id,
                'created_date' => $created_date,
            );
            $this->db->insert('stock_tbl', $stock_data);
            if ($adjustment_type == 1) {
                $purchase_details = array(
                    'purchase_detail_id' => $purchase_detail_id,
                    'purchase_id' => $adjustment_id,
                    'product_id' => $product_id[$i],
                    'quantity' => $in_qty,
                    'rate' => $product_rate[$i],
                    'total_amount' => $total_price[$i],
                    'status' => 1,
                );
                $this->db->insert('product_purchase_details', $purchase_details);
            }
//            if ($adjustment_type == 2) {
//                $invoice_details_data = array(
//                    'invoice_details_id' => $this->auth->generator(15),
//                    'invoice_id' => $adjustment_id,
//                    'product_id' => $product_id[$i],
//                    'spent_time' => '', //$spenttime,
//                    'quantity' => $out_qty, //$product_quantity,
//                    'rate' => $product_rate[$i],
//                    'discount' => '', //$discount,
//                    'description' => 'Stock adjustment', //$description,
//                    'discount_per' => '', //$disper,
//                    'tax' => '', //$tax,
//                    'paid_amount' => 0, //$this->input->post('paid_amount'),
//                    'due_amount' => 0, //$this->input->post('due_amount'),
//                    'supplier_rate' => '', //$supplier_rate[0]['supplier_price'],
//                    'total_price' => $total_price[$i],
//                    'status' => 1
//                );
//                $this->db->insert('invoice_details', $invoice_details_data);
//            }
        }
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Creport/stock_take'));
    }

}
