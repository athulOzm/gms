<link href="<?php echo base_url('assets/custom/job.css') ?>" rel="stylesheet" type="text/css"/>
<?php
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
?>
<!-- Manage service Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('jobs') ?></h1>
            <small><?php echo display('follow_ups') ?></small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('jobs') ?></a></li>
                <li class="active"><?php echo display('follow_ups') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">

        <!-- Alert Message -->
        <?php
        $date_format = $this->session->userdata('date_format');
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
                <div class="m-b-10 float_right">
                    <?php if ($this->permission1->check_label('follow_ups')->create()->access()) { ?>
                        <a href="javascript:void(0)" class="btn btn-info default btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Add New" onclick="add_new_followup();"><i class="fa fa-plus"></i> Add New</a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <?php echo display('follow_ups'); ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('sl') ?></th>
                                        <th class="text-left"><?php echo display('job_order') ?></th>
                                        <th class="text-left"><?php echo display('customer_and_vehicle') ?></th>
                                        <th class="text-left"><?php echo display('date') ?></th>
                                        <th class="text-left"><?php echo display('note') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sl = 1;
                                    foreach ($followuplist as $followups) {
                                        ?>
                                        <tr>
                                            <td><?php echo $sl ?></td>
                                            <td><?php echo $followups->order_id ?></td>
                                            <td><?php echo $followups->customer_name ?>
                                                <br><small> <?php echo $followups->v_reg ?></small>
                                            </td>
                                            <td>
                                                <?php
                                                if ($date_format == 1) {
                                                    echo date('d-m-Y', strtotime($followups->date));
                                                } elseif ($date_format == 2) {
                                                    echo date('m-d-Y', strtotime($followups->date));
                                                } elseif ($date_format == 3) {
                                                    echo date('Y-m-d', strtotime($followups->date));
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $followups->note ?></td>
                                        </tr>
                                        <?php
                                        $sl++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="modal fade" id="follow_up_modal" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add New Follow Up</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body" id="follow_up_info">
                                        <?php echo form_open('Cjob/insert_followup', array('class' => 'form-vertical', 'id' => 'insert_followup')) ?>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="job_order" class="col-sm-4 col-form-label"><?php echo display('job_order') ?> <i class="text-danger"></i></label>
                                                <div class="col-sm-8">
                                                    <?php
                                                    $ownjob_list = $this->Jobs_model->customer_wise_job_info($user_id);
                                                    ?>
                                                    <select name="job_order" class="form-control" onchange="get_joborder_info(this.value)">
                                                        <option value="">Select Order</option>
                                                        <?php
                                                        if ($user_type != 3) {
                                                            foreach ($get_jobtypelist as $jobtyps) {
                                                                ?>
                                                                <option value="<?php echo $jobtyps->work_order_no ?>"><?php echo $jobtyps->work_order_no ?></option>
                                                                <?php
                                                            }
                                                        } else {
                                                            foreach ($ownjob_list as $ownjob) {
                                                                ?>
                                                                <option value="<?php echo $ownjob->work_order_no ?>"><?php echo $ownjob->work_order_no ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="customer_info"></span>
                                                    <input type="hidden" name="v_regno" id="vreg">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="date" class="col-sm-4 col-form-label"><?php echo display('date') ?> </label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="fdate" class="form-control datepicker" id="fdate" value="<?php echo date('Y-m-d') ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="to_whom" class="col-sm-4 col-form-label"><?php echo display('to_whom') ?> </label>
                                                <div class="col-sm-8">
                                                    <select name="to_whom" class="form-control">
                                                        <!--<option value="">Select Order</option>-->
                                                        <?php if ($user_type != 2) { ?>
                                                            <option value="1"> Customer </option>
                                                            <?php
                                                        }
                                                        if ($user_type != 3) {
                                                            ?>
                                                            <option value="2"> Mechanic </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="note" class="col-sm-4 col-form-label"><?php echo display('note') ?> </label>
                                                <div class="col-sm-8">
                                                    <textarea name="note" class="form-control" placeholder="<?php echo display('note') ?>"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <div class="form-group row ">
                                            <div class="col-sm-10"></div>
                                            <div class="col-sm-2">
                                                <input type="submit" name="" value="Add" class="form-control btn btn-success">
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
        </div>       
    </section>
</div>
<!-- Manage service End -->

<script type="text/javascript">
    function add_new_followup() {
        $('#follow_up_modal').modal('show');
    }
</script>
<script type="text/javascript">
    function get_joborder_info(t) {
        $.ajax({
            url: "<?php echo base_url('Cjob/joborder_info'); ?>",
            type: 'POST',
            data: {job_order: t},
            success: function (r) {
//                console.log(r);
                r = JSON.parse(r);
                document.getElementById("customer_info").innerHTML = "Customer Name - " + r.customer_name + ", Vehicle Reg No: " + r.vehicle_regno;
                $("#vreg").val(r.vehicle_regno);
            }
        });
    }
</script>