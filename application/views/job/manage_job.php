<link href="<?php echo base_url('assets/custom/job.css') ?>" rel="stylesheet" type="text/css"/>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('jobs') ?></h1>
            <small><?php echo display('manage_job') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('jobs') ?></a></li>
                <li class="active"><?php echo display('manage_job') ?></li>
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
                    <?php if ($this->permission1->check_label('add_job_order')->create()->access()) { ?>
                        <a href="<?php echo base_url('Cjob') ?>" class="btn btn-info m-b-5 m-r-2"><i class=""> </i> <?php echo display('add_job_order') ?> </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- New category -->
        <div class="row">
            <!--                 <div class="col-sm-12 text-right">
                            <div class="form-group row">
                                                                    <div class="col-sm-1 dropdown">
                                                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"> </i> Action
                                                                            <span class="caret"></span></button>
                                                                        <ul class="dropdown-menu">
                                                                            <li><a href="javascript:void(0)" onClick="ExportMethod('<?php echo base_url(); ?>menu-export-csv')" class="dropdown-item">Export to CSV</a></li>
                                                                            <li><a href="javascript:void(0)"  data-toggle="modal" data-target="#importMenu" class="dropdown-item">Import from CSV</a></li>
                                                                        </ul>
                                                                    </div>
                                <label for="keyword" class="col-sm-offset-8 col-sm-2 col-form-label text-right"></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="keyword" id="keyword" onkeyup="jobkeyup_search()" placeholder="Search..." tabindex="">
                                </div>
                            </div>          
                        </div>-->
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('manage_job') ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive"  id="results">
                            <table id="dataTableExample31" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('sl') ?></th>
                                        <th class=""><?php echo display('customer_name') ?></th>
                                        <th class=""><?php echo display('registration_no') ?></th>
                                        <th class=""><?php echo display('schedule_datetime') ?></th>
                                        <th class=""><?php echo display('delivery_datetime') ?></th>
                                        <th class=""><?php echo display('order_status') ?></th>
                                        <th class=""><?php echo display('mechanic_status') ?></th>
                                        <th class="text-center"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//                                    d($job_list);
                                    if ($job_list) {
                                        $sl = 1+$pagenum;
                                        foreach ($job_list as $job) {
                                            $mechanic_status_sql = "SELECT 
                                             (SELECT COUNT(job_id) FROM job_details WHERE status = 0 AND job_id = $job->job_id) as pending,
                                             (SELECT COUNT(job_id) FROM job_details WHERE status = 1 AND job_id = $job->job_id) as in_progress,  
                                             (SELECT COUNT(job_id) FROM job_details WHERE status = 2 AND job_id = $job->job_id) as declined,
                                             (SELECT COUNT(job_id) FROM job_details WHERE status = 3 AND job_id = $job->job_id) as completed";
                                            $mechanic_status_result = $this->db->query($mechanic_status_sql)->row();
                                            //echo $job->job_id;  echo '<pre>';  print_r($mechanic_status_result);echo '</pre>';
                                            ?>
                                            <tr style="background: <?php
                                            if ($job->status == '3') {
                                                echo '#CFFCB6';
                                            } elseif ($job->status == '2') {
                                                echo '#F37068';
                                            }
                                            ?>">
                                                <td class="text-center"><?php echo $sl; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url('Ccustomer/customerledger/'.$job->customer_id); ?>">
                                                    <?php echo $job->customer_name; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url('Cvehicles/single_vehicle_show/' . $job->vehicle_id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $job->vehicle_registration; ?>">
                                                        <?php echo $job->vehicle_registration; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $job->schedule_date_time; ?></td>
                                                <td><?php echo $job->delivery_date_time; ?></td>
                                                <td>
                                                    <?php
                                                    if ($job->status == 0) {
                                                        echo 'Pending';
                                                    } elseif ($job->status == 1) {
                                                        echo 'Accept';
                                                    } elseif ($job->status == 2) {
                                                        echo 'Decline';
                                                    } elseif ($job->status == 3) {
                                                        echo 'Completed';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // if ($job->status == 1) {
                                                    if ($mechanic_status_result->pending > 0) {
                                                        echo $mechanic_status_result->pending . " " . display('pending') . " <br>";
                                                    }
                                                    if ($mechanic_status_result->in_progress > 0) {
                                                        echo $mechanic_status_result->in_progress . " " . display('in_progress') . " <br>";
                                                    }
                                                    if ($mechanic_status_result->declined > 0) {
                                                        echo $mechanic_status_result->declined . " " . display('decline') . " <br>";
                                                    }
                                                    if ($mechanic_status_result->completed > 0) {
                                                        echo $mechanic_status_result->completed . " " . display('complete') . " <br>";
                                                    }
                                                    //  }
                                                    ?>
                                                </td>
                                                <td>
                                        <center>
                                            <?php
                                            $user_type = $this->session->userdata('user_type');
                                            if ($user_type == 1 && $job->status == 3) {
                                                if ($job->is_invoice == 1) {
                                                    if ($this->permission1->check_label('manage_job')->read()->access()) {
                                                        ?>
                                                        <a href="<?php echo base_url('Cjob/show_job_invoice/' . $job->job_id); ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="<?php echo display('show_invoice'); ?>"><i class="fa fa-eye"> </i></a>
                                                        <?php
                                                    }
                                                }
                                                if ($job->is_invoice == 0) {
                                                    if ($this->permission1->check_label('manage_job')->read()->access()) {
                                                        ?>
                                                        <a href="<?php echo base_url('Cjob/job_generate_invoice/' . $job->job_id); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="left" title="<?php echo display('invoice_generate'); ?>"><i class="fa fa-shopping-cart"> </i></a>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                                <?php
                                            }
                                            if ($user_type != 3) {
                                                if ($this->permission1->check_label('manage_quotation')->read()->access()) {
                                                    if ($job->is_quotation == 1) {
                                                        ?>
                                                        <a href="<?php echo base_url() . 'Cquotation/quotation_details_data/' . $job->quotation_id; ?>" class="btn btn-warning btn-xs"   title="<?php echo 'Quotation Details' ?>" data-toggle="tooltip" data-placement="top"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        <?php
                                                    }
                                                }
                                                if ($this->permission1->check_label('manage_job')->update()->access()) {
                                                    ?>
                                                    <a href="<?php
                                                    if ($job->status == 3) {
                                                        echo "javascript:void(0)";
                                                    } else {
                                                        echo base_url() . 'Cjob/job_confirmation_form/' . $job->job_id;
                                                    }
                                                    ?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left" title="<?php
                                                       if ($job->status == 3) {
                                                           echo display('invoice_done');
                                                       } else {
                                                           echo display('job_confirmation');
                                                       }
                                                       ?>"><i class="fa fa-cogs" aria-hidden="true"></i></a>
                                                       <?php
                                                   }
                                                   if ($this->permission1->check_label('manage_job')->delete()->access()) {
                                                       ?>
                                                    <a href="<?php echo base_url('Cjob/job_delete/' . $job->job_id); ?>" class="btn btn-danger btn-xs" name="<?php echo $job->job_id; ?>" data-toggle="tooltip" data-placement="right" title="<?php echo display('delete') ?> " onclick="return confirm('<?php echo display('are_you_sure'); ?>')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                    <?php
                                                }
                                            }
                                            if ($user_type == 3) {
                                                if ($this->permission1->check_label('manage_job')->read()->access()) {
                                                    ?>
                                                    <a href="<?php echo base_url('Cjob/show_job/' . $job->job_id); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="<?php echo display('show_job_information'); ?>">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <?php
                                                }
                                                if ($this->permission1->check_label('manage_quotation')->read()->access()) {
                                                    if ($job->is_quotation == 1) {
                                                        ?>
                                                        <a href="<?php echo base_url() . 'Cquotation/quotation_details_data/' . $job->quotation_id; ?>" class="btn btn-warning btn-xs"   title="<?php echo 'Quotation Details' ?>" data-toggle="tooltip" data-placement="top"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>


                                        </center>
                                        </td>
                                        </tr>

                                        <?php
                                        $sl++;
                                    }
                                }
                                ?>
                                </tbody>
                                <?php if(empty($job_list)){ ?>
                                <tfoot>
                                    <tr>
                                        <th colspan="8" class="text-center text-danger"><?php echo display('data_not_found'); ?></th>
                                    </tr>
                                </tfoot>
                                <?php } ?>
                            </table>
                            <?php echo $links; ?>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="jobkeyupsearch" value="<?php echo base_url('Cjob/jobonkeyup_search'); ?>">
        </div>
    </section>
</div>
<script src="<?php echo base_url('assets/custom/job.js'); ?>"></script>
