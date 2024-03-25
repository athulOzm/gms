
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('calender') ?></h1>
            <small><?php echo display('add_booking') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('calender') ?></a></li>
                <li class="active"><?php echo display('add_booking') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Alert Message -->
        <?php
          $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
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
                            <h4><?php echo display('add_booking') ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open('Ccalender/insert_booking', array('class' => 'form-vertical', 'id' => '')) ?>
                        <div class="form-group row">
                            <label for="title" class="col-sm-3 col-form-label"><?php echo display('title') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="title" id="title" type="text" placeholder="<?php echo display('title') ?>" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <!--standard_timing-->
                            <label for="d" class="col-sm-3 col-form-label"><?php echo display('bookingtime') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <!--basic_example_3-->
                                <input class="form-control basic_example_3" name ="bookingtime" id="d" type="text" placeholder="<?php echo display('datetime') ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_id" class="col-sm-3 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                           <div class="col-sm-6">
                                <?php if ($user_type == 1 || $user_type == 2) { ?>
                                    <select class="form-control select2" id="customer_id" onchange="customer_wise_vehicle(this.value)" name="customer_id" data-placeholder="-- select one --">
                                        <option value=""></option>
                                        <?php foreach ($customers as $customer) { ?>
                                            <option value="<?php echo $customer['customer_id'] ?>">
                                                        <?php echo $customer['customer_name']; ?>
                                            </option>   
                                        <?php } ?>   
                                    </select>
                                    <?php
                                }
                                if ($user_type == 3) {
                                    ?>
                               <input type="hidden" class="form-control" name="customer_id" id="customer_id" value="<?php echo $user_id; //$this->session->userdata('user_id') ?>" readonly>
                                    <?php
                                    foreach ($customers as $customer) {
                                        if($user_id == $customer['customer_id']){
                                            echo $customer['customer_name']; 
                                        }
                                    }
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                         <?php
                            $customer_wise_vehicle_info = $this->Jobs_model->customer_wise_vehicle_info($user_id);
                            ?>
                        <div class="form-group row">
                            <label for="registration_no" class="col-sm-3 col-form-label"><?php echo display('registration_no') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select name="registration_no" id="registration_no" class="form-control select2" required data-placeholder="-- select one --">
                                    <!--<option value=""></option>-->                                    
                                     <?php
                                        if ($customer_wise_vehicle_info) {
                                            foreach ($customer_wise_vehicle_info as $vehicle) {
                                                echo "<option value='$vehicle->vehicle_id'>$vehicle->vehicle_registration</option>";
                                            }
                                        }
                                        ?>
                                </select>
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
    <input type="hidden" id="custWiseVehi" value="<?php echo base_url('Cjob/customer_wise_vehicle_info'); ?>">
</div>

<script src="<?php echo base_url('assets/custom/calender.js') ?>"></script>