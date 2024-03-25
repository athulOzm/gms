<link href="<?php echo base_url('assets/custom/job.css') ?>" rel="stylesheet" type="text/css"/>
<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$company_info = $CI->db->get('company_information')->row();
//echo '<pre>';print_r($company_info);//die();
$currency = $currency_details[0]['currency'];
$position = $currency_details[0]['currency_position'];
?>

<!-- Printable area start -->
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        $(".gateway_icon").hide();
        window.print();
        location.reload();
        document.body.innerHTML = originalContents;
    }
</script>
<!-- Printable area end -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('jobs') ?></h1>
            <small><?php echo display('invoice_generate') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('jobs') ?></a></li>
                <li class="active"><?php echo display('invoice_generate') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Alert Message -->
        <div class="alert_message">      <!-- Alert Message -->
            <?php
            $message = $this->session->userdata('message');
            if (isset($message)) {
                ?>
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $message ?>                    
                </div>
                <?php
                $this->session->unset_userdata('message');
            }
            $error_message = $this->session->userdata('error_message');
            if (isset($error_message)) {
                ?>
                <!--                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error_message ?>                    
                                </div>-->
                <?php
                $this->session->unset_userdata('error_message');
            }
            ?>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div id="printableArea">
                        <style type="text/css">
                            @media print {
                                a[href]:after {
                                    content: none !important;
                                }
                            }
                        </style>
                        <div class="panel-body">
                            <div class="row" >
                                <?php // dd($get_invoice_info); ?>
                                <div class="col-sm-12 text-right">
<!--                                     <img src="<?php
                                    echo getcwd() . '/assets/dist/img/garage_logo.JPG';
