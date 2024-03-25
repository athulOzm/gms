<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo (isset($title)) ? $title : "Online & Offline Inventory System" ?></title>
        <?php
        $CI = & get_instance();
        $CI->load->model('Web_settings');
        $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
        date_default_timezone_set($Web_settings[0]['timezone']);
        ?>
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php
        if (isset($Web_settings[0]['logo'])) {
            echo $Web_settings[0]['favicon'];
        }
        ?>" type="image/x-icon">
        <link rel="apple-touch-icon" type="image/x-icon" href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-57-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-144-precomposed.png">
        <!-- Start Global Mandatory Style-->
        <!-- full calendar -->
        <link href="<?php echo base_url() ?>assets/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
        <!-- fullcalendar print css -->
        <link href="<?php echo base_url() ?>assets/plugins/fullcalendar/fullcalendar.print.min.css" rel="stylesheet" media='print' type="text/css"/>

        <!-- jquery-ui css -->
        <link href="<?php echo base_url() ?>assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap -->
        <link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!-- modals css -->
        <link href="<?php echo base_url() ?>assets/plugins/modals/component.css" rel="stylesheet" type="text/css"/>
        <?php
        if ($Web_settings[0]['rtr'] == 1) {
            ?>
            <!-- Bootstrap rtl -->
            <link href="<?php echo base_url() ?>assets/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
            <?php
        }
        ?>
        <!-- Font Awesome -->
        <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/css/cmxform.css" rel="stylesheet" type="text/css"/>
        <!-- Themify icons -->
        <link href="<?php echo base_url() ?>assets/themify-icons/themify-icons.min.css" rel="stylesheet" type="text/css"/>
        <!-- Pe-icon -->
        <link href="<?php echo base_url() ?>assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
        <!-- Data Tables -->
        <link href="<?php echo base_url() ?>assets/plugins/datatables/dataTables.min.css" rel="stylesheet" type="text/css"/>
        <!-- Theme style -->
        <link href="<?php echo base_url() ?>assets/dist/css/styleBD.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" type="text/css"/>
        <!-- datetimepicker -->
        <link href="<?php echo base_url() ?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css"/>
        <?php
        if ($Web_settings[0]['rtr'] == 1) {
            ?>
            <!-- Theme style rtl -->
            <link href="<?php echo base_url() ?>assets/dist/css/styleBD-rtl.css" rel="stylesheet" type="text/css"/>
            <?php
        }
        ?>
        <!-- jQuery -->
        <script src="<?php echo base_url() ?>assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
        <!-- fullcalendar js -->
        <script src="<?php echo base_url() ?>assets/plugins/fullcalendar/lib/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!--=========== its for jquery timer ============-->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/jquery.timepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/jquery.timepicker.css" />
    </head>
<style type="text/css">
    .nav.nav-tabs li a {
        background-color: green;
        color:white;
    }

    .nav.nav-tabs li:not(.active) a {
        pointer-events:none;
        background-color: #2554C7;
        color:white;
    }
    /*.nav.nav-tabs li (.active) a{*/
    .nav.nav-tabs li a:active{
        background-color: red;
        color:white;
    }
    ul li a{
        font-size: 12.5px;
    }
