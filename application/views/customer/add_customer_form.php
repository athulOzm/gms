
<script src="<?php echo base_url('assets/custom/customer.js') ?>"></script>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_customer') ?></h1>
            <small><?php echo display('add_new_customer') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('customer') ?></a></li>
                <li class="active"><?php echo display('add_customer') ?></li>
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
                <div class="column" style="float: right;">
                    <?php if ($this->permission1->check_label('manage_customer')->read()->access()) { ?>
                        <a href="<?php echo base_url('Ccustomer/manage_customer') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_customer') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->check_label('credit_customer')->read()->access()) { ?>
                        <a href="<?php echo base_url('Ccustomer/credit_customer') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('credit_customer') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->check_label('paid_customer')->read()->access()) { ?>
                        <a href="<?php echo base_url('Ccustomer/paid_customer') ?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('paid_customer') ?> </a>
                    <?php } ?>


                </div>
            </div>
        </div>


        <!--====== its for tab menu start ==============-->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_customer') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Ccustomer/insert_customer', array('class' => 'form-vertical', 'id' => 'insert_customer')) ?>
                    <div class="panel-body">
                        <ul class="nav nav-tabs m-b-20">
                            <li class="active"><a href="#tab1" data-toggle="tab"><?php echo display('contact_details'); ?></a></li>
                            <li><a href="#tab2" data-toggle="tab"><?php echo display('company_details'); ?></a></li>
                            <li><a href="#tab3" data-toggle="tab"><?php echo display('account_details'); ?></a></li>
                            <li><a href="#tab4" data-toggle="tab"><?php echo display('financial_details'); ?></a></li>
                            <li><a href="#tab5" data-toggle="tab"><?php echo display('login_details'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="form-group row">
                                    <label for="customer_name" class="col-sm-3 col-form-label text-right"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="customer_name" id="customer_name" type="text" placeholder="<?php echo display('customer_name') ?>"  required tabindex="1" onkeyup="special_character_remove(this.value, 'customer_name')">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="customer_phone" class="col-sm-3 col-form-label text-right"><?php echo display('customer_phone') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="customer_phone" id="customer_phone" type="text"  placeholder="<?php echo display('customer_phone') ?>" tabindex="2" onkeyup="onlynumber_allow(this.value, 'customer_phone')"> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="customer_mobile" class="col-sm-3 col-form-label text-right"><?php echo display('customer_mobile') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="customer_mobile" id="customer_mobile" type="text" placeholder="<?php echo display('customer_mobile') ?>" tabindex="3" onkeyup="onlynumber_allow(this.value, 'customer_mobile')"> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="customer_email" class="col-sm-3 col-form-label text-right"><?php echo display('customer_email') ?> <i class="text-danger"> *</i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="customer_email" id="customer_email" type="email" onkeyup="customer_email_to_username(this.value)" placeholder="<?php echo display('customer_email') ?>" required tabindex="4"> <span id="email_v_message"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="customer_skype" class="col-sm-3 col-form-label text-right"><?php echo display('customer_skype') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="customer_skype" id="customer_skype" type="text" placeholder="<?php echo display('customer_skype') ?>" tabindex="5">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-3 col-form-label text-right"><?php echo display('customer_address') ?></label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="customer_address" id="address " rows="3" placeholder="<?php echo display('customer_address') ?>" tabindex="6"></textarea>
                                    </div>
                                </div>
                                <!--<a class="btn btn-primary btnNext" onclick="valid_one()"><?php echo display('next'); ?></a>-->
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="form-group row">
                                    <label for="company_name" class="col-sm-3 col-form-label text-right"><?php echo display('company_name') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="company_name" id="company_name" placeholder="<?php echo display('company_name') ?>" tabindex="7">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_number" class="col-sm-3 col-form-label text-right"><?php echo display('company_number') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" type="number" name="company_number" id="company_number " placeholder="<?php echo display('company_number') ?>" tabindex="8">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gst_vat_number" class="col-sm-3 col-form-label text-right"><?php echo display('gst_vat_number') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="vat_number" id="gst_vat_number " placeholder="<?php echo display('gst_vat_number') ?>" tabindex="9">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_type" class="col-sm-3 col-form-label text-right"><?php echo display('company_type') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="company_type" id="company_type " placeholder="<?php echo display('company_type') ?>" tabindex="10">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="postal_address" class="col-sm-3 col-form-label text-right"><?php echo display('postal_address') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="postal_address" id="postal_address " placeholder="<?php echo display('postal_address') ?>" tabindex="11">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="physical_address" class="col-sm-3 col-form-label text-right"><?php echo display('physical_address') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="physical_address" id="physical_address " placeholder="<?php echo display('physical_address') ?>" tabindex="12">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_website" class="col-sm-3 col-form-label text-right"><?php echo display('company_website') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="website" id="company_website " placeholder="<?php echo display('company_website') ?>" tabindex="13">
                                    </div>
                                </div>
<!--                                <a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>
                                <a class="btn btn-primary btnNext" onclick="valid_two()"><?php echo display('next'); ?></a>-->
                            </div>
                            <div class="tab-pane" id="tab3">
                                <div class="form-group row">
                                    <label for="director_name" class="col-sm-3 col-form-label text-right"><?php echo display('director_name') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="director_name" id="director_name" type="text" placeholder="<?php echo display('director_name') ?>" tabindex="14">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="director_mobile" class="col-sm-3 col-form-label text-right"><?php echo display('director_mobile') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="director_mobile" id="director_mobile" type="number" placeholder="<?php echo display('director_mobile') ?>" min="0" tabindex="15">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="director_phone" class="col-sm-3 col-form-label text-right"><?php echo display('director_phone') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="director_phone" id="director_phone" type="number" placeholder="<?php echo display('director_phone') ?>" min="0" tabindex="16">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="director_address " class="col-sm-3 col-form-label text-right"><?php echo display('director_address') ?></label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="director_address" id="director_address " rows="3" placeholder="<?php echo display('director_address') ?>" tabindex="17"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="trade_reference_1" class="col-sm-3 col-form-label text-right"><?php echo display('trade_reference_1') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="trade_reference_1" id="trade_reference_1" type="text" placeholder="<?php echo display('trade_reference_1') ?>" tabindex="18">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="trade_reference_2" class="col-sm-3 col-form-label text-right"><?php echo display('trade_reference_2') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="trade_reference_2" id="trade_reference_2" type="text" placeholder="<?php echo display('trade_reference_2') ?>" tabindex="19">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="trade_reference_3" class="col-sm-3 col-form-label text-right"><?php echo display('trade_reference_3') ?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="trade_reference_3" id="trade_reference_3" type="text" placeholder="<?php echo display('trade_reference_3') ?>" tabindex="20">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label text-right"><?php echo display('status') ?></label>
                                    <div class="col-sm-6">
                                        <!--<input class="form-control" name ="status" id="status" type="text" placeholder="<?php echo display('status') ?>" tabindex="21">-->
                                        <select class="form-control" id="status" name="status" data-placeholder="-- select one -- " tabindex="21">
                                            <option value=""></option>
                                            <option value="1" selected><?php echo display('active'); ?></option>
                                            <option value="2"><?php echo display('inactive'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="notes" class="col-sm-3 col-form-label text-right"><?php echo display('notes') ?></label>
                                    <div class="col-sm-6">
<!--                                        <input class="form-control" name ="notes" id="notes" type="text" placeholder="<?php echo display('notes') ?>" tabindex="22">-->
                                        <textarea class="form-control" name ="notes" id="notes" placeholder="<?php echo display('notes') ?>" tabindex="22"></textarea>
                                    </div>
                                </div>
<!--                                <a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>
                                <a class="btn btn-primary btnNext" onclick="valid_three()"><?php echo display('next'); ?></a>-->
                            </div>
                            <div class="tab-pane" id="tab4">
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
                                    <label for="payment_period" class="col-sm-3 col-form-label text-right"><?php echo display('payment_period') ?> <i class="text-danger"> *</i></label>
                                    <div class="col-sm-2">
                                        <input type="text" name="payment_period" class="form-control" id="payment_period" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="company_sales_discount" class="col-sm-3  text-right"><?php echo display('company_sales_discount'); ?></label>
                                    <div class="col-sm-2">
                                        <select name="sales_discount_status" onchange="discount_trade_markup(this.value)" class="form-control select2" id="company_sales_discount" data-placeholder="-- select one --">
                                            <option value=""></option>
                                            <option value="none">None</option>
                                            <option value="trade markup"><?php echo display('trade_markup'); ?></option>
                                            <option value="retail markup"><?php echo display('retail_markup'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 text_box">

                                    </div>
                                </div>

<!--                                <a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>
                                <a class="btn btn-primary btnNext" onclick="valid_four()"><?php echo display('next'); ?></a>-->
                            </div>
                            <div class="tab-pane" id="tab5">
                                <div class="form-group row">
                                    <label for="user_name" class="col-sm-3 col-form-label text-right"><?php echo display('user_name') ?> <i class="text-danger"> * </i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="user_name" id="user_name" type="text" placeholder="<?php echo display('user_name') ?>" tabindex="23" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-3 col-form-label text-right"><?php echo display('password') ?> <i class="text-danger"> * </i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name ="password" id="password" type="password" placeholder="<?php echo display('password') ?>" min="0" tabindex="24" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="role_id" class="col-sm-3 col-form-label text-right"><?php echo display('role_name') ?> <i class="text-danger"> * </i></label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="role_id" id="role_id" required> 
                                            <option value=""><?php echo display('select_one') ?></option>
                                            <?php
                                            foreach ($get_rolelist as $data) {
                                                ?>
                                                <option value="<?php echo $data['id'] ?>" <?php if ($data['type'] == 'Customer Role') {
                                                echo 'selected';
                                            } ?>>
                                                <?php echo $data['type'] ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <input type="submit" id="add-customer" class="btn btn-success btn-large customer_btn" onclick="valid_four()" name="add-customer" value="<?php echo display('save') ?>" tabindex="7"/>
                                        <!--<input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-customer-another" class="btn btn-large btn-success" id="add-customer-another" tabindex="6">-->
                                    </div>
                                </div>
                                <!--<a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====== its for tab menu close ==============-->

    </section>
</div>
<!-- Add new customer end -->



