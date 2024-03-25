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
        <!--<link href="<?php echo base_url() ?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css"/>-->

        <?php
        $uri_segment = '';
        $uri_segment = $this->uri->segment(1);
        $uri_segment2 = $this->uri->segment(2);

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

        <!-- Flot Charts js -->
        <script src="<?php echo base_url('assets/plugins/flot/jquery.flot.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/flot/jquery.flot.pie.min.js'); ?>" type="text/javascript"></script>
        <!-- ChartJs JavaScript -->
        <script src="<?php echo base_url('assets/plugins/chartJs/Chart.min.js'); ?>" type="text/javascript"></script>
        <!--=========== its for jquery timer ============-->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/jquery.timepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/jquery.timepicker.css" />
        <!--============ its for custom css =============-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/custom/custom.css') ?>" />

        <?php if ($uri_segment == "Ccalender" || $uri_segment == 'Cjob' || $uri_segment2 == 'create_checklist' || $uri_segment2 == 'inspection_edit') { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/jquery-ui-timepicker-addon.css" />
        <?php } ?>

    </head>
    <body class="hold-transition sidebar-mini">
        <div class="se-pre-con"></div>

        <!-- Site wrapper -->
        <div class="wrapper">
            <?php
            $url = $this->uri->segment(2);
            if ($url != "login") {
                $this->load->view('include/admin_header');
            }
            ?>
            {content}
            <?php
            if ($url != "login") {
                $this->load->view('include/admin_footer');
            }
            ?>
        </div>
        <!-- ./wrapper -->
        <input type="hidden" id="segment1" value="<?php echo $this->uri->segment('1'); ?>">
        <input type="hidden" id="segment2" value="<?php echo $this->uri->segment('2'); ?>">
        <input type="hidden" id="segment3" value="<?php echo $this->uri->segment('3'); ?>">
        <input type="hidden" id="specialcharacterremove" value="<?php echo display('security_character'); ?>">
        <!-- Start Core Plugins-->
        <!-- jquery-ui --> 
        <?php
        //echo $uri_segment;
        if ($uri_segment != 'Cjob' && $uri_segment != 'Ccalender' && $uri_segment2 != 'create_checklist' && $uri_segment2 != 'inspection_edit') {
            ?>
            <script src="<?php echo base_url() ?>assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <?php } ?>
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
        <?php if ($uri_segment == "Ccalender" || $uri_segment == 'Cjob' || $uri_segment2 == 'create_checklist' || $uri_segment2 == 'inspection_edit') { ?>
            <script type="text/javascript" src="<?php echo base_url('assets/1.10.0-jquery-ui.min.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/jquery-ui-timepicker-addon.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/jquery-ui-sliderAccess.js'); ?>"></script>

        <?php } ?>

        <script type="text/javascript">
        </script>
        <script src="<?php echo base_url('assets/custom/custom.js') ?>" type="text/javascript"></script>

    </body>
</html>