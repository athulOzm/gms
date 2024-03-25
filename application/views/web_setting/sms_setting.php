<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('sms') ?></h1>
            <small><?php echo display('sms_configuration') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('sms') ?></a></li>
                <li class="active"><?php echo display('sms_configuration') ?></li>
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
                    <?php // if ($this->permission1->method('manage_service', 'read')->access()) { ?>
<!--                    <a href="<?php echo base_url('Cinspection/view_checklist') ?>" class="btn btn-info m-b-5 m-r-2">
                        <i class="ti-align-justify"> </i> <?php echo display('view_checklist') ?> </a>-->
                    <?php // } ?>
                </div>
            </div>
        </div>
        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('sms_configuration') ?> </h4>
                        </div>
                    </div>
                    <?php // dd($sms_gateway); ?>
                    <div class="panel-body">
                        <form action="<?php echo base_url('Cweb_setting/sms_config_update'); ?>" method="post">
                            <div class="form-group row">
                                <label for="provider_name" class="col-xs-3 col-form-label"><?php echo display('provider_name'); ?> <span class="text-danger"> * </span></label>
                                <div class="col-xs-9">
                                    <input type="text" name="provider_name" class="form-control" id="provider_name" value="<?php echo $sms_gateway[0]->provider_name; ?>" placeholder="<?php echo display('provider_name'); ?>" tabindex="1" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_name" class="col-xs-3 col-form-label"><?php echo display('user_name'); ?> (API Key)  <span class="text-danger"> * </span></label>
                                <div class="col-xs-9">
                                    <input type="text" name="user_name" class="form-control" id="user_name" value="<?php echo $sms_gateway[0]->user; ?>" placeholder="<?php echo display('user_name'); ?>" tabindex="2" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-xs-3 col-form-label"><?php echo display('password'); ?> (API Secret)  <span class="text-danger"> * </span></label>
                                <div class="col-xs-9">
                                    <input type="text" name="password" class="form-control" id="password" value="<?php echo $sms_gateway[0]->password; ?>" placeholder="Password" tabindex="3" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-xs-3 col-form-label"><?php echo display('phone'); ?>  <span class="text-danger"> </span></label>
                                <div class="col-xs-9">
                                    <input type="text" name="phone" class="form-control" id="phone" value="<?php echo $sms_gateway[0]->phone; ?>" placeholder="<?php echo display('phone'); ?>" tabindex="4" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sender_name" class="col-xs-3 col-form-label"><?php echo display('sender_name'); ?> <span class="text-danger"> </span></label>
                                <div class="col-xs-9">
                                    <input type="text" name="sender_name" class="form-control" id="sender_name" value="<?php echo $sms_gateway[0]->authentication; ?>" placeholder="<?php echo display('sender_name'); ?>" tabindex="5">
                                </div>
                            </div>

                            <div class="form-group  text-right">
                                <button type="submit" class="btn btn-success w-md m-b-5"  tabindex="6">Save Changes</button>
                                <button type="reset" class="btn btn-primary w-md m-b-5" tabindex="7">Reset</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new category end -->




