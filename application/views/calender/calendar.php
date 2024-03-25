<link href="<?php echo base_url('assets/custom/calender.css') ?>" rel="stylesheet" type="text/css"/>
<?php
$user_id = $this->session->userdata('user_id');
$user_type = $this->session->userdata('user_type');
?>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('calender') ?></h1>
            <small><?php echo display('calender') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('calender') ?></a></li>
                <li class="active"><?php echo display('calender') ?></li>
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


        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('calender') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Ccalender/', array('class' => 'form-vertical', 'id' => '')) ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div id='calendar'></div>
                        </div>
                    </div>                    
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
        <div class="modal fade" id="even_modal" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> <?php echo display('booking_info'); ?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="booking_info">
                        <?php echo form_open('Ccalender/instant_insert_booking', array('class' => 'form-vertical', 'method' => 'post', 'id' => 'booking_form')) ?>
                        <div class="form-group row">
                            <input type="hidden" id="bdate" name="selectdate" class="booking_date">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="bookintype" class="col-sm-4 col-form-label"><?php echo display('booking_type'); ?></label>
                                    <div class="col-sm-8">
                                        <label for="normal_booking">
                                            <input type="radio" name="btype" value="1" id="normal_booking" checked="" class="btype"> <?php echo display('job_booking'); ?> 
                                        </label>
                                        <?php if ($user_type != 3) { ?>
                                            <label for="courtesy_booking">
                                                <input type="radio" name="btype" value="2" id="courtesy_booking" class="btype"> <?php echo display('courtesy_vehicle'); ?>
                                            </label>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="ltitle" class="col-sm-4 col-form-label"><?php echo display('title') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="title" class="form-control" id="ltitle">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" id="nbooking">
                            <div class="col-sm-12">
                                <label for="btime" class="col-sm-4 col-form-label"><?php echo display('bookingtime') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <!--onlyTimePicker-->
                                    <input type="text" name="btime" class=" form-control basic_example_3" id="btime" onchange="booking_check(this.value)">
                                </div>
                            </div>
                            <div class="col-sm-12 m-t-20">
                                <label for="booking_customer_id" class="col-sm-4 col-form-label"><?php echo display('customer') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <?php if ($user_type == 1 || $user_type == 2) { ?>
                                        <select name="booking_customer_id" id="booking_customer_id" class="form-control select2" onchange="customer_wise_vehicle(this.value)"  data-placeholder="-- select one --" >
                                            <option value="">Select Registration</option>
                                            <?php foreach ($customers as $customer) { ?>
                                                <option value="<?php echo $customer['customer_id'] ?>"><?php echo $customer['customer_name'] ?></option>   
                                            <?php } ?>   
                                        </select>
                                    <?php } ?>
                                    <?php if ($this->session->userdata('user_type') == 3) { ?>
                                        <input type="hidden" class="form-control" name="booking_customer_id" id="booking_customer_id" value="<?php echo $this->session->userdata('user_id') ?>" readonly>
                                        <?php
                                        foreach ($customers as $customer) {
                                            if ($user_id == $customer['customer_id']) {
                                                echo $customer['customer_name'];
                                            }
                                        }
                                        ?>
                                    <?php } ?>
                                </div>
                            </div>   
                            <?php
                            $customer_wise_vehicle_info = $this->Jobs_model->customer_wise_vehicle_info($user_id);
                            ?>
                            <div class="col-sm-12 m-t-20">
                                <label for="registration_no" class="col-sm-4 col-form-label"><?php echo display('registration_no') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <select name="registration_no" id="registration_no" class="form-control select2" data-placeholder="-- select one --">
                                        <!--<option value=""></option>-->
                                        <?php
                                        if ($customer_wise_vehicle_info) {
                                            foreach ($customer_wise_vehicle_info as $vehicle) {
                                                echo "<option value='$vehicle->vehicle_id'>$vehicle->vehicle_registration</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" id="cbooking">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="customer" class="col-sm-4 col-form-label"><?php echo display('customer') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <?php if ($user_type == 1 || $user_type == 2) { ?>
                                            <select name="customer_id" id="customer_id" class="form-control select2"  data-placeholder="-- select one --">
                                                <option value="">Select Registration</option>
                                                <?php foreach ($customers as $customer) { ?>
                                                    <option value="<?php echo $customer['customer_id'] ?>"><?php echo $customer['customer_name'] ?></option>   
                                                <?php } ?>   
                                            </select>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('user_type') == 3) { ?>
                                            <input type="text" class="form-control" name="customer_id" id="customer_id" value="<?php echo $this->session->userdata('user_id') ?>" readonly>
                                        <?php } ?>
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <label for="vehi_registration_no" class="col-sm-4 col-form-label"><?php echo display('vehicle_registration') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select name="vehicle_reg" id="vehi_registration_no" class="form-control select2" data-placeholder="-- select one --">
                                            <option value="">Select Registration</option>
                                            <?php foreach ($vehicles as $vehicle) { ?>
                                                <option value="<?php echo $vehicle['vehicle_registration'] ?>"><?php echo $vehicle['vehicle_registration'] ?></option>   
                                            <?php } ?> 
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date" class="col-sm-4 col-form-label"><?php echo display('start_date') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control datepicker" name ="start_date" id="start_date" autocomplete="off" type="text" placeholder="<?php echo display('start_date') ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="end_date" class="col-sm-4 col-form-label"><?php echo display('end_date') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control datepicker" name ="end_date" id="end_date" type="text" autocomplete="off"  placeholder="<?php echo display('end_date') ?>" onchange="booking_vehicle(this.value)">
                                    </div>


                                </div>
                                <div class="form-group row">
                                    <div id="previous" class="col-sm-12"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group row">
                                <label for="end_date" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-4">
                                    <input class="form-control btn btn-success" name ="" type="submit" value="Save">
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="nbookingCheck" value="<?php echo base_url('Ccalender/n_booking_check'); ?>">
    <input type="hidden" id="crtbookingCheck" value="<?php echo base_url('Ccalender/courtesy_booking_check'); ?>">
    <input type="hidden" id="custWiseVehi" value="<?php echo base_url('Cjob/customer_wise_vehicle_info'); ?>">
</div>
<!--============= this script must be include here ============-->
<script type="text/javascript">
    $(document).ready(function () {
    $(".btype").change(function () {
    var val = $('.btype:checked').val();
    if (val == 2){
    document.getElementById('nbooking').style.display = 'none';
    document.getElementById('cbooking').style.display = 'block';
    document.getElementById("start_date").setAttribute("required", "required");
    document.getElementById("end_date").setAttribute("required", "required");
    document.getElementById("customer_id").setAttribute("required", "required");
    document.getElementById("vehi_registration_no").setAttribute("required", "required");
    }
    if (val == 1){
    document.getElementById('nbooking').style.display = 'block';
    document.getElementById('cbooking').style.display = 'none';
    document.getElementById("start_date").removeAttribute("required");
    document.getElementById("end_date").removeAttribute("required");
    document.getElementById("customer_id").removeAttribute("required");
    document.getElementById("registration_no").removeAttribute("required");
    }
    });
    });
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
                            color: '#ff9f89',
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
                            color: '#FF0000',
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
    });</script>

<script src="<?php echo base_url('assets/custom/calender.js') ?>"></script>