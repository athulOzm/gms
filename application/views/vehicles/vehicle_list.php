
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('vehicles') ?></h1>
            <small><?php echo display('manage_vehicles') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('vehicles') ?></a></li>
                <li class="active"><?php echo display('manage_vehicles') ?></li>
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
                <div class="column text-right">
                    <?php
//                    var_dump($this->permission1->check_label('add_vehicle')->create()->access());
                    if ($this->permission1->check_label('add_vehicle')->create()->access()) {
                        ?>
                        <a href="<?php echo base_url('Cvehicles/add_vehicles') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('Add_new_vehicles') ?> </a>
                    <?php } ?>

                </div>
            </div>
        </div>
        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="form-group row">
                    <!--                                    <div class="col-sm-1 dropdown">
                                                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"> </i> Action
                                                                <span class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="javascript:void(0)" onClick="ExportMethod('<?php echo base_url(); ?>menu-export-csv')" class="dropdown-item">Export to CSV</a></li>
                                                                <li><a href="javascript:void(0)"  data-toggle="modal" data-target="#importMenu" class="dropdown-item">Import from CSV</a></li>
                                                            </ul>
                                                        </div>-->
                    <label for="keyword" class="col-sm-offset-8 col-sm-2 col-form-label text-right"></label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="keyword" id="keyword" onkeyup="vehiclekeyup_search()" placeholder="Search..." tabindex="">
                    </div>
                </div>          
            </div>
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('manage_vehicles') ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div id="results">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('sl'); ?></th>
                                            <th><?php echo display('customer_name'); ?></th>
                                            <th><?php echo display('vehicle_registration'); ?></th>
                                            <th><?php echo display('year'); ?></th>
                                            <th><?php echo display('make'); ?></th>
                                            <th><?php echo display('model'); ?></th>
                                            <th><?php echo display('cc_rating'); ?></th>
                                            <th class="text-center"><?php echo display('action'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                    dd($vehicle_list);
                                        if (!empty($vehicle_list)) {
                                            $sl = 0;
                                            foreach ($vehicle_list as $vehicle) {
                                                $sl++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $sl; ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url('Ccustomer/customerledger/' . $vehicle->customer_id); ?>">
                                                            <?php echo $vehicle->customer_name; ?>
                                                        </a>
                                                    </td>
                                                    <td><?php echo $vehicle->vehicle_registration; ?></td>
                                                    <td><?php echo $vehicle->year; ?></td>
                                                    <td><?php echo $vehicle->make; ?></td>
                                                    <td><?php echo $vehicle->model; ?></td>
                                                    <td><?php echo $vehicle->cc_rating; ?></td>
                                                    <td class="text-center">
                                                        <?php if ($this->permission1->check_label('manage_vehicle')->update()->access()) { ?>
                                                            <a href="<?php echo base_url('Cvehicles/edit_vehicle_form/' . $vehicle->vehicle_id); ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                                            <?php
                                                        }
                                                        if ($this->permission1->check_label('manage_vehicle')->delete()->access()) {
                                                            ?>
                                                            <a href="<?php echo base_url('Cvehicles/vehicle_delete/' . $vehicle->vehicle_id); ?>" onclick="return confirm('Do you want to delete it?')" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <?php if (empty($vehicle_list)) { ?>
                                        <tfoot>
                                            <tr>
                                                <th colspan="8" class="text-danger text-center">Record not found!</th>
                                            </tr>
                                        </tfoot>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="vehiclesearch" value="<?php echo base_url('Cvehicles/vehicle_search'); ?>">
</div>

<script src="<?php echo base_url('assets/custom/vehicle.js') ?>"></script>