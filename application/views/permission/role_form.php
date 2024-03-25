<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo $title ?></h1>
            <small><?php echo $title ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('permission') ?></a></li>
                <li class="active"><?php echo $title ?></li>
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

        <div class="row">
            <div class="col-sm-12">
                <div class="column">

                  <!--   <a href="<?php echo base_url('Permission/add_module') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('module_list') ?> </a>
                    -->


                </div>
            </div>
        </div>

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo $title ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open("Permission/create/") ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="type" class="col-sm-3 col-form-label"><?php echo display('role_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="2" class="form-control" name="role_id" id="type" placeholder="<?php echo display('role_name') ?>" required />
                            </div>
                        </div>
                        <div class="selectDeselect_cls">
                            <label for="select_deselect">
                                <span class="select_cls"><strong>Select / De-select</strong></span>
                                <input type="checkbox" id="select_deselect">
                            </label>
                        </div>
                        <?php
                        $m = 0;
                        foreach ($accounts as $key => $value) {
                            $account_sub = $this->db->select('*')->from('sub_module')->where('status', 1)->where('module', $value['module'])->get()->result();
//                            d($account_sub);
                            ?>
                            <table class="table table-bordered">
                                <h2 class=""><?php echo display($value['name']); ?></h2>
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl_no'); ?></th>
                                        <th><?php echo display('menu_name'); ?></th>
                                        <th><?php echo display('create'); ?>&nbsp; &nbsp;
                                            <label for="<?php echo $value['module']; ?>_can_create_all" class="float_right">
                                                <span class="select_cls"><strong>All</strong></span>
                                                <input type="checkbox" id="<?php echo $value['module']; ?>_can_create_all" class="can_create_all" value="<?php echo $value['module']; ?>">
                                            </label>                                        
                                        </th>
                                        <th><?php echo display('read'); ?>&nbsp; &nbsp;
                                            <label for="<?php echo $value['module']; ?>_can_read_all" class="float_right">
                                                <span class="select_cls"><strong>All</strong></span>
                                                <input type="checkbox" id="<?php echo $value['module']; ?>_can_read_all" class="can_read_all" value="<?php echo $value['module']; ?>">
                                            </label>
                                        </th>
                                        <th><?php echo display('update'); ?>&nbsp; &nbsp;
                                            <label for="<?php echo $value['module']; ?>_can_edit_all" class="float_right">
                                                <span class="select_cls"><strong>All</strong></span>
                                                <input type="checkbox" id="<?php echo $value['module']; ?>_can_edit_all" class="can_edit_all" value="<?php echo $value['module']; ?>">
                                            </label>
                                        </th>
                                        <th><?php echo display('delete'); ?>&nbsp; &nbsp;
                                            <label for="<?php echo $value['module']; ?>_can_delete_all" class="float_right">
                                                <span class="select_cls"><strong>All</strong></span>
                                                <input type="checkbox" id="<?php echo $value['module']; ?>_can_delete_all" class="can_delete_all" value="<?php echo $value['module']; ?>">
                                            </label>
                                        </th>
                                    </tr>
                                </thead>
                                <?php $sl = 0 ?>
                                <?php if (!empty($account_sub)) { ?>
                                    <?php foreach ($account_sub as $key1 => $module_name) { ?>

                                        <?php
                                        $createID = 'id="create' . $m . '' . $sl . '"';
                                        $readID = 'id="read' . $m . '' . $sl . '"';
                                        $updateID = 'id="update' . $m . '' . $sl . '"';
                                        $deleteID = 'id="delete' . $m . '' . $sl . '"';
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo ($sl + 1) ?></td>
                                                <td class="text-<?php echo ($module_name->parent_menu ? 'right' : '') ?>">
                                                    <?php echo str_replace("_", " ", ucwords($module_name->name)); ?>
                                                    <input type="hidden" name="fk_module_id[<?php echo $m ?>][<?php echo $sl ?>][]" value="<?php echo $module_name->id ?>" id="id_<?php echo $module_name->id ?>">
                                                </td>
                                                <td>
                                                    <div class="checkbox checkbox-success text-center">
                                                        <input type="checkbox" name="create[<?php echo $m ?>][<?php echo $sl ?>][]" value="1" id="create<?php echo $m ?><?php echo $sl ?>" class="sameChecked <?php echo $module_name->module; ?>_can_create">
                                                        <?php // echo form_checkbox('create[' . $m . '][' . $sl . '][]', '1', null, $createID); ?>
                                                        <label for="create<?php echo $m ?><?php echo $sl ?>"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkbox checkbox-success text-center">
                                                        <input type="checkbox" name="read[<?php echo $m ?>][<?php echo $sl ?>][]" value="1" id="read<?php echo $m ?><?php echo $sl ?>" class="sameChecked <?php echo $module_name->module; ?>_can_read">
                                                        <?php // echo form_checkbox('read[' . $m . '][' . $sl . '][]', '1', null, $readID); ?>
                                                        <label for="read<?php echo $m ?><?php echo $sl ?>"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkbox checkbox-success text-center">
                                                        <input type="checkbox" name="update[<?php echo $m ?>][<?php echo $sl ?>][]" value="1" id="update<?php echo $m ?><?php echo $sl ?>" class="sameChecked <?php echo $module_name->module; ?>_can_edit">
                                                        <?php // echo form_checkbox('update[' . $m . '][' . $sl . '][]', '1', null, $updateID); ?>
                                                        <label for="update<?php echo $m ?><?php echo $sl ?>"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkbox checkbox-success text-center">
                                                        <input type="checkbox" name="delete[<?php echo $m ?>][<?php echo $sl ?>][]" value="1" id="delete<?php echo $m ?><?php echo $sl ?>" class="sameChecked <?php echo $module_name->module; ?>_can_delete">
                                                        <?php // echo form_checkbox('delete[' . $m . '][' . $sl . '][]', '1', null, $deleteID); ?>
                                                        <label for="delete<?php echo $m ?><?php echo $sl ?>"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php $sl++ ?>
                                    <?php } ?>
                                <?php } //endif ?>
                            </table>
                            <?php
                            $m++;
                        }
                        ?>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo display('reset') ?></button>
                            <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                        </div>
                        <?php echo form_close() ?>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new customer end -->