<!-- Product js php -->
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/product.js.php" ></script>

<!-- Stock List Supplier Wise Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('stock_report_supplier_wise') ?></h1>
            <small><?php echo display('stock_report_supplier_wise') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('stock') ?></a></li>
                <li class="active"><?php echo display('stock_report_supplier_wise') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-sm-12">
                <div class="column m-b-5 float_right">
                    <?php if ($this->permission1->check_label('stock_report_product_wise')->read()->access()) { ?>
                        <a href="<?php echo base_url('Creport/stock_report_product_wise') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('stock_report_product_wise') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->check_label('stock_report')->read()->access()) { ?>
                        <a href="<?php echo base_url('Creport') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('stock_report') ?> </a>
                    <?php } ?>
                </div>
            </div>
        </div>


<!--        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <?php echo form_open('Creport/stock_report_supplier_wise', array('class' => 'form-vertical', 'id' => 'stock_report_supplier_wise')); ?>
                        <?php
                        date_default_timezone_set("Asia/Dhaka");
                        $today = date('Y-m-d');
                        ?>

                        <div class="form-group row">
                            <label for="supplier_id" class="col-sm-3 col-form-label"><?php echo display('select_supplier') ?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="supplier_id" name="supplier_id" required="">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    {supplier_list}
                                    <option value="{supplier_id}">{supplier_name} </option>
                                    {/supplier_list}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_id" class="col-sm-3 col-form-label"><?php echo display('select_product') ?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="product_id" name="product_id" required="">

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="from_date" class="col-sm-3 col-form-label"><?php echo display('from') ?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" id="from_date" name="from_date" value="<?php echo $today; ?>" class="form-control datepicker" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="to_date" class="col-sm-3 col-form-label"><?php echo display('to') ?>: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" id="to_date" name="to_date" value="<?php echo $today; ?>" class="form-control datepicker" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6 text-center">
                                <button type="submit" class="btn btn-primary"><?php echo display('search') ?></button>
                                <a  class="btn btn-warning" href="#" onclick="printDiv('printableArea')"><?php echo display('print') ?></a>
                            </div>
                        </div>

                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>-->

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('stock_report_supplier_wise') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="printableArea" class="table-responsive m-l-2">
                            <table border="0" width="100%" class="m-b-10">
                                <tr>
                                    <td align="left" class="b-b-2-solid">
                                        <img src="<?php echo $software_info[0]['logo']; ?>" alt="logo">
                                    </td>
                                    <td align="left" class="b-b-2-solid">
                                        <span class="custom_hding">
                                            <?php echo $company[0]['company_name']; ?>

                                        </span><br>
                                        <?php echo $company[0]['address']; ?>
                                        <br>
                                        <?php echo $company[0]['email']; ?>
                                        <br>
                                        <?php echo $company[0]['mobile']; ?>

                                    </td>

                                    <td align="right" class="b-b-2-solid">
                                        <?php if ($supplier_info) { ?>
                                            {supplier_info}
                                            <h3> {supplier_name} </h3>
                                            <h4><?php echo display('address') ?> : {address} </h4>
                                            <h4 ><?php echo display('phone') ?> : {mobile} </h4>
                                            {/supplier_info}
                                            <h4><?php echo display('product_model') ?>:{product_model}</h4>
                                        <?php } ?>  
