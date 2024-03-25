<!-- Stock report start -->
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        document.body.style.marginTop = "0px";
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>


<!-- Purchase Report Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('purchase_report') ?></h1>
            <small><?php echo display('total_purchase_report') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('report') ?></a></li>
                <li class="active"><?php echo display('purchase_report') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-sm-12">
                <div class="column m-b-5"  style="float: right;">
                    <?php if ($this->permission1->method('todays_sales_report', 'read')->access()) { ?>
                        <a href="<?php echo base_url('Admin_dashboard/todays_sales_report') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('sales_report') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->method('product_sales_reports_date_wise', 'read')->access()) { ?>
                        <a href="<?php echo base_url('Admin_dashboard/product_sales_reports_date_wise') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('sales_report_product_wise') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->method('todays_sales_report', 'read')->access() && $this->permission1->method('todays_purchase_report', 'read')->access()) { ?>
                        <a href="<?php echo base_url('Admin_dashboard/total_profit_report') ?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('profit_report') ?> </a>
                    <?php } ?>

                </div>
            </div>
        </div>

        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <?php echo form_open('Admin_dashboard/retrieve_dateWise_PurchaseReports', array('class' => 'form-inline', 'method' => 'get')) ?>
                        <?php
                        date_default_timezone_set("Asia/Dhaka");
                        $today = date('Y-m-d');
                        ?>
                        <div class="form-group">
                            <label class="" for="from_date"><?php echo display('start_date') ?></label>
                            <input type="text" name="from_date" class="form-control datepicker" id="from_date" value="<?php echo $today ?>" placeholder="<?php echo display('start_date') ?>" >
                        </div> 

                        <div class="form-group">
                            <label class="" for="to_date"><?php echo display('end_date') ?></label>
                            <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo $today ?>">
                        </div>  

                        <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
                        <a  class="btn btn-warning" href="#" onclick="printDiv('purchase_div')"><?php echo display('print') ?></a>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('purchase_report') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="purchase_div" style="margin-left:2px;" class="table-responsive">
                            <table border="0" width="100%" style="margin-bottom: 10px;padding-bottom: 0px">

                                <tr>
                                    <td align="left" style="border-bottom:2px #333 solid;">
                                        <img src="<?php echo $software_info[0]['logo']; ?>" alt="logo">
                                    </td>
                                    <td align="left" style="border-bottom:2px #333 solid;">
                                        <span style="font-size: 17pt; font-weight:bold;">
                                            <?php echo $company[0]['company_name']; ?>

                                        </span><br>
                                        <?php echo $company[0]['address']; ?>
                                        <br>
                                        <?php echo $company[0]['email']; ?>
                                        <br>
                                        <?php echo $company[0]['mobile']; ?>

                                    </td>

                                    <td align="right" style="border-bottom:2px #333 solid;">
                                <date>
                                    <?php echo display('date') ?>: <?php
                                    echo date('d-M-Y');
                                    ?> 
                                </date>
                                </td>
                                </tr>            

                            </table>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('sales_date') ?></th>
                                            <th><?php echo display('invoice_no') ?></th>
                                            <th><?php echo display('supplier_name') ?></th>
                                            <th><?php echo display('total_ammount') ?>  <?php echo form_open('Admin_dashboard/retrieve_dateWise_PurchaseReports', array('class' => 'form-inline', 'method' => 'get')) ?>
                                                <input type="hidden" value="<?php echo (!empty($from_date) ? $from_date : date('Y-m-d')) ?>" name="from_date">
                                                <input type="hidden" value="<?php echo (!empty($to_date) ? $to_date : date('Y-m-d')) ?>" name="to_date">
                                                <input type="hidden" name="all" value="all">
                                                <button type="submit" class="btn btn-success"><?php echo display('all') ?></button>
                                                <?php echo form_close() ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($purchase_report) {
                                            ?>
                                            {purchase_report}
                                            <tr>
                                                <td>{prchse_date}</td>
                                                <td>
                                                    <a href="<?php echo base_url() . 'cpurchase/purchase_details_data/{purchase_id}'; ?>">
                                                        {chalan_no}
                                                    </a>
                                                </td>
                                                <td>{supplier_name}</td>
                                                <td style="text-align: right;"><?php echo (($position == 0) ? "$currency {grand_total_amount}" : "{grand_total_amount} $currency") ?></td>
                                            </tr>
                                            {/purchase_report}
                                        <?php } else {
                                            ?>                                            
                                            <tr>
                                                <th class="text-center" colspan="6"><?php echo display('not_found'); ?></th>
                                            </tr> 
                                        <?php }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" align="right" style="text-align:right;font-size:14px !Important">&nbsp; <b><?php echo display('total_purchase') ?> </b></td>
                                            <td style="text-align: right;"><b><?php echo (($position == 0) ? "$currency {purchase_amount}" : "{purchase_amount} $currency") ?></b></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="text-right"><?php echo $links ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Purchase Report End -->