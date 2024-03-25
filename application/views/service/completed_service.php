<!-- Manage service Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('service') ?></h1>
            <small><?php echo display('completed_service') ?></small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('service') ?></a></li>
                <li class="active"><?php echo display('completed_service') ?></li>
            </ol>
        </div>
    </section>
    <?php
    $date_format = $this->session->userdata('date_format');
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
                            <?php echo display('completed_service'); ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo display('sl'); ?></th>
                                    <th><?php echo display('customer'); ?></th>
                                    <th><?php echo display('service'); ?></th>
                                    <th><?php echo display('vehicles'); ?></th>
                                    <th><?php echo display('next_occurrence'); ?></th>
                                    <th><?php echo display('reminder'); ?></th>
                                    <th><?php echo display('repeat'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($completed_service) {
                                    $sl = 0;
                                    foreach ($completed_service as $service) {
                                        $sl++;
                                        ?>
                                        <tr>
                                            <td><?php echo $sl; ?></td>
                                            <td><?php echo $service->customer_name; ?></td>
                                            <td><?php echo $service->job_type_name; ?></td>
                                            <td><?php echo $service->vehicle_registration; ?></td>
                                            <td>
                                                <?php
                                                if ($date_format == 1) {
                                                    echo date('d-m-Y', strtotime($service->occurrence_date));
                                                } elseif ($date_format == 2) {
                                                    echo date('m-d-Y', strtotime($service->occurrence_date));
                                                } elseif ($date_format == 3) {
                                                    echo date('Y-m-d', strtotime($service->occurrence_date));
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo @$service->reminder_count . " " . @$service->reminder_period; ?></td>
                                            <td><?php echo @$service->repeat_count . " " . @$service->repeat_period; ?></td>

                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <?php if (empty($completed_service)) { ?>
                                <tfoot>
                                    <tr>
                                        <th colspan="8" class="text-center text-danger"><?php echo display('data_not_found'); ?></th>
                                    </tr>
                                </tfoot>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Manage service End -->