<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('report') ?></h1>
            <small><?php echo display('productivity_report') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('report') ?></a></li>
                <li class="active"><?php echo display('productivity_report') ?></li>
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
                <!--                <div class="column">
                <?php if ($this->permission1->check_label('add_job_type')->create()->access()) { ?>
                                            <a href="<?php echo base_url('Cjob/add_job_type') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('add_job_type') ?> </a>
                <?php } ?>
                                </div>-->
            </div>
        </div>
        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('productivity_report') ?> </h4>
                            <a  class="btn btn-info" href="#" onclick="printDiv('printableArea')"><i class="fa fa-print"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="table-responsive" id="printableArea">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th><?php echo display('mechanic'); ?></th>
                                            <th class="text-center"><?php echo display('assigned_total'); ?></th>
                                            <th class="text-center"><?php echo display('pending'); ?></th>
                                            <th class="text-center"><?php echo display('inprogress'); ?></th>
                                            <th class="text-center"><?php echo display('declined'); ?></th>
                                            <th class="text-center"><?php echo display('completed'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // d($allmechanic);
                                        $sl = 0 + $pagenum;
                                        foreach ($allmechanic as $mechanic) {
                                            $jobdetails_sql = "SELECT (SELECT COUNT(job_id) FROM job_details WHERE status = 0 AND assign_to = '$mechanic->user_id') as pending,
                                                                        (SELECT COUNT(job_id) FROM job_details WHERE status = 1 AND assign_to = '$mechanic->user_id') as in_progress,  
                                                                        (SELECT COUNT(job_id) FROM job_details WHERE status = 2 AND assign_to = '$mechanic->user_id') as declined,
                                                                        (SELECT COUNT(job_id) FROM job_details WHERE status = 3 AND assign_to = '$mechanic->user_id') as completed,
                                                                        (SELECT COUNT(job_id) FROM job_details WHERE assign_to = '$mechanic->user_id') as total_job";
                                            $jobdetails_results = $this->db->query($jobdetails_sql)->row();
                                            //d($jobdetails_results);
                                            $sl++;
                                            ?>
                                            <tr>
                                                <td><?php echo $sl; ?></td>
                                                <td><?php echo $mechanic->first_name . " " . $mechanic->last_name; ?></td>
                                                <td class="text-center"><?php echo $jobdetails_results->total_job; ?></td>
                                                <td class="text-center"><?php echo $jobdetails_results->pending; ?></td>
                                                <td class="text-center"><?php echo $jobdetails_results->in_progress; ?></td>
                                                <td class="text-center"><?php echo $jobdetails_results->declined; ?></td>
                                                <td class="text-center"><?php echo $jobdetails_results->completed; ?></td>
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