<!--                                <date>
                                    <?php echo display('date') ?>: 
                                        <?php
                                    $CI = & get_instance();
                                    $CI->load->library('Occational');
                                    $today = $CI->occational->dateConvertMyformat(date('d-M-Y'));
                                    echo $today;
                                    ?> 
                                </date>-->
                                </td>
                                </tr>            

                            </table>

                            <div class="table-responsive m-t-10">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?php echo display('sl') ?></th>
                                            <th class="text-center"><?php echo display('product') ?></th>
                                            <th class="text-center"><?php echo display('supplier') ?></th>

                                            <th class="text-center"><?php echo display('in_qnty') ?></th>
                                            <th class="text-center"><?php echo display('out_qnty') ?></th>
                                            <th class="text-center"><?php echo display('stock') ?>

                                            </th>
                                            <th class="text-center"><?php echo display('stock_sale') ?>
                                                <?php echo form_open('Creport/stock_report_supplier_wise', array('class' => 'form-inline', 'method' => 'post')) ?>
                                                <input type="hidden" name="all" value="all">
                                                <input type="hidden" name="supplier_id" value="{supplier_id}">
                                                <input type="hidden" name="product_id" value="{product_id}">
                                                <input type="hidden" name="from_date" value="{from_date}">
                                                <input type="hidden" name="to_date" value="{to_date}">
                                                <button type="submit" class="btn btn-success"><?php echo display('all') ?></button>
                                                <?php echo form_close() ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                        dd($stok_report);
                                          $totallin = 0;
                                            $totalout = 0;
                                            $totalstock = 0;
                                            $total_stocksaleprice = 0;
                                        if ($stok_report) {
                                            ?>
                                            <?php $sl = 1; ?>
                                            <?php
                                            foreach ($stok_report as $stok_report) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $sl; ?></td>
                                                    <td align="center">
                                                        <a href="<?php echo base_url() . 'Cproduct/product_details/' . $stok_report['product_id']; ?>">
                                                            <?php echo $stok_report['product_name']." ( ".$stok_report['product_model']." )"; ?>
                                                        </a>        
                                                    </td>
                                                    <td align="center">
                                                        <!--<a href="<?php echo base_url() . 'Cproduct/product_details/' . $stok_report['product_id']; ?>"><?php echo $stok_report['product_model']; ?></a>-->  
                                                        <a href="<?php echo base_url('Csupplier/supplier_ledger_info/'.$stok_report['supplier_id']); ?>">
                                                            <?php echo $stok_report['supplier_name']; ?>
                                                        </a>
                                                    </td>
                                                    <td align="center"><?php
                                                        $totalPurchaseQnty = $stok_report['totalPurchaseQnty'];
                                                        echo (($position == 0) ? number_format($totalPurchaseQnty, 2, '.', ',') : number_format($totalPurchaseQnty, 2, '.', ',') );
                                                        $totallin += $totalPurchaseQnty;
                                                        ?></td>
                                                    <td align="center"><?php
                                                        $totalSalesQnty = $stok_report['totalSalesQnty'];
                                                        echo (($position == 0) ? number_format($totalSalesQnty, 2, '.', ',') : number_format($totalSalesQnty, 2, '.', ','));
                                                        $totalout += $totalSalesQnty;
                                                        ?></td>
                                                    <td align="center"><?php
                                                        $SubTotalStock = $stok_report['stok_quantity_cartoon'];
                                                        echo (($position == 0) ? number_format($SubTotalStock, 2, '.', ',') : number_format($SubTotalStock, 2, '.', ','));
                                                        $totalstock += $SubTotalStock;
                                                        ?></td>
                                                    <td align="center"><?php
                                                        $total_sale_price = $stok_report['total_sale_price'];
                                                        echo (($position == 0) ? "$currency " . number_format($total_sale_price, 2, '.', ',') : number_format($total_sale_price, 2, '.', ',') . " $currency");
                                                        $total_stocksaleprice += $total_sale_price;
                                                        ?></td>
                                                </tr>
                                                <?php $sl++; ?>
                                            <?php } ?>
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
                                            <td colspan="3" align="right"><b><?php echo display('grand_total') ?>:</b></td>
                                            <td align="center"><b><?php echo $totallin ?></b></td>
                                            <td align="center"><b><?php echo $totalout ?></b></td>
                                            <td align="center"><b><?php echo $totalstock ?></td>
                                            <td align="center"><b><?php echo $currency . ' ' . $total_stocksaleprice ?> </td>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-right"><?php echo $links ?></div>
                </div>
            </div>
        </div>

    </section>
</div>
<!-- Stock List Supplier Wise End -->