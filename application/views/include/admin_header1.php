<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$CI->load->model('Reports');
$CI->load->model('Users');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$users = $CI->Users->profile_edit_data();
$out_of_stock = $CI->Reports->out_of_stock_count();
?>
<!-- Admin header end -->
<style type="text/css">
    .navbar .btn-success{
        margin: 13px 2px;
    }
    .displayblock{
        display: block;
    }
</style>
<header class="main-header"> 
    <a href="<?php echo base_url() ?>" class="logo"> <!-- Logo -->
        <span class="logo-mini">
            <!--<b>A</b>BD-->
            <img src="<?php
            if (isset($Web_settings[0]['favicon'])) {
                echo $Web_settings[0]['favicon'];
            }
            ?>" alt="">
        </span>

        <span class="logo-lg">
            <!--<b>Admin</b>BD-->
            <img src="<?php
            if (isset($Web_settings[0]['logo'])) {
                echo $Web_settings[0]['logo'];
            }
            ?>" alt="">
        </span>
    </a>
    <!-- Header Navbar -->


    <nav class="navbar navbar-static-top text-center">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
            <span class="sr-only">Toggle navigation</span>

            <span class="pe-7s-keypad"></span>
        </a>


        <?php if ($this->permission1->method('new_invoice', 'create')->access()) { ?>
            <a href="<?php echo base_url('Cinvoice') ?>" class="btn btn-success btn-outline" style=""><i class="fa fa-balance-scale"></i> <?php echo display('invoice') ?></a>
        <?php } ?>


        <?php if ($this->permission1->method('customer_receive', 'create')->access()) { ?>
            <a href="<?php echo base_url('accounts/customer_receive') ?>" class="btn btn-success btn-outline" style=""><i class="fa fa-money"></i> <?php echo display('customer_receive') ?></a>
        <?php } ?>

        <?php if ($this->permission1->method('supplier_payment', 'create')->access()) { ?>
            <a href="<?php echo base_url('accounts/supplier_payment') ?>" class="btn btn-success btn-outline" style=""><i class="fa fa-money" aria-hidden="true"></i> <?php echo display('supplier_payment') ?></a>
        <?php } ?>

        <?php if ($this->permission1->method('add_purchase', 'create')->access()) { ?>
            <a href="<?php echo base_url('Cpurchase') ?>" class="btn btn-success btn-outline" style=""><i class="ti-shopping-cart"></i> <?php echo display('purchase') ?></a>
        <?php } ?>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                    <a href="<?php echo base_url('Creport/out_of_stock') ?>" >
                        <i class="pe-7s-attention" title="<?php echo display('out_of_stock') ?>"></i>
                        <span class="label label-danger"><?php echo $out_of_stock ?></span>
                    </a>
                </li>
                <!-- settings -->
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('Admin_dashboard/edit_profile') ?>"><i class="pe-7s-users"></i><?php echo display('user_profile') ?></a></li>
                        <li><a href="<?php echo base_url('Admin_dashboard/change_password_form') ?>"><i class="pe-7s-settings"></i><?php echo display('change_password') ?></a></li>
                        <li><a href="<?php echo base_url('Admin_dashboard/logout') ?>"><i class="pe-7s-key"></i><?php echo display('logout') ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<aside class="main-sidebar">
    <!-- sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel text-center">
            <div class="image">
                <?php
                $user_name = $this->session->userdata('user_name');
                if ($users[0]['logo']) {
                    ?>
                    <img src="<?php echo $users[0]['logo'] ?>" class="img-circle" alt="<?php echo $user_name; ?>"  data-toggle="tooltip" data-placement="bottom"  title="<?php echo $user_name; ?>">
                <?php } else { ?>
                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="<?php echo $user_name; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $user_name; ?>">
                <?php } ?>
            </div>
            <div class="info">
                <p><?php echo $user_name; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> <?php echo display('online') ?></a>
            </div>
        </div>
        <!-- sidebar menu -->
        <script type="text/javascript">
        $(document).ready(function (){
              var segment1 = "<?php echo $this->uri->segment('1'); ?>";
                var segment2 = "<?php echo $this->uri->segment('2'); ?>";
                var segment3 = "<?php echo $this->uri->segment('3'); ?>";
                if (segment1 == 'Ccustomer') {
                    $('.customer').addClass('active ');
                    $('#customer').addClass('displayblock ');
                } else if (segment1 == "Cvehicles") {
                    $('.vehicles').addClass('active show');
                    $('#vehicles').addClass('displayblock ');
                }else if (segment1 == "Ccalender") {
                    $('.calenders').addClass('active show');
                    $('#calenders').addClass('displayblock ');
                }
        });
        </script>
        
        <ul class="sidebar-menu">
            <li class="<?php
            if ($this->uri->segment('1') == ("")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="<?php echo base_url() ?>"><i class="ti-dashboard"></i> <span><?php echo display('dashboard') ?></span>
                    <span class="pull-right-container">
                        <span class="label label-success pull-right"></span>
                    </span>
                </a>
            </li>
            <!--========== menu dynamic start =================-->
            <!-- Software Settings menu start -->
            <?php
            $segment1 = $this->uri->segment('1');
            $segment2 = $this->uri->segment('2');
            //        ========= its for all menu =========
            $allmodule = $this->db->select('*')->from('sub_module')->where('status', 1)->group_by('module')->order_by('ordering')->get()->result();
            foreach ($allmodule as $module) {
//                if ($this->permission->module($module->module)->access()) {
                $menu_item = $this->db->select('*')
                                ->from('sub_module')
                                ->where('parent_menu', $module->id)
                                ->where('status', 1)
                                ->get()->result();
                ?>
                <li class="treeview <?php echo $module->name;
//                    foreach ($menu_item as $single) {
//                        $uri = $single->url;
//                        if ($segment1 == ("$uri") || $segment2 == ("$uri")) {
//                            echo "active";
//                        } else {
//                            echo " ";
//                        }
//                    }
                    ?>">
                    <a href="#">
                        <i class="<?php echo $module->icon; ?>"></i><span><?php echo ucwords(str_replace('_', ' ', $module->name)); ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu" id="<?php echo $module->name; ?>">
                        <?php
                        if (!empty($menu_item)) {
                            foreach ($menu_item as $submenu) {
                                $child_menus = $this->db->select('*')
                                                ->from('sub_module a')
                                                ->where('a.parent_menu', $submenu->id)
                                                ->get()->result();
                                ?>
                                <?php
                                if (!empty($child_menus)) {
                                    ?>
                                    <li class="treeview <?php
                                    if ($segment2 == ("voucher_report")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>">
                                        <a href="" style="position: relative;"><?php echo ucwords(str_replace('_', ' ', $submenu->name)); ?>
                                            <span class="pull-right-container">
                                                <i class="fa fa-angle-left pull-right"></i>
                                            </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <?php foreach ($child_menus as $child) { ?>
                                                <li><a href="<?php echo base_url().$child->url; ?>"><?php echo ucwords(str_replace("_", " ", $child->name)) ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } else { ?>
                                    <li><a href="<?php echo base_url().$submenu->url ?>"><?php echo ucwords(str_replace('_', ' ', $submenu->name)); ?></a></li>
                                    <?php
                                }
                            }
                        } else {
                            ?>                                
                            <li><a href="<?php echo base_url() ?>"><?php echo display('manage_company') ?></a></li>
                        <?php }
                        ?>
                    </ul>
                </li>
                <?php
//                }
            }
            ?>
            <!--========== menu dynamic close  =================-->


            <!-- Customer menu start -->
            <?php if ($this->permission1->method('add_customer', 'create')->access() || $this->permission1->method('manage_customer', 'read')->access() || $this->permission1->method('credit_customer', 'read')->access() || $this->permission1->method('paid_customer', 'read')->access()) { ?>
                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Ccustomer")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="fa fa-handshake-o"></i><span><?php echo display('customer') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission1->method('add_customer', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Ccustomer') ?>"><?php echo display('add_customer') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('manage_customer', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Ccustomer/manage_customer') ?>"><?php echo display('manage_customer') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('credit_customer', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Ccustomer/credit_customer') ?>"><?php echo display('credit_customer') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('paid_customer', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Ccustomer/paid_customer') ?>"><?php echo display('paid_customer') ?></a></li>
                        <?php } ?>
                        <li><a href="<?php echo base_url('Ccustomer/paid_customer') ?>"><?php echo display('customer_statement') ?></a></li>
                        <li><a href="<?php echo base_url('Ccustomer/paid_customer') ?>"><?php echo display('emails_and_sms') ?></a></li>   
                    </ul>
                </li>
            <?php } ?>
            <!-- Customer menu end -->
            <!--========== vehicle module start============-->
            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cvehicles")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-car"></i><span><?php echo display('vehicles'); ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cvehicles/add_vehicles') ?>"><?php echo display('add_vehicle'); ?></a></li>
                    <li><a href="<?php echo base_url('Cvehicles/manage_vehicle') ?>"><?php echo display('manage_vehicle'); ?></a></li>   
                </ul>
            </li>
            <!--========== vehicle module close============-->     
            <!--========== calender module start============-->
            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Ccalender")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-calendar"></i><span><?php echo display('calender'); ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Ccalender/calendar') ?>"><?php echo display('calender'); ?></a></li>
                    <li><a href="<?php echo base_url('Ccalender/add_booking') ?>"><?php echo display('add_booking'); ?></a></li>
                    <li><a href="<?php echo base_url('Ccalender/manage_booking') ?>"><?php echo display('manage_booking'); ?></a></li>   
                    <li><a href="<?php echo base_url('Ccalender/add_courtesy_booking') ?>"><?php echo display('courtesy_vehicle_booking'); ?></a></li> 
                    <li><a href="<?php echo base_url('Ccalender/manage_courtesy_booking') ?>"><?php echo display('manage_courtesy_booking'); ?></a></li>   
                </ul>
            </li>
            <!--========== calender module close============-->     
            <!-- Quotation Menu Start -->
            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cquotation")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-book"></i><span><?php echo display('quotation') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cquotation') ?>"><?php echo display('add_quotation') ?></a></li>
                    <li><a href="<?php echo base_url('Cquotation/manage_quotation') ?>"><?php echo display('manage_quotation') ?></a></li>
                </ul>
            </li>
            <!-- quotation Menu end -->
            <!-- job Menu Start -->
            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cjob")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-tasks"></i><span><?php echo display('jobs') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Cjob') ?>"><?php echo display('add_job_order') ?></a></li>    
                    <li><a href="<?php echo base_url('Cjob/manage_job') ?>"><?php echo display('manage_job') ?></a></li>
                    <li><a href="<?php echo base_url('Cjob/add_job_category'); ?>"><?php echo display('add_job_category') ?></a></li>
                    <li><a href="<?php echo base_url('Cjob/add_job_type'); ?>"><?php echo display('add_job_type') ?></a></li>
                    <li><a href="<?php echo base_url('Cjob/manage_job_type') ?>"><?php echo display('manage_job_type') ?></a></li>
                    <li><a href="<?php echo base_url('Cjob/follow_up') ?>"><?php echo display('follow_ups') ?></a></li>
                </ul>
            </li>
            <!-------- job menu close ----->

            <!--========== service module start ============-->
            <?php if ($this->permission1->method('create_service', 'create')->access() || $this->permission1->method('manage_service', 'read')->access() || $this->permission1->method('service_invoice', 'create')->access() || $this->permission1->method('manage_service_invoice', 'read')->access()) { ?>
                <!-- service menu start -->
                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Cservice")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="fa fa-asl-interpreting"></i><span><?php echo display('service') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <!--  <?php if ($this->permission1->method('service_category', 'create')->access()) { ?>
                                                                                                                                                     <li><a href="<?php echo base_url('Cservice/service_category') ?>"><?php echo display('service_category') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('create_service', 'create')->access()) { ?>
                                                                                                                                                     <li><a href="<?php echo base_url('Cservice') ?>"><?php echo display('add_service') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('manage_service', 'read')->access()) { ?>
                                                                                                                                                     <li><a href="<?php echo base_url('Cservice/manage_service') ?>"><?php echo display('manage_service') ?></a></li>
                        <?php } ?>       -->                      
                        <li><a href="<?php echo base_url('Cservice/manage_service_invoice') ?>"><?php echo display('upcoming_service') ?></a></li>
                        <li><a href="<?php echo base_url('Cservice/manage_service_invoice') ?>"><?php echo display('service_reminder') ?></a></li>
                        <li><a href="<?php echo base_url('Cservice/manage_service_invoice') ?>"><?php echo display('overdue_service') ?></a></li>

                        <?php if ($this->permission1->method('service_invoice', 'create')->access()) { ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                    <!--<li><a href="<?php echo base_url('Cservice/service_invoice_form') ?>"><?php echo display('service_invoice') ?></a></li>-->
                        <?php } ?>
                        <?php if ($this->permission1->method('manage_service_invoice', 'read')->access()) { ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                    <!--<li><a href="<?php echo base_url('Cservice/manage_service_invoice') ?>"><?php echo display('manage_service_invoice') ?></a></li>-->
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <!-- service menu end -->

            <!--========== Inspections  module start ============-->
            <?php // if ($this->permission1->method('create_service', 'create')->access() || $this->permission1->method('manage_service', 'read')->access() || $this->permission1->method('service_invoice', 'create')->access() || $this->permission1->method('manage_service_invoice', 'read')->access()) {      ?>
            <!-- service menu start -->
            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cinspection")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-asl-interpreting"></i><span><?php echo display('inspection ') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php // if ($this->permission1->method('service_category', 'create')->access()) {       ?>
                    <li><a href="<?php echo base_url('Cinspection/create_checklist') ?>"><?php echo display('create_checklist') ?></a></li>
                    <?php // }       ?>
                    <li><a href="<?php echo base_url('Cinspection/view_checklist') ?>"><?php echo display('view_checklist') ?></a></li>
                </ul>
            </li>
            <?php // }      ?>
            <!-- service menu end -->

            <!-- Invoice menu start -->
            <?php if ($this->permission1->method('new_invoice', 'create')->access() || $this->permission1->method('manage_invoice', 'read')->access() || $this->permission1->method('pos_invoice', 'create')->access()) { ?>
                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Cinvoice")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="fa fa-balance-scale"></i><span><?php echo display('invoice') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission1->method('new_invoice', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Cinvoice') ?>"><?php echo display('new_invoice') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('manage_invoice', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Cinvoice/manage_invoice') ?>"><?php echo display('manage_invoice') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('pos_invoice', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Cinvoice/pos_invoice') ?>"><?php echo display('pos_invoice') ?></a></li>
                            <!--<li><a href="<?php echo base_url('Cinvoice/gui_pos') ?>"><?php echo display('gui_pos') ?></a></li>-->
                        <?php } ?>
                        <li><a href="<?php echo base_url('Cinvoice/gui_pos') ?>"><?php echo display('recurring_invoice') ?></a></li>
                    </ul>
                </li>
            <?php } ?>
            <!-- Invoice menu end -->
            <!-- --- supplier menu start -->
            <?php if ($this->permission1->method('add_supplier', 'create')->access() || $this->permission1->method('manage_supplier', 'read')->access() || $this->permission1->method('supplier_ledger_report', 'read')->access() || $this->permission1->method('supplier_sales_details_all', 'read')->access()) { ?>
                <!-- Supplier menu start -->
                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Csupplier")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="ti-user"></i><span><?php echo display('supplier') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission1->method('add_supplier', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Csupplier') ?>"><?php echo display('add_supplier') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('manage_supplier', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Csupplier/manage_supplier') ?>"><?php echo display('manage_supplier') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('supplier_ledger_report', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Csupplier/supplier_ledger_report') ?>"><?php echo display('supplier_ledger') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('supplier_sales_details_all', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Csupplier/supplier_sales_details_all') ?>"><?php echo display('supplier_sales_details') ?></a></li> 
                        <?php } ?>
                        <li><a href="<?php echo base_url('Csupplier/supplier_sales_details_all') ?>"><?php echo display('supplier_credit_note') ?></a></li> 
                    </ul>
                </li>
            <?php } ?>
            <!-- Supplier menu end -->       
            <!-- inventory menu start -->
            <?php if ($this->permission1->method('create_product', 'create')->access() || $this->permission1->method('add_product_csv', 'create')->access() || $this->permission1->method('manage_product', 'read')->access()) { ?>
                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Cproduct") || $this->uri->segment('1') == ("Ccategory")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="ti-bag"></i><span><?php echo display('inventory') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission1->method('create_category', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Ccategory') ?>"><?php echo display('add_category') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('manage_category', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Ccategory/manage_category') ?>"><?php echo display('manage_category') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('create_product', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Cproduct') ?>"><?php echo display('add_product') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('add_product_csv', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Cproduct/add_product_csv') ?>"><?php echo display('import_product_csv') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('manage_product', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Cproduct/manage_product') ?>"><?php echo display('manage_product') ?></a></li>
                        <?php } ?>
                        <li><a href="<?php echo base_url('Cproduct/manage_product') ?>"><?php echo display('group_pricing') ?></a></li>  
                    </ul>
                </li>
            <?php } ?>
            <!-- inventory menu end -->
            <!-- Purchase menu start -->
            <?php if ($this->permission1->method('add_purchase', 'create')->access() || $this->permission1->method('manage_purchase', 'read')->access()) { ?>
                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Cpurchase")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="ti-shopping-cart"></i><span><?php echo display('purchase') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission1->method('add_purchase', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Cpurchase') ?>"><?php echo display('add_purchase') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('manage_purchase', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Cpurchase/manage_purchase') ?>"><?php echo display('manage_purchase') ?></a></li>
                        <?php } ?>                            
                        <li><a href="<?php echo base_url('Cpurchase/add_bills') ?>"><?php echo display('add_bills') ?></a></li>
                        <li><a href="<?php echo base_url('Cpurchase/bill_payment') ?>"><?php echo display('bill_payment') ?></a></li>
                    </ul>
                </li>
            <?php } ?>
            <!-- purchase menu close -->

            <!-- human resource management menu start -->
            <?php if ($this->permission1->method('add_designation', 'create')->access() || $this->permission1->method('manage_designation', 'read')->access() || $this->permission1->method('add_employee', 'create')->access() || $this->permission1->method('manage_employee', 'read')->access()) { ?>
                <!-- Supplier menu start -->
                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Chrm")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="fa fa-users"></i><span><?php echo display('hrm') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission1->method('add_designation', 'create')->access()) { ?>     
                            <li><a href="<?php echo base_url('Chrm/add_designation') ?>"><?php echo display('add_designation') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('manage_designation', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Chrm/manage_designation') ?>"><?php echo display('manage_designation') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('add_employee', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Chrm/add_employee') ?>"><?php echo display('add_employee') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('manage_employee', 'read')->access()) { ?>        
                            <li><a href="<?php echo base_url('Chrm/manage_employee') ?>"><?php echo display('manage_employee') ?></a></li> 
                        <?php } ?> 

                    </ul>
                </li>
            <?php } ?>
            <!-- Human resource management menu end -->
            <!-- start return -->
            <?php if ($this->permission1->method('add_return', 'create')->access() || $this->permission1->method('return_list', 'read')->access() || $this->permission1->method('supplier_return_list', 'read')->access() || $this->permission1->method('wastage_return_list', 'read')->access()) { ?>
                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Cretrun_m")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="fa fa-retweet" aria-hidden="true"></i><span><?php echo display('return'); ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission1->method('add_return', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Cretrun_m') ?>"><?php echo display('return'); ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('return_list', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Cretrun_m/return_list') ?>"><?php echo display('stock_return_list') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('supplier_return_list', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Cretrun_m/supplier_return_list') ?>"><?php echo display('supplier_return_list') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('wastage_return_list', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Cretrun_m/wastage_return_list') ?>"><?php echo display('wastage_return_list') ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <!-- Stock menu start -->
            <?php if ($this->permission1->method('stock_report', 'read')->access() || $this->permission1->method('stock_report_sp_wise', 'read')->access() || $this->permission1->method('stock_report_pro_wise', 'read')->access()) { ?>
                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Creport")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="ti-book"></i><span><?php echo display('stock') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission1->method('stock_report', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Creport') ?>"><?php echo display('stock_report') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('stock_report_pro_wise', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Creport/stock_report_product_wise') ?>"><?php echo display('stock_report_product_wise') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('stock_report_sp_wise', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Creport/stock_report_supplier_wise') ?>"><?php echo display('stock_report_supplier_wise') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('stock_take', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Creport/stock_take') ?>"><?php echo display('stock_take') ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <!-- Stock menu end -->
            <!-- Report menu start -->
            <?php if ($this->permission1->method('add_closing', 'create')->access() || $this->permission1->method('closing_report', 'read')->access() || $this->permission1->method('all_report', 'read')->access() || $this->permission1->method('todays_customer_receipt', 'read')->access() || $this->permission1->method('todays_sales_report', 'read')->access() || $this->permission1->method('retrieve_dateWise_DueReports', 'read')->access() || $this->permission1->method('todays_purchase_report', 'read')->access() || $this->permission1->method('purchase_report_category_wise', 'read')->access() || $this->permission1->method('product_sales_reports_date_wise', 'read')->access() || $this->permission1->method('sales_report_category_wise', 'read')->access() || $this->permission1->method('shipping_cost_report', 'read')->access()) { ?>
                <li class="treeview <?php
                if ($this->uri->segment('2') == ("all_report") || $this->uri->segment('2') == ("todays_sales_report") || $this->uri->segment('2') == ("todays_purchase_report") || $this->uri->segment('2') == ("product_sales_reports_date_wise") || $this->uri->segment('2') == ("total_profit_report") || $this->uri->segment('2') == ("purchase_report_category_wise") || $this->uri->segment('2') == ("sales_report_category_wise") || $this->uri->segment('2') == ("filter_purchase_report_category_wise") || $this->uri->segment('2') == ("sales_report_category_wise") || $this->uri->segment('2') == ("todays_customer_receipt") || $this->uri->segment('2') == ("filter_sales_report_category_wise") || $this->uri->segment('2') == ("filter_customer_wise_receipt") || $this->uri->segment('2') == ("closing") || $this->uri->segment('2') == ("closing_report") || $this->uri->segment('2') == ("date_wise_closing_reports") || $this->uri->segment('2') == ("retrieve_dateWise_Shippingcost") || $this->uri->segment('2') == ("product_sales_search_reports") || $this->uri->segment('2') == ("user_sales_report") || $this->uri->segment('2') == ("retrieve_dateWise_DueReports") || $this->uri->segment('2') == ("sales_return") || $this->uri->segment('2') == ("supplier_return") || $this->uri->segment('2') == ("retrieve_dateWise_tax")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="ti-bar-chart"></i><span><?php echo display('report') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission1->method('add_closing', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Admin_dashboard/closing') ?>"><?php echo display('closing') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('closing_report', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Admin_dashboard/closing_report') ?>"><?php echo display('closing_report') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('all_report', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Admin_dashboard/all_report') ?>"><?php echo display('todays_report') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('todays_customer_receipt', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Admin_dashboard/todays_customer_receipt') ?>"><?php echo display('todays_customer_receipt') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('todays_sales_report', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Admin_dashboard/todays_sales_report') ?>"><?php echo display('sales_report') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('retrieve_dateWise_DueReports', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Admin_dashboard/retrieve_dateWise_DueReports') ?>"><?php echo display('due_report'); ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('shipping_cost_report', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Admin_dashboard/retrieve_dateWise_Shippingcost') ?>"><?php echo display('shipping_cost_report'); ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('todays_purchase_report', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Admin_dashboard/todays_purchase_report') ?>"><?php echo display('purchase_report') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('purchase_report_category_wise', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Admin_dashboard/purchase_report_category_wise') ?>"><?php echo display('purchase_report_category_wise') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('product_sales_reports_date_wise', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Admin_dashboard/product_sales_reports_date_wise') ?>"><?php echo display('sales_report_product_wise') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('sales_report_category_wise', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Admin_dashboard/sales_report_category_wise') ?>"><?php echo display('sales_report_category_wise') ?></a></li>
                        <?php } ?>
                        <li class="treeview <?php
                        if ($this->uri->segment('2') == ("voucher_report")) {
                            echo "active";
                        } else {
                            echo " ";
                        }
                        ?>">
                            <a href=""style="position: relative;"><?php echo display('employee_reports') ?>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if ($this->permission1->method('productivity_report', 'create')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cemployee/productivity_report') ?>"><?php echo display('productivity_report') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('efficiency_report', 'read')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cemployee/efficiency_report') ?>"><?php echo display('efficiency_report') ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="treeview <?php
                        if ($this->uri->segment('2') == ("voucher_report")) {
                            echo "active";
                        } else {
                            echo " ";
                        }
                        ?>">
                            <a href=""style="position: relative;"><?php echo display('expense_reports') ?>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if ($this->permission1->method('bills_report', 'create')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cexpense/bills_report') ?>"><?php echo display('bills_report') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('purchase_report', 'read')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cexpense/purchase_report') ?>"><?php echo display('purchase_report') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('supplier_reports', 'read')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cexpense/supplier_reports') ?>"><?php echo display('supplier_reports') ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="treeview <?php
                        if ($this->uri->segment('2') == ("voucher_report") || $this->uri->segment('2') == ("cash_book") || $this->uri->segment('2') == ("bank_book") || $this->uri->segment('2') == ("general_ledger") || $this->uri->segment('2') == ("trial_balance") || $this->uri->segment('2') == ("profit_loss_report") || $this->uri->segment('2') == ("cash_flow_report") || $this->uri->segment('2') == ("inventory_ledger") || $this->uri->segment('2') == ("coa_print")) {
                            echo "active";
                        } else {
                            echo " ";
                        }
                        ?>">
                            <a href=""style="position: relative;"><?php echo display('income_report') ?>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if ($this->permission1->method('received_payment', 'create')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cincome/received_payment') ?>"><?php echo display('received_payment') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('income_job_type', 'read')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cincome/income_job_type') ?>"><?php echo display('income_job_type') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('income_paid_unpaid', 'read')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cincome/income_paid_unpaid') ?>"><?php echo display('income_paid_unpaid') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('invoice_report', 'read')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cincome/invoice_report') ?>"><?php echo display('invoice_report') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('sales_report', 'read')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cincome/sales_report') ?>"><?php echo display('sales_report') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('customer_statement', 'read')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cincome/customer_statement') ?>"><?php echo display('customer_statement') ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="treeview <?php
                        if ($this->uri->segment('2')) {
                            echo "active";
                        } else {
                            echo " ";
                        }
                        ?>">
                            <a href=""style="position: relative;"><?php echo display('inventory_report') ?>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if ($this->permission1->method('buying_report', 'create')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cinventory/buying_report') ?>"><?php echo display('buying_report') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('stock_value_report', 'read')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cinventory/stock_value_report') ?>"><?php echo display('stock_value_report') ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="treeview <?php
                        if ($this->uri->segment('2')) {
                            echo "active";
                        } else {
                            echo " ";
                        }
                        ?>">
                            <a href=""style="position: relative;"><?php echo display('work_report') ?>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if ($this->permission1->method('progress_job_report', 'create')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cworkreport/progress_job_report') ?>"><?php echo display('progress_job_report') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('progress_invoice_report', 'create')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cworkreport/progress_invoice_report') ?>"><?php echo display('progress_invoice_report') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('workshop_efficiency_report', 'read')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cworkreport/workshop_efficiency_report') ?>"><?php echo display('workshop_efficiency_report') ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>

                    </ul>
                </li>
            <?php } ?>
            <!-- employee reports menu start -->
            <?php if ($this->permission1->method('productivity_report', 'create')->access() || $this->permission1->method('efficiency_report', 'read')->access()) { ?>
                <!--                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Cemployee")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                                    <a href="#">
                                        <i class="ti-shopping-cart"></i><span><?php echo display('employee_reports') ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                <?php if ($this->permission1->method('productivity_report', 'create')->access()) { ?>
                                                                                                                                                                                            <li><a href="<?php echo base_url('Cemployee/productivity_report') ?>"><?php echo display('productivity_report') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('efficiency_report', 'read')->access()) { ?>
                                                                                                                                                                                            <li><a href="<?php echo base_url('Cemployee/efficiency_report') ?>"><?php echo display('efficiency_report') ?></a></li>
                <?php } ?>
                                    </ul>
                                </li>-->
            <?php } ?>
            <!-- employee reports menu close -->
            <!-- expense reports menu start -->
            <?php if ($this->permission1->method('bills_report', 'create')->access() || $this->permission1->method('purchase_report', 'read')->access() || $this->permission1->method('supplier_reports', 'read')->access()) { ?>
                <!--                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Cexpense")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                                    <a href="#">
                                        <i class="ti-shopping-cart"></i><span><?php echo display('expense_reports') ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                <?php if ($this->permission1->method('bills_report', 'create')->access()) { ?>
                                                                                                                                                                                        <li><a href="<?php echo base_url('Cexpense/bills_report') ?>"><?php echo display('bills_report') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('purchase_report', 'read')->access()) { ?>
                                                                                                                                                                                        <li><a href="<?php echo base_url('Cexpense/purchase_report') ?>"><?php echo display('purchase_report') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('supplier_reports', 'read')->access()) { ?>
                                                                                                                                                                                        <li><a href="<?php echo base_url('Cexpense/supplier_reports') ?>"><?php echo display('supplier_reports') ?></a></li>
                <?php } ?>
                                    </ul>
                                </li>-->
            <?php } ?>
            <!-- expense reports menu close -->
            <!-- income reports menu start -->
            <?php if ($this->permission1->method('received_payment', 'create')->access() || $this->permission1->method('income_job_type', 'read')->access() || $this->permission1->method('invoice_report', 'read')->access() || $this->permission1->method('sales_report', 'read')->access() || $this->permission1->method('customer_statement', 'read')->access()) { ?>
                <!--                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Cincome")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                                    <a href="#">
                                        <i class="ti-shopping-cart"></i><span><?php echo display('income_report') ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                <?php if ($this->permission1->method('received_payment', 'create')->access()) { ?>
                                                                                                                                                                                    <li><a href="<?php echo base_url('Cincome/received_payment') ?>"><?php echo display('received_payment') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('income_job_type', 'read')->access()) { ?>
                                                                                                                                                                                    <li><a href="<?php echo base_url('Cincome/income_job_type') ?>"><?php echo display('income_job_type') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('income_paid_unpaid', 'read')->access()) { ?>
                                                                                                                                                                                    <li><a href="<?php echo base_url('Cincome/income_paid_unpaid') ?>"><?php echo display('income_paid_unpaid') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('invoice_report', 'read')->access()) { ?>
                                                                                                                                                                                    <li><a href="<?php echo base_url('Cincome/invoice_report') ?>"><?php echo display('invoice_report') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('sales_report', 'read')->access()) { ?>
                                                                                                                                                                                    <li><a href="<?php echo base_url('Cincome/sales_report') ?>"><?php echo display('sales_report') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('customer_statement', 'read')->access()) { ?>
                                                                                                                                                                                    <li><a href="<?php echo base_url('Cincome/customer_statement') ?>"><?php echo display('customer_statement') ?></a></li>
                <?php } ?>
                                    </ul>
                                </li>-->
            <?php } ?>
            <!-- income reports menu close -->
            <!-- inventory report menu start -->
            <?php if ($this->permission1->method('buying_report', 'create')->access() || $this->permission1->method('stock_value_report', 'create')->access()) { ?>
                <!--                <li class="treeview <?php
//                if ($this->uri->segment('1') == ("Cinventory")) {
//                    echo "active";
//                } else {
//                    echo " ";
//                }
                ?>">
                                    <a href="#">
                                        <i class="ti-bag"></i><span><?php echo display('inventory_report') ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                <?php if ($this->permission1->method('buying_report', 'create')->access()) { ?>
                                                                                                                                                                            <li><a href="<?php echo base_url('Cinventory/buying_report') ?>"><?php echo display('buying_report') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('stock_value_report', 'read')->access()) { ?>
                                                                                                                                                                            <li><a href="<?php echo base_url('Cinventory/stock_value_report') ?>"><?php echo display('stock_value_report') ?></a></li>
                <?php } ?>
                                    </ul>
                                </li>-->
            <?php } ?>
            <!-- inventory report menu end -->
            <!-- work reports menu start -->
            <?php if ($this->permission1->method('productivity_report', 'create')->access() || $this->permission1->method('efficiency_report', 'read')->access()) { ?>
                <!--                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Cworkreport")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                                    <a href="#">
                                        <i class="ti-shopping-cart"></i><span><?php echo display('work_report') ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                <?php if ($this->permission1->method('progress_job_report', 'create')->access()) { ?>
                                                                                                                                                                        <li><a href="<?php echo base_url('Cworkreport/progress_job_report') ?>"><?php echo display('progress_job_report') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('progress_invoice_report', 'create')->access()) { ?>
                                                                                                                                                                        <li><a href="<?php echo base_url('Cworkreport/progress_invoice_report') ?>"><?php echo display('progress_invoice_report') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('workshop_efficiency_report', 'read')->access()) { ?>
                                                                                                                                                                        <li><a href="<?php echo base_url('Cworkreport/workshop_efficiency_report') ?>"><?php echo display('workshop_efficiency_report') ?></a></li>
                <?php } ?>
                                    </ul>
                                </li>-->
            <?php } ?>
            <!-- work reports menu close -->







            <!-- Bank menu start -->
            <?php if ($this->permission1->method('add_bank', 'create')->access() || $this->permission1->method('bank_transaction', 'create')->access() || $this->permission1->method('bank_list', 'read')->access()) { ?>
                <li class="treeview <?php
                if ($this->uri->segment('2') == ("index") || $this->uri->segment('2') == ("bank_list") || $this->uri->segment('2') == ("bank_ledger") || $this->uri->segment('2') == ("bank_transaction")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="ti-briefcase"></i><span><?php echo display('bank') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission1->method('add_bank', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Csettings/index') ?>"><?php echo display('add_new_bank') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('bank_transaction', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Csettings/bank_transaction') ?>"><?php echo display('bank_transaction') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('bank_list', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Csettings/bank_list') ?>"><?php echo display('manage_bank') ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <!-- Bank menu end -->
            <!--New Account start-->
            <?php if ($this->permission1->method('show_tree', 'read')->access() || $this->permission1->method('supplier_payment', 'create')->access() || $this->permission1->method('customer_receive', 'create')->access() || $this->permission1->method('debit_voucher', 'create')->access() || $this->permission1->method('credit_voucher', 'create')->access() || $this->permission1->method('aprove_v', 'read')->access() || $this->permission1->method('contra_voucher', 'create')->access() || $this->permission1->method('journal_voucher', 'create')->access()) { ?>
                <li class="treeview <?php
                if ($this->uri->segment('1') == ("accounts")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="fa fa-money"></i><span><?php echo display('accounts') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission1->method('show_tree', 'read')->access()) { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('2') == ("show_tree")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('accounts/show_tree') ?>"><?php echo display('c_o_a'); ?></a></li>
                            <?php } ?>
                            <?php if ($this->permission1->method('supplier_payment', 'create')->access()) { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('2') == ("supplier_payment")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('accounts/supplier_payment') ?>"><?php echo display('supplier_payment'); ?></a></li>
                            <?php } ?>
                            <?php if ($this->permission1->method('customer_receive', 'create')->access()) { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('2') == ("customer_receive")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('accounts/customer_receive') ?>"><?php echo display('customer_receive'); ?></a></li>
                            <?php } ?>
                            <?php if ($this->permission1->method('debit_voucher', 'create')->access()) { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('2') == ("debit_voucher")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('accounts/debit_voucher') ?>"><?php echo display('debit_voucher') ?></a></li>
                            <?php } ?>
                            <?php if ($this->permission1->method('credit_voucher', 'create')->access()) { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('2') == ("credit_voucher")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('accounts/credit_voucher') ?>"><?php echo display('credit_voucher'); ?></a></li>
                            <?php } ?>
                            <?php if ($this->permission1->method('aprove_v', 'read')->access()) { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('2') == ("aprove_v")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('accounts/aprove_v') ?>"><?php echo display('voucher_approval'); ?></a></li> 
                            <?php } ?>
                            <?php if ($this->permission1->method('contra_voucher', 'create')->access()) { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('2') == ("contra_voucher")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('accounts/contra_voucher') ?>"><?php echo display('contra_voucher'); ?></a></li>
                            <?php } ?>
                            <?php if ($this->permission1->method('journal_voucher', 'create')->access()) { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('2') == ("journal_voucher")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('accounts/journal_voucher') ?>"><?php echo display('journal_voucher'); ?></a></li> 
                            <?php } ?>
                            <?php if ($this->permission1->method('ac_report', 'create')->access()) { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('2') == ("voucher_report") || $this->uri->segment('2') == ("cash_book") || $this->uri->segment('2') == ("bank_book") || $this->uri->segment('2') == ("general_ledger") || $this->uri->segment('2') == ("trial_balance") || $this->uri->segment('2') == ("profit_loss_report") || $this->uri->segment('2') == ("cash_flow_report") || $this->uri->segment('2') == ("inventory_ledger") || $this->uri->segment('2') == ("coa_print")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href=""style="position: relative;"><?php echo display('report') ?>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <!--       <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("voucher_report")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('accounts/voucher_report') ?>"><?php echo 'Voucher Report' ?></a></li> -->
                                    <?php if ($this->permission1->method('cash_book', 'read')->access()) { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('2') == ("cash_book")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('accounts/cash_book') ?>"><?php echo display('cash_book'); ?></a></li>
                                        <?php } ?>
                                        <?php if ($this->permission1->method('inventory_ledger', 'read')->access()) { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('2') == ("inventory_ledger")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('accounts/inventory_ledger') ?>"><?php echo display('Inventory_ledger'); ?></a></li>
                                        <?php } ?>
                                        <?php if ($this->permission1->method('bank_book', 'read')->access()) { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('2') == ("bank_book")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('accounts/bank_book') ?>"><?php echo display('bank_book'); ?></a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($this->permission1->method('general_ledger', 'read')->access()) { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('2') == ("general_ledger")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('accounts/general_ledger') ?>"><?php echo display('general_ledger'); ?></a></li>
                                        <?php } ?>
                                        <?php if ($this->permission1->method('trial_balance', 'read')->access()) { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('2') == ("trial_balance")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('accounts/trial_balance') ?>"><?php echo display('trial_balance'); ?></a></li>
                                        <?php } ?>
                                    <!--  <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("profit_loss_report")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('accounts/profit_loss_report') ?>"><?php echo display('profit_loss'); ?></a></li> -->
                                    <?php if ($this->permission1->method('cash_flow_report', 'read')->access()) { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('2') == ("cash_flow_report")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('accounts/cash_flow_report') ?>"><?php echo display('cash_flow'); ?></a></li>
                                        <?php } ?>
                                        <?php if ($this->permission1->method('coa_print', 'read')->access()) { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('2') == ("coa_print")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('accounts/coa_print') ?>"><?php echo display('coa_print'); ?></a></li>
                                        <?php } ?>
                                </ul>   

                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <!-- New Account End -->
            <!-- Synchronizer setting start -->
            <?php if ($this->permission1->method('back_up', 'create')->access() || $this->permission1->method('back_up', 'read')->access()) { ?>
                <li class="treeview <?php
                if ($this->uri->segment('2') == ("form") || $this->uri->segment('2') == ("synchronize") || $this->uri->segment('1') == ("Backup_restore")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="ti-reload"></i><span><?php echo display('data_synchronisation') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php
                        $localhost = false;
                        if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', 'localhost'))) {
                            ?>
                                                                                                                                                                                                                <!--<li><a href="<?php echo base_url('data_synchronizer/form') ?>"><?php echo display('setting') ?></a></li>-->
                            <?php
                        }
                        ?>
                        <li><a href="<?php echo base_url('data_synchronizer/synchronize') ?>"><?php echo display('synchronize') ?></a></li>
                        <?php if ($this->permission1->method('back_up', 'create')->access() || $this->permission1->method('back_up', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Backup_restore') ?>"><?php echo display('backup_restore') ?></a></li>
                        <?php } ?>
                        <li><a href="<?php echo base_url('Backup_restore/import_form') ?>"><?php echo display('import') ?></a></li>
                    </ul>
                </li>
            <?php } ?>
            <!-- Synchronizer setting end -->
            <!-- Software Settings menu start -->
            <?php if ($this->permission1->method('manage_company', 'read')->access() || $this->permission1->method('manage_company', 'create')->access() || $this->permission1->method('add_user', 'create')->access() || $this->permission1->method('manage_user', 'read')->access() || $this->permission1->method('add_language', 'create')->access() || $this->permission1->method('add_currency', 'create')->access() || $this->permission1->method('soft_setting', 'create')->access()) { ?>
                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Company_setup") || $this->uri->segment('1') == ("User") || $this->uri->segment('1') == ("Cweb_setting") || $this->uri->segment('1') == ("Language") || $this->uri->segment('1') == ("Currency")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="ti-settings"></i><span><?php echo display('web_settings') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if ($this->permission1->method('manage_company', 'read')->access() || $this->permission1->method('manage_company', 'update')->access()) { ?>
                            <li><a href="<?php echo base_url('Company_setup/manage_company') ?>"><?php echo display('manage_company') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('add_user', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('User') ?>"><?php echo display('add_user') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('manage_user', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('User/manage_user') ?>"><?php echo display('manage_users') ?> </a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('add_language', 'create')->access() || $this->permission1->method('add_language', 'update')->access()) { ?>
                            <li><a href="<?php echo base_url('Language') ?>"><?php echo display('language') ?> </a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('add_currency', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Currency') ?>"><?php echo display('currency') ?> </a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('soft_setting', 'create')->access() || $this->permission1->method('soft_setting', 'update')->access()) { ?>
                            <li><a href="<?php echo base_url('Cweb_setting') ?>"><?php echo display('setting') ?> </a></li>
                        <?php } ?>
                        <li><a href="<?php echo base_url('Cweb_setting/paypal_setting') ?>"><?php echo display('paypal_setting') ?> </a></li>
                        <li><a href="<?php echo base_url('Cweb_setting') ?>"><?php echo display('data_export') ?> </a></li>
                        <li class="treeview <?php
                        if ($this->uri->segment('2') == ("voucher_report") || $this->uri->segment('2') == ("cash_book") || $this->uri->segment('2') == ("bank_book") || $this->uri->segment('2') == ("general_ledger") || $this->uri->segment('2') == ("trial_balance") || $this->uri->segment('2') == ("profit_loss_report") || $this->uri->segment('2') == ("cash_flow_report") || $this->uri->segment('2') == ("inventory_ledger") || $this->uri->segment('2') == ("coa_print")) {
                            echo "active";
                        } else {
                            echo " ";
                        }
                        ?>">
                            <a href=""style="position: relative;"><?php echo display('tax') ?>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                        <!--<li><a href="<?php echo base_url('Caccounts/tax_settings') ?>"><?php echo display('tax_settings') ?></a></li>-->
                                <?php if ($this->permission1->method('add_tax', 'create')->access()) { ?>
                                    <li><a href="<?php echo base_url('Caccounts/add_tax') ?>"><?php echo display('add_tax') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('manage_tax', 'read')->access()) { ?>
                                    <li><a href="<?php echo base_url('Caccounts/manage_tax') ?>"><?php echo display('manage_tax') ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('add_incometax', 'create')->access()) { ?>
                                    <!--<li><a href="<?php echo base_url('Caccounts/add_incometax') ?>"><?php echo display('add_incometax') ?></a></li>-->
                                <?php } ?>
                                <?php if ($this->permission1->method('manage_income_tax', 'read')->access()) { ?>
                                    <!--<li><a href="<?php echo base_url('Caccounts/manage_income_tax') ?>"><?php echo display('manage_income_tax') ?></a></li>-->
                                <?php } ?>
                                <?php if ($this->permission1->method('tax_report', 'read')->access()) { ?>    
                                    <!--<li><a href="<?php echo base_url('Caccounts/tax_report') ?>"><?php echo display('tax_report') ?></a></li>-->
                                <?php } ?>
                                <?php if ($this->permission1->method('invoice_wise_tax_report', 'read')->access()) { ?>
                                    <!--<li><a href="<?php echo base_url('Caccounts/invoice_wise_tax_report') ?>"><?php echo display('invoice_wise_tax_report') ?></a></li>-->
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="treeview <?php
                        if ($this->uri->segment('2') == ("voucher_report") || $this->uri->segment('2') == ("cash_book") || $this->uri->segment('2') == ("bank_book") || $this->uri->segment('2') == ("general_ledger") || $this->uri->segment('2') == ("trial_balance") || $this->uri->segment('2') == ("profit_loss_report") || $this->uri->segment('2') == ("cash_flow_report") || $this->uri->segment('2') == ("inventory_ledger") || $this->uri->segment('2') == ("coa_print")) {
                            echo "active";
                        } else {
                            echo " ";
                        }
                        ?>">
                            <a href=""style="position: relative;"><?php echo display('unit') ?>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if ($this->permission1->method('add_unit', 'create')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cunit'); ?>"><?php echo display('add_unit'); ?></a></li>
                                <?php } ?>
                                <?php if ($this->permission1->method('manage_unit', 'create')->access()) { ?>
                                    <li><a href="<?php echo base_url('Cunit/manage_unit'); ?>"><?php echo display('manage_unit'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <!-- Software Settings menu end -->
            <!-- Tax menu start -->
            <?php if ($this->permission1->method('add_tax', 'create')->access() || $this->permission1->method('manage_tax', 'read')->access() || $this->permission1->method('add_incometax', 'create')->access() || $this->permission1->method('manage_income_tax', 'read')->access() || $this->permission1->method('tax_settings', 'create')->access() || $this->permission1->method('tax_report', 'read')->access() || $this->permission1->method('invoice_wise_tax_report', 'read')->access()) { ?>
                <!--                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Caccounts") || $this->uri->segment('1') == ("Account_Controller") || $this->uri->segment('1') == ("Cpayment")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                                    <a href="#">
                                        <i class="fa fa-money"></i><span><?php echo display('tax') ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="<?php echo base_url('Caccounts/tax_settings') ?>"><?php echo display('tax_settings') ?></a></li>
                <?php if ($this->permission1->method('add_tax', 'create')->access()) { ?>
                                                                                                                                                                                            <li><a href="<?php echo base_url('Caccounts/add_tax') ?>"><?php echo display('add_tax') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('manage_tax', 'read')->access()) { ?>
                                                                                                                                                                                            <li><a href="<?php echo base_url('Caccounts/manage_tax') ?>"><?php echo display('manage_tax') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('add_incometax', 'create')->access()) { ?>
                                                                                                                                                                                            <li><a href="<?php echo base_url('Caccounts/add_incometax') ?>"><?php echo display('add_incometax') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('manage_income_tax', 'read')->access()) { ?>
                                                                                                                                                                                            <li><a href="<?php echo base_url('Caccounts/manage_income_tax') ?>"><?php echo display('manage_income_tax') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('tax_report', 'read')->access()) { ?>    
                                                                                                                                                                                            <li><a href="<?php echo base_url('Caccounts/tax_report') ?>"><?php echo display('tax_report') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('invoice_wise_tax_report', 'read')->access()) { ?>
                                                                                                                                                                                            <li><a href="<?php echo base_url('Caccounts/invoice_wise_tax_report') ?>"><?php echo display('invoice_wise_tax_report') ?></a></li>
                <?php } ?>
                                    </ul>
                                </li>-->
            <?php } ?>
            <!-- tax  menu End -->
            <!--Unit menu start--> 
            <?php if ($this->permission1->method('add_unit', 'create')->access() || $this->permission1->method('manage_unit', 'read')->access()) { ?>
                <!--                <li class="treeview<?php
                if ($this->uri->segment('1') == ("Cunit")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                                    <a href="#">
                                        <i class="fa fa-universal-access""></i><span><?php echo display('unit'); ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                <?php if ($this->permission1->method('add_unit', 'create')->access()) { ?>
                                                                                                                                                                                            <li><a href="<?php echo base_url('Cunit'); ?>"><?php echo display('add_unit'); ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('manage_unit', 'create')->access()) { ?>
                                                                                                                                                                                            <li><a href="<?php echo base_url('Cunit/manage_unit'); ?>"><?php echo display('manage_unit'); ?></a></li>
                <?php } ?>
                                    </ul>
                                </li>-->
            <?php } ?>
            <!--Unit menu close-->  
            <!-- Role permission start -->
            <?php if ($this->permission1->method('add_role', 'create')->access() || $this->permission1->method('role_list', 'read')->access() || $this->permission1->method('user_assign', 'create')->access()) { ?>
                <li  class="treeview <?php
                if ($this->uri->segment('1') == ("Permission")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="ti-key"></i><span><?php echo display('role_permission') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url('Permission/module_form') ?>"><?php echo display('add_module') ?></a></li>
                        <li><a href="<?php echo base_url('Permission/menu_form') ?>"><?php echo display('add_menu') ?></a></li>  
                        <?php if ($this->permission1->method('add_role', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Permission/add_role') ?>"><?php echo display('add_role') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('role_list', 'read')->access()) { ?>
                            <li><a href="<?php echo base_url('Permission/role_list') ?>"><?php echo display('role_list') ?></a></li>
                        <?php } ?>
                        <?php if ($this->permission1->method('user_assign', 'create')->access()) { ?>
                            <li><a href="<?php echo base_url('Permission/user_assign') ?>"><?php echo display('user_assign_role') ?></a></li>
                        <?php } ?>
    <!--  <li><a href="<?php echo base_url('Permission') ?>"><?php echo display('permission') ?></a></li> -->
                    </ul>
                </li>
            <?php } ?>
            <!-- Role permission End -->
            <!-- support permission start -->
            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Csupport")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-question-circle"></i><span><?php echo display('support'); ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('Csms/configure') ?>"><?php echo display('customer_portal'); ?></a></li>
                    <li><a href="<?php echo base_url('Csms/configure') ?>"><?php echo display('mechanic_portal'); ?></a></li>
                    <li><a href="<?php echo base_url('Csms/configure') ?>"><?php echo display('super_admin_portal'); ?></a></li>
                </ul>
            </li>
            <!-- support permission end -->

            <!-- Shedule menu start -->  
            <!--            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cshedule")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                            <a href="#">
                                <i class="fa fa-calendar"></i><span><?php echo display('schedule') ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
            
                                <li><a href="<?php echo base_url('Cpurchase') ?>"><?php echo display('add_booking') ?></a></li>
            
                                <li><a href="<?php echo base_url('Cpurchase/manage_purchase') ?>"><?php echo display('manage_booking') ?></a></li>
                                <li><a href="<?php echo base_url('Cpurchase/manage_purchase') ?>"><?php echo display('online_booking') ?></a></li>
                                <li><a href="<?php echo base_url('Cpurchase/manage_purchase') ?>"><?php echo display('courtesy_vehicle_bookings') ?></a></li>
            
                            </ul>
                        </li>-->






            <!-- Comission start -->
            <?php if ($this->permission1->method('commission', 'create')->access() || $this->permission1->method('commission', 'read')->access()) { ?>
                <!--                <li class="treeview <?php
                if ($this->uri->segment('2') == ("commission") || $this->uri->segment('2') == ("commission_generate")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                                    <a href="#">
                                        <i class="ti-layout-grid2"></i><span><?php echo display('commission') ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                <?php if ($this->permission1->method('commission', 'read')->access()) { ?>
                                                                                                                                                                                                                <li><a href="<?php echo base_url('Csettings/commission') ?>"><?php echo display('generate_commission') ?></a></li>
                <?php } ?>
                                    </ul>
                                </li>-->
            <?php } ?>
            <!-- Comission end -->

            <!-- Office loan start -->
            <?php if ($this->permission1->method('add1_person', 'create')->access() || $this->permission1->method('add_office_loan', 'create')->access() || $this->permission1->method('add_loan_payment', 'create')->access() || $this->permission1->method('manage1_person', 'read')->access()) { ?>
                <!--                <li class="treeview <?php
                if ($this->uri->segment('1') == ("Cloan") && $this->uri->segment('2') == ("add1_person") || $this->uri->segment('2') == ("manage1_person") || $this->uri->segment('2') == ("person_ledger") || $this->uri->segment('2') == ("add_office_loan") || $this->uri->segment('2') == ("add_loan_payment")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                                    <a href="#">
                                        <i class="fa fa-university" aria-hidden="true"></i>
                
                                        <span><?php echo display('office_loan') ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                <?php if ($this->permission1->method('add1_person', 'create')->access()) { ?>
                                                                                                                                                                                                                <li><a href="<?php echo base_url('Cloan/add1_person') ?>"><?php echo display('add_person') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('add_office_loan', 'create')->access()) { ?>
                                                                                                                                                                                                                <li><a href="<?php echo base_url('Cloan/add_office_loan') ?>"><?php echo display('add_loan') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('add_loan_payment', 'create')->access()) { ?>
                                                                                                                                                                                                                <li><a href="<?php echo base_url('Cloan/add_loan_payment') ?>"><?php echo display('add_payment') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('manage1_person', 'read')->access()) { ?>
                                                                                                                                                                                                                <li><a href="<?php echo base_url('Cloan/manage1_person') ?>"><?php echo display('manage_loan') ?></a></li>
                <?php } ?>
                                    </ul>
                                </li> -->
            <?php } ?>
            <!-- Office loan end -->
            <!--  Personal loan start -->
            <?php if ($this->permission1->method('add_person', 'create')->access() || $this->permission1->method('add_loan', 'create')->access() || $this->permission1->method('add_payment', 'create')->access() || $this->permission1->method('manage_person', 'read')->access()) { ?>
                <!--                <li class="treeview <?php
                if ($this->uri->segment('2') == ("add_person") || $this->uri->segment('2') == ("add_loan") || $this->uri->segment('2') == ("add_payment") || $this->uri->segment('2') == ("person_edit") || $this->uri->segment('2') == ("manage_person")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                                    <a href="#">
                                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                                        <span><?php echo display('personal_loan') ?></span>
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                <?php if ($this->permission1->method('add_person', 'create')->access()) { ?>
                                                                                                                                                                                                                <li><a href="<?php echo base_url('Csettings/add_person') ?>"><?php echo display('add_person') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('add_loan', 'create')->access()) { ?>
                                                                                                                                                                                                                <li><a href="<?php echo base_url('Csettings/add_loan') ?>"><?php echo display('add_loan') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('add_payment', 'create')->access()) { ?>
                                                                                                                                                                                                                <li><a href="<?php echo base_url('Csettings/add_payment') ?>"><?php echo display('add_payment') ?></a></li>
                <?php } ?>
                <?php if ($this->permission1->method('manage_person', 'read')->access()) { ?>
                                                                                                                                                                                                                <li><a href="<?php echo base_url('Csettings/manage_person') ?>"><?php echo display('manage_loan') ?></a></li>
                <?php } ?>
                                    </ul>
                                </li>-->
            <?php } ?>
            <!-- loan end -->

            <!--            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Csms")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                            <a href="#">
                                <i class="fa fa-comments"></i><span><?php echo display('sms'); ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
            
            
                                <li><a href="<?php echo base_url('Csms/configure') ?>"><?php echo display('sms_configure'); ?></a></li>
            
            
                            </ul>
                        </li>-->


            <!--            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Autoupdate")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                            <a href="#">
                                <span><?php echo display('update'); ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
            
            
                                <li><a href="<?php echo base_url('Autoupdate') ?>"><?php echo display('update_now'); ?></a></li>


            </ul>
        </li>-->




        </ul>
    </div> <!-- /.sidebar -->
</aside>
<script type="text/javascript">
    $(document).ready(function () {
        $("form :input").attr("autocomplete", "off");
    })
</script>