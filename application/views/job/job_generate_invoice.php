<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
//dd($Web_settings);
$date_format = $this->session->userdata('date_format');
?>

<!-- Printable area start -->
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        // document.body.style.marginTop="-45px";
        $("#show_hide_area").hide();
        window.print();
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
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error_message ?>                    
            </div>
            <?php
            $this->session->unset_userdata('error_message');
        }
//        d($get_job_info);
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div id="printableArea">
                        <form action="<?php echo base_url('Cjob/job_to_invoice_save'); ?>" method="post">
                            <div class="panel-body">
                                <div class="row" style="">
                                    <!--                                    <div class="col-sm-12 text-center" style="margin-bottom: 10px;"> 
                                                                            <img src="<?php
                                    echo base_url('assets/dist/img/garage_logo.JPG');
//                                    if (isset($Web_settings[0]['logo'])) {
//                                        echo $Web_settings[0]['logo'];
//                                    }
                                    ?>" class="" alt="" style="margin-bottom:20px">
                                                                        </div>-->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-responsive">
                                                <tr>
                                                    <td> 
                                                        <address>
                                                            <strong style="font-size: 20px; ">
                                                                <?php echo $get_job_info[0]->company_name; ?>
                                                                <input type="hidden" value="<?php echo $get_job_info[0]->job_id; ?>" name="job_id">
                                                                <input type="hidden" value="<?php echo $get_job_info[0]->customer_id; ?>" name="customer_id">
                                                            </strong><br>
                                                            <abbr><b><?php echo display('address'); ?>: <?php echo $get_job_info[0]->customer_address ?></b></abbr><br>
                                                            <abbr><b><?php echo display('dear'); ?> :</b></abbr> <?php echo $get_job_info[0]->customer_name; ?><br>
                                                            <abbr><b><?php echo display('email'); ?> :</b></abbr> <?php echo $get_job_info[0]->customer_email; ?> <br>
                                                            <abbr><b><?php echo display('mobile'); ?>: </b> </abbr><?php echo $get_job_info[0]->customer_mobile; ?><br>
                                                        </address>
                                                        <!--  <div class="check_show_hide">
                                                              <label for="show_hide" id="show_hide_area">
                                                                 <input type="checkbox" id="show_hide" onclick="check_show_hide()" value="1" checked> Show / Hide
                                                             </label>
                                                            <table class="table table-bordered show_hide_table" style="width: 50%">
                                                                 <tr>
                                                                     <th><?php echo display('vehicle_registration'); ?></th>
                                                                     <th>:</th>
                                                                     <td><?php echo $get_job_info[0]->vehicle_registration; ?></td>
                                                                 </tr>
                                                                 <tr>
                                                                     <th><?php echo display('odometer'); ?></th>
                                                                     <th>:</th>
                                                                     <td><?php echo $get_job_info[0]->odometer; ?></td>
                                                                 </tr>
                                                                 <tr>
                                                                     <th><?php echo display('hubo_meter'); ?></th>
                                                                     <th>:</th>
                                                                     <td><?php echo $get_job_info[0]->hubo_meter; ?></td>
                                                                 </tr>
                                                                 <tr>
                                                                     <th><?php echo display('date_in'); ?></th>
                                                                     <th>:</th>
                                                                     <td>2019-05-30</td>
                                                                 </tr>
                                                             </table>
                                                         </div>-->
                                                    </td>
                                                    <td>
    <!--                                                    <table class="table table-bordered">
                                                            <tr>
                                                                <th><?php echo display('invoice_date'); ?></th>
                                                                <th>:</th>
                                                                <td>2019-07-03</td>
                                                            </tr>
                                                            <tr>
                                                                <th><?php echo display('invoice_number'); ?></th>
                                                                <th>:</th>
                                                                <td>174128</td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="3" class="">Payment Terms 7 days</th>
                                                            </tr>
                                                            <tr>
                                                                <th><?php echo display('payment_status'); ?></th>
                                                                <th>:</th>
                                                                <td><strong class="text-danger">Unpaid</strong></td>
                                                            </tr>
                                                            <p style="height: 30px;"></p>
                                                            <tr>
                                                                <th><?php echo display('registration_due'); ?></th>
                                                                <th>:</th>
                                                                <td><?php echo $get_job_info[0]->registration_date; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?php echo display('cof_due'); ?></th>
                                                                <th>:</th>
                                                                <td><?php echo $get_job_info[0]->cof_wof_date; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?php echo display('service_due'); ?></th>
                                                                <th>:</th>
                                                                <td><?php // echo $get_job_info[0]->service_due;                            ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?php echo display('date_out'); ?></th>
                                                                <th>:</th>
                                                                <td>2019-05-28</td>
                                                            </tr>
                                                        </table>-->
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div> 
                                <div class="table-responsive m-b-2">
                                    <br>
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
//                                            dd($get_jobdetails_info);
                                            $amount = $spent_time = 0;
                                            if ($get_jobdetails_info) {
                                                foreach ($get_jobdetails_info as $jobdetails) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php
//                                                            echo date('Y-m-d', strtotime($jobdetails->end_datetime));
                                                            if ($date_format == 1) {
                                                                echo date('d-m-Y', strtotime($jobdetails->end_datetime));
                                                            } elseif ($date_format == 2) {
                                                                echo date('m-d-Y', strtotime($jobdetails->end_datetime));
                                                            } elseif ($date_format == 3) {
                                                                echo date('Y-m-d', strtotime($jobdetails->end_datetime));
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $jobdetails->job_type_name; ?>
                                                            <input type="hidden" name="product_id[]" class="form-control" value="<?php echo $jobdetails->job_type_id; ?>">
                                                        </td>
                                                        <td><?php echo $jobdetails->mechanic_notes; ?></td>
                                                        <td class="text-center">
                                                            <?php $spent_time += $jobdetails->spent_time; ?>
                                                            <input type="text" class="form-control text-center" name="spent_time[]" value="<?php echo $jobdetails->spent_time; ?>" readonly>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="text" class="form-control text-center" name="quantity[]" value="1" readonly>
                                                        </td>
                                                        <td class="text-right">
                                                            <input type="text" class="form-control text-right" name="rate[]" value="<?php echo $rate = $jobdetails->rate; ?>" readonly>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php $amount += $rate * 1; ?>
                                                            <input type="text" name="amount[]" class="form-control text-right" value="<?php echo $rate * 1; ?>" readonly>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            
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
                                                            <td>
                                                                <?php
//                                                                if ($product_used->product_name) {
                                                                echo $product_used->product_name;
//                                                                } else {
//                                                                    echo $product_used->group_name . " id " . $product_used->group_price_id;
//                                                                }
                                                                ?>
                                                                <input type="hidden" name="product_id[]" class="form-control" value="<?php echo $product_used->product_id; ?>">
                                                            </td>
                                                            <td><?php echo $product_used->mechanic_note; ?></td>
                                                            <td>
                                                                <input type="text" class="form-control text-center" name="spent_time[]" value="N/A"  readonly>
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="text" class="form-control text-center" name="quantity[]" value="<?php echo $quantity = $product_used->used_qty; ?>" readonly>
                                                            </td>
                                                            <td class="text-right">
                                                                <input type="text" class="form-control text-right" name="rate[]" value="<?php echo $rate = $product_used->rate; ?>" readonly>
                                                            </td>
                                                            <td class="text-right">
                                                                <?php $amount += $rate * $quantity; ?>
                                                                <!--<input type="text" name="amount[]" class="form-control text-right" value="<?php echo number_format($rate * $quantity, 2); ?>" readonly>-->
                                                                <input type="text" name="amount[]" class="form-control text-right" value="<?php echo $rate * $quantity; ?>" readonly>
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
                                                                    <input type="hidden" name="product_id[]" class="form-control" value="<?php echo $groupproduct->product_id; ?>">
                                                                </td>
                                                                <td><?php echo $groupproduct->product_name; ?></td>
                                                                <td></td>
                                                                <td>
                                                                    <input type="text" class="form-control text-center" name="spent_time[]" value="N/A"  readonly>
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" class="form-control text-center" name="quantity[]" value="<?php echo $quantity = ($groupproduct->group_product_qty) * ($product_used->used_qty); ?>" readonly>
                                                                </td>
                                                                <td class="text-right">
                                                                    <input type="text" class="form-control text-right" name="rate[]" value="<?php echo $rate = $groupproduct->product_rate; ?>" readonly>
                                                                </td>
                                                                <td class="text-right">
                                                                    <?php $amount += $rate * $quantity; ?>
                                                                    <input type="text" name="amount[]" class="form-control text-right" value="<?php echo $rate * $quantity; ?>" readonly>
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
                                                <td></td>
                                                <td class='text-right'>
                                                    <?php echo $Web_settings[0]['labour_cost']; ?>
                                                </td>
                                                <th class="text-right">
                                                    <?php
                                                    $labour_cost_spenttime = $Web_settings[0]['labour_cost'] * $spent_time;
                                                    echo $Web_settings[0]['labour_cost'] * $spent_time;
                                                    ?>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="5" rowspan="3">
                                                    <strong><?php echo display('recommendation_notes'); ?></strong><br>
                                                    <p>
                                                        <?php echo $get_job_info[0]->recommendation; ?>
                                                    </p>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="1" class="text-right"><?php echo display('sub_total'); ?></th>
                                                <th class="">
                                                    <input type="text" name="" id="" class="form-control text-right" value="<?php echo $amount + $labour_cost_spenttime; ?>" readonly>
                                                    <input type="hidden" name="sub_total" id="sub_total" class="form-control text-right" value="<?php echo $sub_amount = $amount + $labour_cost_spenttime; ?>">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="1" class="text-right"><?php echo display('discount'); ?> </th>
                                                <th class="text-right">
                                                    <input type=" text" class="form-control text-right discount"  onkeyup="discount_cals(this.value)" id="discount" name="discount">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="6" class="text-right"><?php echo display('gst') . " (" . $get_tax[0]->tax . "%)"; ?></th>
                                                <th class="text-right">
                                                    <?php
                                                    $tax = ($sub_amount * $get_tax[0]->tax) / 100;
                                                    ?>
                                                    <input type="text" name="gst" id="gst" value="<?php echo $tax; ?>" class="form-control text-right" readonly>
                                                    <input type="hidden" name="gst_percent" id="gst_percent" value="<?php echo $get_tax[0]->tax; ?>">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="6" class="text-right"><?php echo display('total'); ?></th>
                                                <th class="text-right">
                                                    <input type="hidden" name="labour_cost" value="<?php echo $Web_settings[0]['labour_cost']; ?>">
                                                    <input type="text" name="total" class="form-control text-right" id="total" value="<?php echo $sub_amount + $tax; ?>" readonly>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div style="width: 20%; float: right;">
                                        <input type="submit" class="form-control btn btn-info btn-sm" value="Save">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                    <!--                    <div class="panel-footer text-right">
                                            <a  class="btn btn-danger" href="<?php echo base_url('Cquotation/manage_quotation'); ?>"><?php echo display('cancel') ?></a>
                                        <button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>
                                    </div>-->
                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {

    });
//    ============ its for check_show_hide ===========/
//    function check_show_hide() {
//        $('.show_hide_table').slideToggle();
//    }
//=========== its for discount_cals ==========
    function discount_cals(dis) {
        var sub_total = $('#sub_total').val();
        var gst_percent = $('#gst_percent').val();
        var sub_total_discount = (sub_total - dis);
        var sub_total_discount_gst = (sub_total_discount * gst_percent) / 100;
        $("#gst").val(sub_total_discount_gst);
        $("#total").val(sub_total_discount + sub_total_discount_gst);
//        alert(sub_total_discount_gst);
    }
</script>