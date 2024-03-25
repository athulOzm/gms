
<!-- Add new supplier start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_supplier') ?></h1>
            <small><?php echo display('add_new_supplier') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('supplier') ?></a></li>
                <li class="active"><?php echo display('add_supplier') ?></li>
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
                <div class="column m-b-10 float_right">
                    <?php if ($this->permission1->check_label('manage_supplier')->read()->access()) { ?>
                        <a href="<?php echo base_url('Csupplier/manage_supplier') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_supplier') ?> </a>
                        <?php
                    }
                    if ($this->permission1->check_label('supplier_ledger')->read()->access()) {
                        ?>
                        <!--<a href="<?php echo base_url('Csupplier/supplier_ledger_report') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_ledger') ?> </a>-->
                        <?php
                    }
                    if ($this->permission1->check_label('supplier_sales_details')->read()->access()) {
                        ?>
                        <!--<a href="<?php echo base_url('Csupplier/supplier_sales_details_all') ?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_sales_details') ?> </a>-->
                        <?php
                    }
                    if ($this->permission1->check_label('add_supplier')->create()->access()) {
                        ?>
                        <!--<button type="button" class="btn btn-info m-b-5 m-r-2" data-toggle="modal" data-target="#supplier_modal"><?php echo display('csv_upload_supplier') ?></button>-->
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- New supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_supplier') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Csupplier/insert_supplier', array('id' => 'insert_supplier')) ?>
                    <div class="panel-body">
                        <ul class="nav nav-tabs m-b-20" >
                            <li class="active"><a href="#tab1" data-toggle="tab"><?php echo display('company_details'); ?></a></li>
                            <li><a href="#tab2" data-toggle="tab"><?php echo display('financial_details'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="form-group row">
                                    <label for="company_name" class="col-sm-3 col-form-label text-right"><?php echo display('company_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="company_name" id="company_name" type="text" placeholder="<?php echo display('company_name') ?>"  required="" tabindex="1">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_phone" class="col-sm-3 col-form-label text-right"><?php echo display('company_phone') ?> <i class="text-danger"> * </i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="company_phone" id="company_phone" type="text" placeholder="<?php echo display('company_phone') ?>"  min="0" tabindex="2" onkeyup="onlynumber_allow(this.value,'company_phone')" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_mobile" class="col-sm-3 col-form-label text-right"><?php echo display('company_mobile') ?> <i class="text-danger"></i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="company_mobile" id="company_mobile" type="text" placeholder="<?php echo display('company_mobile') ?>"  min="0" onkeyup="onlynumber_allow(this.value,'company_mobile')" tabindex="3">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_address " class="col-sm-3 col-form-label text-right"><?php echo display('company_address') ?></label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="company_address" id="company_address " rows="3" placeholder="<?php echo display('company_address') ?>" tabindex="4"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_email" class="col-sm-3 col-form-label text-right"><?php echo display('company_email') ?> <i class="text-danger"> * </i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="company_email" id="company_email" type="text" placeholder="<?php echo display('company_email') ?>" tabindex="5" required>
                                        <span id="email_v_message"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_website" class="col-sm-3 col-form-label text-right"><?php echo display('company_website') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="company_website" id="company_website" type="text" placeholder="<?php echo display('company_website') ?>" tabindex="6">
                                    </div>
                                </div>
                                <!--<a class="btn btn-primary btnNext"  onclick="valid_one()"><?php echo display('next'); ?></a>-->
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="form-group row">
                                    <label for="notifications" class="col-sm-3 col-form-label text-right"><?php echo display('notification') ?></label>
                                    <div class="col-sm-6">
                                        <label for="sms">
                                            <input type="checkbox" name="notifications[]" id="sms" value="sms"> <?php echo display('sms'); ?>  
                                        </label>
                                        <label for="email">
                                            <input type="checkbox" name="notifications[]" id="email" value="email"> <?php echo display('email'); ?> 
                                        </label>
                                        <label for="post">
                                            <input type="checkbox" name="notifications[]" id="post" value="post"> <?php echo display('post'); ?> 
                                        </label>
                                        <label for="none">
                                            <input type="checkbox" name="notifications[]" id="none" value="none"> <?php echo display('none'); ?> 
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="payment_method" class="col-sm-3 col-form-label text-right"><?php echo display('payment_method') ?></label>
                                    <div class="col-sm-6">
                                        <label for="cash">
                                            <input type="radio" name="payment_method" id="cash" value="cash"> <?php echo display('cash'); ?> 
                                        </label>
                                        <label for="internet">
                                            <input type="radio" name="payment_method" id="internet" value="internet"> <?php echo display('internet'); ?> 
                                        </label>
                                        <label for="credit">
                                            <input type="radio" name="payment_method" id="credit" value="credit"> <?php echo display('credit'); ?> 
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="order_by" class="col-sm-3 col-form-label text-right"><?php echo display('order_by') ?></label>
                                    <div class="col-sm-6">
                                        <label for="phone">
                                            <input type="radio" name="order_by" id="phone" value="phone"> <?php echo display('phone'); ?> 
                                        </label>
                                        <label for="mobile">
                                            <input type="radio" name="order_by" id="mobile" value="mobile"> <?php echo display('mobile'); ?> 
                                        </label>
                                        <label for="email_order">
                                            <input type="radio" name="order_by" id="email_order" value="email"> <?php echo display('email'); ?> 
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <input type="submit" id="add-customer" class="btn btn-success btn-large supplier_btn" name="add-supplier" value="<?php echo display('save') ?>" tabindex="7"/>
                                        <!--<input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-customer-another" class="btn btn-large btn-success" id="add-customer-another" tabindex="6">-->
                                    </div>
                                </div>
                                <!--<a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>-->
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <!--                        <div class="form-group row">
                                                    <label for="supplier_name" class="col-sm-3 col-form-label"><?php echo display('supplier_name') ?> <i class="text-danger">*</i></label>
                                                    <div class="col-sm-6">
                                                        <input class="form-control" name ="supplier_name" id="supplier_name" type="text" placeholder="<?php echo display('supplier_name') ?>"  required="" tabindex="1">
                                                    </div>
                                                </div>
                                              <div class="form-group row">
                                                    <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('supplier_mobile') ?> <i class="text-danger"></i></label>
                                                    <div class="col-sm-6">
                                                        <input class="form-control" name="mobile" id="mobile" type="text" placeholder="<?php echo display('supplier_mobile') ?>"  min="0" tabindex="2">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="address " class="col-sm-3 col-form-label"><?php echo display('supplier_address') ?></label>
                                                    <div class="col-sm-6">
                                                        <textarea class="form-control" name="address" id="address " rows="3" placeholder="<?php echo display('supplier_address') ?>" tabindex="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="details" class="col-sm-3 col-form-label"><?php echo display('supplier_details') ?></label>
                                                    <div class="col-sm-6">
                                                        <textarea class="form-control" name="details" id="details" rows="3" placeholder="<?php echo display('supplier_details') ?>" tabindex="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="previous_balance" class="col-sm-3 col-form-label"><?php echo display('previous_balance') ?></label>
                                                    <div class="col-sm-6">
                                                        <input class="form-control" name="previous_balance" id="previous_balance" type="number" placeholder="<?php echo display('previous_balance') ?>" tabindex="5">
                                                    </div>
                                                </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-supplier" class="btn btn-primary btn-large" name="add-supplier" value="<?php echo display('save') ?>" tabindex="6"/>
                                <input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-supplier-another" class="btn btn-large btn-success" id="add-supplier-another" tabindex="5">
                            </div>
                        </div>-->
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
        <div id="supplier_modal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?php echo display('csv_supplier'); ?></h4>
                    </div>
                    <div class="modal-body">

                        <div class="panel panel-bd">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <h4><?php echo display('csv_supplier'); ?></h4>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="col-sm-12"><a href="<?php echo base_url('assets/data/csv/supplier_csv_sample.csv') ?>" class="btn btn-primary pull-right"><i class="fa fa-download"></i> <?php echo display('download_sample_file') ?></a></div>
                                <?php echo form_open_multipart('Csupplier/uploadCsv_Supplier', array('class' => 'form-vertical', 'id' => 'validate', 'name' => 'insert_supplier')) ?>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="upload_csv_file" class="col-sm-4 col-form-label"><?php echo display('upload_csv_file') ?> <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="upload_csv_file" type="file" id="upload_csv_file" placeholder="<?php echo display('upload_csv_file') ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <div class="col-sm-12 text-right">
                                            <input type="submit" id="add-product" class="btn btn-primary btn-large" name="add-product" value="<?php echo display('submit') ?>" />
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                </div>
                                <?php echo form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new supplier end -->
<script src="<?php echo base_url('assets/custom/supplier.js'); ?>"></script>


