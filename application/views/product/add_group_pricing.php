<link href="<?php echo base_url('assets/custom/product.css') ?>" rel="stylesheet" type="text/css"/>
<?php
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
?>
<!-- Manage service Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('inventory') ?></h1>
            <small><?php echo display('group_pricing') ?></small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('inventory') ?></a></li>
                <li class="active"><?php echo display('group_pricing') ?></li>
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
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <?php echo display('group_pricing') ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open('Cproduct/group_pricing_save', array('class' => 'form-vertical', 'id' => 'insert_menu')) ?>
                        <div class="form-group row">
                            <label for="group_name" class="col-sm-3 text-right"><?php echo display('group_name'); ?> <span class="text-danger"> * </span></label>
                            <div class="col-sm-8">
                                <input type="text" name="group_name" id="group_name" class="form-control" placeholder="Enter Group Name" required>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="normalinvoice">
                                <thead>
                                    <tr>
                                        <th class="text-left"><?php echo display('product'); ?></th>
                                        <th class="text-center"><?php echo display('quantity'); ?></th>
                                        <th class="text-right"><?php echo display('regular_price'); ?></th>
                                        <th class="text-right"><?php echo display('unit_price'); ?></th>
                                        <th class="text-center"><?php echo display('action'); ?> </th>
                                    </tr>
                                </thead>
                                <tbody id="addinvoiceItem">
                                    <tr>
                                        <td>
                                            <select class="form-control product_id" id="product_id_1" onchange="service_cals(this.value, '1')" name="product_id[]">
                                                <option value=""><?php echo display('select_one'); ?>/option>
                                                    <?php foreach ($get_products as $product) { ?>
                                                    <option value='<?php echo $product->product_id; ?>'>
                                                        <?php echo $product->product_name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control text-center" type="number" min="1" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);" value="1"name="group_product_qty[]" id="group_product_qty_1">
                                        </td>
                                        <td>
                                            <input class="form-control text-right regular_price" type="text" value=""name="regular_price[]" id="regular_price_1" readonly>
                                            <input type='hidden' class='quantity_regularprice' id='quantity_regularprice_1'>
                                        </td>
                                        <td class="test">
                                            <input type="text" name="product_rate[]" onkeyup="groupquantity_calculate(1);" onchange="groupquantity_calculate(1);" id="product_rate_1" class="form-control text-right productrate" placeholder="0.00" value="" min="0"  required=""/>
                                            <input type='hidden' class='quantity_productrate' id='quantity_productrate_1'>
                                        </td>
                                        <td class="text-center">
                                            <button  class="btn btn-danger text-right" type="button" value="Delete" onclick="deleteRow(this)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>

                                    <tr>
                                        <td colspan="2"  class="text-right"><b><?php echo display('cumulative_price'); ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="cumulative_price" class="form-control text-right cumulative_price" name="cumulative_price" value="0.00" readonly="readonly" />
                                        </td>
                                        <td>                                            
                                            <b><?php echo display('group_price'); ?>:</b>
                                            <input type="text" id="groupprice" class="form-control text-right groupprice_txtcls" name="groupprice" placeholder="0.00" tabindex=""/>
                                        </td>
                                        <td class="text-center">                                            
                                            <input id="add-invoice-item" class="btn btn-info" name="add-new-item" onclick="addInputField('addinvoiceItem');" value="Add New" type="button">
                                        </td>
                                    </tr>
                                    <tr>

                                    </tr>
                                </tfoot>
                            </table>  
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="" class="btn btn-primary btn-large" name="add-user" value="Save" />
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>       
    </section>
</div>
<!--============== this script must be required here==============--> 
<script type="text/javascript">
//    var count = 2;
//    limits = 500;
// ========== its for row add dynamically =============
    function addInputField(t) {
        var row = $("#normalinvoice tbody tr").length;
        var count = row + 1;
//        alert(count);
        var limits = 500;
        if (count == limits) {
            alert("You have reached the limit of adding" + count + "inputs");
        } else {
            var a = "product_id_" + count, e = document.createElement("tr");
            e.innerHTML = "<td>\n\
<select class='form-control select2-container' id='" + a + "' name='product_id[]' onchange='service_cals(this.value," + count + ")' ><option value=''>-- select one -- </option><?php foreach ($get_products as $product) { ?><option value='<?php echo $product->product_id; ?>'><?php echo $product->product_name; ?></option><?php } ?></select></td>\n\
<td><input class='form-control text-center' type='number' value='1' min='1' onkeyup='quantity_calculate(" + count + ");' onchange='quantity_calculate(" + count + ");' name='group_product_qty[]' id='group_product_qty_" + count + "'></td>\n\
<td><input class='form-control text-right regular_price' type='text' value='' name='regular_price[]' id='regular_price_" + count + "' readonly=''><input type='hidden' class='quantity_regularprice' id='quantity_regularprice_" + count + "'></td>\n\
<td><input type='text' class='form-control productrate text-right' name='product_rate[]' id='product_rate_" + count + "' onkeyup='groupquantity_calculate(" + count + ")' onchange='groupquantity_calculate(" + count + ")' placeholder='0.00' ><input type='hidden' class='quantity_productrate' id='quantity_productrate_" + count + "'></td>\n\
<td class='text-center'>\n\
<button class='btn btn-danger text-right' type='button' value='Delete' onclick='deleteRow(this)'>Delete</button></td>\n\
",
                    document.getElementById(t).appendChild(e), document.getElementById(a).focus(), count++
//        $('.select2').select2();
        }
    }
// ============= its for row delete dynamically =========
    function deleteRow(t) {
        var a = $("#normalinvoice > tbody > tr").length;
        if (1 == a) {
            alert("There only one row you can't delete it.");
        } else {
            var e = t.parentNode.parentNode;
            e.parentNode.removeChild(e);
        }
        calculateSum()
        groupquantity_calculate()
    }
//    =============== its for service_cals =============
    function service_cals(product_id, sl) {
//        alert(product_id);
//        var avail_qty = '#available_qty_' + sl;
        var group_product_qty = '#group_product_qty_' + sl;
        var regular_price = '#regular_price_' + sl;
//        var quantity_regularprice = group_product_qty*regular_price;
        var price = '#product_rate_' + sl;
//        alert(price);
        $.ajax({
            url: "<?php echo base_url('Cjob/get_product_info'); ?>",
            type: 'POST',
            data: {product_id: product_id},
            success: function (r) {
                r = JSON.parse(r);
//                alert(r.customer_id);
                $(regular_price).val(r.price);
                calculateSum(sl);
                groupquantity_calculate(sl);
            },
        });
    }
//    ========= its for quantity_calculate ============
    function quantity_calculate(item) {
        var group_product_qty = $("#group_product_qty_" + item).val();
        var regular_price = $("#regular_price_" + item).val();
        var quantity_regularprice = group_product_qty * regular_price;
        $("#quantity_regularprice_" + item).val(quantity_regularprice);

        var product_rate = $("#product_rate_" + item).val();
        var quantity_productrate = group_product_qty * product_rate;

        calculateSum(item);
        groupquantity_calculate(item);
    }
//    ========== its for groupquantity_calculate ==========
    function groupquantity_calculate(item) {
        var e = 0;
        var group_product_qty = $("#group_product_qty_" + item).val();
        var product_rate = $("#product_rate_" + item).val();
        var quantity_productrate = group_product_qty * product_rate;
//    alert(quantity_productrate);
        $("#quantity_productrate_" + item).val(quantity_productrate);
        $(".quantity_productrate").each(function () {
            isNaN(this.value) || 0 == this.value.length || (e += parseFloat(this.value));
        }),
                $("#groupprice").val(e.toFixed(2));
    }

    //    ======== its for calculateSum ===========
    function calculateSum(sl) {
        var group_product_qty = $('#group_product_qty_' + sl).val();
        var regular_price = $('#regular_price_' + sl).val();
        var quantity_regularprice = group_product_qty * regular_price;
        $("#quantity_regularprice_" + sl).val(quantity_regularprice);
        var t = 0,
                a = 0,
                e = 0,
                o = 0,
                p = 0;
//                f = 0;
        $(".quantity_regularprice").each(function () {
            isNaN(this.value) || 0 == this.value.length || (e += parseFloat(this.value));
        }),
                $("#cumulative_price").val(e.toFixed(2));
//        $("#groupprice").val(e.toFixed(2));

    }
</script>