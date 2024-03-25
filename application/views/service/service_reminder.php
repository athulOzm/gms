<!-- Manage service Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('service') ?></h1>
            <small><?php echo display('manage_your_service') ?></small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('service') ?></a></li>
                <li class="active"><?php echo display('service_reminder') ?></li>
            </ol>
        </div>
    </section>
    <?php
    $user_type = $this->session->userdata('user_type');
    $user_id = $this->session->userdata('user_id');
    $customer_id = '';
    if ($user_type == 3) {
        $customer_id = $user_id;
    }
    ?>
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
                <!--                <div class="column">
                <?php if ($this->permission1->method('create_service', 'create')->access()) { ?>
                          <a href="<?php echo base_url('Cservice') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_service') ?> </a>
                <?php } ?>
                <?php if ($this->permission1->method('create_service', 'create')->access()) { ?>
                                                                                                    <button type="button" class="btn btn-info m-b-5 m-r-2" data-toggle="modal" data-target="#service_csv"><?php echo display('service_csv_upload') ?></button>
                <?php } ?>
                                </div>-->
            </div>
        </div>

        <!-- Manage service -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <?php echo display('service_reminder'); ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open('Cservice/service_reminder_save', array('class' => 'form-vertical', 'id' => 'insert_menu')) ?>
                        <div class="form-group row">
                            <label for="customer_id" class="col-sm-3 text-right"><?php echo display('customer'); ?> <span class="text-danger"> * </span></label>
                            <div class="col-sm-8">
                                <?php // dd($customers);  ?>
                                <select  class="form-control select2" name="customer_id" id="customer_id" onchange="get_customer_info(this.value)" data-placeholder="-- select one --" tabindex="1" required>
                                    <option value=""></option>
                                    <?php foreach ($customers as $customer) { ?>
                                        <option value="<?php echo $customer['customer_id']; ?>" <?php
                                        if ($customer['customer_id'] == $user_id) {
                                            echo 'selected';
                                        }
                                        ?>>
                                                    <?php echo $customer['customer_name']; ?>
                                        </option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="registration_no" class="col-sm-3 text-right"><?php echo display('vehicles'); ?> <span class="text-danger"> * </span></label>
                            <div class="col-sm-8">
                                <select  class="form-control select2" name="registration_no" id="registration_no" data-placeholder="-- select firstly customer --" tabindex="2" required>
                                    <option value=""></option>
                                    <?php
                                    $customer_wise_vehicle_info = $this->Jobs_model->customer_wise_vehicle_info($customer_id);
                                    foreach ($customer_wise_vehicle_info as $vehicle) {
                                        echo "<option value='$vehicle->vehicle_id'>$vehicle->vehicle_registration</option>'";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="job_type_id" class="col-sm-3 text-right"><?php echo display('job_type'); ?> <span class="text-danger"> * </span></label>
                            <div class="col-sm-8">
                                <select  class="form-control select2" name="job_type_id" id="job_type_id" data-placeholder="-- select one --" tabindex="3" required>
                                    <option value=""></option>
                                    <?php
                                    foreach ($get_jobcategory as $jobcategory) {
                                        $get_jobtypes = $this->Jobs_model->get_jobcategory_wise_type($jobcategory->job_category_id);
                                        if (!empty($jobcategory)) {
                                            ?>
                                            <optgroup label="<?php echo $jobcategory->job_category_name; ?>">
                                                <?php foreach ($get_jobtypes as $jobtype) { ?>
                                                    <option value="<?php echo $jobtype->job_type_id; ?>">
                                                        <?php echo $jobtype->job_type_name; ?>
                                                    </option>
                                                <?php } ?>
                                            </optgroup>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-1"></label>
                            <div class="col-sm-10">
                                <table class="table table-bordered">
                                    <thead>
                                    <th></th>
                                    <th class="text-center"><?php echo display('date'); ?></th>
                                    <th class="text-center"><?php echo display('hubo_reading'); ?></th>
                                    <th class="text-center"><?php echo display('engine_hour'); ?></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class='text-right'><strong><?php echo display('next_occurrence'); ?></strong></td>
                                            <td>
                                                <input type="text" name="occurrence_date" id="occurrence_date" placeholder="<?php echo display('next_occurrence'); ?>" class="form-control datepicker" tabindex="4" required>
                                            </td>
                                            <td>
                                                <input type="text" name="" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='text-right'><strong><?php echo display('reminder'); ?> </strong></td>
                                            <td>
                                                <div class="col-sm-4">
                                                    <input type="number" min="1" name="reminder_count" class="form-control" id="reminder_count" tabindex="5">
                                                </div>
                                                <div class="col-sm-6">
                                                    <select  class="form-control select2" name="reminder_period" id="reminder_period" data-placeholder="-- select one --" tabindex="6">
                                                        <option value=""></option>
                                                        <option value="week">Weeks</option>
                                                        <option value="month">Months</option>
                                                        <option value="year">Years</option>                                   
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='text-right'><strong><?php echo display('repeat'); ?> </strong></td>
                                            <td>
                                                <div class="col-sm-4">
                                                    <input type="number" min="1" name="repeat_count" id="repeat_count" class="form-control" tabindex="7">
                                                </div>
                                                <div class="col-sm-6">
                                                    <select  class="form-control select2" name="repeat_period" id="repeat_period" data-placeholder="-- select one --" tabindex="8">
                                                        <option value=""></option>
                                                        <option value="week">Weeks</option>
                                                        <option value="month">Months</option>
                                                        <option value="year">Years</option>                                   
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="" class="form-control">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="" class="btn btn-primary btn-large" name="add-user" value="Save" tabindex="9" />
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="custinfo" value="<?php echo base_url('Cjob/customer_wise_vehicle_info'); ?>">
</div>
<!-- Manage service End -->
<script src="<?php echo base_url('assets/custom/serviceReminder.js') ?>"></script>

