
<!-- Product Report Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('sales_report_product_wise') ?></h1>
            <small><?php echo display('sales_report_product_wise') ?></small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('report') ?></a></li>
                <li class="active"><?php echo display('sales_report_product_wise') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-sm-12">
                <div class="column m-b-5 float_right">
                    <?php if ($this->permission1->method('todays_sales_report', 'read')->access()) { ?>
                        <a href="<?php echo base_url('Admin_dashboard/todays_sales_report') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('sales_report') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->method('todays_purchase_report', 'read')->access()) { ?>
                        <a href="<?php echo base_url('Admin_dashboard/todays_purchase_report') ?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('purchase_report') ?> </a>
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

        <!-- Product report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <?php echo form_open('Admin_dashboard/product_sales_search_reports', array('class' => 'form-inline', 'method' => 'get')) ?>
                        <?php
                        date_default_timezone_set("Asia/Dhaka");
                        $today = date('Y-m-d');
                        ?>
                        <div class="form-group">
                            <label class="" for="from_date"><?php echo display('start_date') ?></label>
                            <input type="text" name="from_date" class="form-control datepicker" id="from_date" placeholder="<?php echo display('start_date') ?>" >
                        </div> 

                        <div class="form-group">
                            <label class="" for="to_date"><?php echo display('end_date') ?></label>
                            <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="">
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
                            <h4><?php echo display('sales_report_product_wise') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="purchase_div" class="table-responsive m-l-2">
                            <table border="0" width="100%" class="m-b-10">
                                <tr>
                                    <td align="left" class="b-b-2-solid">
                                        <img src="<?php echo $software_info[0]['logo']; ?>" alt="logo">
                                    </td>
                                    <td align="left" class="b-b-2-solid">
                                        <span class="custom_hding">
                                            <?php echo $company[0]['company_name']; ?>
                                        </span>
                                        <br>
                                        <?php echo $company[0]['address']; ?>
                                        <br>
                                        <?php echo $company[0]['email']; ?>
                                        <br>
                                        <?php echo $company[0]['mobile']; ?>
                                    </td>
                                    <td align="right" class="b-b-2-solid">
                                <date>
                                    <?php echo display('date') ?>: 
                                    <?php
                                    $CI = & get_instance();
                                    $CI->load->library('Occational');
                                    $today = $CI->occational->dateConvertMyformat(date('d-M-Y'));
                                    echo $today;
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
                                            <th><?php echo display('product_name') ?></th>
                                            <th><?php echo display('product_model') ?></th>
                                            <th><?php echo display('customer_name') ?></th>
                                            <th class="text-right"><?php echo display('rate') ?></th>
                                            <th class="text-right"><?php echo display('total_ammount') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($product_report) {
                                            ?>
                                            {product_report}
                                            <tr>
                                                <td>{sales_date}</td>
                                                <td>{product_name}</td>
                                                <td>{product_model}</td>
                                                <td>{customer_name}</td>
                                                <td class="text-right"><?php echo (($position == 0) ? "$currency {rate}" : "{rate} $currency") ?></td>
                                                <td class="text-right"><?php echo (($position == 0) ? "$currency {total_price}" : "{total_price} $currency") ?></td>
                                            </tr>
                                            {/product_report}
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right">&nbsp; <b><?php echo display('total_ammount') ?></b></td>
                                            <td class="text-right"><b><?php echo (($position == 0) ? "$currency {sub_total}" : "{sub_total} $currency") ?></b></td>
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
<!-- Product Report End -->
