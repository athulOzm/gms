<link href="<?php echo base_url('assets/custom/job.css') ?>" rel="stylesheet" type="text/css"/>
<?php
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
            <small><?php echo display('add_job_order') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('jobs') ?></a></li>
                <li class="active"><?php echo display('add_job_order') ?></li>
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
                <div class="column float_right">
                    <?php if ($this->permission1->check_label('manage_job')->read()->access()) { ?>
                        <a href="<?php echo base_url('Cjob/manage_job') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_job') ?> </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_job_order') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Cjob/insert_job', array('class' => 'form-vertical', 'id' => 'insert_category')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="customer_id" class="col-sm-4 col-form-label"><?php echo display('customer') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <?php
//                                    d($customers);
                                    if ($user_type == 3) {
                                        ?>
                                        <select name="customer_id" class="form-control" required>
                                            <option value="">Select One</option>
                                            <?php
                                            foreach ($customers as $customer) {
                                                if ($user_id == $customer['customer_id']) {
                                                    ?>
                                                    <option value="<?php echo $customer['customer_id'] ?>" selected=""><?php echo $customer['customer_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    <?php } else { ?>
                                        <select name="customer_id" class="form-control select2" onchange="get_customer_info(this.value)" required data-placeholder="-- select one --">
                                            <option value="">Select One </option>
                                            <?php
                                            foreach ($customers as $customer) {
                                                ?>
                                                <option value="<?php echo $customer['customer_id'] ?>" <?php
                                                if ($user_id == $customer['customer_id']) {
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
                            <?php
                            $customer_id = $customer_address = $customer_phone = $customer_mobile = $website = $work_order = '';
                            if ($user_type == 3) {
                                $customer_id = $customers[0]['customer_id'];
                                $customer_address = $customers[0]['customer_address'];
                                $customer_phone = $customers[0]['customer_phone'];
                                $customer_mobile = $customers[0]['customer_mobile'];
                                $website = $customers[0]['website'];
                                $work_order = $customers[0]['id'] . "-" . time();
                            }
                            ?>
                            <div class="col-sm-6">
                                <label for="order_no" class="col-sm-4 col-form-label"><?php
                                    if ($user_type != 3) {
                                        echo display('work_order_no');
                                    } else {
                                        echo display('job_order_no');
                                    }
                                    ?> </label>
                                <div class="col-sm-8">
                                    <input type="text" name="work_order_no" id="order_no" class="form-control" value="<?php echo $work_order; ?>" readonly placeholder="<?php echo display('enter_customer_order_no') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="address" class="col-sm-4 col-form-label"><?php echo display('address') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="address" class="form-control" id="address" value="<?php echo $customer_address; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                $customer_wise_vehicle_info = $this->Jobs_model->customer_wise_vehicle_info($customer_id);
                                ?>
                                <label for="registration_no" class="col-sm-4 col-form-label"><?php echo display('vehicle_reg_no') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="registration_no" id="registration_no" class="form-control select2" required data-placeholder="-- select one --">
                                        <option value="">Select Registration</option>
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
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="phone" class="col-sm-4 col-form-label"><?php echo display('phone') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="phone" class="form-control" value="<?php echo $customer_phone; ?>"  id="phone" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="reference" class="col-sm-4 col-form-label"><?php echo display('reference') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="tex" name="reference" id="reference" class="form-control " placeholder="<?php echo display('reference') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="mobile" class="col-sm-4 col-form-label"><?php echo display('mobile') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="mobile" class="form-control" value="<?php echo $customer_mobile; ?>"  id="mobile" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="schedule_datetime" class="col-sm-4 col-form-label"><?php echo display('schedule_datetime') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type="tex" name="schedule_datetime" id="schedule_datetime" class="form-control basic_example_3" placeholder="<?php echo display('schedule_datetime') ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="website" class="col-sm-4 col-form-label"><?php echo display('website') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="website" class="form-control" value="<?php echo $customers[0]['website']; ?>"  id="website" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="delivery_datetime" class="col-sm-4 col-form-label"><?php echo display('delivery_datetime') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type="tex" name="delivery_datetime" id="delivery_datetime" class="form-control basic_example_3" onchange="checkdelivery_datetime()" placeholder="<?php echo display('delivery_datetime') ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="details" class="col-sm-4 col-form-label"><?php echo display('details') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <textarea  name="details" class="form-control" id="details"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="vehicle" class="col-sm-4 col-form-label"><?php echo display('alert_via') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="radio" id="sms" name="alert_via" value="sms">
                                    <label for="sms">SMS</label>
                                    <input type="radio" id="email" name="alert_via" value="email">
                                    <label for="email">Email</label>
                                    <input type="radio" id="post" name="alert_via" value="post">
                                    <label for="post">Post</label>
                                    <input type="radio" id="never" name="alert_via" value="never" checked>
                                    <label for="never">Never</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="job_type_table">
                                        <thead>
                                            <tr>
                                                <th width="30%"><?php echo display('job_type'); ?></th>
                                                <th width="30%"><?php echo display('mechanics'); ?></th>
                                                <!--     <?php if ($user_type == 1 || $user_type == 2) { ?>
                                                                                                                                                        <th><?php echo display('starting_datetime'); ?></th>   
                                                                                                                                                        <th><?php echo display('ending_datetime'); ?></th>   
                                                <?php } ?> -->
                                                <th width="30%"><?php echo display('customer_notes'); ?></th>   
                                                <th width="10%"><button type="button" class="btn btn-success" onClick="addLabour();"><i class="fa fa-plus"></i></button></th>      
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="job_type_id[]" id="job_type_id" onchange="jobtype_wise_info(this.value, 1);" class="form-control select2" data-placeholder="-- select one --" required>
                                                        <option value=""></option>
                                                        <?php foreach ($get_jobtypelist as $jobtype) { ?>
                                                            <option value='<?php echo $jobtype->job_type_id; ?>'>
                                                                <?php echo $jobtype->job_type_name; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <input type="hidden" name="jobtype_rate[]" id="jobtype_rate_1">       
                                                </td>
                                                <td>
                                                    <select name="mechanics_id[]" id="mechanics_id" class="form-control select2" data-placeholder="-- select one --">
                                                        <option value=""></option>
                                                        <?php foreach ($get_employeelist as $mechanic) { ?>
                                                            <option value='<?php echo $mechanic->user_id; ?>' <?php
                                                            if ($mechanic->user_id == $user_id) {
                                                                echo 'selected';
                                                            }
                                                            ?>>
                                                                        <?php echo $mechanic->full_name; ?>
                                                            </option>
                                                        <?php } ?> 
                                                    </select>   
                                                </td>
                                                <!--   <?php if ($user_type == 1 || $user_type == 2) { ?>
                                                                                                                                                      <td>
                                                                                                                                                          <input type="text" name="startdatetime" class="form-control datetime">    
                                                                                                                                                      </td>
                                                                                                                                                      <td> <input type="text" name="enddatetime" class="form-control datetime" id=""> </td>
                                                <?php } ?> -->
                                                <td><input type="text" name="customer_note[]" class="form-control "></td>
                                                <td></td>

                                            </tr>
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row m-t-20">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save') ?>" tabindex="7"/>
                                <!--<input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-customer-another" class="btn btn-large btn-success" id="add-customer-another" tabindex="6">-->
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>

        </div>
    </section>
</div>
<!--============= this script must be required here ==============-->
<script type="text/javascript">
    "use strict";
    function addLabour() {
        var row = $("#job_type_table tbody tr").length;
        var count = row + 1;
        var limits = 500;
        var xTable = document.getElementById('job_type_table');
        var tr = document.createElement('tr');
        tr.innerHTML = '<td><select name="job_type_id[]" onchange="jobtype_wise_info(this.value,' + count + ')" id="job_type_id" class="form-control select2" data-placeholder="-- select one --"><option value="">-- select one -- </option> <?php foreach ($get_jobtypelist as $jobtype) { ?><option value="<?php echo $jobtype->job_type_id; ?>"><?php echo $jobtype->job_type_name; ?></option> <?php } ?></select>\n\
                                     <input type="hidden" name="jobtype_rate[]" id="jobtype_rate_' + count + '"> </td>\n\
                                  <td><select name="mechanics_id[]" id="mechanics_id" class="form-control select2" data-placeholder="-- select one --"><option value="">-- select one -- </option><?php foreach ($get_employeelist as $mechanic) { ?><option value="<?php echo $mechanic->user_id; ?>" <?php
                        if ($mechanic->user_id == $user_id) {
                            echo 'selected';
                        }
                        ?>><?php echo $mechanic->full_name; ?></option> <?php } ?></select></td>\n\
                                  <td><input type="text" name="customer_note[]" class="form-control "></td>\n\
                                    <td><button  class="btn btn-danger removelabour text-right" type="button"  onclick="deleteRow(this)" tabindex="8"><i class="fa fa-close"></i></button></td>';
        xTable.children[1].appendChild(tr); // appends to the tbody element
//        $(".datetime").datetimepicker({
//            format: 'yyyy-mm-dd hh:ii',
//            autoclose: true,
//            todayBtn: true
//        });
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
    "use strict";
    function get_customer_info(t) {
        var current_time = "<?php echo time(); ?>"
        $.ajax({
            url: "<?php echo base_url('Cjob/get_customer_info'); ?>",
            type: 'POST',
            data: {customer_id: t},
            success: function (r) {
//                console.log(r);
                r = JSON.parse(r);
//                alert(r.customer_id);
                $("#order_no").val(r.id + "-" + current_time);
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
//                $("#registration_no").html("<option value=''>-- select one -- </option>");

                $.each(r, function (ar, typeval) {
                    $('#registration_no').append($('<option>').text(typeval.vehicle_registration).attr('value', typeval.vehicle_id));
                });
            }
        });
    }
//    ============ its for jobtype_wise_info =============
    "use strict";
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
//    ========== its for checkdelivery_datetime =========
    "use strict";
    function checkdelivery_datetime() {
        var starttime = $("#schedule_datetime").val();
        var endtime = $("#delivery_datetime").val();
        if (!starttime) {
            alert("Please schedule date time input firstly!");
            $("#delivery_datetime").val('');
            $("#schedule_datetime").focus();
        }
        if (endtime < starttime) {
            alert("Delivery datetime must be greater than schedule datetime!");
            $("#delivery_datetime").val('');
        }
    }
</script>
<script src="<?php echo base_url('assets/custom/job.js') ?>"></script>




