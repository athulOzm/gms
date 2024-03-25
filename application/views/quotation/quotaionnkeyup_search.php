<table id="dataTableExample2" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th class="text-center"><?php echo display('sl') ?></th>
            <th class=""><?php echo display('customer_name') ?></th>
            <th class=""><?php echo display('quotation_no') ?></th>
            <th class=""><?php echo display('quotation_date') ?></th>
            <th class=""><?php echo display('total_amount') ?></th>
            <th class=""><?php echo display('status') ?></th>
            <th class="text-center"><?php echo display('action') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $date_format = $this->session->userdata('date_format');
        if ($quotation_list) {
            $sl = 0;
            foreach ($quotation_list as $quotation) {
                $sl++;
                ?>
                <tr>
                    <td><?php echo $sl; ?></td>
                    <td><?php echo $quotation->customer_name; ?></td>
                    <td><?php echo $quotation->quot_no; ?></td>
                    <td>
                        <?php
                        if ($date_format == 1) {
                            echo date('d-m-Y', strtotime($quotation->quotdate));
                        } elseif ($date_format == 2) {
                            echo date('m-d-Y', strtotime($quotation->quotdate));
                        } elseif ($date_format == 3) {
                            echo date('Y-m-d', strtotime($quotation->quotdate));
                        }
                        ?>
                    </td>
                    <td><?php echo $quotation->totalamount; ?></td>
                    <td><?php
                        if ($quotation->status == 1) {
                            echo 'New';
                        }
                        if ($quotation->status == 2) {
                            echo 'Pending';
                        }
                        if ($quotation->status == 3) {
                            echo 'Accept';
                        }
                        if ($quotation->status == 4) {
                            echo 'Decline';
                        }
                        ?></td>

                    <td class="text-center">
                        <?php if ($this->permission1->check_label('manage_quotation')->read()->access()) { ?>
                            <a href="<?php echo base_url() . 'Cquotation/quotation_details_data/' . $quotation->quotation_id; ?>" class="btn btn-info btn-sm"   title="" data-original-title="<?php echo 'details' ?> "><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <?php
                        }
                        if ($this->permission1->check_label('manage_quotation')->update()->access()) {
                            ?>
                            <a href="<?php echo base_url() . 'Cquotation/quotation_edit_data/' . $quotation->quotation_id; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('edit'); ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?php
                        }
                        if ($this->permission1->check_label('manage_quotation')->delete()->access()) {
                            ?>
                            <a href="<?php echo base_url() . 'Cquotation/delete_quotation/' . $quotation->quotation_id; ?>" class="btn btn-danger btn-sm"  onclick="return confirm('Are You Sure To Want to Delete ??')" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        <?php } ?>
                        <a href="<?php echo base_url('Cquotation/quotation_download/' . $quotation->quotation_id); ?>" class="btn btn-primary btn-sm"  title="" data-original-title="<?php echo display('download') ?> "><i class="fa fa-download" aria-hidden="true"></i></a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
    <?php if (empty($quotation_list)) { ?>
        <tfoot>
            <tr>
                <th colspan="7" class="text-danger text-center"><?php echo display('data_not_found'); ?></th>
            </tr>
        </tfoot>
    <?php } ?>
</table>