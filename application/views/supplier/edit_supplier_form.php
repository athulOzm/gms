
<!-- Edit supplier page start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('supplier_edit') ?></h1>
            <small><?php echo display('supplier_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('supplier') ?></a></li>
                <li class="active"><?php echo display('supplier_edit') ?></li>
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

        <!-- New supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('supplier_edit') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Csupplier/supplier_update', array('id' => 'insert_supplier')) ?>
                    <div class="panel-body">
                        <ul class="nav nav-tabs m-b-20">
                            <li class="active"><a href="#tab1" data-toggle="tab"><?php echo display('company_details'); ?></a></li>
                            <li><a href="#tab2" data-toggle="tab"><?php echo display('financial_details'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="form-group row">
                                    <label for="company_name" class="col-sm-3 col-form-label text-right"><?php echo display('company_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="company_name" id="company_name" type="text" value="{supplier_name}" placeholder="<?php echo display('company_name') ?>" required="" tabindex="1">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_phone" class="col-sm-3 col-form-label text-right"><?php echo display('company_phone') ?> <i class="text-danger"> * </i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="company_phone" id="company_phone" type="text" onkeyup="onlynumber_allow(this.value, 'company_phone')" value="{phone}" placeholder="<?php echo display('company_phone') ?>"  min="0" tabindex="2" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_mobile" class="col-sm-3 col-form-label text-right"><?php echo display('company_mobile') ?> <i class="text-danger"></i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="company_mobile" id="company_mobile" type="text" onkeyup="onlynumber_allow(this.value, 'company_mobile')" value="{mobile}" placeholder="<?php echo display('company_mobile') ?>"  min="0" tabindex="3">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_address " class="col-sm-3 col-form-label text-right"><?php echo display('company_address') ?></label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="company_address" id="company_address " rows="3" placeholder="<?php echo display('company_address') ?>" tabindex="4">{address}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_email" class="col-sm-3 col-form-label text-right"><?php echo display('company_email') ?> <i class="text-danger"> * </i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="company_email" id="company_email" type="text" value="{email}" placeholder="<?php echo display('company_email') ?>" tabindex="5" required>
                                        <span id="email_v_message"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_website" class="col-sm-3 col-form-label text-right"><?php echo display('company_website') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="company_website" id="company_website" type="text" value="{website}" placeholder="<?php echo display('company_website') ?>" tabindex="6">
                                    </div>
                                </div>
                                <!--<a class="btn btn-primary btnNext"  onclick="valid_one()"><?php echo display('next'); ?></a>-->
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="form-group row">
                                    <?php
                                    $notifications = explode(',', $notification);
                                    ?>
                                    <label for="notifications" class="col-sm-3 col-form-label text-right"><?php echo display('notification') ?></label>
                                    <div class="col-sm-6">
                                        <label for="sms">
                                            <input type="checkbox" name="notifications[]" id="sms" value="sms" <?php
                                            if (in_array('sms', $notifications)) {
                                                echo 'checked';
                                            }
                                            ?>> <?php echo display('sms'); ?>  
                                        </label>
                                        <label for="email">
                                            <input type="checkbox" name="notifications[]" id="email" value="email" <?php
                                            if (in_array('email', $notifications)) {
                                                echo 'checked';
                                            }
                                            ?>> <?php echo display('email'); ?> 
                                        </label>
                                        <label for="post">
                                            <input type="checkbox" name="notifications[]" id="post" value="post" <?php
                                            if (in_array('post', $notifications)) {
                                                echo 'checked';
                                            }
                                            ?>> <?php echo display('post'); ?> 
                                        </label>
                                        <label for="none">
                                            <input type="checkbox" name="notifications[]" id="none" value="none" <?php
                                            if (in_array('none', $notifications)) {
                                                echo 'checked';
                                            }
                                            ?>> <?php echo display('none'); ?> 
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="payment_method" class="col-sm-3 col-form-label text-right"><?php echo display('payment_method') ?></label>
                                    <div class="col-sm-6">
                                        <label for="cash">
                                            <input type="radio" name="payment_method" id="cash" value="cash" <?php
                                            if ($payment_method == 'cash') {
                                                echo 'checked';
                                            }
                                            ?>> <?php echo display('cash'); ?> 
                                        </label>
                                        <label for="internet">
                                            <input type="radio" name="payment_method" id="internet" value="internet" <?php
                                            if ($payment_method == 'internet') {
                                                echo 'checked';
                                            }
                                            ?>> <?php echo display('internet'); ?> 
                                        </label>
                                        <label for="credit">
                                            <input type="radio" name="payment_method" id="credit" value="credit" <?php
                                            if ($payment_method == 'credit') {
                                                echo 'checked';
                                            }
                                            ?>> <?php echo display('credit'); ?> 
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="order_by" class="col-sm-3 col-form-label text-right"><?php echo display('order_by') ?></label>
                                    <div class="col-sm-6">
                                        <label for="phone">
                                            <input type="radio" name="order_by" id="phone" value="phone" <?php
                                            if ($order_by == 'phone') {
                                                echo 'checked';
                                            }
                                            ?>> <?php echo display('phone'); ?> 
                                        </label>
                                        <label for="mobile">
                                            <input type="radio" name="order_by" id="mobile" value="mobile" <?php
                                            if ($order_by == 'mobile') {
                                                echo 'checked';
                                            }
                                            ?>> <?php echo display('mobile'); ?> 
                                        </label>
                                        <label for="email_order">
                                            <input type="radio" name="order_by" id="email_order" value="email" <?php
                                            if ($order_by == 'email') {
                                                echo 'checked';
                                            }
                                            ?>> <?php echo display('email'); ?> 
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="oldname" value="{supplier_name}">
                                        <input type="hidden" name="supplier_id" value="{supplier_id}">
                                        <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-supplier" value="<?php echo display('update') ?>" tabindex="7"/>
                                        <!--<input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-customer-another" class="btn btn-large btn-success" id="add-customer-another" tabindex="6">-->
                                    </div>
                                </div>
                                <!--<a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>-->
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit supplier page end -->
<script src="<?php echo base_url('assets/custom/supplier.js'); ?>"></script>


