<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('calender') ?></h1>
            <small><?php echo display('edit_booking') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('calender') ?></a></li>
                <li class="active"><?php echo display('edit_booking') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Alert Message -->
        <?php
        $message = $this->session->userdata('message');
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
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
                            <h4><?php echo display('edit_booking') ?> </h4>
                        </div>
                    </div>

                    <div class="panel-body">
                        <?php echo form_open('Ccalender/update_booking', array('class' => 'form-vertical', 'id' => '')) ?>
                        <div class="form-group row">
                            <label for="title" class="col-sm-3 col-form-label"><?php echo display('title') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="title" id="title" type="text" placeholder="<?php echo display('title') ?>"  value="<?php echo $booking[0]['title'] ?>">
                                <input type="hidden" name="id" value="<?php echo $booking[0]['id'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bookingtime" class="col-sm-3 col-form-label"><?php echo display('bookingtime') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <!--basic_example_3    standard_timing-->
                                <input class="form-control basic_example_3" name ="bookingtime" id="bookingtime" type="text" placeholder="<?php echo display('datetime') ?>" required value="<?php echo $booking[0]['booking_time'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_id" class="col-sm-3 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <?php if ($user_type == 1 || $user_type == 2) { ?>
                                    <select class="form-control select2" id="customer_id" onchange="customer_wise_vehicle(this.value)" name="customer_id" data-placeholder="-- select one --">
                                        <option value=""></option>
                                        <?php foreach ($customers as $customer) { ?>
                                            <option value="<?php echo $customer['customer_id'] ?>" <?php
                                            if ($booking[0]['customer_id'] == $customer['customer_id']) {
                                                echo 'selected';
                                            }
                                            ?>>
                                                        <?php echo $customer['customer_name'] ?>
                                            </option>   
                                        <?php } ?>   
                                    </select>
                                    <?php
                                }
                                if ($user_type == 3) {
                                    ?>
                                    <input type="text" class="form-control" name="customer_id" id="customer_id" value="<?php echo $this->session->userdata('user_id') ?>" readonly>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                        if ($user_type == 3) {
                            $user_id = $user_id;
                        } else {
                            $user_id = $booking[0]['customer_id'];
                        }
                        $customer_wise_vehicle_info = $this->Jobs_model->customer_wise_vehicle_info($user_id);
                        ?>
                        <div class="form-group row">
                            <label for="registration_no" class="col-sm-3 col-form-label"><?php echo display('registration_no') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select name="registration_no" id="registration_no" class="form-control select2" required data-placeholder="-- select one --">
                                    <option value=""></option>
                                    <?php
                                    if ($customer_wise_vehicle_info) {
                                        foreach ($customer_wise_vehicle_info as $vehicle) {
                                            ?>
                                            <option value='<?php echo $vehicle->vehicle_registration; ?>' <?php
                                            if ($booking[0]['registration_no'] == $vehicle->vehicle_registration) {
                                                echo 'selected';
                                            }
                                            ?>>
                                                        <?php echo $vehicle->vehicle_registration; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save_changes') ?>" />
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
<script src="<?php echo base_url('assets/custom/calender.js.php') ?>"></script>