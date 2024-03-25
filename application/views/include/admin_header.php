<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$CI->load->model('Reports');
$CI->load->model('Users');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$users = $CI->Users->profile_edit_data();
$out_of_stock = $CI->Reports->out_of_stock_count();
$user_type = $this->session->userdata('user_type');
?>
<!-- Admin header end -->
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
            <a href="<?php echo base_url('Cinvoice/manage_invoice') ?>" class="btn btn-success btn-outline"><i class="fa fa-balance-scale"></i> <?php echo display('invoices') ?></a>
        <?php } ?>


        <?php if ($this->permission1->method('customer_receive', 'create')->access()) { ?>
            <a href="<?php echo base_url('accounts/customer_receive') ?>" class="btn btn-success btn-outline"><i class="fa fa-money"></i> <?php echo display('customer_receive') ?></a>
        <?php } ?>

        <?php if ($this->permission1->method('supplier_payment', 'create')->access()) { ?>
            <a href="<?php echo base_url('accounts/supplier_payment') ?>" class="btn btn-success btn-outline"><i class="fa fa-money" aria-hidden="true"></i> <?php echo display('supplier_payment') ?></a>
        <?php } ?>

        <?php if ($this->permission1->method('add_purchase', 'create')->access()) { ?>
            <a href="<?php echo base_url('Cpurchase') ?>" class="btn btn-success btn-outline"><i class="ti-shopping-cart"></i> <?php echo display('purchase') ?></a>
        <?php } ?>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php if ($user_type != 3) { ?>
                    <li class="dropdown notifications-menu">
                        <a href="<?php echo base_url('Creport/out_of_stock') ?>" >
                            <i class="pe-7s-attention" title="<?php echo display('out_of_stock') ?>"></i>
                            <span class="label label-danger"><?php echo $out_of_stock ?></span>
                        </a>
                    </li>
                <?php } ?>
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
//                var_dump($this->permission1->module($module->name)->access());
                if ($this->permission1->module($module->name)->access()) {
                    $menu_item = $this->db->select('*')
                                    ->from('sub_module')
                                    ->where('parent_menu', $module->id)
                                    ->where('status', 1)
                                    ->get()->result();
//                    echo '<pre>';                    print_r($menu_item);
                    ?>
                    <li class="treeview <?php echo $module->name; ?>">
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
//                                    echo $submenu->name;
                                    // ($this->permission1->check_label($submenu->name)->access());//die();
                                    if ($this->permission1->check_label($submenu->name)->access()) {
                                        $child_menus = $this->db->select('*')
                                                        ->from('sub_module a')
                                                        ->where('a.parent_menu', $submenu->id)
                                                        ->where('a.status', 1)
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
                                                <a href=""><?php echo ucwords(str_replace('_', ' ', $submenu->name)); ?>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php foreach ($child_menus as $child) { ?>
                                                        <li><a href="<?php echo base_url() . $child->url; ?>"><?php echo ucwords(str_replace("_", " ", $child->name)) ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } else { ?>
                                            <li><a href="<?php echo base_url() . $submenu->url ?>"><?php echo ucwords(str_replace('_', ' ', $submenu->name)); ?></a></li>
                                            <?php
                                        }
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
                }
            }
            ?>
            <!--========== menu dynamic close  =================-->
            
        </ul>
    </div> <!-- /.sidebar -->
</aside>

 <!--sidebar menu--> 