</style>
    <body class="hold-transition sidebar-mini">
        <div class="se-pre-con"></div>
        <!-- Site wrapper -->
        <div class="wrapper">
            <!--            {content}-->
            <div class="content-wrapper">
            <!--    <section class="content-header">
                    <div class="header-icon">
                        <i class="pe-7s-note2"></i>
                    </div>
                    <div class="header-title">
                        <h1><?php echo display('customer') ?></h1>
                        <small><?php echo display('customer_register') ?></small>
                        <ol class="breadcrumb">
                            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                            <li><a href="#"><?php echo display('customer') ?></a></li>
                            <li class="active"><?php echo display('customer_register') ?></li>
                        </ol>
                    </div>
                </section>-->

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
                                <?php // if ($this->permission1->check_label('manage_job')->read()->access()) { ?>
                                <a href="<?php echo base_url('Admin_dashboard/login') ?>" class="btn btn-info m-b-5 m-r-2"> <?php echo display('back') ?> </a>
                                <?php // } ?>
                            </div>
                        </div>
                    </div>
                    <!-- New category -->
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h4><?php echo display('customer_register') ?> </h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo form_open('Admin_dashboard/insert_customer', array('class' => 'form-vertical', 'id' => '')) ?>
                                    <ul class="nav nav-tabs" style="margin-bottom: 20px;">
                                        <li class="active"><a href="#tab1" data-toggle="tab"><?php echo display('contact_details'); ?></a></li>
                                        <li><a href="#tab2" data-toggle="tab"><?php echo display('company_details'); ?></a></li>
                                        <li><a href="#tab3" data-toggle="tab"><?php echo display('account_details'); ?></a></li>
                                        <li><a href="#tab4" data-toggle="tab"><?php echo display('financial_details'); ?></a></li>
                                        <li><a href="#tab5" data-toggle="tab"><?php echo display('login_details'); ?></a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="form-group row">
                                                <label for="customer_name" class="col-sm-3 col-form-label text-right"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="customer_name" id="customer_name" type="text" placeholder="<?php echo display('customer_name') ?>"  required tabindex="1">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="customer_phone" class="col-sm-3 col-form-label text-right"><?php echo display('customer_phone') ?> <i class="text-danger">*</i></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="customer_phone" id="customer_phone" type="number" placeholder="<?php echo display('customer_phone') ?>" tabindex="2"> 
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="customer_mobile" class="col-sm-3 col-form-label text-right"><?php echo display('customer_mobile') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="customer_mobile" id="customer_mobile" type="number" placeholder="<?php echo display('customer_mobile') ?>" tabindex="3"> 
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="customer_email" class="col-sm-3 col-form-label text-right"><?php echo display('customer_email') ?> <i class="text-danger"> *</i></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="customer_email" id="customer_email" type="email" onkeyup="customer_email_to_username(this.value)" placeholder="<?php echo display('customer_email') ?>" required tabindex="4"> <span id="email_v_message"></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="customer_skype" class="col-sm-3 col-form-label text-right"><?php echo display('customer_skype') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="customer_skype" id="customer_skype" type="text" placeholder="<?php echo display('customer_skype') ?>" tabindex="5">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="address" class="col-sm-3 col-form-label text-right"><?php echo display('customer_address') ?></label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control" name="customer_address" id="address " rows="3" placeholder="<?php echo display('customer_address') ?>" tabindex="6"></textarea>
                                                </div>
                                            </div>
                                            <a class="btn btn-primary btnNext" onclick="valid_one()"><?php echo display('next'); ?></a>
                                        </div>
                                        <div class="tab-pane" id="tab2">
                                            <div class="form-group row">
                                                <label for="company_name" class="col-sm-3 col-form-label text-right"><?php echo display('company_name') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name="company_name" id="company_name" placeholder="<?php echo display('company_name') ?>" tabindex="7">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="company_number" class="col-sm-3 col-form-label text-right"><?php echo display('company_number') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="number" name="company_number" id="company_number " placeholder="<?php echo display('company_number') ?>" tabindex="8">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="gst_vat_number" class="col-sm-3 col-form-label text-right"><?php echo display('gst_vat_number') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name="vat_number" id="gst_vat_number " placeholder="<?php echo display('gst_vat_number') ?>" tabindex="9">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="company_type" class="col-sm-3 col-form-label text-right"><?php echo display('company_type') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name="company_type" id="company_type " placeholder="<?php echo display('company_type') ?>" tabindex="10">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="postal_address" class="col-sm-3 col-form-label text-right"><?php echo display('postal_address') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name="postal_address" id="postal_address " placeholder="<?php echo display('postal_address') ?>" tabindex="11">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="physical_address" class="col-sm-3 col-form-label text-right"><?php echo display('physical_address') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name="physical_address" id="physical_address " placeholder="<?php echo display('physical_address') ?>" tabindex="12">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="company_website" class="col-sm-3 col-form-label text-right"><?php echo display('company_website') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name="website" id="company_website " placeholder="<?php echo display('company_website') ?>" tabindex="13">
                                                </div>
                                            </div>
                                            <a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>
                                            <a class="btn btn-primary btnNext" onclick="valid_two()"><?php echo display('next'); ?></a>
                                        </div>
                                        <div class="tab-pane" id="tab3">
                                            <div class="form-group row">
                                                <label for="director_name" class="col-sm-3 col-form-label text-right"><?php echo display('director_name') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="director_name" id="director_name" type="text" placeholder="<?php echo display('director_name') ?>" tabindex="14">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="director_mobile" class="col-sm-3 col-form-label text-right"><?php echo display('director_mobile') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="director_mobile" id="director_mobile" type="number" placeholder="<?php echo display('director_mobile') ?>" min="0" tabindex="15">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="director_phone" class="col-sm-3 col-form-label text-right"><?php echo display('director_phone') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="director_phone" id="director_phone" type="number" placeholder="<?php echo display('director_phone') ?>" min="0" tabindex="16">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="director_address " class="col-sm-3 col-form-label text-right"><?php echo display('director_address') ?></label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control" name="director_address" id="director_address " rows="3" placeholder="<?php echo display('director_address') ?>" tabindex="17"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="trade_reference_1" class="col-sm-3 col-form-label text-right"><?php echo display('trade_reference_1') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="trade_reference_1" id="trade_reference_1" type="text" placeholder="<?php echo display('trade_reference_1') ?>" tabindex="18">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="trade_reference_2" class="col-sm-3 col-form-label text-right"><?php echo display('trade_reference_2') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="trade_reference_2" id="trade_reference_2" type="text" placeholder="<?php echo display('trade_reference_2') ?>" tabindex="19">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="trade_reference_3" class="col-sm-3 col-form-label text-right"><?php echo display('trade_reference_3') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="trade_reference_3" id="trade_reference_3" type="text" placeholder="<?php echo display('trade_reference_3') ?>" tabindex="20">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="status" class="col-sm-3 col-form-label text-right"><?php echo display('status') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="status" id="status" type="text" placeholder="<?php echo display('status') ?>" tabindex="21">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="notes" class="col-sm-3 col-form-label text-right"><?php echo display('notes') ?></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="notes" id="notes" type="text" placeholder="<?php echo display('notes') ?>" tabindex="22">
                                                </div>
                                            </div>
                                            <a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>
                                            <a class="btn btn-primary btnNext" onclick="valid_three()"><?php echo display('next'); ?></a>
                                        </div>
                                        <div class="tab-pane" id="tab4">
                                            <div class="form-group row">
                                                <label for="notifications" class="col-sm-3 col-form-label text-right"><?php echo display('notification') ?></label>
                                                <div class="col-sm-6">
                                                    <label for="sms">
                                                        <input type="checkbox" name="notifications[]" id="sms" value="sms"> <?php echo display('sms'); ?>  
                                                    </label>
                                                    <label for="email">
                                                        <input type="checkbox" name="notifications[]" id="email" value="email"> <?php echo display('email'); ?> 
                                                    </label>
                                                    <label for="post">
                                                        <input type="checkbox" name="notifications[]" id="post" value="post"> <?php echo display('post'); ?> 
                                                    </label>
                                                    <label for="none">
                                                        <input type="checkbox" name="notifications[]" id="none" value="none"> <?php echo display('none'); ?> 
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="payment_method" class="col-sm-3 col-form-label text-right"><?php echo display('payment_method') ?></label>
                                                <div class="col-sm-6">
                                                    <label for="cash">
                                                        <input type="radio" name="payment_method" id="cash" value="cash"> <?php echo display('cash'); ?> 
                                                    </label>
                                                    <label for="internet">
                                                        <input type="radio" name="payment_method" id="internet" value="internet"> <?php echo display('internet'); ?> 
                                                    </label>
                                                    <label for="credit">
                                                        <input type="radio" name="payment_method" id="credit" value="credit"> <?php echo display('credit'); ?> 
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="company_sales_discount" class="col-sm-3  text-right"><?php echo display('company_sales_discount'); ?></label>
                                                <div class="col-sm-6">
                                                    <select name="sales_discount_status" onchange="discount_trade_markup(this.value)" class="form-control select2" id="company_sales_discount" data-placeholder="-- select one --" style="margin-bottom: 20px;">
                                                        <option value=""></option>
                                                        <option value="none">None</option>
                                                        <option value="trade markup"><?php echo display('trade_markup'); ?></option>
                                                        <option value="retail markup"><?php echo display('retail_markup'); ?></option>
                                                    </select>
                                                    <div class="text_box" style="margin-top: 10px;">

                                                    </div>
                                                </div>
                                            </div>

                                            <a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>
                                            <a class="btn btn-primary btnNext" onclick="valid_four()"><?php echo display('next'); ?></a>
                                        </div>
                                        <div class="tab-pane" id="tab5">
                                            <div class="form-group row">
                                                <label for="user_name" class="col-sm-3 col-form-label text-right"><?php echo display('user_name') ?> <i class="text-danger"> * </i></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="user_name" id="user_name" type="text" placeholder="<?php echo display('user_name') ?>" tabindex="23" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-3 col-form-label text-right"><?php echo display('password') ?> <i class="text-danger"> * </i></label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name ="password" id="password" type="password" placeholder="<?php echo display('password') ?>" min="0" tabindex="24" required>
                                                </div>
                                            </div>
