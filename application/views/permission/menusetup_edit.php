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
                    <?php echo form_open('Permission/menu_update', array('class' => 'form-vertical', 'id' => 'insert_menu')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="menu_name" class="col-sm-3 text-right">Menu Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="menu_name" id="menu_name" placeholder="Menu Name" value="<?php echo $get_editdata[0]->name; ?>" required tabindex="1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="url" class="col-sm-3  text-right">Menu URL</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="url" id="url" placeholder="URL" value="<?php echo $get_editdata[0]->url; ?>" tabindex="2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="module" class="col-sm-3  text-right">Module</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="module" id="module" value="<?php echo $get_editdata[0]->module; ?>" placeholder="Enter Module" tabindex="3">
<!--                                <select name="module_id" class="form-control" tabindex="3">
                                    <option value=""> Select One</option>
                                    <?php foreach ($module_list as $modules) { ?>
                                        <option value="<?php echo $modules->id ?>" <?php
                                        if ($modules->id == $get_editdata[0]->mid) {
                                            echo 'selected';
                                        }
                                        ?>>
                                                    <?php echo ucwords(str_replace("_", ' ', $modules->name)); ?>
                                        </option>
                                    <?php } ?>
                                </select>-->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="order" class="col-sm-3  text-right">Order</label>
                            <div class="col-sm-8">
                                <select  class="form-control select2" name="order" id="order" data-placeholder="-- select one --" tabindex="4">
                                    <option value=""></option>
                                    <?php for ($i = 1; $i < 51; $i++) { ?>
                                        <option value='<?php echo $i; ?>' <?php
                                        if ($i == $get_editdata[0]->ordering) {
                                            echo 'selected';
                                        }
                                        ?>>
                                                    <?php echo $i; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="parent_menu" class="col-sm-3  text-right">Parent Menu</label>
                            <div class="col-sm-8">
                                <select  class="form-control select2" name="parent_menu" id="parent_menu" data-placeholder="-- select firstly menu type --" tabindex="5">
                                    <option value=""></option>
                                    <?php foreach ($parent_menu as $parent) { ?>
                                        <option value='<?php echo $parent->id; ?>' <?php
                                        if ($parent->id == $get_editdata[0]->parent_menu) {
                                            echo 'selected';
                                        }
                                        ?>>
                                                    <?php echo ucwords(str_replace('_', ' ', $parent->name)); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>                      
                        <div class="form-group row">
                            <label for="icon" class="col-sm-3  text-right">Icon</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon Class" value="<?php echo $get_editdata[0]->icon; ?>" tabindex="6">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="hidden" name="menu_id" value="<?php echo $get_editdata[0]->id; ?>">
                                <input type="submit" id="" class="btn btn-primary btn-large" name="add-user" value="Update" tabindex="7" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new customer end -->



