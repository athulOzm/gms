<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
?>
<style type="text/css">
    table{
        border-collapse: collapse;
        width: 100%;
    }
    table th, td {
        border: 1px solid black;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div id="printableArea">
                        <div class="panel-body">
                            <?php
//                            d(getcwd());
//                            d($Web_settings[0]['logo']); 
                            ?>
                            <!--                            <div class="row" >
                                                            <div class="col-sm-12" style="text-align: right; "> 
                                                                <img src="<?php
                            if (isset($Web_settings[0]['logo'])) {
                                echo getcwd() . $Web_settings[0]['logo'];
                            }
                            ?>" class="" alt="" style="margin-bottom:20px">
                                                            </div>
                                                        </div>-->
                            <img src="<?php
                            echo base_url('assets/dist/img/garage_logo.JPG');
                            ?>" class="" alt="" style="margin-bottom:20px">
                            <div class="firts_section" style="">
                                <div class="first_section_left"  style="width: 55%; display: inline-block;">
                                    <h3>Quotation</h3>
                                    <div>
                                        <strong style="font-size: 20px; "><?php echo $company_info[0]['company_name']; ?></strong><br>
                                        <?php echo $company_info[0]['address']; ?><br>
                                        <abbr><b> Mobile :</b></abbr> <?php echo $company_info[0]['mobile']; ?><br>
                                        <abbr><b>Email:</b></abbr> 
                                        <?php echo $company_info[0]['email']; ?><br>
                                        <abbr><b>Website : </b></abbr> 
                                        <?php echo $company_info[0]['website']; ?><br>
                                    </div>
                                </div>
                                <!--                                <div class="first_section_middle" style="width: 30%; display: inline-block; margin-top: 50px;">
                                
                                                                </div>-->
                                <div class="first_section_right"  style="width: 40%; display: inline-block; margin-top: 50px; float: right;">
                                    <div> 
                                        <strong style="font-size: 20px; "><?php echo $customer_info[0]['customer_name']; ?> </strong><br>
                                        <?php echo $customer_info[0]['customer_address']; ?><br>
                                        <abbr><b>Mobile :</b></abbr>
                                        <?php echo $customer_info[0]['customer_mobile']; ?> <br>
                                        <abbr><b>Email :</b></abbr> 
                                        <?php echo $customer_info[0]['customer_email']; ?><br>
                                        <abbr><b>Quotation Date :</b></abbr> 
                                        <?php echo $quot_main[0]['quotdate']; ?><br>
                                        <abbr><b>Quotation No :</b></abbr> 
                                        <?php echo $quot_main[0]['quot_no']; ?><br>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice_details_section">
                                <?php if ($quot_labour) { ?>
                                    <table class="invoice_details_table">
                                        <caption class="text-center"> <h2>Jobs Information </h2></caption>
                                        <thead>
                                            <tr>
                                                <th style="text-align: left;">Sl No</th>
                                                <th style="text-align: left;">Jobs</th>
                                                <th style="text-align: left;">Note</th>
                                                <th style="text-align: right;">Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sl = 1;
                                            foreach ($quot_labour as $labours) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $sl ?></td>
                                                    <td><?php echo $labours['job_type_name'] ?></td>
                                                    <td><?php echo nl2br($labours['note']) ?></td>
                                                    <td style="text-align: right;"><?php echo $labours['rate'] ?></td>
                                                </tr>
                                                <?php
                                                $sl++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
                            </div>

                            <div class="table-responsive m-b-20">
                                <?php if ($quot_product) { ?>
                                    <table class="table table-striped">
                                        <caption class="text-center"> <h2>Item Information </h2></caption>
                                        <thead>
                                            <tr>
                                                <th style="text-align: left; ">SL No</th>
                                                <th style="text-align: left;">Item</th>
                                                <th style="text-align: center;">Quatity</th>
                                                <th style="text-align: right;">Price</th>
                                                <th style="text-align: right;">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sl = 1;
                                            foreach ($quot_product as $item) {
                                                ?>
                                                <tr>
                                                    <td style="text-align: left;"><?php echo $sl ?></td>
                                                    <td style="text-align: left;"><?php echo $item['product_name'] ?></td>
                                                    <td style="text-align: center;"><?php echo $item['used_qty'] ?></td>
                                                    <td style="text-align: right;"><?php echo $item['rate'] ?></td>
                                                    <td style="text-align: right;"><?php echo $item['rate'] * $item['used_qty'] ?></td>
                                                </tr>
                                                <?php
                                                $sl++;
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" style="text-align: right; "><b>Sub Total</b></td>
                                                <td style="text-align: right; "><b><?php echo $quot_main[0]['totalamount'] - $quot_main[0]['total_discount'] ?></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: right; "><b>Discount</b></td>
                                                <td style="text-align: right; "><b><?php echo $quot_main[0]['total_discount'] ?></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: right;"><b>Grand Total</b></td>
                                                <td style="text-align: right;"><b><?php echo $quot_main[0]['totalamount'] ?></b>      </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <?php } ?>
                            </div>                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->