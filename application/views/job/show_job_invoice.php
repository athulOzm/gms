<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
//dd($Web_settings);
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
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div id="printableArea">
                        <div class="panel-body">
                            <div class="row" style="border-bottom:2px #333 solid;">
                                <div class="col-sm-12 text-center" style="margin-bottom: 10px;"> 
                                    <img src="<?php
                                     echo base_url('assets/dist/img/garage_logo.JPG');
//                                    if (isset($Web_settings[0]['logo'])) {
//                                        echo $Web_settings[0]['logo'];
//                                    }
                                    ?>" class="" alt="" style="margin-bottom:20px">
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-responsive">
                                            <tr>
                                                <td>  <address>
                                                        <strong style="font-size: 20px; "><?php echo $get_invoice_info[0]->company_name; ?></strong><br>
                                                        <abbr><b><?php echo display('address'); ?>: <?php echo $get_invoice_info[0]->customer_address ?></b></abbr><br>
                                                        <abbr><b><?php echo display('dear'); ?> :</b></abbr> <?php echo $get_invoice_info[0]->customer_name; ?><br>
                                                        <abbr><b><?php echo display('email'); ?> :</b></abbr> <?php echo $get_invoice_info[0]->customer_email; ?> <b>/ <?php echo display('phone'); ?>: </b> <?php echo $get_invoice_info[0]->customer_phone; ?><br>
                                                    </address>
                                                    <div class="check_show_hide">
                                                        <label for="show_hide" id="show_hide_area">
                                                            <input type="checkbox" id="show_hide" value="1" onclick="check_show_hide(this.value),$(this).attr('value', this.checked ? 1 : 0)" checked> Show / Hide
                                                        </label>
                                                        <table class="table table-bordered show_hide_table" style="width: 50%">
                                                            <tr>
                                                                <th><?php echo display('vehicle_registration'); ?></th>
                                                                <th>:</th>
                                                                <td><?php echo $get_invoice_info[0]->vehicle_registration; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?php echo display('odometer'); ?></th>
                                                                <th>:</th>
                                                                <td><?php echo $get_invoice_info[0]->odometer; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?php echo display('hubo_meter'); ?></th>
                                                                <th>:</th>
                                                                <td><?php echo $get_invoice_info[0]->hubo_meter; ?></td>
                                                            </tr>
<!--                                                            <tr>
                                                                <th><?php echo display('date_in'); ?></th>
                                                                <th>:</th>
                                                                <td>2019-05-30</td>
                                                            </tr>-->
                                                        </table>
                                                    </div></td>
                                                <td>
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th><?php echo display('invoice_date'); ?></th>
                                                            <th>:</th>
                                                            <td><?php echo $get_invoice_info[0]->date; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo display('invoice_number'); ?></th>
                                                            <th>:</th>
                                                            <td><?php echo $get_invoice_info[0]->invoice; ?></td>
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
                                                            <td><?php echo $get_invoice_info[0]->registration_date; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo display('cof_due'); ?></th>
                                                            <th>:</th>
                                                            <td><?php echo $get_invoice_info[0]->cof_wof_date; ?></td>
                                                        </tr>
                                                    </table>
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
                                            <!--<th><?php echo display('date') ?></th>-->
                                            <th class="text-left"><?php echo display('description') ?></th>
                                            <th class="text-center"><?php echo display('qty') ?></th>
                                            <th class="text-right"><?php echo display('unit_price') ?></th>
                                            <th class="text-right"><?php echo display('amount') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $amount = 0;
                                        if ($get_invoicedetails) {
                                            foreach ($get_invoicedetails as $jobdetails) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $jobdetails->job_type_name; ?></td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-right"><?php echo $rate = $jobdetails->rate; ?></td>
                                                    <td class="text-right">
                                                        <?php
                                                        $amount += $rate * 1;
                                                        echo number_format($rate * 1, 2);
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        if ($get_job_products_used) {
                                            foreach ($get_job_products_used as $product_used) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $product_used->product_name; ?></td>
                                                    <td class="text-center">
                                                        <?php echo $quantity = $product_used->used_qty; ?>
                                                    </td>
                                                    <td class="text-right"><?php echo $rate = $product_used->rate; ?></td>
                                                    <td class="text-right">
                                                        <?php
                                                        $amount += $rate * $quantity;
                                                        echo number_format($rate * $quantity, 2);
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <th colspan="2" rowspan="3">
                                                <strong><?php echo display('recommendation_notes'); ?></strong><br>
                                                <p>
                                                    <?php // echo $get_invoice_info[0]->recommendation; ?>
                                                </p>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="1" class="text-right"><?php echo display('sub_total'); ?></th>
                                            <th class="text-right">
                                                <?php echo number_format($amount, 2);
                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="1" class="text-right"><?php echo display('discount'); ?> </th>
                                            <th class="text-right">
                                                <?php
                                                echo $get_invoice_info[0]->invoice_discount;
                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right"><?php echo display('gst') . " (" . $get_tax[0]->tax . "%)"; ?></th>
                                            <th class="text-right">
                                                <?php
//                                                $tax = ($amount * $get_tax[0]->tax) / 100;
                                                $tax = (($amount - $get_invoice_info[0]->invoice_discount) * $get_tax[0]->tax) / 100;
                                                echo number_format($tax, 2);
                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right"><?php echo display('total'); ?></th>
                                            <th class="text-right">
                                                <?php $total_amount = ($amount-$get_invoice_info[0]->invoice_discount) + $tax;
                                                echo number_format($total_amount, 2);
                                                ?>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="print_footer">
                                <center style="font-size: 11px; line-height: 8px;    font-weight: bold;">
                                    <p>Truck Systems NZ LTD</p>
                                    <p>P.O Box 85061, Mt Wellington, Auckland 1060, NZ</p>
                                    <p>GST: 105372230 | Incorporation Number: 3084205 | Acct No: 12-3021-0354872-00</p>
                                    <p>P: +64 9 580 1089│M: +64 21 494 164│E: trucksystems@gmail.com | W: www.trucksystems.co.nz</p>
                                </center>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer text-left">
                        <a class="btn btn-success" id="send_customer_invoice" href="<?php echo base_url('Cjob/invoice_pdf_generate/'.$get_invoice_info[0]->job_id); ?>/1"><?php echo display('send_to_customer'); ?></a>
                        <a  class="btn btn-danger" href="<?php echo base_url('Cjob/manage_job'); ?>"><?php echo display('cancel') ?></a>
                        <button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        
    });
//    ============ its for check_show_hide ===========/
    function check_show_hide(t) {
        if(t==1){
            show = 0;
        }else if(t ==0){
            show = 1
        }
        var url = "<?php echo base_url();?>Cjob/invoice_pdf_generate/<?php echo $get_invoice_info[0]->job_id; ?>/"+show
//        alert(url);
        $('#send_customer_invoice').attr('href', url);
        $('.show_hide_table').slideToggle();
    }
</script>