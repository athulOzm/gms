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
            <small><?php echo display('add_new_vehicles') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('vehicles') ?></a></li>
                <li class="active"><?php echo display('add_new_vehicles') ?></li>
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
                    <?php if ($this->permission1->check_label('manage_vehicle')->read()->access()) { ?>
                        <a href="<?php echo base_url('Cvehicles/manage_vehicle') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_vehicles') ?> </a>
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
                            <h4><?php echo display('add_new_vehicles') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Cvehicles/insert_vehicle', array('class' => 'form-vertical', 'id' => 'insert_category')) ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="customer_id" class="col-sm-4 col-form-label"><?php echo display('customer_name'); ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <?php
//                                    d($customers);
                                    if ($user_type == 3) {
                                        ?>
                                    <select name="customer_id" id="customer_id" class="form-control" required>
                                            <option value="">Select One</option>
                                            <?php
                                            foreach ($customers as $customer) {
                                                if ($user_id == $customer['customer_id']) {
                                                    ?>
                                                    <option value="<?php echo $customer['customer_id'] ?>" selected=""><?php echo $customer['customer_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    <?php } else { ?>
                                    <select name="customer_id" id="customer_id" class="form-control" required>
                                            <option value="">Select One</option>
                                            <?php foreach ($customers as $customer) { ?>
                                                <option value="<?php echo $customer['customer_id'] ?>"><?php echo $customer['customer_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="vehicle_registration" class="col-sm-4 col-form-label"><?php echo display('vehicle_registration') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="vehicle_registration" id="vehicle_registration" placeholder="<?php echo display('vehicle_registration') ?>" class="form-control" required>    
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="year" class="col-sm-4 col-form-label"><?php echo display('year') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="year" id="year" placeholder="<?php echo display('year') ?>" class="form-control">    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="seats" class="col-sm-4 col-form-label"><?php echo display('seats') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="seats" id="seats" placeholder="<?php echo display('seats') ?>" class="form-control">    
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                           
                            <div class="col-sm-6">
                                <label for="make" class="col-sm-4 col-form-label"><?php echo display('make') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="make" id="make" class="form-control" placeholder="<?php echo display('make') ?>">    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="cc_rating" class="col-sm-4 col-form-label"><?php echo display('cc_rating') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name ="cc_rating" id="cc_rating" type="text" placeholder="<?php echo display('cc_rating') ?>" >
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="model" class="col-sm-4 col-form-label"><?php echo display('model') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="model" id="model" class="form-control" placeholder="<?php echo display('model') ?>">    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="fuel_type" class="col-sm-4 col-form-label"><?php echo display('fuel_type') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" name ="fuel_type" id="fuel_type" data-placeholder='-- select one --'>
                                        <option value=""></option>
                                        <option value="Petrol">Petrol</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="Octane">Octane</option>
                                        <option value="CNG">CNG</option>
                                        <option value="Hybrid">Hybrid</option>
                                        <option value="Electrict Charge">Electric Charge</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="color" class="col-sm-4 col-form-label"><?php echo display('color') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="color" id="color" class="form-control" placeholder="<?php echo display('color') ?>">    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="assembly_type" class="col-sm-4 col-form-label"><?php echo display('assembly_type') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name ="assembly_type" id="assembly_type" type="text" placeholder="<?php echo display('assembly_type') ?>" >
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="second_color" class="col-sm-4 col-form-label"><?php echo display('second_color') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="second_color" id="second_color" class="form-control" placeholder="<?php echo display('second_color') ?>">    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="country_of_origin" class="col-sm-4 col-form-label"><?php echo display('country_of_origin') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name ="country_of_origin" id="country_of_origin" type="text" placeholder="<?php echo display('country_of_origin') ?>" >
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="sub_model" class="col-sm-4 col-form-label"><?php echo display('sub_model') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="sub_model" id="sub_model" class="form-control" placeholder="<?php echo display('sub_model') ?>">    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="gross_vehicle_mass" class="col-sm-4 col-form-label"><?php echo display('gross_vehicle_mass') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name ="gross_vehicle_mass" id="gross_vehicle_mass" type="text" placeholder="<?php echo display('gross_vehicle_mass') ?>" >
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="body_style" class="col-sm-4 col-form-label"><?php echo display('body_style') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="body_style" id="body_style" class="form-control" placeholder="<?php echo display('body_style') ?>">    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="tare_weight" class="col-sm-4 col-form-label"><?php echo display('tare_weight') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name ="tare_weight" id="tare_weight" type="text" placeholder="<?php echo display('tare_weight') ?>" >
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="vin" class="col-sm-4 col-form-label"><?php echo display('vin') ?> <i class="text-danger"> *</i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="vin" id="vin" class="form-control" placeholder="<?php echo display('vin') ?>" required>    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="axle" class="col-sm-4 col-form-label"><?php echo display('axle') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name ="axle" id="axle" type="text" placeholder="<?php echo display('axle') ?>" >
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
<!--                            <div class="col-sm-6">
                                <label for="plate" class="col-sm-4 col-form-label"><?php echo display('plate') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name ="plate" id="plate" type="text" placeholder="<?php echo display('plate') ?>" >
                                </div>
                            </div>                            -->
                            <div class="col-sm-6">
                                <label for="wheelbase" class="col-sm-4 col-form-label"><?php echo display('wheelbase') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name ="wheelbase" id="wheelbase" type="text" placeholder="<?php echo display('wheelbase') ?>" >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="engine_no" class="col-sm-4 col-form-label"><?php echo display('engine_no') ?> <i class="text-danger"> *</i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="engine_no" id="engine_no" class="form-control" placeholder="<?php echo display('engine_no') ?>" required>    
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="front_axle_group_rating" class="col-sm-4 col-form-label"><?php echo display('front_axle_group_rating') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name ="front_axle_group_rating" id="front_axle_group_rating" type="text" placeholder="<?php echo display('front_axle_group_rating') ?>" >
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <label for="vehicle_type" class="col-sm-4 col-form-label"><?php echo display('vehicle_type') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" name="vehicle_type" id="vehicle_type" class="form-control" data-placeholder="-- select one --">
                                        <option value=""></option>
                                        <?php
                                        foreach ($get_vehicletype as $type) {
                                            echo "<option value='$type->id'>$type->vehicle_type</option>";
                                        }
                                        ?>
                                    </select>   
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="rear_axle_group_rating" class="col-sm-4 col-form-label"><?php echo display('rear_axle_group_rating') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="rear_axle_group_rating" id="rear_axle_group_rating" type="text" placeholder="<?php echo display('rear_axle_group_rating') ?>" >
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-vehicles" class="btn btn-success btn-large" name="add-vehicles" value="<?php echo display('save') ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>





