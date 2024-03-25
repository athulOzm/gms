<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cinvoice extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->invoice_add_form();
        $this->template->full_admin_html_view($content);
    }

    //Insert invoice
    public function insert_invoice() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $invoice_id = $CI->Invoices->invoice_entry();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cinvoice/invoice_inserted_data/'.$invoice_id));

    }

    //invoice Update Form
    public function invoice_update_form($invoice_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->invoice_edit_data($invoice_id);
        $this->template->full_admin_html_view($content);
    }

    // invoice Update
    public function invoice_update() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $invoice_id = $CI->Invoices->update_invoice();
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        $this->invoice_inserted_data($invoice_id);
    }

    //Search Inovoice Item
    public function search_inovoice_item() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('linvoice');

        $customer_id = $this->input->post('customer_id');
        $content = $CI->linvoice->search_inovoice_item($customer_id);
        $this->template->full_admin_html_view($content);
    }

    //Manage invoice list
    public function manage_invoice() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $CI->load->model('Invoices');
        $alldata = $this->input->post('all');
        if(!empty($alldata)){
            $perpagdata = $this->Invoices->invoice_list_count();
        }else{
          $perpagdata = 20;  
        }
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
//        echo $user_id. "  ". $user_type;die();
        #        #pagination starts        #
        $config["base_url"] = base_url('Cinvoice/manage_invoice/');
        $config["total_rows"] = $this->Invoices->invoice_list_count($user_id, $user_type);
//        dd($config["total_rows"]);
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
        #        #pagination ends        #  
        $content = $this->linvoice->invoice_list($links, $config["per_page"], $page, $user_id, $user_type);
        $this->template->full_admin_html_view($content);
    }
