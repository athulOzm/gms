<!--<link href="http://code.jquery.com/ui/1.10.0/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css"/>
<link href="https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css"/>-->
<style type="text/css">
    .nav-tabs{
        border-bottom: 1px solid #ddd;
    }
    .nav-tabs>li.active, .nav-tabs>li.active>a, .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus{
        border-bottom-color: transparent;
    }
    .select2-container {
        width: 170px !important;
    }
    td p{font-size: 10px; font-weight: bold;}
    td label{font-size: 10px; font-weight: bold;}
</style>
<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$company_info = $CI->db->get('company_information')->row();
//dd($Web_settings);

$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
?>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('jobs') ?></h1>
            <small><?php echo display('job_confirmation') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('jobs') ?></a></li>
                <li class="active"><?php echo display('job_confirmation') ?></li>
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

        <?php // print_r($get_workorder); ?>
        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">
                <!--<div class="alert_show" style="display: none;">Hobe na!</div>-->
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('job_confirmation') ?> </h4>
                        </div>
                    </div>
                    <?php // echo form_open('#', array('class' => 'form-vertical', 'id' => 'insert_category')) ?>
                    <div class="panel-body">
                        <ul class="nav nav-tabs" style="margin-bottom: 20px;">
                            <li class="active"><a href="#tab1" data-toggle="tab"><?php echo display('job_order'); ?></a></li>
                            <?php if ($get_workorder[0]->status != 0) { ?>
                                <li class="change_me" ><a href="#tab2" data-toggle="tab" id="t2"><?php echo display('job_performed'); ?></a></li>
                            <?php } else { ?>
                                <li class="change_me" ><a href="#tab2" data-toggle="tab" id="t2"><?php echo display('requested'); ?></a></li>
                            <?php } ?>
<!--                            <li><a href="#tab3" data-toggle="tab"><?php echo display('product_used'); ?></a></li>
<li><a href="#tab4" data-toggle="tab"><?php echo display('recommendation_notes'); ?></a></li>-->
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <form action="<?php echo base_url('Cjob/workorder_update'); ?>" method="post">
                                    <div id="output" class="hide alert alert-danger"></div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="customer_id" class="col-sm-4 col-form-label"><?php echo display('customer') ?> <i class="text-danger">*</i></label>
                                            <div class="col-sm-8">
                                                <?php
                                                foreach ($customers as $customer) {
                                                    if ($get_workorder[0]->customer_id == $customer['customer_id']) {
                                                        ?>
                                                        <input type="text" name="" id="" class="form-control" value="<?php echo $customer['customer_name']; ?>" readonly>
                                                        <?php
                                                    }
                                                }
                                                ?>
<!--                                            <select name="customer_id" class="form-control" onchange="get_customer_info(this.value)" required >
<option value="">Select One </option>
                                                <?php
                                                foreach ($customers as $customer) {
                                                    ?>
    <option value="<?php echo $customer['customer_id'] ?>" <?php
                                                    if ($get_workorder[0]->customer_id == $customer['customer_id']) {
                                                        echo 'selected';
                                                    }
                                                    ?>>
                                                    <?php echo $customer['customer_name'] ?>
    </option>
                                                <?php } ?>
</select>-->
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="order_no" class="col-sm-4 col-form-label"><?php echo display('work_order_no') ?> </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="order_no" id="order_no" class="form-control" value="<?php echo $get_workorder[0]->work_order_no; ?>" placeholder="<?php echo display('enter_customer_order_no') ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="address" class="col-sm-4 col-form-label"><?php echo display('address') ?> <i class="text-danger"></i></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="address" class="form-control" id="address" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="registration_no" class="col-sm-4 col-form-label"><?php echo display('registration_no') ?> <i class="text-danger">*</i></label>
                                            <div class="col-sm-8">
                                                <?php
                                                foreach ($customer_wise_vehicle_info as $single) {
                                                    if ($single->vehicle_id == $get_workorder[0]->vehicle_id) {
                                                        ?>
                                                        <input type="text" name="" id="registration_no" class="form-control" value="<?php echo $single->vehicle_registration; ?>" readonly>
                                                        <?php
                                                    }
                                                }
                                                ?>
<!--                                            <select name="registration_no" id="registration_no" class="form-control">
<option value="">Select Registration</option>
                                                <?php foreach ($customer_wise_vehicle_info as $single) { ?>
    <option value="<?php echo $single->vehicle_id; ?>" <?php
                                                    if ($single->vehicle_id == $get_workorder[0]->vehicle_id) {
                                                        echo 'selected';
                                                    }
                                                    ?>>
                                                    <?php echo $single->vehicle_registration; ?>
    </option>
                                                <?php } ?>
</select>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="phone" class="col-sm-4 col-form-label"><?php echo display('phone') ?> <i class="text-danger"></i></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="phone" class="form-control" id="phone" value="<?php echo $customer_info[0]->customer_phone; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="reference" class="col-sm-4 col-form-label"><?php echo display('reference') ?> <i class="text-danger"></i></label>
                                            <div class="col-sm-8">
                                                <input type="tex" name="reference" id="reference" class="form-control" value="<?php echo $get_workorder[0]->customer_ref; ?>" placeholder="<?php echo display('reference') ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="mobile" class="col-sm-4 col-form-label"><?php echo display('mobile') ?> <i class="text-danger"></i></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="mobile" class="form-control" id="mobile" value="<?php echo $customer_info[0]->customer_phone; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="schedule_datetime" class="col-sm-4 col-form-label"><?php echo display('schedule_datetime') ?> <i class="text-danger">*</i></label>
                                            <div class="col-sm-8">
                                                <input type="tex" name="schedule_datetime" id="schedule_datetime" class="form-control basic_example_3" value="<?php
                                                if ($get_workorder[0]->schedule_date_time == '0000-00-00 00:00:00') {
                                                    echo ' ';
                                                } else {
                                                    echo $get_workorder[0]->schedule_date_time;
                                                }
                                                ?>" placeholder="<?php echo display('schedule_datetime') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="website" class="col-sm-4 col-form-label"><?php echo display('website') ?> <i class="text-danger"></i></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="website" class="form-control" id="website" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="delivery_datetime" class="col-sm-4 col-form-label"><?php echo display('delivery_datetime') ?> <i class="text-danger">*</i></label>
                                            <div class="col-sm-8">
                                                <input type="tex" name="delivery_datetime" id="delivery_datetime" class="form-control basic_example_3" value="<?php
                                                if ($get_workorder[0]->delivery_date_time == '0000-00-00 00:00:00') {
                                                    echo ' ';
                                                } else {
                                                    echo $get_workorder[0]->delivery_date_time;
                                                }
                                                ?>" placeholder="<?php echo display('delivery_datetime') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="details" class="col-sm-4 col-form-label"><?php echo display('details') ?> <i class="text-danger"></i></label>
                                            <div class="col-sm-8">
                                                <textarea  name="details" class="form-control" id="details" readonly><?php echo $get_workorder[0]->job_description; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="vehicle" class="col-sm-4 col-form-label"><?php
                                                echo display('alert_via');
