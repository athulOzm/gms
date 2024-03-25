
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('jobs') ?></h1>
            <small><?php echo display('manage_job_type') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('jobs') ?></a></li>
                <li class="active"><?php echo display('manage_job_type') ?></li>
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
                    <?php if ($this->permission1->check_label('add_job_type')->create()->access()) { ?>
                        <a href="<?php echo base_url('Cjob/add_job_type') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('add_job_type') ?> </a>
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
                            <h4><?php echo display('manage_job_type') ?> </h4>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Job Type Name</th>
                                            <th>Job Category</th>
                                            <th>Rate</th>
                                            <th>Time</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sl = 0 + $pagenum;
                                        foreach ($job_typelist as $type) {
                                            $sl++;
                                            ?>
                                            <tr>
                                                <td><?php echo $sl; ?></td>
                                                <td><?php echo $type->job_type_name; ?></td>
                                                <td><?php echo $type->job_category_name; ?></td>
                                                <td><?php echo $type->job_type_rate; ?></td>
                                                <td><?php echo $type->standard_timing; ?></td>
                                                <td class="text-center">
                                                    <?php if ($this->permission1->check_label('manage_job_type')->update()->access()) { ?>
                                                        <a href="<?php echo base_url('Cjob/job_type_edit/' . $type->job_type_id); ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>    
                                                        <?php
                                                    }
                                                    if ($this->permission1->check_label('manage_job_type')->delete()->access()) {
                                                        ?>
                                                        <a href="<?php echo base_url('Cjob/job_type_delete/' . $type->job_type_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete it?')"><i class="fa fa-close"></i></a>
                                                        <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php echo $links; ?>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
    </section>
</div>
<!-- Add new category end -->