// invoice list pdf download
    public function sale_downloadpdf(){
        $CI = & get_instance();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $CI->load->library('occational');
        $CI->load->library('linvoice');
        $CI->load->library('pdfgenerator'); 
        $invoices_list = $CI->Invoices->invoice_list_pdf();
        if (!empty($invoices_list)) {
            $i = 0;
            if (!empty($invoices_list)) {
                 foreach ($invoices_list as $k => $v) {
                $invoices_list[$k]['final_date'] = $CI->occational->dateConvert($invoices_list[$k]['date']);
            }
                foreach ($invoices_list as $k => $v) {
                    $i++;
                    $invoices_list[$k]['sl'] = $i + $CI->uri->segment(3);
                }
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
         $company_info = $CI->Invoices->retrieve_company();
        $data = array(
            'title'         => display('manage_invoice'),
            'invoices_list' => $invoices_list,
            'currency'      => $currency_details[0]['currency'],
            'logo'          => $currency_details[0]['logo'],
            'position'      => $currency_details[0]['currency_position'],
            'company_info'  => $company_info
        );
            $this->load->helper('download');
            $content = $this->parser->parse('invoice/invoice_list_pdf', $data, true);
            $time = date('Ymdhi');
            $dompdf = new DOMPDF();
            $dompdf->load_html($content);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents('assets/data/pdf/'.'sales'.$time.'.pdf', $output);
            $file_path = 'assets/data/pdf/'.'sales'.$time.'.pdf';
           $file_name = 'sales'.$time.'.pdf';
            force_download(FCPATH.'assets/data/pdf/'.$file_name, null);
    }

    // search invoice by customer id
    public function invoice_search() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $CI->load->model('Invoices');
        $customer_id = $this->input->get('customer_id');
        #
        #pagination starts
        #
        $config["base_url"] = base_url('Cinvoice/invoice_search/');
        $config["total_rows"] = $this->Invoices->invoice_search_count($customer_id);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        $config['suffix'] = '?' . http_build_query($_GET);
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
        $content = $this->linvoice->invoice_search($customer_id, $links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

    // search invoice by invoice id
    public function manage_invoice_invoice_id() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $CI->load->model('Invoices');
        $invoice_no = $this->input->post('invoice_no');
        $content = $this->linvoice->invoice_list_invoice_no($invoice_no);
        $this->template->full_admin_html_view($content);
    }

    // invoice list date to date 
    public function date_to_date_invoice() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $CI->load->model('Invoices');
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');

        #
        #pagination starts
        #
        $config["base_url"] = base_url('Cinvoice/date_to_date_invoice/');
        $config["total_rows"] = $this->Invoices->invoice_list_date_to_date_count($from_date, $to_date);
        $config["per_page"] = 10;
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

        $content = $this->linvoice->invoice_list_date_to_date($from_date, $to_date, $links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

    //POS invoice page load
    public function pos_invoice() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->pos_invoice_add_form();
        $this->template->full_admin_html_view($content);
    }

    //Insert pos invoice
    public function insert_pos_invoice() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $product_id = $this->input->post('product_id');

        $product_details = $CI->Invoices->pos_invoice_setup($product_id);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $taxfield = $CI->db->select('tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
           $prinfo = $this->db->select('*')->from('product_information')->where('product_id',$product_id)->get()->result_array();
           // $tablecolumn = $this->db->list_fields('tax_collection');
           //     $num_column = count($tablecolumn)-4;
           // for($j=0;$j<$num_column;$j++){
           //      $taxfield = 'tax'.$j;
           //    $data2[$taxfield] = $prinfo[0][$taxfield];
           //  }   
        $tr = " ";
        if (!empty($product_details)) {
            $product_id = $this->generator(5);
            
            $tr .= "<tr id=\"row_" . $product_details->product_id . "\">
						<td class=\"\" style=\"width:220px\">
							
							<input type=\"text\" name=\"product_name\" onkeypress=\"invoice_productList('" . $product_details->product_id . "');\" class=\"form-control productSelection \" value='" . $product_details->product_name . "- (" . $product_details->product_model . ")" . "' placeholder='" . display('product_name') . "' required=\"\" id=\"product_name\" tabindex=\"\" readonly>

							<input type=\"hidden\" class=\"form-control autocomplete_hidden_value product_id_" . $product_details->product_id . "\" name=\"product_id[]\" id=\"SchoolHiddenId_" . $product_details->product_id . "\" value = \"$product_details->product_id\"/>
							
						</td>
                         <td>
                             <input type=\"text\" name=\"desc[]\" class=\"form-control text-right \"  />
                                        </td>
						<td>
                            <input type=\"text\" name=\"available_quantity[]\" class=\"form-control text-right available_quantity_" . $product_details->product_id . "\" value='" . $product_details->total_product . "' readonly=\"\" id=\"available_quantity_" . $product_details->product_id . "\"/>
                        </td>

                        <td>
                            <input class=\"form-control text-right unit_'" . $product_details->product_id . "' valid\" value=\"$product_details->unit\" readonly=\"\" aria-invalid=\"false\" type=\"text\">
                        </td>
                    
                        <td>
                            <input type=\"text\" name=\"product_quantity[]\" onkeyup=\"quantity_calculate('" . $product_details->product_id . "');\" onchange=\"quantity_calculate('" . $product_details->product_id . "');\" class=\"total_qntt_" . $product_details->product_id . " form-control text-right\" id=\"total_qntt_" . $product_details->product_id . "\" placeholder=\"0.00\" min=\"0\" value=\"1\"/>
                        </td>

						<td style=\"width:85px\">
							<input type=\"text\" name=\"product_rate[]\" onkeyup=\"quantity_calculate('" . $product_details->product_id . "');\" onchange=\"quantity_calculate('" . $product_details->product_id . "');\" value='" . $product_details->price . "' id=\"price_item_" . $product_details->product_id . "\" class=\"price_item1 form-control text-right\" required placeholder=\"0.00\" min=\"0\"/>
						</td>

						<td class=\"\">
							<input type=\"text\" name=\"discount[]\" onkeyup=\"quantity_calculate('" . $product_details->product_id . "');\" onchange=\"quantity_calculate('" . $product_details->product_id . "');\" id=\"discount_" . $product_details->product_id . "\" class=\"form-control text-right\" placeholder=\"0.00\" min=\"0\"/>

							<input type=\"hidden\" value=" . $currency_details[0]['discount_type'] . " name=\"discount_type\" id=\"discount_type_" . $product_details->product_id . "\">
						</td>

						<td class=\"text-right\" style=\"width:100px\">
							<input class=\"total_price form-control text-right\" type=\"text\" name=\"total_price[]\" id=\"total_price_" . $product_details->product_id . "\" value='" . $product_details->price . "' tabindex=\"-1\" readonly=\"readonly\"/>
						</td>

						<td>";
                        $sl=0;
                        foreach ($taxfield as $taxes) {
                            $txs = 'tax'.$sl;
                           $tr .= "<input type=\"hidden\" id=\"total_tax".$sl."_" . $product_details->product_id . "\" class=\"total_tax".$sl."_" . $product_details->product_id . "\" value='" . $prinfo[0][$txs] . "'/>
                            <input type=\"hidden\" id=\"all_tax".$sl."_" . $product_details->product_id . "\" class=\" total_tax".$sl."\" value='" . $prinfo[0][$txs]*$product_details->price . "' name=\"tax[]\"/>";  
                       $sl++; }
						
							 $tr .= "<input type=\"hidden\" id=\"total_discount_" . $product_details->product_id . "\" />
							<input type=\"hidden\" id=\"all_discount_" . $product_details->product_id . "\" class=\"total_discount\"/>
							<button style=\"text-align: right;\" class=\"btn btn-danger\" type=\"button\" value='" . display('delete') . "' onclick=\"deleteRow(this)\">" . '<i class="fa fa-close"></i>' . "</button>
						</td>
					</tr>";
            echo $tr;
        } else {
            return false;
        }
    }

    //Retrive right now inserted data to cretae html
    public function invoice_inserted_data($invoice_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->invoice_html_data($invoice_id);
        $this->template->full_admin_html_view($content);
    }

    //Retrive right now inserted data to cretae html
    public function pos_invoice_inserted_data($invoice_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->pos_invoice_html_data($invoice_id);
        $this->template->full_admin_html_view($content);
    }
//Min invoice data
     public function min_invoice_inserted_data($invoice_id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $content = $CI->linvoice->min_invoice_html_data($invoice_id);
        $this->template->full_admin_html_view($content);
    }
    // Retrieve_product_data
    public function retrieve_product_data() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $product_id = $this->input->post('product_id');
        $supplier_id = $this->input->post('supplier_id');

        $product_info = $CI->Invoices->get_total_product($product_id, $supplier_id);

        echo json_encode($product_info);
    }

    //product info retrive by product id for invoice
    public function retrieve_product_data_inv() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $product_id = $this->input->post('product_id');


        $product_info = $CI->Invoices->get_total_product_invoic($product_id);

        echo json_encode($product_info);
    }

    // Invoice delete
    public function invoice_delete() {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $invoice_id = $_POST['invoice_id'];
        $result = $CI->Invoices->delete_invoice($invoice_id);
        if ($result) {
            $this->session->set_userdata(array('message' => display('successfully_delete')));
            return true;
        }
    }

    //AJAX INVOICE STOCKs
    public function product_stock_check($product_id) {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Invoices');
        //$product_id =  $this->input->post('product_id');

        $purchase_stocks = $CI->Invoices->get_total_purchase_item($product_id);
        $total_purchase = 0;
        if (!empty($purchase_stocks)) {
            foreach ($purchase_stocks as $k => $v) {
                $total_purchase = ($total_purchase + $purchase_stocks[$k]['quantity']);
            }
        }
        $sales_stocks = $CI->Invoices->get_total_sales_item($product_id);
        $total_sales = 0;
        if (!empty($sales_stocks)) {
            foreach ($sales_stocks as $k => $v) {
                $total_sales = ($total_sales + $sales_stocks[$k]['quantity']);
            }
        }

        $final_total = ($total_purchase - $total_sales);
        return $final_total;
    }

