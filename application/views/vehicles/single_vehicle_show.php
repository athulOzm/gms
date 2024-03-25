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
                <div class="column m-b-5 float_right">
                    <?php if ($this->permission1->check_label('manage_vehicle')->read()->access()) { ?>
                        <a href="<?php echo base_url('Cvehicles/manage_vehicle') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_vehicles') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->check_label('manage_vehicle')->read()->access()) { ?>
                        <a href="<?php echo base_url('Cvehicles/vehicle_wise_job/'.$single_vehicle_show[0]->vehicle_id) ?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('own_vehicle_job') ?> </a>
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
                        <?php // d($single_vehicle_show); ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo display('customer_name'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->customer_name; ?></td>
                                    <th><?php echo display('vehicle_registration'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->vehicle_registration; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('year'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->year; ?></td>
                                    <th><?php echo display('seats'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->seat; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('make'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->make; ?></td>
                                    <th><?php echo display('cc_rating'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->cc_rating; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('model'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->model; ?></td>
                                    <th><?php echo display('fuel_type'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->fuel_type; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('color'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->color; ?></td>
                                    <th><?php echo display('assembly_type'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->assembly_type; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('second_color'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->second_color; ?></td>
                                    <th><?php echo display('country_of_origin'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->country_of_origin; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('sub_model'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->sub_model; ?></td>
                                    <th><?php echo display('gross_vehicle_mass'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->gross_vehicle_mass; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('body_style'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->body_style; ?></td>
                                    <th><?php echo display('tare_weight'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->tyre_weight; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('vin'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->vin; ?></td>
                                    <th><?php echo display('axle'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->axle; ?></td>
                                </tr>
                                <tr>
<!--                                    <th><?php echo display('plate'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->plate; ?></td>-->
                                    <th><?php echo display('wheelbase'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->wheelbase; ?></td>
                                     <th><?php echo display('engine_no'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->engine_no; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display('front_axle_group_rating'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->front_axle_rating; ?></td>
                                      <th><?php echo display('vehicle_type'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->vehicle_type; ?></td>
                                </tr>
                                <tr>                                  
                                    <th><?php echo display('rear_axle_group_rating'); ?></th>
                                    <th>:</th>
                                    <td><?php echo $single_vehicle_show[0]->rear_axle_rating; ?></td>
                                  <th></th>
                                    <th></th>
                                    <td></td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>





