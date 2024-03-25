<link href="<?php echo base_url('assets/custom/dashboard.css') ?>" rel="stylesheet" type="text/css"/>
<?php
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
?>
<!-- Admin Home Start -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('dashboard') ?></h1>
            <small><?php echo display('home') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li class="active"><?php echo display('dashboard') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
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
        <!-- First Counter -->
        <?php if ($this->session->userdata('user_type') == 3) { ?>
            <div class="row">            
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="small-box smallBox-1">
                        <div class="inner">
                            <h4><span class="count-number"><?php echo $ttl_completejob; ?></span></h4>
                            <p><?php echo display('complete_job') ?></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <a href="#" class="small-box-footer"><?php echo display('complete_job') ?> </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="small-box bg-green text-white">
                        <div class="inner">
                            <h4><span class="count-number"><?php echo $completed_services ?></span></h4>
                            <p><?php echo display('total_services') ?></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer"><?php echo display('total_services') ?></a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="small-box smallBox-2">
                        <div class="inner">
                            <h4><span class="count-number"><?php echo $total_payment ?></span></h4>

                            <p><?php echo display('total_payment') ?></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer"><?php echo display('total_payment') ?></a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="small-box smallBox-3">
                        <div class="inner">
                            <h4><span class="count-number"><?php echo $total_vehicle ?></span> </h4>

                            <p><?php echo display('total_vehicle') ?></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <a href="#" class="small-box-footer"><?php echo display('total_vehicle') ?> </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4 class="calender_ttl"> <?php echo display('calender') ?></h4>
                                <!--<a href="<?php echo base_url(); ?>Admin_dashboard/see_all_best_sales" class="btn btn-success text-white">See All</a>-->
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id='calendar'></div>
                            <?php //d($followup); ?>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="m-b-5">
                        <select name="jobmonth" id="jobmonth" class="form-control monthcst_cls" data-placeholder="-- select month -- ">
                            <option value=""></option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">Aprill</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <select name="jobyear" id="jobyear" class="form-control yearcst_cls" data-placeholder="-- select year --">
                            <option value=""></option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                        </select>
                        <button class="form-control btn btn-sm btn-success jobstatus_monthyear" onclick="jobstatus_monthyear()"><i class="fa fa-search"> </i></button>
                    </div>
                    <!-- Flot Pie Chart -->
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4>Monthly Job Status</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="flotChart" id="jobstatusresult">
                                <div id="flotChart8" class="flotChart-demo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('upcoming_service') ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="message_inners">
                                <div class="message_widgets">
                                    <table class="table table-bordered table-striped table-hover upcoming_tbl">
                                        <tr>
                                            <th width="35%"><?php echo display('date') ?></th>
                                            <th width="65%"><?php echo display('service') ?></th>
                                        </tr>
                                        <?php
                                        foreach ($upcoming_service as $service) {
                                            ?>
                                        <tr class="f-11">
                                                <td><?php echo $service->occurrence_date; ?></td>
                                                <td><?php echo $service->job_type_name; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
        <!--<hr>-->
        <?php if ($user_type == '1' || $user_type == 2) { ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body">
                            <div class="statistic-box">
                                <!--<canvas class="totalProduct"></canvas>-->
                                <div class="small"><?php echo display('complete_job') ?></div>
                                <h2 class="leftfloat">
                                    <span class="count-number"><?php echo $ttl_completejob ?></span> 
                                    <span class="slight"><i class="fa fa-play fa-rotate-270 text-primary"> </i></span>
                                </h2>                            
                                <span>
                                    <img src="<?php echo base_url('my-assets/image/purchase.png'); ?>" class="float_right w-25p">
                                </span>
                                <!--<div class="small"><?php echo display('complete_job') ?></div>-->
                                <!--<div class="sparkline1 text-center"></div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body">
                            <div class="statistic-box">
    <!--                              <canvas class="totalInvoice"></canvas>-->
                                <div class="small"><?php echo display('total_vehicle') ?></div>
                                <h2 class="leftfloat">
                                    <span class="count-number"><?php echo $ttl_vehicle ?></span>
                                    <span class="slight"> <i class="fa fa-play fa-rotate-270 text-primary"> </i> </span>
                                </h2>
                                <span>
                                    <img src="<?php echo base_url('my-assets/image/truck.png'); ?>" class="w-25p float_right">
                                </span>
                                <!--<div class="small"><?php echo display('total_vehicle') ?></div>-->
                                <!--<div class="sparkline1 text-center"></div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body">
                            <div class="statistic-box">
    <!--                              <canvas class="totalInvoice"></canvas>-->
                                <div class="small"><?php echo display('total_product') ?></div>
                                <h2 class="leftfloat">
                                    <span class="count-number"><?php echo $total_product ?></span>
                                    <span class="slight"> <i class="fa fa-play fa-rotate-270 text-primary"> </i> </span>
                                </h2>
                                <span>
                                    <img src="<?php echo base_url('my-assets/image/product.png'); ?>" class="w-25p float_right">
                                </span>
                                <!--<div class="small"><?php echo display('total_product') ?></div>-->
                                <!--<div class="sparkline1 text-center"></div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body">
                            <div class="statistic-box">
    <!--                              <canvas class="totalInvoice"></canvas>-->
                                <div class="small"><?php echo display('total_invoice') ?></div>
                                <h2 class="leftfloat">
                                    <span class="count-number"><?php echo $total_sales ?></span>
                                    <span class="slight"> <i class="fa fa-play fa-rotate-270 text-primary"> </i> </span>
                                </h2>
                                <span>
                                    <img src="<?php echo base_url('my-assets/image/sale.png'); ?>" class="w-25p float_right">
                                </span>
                                <!--<div class="small"><?php echo display('total_invoice') ?></div>-->
                                <!--<div class="sparkline1 text-center"></div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <h4><span class="count-number"><?php echo $ttl_completejob ?></span></h4>
                                            <p><?php echo display('complete_job') ?></p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <a href="#" class="small-box-footer"><?php echo display('complete_job') ?></a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="small-box">
                                        <div class="inner">
                                            <h4><span class="count-number"><?php echo $ttl_vehicle ?></span></h4>
                
                                            <p><?php echo display('total_vehicle') ?></p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <a href="#" class="small-box-footer"><?php echo display('total_vehicle') ?> </a>
                                    </div>
                                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="small-box">
                        <div class="inner">
                            <h4><span class="count-number"><?php echo $total_product ?></span></h4>

                            <p><?php echo display('total_product') ?></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer"><?php echo display('total_product') ?></a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="small-box">
                        <div class="inner">
                            <h4><span class="count-number"><?php echo $total_sales ?></span> </h4>

                            <p><?php echo display('total_invoice') ?></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <a href="#" class="small-box-footer"><?php echo display('total_invoice') ?> </a>
                    </div>
                </div>-->
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4>Job Type</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <canvas id="barChart" height="225"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Single Bar Chart -->
                <div class="col-sm-6 col-md-6">
                    <div class="m-b-5">
                        <select name="productmonth" id="productmonth" class="form-control monthcst_cls float_right" data-placeholder="-- select month --">
                            <option value=""></option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">Aprill</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <select name="productyear" id="productyear" class="form-control yearcst_cls"data-placeholder="-- select year --">
                            <option value=""></option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                        </select>
                        <button class="form-control btn btn-sm btn-success jobstatus_monthyear" onclick="productstatus_monthyear()"><i class="fa fa-search"> </i></button>
                    </div>
                    <?php //d($get_allproducts); ?>
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4>Product Sales Information</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="productstatusresult">
                                <canvas id="singelBarChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4 class="calender_ttl"> <?php echo display('calender') ?></h4>
                                <!--<a href="<?php echo base_url(); ?>Admin_dashboard/see_all_best_sales" class="btn btn-success text-white">See All</a>-->
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id='calendar'></div>
                            <?php //d($followup); ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">                    
                    <div class="m-b-5">
                        <select name="jobmonth" id="jobmonth" class="form-control monthcst_cls" data-placeholder="-- select month --">
                            <option value=""></option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">Aprill</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <select name="jobyear" id="jobyear" class="form-control yearcst_cls" data-placeholder="-- select year --">
                            <option value=""></option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                        </select>
                        <button class="form-control btn btn-sm btn-success jobstatus_monthyear" onclick="jobstatus_monthyear()"><i class="fa fa-search"> </i></button>
                    </div>
                    <!-- Flot Pie Chart -->
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4>Monthly Job Status</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="flotChart" id="jobstatusresult">
                                <div id="flotChart8" class="flotChart-demo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('upcoming_service') ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="message_inners">
                                <div class="message_widgets">
                                    <table class="table table-bordered table-striped table-hover upcoming_tbl">
                                        <tr>
                                            <th width="35%"><?php echo display('date') ?></th>
                                            <th width="65%"><?php echo display('service') ?></th>
                                        </tr>
                                        <?php
                                        foreach ($upcoming_service as $service) {
                                            ?>
                                        <tr class="f-11">
                                                <td><?php echo $service->occurrence_date; ?></td>
                                                <td><?php echo $service->job_type_name; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php //d($jobtype_productivity); ?>
                </div>
            </div>
        
        <?php } ?>
        <?php // echo '<pre>';                    print_r($best_sales_product);   ?>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<?php
$user_id = $this->session->userdata('user_id');
$user_type = $this->session->userdata('user_type');
$this->db->select('a.id as reminder_id, a.*, b.customer_name, c.vehicle_registration, d.job_type_name');
$this->db->from('service_reminder_tbl a');
$this->db->join('customer_information b', 'b.customer_id = a.customer_id');
$this->db->join('vehicle_information c', 'c.vehicle_id = a.registration_no');
$this->db->join('job_type d', 'd.job_type_id = a.job_type_id');
$this->db->where('a.customer_id', $user_id);
$this->db->where('a.status', 0);
$this->db->order_by('a.id', 'desc');
$get_own_service_reminder = $this->db->get()->result();
?>
<div id="myModalt" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title leftfloat"><?php echo display('service_reminder'); ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">          
<!--                <p>Welcome! to Garagemanagement System. Please check your service reminder. </p>
                <a href="<?php echo base_url('company-profile') ?>" class="btn btn-success">Go</a>-->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <!--<th><?php echo display('sl'); ?></th>-->
                            <th><?php echo display('customer'); ?></th>
                            <th><?php echo display('service'); ?></th>
                            <th><?php echo display('vehicles'); ?></th>
                            <th><?php echo display('next_occurrence'); ?></th>
                            <th><?php echo display('reminder'); ?></th>
                            <th><?php echo display('repeat'); ?></th>
                            <th class="text-center"><?php echo display('action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $is_remind = $sl = 0;
                        foreach ($get_own_service_reminder as $ownservice) {

                            $reminder_count = $ownservice->reminder_count;
                            $reminder_period = $ownservice->reminder_period;
                            $repeat_count = $ownservice->repeat_count;
                            $repeat_period = $ownservice->repeat_period;
//                    $reminder_dates = strtotime("-1 week", $occurrence_date);
                            $occurrence_date = strtotime($ownservice->occurrence_date);
                            $reminders = strtotime("-$reminder_count $reminder_period", $occurrence_date);
//                            $repeats = strtotime("-$repeat_count $repeat_period", $occurrence_date);
                            $reminder = date('Y-m-d', $reminders);
//                            $repeat = date('Y-m-d', $repeats);
                            if ($reminder <= date('Y-m-d')) {
                                $is_remind = 1;
                                ?>
                                <tr>
                                    <!--<td><?php echo $sl; ?></td>-->
                                    <td class="text-left"><?php echo $ownservice->customer_name; ?></td>
                                    <td class="text-left"><?php echo $ownservice->job_type_name; ?></td>
                                    <td class="text-left"><?php echo $ownservice->vehicle_registration; ?></td>
                                    <td class="text-left"><?php echo $ownservice->occurrence_date; ?></td>
                                    <td class="text-left"><?php echo $ownservice->reminder_count . " " . @$ownservice->reminder_period; ?></td>
                                    <td class="text-left"><?php echo $ownservice->repeat_count . " " . @$ownservice->repeat_period; ?></td>
                                    <td>
                                        <a href="<?php echo base_url('Cservice/service_reminder_status/' . $ownservice->reminder_id); ?>" class="btn btn-sm btn-success" onclick="return confirm('<?php echo display('are_you_sure'); ?>')"><?php echo display('complete'); ?></a>
                                    </td>
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
</div>
<?php if ($is_remind == 1) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
        $('#myModalt').modal({
        backdrop: 'static',
                keyboard: false
        });
        });</script>
<?php } ?>
<!-- ChartJs JavaScript -->
<script src="<?php echo base_url() ?>assets/plugins/chartJs/Chart.min.js" type="text/javascript"></script>

<script type="text/javascript">
//    ================ its for pie chart ============
        var data8 = [
        {label: "Data 1", data: 16, color: "#37a000"},
        {label: "Data 2", data: 6, color: "#48c208"},
        {label: "Data 3", data: 22, color: "#50de05"},
        {label: "Data 4", data: 32, color: "#64d728"}
        ];
        var chartUsersOptions8 = {
        series: {
        pie: {
        show: true
        }
        },
                grid: {
                hoverable: true
                },
                tooltip: true,
                tooltipOpts: {
                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                        shifts: {
                        x: 20,
                                y: 0
                        },
                        defaultTheme: false
                }
        };
        $.plot($("#flotChart8"), data8, chartUsersOptions8);</script>
<script type="text/javascript">
    $(document).ready(function () {

    "use strict"; // Start of use strict

    /* initialize the external events
     -----------------------------------------------------------------*/

    $('#external-events .fc-event').each(function () {

    // store data so the calendar knows to render an event upon drop
    $(this).data('event', {
    title: $.trim($(this).text()), // use the element's text as the event title
            stick: true // maintain when user navigates (see docs on the renderEvent method)
    });
    // make the event draggable using jQuery UI
    $(this).draggable({
    zIndex: 999,
            revert: true, // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
    });
    });
    /* initialize the calendar
     -----------------------------------------------------------------*/

    $('#calendar').fullCalendar({
    header: {
    left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listMonth',
    },
            defaultDate: '<?php echo date('Y-m-d') ?>',
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            selectable:true,
            selectHelper:true,
            select: function(start)
            {


            //var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
            var myDate = new Date(start).toDateString("yyyy-mm-dd");
            $("#bdate").val(myDate);
            $('#even_modal').modal('show');
            var frm = $("#booking_form");
//            frm.on('submit', function(e) {
//
//            e.preventDefault();
//            $.ajax({
//            url : $(this).attr('action'),
//                    method : $(this).attr('method'),
//                    dataType : 'json',
//                    data : frm.serialize(),
//                    success: function(data)
//                    {
//                    //console.log(data);return false;
//                    if (data.status == 1) {
////                    alert('Successfully Inserted');
//                    location.reload();
//                    } else {
//                    alert('Sorry ');
//                    location.reload();
//                    }
//                    },
//                    error: function(xhr)
//                    {
//                    alert('failed!');
//                    }
//            });
//            });
            },
            drop: function () {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
            // if so, remove the element from the "Draggable Events" list
            $(this).remove();
            }
            },
            events: [<?php
if ($followup) {
    foreach ($followup as $followup) {
        ?>
                    {
                    title: "<?php echo $followup['note'] ?>",
                            start: "<?php echo $followup['date'] ?>",
                            end:'',
                            overlap: false,
                            // rendering: 'background',
                            // color: '#ff9f89',
                            constraint: 'businessHours'
                    },
        <?php
    }
}
?>
<?php
if ($booking) {
    foreach ($booking as $book) {
        ?>
                    {
                    title: "<?php echo $book['title']; ?>",
                            start: "<?php echo $book['booking_time'] ?>",
                            end:'',
                            overlap: false,
                            // rendering: 'background',
                            color: '#328F00',
                            constraint: 'businessHours',
                            url : '<?php echo base_url('Ccalender/manage_booking/'); ?>',
                    },
        <?php
    }
}
?>
<?php
if ($courtesy) {
    foreach ($courtesy as $courtesydata) {
        ?>
                    {
                    title: "<?php
        //echo '(' . $courtesydata['vehicle_reg'] . ')';
        echo $courtesydata['title'];
        ?>",
                            start: "<?php echo $courtesydata['start_date'] ?>",
                            end:"<?php echo $courtesydata['end_date'] ?>",
                            overlap: false,
                            // rendering: 'background',
                            color: '#2C3136',
                            constraint: 'businessHours',
                            url : '<?php echo base_url('Ccalender/manage_courtesy_booking/'); ?>'
                    },
        <?php
    }
}
?>
            ],
//            eventAfterAllRender: function(view) {
//            $(".fc-event-container").append("<span class='closon'>X</span>");
//            }
    });
    });
//    ============ its for pie chart ==============
    var data8 = [
    {label: " Complete Job ( <?php echo $ttl_completejob; ?> )", data: <?php echo $ttl_completejob; ?>, color: "#328F00"},
    {label: " Declined Job ( <?php echo $ttl_declinedjob; ?> )", data: <?php echo $ttl_declinedjob; ?>, color: "#6CABBC"},
    {label: "Accepted Job ( <?php echo $ttl_acceptedjob; ?> )", data: <?php echo $ttl_acceptedjob; ?>, color: "#50de05"},
//    {label: "Data 4", data: 32, color: "#64d728"}
    ];
    var chartUsersOptions8 = {
    series: {
    pie: {
    show: true
    }
    },
            grid: {
            hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                    x: 20,
                            y: 0
                    },
                    defaultTheme: false
            }
    };
    $.plot($("#flotChart8"), data8, chartUsersOptions8);
    //bar chart
    var ctx = document.getElementById("barChart");
    var myChart = new Chart(ctx, {
    type: 'bar',
            data: {
            labels: ["Pending", "In Progress", "Declined", "Completed", "Total Job Type"],
                    datasets: [
                    {
                    label: "Job Type Productivity Report",
//                            data: [65, 59, 80, 81, 56, 55, 40],
                            data: [<?php echo $jobtype_productivity[0]->pending; ?>, <?php echo $jobtype_productivity[0]->in_progress; ?>, <?php echo $jobtype_productivity[0]->declined; ?>, <?php echo $jobtype_productivity[0]->completed; ?>, <?php echo $jobtype_productivity[0]->total_job; ?>],
                            borderColor: "#4BA919", //"rgba(55, 160, 0, 0.9)",
                            lineWidth: 0,
                            backgroundColor: "#37A000" //"rgba(55, 160, 0, 0.5)"
                    },
//                    {
//                    label: "My Second dataset",
//                            data: [28, 48, 40, 19, 86, 27, 90],
//                            borderColor: "rgba(0,0,0,0.09)",
//                            borderWidth: "0",
//                            backgroundColor: "rgba(0,0,0,0.07)"
//                    }
                    ]
            },
            options: {
            scales: {
            yAxes: [{
            ticks: {
            beginAtZero: true
            }
            }]
            }
            }
    });
    // single bar chart
<?php
$productsname = '';
foreach ($get_allproducts as $product) {
    $productsname .= '"' . $product->product_name . '",';
}
$productsname = rtrim($productsname, ',');
$salesquantity = '';
foreach ($get_allproducts as $product) {
    $salesquantity .= '"' . $product->salesquantity . '",';
}
$salesquantity = rtrim($salesquantity, ',');
?>
    var ctx = document.getElementById("singelBarChart");
    var myChart = new Chart(ctx, {
    type: 'bar',
            data: {
//            labels: ["Sun", "Mon", "Tu", "Wed", "Th", "Fri", "Sat"],
            labels: [<?php echo $productsname; ?>],
                    datasets: [
                    {
                    label: "Sales Information",
                            data: [<?php echo $salesquantity; ?>],
                            borderColor: "rgba(55, 160, 0, 0.9)",
                            borderWidth: "0",
                            backgroundColor: "#328F00", //rgba(55, 160, 0, 0.5)"
                    }
                    ]
            },
            options: {
            scales: {
            yAxes: [{
            ticks: {
            beginAtZero: true
            }
            }]
            }
            }
    });
//    ============= its for jobstatus_monthyear ===========
    function jobstatus_monthyear(){
    var month = $("#jobmonth").val();
    var year = $("#jobyear").val();
    if (month == '' && year == ''){
    alert("Month or year must be required");
    return false;
    }
    $.ajax({
    url : "<?php echo base_url('Admin_dashboard/jobstatus_monthyear'); ?>",
            type : "POST",
            data : {month : month, year : year},
            success : function (r){
            $("#jobstatusresult").html(r);
            }
    });
    }
//    ============= its for productstatus_monthyear ===========
    function productstatus_monthyear(){
    var month = $("#productmonth").val();
    var year = $("#productyear").val();
    if (month == '' && year == ''){
    alert("Month or year must be required");
    return false;
    }
    $.ajax({
    url : "<?php echo base_url('Admin_dashboard/productstatus_monthyear'); ?>",
            type : "POST",
            data : {month : month, year : year},
            success : function (r){
//            alert(r);
            $("#productstatusresult").html(r);
            }
    });
    }
</script>