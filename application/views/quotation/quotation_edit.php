<link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" type="text/css"/>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('quotation') ?></h1>
            <small><?php echo display('quotation_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('quotation') ?></a></li>
                <li class="active"><?php echo display('quotation_edit') ?></li>
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
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        ?>


        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('quotation_edit') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Cquotation/update_quotation', array('class' => 'form-vertical', 'id' => 'update_quotation')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="customer" class="col-sm-4 col-form-label"><?php echo display('customer') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="quotation_id" value="<?php echo $quot_main[0]['quotation_id'] ?>">
                                    <?php if ($user_type == 3) { ?>
                                        <input type="text" name="cname" value="<?php echo $customer_info[0]['customer_name'] ?>" class="form-control" readonly>
                                        <input type="hidden" name="customer_id" value="<?php echo $quot_main[0]['customer_id'] ?>" class="form-control" id="customer_id">
                                    <?php } else { ?>
                                        <select name="customer_id" class="form-control" onchange="get_customer_info(this.value)" required  id="customer_id">
                                            <option value="">Select One </option>
                                            <?php
                                            foreach ($customers as $customer) {
                                                ?>
                                                <option value="<?php echo $customer['customer_id'] ?>" <?php
                                                if ($quot_main[0]['customer_id'] == $customer['customer_id']) {
                                                    echo 'selected';
                                                }
                                                ?>>
                                                            <?php echo $customer['customer_name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="quotation_no" class="col-sm-4 col-form-label"><?php echo display('quotation_no') ?> </label>
                                <div class="col-sm-8">
                                    <input type="text" name="quotation_no" id="quotation_no" class="form-control" placeholder="<?php echo display('quotation_no') ?>" value="<?php echo $quot_main[0]['quot_no']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="address" class="col-sm-4 col-form-label"><?php echo display('address') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="address" class="form-control" id="address" value="<?php echo $customer_info[0]['customer_address'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="quotation_date" class="col-sm-4 col-form-label"><?php echo display('quotation_date') ?> </label>
                                <div class="col-sm-8">
                                    <input type="text" name="qdate" class="form-control datepicker" id="qdate" value="<?php echo $quot_main[0]['quotdate'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="phone" class="col-sm-4 col-form-label"><?php echo display('phone') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="phone" class="form-control" id="phone" value="<?php echo $customer_info[0]['customer_phone'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="registration_no" class="col-sm-4 col-form-label"><?php echo display('registration_no') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <?php if ($user_type == 3) { ?>
                                        <select name="registration_no" id="" class="form-control">
                                            <option value="">Select Registration</option>
                                            <?php foreach ($vehicles as $vehicle) { ?>
                                                <option value="<?php echo $vehicle->vehicle_registration ?>"><?php echo $vehicle->vehicle_registration ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } else { ?>
                                        <select name="registration_no" id="registration_no" class="form-control">
                                            <option value="">Select Registration</option>
                                        </select>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="phone" class="col-sm-4 col-form-label"><?php echo display('mobile') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="mobile" class="form-control" id="mobile" value="<?php echo $customer_info[0]['customer_mobile'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="phone" class="col-sm-4 col-form-label"><?php echo display('website') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="website" class="form-control" id="website" value="<?php echo $customer_info[0]['website'] ?>" readonly>
                                </div>
                            </div>


                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="phone" class="col-sm-2 col-form-label"><?php echo display('details') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-10">
                                    <textarea  name="details" class="form-control" id="details"><?php echo $quot_main[0]['quot_description'] ?></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="labour_table">
                                        <thead>
                                            <tr>
                                                <th width="200">Labour</th>
                                                <th><?php echo display('notes'); ?></th>    
                                                <th class="text-right"><?php echo display('rate'); ?></th>     
                                                <th class="text-center">
                                                    <button type="button" class="btn btn-success" onClick="addLabour('labourdive');"><i class="fa fa-plus"></i></button>
                                                </th>      
                                            </tr>
                                        </thead>
                                        <tbody id="labourdive">
                                            <?php
                                            $sl = 1;
                                            foreach ($quot_labour as $labours) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <select name="job_type_id[]" id="job_type_id_<?php echo $sl ?>" class="form-control select2" onchange="labour_data(this.value, '<?php echo $sl ?>')">
                                                            <option value=""></option>
                                                            <?php foreach ($get_jobtypelist as $jobtype) { ?>
                                                                <option value='<?php echo $jobtype->job_type_id ?>' <?php
                                                                if ($jobtype->job_type_id == $labours['job_type_id']) {
                                                                    echo 'selected';
                                                                }
                                                                ?>><?php echo $jobtype->job_type_name; ?></option>
                                                                    <?php }
                                                                    ?>
                                                        </select>    
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder="Notes" name="lnotes[]" value="<?php echo $labours['note'] ?>">
                                                    </td>

                                                    <td>
                                                        <input type="text" class="form-control itemtotal text-right" placeholder="Rate" id="lrate_<?php echo $sl ?>" name="lrate[]" readonly value="<?php echo $labours['rate'] ?>">
                                                    </td>

                                                    <td></td>

                                                </tr>
                                                <?php
                                                $sl++;
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="item_table">
                                        <thead>
                                            <tr>
                                                <th width="200"> Item </th>
                                                <th class="text-center"><?php echo display('available_qty'); ?></th>
                                                <th class='text-center'> Qty </th>   
                                                <th class='text-right'> <?php echo display('price'); ?> </th> 
                                                <th class='text-right'><?php echo display('total'); ?></th>    
                                                <th class="text-center">
                                                    <button type="button" class="btn btn-success" onClick="addItem('itmetable');"><i class="fa fa-plus"></i></button>
                                                </th>      
                                            </tr>
                                        </thead>
                                        <tbody id="itmetable">
                                            <?php
//                                            dd($quot_product);
                                            $x = 1;
                                            foreach ($quot_product as $products) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php // dd($get_productlist); ?>
                                                        <select name="product_id[]" id="product_id" class="form-control select2" onchange="product_data(this.value, '<?php echo $x ?>')">
                                                            <option value="">Select One</option>
                                                            <?php foreach ($get_productlist as $product) { ?>
                                                                <option value='<?php echo $product->product_id; ?>' <?php
                                                                if ($products['product_id'] == $product->product_id) {
                                                                    echo 'selected';
                                                                }
                                                                ?>><?php echo $product->product_name; ?></option>
                                                                    <?php } ?>
                                                                    <?php foreach ($get_groupprice as $groupprice) { ?>
                                                                <option value='<?php echo $groupprice->group_price_id; ?>' <?php
                                                                if ($products['product_id'] == $groupprice->group_price_id) {
                                                                    echo 'selected';
                                                                }
                                                                ?>>
                                                                            <?php echo $groupprice->group_name; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>         
                                                    </td>
                                                    <td>
                                                        <input type="text" name="available_qty[]" id="available_qty_<?php echo $x ?>" class="form-control text-center" value="<?php echo $products['available_qty']; ?>" readonly>   
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" name="qty[]" class="form-control text-center" placeholder="Quantity" id="qty_<?php echo $x ?>" onkeyup="item_total_price('<?php echo $x ?>')" onchange="item_total_price('<?php echo $x ?>')" value="<?php echo $products['used_qty'] ?>">    
                                                    </td>
                                                    <td class='text-right'> <input type="text" name="price[]" class="form-control text-right" placeholder="Price" id="item_price_<?php echo $x ?>" readonly value="<?php echo $products['rate'] ?>"> </td>
                                                    <td class='text-right'> <input type="text" name="item_total" class="form-control itemtotal text-right" placeholder="Total" id="item_total_<?php echo $x ?>" readonly value="<?php echo $products['rate'] * $products['used_qty'] ?>"> </td>
                                                    <td></td>

                                                </tr>
                                                <?php
                                                $x++;
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-right"> <b>Sub Total</b></td>
                                                <td><input type="text" name="grandtotal" id="grandtotal" readonly="" class="form-control text-right" value="<?php echo $quot_main[0]['totalamount'] - $quot_main[0]['total_discount'] ?>"></td>
                                                <td></td>
                                            </tr>
                                            <?php if ($user_type != 3) { ?>
                                                <tr> <td colspan="4" class="text-right"> <b>Discount(%)</b></td>
                                                    <td><input type="text" name="dis_per" id="dis_per"  class="form-control text-right" onkeyup="totalcalculation()" value="<?php echo $quot_main[0]['dis_per'] ?>"></td>
                                                </tr>                                                
                                                <tr> <td colspan="4" class="text-right"> <b>Total Discount</b></td>
                                                    <td><input type="text" name="total_dis" id="total_dis"  class="form-control text-right" readonly="" value="<?php echo $quot_main[0]['total_discount'] ?>"></td>
                                                </tr>
                                            <?php } else { ?>
                                            <input type="hidden" name="dis_per" id="dis_per"  class="form-control text-right">
                                            <input type="hidden" name="total_dis" id="total_dis"  class="form-control text-right">
                                        <?php } ?>
                                        <tr>
                                            <td colspan="4" class="text-right"> <b>Grand Total</b></td>
                                            <td><input type="text" name="grandtotal" id="tgrandTotal" readonly="" class="form-control text-right" value="<?php echo $quot_main[0]['totalamount'] ?>"></td>
                                        </tr>
                                        </tfoot>

                                    </table>
                                </div>
                                <?php if ($user_type == 1) { ?>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="terms" class="col-sm-2 col-form-label"><?php echo display('terms') ?> <i class="text-danger"></i></label>
                                            <div class="col-sm-10">
                                                <textarea  name="terms" class="form-control" id="terms"><?php echo $quot_main[0]['terms'] ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">

                                <input type="submit" id="add-quotation" class="btn btn-primary btn-large" name="add-quotation" value="<?php echo display('save_changes') ?>" />
                                <?php if ($quot_main[0]['cust_show'] == 0) { ?>
                                    <input type="submit" value="<?php echo display('send_to_customer') ?>" name="customer_sent" class="btn btn-large btn-success" id="customer_sent" >
                                <?php } ?>
                            </div>
                        </div>
                    </div>               
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!--=============== this script must be include here ==================-->
<script type="text/javascript">
    "use strict";
    function addLabour(t) {
        var row = $("#labour_table tbody tr").length;
        var count = row + 1;
        var limits = 500;
        var xTable = document.getElementById('labour_table');
        var tr = document.createElement('tr');
        tr.innerHTML = '<td><select name="job_type_id[]" id="job_type_id_' + count + '"  class="form-control select2" onchange="labour_data(this.value,' + count + ')"><option value="" >-- select one -- </option><?php foreach ($get_jobtypelist as $labour) { ?><option value="<?php echo $labour->job_type_id; ?>"><?php echo $labour->job_type_name; ?></option> <?php } ?></select></td><td><input type="text" name="lnotes[]" class="form-control"> </td><td><input type="text" name="lrate[]" class="form-control itemtotal text-right" id="lrate_' + count + '" readonly></td><td><button class="btn btn-danger removeitem text-right" type="button"  onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button></td>';
        document.getElementById(t).appendChild(tr),
                document.getElementById(a).focus(),
                count++;
        $('.select2').select2();
    }

    "use strict";
    function addItem(t) {
        var row = $("#item_table tbody tr").length;
        var count = row + 1;
        var limits = 500;
        var xTable = document.getElementById('item_table');
        var tr = document.createElement('tr');
        tr.innerHTML = '<td><select name="product_id[]" onchange="product_data(this.value,' + count + ')" id="product_id"  class="select2 form-control" ><option value="" >-- select one -- </option><?php foreach ($get_productlist as $product) { ?><option value="<?php echo $product->product_id; ?>"><?php echo $product->product_name; ?></option> <?php } ?><?php foreach ($get_groupprice as $groupprice) { ?><option value="<?php echo $groupprice->group_price_id; ?>"><?php echo $groupprice->group_name; ?></option><?php } ?></select></td>\n\
                                <td><input type="text" name="available_qty[]" id="available_qty_' + count + '" class="form-control text-center" readonly> </td>\n\
                                <td><input type="text" name="qty[]" onkeyup="item_total_price(' + count + ')" onchange="item_total_price(' + count + ')" class="form-control text-center" id="qty_' + count + '"> </td>\n\
                                <td><input type="text" name="price[]" class="form-control text-right" id="item_price_' + count + '" readonly></td>\n\
                                <td> <input type="text" name="item_total" class="form-control itemtotal text-right" placeholder="Total" id="item_total_' + count + '" readonly> </td>\n\
                                <td><button  class="btn btn-danger removeitem text-right" type="button"  onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button></td>';
        document.getElementById(t).appendChild(tr),
                document.getElementById(a).focus(),
                count++;

        $('.select2').select2();

    }
    $(document).on('click', 'button.removelabour', function () {
        $(this).closest('tr').remove();
        totalcalculation();
        return false;
    });

    $(document).on('click', 'button.removeitem', function () {
        $(this).closest('tr').remove();
        totalcalculation();
        return false;
    });
    "use strict";
    function item_total_price(item) {
        var quantity = $("#qty_" + item).val();
        var price_item = $("#item_price_" + item).val();
        var total = quantity * price_item;
        $("#item_total_" + item).val(total.toFixed(2, 2));
        totalcalculation();
    }
    "use strict";
    function totalcalculation() {
        var p = 0;
        $(".itemtotal").each(function () {
            isNaN(this.value) || 0 == this.value.length || (p += parseFloat(this.value))
        }),
                $("#grandtotal").val(p.toFixed(2, 2));
        var subtotal = $("#grandtotal").val()
        var dis_per = $("#dis_per").val();
        var total_dis = (p * dis_per) / 100;
        $("#total_dis").val(total_dis.toFixed(2, 2));
        var grandTotal = subtotal - total_dis;
        $("#tgrandTotal").val(grandTotal.toFixed(2, 2));
    }
</script>
<script type="text/javascript">
    "use strict";
    function get_customer_info(t) {
        $.ajax({
            url: "<?php echo base_url('Cjob/get_customer_info'); ?>",
            type: 'POST',
            data: {customer_id: t},
            success: function (r) {
//                console.log(r);
                r = JSON.parse(r);
//                alert(r.customer_id);
                $("#address").val(r.customer_address);
                $("#phone").val(r.customer_phone);
                $("#mobile").val(r.customer_mobile);
                $("#website").val(r.website);
            }
        });
        $.ajax({
            url: "<?php echo base_url('Cjob/customer_wise_vehicle_info'); ?>",
            type: 'POST',
            data: {customer_id: t},
            success: function (r) {
//                console.log(r);
                r = JSON.parse(r);
                $("#registration_no").empty();
                $("#registration_no").html("<option value=''>-- select one -- </option>");

                $.each(r, function (ar, typeval) {
                    $('#registration_no').append($('<option>').text(typeval.vehicle_registration).attr('value', typeval.vehicle_id));
                });
            }
        });
    }
</script>
<script type="text/javascript">
    "use strict";
    function product_data(product_id, sl) {
        var avail_qty = '#available_qty_' + sl;
        var price = '#item_price_' + sl;

        $.ajax({
//            url: "<?php // echo base_url('Cjob/available_quantity_check');        ?>",
            url: "<?php echo base_url('Cjob/available_quantity_check_job'); ?>",
            type: 'POST',
            data: {product_id: product_id},
            success: function (r) {
//                r = JSON.parse(r);
//                $(price).val(r.price);
                var obj = jQuery.parseJSON(r);
                if (obj.available_qty == 0) {
                    alert("This product quatity is not available!");
                }
                if (obj.na != 'N/A') {
                    $(avail_qty).val(obj.available_qty);
                    $(price).val(obj.price);
                } else {
                    $(avail_qty).val(obj.na);
                    $(price).val(obj.price);
                }
//                $(price).val(obj.price);
            }
        });

    }

// =================labour data by select =================
    "use strict";
    function labour_data(jobtype_id, sl) {
        var lrate = '#lrate_' + sl;
        $.ajax({
            url: "<?php echo base_url('Cquotation/get_job_info'); ?>",
            type: 'POST',
            data: {jobtype_id: jobtype_id},
            success: function (r) {
                r = JSON.parse(r);
                $(lrate).val(r.job_type_rate);
                totalcalculation()
            }
        });

    }
    "use strict";
    $(document).ready(function () {
        var customer_id = $("#customer_id").val();
        var reg_no = '<?php echo $quot_main[0]['vehicle_reg'] ?>';
        $.ajax({
            url: "<?php echo base_url('Cjob/customer_wise_vehicle_info'); ?>",
            type: 'POST',
            data: {customer_id: customer_id},
            success: function (r) {
//                console.log(r);
                r = JSON.parse(r);
                $("#registration_no").empty();
                $("#registration_no").html("<option value=''>-- select one -- </option>");

                $.each(r, function (ar, typeval) {
                    if (typeval.vehicle_id == reg_no) {
                        $('#registration_no').append($('<option selected="selected">').text(typeval.vehicle_registration).attr('value', typeval.vehicle_id));

                    } else {
                        $('#registration_no').append($('<option>').text(typeval.vehicle_registration).attr('value', typeval.vehicle_id));
                    }

                });
            }
        });
    });
</script>