//                                    if (isset($Web_settings[0]['logo'])) {
//                                        echo $Web_settings[0]['logo'];
//                                    }
                                    ?>" class="" alt="" style="margin-bottom:20px">-->
                                    <img src="<?php
                                    if (isset($Web_settings[0]['invoice_logo'])) {
                                        echo $Web_settings[0]['invoice_logo'];
                                    }
                                    ?>" class="m-b-20" alt="">
                                </div>
                            </div>
                            <div class="row m-l-5">
                                <div class="firts_section" style="display: flex;">
                                    <div class="first_section_left" style="width: 40%; margin-top: 5px; ">
                                        <h3 class=""><?php echo display('invoice_details') ?></h3>
                                        <address>
                                            <strong style="font-size: 18px; "><?php echo $get_invoice_info[0]->company_name; ?></strong><br>
                                            <abbr><b><?php echo display('address'); ?>: <?php echo nl2br($get_invoice_info[0]->customer_address) ?></b></abbr><br>
                                            <abbr><b><?php echo display('attention'); ?> :</b></abbr> <?php echo $get_invoice_info[0]->customer_name; ?><br>
                                            <abbr><b><?php echo display('email'); ?> :</b></abbr> <?php echo $get_invoice_info[0]->customer_email; ?> <br>
                                            <abbr><b><?php echo display('phone'); ?>: </b></abbr> <?php echo $get_invoice_info[0]->customer_phone; ?>
                                        </address>
                                        <?php if ($get_invoice_info[0]->show_hide_status == 1) { ?>
                                            <address style="font-size: 12px;"> 
                                                <?php if ($get_invoice_info[0]->vehicle_registration) { ?>
                                                    <abbr><b><?php echo display('vehicle_registration'); ?> : </b><?php echo $get_invoice_info[0]->vehicle_registration; ?></abbr><br>
                                                <?php } if ($get_invoice_info[0]->odometer) { ?>
                                                    <abbr><b><?php echo display('odometer'); ?> : </b><?php echo $get_invoice_info[0]->odometer; ?></abbr><br>
                                                <?php } if ($get_invoice_info[0]->hubo_meter) { ?>
                                                    <abbr><b><?php echo display('hubo_meter'); ?> : </b><?php echo $get_invoice_info[0]->hubo_meter; ?></abbr><br>
                                                <?php } if ($get_invoice_info[0]->hour_meter) { ?>
                                                    <abbr><b><?php echo display('hour_meter'); ?> : </b><?php echo $get_invoice_info[0]->hour_meter; ?></abbr><br>
                                                <?php } if ($get_invoice_info[0]->cof_wof_date) { ?>
                                                    <abbr><b><?php echo display('cof_wof_date'); ?> : </b><?php echo $get_invoice_info[0]->cof_wof_date; ?></abbr><br>
                                                <?php } if ($get_invoice_info[0]->registration_date) { ?>
                                                    <abbr><b><?php echo display('registration_date'); ?> : </b><?php echo $get_invoice_info[0]->registration_date; ?></abbr><br>
                                                <?php } if ($get_invoice_info[0]->fuel_burn) { ?>
                                                    <abbr><b><?php echo display('fuel_burn'); ?> : </b><?php echo $get_invoice_info[0]->fuel_burn; ?></abbr><br>
                                                <?php } ?>
                                            </address>
                                        <?php } ?>
                                    </div>
                                    <div class="first_section_middle" style="width: 30%; margin-top: 30px;">
                                        <address> 
                                            <?php if ($get_invoice_info[0]->date != '0000-00-00') { ?>
                                                <abbr><b><?php echo display('invoice_date'); ?> : </b></abbr>
                                                <?php
                                                $date_format = $this->session->userdata('date_format');
                                                if ($date_format == 1) {
                                                    echo date('d-m-Y', strtotime($get_invoice_info[0]->date));
                                                } elseif ($date_format == 2) {
                                                    echo date('m-d-Y', strtotime($get_invoice_info[0]->date));
                                                } elseif ($date_format == 3) {
                                                    echo date('Y-m-d', strtotime($get_invoice_info[0]->date));
                                                }
                                                ?>
                                                <br>
                                            <?php } if ($get_invoice_info[0]->invoice_id) { ?>
                                                <abbr><b><?php echo display('invoice_number'); ?> : </b></abbr>
                                                <?php echo $get_invoice_info[0]->invoice_id; ?><br>
                                            <?php } if ($get_invoice_info[0]->customer_ref) { ?>
                                                <abbr><b><?php echo display('reference'); ?> </b> : </abbr>
                                                <?php echo $get_invoice_info[0]->customer_ref; ?><br>     
                                                <?php
                                            }
                                            if ($get_invoice_info[0]->date != '0000-00-00') {
                                                ?>
                                                <abbr>
                                                    <b><?php echo display('due_date'); ?> : </b>
                                                </abbr>
                                                <?php
//                                                echo $get_invoice_info[0]->date;echo "X". $get_invoice_info[0]->payment_period." XX ";
                                                $payment_period = '';
                                                if ($get_invoice_info[0]->payment_period) {
                                                    $due_date = strtotime($get_invoice_info[0]->date);
                                                    $payment_period = $get_invoice_info[0]->payment_period;
                                                    if ($date_format == 1) {
//                                                    echo date('d-m-Y', strtotime("+7 day", $due_date));
                                                        echo date('d-m-Y', strtotime("+$payment_period day", $due_date));
                                                    } elseif ($date_format == 2) {
                                                        echo date('m-d-Y', strtotime("+$payment_period day", $due_date));
                                                    } elseif ($date_format == 3) {
                                                        echo date('Y-m-d', strtotime("+$payment_period day", $due_date));
                                                    }
                                                } else {
                                                    if ($date_format == 1) {
                                                        echo date('d-m-Y', strtotime($get_invoice_info[0]->date));
                                                    } elseif ($date_format == 2) {
                                                        echo date('m-d-Y', strtotime($get_invoice_info[0]->date));
                                                    } elseif ($date_format == 3) {
                                                        echo date('Y-m-d', strtotime($get_invoice_info[0]->date));
                                                    }
                                                }
                                                ?><br>  
                                            <?php } ?>  