//                                            echo $get_workorder[0]->alert_via;
                                                ?> <i class="text-danger">*</i></label>
                                            <div class="col-sm-8">
                                                <input type="radio" id="sms" name="alert_via" value="sms" <?php
                                                if ($get_workorder[0]->alert_via == 'sms') {
                                                    echo 'checked';
                                                }
                                                ?>>
                                                <label for="sms">SMS</label>
                                                <input type="radio" id="email" name="alert_via" value="email" <?php
                                                if ($get_workorder[0]->alert_via == 'email') {
                                                    echo 'checked';
                                                }
                                                ?>>
                                                <label for="email">Email</label>
                                                <input type="radio" id="post" name="alert_via" value="post" <?php
                                                if ($get_workorder[0]->alert_via == 'post') {
                                                    echo 'checked';
                                                }
                                                ?>>
                                                <label for="post">Post</label>
                                                <input type="radio" id="never" name="alert_via" value="never" <?php
                                                if ($get_workorder[0]->alert_via == 'never') {
                                                    echo 'checked';
                                                }
                                                ?>>
                                                <label for="never">Never</label>
                                                <?php
//                                            if ($get_workorder[0]->alert_via == 'sms') {
//                                                echo "SMS";
//                                            }
//                                            if ($get_workorder[0]->alert_via == 'email') {
//                                                echo 'checked';
//                                            }
//                                            if ($get_workorder[0]->alert_via == 'post') {
//                                                echo 'checked';
//                                            }
                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
