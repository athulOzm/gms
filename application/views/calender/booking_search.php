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
            $sl = 1;
            foreach ($manage_booking as $booking) {
                ?>
                <tr>
                    <td><?php echo $sl; ?></td>
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
                            <a href="<?php echo base_url() . 'Ccalender/booking_edit_data/' . $booking['id']; ?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
                            <?php
                        }
                        if ($this->permission1->check_label('manage_booking')->delete()->access()) {
                            ?>
                            <a href="<?php echo base_url() . 'Ccalender/delete_booking/' . $booking['id']; ?>" class="btn btn-danger" onclick="return confirm('Are You Sure To Want To Delete ?')"><i class="fa fa-close"></i></a></td>
                            <?php } ?>
                </tr>
                <?php
                $sl++;
            }
        }
        ?>
    </tbody>
    <?php if(empty($manage_booking)){ ?>
    <tfoot>
        <tr>
            <th colspan="6" class="text-danger text-center"><?php echo display('data_not_found'); ?></th>
        </tr>
    </tfoot>
    <?php } ?>

</table>