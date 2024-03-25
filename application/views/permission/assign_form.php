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

                    <div class="panel-body">

                        <?php echo form_open("Permission/usercreate") ?>
                        <div class="form-group row">
                            <label for="user_id" class="col-sm-3 col-form-label text-right">
                                <?php echo display('username') ?> <i class="text-danger"> * </i>
                            </label>
                            <div class="col-sm-5">
                                <select class="form-control" name="user_id" id="user_id" onchange="userRole(this.value)">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <?php
                                    foreach ($user as $udata) {
                                        ?>
                                        <option value="<?php echo $udata['user_id'] ?>"><?php echo $udata['first_name'] . ' ' . $udata['last_name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_type" class="col-sm-3 col-form-label text-right">
                                <?php echo display('role_name') ?>  <i class="text-danger"> * </i>
                            </label>
                            <div class="col-sm-5">
                                <select class="form-control" name="user_type" id="user_type">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <?php
                                    foreach ($user_list as $data) {
                                        ?>
                                        <option value="<?php echo $data['id'] ?>"><?php echo $data['type'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h3><?php echo display('exsisting_role') ?></h3>
                            <div id="existrole">
                                
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo display('reset') ?></button>
                                <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>

                </div>
            </div>
        </div>
        <input type="hidden" id="assignRoleURL" value="<?php echo site_url('permission/select_to_rol') ?>">
    </section>
</div>
<!-- Add new customer end -->