<!--<abbr><b><?php echo display('gst'); ?> : </b>105372230</abbr>-->
                                        </address>
                                    </div>
                                    <div class="first_section_right"  style="width: 30%; margin-top: 30px;">
                                        <address style="font-size: 12px;"> 
                                            <abbr><b><?php echo $company_info->company_name; ?></b></abbr><br>
                                            <abbr><b><?php echo $company_info->email; ?></b></abbr><br>
                                            <abbr><b><?php echo $company_info->mobile; ?></b></abbr><br>
                                            <abbr><b><?php echo $company_info->address; ?></b></abbr><br>
                                            <abbr><b><?php echo $company_info->website; ?></b></abbr><br>
                                        </address>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive m-b-20">
                                <table class="table table-bordered">
 <!--                                    <caption class="text-center"> 
                                         <h2>Jobs Information </h2>
                                     </caption>-->
                                    <thead>
                                        <tr>
                                            <th class="text-left" width="15%"><?php echo display('date') ?></th>
                                            <th class="text-left" width="25%"><?php echo display('service') ?></th>
                                            <th class="text-left" width="20%"><?php echo display('notes') ?></th>
                                            <th class="text-center" width="10%"><?php echo display('spent_time') ?></th>
                                            <th class="text-center" width="10%"><?php echo display('qty') ?></th>
                                            <th class="text-right" width="10%"><?php echo display('unit_price') ?></th>
                                            <th class="text-right" width="10%"><?php echo display('amount') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                        d($get_invoicedetails);
                                        $amount = $spent_time = $sptime = 0;
                                        if ($get_invoicedetails) {
                                            foreach ($get_invoicedetails as $jobdetails) {
                                                $jod_details_item = $this->db->select('*')->from('job_details')->where('job_type_id', $jobdetails->product_id)
                                                                ->where('job_id', $jobdetails->job_id)->get()->row();
//                                                echo $this->db->last_query();
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php
//                                                        echo $jod_details_item->end_datetime; 
                                                        if ($jod_details_item->end_datetime != ' ') {
//                                                            echo date('Y-m-d', strtotime($jod_details_item->end_datetime));
                                                            if ($date_format == 1) {
                                                                echo date('d-m-Y', strtotime($jod_details_item->end_datetime));
                                                            } elseif ($date_format == 2) {
                                                                echo date('m-d-Y', strtotime($jod_details_item->end_datetime));
                                                            } elseif ($date_format == 3) {
                                                                echo date('Y-m-d', strtotime($jod_details_item->end_datetime));
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $jobdetails->job_type_name; ?></td>
                                                    <td><?php echo $jod_details_item->mechanic_notes; ?></td>
                                                    <td style="text-align: center">
                                                        <?php
                                                        $spent_time += $jod_details_item->spent_time;
//                                                        $spent_time = is_numeric($sptime);
                                                        echo $jod_details_item->spent_time;
                                                        ?>
                                                    </td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-right">
                                                        <?php
                                                        $rate = $jobdetails->rate;
                                                        echo (($position == 0) ? "$currency $rate" : "$rate $currency");
                                                        ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php
                                                        $amount += $rate * 1;
                                                        $format_servicettlrate = number_format($rate * 1, 2);
                                                        echo (($position == 0) ? "$currency $format_servicettlrate" : "$format_servicettlrate $currency")
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
//                                        d($get_job_products_used);
                                        if ($get_job_products_used) {
                                            foreach ($get_job_products_used as $product_used) {
                                                if (!$product_used->group_price_id) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php
                                                            if ($date_format == 1) {
                                                                echo date('d-m-Y', strtotime($product_used->created_date));
                                                            } elseif ($date_format == 2) {
                                                                echo date('m-d-Y', strtotime($product_used->created_date));
                                                            } elseif ($date_format == 3) {
                                                                echo date('Y-m-d', strtotime($product_used->created_date));
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $product_used->product_name; ?></td>
                                                        <td><?php echo $product_used->mechanic_note; ?></td>
                                                        <td class="text-center" style="font-size: 11px;">N/A</td>
                                                        <td class="text-center">
                                                            <?php echo $quantity = $product_used->used_qty; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php
                                                            $only_rate = $product_used->rate;
                                                            $prd_rate = number_format($product_used->rate, 2);
                                                            echo (($position == 0) ? "$currency $prd_rate" : "$prd_rate $currency");
                                                            ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php
                                                            $amount += $only_rate * $quantity;
                                                            $format_rate = number_format($only_rate * $quantity, 2);
                                                            echo (($position == 0) ? "$currency $format_rate" : "$format_rate $currency");
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } else {
                                                    $this->db->select('*')->from('group_pricing_details a');
                                                    $this->db->join('product_information b', 'b.product_id = a.product_id');
                                                    $this->db->where('a.group_price_id', $product_used->group_price_id);
                                                    $getgroupproducts = $this->db->get()->result();
                                                    foreach ($getgroupproducts as $groupproduct) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                if ($date_format == 1) {
                                                                    echo date('d-m-Y', strtotime($product_used->created_date));
                                                                } elseif ($date_format == 2) {
                                                                    echo date('m-d-Y', strtotime($product_used->created_date));
                                                                } elseif ($date_format == 3) {
                                                                    echo date('Y-m-d', strtotime($product_used->created_date));
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $groupproduct->product_name; ?>
                                                            </td>
                                                            <td></td>
                                                            <td class="text-center" style="font-size: 11px;">N/A</td>
                                                            <td class="text-center"><?php echo $groupqty = ($groupproduct->group_product_qty) * ($product_used->used_qty); ?></td>
                                                            <td class="text-right">
                                                                <?php
                                                                $only_grouprate = $groupproduct->product_rate;
                                                                $prd_grouprate = number_format($groupproduct->product_rate, 2);
                                                                echo (($position == 0) ? "$currency $prd_grouprate" : "$prd_grouprate $currency");
                                                                ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <?php
                                                                $amount += $only_grouprate * $groupqty;
                                                                $format_grouprate = number_format($only_grouprate * $groupqty, 2);
                                                                echo (($position == 0) ? "$currency $format_grouprate" : "$format_grouprate $currency");
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td><?php echo display('labour_cost'); ?></td>
                                            <td>
                                            </td>
                                            <td class='text-center'>
                                                <?php echo $spent_time; ?>
                                            </td>
                                            <td class="text-center" style="font-size: 11px;">N/A</td>
                                            <td class='text-right'>
                                                <?php
                                                $laboutcost = $Web_settings[0]['labour_cost'];
                                                echo (($position == 0) ? "$currency $laboutcost" : "$laboutcost $currency");
                                                ?>
                                            </td>
                                            <th class="text-right">
                                                <?php
                                                $labour_cost_spenttime = $Web_settings[0]['labour_cost'] * $spent_time;
                                                $format_labourcost = number_format($Web_settings[0]['labour_cost'] * $spent_time, 2);
                                                echo (($position == 0) ? "$currency $format_labourcost " : "$format_labourcost $currency");
                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="5" rowspan="2">
                                                <strong><?php echo display('recommendation_notes'); ?></strong><br>
                                                <p>
                                                    <?php echo nl2br($get_invoice_info[0]->recommendation); ?>
                                                </p>
                                            </th>                                            
                                            <th colspan="1" class="text-right"><?php echo display('sub_total'); ?></th>
                                            <th class="text-right">
                                                <?php
                                                //echo $amount."+".$labour_cost_spenttime;
                                                $sub_amount = $amount + $labour_cost_spenttime;
                                                $format_subamount = number_format($sub_amount, 2);
                                                echo (($position == 0) ? "$currency $format_subamount" : "$format_subamount $currency");
                                                ?>
                                            </th>                                          
                                        </tr>
                                        <tr>
                                            <th colspan="1" class="text-right"><?php echo display('discount'); ?> </th>
                                            <th class="text-right">
                                                <?php
                                                $invoice_discount = $get_invoice_info[0]->invoice_discount;
                                                echo (($position == 0) ? "$currency $invoice_discount" : "$invoice_discount $currency");
                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="6" class="text-right"><?php echo display('gst') . " (" . $get_tax[0]->tax . "%)"; ?></th>
                                            <th class="text-right">
                                                <?php
//                                                $tax = ($amount * $get_tax[0]->tax) / 100;
                                                $tax = (($sub_amount - $get_invoice_info[0]->invoice_discount) * $get_tax[0]->tax) / 100;
                                                $format_tax = number_format($tax, 2);
                                                echo (($position == 0) ? "$currency $format_tax" : "$format_tax $currency");
                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="6" class="text-right"><?php echo display('total'); ?></th>
                                            <th class="text-right">
                                                <?php
                                                $total_amount = ($sub_amount - $get_invoice_info[0]->invoice_discount) + $tax;
                                                $format_ttlamount = number_format($total_amount, 2);
                                                echo (($position == 0) ? "$currency $format_ttlamount" : "$format_ttlamount $currency")
                                                ?>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="gateway_icon">
                                        <a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Visa">
                                            <img src="<?php echo base_url(); ?>assets/visa.png" class="" alt="" style="width: 7%">
                                        </a>
                                        <a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Master Card">
                                            <img src="<?php echo base_url(); ?>assets/master_card.png" class="" alt="" style="width: 8%">
                                        </a>
                                        <a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Paypal">
                                            <img src="<?php echo base_url(); ?>assets/paypal.png" class="" alt="" style="width: 10%">
                                        </a>
                                        <br>
                                        <?php
                                        $customer_id = $get_invoice_info[0]->customer_id;
                                        $invoice_id = $get_invoice_info[0]->invoice_id;
                                        $price = $total_amount;
                                        ?>
<!--                                        <a href="<?php echo base_url('Paypal/buy/' . $customer_id . "/" . $invoice_id . "/" . $price); ?>">
                                            View and pay online now
                                        </a>-->
                                    </div>
                                    <div>Acct No: 12-3021-0354872-00</div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                        </div>
                    </div>
                    <div class="panel-footer text-left">
                        <?php if ($this->session->userdata('user_type') != 3) { ?>
                            <a class="btn btn-success" id="send_customer_invoice" href="<?php echo base_url('Cjob/invoice_pdf_generate/' . $get_invoice_info[0]->job_id); ?>"><?php echo display('send_to_customer'); ?></a>
                        <?php } ?>
                        <a  class="btn btn-danger" href="<?php echo base_url('Cjob/manage_job'); ?>"><?php echo display('cancel') ?></a>
                        <button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>
                    </div>

                </div>
            </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