<?php if ($user_type == 1) { ?>
                                            <div class="col-sm-6">
                                                <label for="order_status" class="col-sm-4 "><?php echo display('order_status'); ?></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control select2" name="order_status" onchange="order_status_check(this.value)" id="order_status" data-placeholder="-- select one --">
                                                        <option value=""></option>
                                                        <option value="1" <?php
    if ($get_workorder[0]->status == 1) {
        echo 'selected';
    }
    ?>><?php echo display('accept'); ?></option>
                                                        <option value="2" <?php
                                                    if ($get_workorder[0]->status == 2) {
                                                        echo 'selected';
                                                    }
    ?>><?php echo display('decline'); ?></option>
                                                        <option value="3" <?php
                                                    if ($get_workorder[0]->status == 3) {
                                                        echo 'selected';
                                                    }
                                                    ?>><?php echo display('complete_invoice'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="show_hide_status" class="col-sm-4 "><?php echo display('show_hide_status'); ?></label>
                                                <div class="col-sm-8">
                                                    <?php if ($get_workorder[0]->show_hide_status == 1) { ?>
                                                        <input type="checkbox" name="show_hide_status" id="show_hide_status" value="1" <?php
                                                               if ($get_workorder[0]->show_hide_status == 1) {
                                                                   echo 'checked';
                                                               }
                                                               ?>>
                                            <?php } else { ?>
                                                        <input type="checkbox" name="show_hide_status" id="show_hide_status" value="0">
    <?php } ?>
                                                </div>
                                            </div>
<?php } ?>
                                    </div>

                                    <a class="btn btn-primary btnNext" ><?php echo display('next'); ?></a>
                                    <div class="form-group row" style="margin-top: 20px;">
                                        <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                        <div class="col-sm-6">
                                            <input type="hidden" name="job_id" id="job_id" value="<?php echo $get_workorder[0]->job_id; ?>">
                                            <input type="submit" id="" class="btn btn-success btn-large" onclick="" name="" value="<?php echo display('save') ?>" tabindex="7"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab2">                                
<?php echo form_open('Cjob/save_jobdetails', array('class' => 'form-vertical', 'id' => 'insert_category')) ?>
                                <div class="row">                                    
                                    <h4 style="margin: 0 0 20px 20px; "><?php echo display('job_performed'); ?></h4><hr>
<?php if ($get_workorder[0]->status != 0) { ?>
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <label for="odometer" class="col-sm-4 col-form-label"><?php echo display('odometer') ?> <i class="text-danger">*</i></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="odometer" id="odometer" class="form-control" value="<?php echo $get_workorder[0]->odometer; ?>" min="1" onkeyup="special_character(this.value, 'idname')" onchange="get_odometer(this.value)" placeholder="<?php echo display('odometer'); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="hubo_meter" class="col-sm-4 col-form-label"><?php echo display('hubo_meter') ?> <i class="text-danger">*</i></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="hubo_meter" id="hubo_meter" class="form-control" value="<?php echo $get_workorder[0]->hubo_meter; ?>" min="1" onkeyup="special_character(this.value, 'idname')" onchange="get_hubometer(this.value)" placeholder="<?php echo display('hubo_meter'); ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <label for="hour_meter" class="col-sm-4 col-form-label"><?php echo display('hour_meter') ?> <i class="text-danger">*</i></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="hour_meter" id="hour_meter" class="form-control" value="<?php echo $get_workorder[0]->hour_meter; ?>" min="1" onkeyup="special_character(this.value, 'idname')"  onchange="get_hourmeter(this.value)" placeholder="<?php echo display('hour_meter'); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="cof_wof_date" class="col-sm-4 col-form-label"><?php echo display('cof_wof_date') ?> <i class="text-danger">*</i></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="cof_wof_date" id="cof_wof_date" onchange="get_cofwofdate(this.value)" class="form-control datepicker" value="<?php
                                                        if ($get_workorder[0]->cof_wof_date == '0000-00-00') {
                                                            echo ' ';
                                                        } else {
                                                            echo $get_workorder[0]->cof_wof_date;
                                                        }
                                                        ?>" placeholder="<?php echo display('cof_wof_date'); ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <label for="registration_date" class="col-sm-4 col-form-label"><?php echo display('registration_date') ?> <i class="text-danger">*</i></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="registration_date" id="registration_date" onchange="get_registrationdate(this.value)" class="form-control datepicker" value="<?php
                                                        if ($get_workorder[0]->registration_date == '0000-00-00') {
                                                            echo ' ';
                                                        } else {
                                                            echo $get_workorder[0]->registration_date;
                                                        }
                                                        ?>" placeholder="<?php echo display('registration_date'); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="fuel_burn" class="col-sm-4 col-form-label"><?php echo display('fuel_burn') ?> <i class="text-danger"> * </i></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="fuel_burn" id="fuel_burn" class="form-control" value="<?php echo $get_workorder[0]->fuel_burn; ?>"  min="1" onkeyup="special_character(this.value, 'idname')"  onchange="get_fuelburn(this.value)" placeholder="<?php echo display('fuel_burn'); ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<?php } ?>
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="item_table">
                                                <thead>
                                                    <tr>
                                                        <th width="20%"><?php echo display('job_type'); ?></th>
                                                        <?php if ($get_employeelist[0]->user_id != $user_id) { ?>
                                                            <th width="15%"><?php echo display('mechanic'); ?></th>
                                                        <?php } ?>
<?php if ($user_type == 1 || $user_type == 2) { ?>
                                                            <th width="25%"><?php echo display('starting_datetime'); ?></th>    
                                                            <?php } ?>    
                                                            <?php if ($user_type == 1 || $user_type == 2) { ?>
                                                            <th width="25%"><?php echo display('ending_datetime'); ?></th>   
                                                            <th width="10%"><?php echo display('spent_time'); ?>
<?php } ?>       
<?php if ($user_type == 1 || $user_type == 2) { ?>
                                                            <th width="10%"><?php echo display('mechanic_notes'); ?></th>   
<?php } ?>
                                                        <th width="10%" class="text-center"><?php echo display('status'); ?></th>
                                                        <th width="5%">
                                                            <button type="button" class="btn btn-success" onClick="addItem();"><i class="fa fa-plus"></i></button>
                                                        </th>      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($get_job_details) {
                                                        $j = 0;
                                                        $i = 0;
                                                        foreach ($get_job_details as $job_details) {
                                                            $i++;
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                        <?php if ($user_type == 1) { ?>
                                                                        <select name="job_type[]" id="job_type_<?php echo $i; ?>" onchange="jobtype_wise_info(this.value, '<?php echo $i; ?>');" class="form-control select2" data-placeholder="-- select one --">
                                                                            <option value=""></option>
                                                                            <?php foreach ($get_jobtypelist as $jobtype) { ?>
                                                                                <option value='<?php echo $jobtype->job_type_id; ?>' <?php
                                                                                            if ($job_details->job_type_id == $jobtype->job_type_id) {
                                                                                                echo 'selected';
                                                                                            }
                                                                                            ?>>
                                                                            <?php echo $jobtype->job_type_name; ?>
                                                                                </option>
                                                                        <?php } ?>
                                                                        </select>  
                                                                    <?php } elseif ($user_type == 2) { ?>
                                                                        <input type="hidden" name="job_type[]" value="<?php echo $job_details->job_type_id; ?>">
                                                                        <?php
                                                                        foreach ($get_jobtypelist as $jobtype) {
                                                                            if ($job_details->job_type_id == $jobtype->job_type_id) {
                                                                                echo $jobtype->job_type_name;
                                                                            }
                                                                        }
                                                                        ?>
                                                                    <?php } ?>
                                                                    <input type="hidden" name="jobtype_rate[]" id="jobtype_rate_<?php echo $i; ?>" value="<?php echo $job_details->rate; ?>">
        <?php
        foreach ($get_jobtypelist as $jobtype) {
            if ($job_details->job_type_id == $jobtype->job_type_id && $jobtype->fk_inspection_id != 0) {
                ?>
                                                                            <button type="button" class="btn btn-xs btn-info" onclick="assign_checklist('<?php echo $jobtype->fk_inspection_id; ?>', '<?php echo $get_workorder[0]->job_id; ?>')" data-toggle='tooltip' data-placement='top' title='Assign Checklist' style="margin-top: 5px;">
                                                                                <i class="ti-align-justify"></i>
                                                                            </button>
                                                                            <?php
                                                                            $checklist_view = $this->db->select('*')->where('fk_inspection_id', $jobtype->fk_inspection_id)->get('job_type')->row();
//                                                                            echo $checklist_view->job_type_id;
                                                                            $check_job_typeid_package = $this->db->select('*')
                                                                                            ->where('inspection_job_typeid', $checklist_view->job_type_id)
                                                                                            ->where('job_id', $get_workorder[0]->job_id)
                                                                                            ->get('package_tbl')->row();
                                                                            if ($check_job_typeid_package) {
                                                                                ?>
                                                                    <button type="button" class="btn btn-xs btn-success" onclick="view_checklist('<?php echo $jobtype->fk_inspection_id; ?>', '<?php echo $get_workorder[0]->job_id; ?>')" data-toggle='tooltip' data-placement='top' title='View Checklist' style="margin-top: 5px;">
                                                                                    <i class="fa fa-eye"><?php // echo $jobtype->fk_inspection_id;                        ?></i>
                                                                                </button>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                 <?php
//                                                                echo $get_employeelist[0]->user_id;   echo " D " . $user_id;  echo "<br>";  echo $user_type;
//                                                                if ($get_employeelist[0]->user_id != $user_id) { 
                                                                if ($user_type != 2) {
                                                                    ?>
                                                                        <select name="mechanics_id[]" id="mechanics_id_<?php echo $i; ?>" class="form-control select2" data-placeholder="-- select one --">
                                                                            <option value=""></option>
                                                                            <?php foreach ($get_employeelist as $mechanic) { ?>
                                                                                <option value='<?php echo $mechanic->user_id; ?>' <?php
                                                                                            if ($job_details->assign_to == $mechanic->user_id) {
                                                                                                echo 'selected';
                                                                                            }
                                                                                            ?>>
                                                                            <?php echo $mechanic->full_name; ?>
                                                                                </option>
                                                                        <?php } ?> 
                                                                        </select>  
                                                                <?php } else { ?>
                                                                          <input type="hidden" name="mechanics_id[]" value="<?php echo $user_id; ?>">
                                                                    <?php
                                                                    foreach ($get_employeelist as $mechanic) {
                                                                    if($job_details->assign_to == $mechanic->user_id){
                                                                        echo $mechanic->full_name;
                                                                    }
                                                                    }
                                                                    
                                                                } ?>
                                                                </td>                                                                
                                                                    <?php if ($user_type == 1 || $user_type == 2) { ?>
                                                                    <td>
                                                                        <input type="text" name="startdatetime[]" id="startdatetime_<?php echo $i; ?>" class="form-control basic_example_3" value="<?php
                                                                        if ($job_details->start_datetime == '0000-00-00 00:00:00') {
                                                                            echo ' ';
                                                                        } else {
                                                                            echo $job_details->start_datetime;
                                                                        }
                                                                        ?>">    
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if ($user_type == 1 || $user_type == 2) { ?>
                                                                    <td> <input type="text" name="c_enddatetime[]" onchange="enddatetime_check(this.value,<?php echo $i; ?>)" id="enddatetime_<?php echo $i; ?>" class="form-control basic_example_3"  value="<?php
                                                                        if ($job_details->end_datetime == '0000-00-00 00:00:00') {
                                                                            echo ' ';
                                                                        } else {
                                                                            echo $job_details->end_datetime;
                                                                        }
                                                                        ?>"> </td>                                                                    
                                                                    <td>
                                                                        <input type="text" name="spent_time[]" class="form-control" id="spent_time_<?php echo $i; ?>" value="<?php echo $job_details->spent_time; ?>">
                                                                    </td>
                                                                <?php } ?>
                                                                <?php if ($user_type == 1 || $user_type == 2) { ?>
                                                                    <td>
                                                                        <input type="text" name="mechanics_note[]" id="mechanics_note_<?php echo $i; ?>" class="form-control " value="<?php echo $job_details->mechanic_notes; ?>">
                                                                    </td>
                                                                    <?php } ?>
                                                                <td>                                                                    
                                                                    <?php
                                                                    if ($job_details->status == 0) {
                                                                        echo '<p class="text-center">Pending</p>';
                                                                    } elseif ($job_details->status == 3) {
                                                                        echo '<p class="text-center">Completed</p>';
                                                                    } elseif ($job_details->status == 1) {
                                                                        echo '<p class="text-center">In Progress</p>';
                                                                    } elseif ($job_details->status == 2) {
                                                                        echo '<p class="text-center">Declined</p>';
                                                                    }
                                                                    if ($job_details->status != 3 && $job_details->start_datetime == '0000-00-00 00:00:00') {
                                                                        ?>
                                                                        <label for="declined_<?php echo $i; ?>">
                                                                            <input type="hidden" name="checked_hdn_<?php echo$i; ?>" id="checked_hdn_<?php echo$i; ?>" value="<?php echo $job_details->status; ?>">
                                                                            <input type="checkbox" name="declined[]" value="<?php echo $job_details->status; ?>" <?php
                                                                       if ($job_details->status == 2) {
                                                                           echo 'checked';
                                                                       }
                                                                        ?> id="declined_<?php echo $i; ?>" onclick="check_declined('<?php echo $i; ?>')"> Declined
                                                                        </label>
                                                            <?php } else { ?>
                                                                    <!--<input type="hidden" name="declined[]" value="">-->
                                                            <?php } ?>
                                                                    <input type="hidden" name="jobdetails_rowid" id="jobdetails_rowid_<?php echo $i; ?>" value="<?php echo $job_details->row_id; ?>">
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <?php
                                                            $j++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modal_show_info" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header" style="text-align: center;">
                                                <!--                                                <h5 class="modal-title" style="float: left;">Edit Category Information</h5>
                                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                                                <img src="<?php echo $Web_settings[0]['invoice_logo']; ?>">
                                            </div>
                                            <div class="modal-body" id="modal_info">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 style="margin: 0 0 20px 20px;"><?php echo display('product_used'); ?></h4>
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="product_table">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo display('product_name'); ?></th>
                                                        <th><?php echo display('available_quantity'); ?></th>   
                                                        <th><?php echo display('used_quantity'); ?></th>   
                                                        <th><?php echo display('price'); ?></th>   
<?php if ($user_type == 1 || $user_type == 2) { ?>
                                                            <th><?php echo display('mechanic_notes'); ?></th>   
<?php } ?>
                                                        <th>
                                                            <button type="button" class="btn btn-success" onClick="addProduct('itmetable');"><i class="fa fa-plus"></i></button>
                                                        </th>      
                                                    </tr>
                                                </thead>
                                                <tbody id="itmetable">
                                                    <?php
                                                    if ($job_usedproduct) {
                                                        $i = 0;
                                                        foreach ($job_usedproduct as $usedproduct) {
                                                            $i++;
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <select name="product_id[]" id="product_id_<?php echo $i; ?>" class="form-control  select2" onchange="product_data(this.value, '<?php echo $i; ?>')">
                                                                        <option value="">Select One</option>
                                                                        <?php foreach ($get_productlist as $product) { ?>
                                                                            <option value='<?php echo $product->product_id; ?>' <?php
                                                                                        if ($usedproduct->product_id == $product->product_id) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                        ?>>
                                                                            <?php echo $product->product_name; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                        <?php foreach ($get_groupprice as $groupprice) { ?>
                                                                            <option value='<?php echo $groupprice->group_price_id; ?>' <?php
                                                                                        if ($usedproduct->product_id == $groupprice->group_price_id) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                        ?>>
            <?php echo $groupprice->group_name; ?>
                                                                            </option>
        <?php } ?>
                                                                    </select>       
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="available_qty[]" id="available_qty_<?php echo $i; ?>" class="form-control" value="<?php echo $usedproduct->available_qty; ?>" readonly>   
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="used_qty[]" value="<?php echo $usedproduct->used_qty; ?>" id="used_qty_<?php echo $i; ?>" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="price[]" value="<?php echo $usedproduct->rate; ?>" class="form-control" id="product_price_<?php echo $i; ?>" readonly>
                                                                </td>
                                                                <?php if ($user_type == 1 || $user_type == 2) { ?>
                                                                    <td>
                                                                        <input type="text" name="mechanic_notes[]" value="<?php echo $usedproduct->mechanic_note; ?>" id="mechanic_notes_<?php echo $i; ?>" class="form-control">
                                                                    </td>
                                                            <?php } ?>
                                                                <td></td>
                                                            </tr>
        <?php
    }
}
?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <label for="set_default_terms"><?php // echo display('terms');                    ?><?php echo display('recommendation_notes'); ?></label>
                                        <textarea name="set_default_terms" class="form-control" id="set_default_terms" placeholder="<?php echo display('recommendation_notes'); ?>" rows="5"><?php echo $get_workorder[0]->recommendation ?></textarea>
                                    </div>
                                </div>


                                <!--                                <div class="row">                                    
                                                                    <h4 style="margin: 20px 0 20px 20px; "><?php echo display('job_completed'); ?></h4>
                                                                    <div class="col-sm-12">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered" id="item_completed_table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th width="30%"><?php echo display('job_type'); ?></th>
<?php if ($user_type == 1 || $user_type == 2) { ?>
                                                                                                        <th width="25%"><?php echo display('ending_datetime'); ?></th>   
<?php } ?>       
                                                                                        <th width="20%"><?php echo display('spent_time'); ?>
                                                                                        <th width="25%" class="text-center"><?php echo display('status'); ?></th>
                                                                                        <th>
                                                                                            <button type="button" class="btn btn-success" onClick="addCompletedItem();"><i class="fa fa-plus"></i></button>
                                                                                        </th>      
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                <?php
                                if ($get_job_details) {
                                    $i = 0;
                                    foreach ($get_job_details as $job_details) {
                                        $i++;
                                        ?>
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <input type="hidden" name="jobdetails_rowid" id="jobdetails_rowid_<?php echo $i; ?>" value="<?php echo $job_details->row_id; ?>">
                                                                                                                            <select name="c_job_type[]" id="job_type_<?php echo $i; ?>" onchange="jobtype_wise_info(this.value, '<?php echo $i; ?>');" class="form-control select2" data-placeholder="-- select one --">
                                                                                                                                <option value=""></option>
                                        <?php foreach ($get_jobtypelist as $jobtype) { ?>
                                                                                                                                                <option value='<?php echo $jobtype->job_type_id; ?>' <?php
                                            if ($job_details->job_type_id == $jobtype->job_type_id) {
                                                echo 'selected';
                                            }
                                            ?>>
            <?php echo $jobtype->job_type_name; ?>
                                                                                                                                                </option>
                                        <?php } ?>
                                                                                                                            </select>       
                                                                                                                            <input type="hidden" name="c_jobtype_rate[]" id="jobtype_rate_<?php echo $i; ?>" value="<?php echo $job_details->rate; ?>">
                                                                                                                        </td>
                                        <?php if ($user_type == 1 || $user_type == 2) { ?>
                                                                                                                                        <td> <input type="text" name="c_enddatetime[]" onchange="enddatetime_check(this.value,<?php echo $i; ?>)" id="enddatetime_<?php echo $i; ?>" class="form-control basic_example_3"  value="<?php
                                            if ($job_details->end_datetime == '0000-00-00 00:00:00') {
                                                echo ' ';
                                            } else {
                                                echo $job_details->end_datetime;
                                            }
                                            ?>"> </td>
                                        <?php } ?>
                                                                                                                        <td>
                                                                                                                            <input type="text" name="spent_time[]" class="form-control" id="spent_time_<?php echo $i; ?>" value="<?php echo $job_details->spent_time; ?>">
                                                                                                                        </td>
                                                                                                                        <td>
                                        <?php
                                        if ($job_details->status == 0) {
                                            echo '<p class="text-center">Pending</p>';
                                        } elseif ($job_details->status == 3) {
                                            echo '<p class="text-center">Completed</p>';
                                        } elseif ($job_details->status == 1) {
                                            echo '<p class="text-center">In Progress</p>';
                                        } elseif ($job_details->status == 2) {
                                            echo '<p class="text-center">Declined</p>';
                                        }
                                        ?>
                                                                                                                        </td>
                                                                                                                        <td></td>
                                                                                                                    </tr>
        <?php
    }
}
?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                                <div class="form-group row" style="margin-top: 20px;">
                                    <label for="addProductused" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="job_id" value="<?php echo $get_workorder[0]->job_id; ?>">
                                        <input type="submit" id="addProductused" class="btn btn-success btn-large" name="addProductused" value="<?php echo display('save') ?>"/>
                                    </div>
                                </div>
<?php echo form_close() ?>
                                <a class="btn btn-primary btnPrevious"><?php echo display('previous'); ?></a>                                
<!--                                <a class="btn btn-primary btnNext" ><?php echo display('next'); ?></a>-->
                            </div>
                            <!--                            <div class="tab-pane" id="tab3">
                                                            <a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>
                                                            <a class="btn btn-primary btnNext" ><?php echo display('next'); ?></a>
                                                        </div>-->
                        </div>


                        <hr>

                    </div>
<?php // echo form_close()                                ?>
                </div>
            </div>

        </div>
    </section>
</div>

<!--<script type="text/javascript" src="http://code.jquery.com/ui/1.10.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="https://trentrichardson.com/examples/timepicker/jquery-ui-sliderAccess.js"></script>-->
<script type="text/javascript">
//                                                                        $('.basic_example_3').datetimepicker({
////	timeFormat: "hh:mm tt"
//                                                                            dateFormat: "yy-mm-dd",
//                                                                            timeFormat: "HH:mm",
//                                                                            showButtonPanel: false,
//                                                                        });

//                  =========== its for order status change =============
    function order_status_check(status) {
        var job_id = '<?php echo $get_workorder[0]->job_id; ?>';
//        alert(job_id);
        $.ajax({
            url: "<?php echo base_url('Cjob/order_status_check'); ?>",
            type: 'POST',
            data: {status: status, job_id: job_id},
            success: function (r) {
                if (r == 1) {
                    alert("already some order pending!");
                    $("#order_status").empty().append("<option value=''>-- select one --</option>");
                    $("#order_status").append("<option value='1'>Accept</option>");
                    $("#order_status").append("<option value='2'>Decline</option>");
                    $("#order_status").append("<option value='3'>Complete</option>");
                }
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.btnNext').click(function () {
            $('.nav-tabs > .active').next('li').find('a').trigger('click');
        });

        $('.btnPrevious').click(function () {
            $('.nav-tabs > .active').prev('li').find('a').trigger('click');
        });

//        ======= checkbox value read ==========
        $("#show_hide_status").click(function () {
            if ($('#show_hide_status').is(':checked')) {
                $('#show_hide_status').attr('value', '1');
            } else {
                $('#show_hide_status').attr('value', '0');
            }
        });

    });
    //=========== its for get special character =========
    function special_character(vtext, id) {
        var specialChars = "abcedfghijklmnopqrstuvwxyz<>@!#$%^&*()_+[]{}?:;|'\"\\/~`-="
        var check = function (string) {
            for (i = 0; i < specialChars.length; i++) {
                if (string.indexOf(specialChars[i]) > -1) {
                    return true
                }
            }
            return false;
        }
        if (check(vtext) == false) {
            // Code that needs to execute when none of the above is in the string
        } else {
            alert(specialChars + " these special character are not allows");
            $("#" + id).val('').focus();
        }

    }
//    ============ its for get odometer ===========
    function get_odometer(t) {
        var odometer = +t;
        var job_id = $("#job_id").val();
        var registration_no = $("#registration_no").val();
        var vehicle_id = "<?php echo $get_workorder[0]->vehicle_id; ?>";
        $.ajax({
            url: "<?php echo base_url('Cjob/get_odometer'); ?>",
            type: "POST",
            data: {job_id: job_id, vehicle_id: vehicle_id},
            success: function (r) {
                if (odometer < r) {
                    alert("Odometer cannot less of previous odometer " + r);
                    $("#odometer").val('').focus();
                }
            }
        });
    }
//    ================== its for get_hubometer =============
    function get_hubometer(h) {
        var hubometer = +h;
        var job_id = $("#job_id").val();
        var vehicle_id = "<?php echo $get_workorder[0]->vehicle_id; ?>";
        $.ajax({
            url: "<?php echo base_url('Cjob/get_hubometer'); ?>",
            type: "POST",
            data: {job_id: job_id, vehicle_id: vehicle_id},
            success: function (r) {
                if (hubometer < r) {
                    alert("Hubo meter cannot less of previous hubometer " + r);
                    $("#hubo_meter").val('').focus();
                }
            }
        });
    }
//    ================== its for get_hourmeter =============
    function get_hourmeter(h) {
        var hour_meter = +h;
        var job_id = $("#job_id").val();
        var vehicle_id = "<?php echo $get_workorder[0]->vehicle_id; ?>";
        $.ajax({
            url: "<?php echo base_url('Cjob/get_hourmeter'); ?>",
            type: "POST",
            data: {job_id: job_id, vehicle_id: vehicle_id},
            success: function (r) {
                if (hour_meter < r) {
                    alert("Hour meter cannot less of previous hourmeter " + r);
                    $("#hour_meter").val('').focus();
                }
            }
        });
    }
//============= its for get_cofwofdate =============
    function get_cofwofdate(t) {
        var cofwof_date = t;
        var job_id = $("#job_id").val();
        var vehicle_id = "<?php echo $get_workorder[0]->vehicle_id; ?>";
        $.ajax({
            url: "<?php echo base_url('Cjob/get_cofwofdate'); ?>",
            type: "POST",
            data: {job_id: job_id, vehicle_id: vehicle_id, cofwof_date: cofwof_date},
            success: function (r) {
                if (r == 0) {
                    alert('Wrong info!');
                    $("#cof_wof_date").val('').focus();
                }
            }
        });
    }
//============= its for get_registrationdate =============
    function get_registrationdate(t) {
        var regi_date = t;
        var job_id = $("#job_id").val();
        var vehicle_id = "<?php echo $get_workorder[0]->vehicle_id; ?>";
        $.ajax({
            url: "<?php echo base_url('Cjob/get_registrationdate'); ?>",
            type: "POST",
            data: {job_id: job_id, vehicle_id: vehicle_id, regi_date: regi_date},
            success: function (r) {
                if (r == 0) {
                    alert('Wrong info!');
                    $("#registration_date").val('').focus();
                }
            }
        });
    }

//    ================== its for get_fuelburn =============
    function get_fuelburn(f) {
        var fuel_burn = +f;
        var job_id = $("#job_id").val();
        var vehicle_id = "<?php echo $get_workorder[0]->vehicle_id; ?>";
        $.ajax({
            url: "<?php echo base_url('Cjob/get_fuelburn'); ?>",
            type: "POST",
            data: {job_id: job_id, vehicle_id: vehicle_id},
            success: function (r) {
                if (fuel_burn < r) {
                    alert("Fuel burn cannot less of previous fuel burn " + r);
                    $("#fuel_burn").val('').focus();
                }
            }
        });
    }

    function addLabour() {
        var xTable = document.getElementById('job_type_table');
        var tr = document.createElement('tr');
        tr.innerHTML = '<td><select name="job_type_id" id="job_type_id" class="form-control select2"><option value="">-- select one -- </option> <?php foreach ($get_jobtypelist as $jobtype) { ?><option value="<?php echo $jobtype->job_type_id; ?>"><?php echo $jobtype->job_type_name; ?></option> <?php } ?></select></td>\n\
<?php // if ($get_employeelist[0]->user_id != $user_id) {                            ?><td><select name="mechanics_id" id="mechanics_id" class="form-control select2"><option value="">-- select one -- </option><?php foreach ($get_employeelist as $mechanic) { ?><option value="<?php echo $mechanic->user_id; ?>"><?php echo $mechanic->full_name; ?></option> <?php } ?></select></td><?php // }                            ?>\n\
                                 <td><input type="text" name="customer_note" class="form-control "></td>\n\
                                 <td><button style="text-align: right;" class="btn btn-danger removelabour" type="button"  onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button></td>';
        xTable.children[1].appendChild(tr); // appends to the tbody element
        $(".datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
            todayBtn: true
        });
    }
//" + a + "

    function addItem() {
        var row = $("#item_table tbody tr").length;
        var count = row + 1;
        var limits = 500;
//        alert(count);
        var xTable = document.getElementById('item_table');
        var tr = document.createElement('tr');
        tr.innerHTML = '<td><select name="job_type[]" onchange="jobtype_wise_info(this.value,' + count + ')" id="job_type_' + count + '" class="form-control select2" data-placeholder="-- select one -- "><option value=""></option><?php foreach ($get_jobtypelist as $jobtype) { ?><option value="<?php echo $jobtype->job_type_id; ?>"><?php echo $jobtype->job_type_name; ?></option> <?php } ?></select>\n\
                                 <input type="hidden" name="jobtype_rate[]" id="jobtype_rate_' + count + '"></td>\n\
<?php if ($get_employeelist[0]->user_id != $user_id) { ?>  <td><select name="mechanics_id[]" id="mechanics_id_' + count + '" class="form-control select2"><option value="">-- select one --</option><?php foreach ($get_employeelist as $mechanic) { ?><option value="<?php echo $mechanic->user_id; ?>"><?php echo $mechanic->full_name; ?></option><?php } ?></select></td><?php } else { ?><input type="hidden" name="mechanics_id[]" value="<?php echo $user_id; ?>"><?php } ?>\n\
<?php if ($user_type == 1 || $user_type == 2) { ?>\n\
                   <td><input type="text" name="startdatetime[]" id="startdatetime_' + count + '" class="form-control basic_example_3"> </td>\n\
<?php } ?>\n\
<?php if ($user_type == 1 || $user_type == 2) { ?>\n\
                        <td><input type="text" name="c_enddatetime[]" onchange="enddatetime_check(this.value,' + count + ')" id="enddatetime_' + count + '" class="form-control basic_example_3"></td>\n\
                        <td><input type="text" name="spent_time[]" class="form-control " id="spent_time_' + count + '"></td>\n\
<?php } ?>\n\
<?php if ($user_type == 1 || $user_type == 2) { ?>\n\
                    <td><input type="text" name="mechanics_note[]" id="mechanics_note_' + count + '" class="form-control "></td>\n\
<?php } ?>\n\
  <td> \n\
<?php
if ($job_details->start_datetime == '0000-00-00 00:00:00') {
    echo '<p class="text-center">Pending</p>';
}
?>\n\
                            </td>\n\
                                <td><button style="text-align: right;" class="btn btn-danger removeitem" type="button"  onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button></td>';
        xTable.children[1].appendChild(tr); // appends to the tbody element
        $(".basic_example_3").datetimepicker({
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm",
            showButtonPanel: false,
        });
        $('.select2').select2();
    }
    function addProduct(t) {
        var row = $("#product_table tbody tr").length;
        var count = row + 1;
        var limits = 500;
        var xTable = document.getElementById('product_table');
        var tr = document.createElement('tr');
        tr.innerHTML = '<td><select name="product_id[]" id="product_id"  class="form-control select2" onchange="product_data(this.value,' + count + ')"><option value="" >-- select one -- </option><?php foreach ($get_productlist as $product) { ?><option value="<?php echo $product->product_id; ?>"><?php echo $product->product_name; ?></option> <?php } ?></select></td>\n\
                                 <td><input type="text" name="available_qty[]" id="available_qty_' + count + '" class="form-control" readonly> </td>\n\
                                <td><input type="text" name="used_qty[]" class="form-control"> </td>\n\
                                <td> <input type="text" name="price[]" class="form-control" id="product_price_' + count + '" readonly> </td>\n\
<?php if ($user_type == 1 || $user_type == 2) { ?>\n\
                                                                                                                                                                                                                                                                                                                               <td><input type="text" name="mechanic_notes[]" class="form-control"></td>\n\
<?php } ?>\n\
                                <td><button style="text-align: right;" class="btn btn-danger removeitem" type="button"  onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button></td>';
        document.getElementById(t).appendChild(tr),
//                document.getElementById(a).focus(),
                count++
        //xTable.children[1].appendChild(tr); // appends to the tbody element
        $(".datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
            todayBtn: true
        });
        $('.select2').select2();
    }


    function addCompletedItem() {
        var row = $("#item_completed_table tbody tr").length;
        var count = row + 1;
        var limits = 500;
//        alert(count);
        var xTable = document.getElementById('item_completed_table');
        var tr = document.createElement('tr');
        tr.innerHTML = '<td><select name="job_type" onchange="jobtype_wise_info(this.value,' + count + ')" id="job_type_' + count + '" class="form-control select2" data-placeholder="-- select one -- "><option value=""></option><?php foreach ($get_jobtypelist as $jobtype) { ?><option value="<?php echo $jobtype->job_type_id; ?>"><?php echo $jobtype->job_type_name; ?></option> <?php } ?></select>\n\
                                 <input type="hidden" name="jobtype_rate[]" id="jobtype_rate_' + count + '"></td>\n\
<?php if ($user_type == 1 || $user_type == 2) { ?>\n\
                                                                                                                                                                                                                                                 <td><input type="text" name="enddatetime" id="enddatetime_' + count + '" class="form-control datetime"> </td>\n\
                                                                                                                                                                                                                                                   \n\
<?php }
?>\n\
                            <td> \n\
                            <select name="jobperformed_status" id="jobperformed_status_' + count + '" class="form-control  select2" ><option value="">-- select one --</option><option value="0">Pending</option><option value="1">In Progress</option><option value="2">Declined</option><option value="3">Completed</option></select>\n\
                            </td>';
        xTable.children[1].appendChild(tr); // appends to the tbody element
        $(".datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
            todayBtn: true
        });
        $('.select2').select2();
    }

    $(document).on('click', 'button.removelabour', function () {
        $(this).closest('tr').remove();
        return false;
    });

    $(document).on('click', 'button.removeitem', function () {
        $(this).closest('tr').remove();
        return false;
    });

    //    ========== its for when customer select then show his/her information show =========
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

<!-- product select -->
<script type="text/javascript">
    function product_data(product_id, sl) {
        var avail_qty = '#available_qty_' + sl;
        var price = '#product_price_' + sl;

        $.ajax({
            url: "<?php echo base_url('Cjob/available_quantity_check'); ?>",
            type: 'POST',
            data: {product_id: product_id},
            success: function (r) {
//                r = JSON.parse(r);
//                $(avail_qty).val(r.totalstock);
//                $(price).val(r.price);
                var obj = jQuery.parseJSON(r);
                if(obj.available_qty == 0){
                    alert("This product quatity is not available!");
                }
                $(avail_qty).val(obj.available_qty);
                $(price).val(obj.price);

            }
        });

    }

//    ============ its for jobtype_wise_info =============
    function jobtype_wise_info(jobtype_id, sl) {
        var jobtype_rate = '#jobtype_rate_' + sl;
        $.ajax({
            url: "<?php echo base_url('Cjob/jobtype_wise_info'); ?>",
            type: 'POST',
            data: {jobtype_id: jobtype_id},
            success: function (r) {
                r = JSON.parse(r);
//                alert(r.customer_id);
                $(jobtype_rate).val(r.job_type_rate);
            }
        });
    }
//    ========== its for job performed status change ===========
//    function change_jobperformed(id, count) {
////    alert(id);    alert(count);
//        var job_id = "<?php echo $get_workorder[0]->job_id ?>"
//        var job_type = $("#job_type_" + count).val();
//        var jobtype_rate = $("#jobtype_rate_" + count).val();
//        var mechanics_id = $("#mechanics_id_" + count).val();
//        var startdatetime = $("#startdatetime_" + count).val();
//        var enddatetime = $("#enddatetime_" + count).val();
//        var mechanics_note = $("#mechanics_note_" + count).val();
//        var jobdetails_rowid = $("#jobdetails_rowid_" + count).val();
//        var burl = "<?php echo base_url() ?>";
////        alert(id);exit();
//        if (id == 1) {
//            if (startdatetime == '') {
//                alert("Start date time must be required");
//                $("#startdatetime_" + count).focus();
//                $("#jobperformed_status_" + count).val(null).trigger('change');
//                return FALSE;
//            } else {
//                $.ajax({
//                    url: "<?php echo base_url('Cjob/change_jobperformed'); ?>",
//                    type: 'POST',
//                    data: {job_id: job_id, performed_status: id, job_type: job_type, jobtype_rate: jobtype_rate, mechanics_id: mechanics_id, startdatetime: startdatetime, enddatetime: enddatetime, mechanics_note: mechanics_note, jobdetails_rowid: jobdetails_rowid},
//                    success: function (r) {
////                    console.log(r);
//                        location.reload(true);
//                    }
//                });
//            }
//        }
//        if (id == 2) {
//            if (mechanics_note == '') {
//                alert("Mechanic notes must be required");
//                $("#mechanics_note_" + count).focus();
//                $("#jobperformed_status_" + count).val(null).trigger('change');
//                return FALSE;
//            } else {
//                $.ajax({
//                    url: "<?php echo base_url('Cjob/change_jobperformed'); ?>",
//                    type: 'POST',
//                    data: {job_id: job_id, performed_status: id, job_type: job_type, jobtype_rate: jobtype_rate, mechanics_id: mechanics_id, startdatetime: startdatetime, enddatetime: enddatetime, mechanics_note: mechanics_note, jobdetails_rowid: jobdetails_rowid},
//                    success: function (r) {
//                        location.reload(true);
//                    }
//                });
//            }
//        }
//        if (id == 3) {
//            if (startdatetime == '' || enddatetime == '') {
//                alert("Datetime must be required");
//                $("#startdatetime_" + count).focus();
//                $("#enddatetime_" + count).focus();
//                $("#jobperformed_status_" + count).val(null).trigger('change');
//                return FALSE;
//            } else {
//                $.ajax({
//                    url: "<?php echo base_url('Cjob/change_jobperformed'); ?>",
//                    type: 'POST',
//                    data: {job_id: job_id, performed_status: id, job_type: job_type, jobtype_rate: jobtype_rate, mechanics_id: mechanics_id, startdatetime: startdatetime, enddatetime: enddatetime, mechanics_note: mechanics_note, jobdetails_rowid: jobdetails_rowid},
//                    success: function (r) {
//                        location.reload(true);
//                    }
//                });
//            }
//        }
////        else if (id == 2) {
////            if (mechanics_note == '') {
////                alert("Mechanic notes must be required");
////                $("#jobperformed_status_" + count).val(null).trigger('change');
////                $("#mechanics_note_" + count).focus();
////            }
////        }
////        else {
////            $.ajax({
////                url: "<?php echo base_url('Cjob/change_jobperformed'); ?>",
////                type: 'POST',
////                data: {job_id: job_id, performed_status: id, job_type: job_type, jobtype_rate: jobtype_rate, mechanics_id: mechanics_id, startdatetime: startdatetime, enddatetime: enddatetime, mechanics_note: mechanics_note, jobdetails_rowid: jobdetails_rowid},
////                success: function (r) {
//////                    console.log(r);
//////                    location.reload($('.nav-tabs li:eq(1) a').tab('show'));
////                    location.reload(true);
////                }
////            });
////        }
//    }
////    =========== its for addrecomendation =========
//    function addrecomendation() {
//        var set_default_terms = $("#set_default_terms").val();
//        var job_id = "<?php echo $get_workorder[0]->job_id ?>"
//        $.ajax({
//            url: "<?php echo base_url('Cjob/addrecomendation'); ?>",
//            type: 'POST',
//            data: {job_id: job_id, set_default_terms: set_default_terms},
//            success: function (r) {
////                console.log(r);
//                window.location.reload(true);
//            }
//        });
//    }
//    ============ its for extra job field add when job confirmation mode admin and mechanic login ===========
//    function extra_jobfield_add() {
////        var odometer = $("#odometer").val();
////        var hubo_meter = $("#hubo_meter").val();
////        var hour_meter = $("#hour_meter").val();
////        var cof_wof_date = $("#cof_wof_date").val();
////        var registration_date = $("#registration_date").val();
////        var fuel_burn = $("#fuel_burn").val();
//        var order_status = $("#order_status").val();
//        var schedule_datetime = $("#schedule_datetime").val();
//        var delivery_datetime = $("#delivery_datetime").val();
//        if ($('#sms').is(':checked')) {
//            var alert_via = $("#sms").val();
//        } else if ($('#email').is(':checked')) {
//            var alert_via = $("#email").val();
//        } else if ($('#post').is(':checked')) {
//            var alert_via = $("#post").val();
//        } else if ($('#never').is(':checked')) {
//            var alert_via = $("#never").val();
//        }
//        if ($('#show_hide_status').is(':checked')) {
//            var show_hide_status = '1';
//        } else {
//            var show_hide_status = '0';
//        }
////        alert(show_hide_status);exit();
//        var job_id = '<?php echo $get_workorder[0]->job_id ?>';
//        var output = $("#output");
//        $.ajax({
//            url: "<?php echo base_url('Cjob/workorder_update'); ?>",
//            type: "POST",
////            data: {job_id: job_id, odometer: odometer, hubo_meter: hubo_meter, hour_meter: hour_meter, cof_wof_date: cof_wof_date, registration_date: registration_date, fuel_burn: fuel_burn, order_status: order_status, show_hide_status: show_hide_status, alert_via: alert_via, schedule_datetime: schedule_datetime, delivery_datetime: delivery_datetime},
//            data: {job_id: job_id, order_status: order_status, show_hide_status: show_hide_status, alert_via: alert_via, schedule_datetime: schedule_datetime, delivery_datetime: delivery_datetime},
//            success: function (r) {
//                r = JSON.parse(r);
////                $("#odometer").val(r.odometer);
////                $("#hubo_meter").val(r.hubo_meter);
////                $("#hour_meter").val(r.hour_meter);
////                $("#cof_wof_date").val(r.cof_wof_date);
////                $("#registration_date").val(r.registration_date);
////                $("#fuel_burn").val(r.fuel_burn);
//                output.empty().html('Successfully Updated').addClass('alert-success').removeClass('alert-danger').removeClass('hide');
//
//            },
//            error: function (xhr, desc, err) {
//                alert('failed');
//            }
//        });
//    }


//    ============ its for enddatetime_check =================
    function enddatetime_check(t, sl) {
        var startdatetime = $("#startdatetime_" + sl).val();
        var enddatetime = $("#enddatetime_" + sl).val();
//        alert(startdatetime);
        if (!startdatetime) {
            alert("Please start datetime input firstly!");
            $("#enddatetime_" + sl).val('');
            $("#startdatetime_" + sl).focus();
        }
        if (startdatetime == ' ') {
            alert("Please start datetime input correctly!");
            $("#enddatetime_" + sl).val('').focus();
            $("#spent_time_" + sl).val();
            return false;
        }

        if (enddatetime < startdatetime) {
//            alert("End datetime  is not greater than Start datetime!");
            $("#enddatetime_" + sl).css({'border': '2px solid red'});
//            $(".alert_show").css({'display' : 'block'});
            $("#enddatetime_" + sl).val('').focus();
            return false;
        } else {
            $("#enddatetime_" + sl).css({'border': '2px solid green'});
        }
        $.ajax({
            url: "<?php echo base_url('Cjob/find_spent_time'); ?>",
            type: "POST",
            data: {startdatetime: startdatetime, enddatetime: enddatetime},
            success: function (r) {
//                alert(r);
//                r = JSON.parse(r);
                $("#spent_time_" + sl).val(r);
//                $("#hubo_meter").val(r.hubo_meter);
//                $("#hour_meter").val(r.hour_meter);
//                $("#cof_wof_date").val(r.cof_wof_date);
//                $("#registration_date").val(r.registration_date);
//                $("#fuel_burn").val(r.fuel_burn);
//                output.empty().html('Successfully Updated').addClass('alert-success').removeClass('alert-danger').removeClass('hide');

            },
            error: function (xhr, desc, err) {
                alert('failed');
            }
        });
    }
    function check_declined(t) {
        if ($('#declined_' + t).is(':checked')) {
            $("#declined_" + t).attr("value", "2");
            $("#checked_hdn_" + t).attr("value", "2");
        } else {
            $("#declined_" + t).attr("value", '0');
            $("#checked_hdn_" + t).attr("value", "0");
        }
    }
//    ========== its for assign_checklist ============
    function assign_checklist(inspection_id, job_id) {
        $.ajax({
            url: "<?php echo base_url('Cinspection/get_checklist_design'); ?>",
            type: "POST",
            data: {inspection_id: inspection_id, job_id: job_id},
            success: function (r) {
                $("#modal_info").html(r);
                $('#modal_show_info').modal('show');
            }
        });
    }
//    =============== its for view_checklist only show -===============
    function view_checklist(inspection_id, job_id) {
        $.ajax({
            url: "<?php echo base_url('Cinspection/get_view_checklist'); ?>",
            type: "POST",
            data: {inspection_id: inspection_id, job_id: job_id},
            success: function (r) {
                $("#modal_info").html(r);
                $('#modal_show_info').modal('show');
            }
        });
    }
</script>




