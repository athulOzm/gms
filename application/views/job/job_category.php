
<!-- Manage service Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('job_category') ?></h1>
            <small><?php echo display('manage_your_service') ?></small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('job') ?></a></li>
                <li class="active"><?php echo display('job_category') ?></li>
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

        <!-- insert service category-->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('job_category') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Cjob/job_category_save', array('class' => 'form-vertical', 'id' => 'insert_customer')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="job_category" class="col-sm-3 col-form-label"><?php echo display('job_category') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="job_category" id="job_category" type="text" placeholder="<?php echo display('job_category') ?>"  required="" tabindex="2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-primary btn-large" name="" value="<?php echo display('save') ?>" tabindex="7"/>
                                <!--<input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-customer-another" class="btn btn-large btn-success" id="add-customer-another" tabindex="6">-->
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>

        <!--============= manage service category ==========-->

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <!--<a href="<?php echo base_url('Cservice/service_downloadpdf') ?>" class="btn btn-warning">Pdf</a>--> 
                            <h4><?php echo display('manage_job_category'); ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('sl') ?></th>
                                        <th class="text-center"><?php echo display('job_category') ?></th>
                                        <th class="text-center"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($job_categorylist) {
                                        $sl = 1+$pagenum;
                                        foreach ($job_categorylist as $job_category) {
                                            ?>

                                            <tr>
                                                <td class="text-center"><?php echo $sl; ?></td>
                                                <td class="text-center"><?php echo $job_category->job_category_name; ?></td>
                                                <td>
                                        <center>
                                            <?php echo form_open() ?>
                                            <?php if ($this->permission1->check_label('add_job_category')->update()->access()) { ?>
                                            <a href="javascript:void(0)" class="btn btn-info default btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Edit" onclick="show_job_category_edit(<?php echo $job_category->job_category_id; ?>);"><i class="fa fa-pencil"></i></a>
                                            <!--<a href="<?php echo base_url() . 'Cjob/job_category_edit_form/' . $job_category->job_category_id; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->
                                            <?php } ?>
                                            <?php if ($this->permission1->check_label('add_job_category')->delete()->access()) { ?>
                                            <a href="<?php echo base_url('Cjob/jobcategory_delete/'.$job_category->job_category_id); ?>" class="btn btn-danger btn-sm" name="<?php echo $job_category->job_category_id; ?>" onclick="return confirm('Do you want to delete it?')" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            <?php } ?>
                                            <?php echo form_close() ?>
                                        </center>
                                        </td>
                                        </tr>

                                        <?php
                                        $sl++;
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <?php echo $links; ?>
                        </div>

                        <div class="modal fade" id="category_modal_info" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Job Category Information</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body" id="category_info">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>       
    </section>
    <input type="hidden" id="jobcateditUrl" value="<?php echo base_url('Cjob/job_category_edit'); ?>">
</div>
<!-- Manage service End -->
<script src="<?php echo base_url('assets/custom/job.js') ?>"></script>