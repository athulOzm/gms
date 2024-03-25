<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('calender') ?></h1>
            <small><?php echo display('add_courtesy_booking') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('calender') ?></a></li>
                <li class="active"><?php echo display('add_courtesy_booking') ?></li>
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


        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_courtesy_booking') ?> </h4>
                        </div>
                    </div>

                    <div class="panel-body">
                        <?php echo form_open('Ccalender/insert_courtesy_booking', array('class' => 'form-vertical', 'id' => '')) ?>
                        <div class="form-group row">
                            <label for="customer" class="col-sm-3 col-form-label"><?php echo display('customer') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <!--<select name="customer_id" id="customer_id" class="form-control select2" required data-placeholder="-- select one --" onchange="get_customer_info(this.value)">-->
                                <select name="customer_id" id="customer_id" class="form-control select2" required data-placeholder="-- select one --">
                                    <option value="">Select Registration</option>
                                    <?php foreach ($customers as $customer) { ?>
                                        <option value="<?php echo $customer['customer_id'] ?>"><?php echo $customer['customer_name'] ?></option>   
                                    <?php } ?>   
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vehicle_registration" class="col-sm-3 col-form-label"><?php echo display('vehicle_registration') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <?php //dd($vehicles); ?>
                                <select name="vehicle_reg" id="registration_no" class="form-control select2" required data-placeholder="-- select one --">
                                    <option value="">Select Registration</option>
                                    <?php foreach ($vehicles as $vehicle) { ?>
                                        <option value="<?php echo $vehicle['vehicle_registration'] ?>">
                                            <?php echo $vehicle['vehicle_registration'] ?>
                                        </option>   
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="start_date" class="col-sm-3 col-form-label"><?php echo display('start_date') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control datepicker" name ="start_date" id="start_date" type="text" placeholder="<?php echo display('start_date') ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_date" class="col-sm-3 col-form-label"><?php echo display('end_date') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control datepicker" name ="end_date" id="end_date" type="text" placeholder="<?php echo display('end_date') ?>" onchange="booking_vehicle(this.value)" required>
                            </div>
                            <div id="previous" class="col-sm-3">

                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="title" class="col-sm-3 col-form-label"><?php echo display('title') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="title" id="title" type="text" placeholder="<?php echo display('title') ?>" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save') ?>" />
                            </div>
                        </div>
                    </div>

                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="crtbookingCheck" value="<?php echo base_url('Ccalender/courtesy_booking_check'); ?>">
    <input type="hidden" id="custVehicleInfo" value="<?php echo base_url('Cjob/customer_wise_vehicle_info'); ?>">
</div>
<script src="<?php echo base_url('assets/custom/calender.js') ?>"></script>