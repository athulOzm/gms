<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('calender') ?></h1>
            <small><?php echo display('manage_courtesy_booking') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('calender') ?></a></li>
                <li class="active"><?php echo display('manage_courtesy_booking') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Alert Message -->
        <?php
        $date_format = $this->session->userdata('date_format');
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
            <div class="col-sm-12 text-right">
                <div class="form-group row">
                    <form action="#" method="post">
                        <label class="col-sm-1" for="startdate">From :</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control datepicker" name="startdate" id="startdate" value="<?php echo date('Y-m-d') ?>" placeholder="Search..." tabindex="">
                        </div>
                        <label class="col-sm-1" for="enddate">To :</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control datepicker" name="enddate" id="enddate" value="<?php echo date('Y-m-d') ?>" placeholder="Search..." tabindex="">
                        </div>
                        <div class="col-sm-1">
                            <input type="button" class="form-contro btn btn-success" id="" onclick="courtesybookingdate_search()" value="Submit">
                        </div>
                    </form>

                    <label for="keyword" class="col-sm-offset-1 col-sm-2 col-form-label text-right"></label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="keyword" id="keyword" onkeyup="courtesybookingonkeyup_search()" placeholder="Search..." tabindex="">
                    </div>
                </div>          
            </div>
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('manage_courtesy_booking') ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table" id="results">
                            <table id="dataTableExample" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('sl') ?></th>
                                        <th class=""><?php echo display('title') ?></th>
                                        <th class=""><?php echo display('vehicle_registration') ?></th>
                                        <th class=""><?php echo display('start_date') ?></th>
                                        <th class=""><?php echo display('end_date') ?></th>
                                        <th class=""><?php echo display('booked_by') ?></th>

                                        <th class="text-center"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($manage_booking) {
                                        $sl = 1 + $pagenum;
                                        foreach ($manage_booking as $booking) {
                                            ?>
                                            <tr>
                                                <td><?php echo $sl; ?></td>
                                                <td><?php echo $booking['title'] ?></td>
                                                <td><?php echo $booking['vehicle_reg'] ?></td>
                                                <td>
                                                    <?php
                                                    if ($date_format == 1) {
                                                        echo date('d-m-Y', strtotime($booking['start_date']));
                                                    } elseif ($date_format == 2) {
                                                        echo date('m-d-Y', strtotime($booking['start_date']));
                                                    } elseif ($date_format == 3) {
                                                        echo date('Y-m-d', strtotime($booking['start_date']));
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($date_format == 1) {
                                                        echo date('d-m-Y', strtotime($booking['end_date']));
                                                    } elseif ($date_format == 2) {
                                                        echo date('m-d-Y', strtotime($booking['end_date']));
                                                    } elseif ($date_format == 3) {
                                                        echo date('Y-m-d', strtotime($booking['end_date']));
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $booking['first_name'] . ' ' . $booking['last_name'] ?></td>

                                                <td class="text-center">
                                                    <?php if ($this->permission1->check_label('manage_courtesy_booking')->update()->access()) { ?>
                                                        <a href="<?php echo base_url() . 'Ccalender/courtesy_booking_edit_data/' . $booking['id']; ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                        <?php
                                                    }
                                                    if ($this->permission1->check_label('manage_courtesy_booking')->delete()->access()) {
                                                        ?>
                                                        <a href="<?php echo base_url() . 'Ccalender/delete_courtesy_booking/' . $booking['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure To Want To Delete ?')"><i class="fa fa-close"></i></a></td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                            $sl++;
                                        }
                                    }
                                    ?>
                                </tbody>
                                <?php if (empty($manage_booking)) { ?>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center text-danger" colspan="7"><?php echo display('data_not_found'); ?></th>
                                        </tr>
                                    </tfoot>
                                <?php } ?>
                            </table>
                            <?php echo $links; ?>
                        </div>
                    </div>        
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="courtesyBkingSearch" value="<?php echo base_url('Ccalender/courtesybookingdate_search'); ?>">
    <input type="hidden" id="courtesyBkingkeyupSearch" value="<?php echo base_url('Ccalender/courtesybookingonkeyup_search'); ?>">
</div>
<script src="<?php echo base_url('assets/custom/calender.js') ?>"></script>
