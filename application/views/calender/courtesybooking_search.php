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
        $date_format = $this->session->userdata('date_format');
        if ($manage_booking) {
            $sl = 1;
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

                    <td>
                        <?php if ($this->permission1->check_label('manage_courtesy_booking')->update()->access()) { ?>
                            <a href="<?php echo base_url() . 'Ccalender/courtesy_booking_edit_data/' . $booking['id']; ?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
                            <?php
                        }
                        if ($this->permission1->check_label('manage_courtesy_booking')->delete()->access()) {
                            ?>
                            <a href="<?php echo base_url() . 'Ccalender/delete_courtesy_booking/' . $booking['id']; ?>" class="btn btn-danger" onclick="return confirm('Are You Sure To Want To Delete ?')"><i class="fa fa-close"></i></a></td>
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
            <th class="text-center text-danger" colspan="7"><?php echo display('data_not_found'); ?></th>
        </tr>
    </tfoot>
    <?php } ?>
</table>