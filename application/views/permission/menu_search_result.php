
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th width="5%">#</th>
            <th width="15%">Menu Name</th>
            <th width="15%">URL</th>
            <th width="15%">Module</th>
            <th width="15%">Parent Menu</th>
            <th width="18%" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($get_menu_search_result)) {
            $sl = 0;
            foreach ($get_menu_search_result as $key => $value) {
                $parent_menu = $this->db->select('*')->where('id', $value->parent_menu)->get('sub_module')->row();
                $sl++;
                ?>
                <tr>
                    <td><?php echo $sl; ?></td>
                    <td><?php echo str_replace("_", " ", ucfirst($value->name)); ?></td>
                    <td><?php echo $value->url; ?></td>
                    <td><?php echo $value->module ?></td>
                    <td><?php echo str_replace("_", " ", ucfirst(@$parent_menu->name)); ?></td>
                    <td class="text-center">
                        <?php
                        $status = $value->status;
                        if ($status == 1) {
                            ?>
                            <a href="<?php echo base_url(); ?>Permission/menusetup_inactive/<?php echo $value->id; ?>" data-toggle='tooltip' data-placement='top' data-original-title='Make Inactive' onclick="return confirm('Are you sure inactive it ?')" title="Inactive" class="btn btn-sm btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
                            <?php
                        }
                        if ($status == 0) {
                            ?>
                            <a href="<?php echo base_url(); ?>Permission/menusetup_active/<?php echo $value->id; ?>" data-toggle='tooltip' data-placement='top' data-original-title='Make Active' onclick="return confirm('Are you sure active it ?')" title="Active" class="btn btn-sm btn-info"><i class="fa fa-check-circle"></i></a>
                        <?php } ?>
                        <a href = "<?php echo base_url(); ?>Permission/menusetup_edit/<?php echo $value->id; ?>" title = "" class = "btn btn-info btn-sm simple-icon-note"><i class = "fa fa-edit"></i></a>
                        <a href = "<?php echo base_url(); ?>Permission/menusetup_delete/<?php echo $value->id; ?>" title = "" onclick = "return confirm('Do you want to delete it?');" class = "btn btn-danger btn-sm simple-icon-trash"><i class = "fa fa-trash-o"></i></a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
    <?php if (empty($get_menu_search_result)) { ?>
        <tfoot>
            <tr>
                <th colspan="6" class="text-danger text-center">Record not found!</th>
            </tr>
        </tfoot>
    <?php } ?>
</table> 