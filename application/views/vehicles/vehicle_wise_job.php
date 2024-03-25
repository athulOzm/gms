<?php
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('vehicles') ?></h1>
            <small><?php echo display('vehicle_information') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('vehicles') ?></a></li>
                <li class="active"><?php echo display('vehicle_information') ?></li>
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
                <div class="column">
                    <?php if ($this->permission1->check_label('manage_vehicle')->read()->access()) { ?>
                        <a href="<?php echo base_url('Cvehicles/single_vehicle_show/' . $single_vehicle_show[0]->vehicle_id) ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('vehicle_information') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->check_label('manage_vehicle')->read()->access()) { ?>
                        <a href="<?php echo base_url('Cvehicles/vehicle_wise_job/' . $single_vehicle_show[0]->vehicle_id) ?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('own_vehicle_job') ?> </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('vehicle_information') ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php // d($vehicle_wise_job); ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center"><?php echo display('sl') ?></th>
                                    <th class=""><?php echo display('customer_name') ?></th>
                                    <th class=""><?php echo display('registration_no') ?></th>
                                    <th class=""><?php echo display('schedule_datetime') ?></th>
                                    <th class=""><?php echo display('delivery_datetime') ?></th>
                                    <th class=""><?php echo display('order_status') ?></th>
                                </tr>                           
                            </thead>
                            <tbody>
                                <?php
                                $sl = 0;
                                foreach ($vehicle_wise_job as $single) {
                                    $sl++;
                                    ?>
                                    <tr>
                                        <td><?php echo $sl; ?></td>
                                        <td><?php echo $single->customer_name; ?></td>
                                        <td><?php echo $single->vehicle_registration; ?></td>
                                        <td><?php echo $single->schedule_date_time; ?></td>
                                        <td><?php echo $single->delivery_date_time; ?></td>
                                        <td>
                                            <?php
                                            if ($single->status == 0) {
                                                echo 'Pending';
                                            } elseif ($single->status == 1) {
                                                echo 'Accept';
                                            } elseif ($single->status == 2) {
                                                echo 'Decline';
                                            } elseif ($single->status == 3) {
                                                echo 'Completed';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>





