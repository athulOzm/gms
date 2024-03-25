<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo display('sl'); ?></th>
            <th><?php echo display('customer_name'); ?></th>
            <th><?php echo display('vehicle_registration'); ?></th>
            <th><?php echo display('year'); ?></th>
            <th><?php echo display('make'); ?></th>
            <th><?php echo display('model'); ?></th>
            <th><?php echo display('cc_rating'); ?></th>
            <th class="text-center"><?php echo display('action'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
//                                    dd($vehicle_list);
        if (!empty($vehicle_list)) {
            $sl = 0;
            foreach ($vehicle_list as $vehicle) {
                $sl++;
                ?>
                <tr>
                    <td><?php echo $sl; ?></td>
                    <td>
                        <a href="#">
                            <?php echo $vehicle->customer_name; ?>
                        </a>
                    </td>
                    <td><?php echo $vehicle->vehicle_registration; ?></td>
                    <td><?php echo $vehicle->year; ?></td>
                    <td><?php echo $vehicle->make; ?></td>
                    <td><?php echo $vehicle->model; ?></td>
                    <td><?php echo $vehicle->cc_rating; ?></td>
                    <td class="text-center">
                        <?php if ($this->permission1->check_label('manage_vehicle')->update()->access()) { ?>
                            <a href="<?php echo base_url('Cvehicles/edit_vehicle_form/' . $vehicle->vehicle_id); ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            <?php
                        }
                        if ($this->permission1->check_label('manage_vehicle')->delete()->access()) {
                            ?>
                            <a href="<?php echo base_url('Cvehicles/vehicle_delete/' . $vehicle->vehicle_id); ?>" onclick="return confirm('Do you want to delete it?')" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
    <?php if (empty($vehicle_list)) { ?>
        <tfoot>
            <tr>
                <th colspan="8" class="text-danger text-center">Record not found!</th>
            </tr>
        </tfoot>
    <?php } ?>
</table>