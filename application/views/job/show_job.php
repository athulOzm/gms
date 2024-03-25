<link href="<?php echo base_url('assets/custom/job.css') ?>" rel="stylesheet" type="text/css"/>
<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$company_info = $CI->db->get('company_information')->row();

$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
?>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('jobs') ?></h1>
            <small><?php echo display('show_job_information') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('jobs') ?></a></li>
                <li class="active"><?php echo display('show_job_information') ?></li>
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
        <?php // print_r($get_workorder); ?>
        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('show_job_information') ?> </h4>
                        </div>
                    </div>
                    <?php // echo form_open('#', array('class' => 'form-vertical', 'id' => 'insert_category')) ?>
                    <div class="panel-body">
                        <ul class="nav nav-tabs m-b-20">
                            <li class="active"><a href="#tab1" data-toggle="tab"><?php echo display('work_order'); ?></a></li>
                            <li><a href="#tab2" data-toggle="tab"><?php echo display('job_performed'); ?></a></li>
                            <li><a href="#tab3" data-toggle="tab"><?php echo display('product_used'); ?></a></li>
                            <li><a href="#tab4" data-toggle="tab"><?php echo display('recommendation_notes'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="customer_id" class="col-sm-4 col-form-label"><?php echo display('customer') ?></label>
                                        <div class="col-sm-8">
                                            <?php
                                            foreach ($customers as $customer) {
                                                if ($get_workorder[0]->customer_id == $customer['customer_id']) {
                                                    echo $customer['customer_name'];
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="order_no" class="col-sm-4 col-form-label"><?php
                                            if ($user_type != 3) {
                                                echo display('work_order_no');
                                            } else {
                                                echo display('job_order_no');
                                            }
                                            ?> </label>
                                        <div class="col-sm-8">
                                            <?php echo $get_workorder[0]->work_order_no; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="address" class="col-sm-4 col-form-label"><?php echo display('address') ?></label>
                                        <div class="col-sm-8">
                                            <?php echo $customer_info[0]->customer_address; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="registration_no" class="col-sm-4 col-form-label"><?php echo display('registration_no') ?></label>
                                        <div class="col-sm-8">
                                            <?php
                                            foreach ($customer_wise_vehicle_info as $single) {
                                                if ($single->vehicle_id == $get_workorder[0]->vehicle_id) {
                                                    echo $single->vehicle_registration;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="phone" class="col-sm-4 col-form-label"><?php echo display('phone') ?></label>
                                        <div class="col-sm-8">
                                            <?php echo $customer_info[0]->customer_phone; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="reference" class="col-sm-4 col-form-label"><?php echo display('reference') ?></label>
                                        <div class="col-sm-8">
                                            <?php echo $get_workorder[0]->customer_ref; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="mobile" class="col-sm-4 col-form-label"><?php echo display('mobile') ?></label>
                                        <div class="col-sm-8">
                                            <?php echo $customer_info[0]->customer_phone; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="schedule_datetime" class="col-sm-4 col-form-label"><?php echo display('schedule_datetime') ?></label>
                                        <div class="col-sm-8">
                                            <?php echo $get_workorder[0]->schedule_date_time; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="website" class="col-sm-4 col-form-label"><?php echo display('website') ?></label>
                                        <div class="col-sm-8">
                                            <?php echo $customer_info[0]->website; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="delivery_datetime" class="col-sm-4 col-form-label"><?php echo display('delivery_datetime') ?></label>
                                        <div class="col-sm-8">
                                            <?php echo $get_workorder[0]->delivery_date_time; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="details" class="col-sm-4 col-form-label"><?php echo display('details') ?></label>
                                        <div class="col-sm-8">
                                            <?php echo $get_workorder[0]->job_description; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="vehicle" class="col-sm-4 col-form-label"><?php echo display('alert_via') ?></label>
                                        <div class="col-sm-8">
                                            <?php
                                            if ($get_workorder[0]->alert_via == 'sms') {
                                                echo "SMS";
                                            } elseif ($get_workorder[0]->alert_via == 'email') {
                                                echo "Email";
                                            } elseif ($get_workorder[0]->alert_via == 'post') {
                                                echo "Post";
                                            } elseif ($get_workorder[0]->alert_via == 'never') {
                                                echo "Never";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-primary btnNext" ><?php echo display('next'); ?></a>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="item_table">
                                                <thead>
                                                    <tr>
                                                        <th width=""><?php echo display('job_type'); ?></th>
                                                        <th width=""><?php echo display('mechanic'); ?></th>
                                                        <?php if ($user_type == 1 || $user_type == 2) { ?>
                                                            <th width=""><?php echo display('starting_datetime'); ?></th>   
                                                            <th width=""><?php echo display('ending_datetime'); ?></th>   
                                                        <?php } ?>                                                            
                                                        <?php if ($user_type == 1 || $user_type == 2) { ?>
                                                            <th width=""><?php echo display('mechanic_notes'); ?></th>   
                                                        <?php } ?>
                                                        <th width="" class="text-left"><?php echo display('status'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($get_job_details) {
                                                        $i = 0;
                                                        foreach ($get_job_details as $job_details) {
                                                            $i++;
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <?php
                                                                    foreach ($get_jobtypelist as $jobtype) {
                                                                        if ($job_details->job_type_id == $jobtype->job_type_id) {
                                                                            echo $jobtype->job_type_name;
                                                                        }
                                                                        if ($job_details->job_type_id == $jobtype->job_type_id && $jobtype->fk_inspection_id != 0) {
                                                                            $checklist_view = $this->db->select('*')->where('fk_inspection_id', $jobtype->fk_inspection_id)->get('job_type')->row();
//                                                                            echo $checklist_view->job_type_id;die()
                                                                            $check_job_typeid_package = $this->db->select('*')
                                                                                            ->where('inspection_job_typeid', $checklist_view->job_type_id)
                                                                                            ->where('job_id', $get_workorder[0]->job_id)
                                                                                            ->get('package_tbl')->row();
                                                                            if ($check_job_typeid_package) {
                                                                                ?>
                                                                                <button type="button" class="btn btn-sm btn-success" onclick="view_checklist('<?php echo $jobtype->fk_inspection_id; ?>', '<?php echo $get_workorder[0]->job_id; ?>')" data-toggle='tooltip' data-placement='top' title='View Checklist'>
                                                                                    <i class="fa fa-eye"><?php //echo $jobtype->fk_inspection_id;       ?></i>
                                                                                </button>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    foreach ($get_employeelist as $mechanic) {
                                                                        if ($job_details->assign_to == $mechanic->user_id) {
                                                                            echo $mechanic->full_name;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <?php if ($user_type == 1 || $user_type == 2) { ?>
                                                                    <td>
                                                                        <input type="text" name="startdatetime" id="startdatetime_<?php echo $i; ?>" class="form-control datetime" value="<?php echo $job_details->start_datetime; ?>" readonly>    
                                                                    </td>
                                                                    <td> <input type="text" name="enddatetime" id="enddatetime_<?php echo $i; ?>" class="form-control datetime"  value="<?php echo $job_details->end_datetime; ?>" readonly> </td>
                                                                <?php } ?>
                                                                <?php if ($user_type == 1 || $user_type == 2) { ?>
                                                                    <td>
                                                                        <input type="text" name="mechanics_note" id="mechanics_note_<?php echo $i; ?>" class="form-control " value="<?php echo $job_details->mechanic_notes; ?>" readonly>
                                                                    </td>
                                                                <?php } ?>
                                                                <td>
                                                                    <input type="hidden" name="jobdetails_rowid" id="jobdetails_rowid_<?php echo $i; ?>" value="<?php echo $job_details->row_id; ?>">
                                                                    <?php
                                                                    if ($job_details->status == '0') {
                                                                        echo "Pending";
                                                                    } elseif ($job_details->status == '1') {
                                                                        echo "In Progress";
                                                                    } elseif ($job_details->status == '2') {
                                                                        echo "Declined";
                                                                    } elseif ($job_details->status == '3') {
                                                                        echo "Completed";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <!--<td></td>-->
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modal_show_info" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <!--                                                <h5 class="modal-title">Edit Category Information</h5>
                                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                                                <img src="<?php echo $Web_settings[0]['invoice_logo']; ?>">
                                            </div>
                                            <div class="modal-body" id="modal_info">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>                                
                                <a class="btn btn-primary btnNext" ><?php echo display('next'); ?></a>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <div class="row">
                                    <?php // echo form_open('Cjob/addProductused', array('class' => 'form-vertical', 'id' => 'insert_category'))         ?>
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="product_table">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo display('product_name'); ?></th>
                                                        <!--<th><?php echo display('available_quantity'); ?></th>-->   
                                                        <th class="text-center"><?php echo display('used_quantity'); ?></th>   
                                                        <th class="text-right"><?php echo display('price'); ?></th>   
                                                        <?php // if ($user_type == 1 || $user_type == 2) {      ?>
                                                        <th><?php echo display('mechanic_notes'); ?></th>   
                                                        <?php // }         ?>
<!--                                                        <th>
                                                        <button type="button" class="btn btn-success" onClick="addProduct('itmetable');"><i class="fa fa-plus"></i></button>
                                                    </th>      -->
                                                    </tr>
                                                </thead>
                                                <tbody id="itmetable">
                                                    <?php
//                                                    dd($job_usedproduct);
                                                    if ($job_usedproduct) {
                                                        $i = 0;
                                                        foreach ($job_usedproduct as $usedproduct) {
                                                            if (!$usedproduct->group_price_id) {
                                                                $i++;
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php
                                                                        foreach ($get_productlist as $product) {
                                                                            if ($usedproduct->product_id == $product->product_id) {
                                                                                echo $product->product_name;
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </td>
            <!--                                                                <td>
                                                                    <?php echo $usedproduct->available_qty; ?>
                                                                    </td>-->
                                                                    <td class="text-center">
                                                                        <?php echo $usedproduct->used_qty; ?>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php echo $usedproduct->rate; ?>
                                                                    </td>
                                                                    <?php // if ($user_type == 1 || $user_type == 2) {     ?>
                                                                    <td>
                                                                        <?php echo $usedproduct->mechanic_note; ?>
                                                                    </td>
                                                                    <?php // }       ?>
                                                                </tr>
                                                                <?php
                                                            } else {
                                                                $this->db->select('*')->from('group_pricing_details a');
                                                                $this->db->join('product_information b', 'b.product_id = a.product_id');
                                                                $this->db->where('a.group_price_id', $usedproduct->group_price_id);
                                                                $getgroupproducts = $this->db->get()->result();
                                                                foreach ($getgroupproducts as $groupproduct) {
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php
//                                                                            foreach ($get_productlist as $product) {
//                                                                                if ($usedproduct->product_id == $groupproduct->product_id) {
                                                                            echo $groupproduct->product_name;
//                                                                                }
//                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?php echo ($usedproduct->used_qty) * ($groupproduct->group_product_qty); ?>
                                                                        </td>
                                                                        <td class="text-right">
                                                                            <?php echo $groupproduct->product_rate; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $usedproduct->mechanic_note; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <?php // echo form_close()         ?>
                                </div>
                                <a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>
                                <a class="btn btn-primary btnNext" ><?php echo display('next'); ?></a>
                            </div>
                            <div class="tab-pane" id="tab4">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <label for="set_default_terms"><?php echo display('recommendation_notes'); ?></label><br>
                                        <p class="recommendation_txt">
                                            <?php echo $get_workorder[0]->recommendation; ?>
                                        </p>
                                    </div>
                                </div>
                                <a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>
                            </div>
                        </div>
                    </div>
                    <?php // echo form_close()                  ?>
                </div>
            </div>
            <input type="hidden" id="viewChecklistUrl" value="<?php echo base_url('Cinspection/get_view_checklist'); ?>">
        </div>
    </section>
</div>
<script src="<?php echo base_url('assets/custom/job.js'); ?>"></script>