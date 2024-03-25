<link href="<?php echo base_url('assets/custom/job.css') ?>" rel="stylesheet" type="text/css"/>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('jobs') ?></h1>
            <small><?php echo display('job_type_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('jobs') ?></a></li>
                <li class="active"><?php echo display('job_type_edit') ?></li>
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
                    <?php if ($this->permission1->check_label('manage_job_type')->read()->access()) { ?>
                        <a href="<?php echo base_url('Cjob/manage_job_type') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_job_type') ?> </a>
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
                            <h4><?php echo display('job_type_edit') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Cjob/update_job_type', array('class' => 'form-vertical', 'id' => '')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="job_category_id" class="col-sm-3 col-form-label text-right"><?php echo display('job_category') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="job_category_id" id="job_category_id" required>
                                    <option value=""></option>
                                    <?php foreach ($job_category as $single) { ?>
                                        <option value='<?php echo $single->job_category_id; ?>' <?php
                                        if ($edit_job_type[0]->job_category_id == $single->job_category_id) {
                                            echo 'selected';
                                        }
                                        ?>>
                                                    <?php echo $single->job_category_name; ?>
                                        </option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="job_type_name" class="col-sm-3 col-form-label text-right"><?php echo display('job_type_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="job_type_name" id="job_type_name" type="text" placeholder="<?php echo display('job_type_name') ?>" value="<?php echo $edit_job_type[0]->job_type_name; ?>"  required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="job_type_rate" class="col-sm-3 col-form-label text-right"><?php echo display('job_type_rate') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="job_type_rate" id="job_type_rate" type="text" placeholder="<?php echo display('job_type_rate') ?>" value="<?php echo $edit_job_type[0]->job_type_rate; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="standard_timing" class="col-sm-3 col-form-label text-right"><?php echo display('standard_timing') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control standard_timing" id="standard_timing" name="standard_timing" value="<?php echo $edit_job_type[0]->standard_timing; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="hidden" name="job_type_id" value="<?php echo $edit_job_type[0]->job_type_id; ?>">
                                <input type="submit" id="add-category" class="btn btn-success btn-large" name="" value="<?php echo display('save') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>

        </div>
    </section>
</div>
<script src="<?php echo base_url('assets/custom/job.js') ?>"></script>