//    =========== its for 1 increment =============
    function randomChange($myValue) {
        $random = rand(0, 1);
        if ($random > 0)
            return $myValue + 1;

        return $myValue - 1;
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
    //customer previous due
     public function previous() {
         $CI = & get_instance();
        $CI->load->model('Customers');
        $customer_id = $this->input->post('customer_id');
         $sql = 'SELECT (SELECT SUM(amount) FROM customer_ledger WHERE d_c = "d" AND customer_id = "' . $customer_id . '") dr, 
        (SELECT sum(amount) FROM customer_ledger WHERE d_c = "c" AND customer_id = "' . $customer_id . '") cr';
        $result = $this->db->query($sql)->result();
       $balance = $result[0]->dr - $result[0]->cr;   
       $b = (!empty($balance)?$balance:0);                            
        if ($b){
           echo  json_encode($b);
        } else {
            return false;
        }
    }

    public function customer_autocomplete(){
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpurchase');
        $CI->load->model('Customers');
        $customer_id    = $this->input->post('customer_id');
        $customer_info   = $CI->Customers->customer_search($customer_id);

        $list[''] = '';
        foreach ($customer_info as $value) {
            $json_customer[] = array('label'=>$value['customer_name'],'value'=>$value['customer_id']);
        } 
        echo json_encode($json_customer);
    }
    //csv excel 
     public function exportinvocsv() {
        // file name 
        $this->load->model('Invoices');
        $filename = 'sale_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // get data 
        $invoicedata = $this->Invoices->invoice_csv_file();
   

        // file creation 
        $file = fopen('php://output', 'w');

        $header = array('invoice_no', 'invoice_id', 'customer_name', 'date', 'total_amount');
        fputcsv($file, $header);
        foreach ($invoicedata as $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }


    public function gui_pos(){
           $this->load->model('Invoices');
           $this->load->model('Web_settings');
            $taxfield = $this->db->select('tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
                $tablecolumn = $this->db->list_fields('tax_collection');
                $num_column = count($tablecolumn)-4;
            $data['title'] = display('gui_pos');
            $saveid=$this->session->userdata('user_id');
            $walking_customer = $this->Invoices->walking_customer();
            $data['customer_id'] = @$walking_customer[0]['customer_id'];
            $data['customer_name'] = @$walking_customer[0]['customer_name'];
            $data['categorylist']= $this->Invoices->category_dropdown();
            $customer_details    = $this->Invoices->pos_customer_setup();
            $data['customerlist']= $this->Invoices->customer_dropdown();
            $currency_details    = $this->Web_settings->retrieve_setting_editdata();
            $data['customer_name']=$customer_details[0]['customer_name'];
            $data['customer_id'] = $customer_details[0]['customer_id'];
            $data['itemlist']    =  $this->Invoices->allproduct();
            $data['discount_type']= $currency_details[0]['discount_type'];
            $data['taxes']       = $taxfield;
            $data['taxnumber']   = $num_column;
            $content  = $this->parser->parse('invoice/gui_pos_invoice', $data, true);
     $this->template->full_admin_html_view($content);  
        }

        //gui pos invoice 
            public function gui_pos_invoice() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $product_id = $this->input->post('product_id');

        $product_details = $CI->Invoices->pos_invoice_setup($product_id);
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $taxfield = $CI->db->select('tax_name,default_value')
                ->from('tax_settings')
                ->get()
                ->result_array();
           $prinfo = $this->db->select('*')->from('product_information')->where('product_id',$product_id)->get()->result_array();

        $tr = " ";
        if (!empty($product_details)) {
            $product_id = $this->generator(5);
            
            $tr .= "<tr id=\"row_" . $product_details->product_id . "\">
                        <td class=\"\" style=\"width:220px\">
                            
                            <input type=\"text\" name=\"product_name\" onkeypress=\"invoice_productList('" . $product_details->product_id . "');\" class=\"form-control productSelection \" value='" . $product_details->product_name . "- (" . $product_details->product_model . ")" . "' placeholder='" . display('product_name') . "' required=\"\"  tabindex=\"\" readonly>

                            <input type=\"hidden\" class=\"form-control autocomplete_hidden_value product_id_" . $product_details->product_id . "\" name=\"product_id[]\" id=\"SchoolHiddenId_" . $product_details->product_id . "\" value = \"$product_details->product_id\"/>
                            
                        </td>
                       
                        <td>
                            <input type=\"text\" name=\"available_quantity[]\" class=\"form-control text-right available_quantity_" . $product_details->product_id . "\" value='" . $product_details->total_product . "' readonly=\"\" id=\"available_quantity_" . $product_details->product_id . "\"/>
                        </td>

                       
                    
                        <td>
                            <input type=\"text\" name=\"product_quantity[]\" onkeyup=\"quantity_calculate('" . $product_details->product_id . "');\" onchange=\"quantity_calculate('" . $product_details->product_id . "');\" class=\"total_qntt_" . $product_details->product_id . " form-control text-right\" id=\"total_qntt_" . $product_details->product_id . "\" placeholder=\"0.00\" min=\"0\" value=\"1\" required=\"required\"/>
                        </td>

                        <td style=\"width:85px\">
                            <input type=\"text\" name=\"product_rate[]\" onkeyup=\"quantity_calculate('" . $product_details->product_id . "');\" onchange=\"quantity_calculate('" . $product_details->product_id . "');\" value='" . $product_details->price . "' id=\"price_item_" . $product_details->product_id . "\" class=\"price_item1 form-control text-right\" required placeholder=\"0.00\" min=\"0\"/>
                        </td>

                        <td class=\"\">
                            <input type=\"text\" name=\"discount[]\" onkeyup=\"quantity_calculate('" . $product_details->product_id . "');\" onchange=\"quantity_calculate('" . $product_details->product_id . "');\" id=\"discount_" . $product_details->product_id . "\" class=\"form-control text-right\" placeholder=\"0.00\" min=\"0\"/>

                            <input type=\"hidden\" value=" . $currency_details[0]['discount_type'] . " name=\"discount_type\" id=\"discount_type_" . $product_details->product_id . "\">
                        </td>

                        <td class=\"text-right\" style=\"width:100px\">
                            <input class=\"total_price form-control text-right\" type=\"text\" name=\"total_price[]\" id=\"total_price_" . $product_details->product_id . "\" value='" . $product_details->price . "' tabindex=\"-1\" readonly=\"readonly\"/>
                        </td>

                        <td>";
                            $sl=0;
                        foreach ($taxfield as $taxes) {
                            $txs = 'tax'.$sl;
                           $tr .= "<input type=\"hidden\" id=\"total_tax".$sl."_" . $product_details->product_id . "\" class=\"total_tax".$sl."_" . $product_details->product_id . "\" value='" . $prinfo[0][$txs] . "'/>
                            <input type=\"hidden\" id=\"all_tax".$sl."_" . $product_details->product_id . "\" class=\" total_tax".$sl."\" value='" . $prinfo[0][$txs]*$product_details->price . "' name=\"tax[]\"/>";  
                       $sl++; }
                           $tr.="<input type=\"hidden\" id=\"total_discount_" . $product_details->product_id . "\" />
                            <input type=\"hidden\" id=\"all_discount_" . $product_details->product_id . "\" class=\"total_discount\"/>
                            <a style=\"text-align: right;\" class=\"btn btn-danger btn-xs\" href=\"#\"  onclick=\"deleteRow(this)\">" . '<i class="fa fa-close"></i>' . "</a>
                             <a style=\"text-align: right;\" class=\"btn btn-success btn-xs\" href=\"#\"  onclick=\"detailsmodal('".$product_details->product_name."','".$product_details->total_product."','".$product_details->product_model."','".$product_details->unit."','".$product_details->price."','".$product_details->image."')\">" . '<i class="fa fa-eye"></i>' . "</a>
                        </td>
                    </tr>";
            echo $tr;
        } else {
            return false;
        }
    }

        public function getitemlist(){
             $this->load->model('Invoices');
                $prod=$this->input->post('product_name');
                $catid=$this->input->post('category_id');
                $getproduct = $this->Invoices->searchprod($catid,$prod);
                if(!empty($getproduct)){
                $data['itemlist']=$getproduct;
                $this->load->view('invoice/getproductlist', $data);  
                }
                else{
                    echo 420;
                    }
        }
        public function instant_customer(){
      $this->load->model('Customers');
        $customer_id = $this->auth->generator(15);
        $vouchar_no = $this->auth->generator(10);
        //Customer  basic information adding.
        $coa = $this->Customers->headcode();
           if($coa->HeadCode!=NULL){
                $headcode=$coa->HeadCode+1;
           }else{
                $headcode="102030101";
            }
    $c_acc=$customer_id.'-'.$this->input->post('customer_name');
   $createby=$this->session->userdata('user_id');
  $createdate=date('Y-m-d H:i:s');
        $data = array(
            'customer_id'      => $customer_id,
            'customer_name'    => $this->input->post('customer_name'),
            'customer_address' => $this->input->post('address'),
            'customer_mobile'  => $this->input->post('mobile'),
            'customer_email'   => $this->input->post('email'),
            'status'           => 2
        );

    $customer_coa = [
             'HeadCode'         => $headcode,
             'HeadName'         => $c_acc,
             'PHeadName'        => 'Customer Receivable',
             'HeadLevel'        => '4',
             'IsActive'         => '1',
             'IsTransaction'    => '1',
             'IsGL'             => '0',
             'HeadType'         => 'A',
             'IsBudget'         => '0',
             'IsDepreciation'   => '0',
             'DepreciationRate' => '0',
             'CreateBy'         => $createby,
             'CreateDate'       => $createdate,
        ];

        $result = $this->Customers->customer_entry($data);
        if ($result == TRUE) {
            //Previous balance adding -> Sending to customer model to adjust the data.
            $this->db->insert('acc_coa',$customer_coa);
            $this->Customers->previous_balance_add($this->input->post('previous_balance'), $customer_id);
          
               $data['status'] = true;
                $data['message'] = display('save_successfully');
                $data['customer_id'] = $data['customer_id'];
                $data['customer_name'] = $data['customer_name'];
        } else {
            $data['status'] = false;
                $data['error_message'] = display('please_try_again');
        }
         echo json_encode($data);
        }

//        =========== its for recurring_invoice ===========
    public function recurring_invoice(){
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('linvoice');
        $CI->load->model('Invoices');
        $alldata = $this->input->post('all');
        if(!empty($alldata)){
            $perpagdata = $this->Invoices->recurring_invoice_count();
        }else{
          $perpagdata = 20;  
        }
        #
        #pagination starts
        #
        $config["base_url"] = base_url('Cinvoice/recurring_invoice/');
        $config["total_rows"] = $this->Invoices->recurring_invoice_count();
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
        $content = $this->linvoice->recurring_invoice_list($links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    
    }
    
}
