<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('calender') ?></h1>
            <small><?php echo display('manage_booking') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('calender') ?></a></li>
                <li class="active"><?php echo display('manage_booking') ?></li>
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
            <div class="col-sm-12 text-right">
                <div class="form-group row">

                    <label for="keyword" class="col-sm-offset-8 col-sm-2 col-form-label text-right"></label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="keyword" id="keyword" onkeyup="bookingonkeyup_search()" placeholder="Search..." tabindex="">
                    </div>
                </div>          
            </div>
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('manage_booking') ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table"
                             <div id="results">
                                <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?php echo display('sl') ?></th>
                                            <th class=""><?php echo display('title') ?></th>
                                            <th class=""><?php echo display('bookingtime') ?></th>
                                            <th class=""><?php echo display('booked_by') ?></th>
                                            <th class=""><?php echo display('status') ?></th>
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
                                                    <td class="text-center"><?php echo $sl; ?></td>
                                                    <td><?php echo $booking['title'] ?></td>
                                                    <td><?php echo $booking['booking_time'] ?></td>
                                                    <td><?php echo $booking['first_name'] . ' ' . $booking['last_name'] ?></td>
                                                    <td><?php
                                                        if ($booking['status'] == 1) {
                                                            echo 'Accepted';
                                                        } else {
                                                            echo 'Pending';
                                                        }
                                                        ?></td>
                                                    <td class="text-center">
                                                        <?php if ($this->session->userdata('user_type') == 1) { ?>
                                                            <input type="button" id="bconfirmation" class="btn btn-warning" onclick="bookingAccept('<?php echo $booking['id'] ?>', '<?php echo $booking['status'] ?>', '<?php echo $booking['booking_time'] ?>')" value="<?php
                                                            if ($booking['status'] == 1) {
                                                                echo 'Decline';
                                                            } else {
                                                                echo 'Accept';
                                                            }
                                                            ?>">
                                                                   <?php
                                                               }

                                                               if ($this->permission1->check_label('manage_booking')->update()->access()) {
                                                                   ?>
                                                            <a href="<?php echo base_url() . 'Ccalender/booking_edit_data/' . $booking['id']; ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                                            <?php
                                                        }
                                                        if ($this->permission1->check_label('manage_booking')->delete()->access()) {
                                                            ?>
                                                            <a href="<?php echo base_url() . 'Ccalender/delete_booking/' . $booking['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure To Want To Delete ?')"><i class="fa fa-close"></i></a></td>
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
                                                <th colspan="6" class="text-danger text-center"><?php echo display('data_not_found'); ?></th>
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
</div>
<input type="hidden" id="bkingAccept" value="<?php echo base_url('Ccalender/bookin_confirmation'); ?>">
<input type="hidden" id="bkingSearch" value="<?php echo base_url('Ccalender/bookingonkeyup_search'); ?>">
<script src="<?php echo base_url('assets/custom/calender.js.php') ?>"></script>