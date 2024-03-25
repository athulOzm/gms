<!-- Product Purchase js -->
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/product_purchase.js.php" ></script>
<!-- Supplier Js -->
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>

<script src="<?php echo base_url() ?>my-assets/js/admin_js/purchase.js" type="text/javascript"></script>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('stock') ?></h1>
            <small><?php echo display('stock_adjustment') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('stock') ?></a></li>
                <li class="active"><?php echo display('stock_adjustment') ?></li>
            </ol>
        </div>
    </section>

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
                <div class="column m-b-5 float_right">
                    <?php // if ($this->permission1->method('manage_service', 'read')->access()) { ?>
                    <!--<a href="<?php echo base_url('Cjob/add_job_type') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('add_job_type') ?> </a>-->
                    <?php // } ?>
                </div>
            </div>
        </div>
        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('stock_adjustment') ?> </h4>
                        </div>
                    </div>


                    <div class="panel-body">
                        <?php echo form_open_multipart('Creport/insert_stockadjustment', array('class' => 'form-vertical', 'id' => '', 'name' => '')) ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="adjustment_type" class="col-sm-4 col-form-label"><?php echo display('adjustment_type') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <select name="adjustment_type" id="adjustment_type select2" class="form-control " required tabindex="1"> 
                                            <option value=""><?php echo display('select_one') ?></option>
                                            <option value="1">Stock In</option>
                                            <option value="2">Stock Out</option>
                                        </select>
                                    </div>
                                </div> 
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('date') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php $date = date('Y-m-d'); ?>
                                        <input type="text" tabindex="2" class="form-control datepicker" name="date" value="<?php echo $date; ?>" id="date" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="details" class="col-sm-4 col-form-label"><?php echo display('notes') ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" tabindex="3" id="details" name="details" placeholder=" <?php echo display('details') ?>" rows="1"></textarea>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="product_table">
                                <thead>
                                    <tr>
                                        <th><?php echo display('product_name'); ?></th>
                                        <!--<th class="text-center"><?php echo display('stock_ctn') ?></th>-->
                                        <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('rate') ?><i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('total') ?></th>
                                        <th class="text-center"><?php echo display('action') ?></th>

                                    </tr>
                                </thead>
                                <tbody id="itmetable">
                                    <?php
                                    $i = 0;
                                    $i++;
                                    ?>
                                    <tr>
                                        <td>
                                            <select name="product_id[]" id="product_id_<?php echo $i; ?>" class="form-control  select2" onchange="product_data(this.value, '<?php echo $i; ?>')" tabindex="4">
                                                <option value="">Select One</option>
                                                <?php foreach ($get_products as $product) { ?>
                                                    <option value="<?php echo $product->product_id; ?>">
                                                        <?php echo $product->product_name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>       
                                        </td>
<!--                                        <td>
                                            <input type="text" id="available_qty_1" class="form-control text-right stock_ctn_1" placeholder="0.00" readonly/>
                                        </td>-->
                                        <td>
                                            <input type="text" name="product_quantity[]" id="product_quantity_1" class="form-control text-right store_cal_1" onkeyup="calculate_store(1);" onchange="calculate_store(1);" placeholder="0" value="" min="0" tabindex="5"/>
                                        </td>
                                        <td>
                                            <input type="text" name="product_rate[]" onkeyup="calculate_store(1);" onchange="calculate_store(1);" id="product_rate_1" class="form-control product_rate_1 text-right" placeholder="0.00" value="" min="0" tabindex="6" readonly/>
                                        </td>
                                        <td>
                                            <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_1" tabindex="7" value="0.00" readonly="readonly" />
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-success" tabindex="8" onClick="addProduct('itmetable');"><i class="fa fa-plus"></i></button>
                                        </td>      
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="1">

                                        </td>
                                        <td class="text-right" colspan="2"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" tabindex="9" value="0.00" readonly="readonly" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add_purchase" class="btn btn-primary btn-large" tabindex="10" name="add-purchase" value="<?php echo display('submit') ?>" />
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>

            </div>
    </section>
</div>
<!-- this script must be included here -->
<script type="text/javascript">
    function addProduct(t) {
        var row = $("#product_table tbody tr").length;
        var count = row + 1;
        var limits = 500;
        var xTable = document.getElementById('product_table');
        var tr = document.createElement('tr');
        tr.innerHTML = '<td><select name="product_id[]" id="product_id"  class="form-control select2" onchange="product_data(this.value,' + count + ')"><option value="" >-- select one -- </option><?php foreach ($get_products as $product) { ?><option value="<?php echo $product->product_id; ?>"><?php echo $product->product_name; ?></option> <?php } ?></select></td>\n\
                                \n\
                                <td><input type="text" name="product_quantity[]" id="product_quantity_' + count + '" placeholder="0" onkeyup="calculate_store('+ count +')" class="form-control text-right"> </td>\n\
                                <td> <input type="text" name="product_rate[]" class="form-control text-right" id="product_rate_' + count + '" readonly> </td>\n\
                                <td><input type="text" name="total_price[]" id="total_price_' + count + '" class="form-control text-right total_price" readonly></td>\n\
                                <td class="text-center"><button  class="btn btn-danger removeitem text-right" type="button"  onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button></td>';
        document.getElementById(t).appendChild(tr),
//                document.getElementById(a).focus(),
                count++
        //xTable.children[1].appendChild(tr); // appends to the tbody element

//        $('.select2').select2();
    }
//    ========= its for product_data =============
    function product_data(product_id, sl) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Cproduct/get_product_info'); ?>",
            data: {product_id: product_id},
            success: function (s) {
                var obj = jQuery.parseJSON(s);
//                alert(obj.total_service);
                $('#product_rate_' + sl).val(obj.price);

            },
        });
    }
//    =========== its for calculate_store ===========
    function calculate_store(sl) {
        var quantity = $("#product_quantity_" + sl).val();
        var rate = $("#product_rate_" + sl).val();
        var total_amount = quantity * rate;
        $("#total_price_" + sl).val(total_amount);
        calculateSum();
    }
    //    ======== its for calculateSum ===========
    function calculateSum() {
        var t = 0,
                a = 0,
                e = 0,
                o = 0,
                p = 0;
        $(".total_price").each(function () {
            isNaN(this.value) || 0 == this.value.length || (e += parseFloat(this.value))
        }),
//                $(".all_discount").each(function () {
//            isNaN(this.value) || 0 == this.value.length || (p += parseFloat(this.value))
//        }),
                $("#total_discount").val(p.toFixed(2, 2)),
                $("#grandTotal").val(e.toFixed(2))
        var gt = $("#grandTotal").val();
//        var invoiceDiscount = $("#invoice_discount").val();
//        var total_discount = $("#total_discount").val();
//        var ttl_discount = +invoiceDiscount + +total_discount;
//        $("#total_discount").val(ttl_discount);
        var grandTotals = gt;
        $("#grandTotal").val(grandTotals);
    }
</script>