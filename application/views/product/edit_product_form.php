<link href="<?php echo base_url('assets/custom/product.css') ?>" rel="stylesheet" type="text/css"/>
<!-- Edit Product Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('product_edit') ?></h1>
            <small><?php echo display('edit_your_product') ?></small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('product') ?></a></li>
                <li class="active"><?php echo display('product_edit') ?></li>
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
        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('product_edit') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cproduct/product_update', array('class' => 'form-vertical', 'id' => 'product_update', 'name' => 'product_update')) ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('product_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="product_name" type="text" id="product_name" placeholder="<?php echo display('product_name') ?>" required tabindex="1" value="{product_name}" >
                                        <input type="hidden" name="product_id" value="{product_id}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="serial_no" class="col-sm-4 col-form-label"><?php echo display('serial_no') ?> </label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="2" class="form-control" id="serial_no" name="serial_no" placeholder="<?php echo display('serial_no') ?>"  value="{serial_no}"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_model" class="col-sm-4 col-form-label"><?php echo display('model') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="3" id="product_model" class="form-control" name="model" placeholder="<?php echo display('model') ?>"  required  value="{product_model}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="category_id" class="col-sm-4 col-form-label"><?php echo display('category') ?></label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="category_id" name="category_id" tabindex="4">
                                            {category_list}
                                            <option value="{category_id}">{category_name} </option>
                                            {/category_list}
                                            <?php
                                            if ($category_selected) {
                                                ?>
                                                {category_selected}
                                                <option selected value="{category_id}">{category_name} </option>
                                                {/category_selected}
                                                <?php
                                            } else {
                                                ?>
                                                <option selected value="0"><?php echo display('category_not_selected') ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>                        

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="sell_price" class="col-sm-4 col-form-label"><?php echo display('sell_price') ?> <i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                        <input class="form-control text-right" id="sell_price" name="price" type="text" required="" placeholder="0.00" tabindex="5" min="0" value="{price}">
                                    </div>
                                </div> 
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="unit" class="col-sm-4 col-form-label"><?php echo display('unit') ?></label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="unit" name="unit" tabindex="6" aria-hidden="true">
                                            <option value="">Select One</option>
                                            <?php
                                            foreach ($unit_list as $single) {
                                                if ($single['unit_name'] == $unit) {
                                                    ?>
                                                    <option selected value="<?php echo $single['unit_name']; ?>">
                                                        <?php echo $single['unit_name']; ?>
                                                    </option>
                                                <?php } else { ?>
                                                    <option  value="<?php echo $single['unit_name']; ?>">
                                                        <?php echo $single['unit_name']; ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="image" class="col-sm-4 col-form-label"><?php echo display('image') ?> </label>
                                    <div class="col-sm-8">
                                        <input type="file" name="image" id="image" class="form-control" tabindex="7">
                                        <img class="img img-responsive text-center" src="{image}" height="80" width="80">
                                        <input type="hidden" value="{image}" name="old_image">
                                    </div>
                                </div> 
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="tax" class="col-sm-4 col-form-label"><?php echo display('tax') ?> </label>
                                    <div class="col-sm-8">
                                        <select name="tax" class="form-control dont-select-me" id="tax" tabindex="8">
                                            <option value=""><?php echo display('select_tax') ?></option>
                                            <?php foreach ($tax_list as $txs) { ?>
                                                <option value="<?php echo $txs->tax; ?>" <?php
                                                if (trim($txs->tax, '') == trim($tax_selecete, '')) {
                                                    echo "selected";
                                                }
                                                ?> ><?php echo $txs->tax; ?>%</option>
                                                    <?php } ?>  
                                        </select>
                                    </div>
                                </div> 
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="minimum_stock" class="col-sm-4 col-form-label"><?php echo display('minimum_stock') ?> </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="minimum_stock" class="form-control" id="minimum_stock" tabindex="9" value="{minimum_stock}">
                                    </div>
                                </div> 
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="re_order_level" class="col-sm-4 col-form-label"><?php echo display('re_order_level') ?> </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="re_order_level" class="form-control" id="re_order_level" value="{reorder_level}" tabindex="10">
                                    </div>
                                </div> 
                            </div> 
                        </div> 


                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_location" class="col-sm-4 col-form-label"><?php echo display('product_location') ?> </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="product_location" class="form-control" id="product_location" value="{product_location}" tabindex="11" >
                                    </div>
                                </div> 
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="global_markup" class="col-sm-4 col-form-label"><?php echo display('global_markup') ?> </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="global_markup" class="form-control" id="global_markup" value="{global_markup}" tabindex="12">
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="individual_markup" class="col-sm-4 col-form-label"><?php echo display('individual_markup') ?> </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="individual_markup" class="form-control" id="individual_markup" value="{individual_markup}" tabindex="13" >
                                    </div>
                                </div> 
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="notes" class="col-sm-4 col-form-label"><?php echo display('notes') ?> </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="notes" class="form-control" id="notes" value="{notes}" tabindex="14" >
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <div class="table-responsive m-t-10">
                            <table class="table table-bordered table-hover"  id="product_table">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('supplier') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('supplier_price') ?> <i class="text-danger">*</i></th>


                                        <th class="text-center"><?php echo display('action') ?> <i class="text-danger"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="proudt_item">
                                    {supplier_product_data}
                                    <tr class="">

                                        <td>
                                            <select name="supplier_id[]" class="form-control dont-select-me" required="" tabindex="15">
                                                <option value="">-- select one -- </option>
                                                <?php foreach ($supplier_list as $supplier) { ?>
                                                    <option value="<?php echo $supplier['supplier_id'] ?>"><?php echo $supplier['supplier_name'] ?> </option>
                                                <?php } ?>
                                                <?php
                                                if ($supplier_selected) {
                                                    ?>
                                                    {supplier_selected}
                                                    <option selected value="{supplier_id}">{supplier_name} </option>
                                                    {/supplier_selected}
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option selected value="0"><?php echo display('supplier_not_selected') ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                           <!--  <input type="text" name="supplier_id" value="{supplier_name}"> -->
                                        </td>
                                        <td class="">
                                            <input type="text" tabindex="16" class="form-control text-right" name="supplier_price[]" placeholder="0.00"  required  min="0" value="{supplier_price}"/>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" id="add_purchase_item" class="btn btn-info" name="add-invoice-item" onClick="addpruduct('proudt_item');" /><i class="fa fa-plus-square" aria-hidden="true"></i></button> 
                                            <button class="btn btn-danger red" type="button" value="<?php echo display('delete') ?>" onclick="deleteRow(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                    {/supplier_product_data}
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <left><label for="description" class="col-form-label"><?php echo display('product_details') ?></label></left>
                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="<?php echo display('product_details') ?>" tabindex="17">{product_details}</textarea>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <div class="col-sm-6">

                                <input type="submit" id="add-product" class="btn btn-primary btn-large" name="add-product" value="<?php echo display('save_changes') ?>" tabindex="18"/>

                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit Product End -->
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/product.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/custom/product.js'); ?>"></script>




