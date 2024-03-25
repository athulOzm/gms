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
            <h1><?php echo display('quotation') ?></h1>
            <small><?php echo display('quotation_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('quotation') ?></a></li>
                <li class="active"><?php echo display('quotation_details') ?></li>
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
                                <div class="col-sm-8" style="">
                                    <address>
                                        <strong style="font-size: 20px; ">SELWYN CARE LTD</strong><br>
                                        Address:Unit 3/38 Eagle Hurst Road Ellerslie, Auckland 1016<br>
                                        <abbr><b>Address: PO Box 8203, Symonds Street, Auckland 1150</b></abbr><br>
                                        <abbr><b>Dear :</b></abbr> Sane Tanielu<br>
                                        <abbr><b>Email :</b></abbr> Sane.Tanielu@selwynfoundation.org.nz <b>/ Ph: </b> +64 21 2294932<br>
                                    </address>
                                    <br>
                                    <table class="table table-bordered" style="width: 50%">
                                        <tr>
                                            <th>Vehicle Reg</th>
                                            <th>:</th>
                                            <td>JDJ570</td>
                                        </tr>
                                        <tr>
                                            <th>Odometer</th>
                                            <th>:</th>
                                            <td>214,494</td>
                                        </tr>
                                        <tr>
                                            <th>Hubo Meter</th>
                                            <th>:</th>
                                            <td>85,285</td>
                                        </tr>
                                        <tr>
                                            <th>Date In</th>
                                            <th>:</th>
                                            <td>2019-05-30</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-4 text-left">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Invoice Date</th>
                                            <th>:</th>
                                            <td>2019-07-03</td>
                                        </tr>
                                        <tr>
                                            <th>Invoice Number</th>
                                            <th>:</th>
                                            <td>174128</td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="">Payment Terms 7 days</th>
                                        </tr>
                                        <tr>
                                            <th>Payment Status</th>
                                            <th>:</th>
                                            <td><strong class="text-danger">Unpaid</strong></td>
                                        </tr>
                                        <p style="height: 30px;"></p>
                                        <tr>
                                            <th>Registration Due</th>
                                            <th>:</th>
                                            <td>2019-05-28</td>
                                        </tr>
                                        <tr>
                                            <th>COF Due</th>
                                            <th>:</th>
                                            <td>2019-05-28</td>
                                        </tr>
                                        <tr>
                                            <th>Service Due</th>
                                            <th>:</th>
                                            <td>2019-05-28</td>
                                        </tr>
                                        <tr>
                                            <th>Date Out</th>
                                            <th>:</th>
                                            <td>2019-05-28</td>
                                        </tr>
                                    </table>
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
                                            <th class="text-right"><?php echo display('unit_price') ?>Unit Price</th>
                                            <th class="text-right"><?php echo display('amount') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $amount = 0;
                                        if ($get_jobdetails_info) {
                                            foreach ($get_jobdetails_info as $jobdetails) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $jobdetails->job_type_name; ?></td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-right"><?php echo $rate = $jobdetails->rate; ?></td>
                                                    <td class="text-right">
                                                        <?php
                                                        $amount += $rate * 1;
                                                        echo $rate * 1;
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
                                                        $amount += $rate*$quantity;
                                                        echo $rate * $quantity;
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
                                                    <?php // echo $get_job_info[0]->recommendation; ?>
                                                </p>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="1" class="text-right">Sub Total</th>
                                            <th class="text-right"><?php echo $amount; ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="1" class="text-right">GST</th>
                                            <th class="text-right">
                                                <?php
                                                $tax = ($amount * $get_tax[0]->tax) / 100;
                                                echo $tax;
                                                ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right">Total</th>
                                            <th class="text-right">
                                                <?php echo $amount + $tax; ?>
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
                        <a  class="btn btn-danger" href="<?php echo base_url('Cquotation/manage_quotation'); ?>"><?php echo display('cancel') ?></a>
                        <button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
