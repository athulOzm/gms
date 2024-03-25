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
                    <?php echo form_open('Permission/add_menu', array('class' => 'form-vertical', 'id' => 'insert_menu')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="menu_name" class="col-sm-3 text-right">Menu Name <span class="text-danger"> * </span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="menu_name" id="menu_name" placeholder="Menu Name" required tabindex="1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="url" class="col-sm-3  text-right">Menu URL</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="url" id="url" placeholder="URL" tabindex="2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="module" class="col-sm-3  text-right">Module</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="module" id="module" placeholder="Enter Module" tabindex="3">
<!--                                <select name="module_id" class="form-control" tabindex="3">
                                    <option value=""> Select One</option>
                                    <?php foreach ($module_list as $modules) { ?>
                                        <option value="<?php echo $modules->id ?>"><?php echo ucwords(str_replace("_", ' ', $modules->name)); ?></option>
                                    <?php } ?>
                                </select>-->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="order" class="col-sm-3  text-right">Order</label>
                            <div class="col-sm-8">
                                <select  class="form-control select2" name="order" id="order" data-placeholder="-- select one --" tabindex="4">
                                    <option value=""></option>
                                    <?php
                                    for ($i = 1; $i < 51; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="parent_menu" class="col-sm-3  text-right">Parent Menu</label>
                            <div class="col-sm-8">
                                <select  class="form-control select2" name="parent_menu" id="parent_menu" data-placeholder="-- select firstly menu type --" tabindex="5">
                                    <option value=""></option>
                                    <?php
                                    foreach ($parent_menu as $parent) {
                                        echo "<option value='$parent->id'>" . ucwords(str_replace('_', ' ', $parent->name)) . "</option>'";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>                      
                        <div class="form-group row">
                            <label for="icon" class="col-sm-3  text-right">Icon</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon Class" tabindex="6">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="" class="btn btn-primary btn-large" name="add-user" value="Save" tabindex="7" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="form-group row">
                    <!--                <div class="col-sm-1 dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"> </i> Action
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="javascript:void(0)" onClick="ExportMethod('<?php echo base_url(); ?>menu-export-csv')" class="dropdown-item">Export to CSV</a></li>
                                            <li><a href="javascript:void(0)"  data-toggle="modal" data-target="#importMenu" class="dropdown-item">Import from CSV</a></li>
                                        </ul>
                                    </div>-->
                    <label for="keyword" class="col-sm-offset-8 col-sm-2 col-form-label text-right"></label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="keyword" id="keyword" onkeyup="menukeyup_search()" placeholder="Search..." tabindex="">
                    </div>
                </div>          
            </div>
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('menu_list'); ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="results_menu">
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
                                    if (!empty($menusetuplist)) {
                                        $sl = 0 + ($pagenum);
                                        foreach ($menusetuplist as $key => $value) {
                                            $parent_menu = $this->db->select('*')->where('id', $value->parent_menu)->get('sub_module')->row();
//                                            $module_menu = $this->db->select('*')->where('id', $value->mid)->get('module')->row();
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
                                <?php if (empty($menusetuplist)) { ?>
                                    <tfoot>
                                        <tr>
                                            <th colspan="7" class="text-danger text-center">Record not found!</th>
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
        <input type="text" id="menukeyup_search" value="<?php echo base_url('Permission/menu_search'); ?>">
    </section>
</div>
<!-- Add new customer end -->