<!--                                            <div class="form-group row">
                                                <label for="role_id" class="col-sm-3 col-form-label text-right"><?php echo display('role_name') ?> <i class="text-danger"> * </i></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="role_id" id="role_id" required> 
                                                        <option value=""><?php echo display('select_one') ?></option>
                                                        <?php
                                                        foreach ($get_rolelist as $data) {
                                                            ?>
                                                            <option value="<?php echo $data['id'] ?>"><?php echo $data['type'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>-->

                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                                <div class="col-sm-6">
                                                    <input type="submit" id="add-customer" class="btn btn-success btn-large" onclick="valid_four()" name="add-customer" value="<?php echo display('save') ?>" tabindex="7"/>
                                                    <!--<input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-customer-another" class="btn btn-large btn-success" id="add-customer-another" tabindex="6">-->
                                                </div>
                                            </div>
                                            <a class="btn btn-primary btnPrevious" ><?php echo display('previous'); ?></a>
                                        </div>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
        <!-- ./wrapper -->

        <!-- Start Core Plugins-->
        <!-- jquery-ui --> 

        <script src="<?php echo base_url() ?>assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

        <!-- SlimScroll -->
        <script src="<?php echo base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url() ?>assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <!-- AdminBD frame -->
        <script src="<?php echo base_url() ?>assets/dist/js/frame.min.js" type="text/javascript"></script>
        <!-- Sparkline js -->
        <script src="<?php echo base_url() ?>assets/plugins/sparkline/sparkline.min.js" type="text/javascript"></script>
        <!-- Counter js -->
        <script src="<?php echo base_url() ?>assets/plugins/counterup/waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <!-- dataTables js -->
        <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.min.js" type="text/javascript"></script>


        <!-- Modal js -->
        <script src="<?php echo base_url() ?>assets/plugins/modals/classie.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/modals/modalEffects.js" type="text/javascript"></script>

        <!-- Dashboard js -->
        <script src="<?php echo base_url() ?>assets/dist/js/dashboard.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/jstree.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/TreeMenu.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap-datetimepicker.js"></script>


        <script>
                                                        $('.select2').select2();
                                                        //    ============= its for jquery timepicker ============
                                                        $(function () {
                                                            $('#standard_timing').timepicker({'scrollDefault': 'now'});
                                                        });
        </script>

        <script type="text/javascript">
            $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});

            // select 2 dropdown 
            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });

            //Insert supplier
            $("#insert_supplier").validate();
            $("#validate").validate();

            //Update supplier
            $("#supplier_update").validate();

            //Update customer
            $("#customer_update").validate();

            //Insert customer
            $("#insert_customer").validate();

            //Update product
            $("#product_update").validate();

            //Insert product
            $("#insert_product").validate();

            //Insert pos invoice
            $("#insert_pos_invoice").validate();

            //Insert invoice
            $("#insert_invoice").validate();

            //Update invoice
            $("#invoice_update").validate();

            //Insert purchase
            $("#insert_purchase").validate();

            //Update purchase
            $("#purchase_update").validate();

            //Add category
            $("#insert_category").validate();

            //Update category
            $("#category_update").validate();

            //Stock report
            $("#stock_report").validate();

            //Stock report
            $("#stock_report_supplier_wise").validate();
            //Stock report
            $("#stock_report_product_wise").validate();

            //Create account
            $("#create_account_data").validate();

            //Update account
            $("#update_account_data").validate();

            //Inflow entry
            $("#inflow_entry").validate();

            //Outflow entry
            $("#outflow_entry").validate();

            //Tax entry
            $("#tax_entry").validate();

            //Update tax
            $("#update_tax").validate();

            //Account summary
            $("#summary_datewise").validate();
            //Comission generate
            $("#commission_generate").validate();

        </script>

        <script>
            $(document).ready(function () {
                "use strict"; // Start of use strict
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('editor1');
            });
        </script>
        <script type="text/javascript">
            $(".datetime").datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                autoclose: true,
                todayBtn: true
            });



            var today = new Date();
            $("#datetime4").datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                autoclose: true,
                todayBtn: true,
                startDate: today
            });

            var today = new Date();
            $('#from').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                autoclose: true,
                todayBtn: true,
                startDate: today
            }).on('changeDate', function (ev) {
                $('#to').datetimepicker('setStartDate', ev.date);
            });

            $('#to').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                autoclose: true,
                todayBtn: true,
                startDate: today
            }).on('changeDate', function (ev) {
                $('#from').datetimepicker('setEndDate', ev.date);
            });

            $('#date').datetimepicker({
                format: 'yyyy-mm-dd',
                weekStart: 1,
                todayBtn: true,
                autoclose: true,
                todayHighlight: true,
                startView: 2,
                minView: 2,
                forceParse: 0
            });

            $('#time').datetimepicker({
                format: 'hh:ii',
                weekStart: 1,
                todayBtn: true,
                autoclose: true,
                todayHighlight: true,
                startView: 1,
                minView: 0,
                maxView: 1,
                forceParse: 0
            });
        </script>


        <script type="text/javascript">
            $('.btnPrevious').click(function () {
                $('.nav-tabs > .active').prev('li').find('a').trigger('click');
            });

            $("#customer_name").on('keyup', function () {
                var customername = document.getElementById('customer_name');
                if (customername.value.length === 0)
                    return;
                document.getElementById("customer_name").style.borderColor = "green";
            });

            $("#customer_phone").on('keyup', function () {
                var customerphone = document.getElementById('customer_phone');
                if (customerphone.value.length === 0)
                    return;
                document.getElementById("customer_phone").style.borderColor = "green";
            });
            $("#customer_email").on('keyup', function () {
                var inpemail = document.getElementById('customer_email');
                if (inpemail.value.length === 0)
                    return;
                document.getElementById("customer_email").style.borderColor = "green";
                var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;

                if (!(inpemail.value).match(reEmail)) {
                    //alert("Invalid email address");
                    document.getElementById("email_v_message").innerHTML = "Invalid Email address";
                    document.getElementById("customer_email").style.borderColor = "red";
                    return false;
                }
                document.getElementById("email_v_message").innerHTML = "";
                return true;
            });
        //    ============= its for discount_trade_markup =============
            function discount_trade_markup(t) {
                if (t == 'trade markup' || t == 'retail markup') {
                    $(".text_box").html("<input type='number' name='markup_discount' class='form-control markup_discount' id='markup_discount'>");
                }
                if (t == 'none') {
                    $(".text_box").html('');
                }
            }
        //    =========== its for when customer email type then go to username auto ===========
            function customer_email_to_username(t) {
                var customer_email = t;
                $("#user_name").val(customer_email);
        //        console.log(customer_email);
            }

            function valid_one() {
                var customerName = document.getElementById('customer_name');
                var phoneInput = document.getElementById('customer_phone');
                var emailInput = document.getElementById('customer_email');
                var name = $('#customer_name').val();
                var phone = $('#customer_phone').val();
                var email = $('#customer_email').val();
                if (name == "") {
                    document.getElementById("customer_name").style.borderColor = "red";

                } else {
                    $("#customer_name").on('keyup', function () {
                        document.getElementById("customer_name").style.borderColor = "green";
                    });

                }
                if (phone == "") {
                    document.getElementById("customer_phone").style.borderColor = "red";

                } else {
                    $("#customer_phone").on('keyup', function () {
                        document.getElementById("customer_phone").style.borderColor = "green";
                    });

                }
                if (email == "") {
                    document.getElementById("customer_email").style.borderColor = "red";
                    return false;
                } else {
                    $("#customer_email").on('keyup', function () {
                        document.getElementById("customer_email").style.borderColor = "green";
                    });
                }
                var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;

                if (email !== "" && email.match(reEmail) && phone !== "" && name !== "") {
                    $('.nav-tabs > .active').next('li').find('a').trigger('click');
                }
            }

            function valid_two() {
                $('.nav-tabs > .active').next('li').find('a').trigger('click');
            }
            function valid_three() {
                $('.nav-tabs > .active').next('li').find('a').trigger('click');
            }
            function valid_four() {
                $('.nav-tabs > .active').next('li').find('a').trigger('click');
            }
            function valid_five() {
                var username = document.getElementById('user_name');
                var password = document.getElementById('password');
                var user = $('#user_name').val();
                var password = $('#password').val();

                if (username == "") {
                    document.getElementById("user_name").style.borderColor = "red";
                    return false;
                } else {
                    $("#user_name").on('keyup', function () {
                        document.getElementById("user_name").style.borderColor = "green";
                    });
                }
                if (password == "") {
                    document.getElementById("password").style.borderColor = "red";
                    return false;
                } else {
                    $("#password").on('keyup', function () {
                        document.getElementById("password").style.borderColor = "green";
                    });
                }

                if (username !== "" && password !== "") {
                    document.getElementById("insert_customer").submit();
                }


            }

        </script>
    </body>
</html>