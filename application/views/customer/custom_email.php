<!-- Manage Customer Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('customer') ?></h1>
            <small><?php echo display('custom_email') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('customer') ?></a></li>
                <li class="active"><?php echo display('custom_email') ?></li>
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
                <!--                <div class="column">
                <?php if ($this->permission1->check_label('add_customer')->create()->access()) { ?>
                                                                                <a href="<?php echo base_url('Ccustomer') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_customer') ?> </a>
                <?php } ?>
                <?php if ($this->permission1->check_label('credit_customer')->read()->access()) { ?>
                                                                                <a href="<?php echo base_url('Ccustomer/credit_customer') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('credit_customer') ?> </a>
                <?php } ?>
                <?php if ($this->permission1->check_label('paid_customer')->read()->access()) { ?>
                                                                                <a href="<?php echo base_url('Ccustomer/paid_customer') ?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('paid_customer') ?> </a>
                <?php } ?>
                                </div>-->
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('custom_email') ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open_multipart('Ccustomer/send_custom_email', array('class' => 'form-vertical', 'id' => '')) ?>
                        <div class="form-group">
                            <div class="form-group row">
                                <label for="customer_email" class="col-sm-3 col-form-label text-right"><?php echo display('customer') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-9">
                                    <select name="customer_email" class="form-control" id="customer_email" data-placeholder="-- select one --">
                                        <option value=""></option>
                                        <?php
                                        foreach ($customers as $customer) {
                                            ?>
                                            <option value="<?php echo $customer['customer_email'] ?>">
                                                <?php echo $customer['customer_name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="editor1" class="col-sm-3 col-form-label text-right"><?php echo display('message') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-9">
                                    <textarea name="message" id="editor1" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="attach" class="col-sm-3 col-form-label text-right"><?php echo display('attach') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-9">
                                    <input type="file" name="attach" id="attach" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="" class="btn btn-success btn-large" name="" value="<?php echo display('send') ?>" />
                                </div>
                            </div>
                        </div>                           
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Manage Customer End -->
<script src="<?php echo base_url('assets/custom/customer.js') ?>"></script>