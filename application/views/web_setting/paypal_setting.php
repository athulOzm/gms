<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('paypal') ?></h1>
            <small><?php echo display('paypal_setting') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('paypal') ?></a></li>
                <li class="active"><?php echo display('paypal_setting') ?></li>
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
                            <h4><?php echo display('paypal_setting') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Cweb_setting/paypal_setting_update', array('class' => 'form-vertical', 'id' => '')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="payment_gateway" class="col-sm-3 col-form-label text-right"><?php echo display('payment_gateway') ?> <i class="text-danger"> *</i></label>
                            <div class="col-sm-6">
                                <select class="form-control"  class="form-control payment_gateway" id="payment_gateway" name="payment_gateway" required data-placeholder="-- select one --">
                                    <option value=""></option>
                                    <option value="paypal" <?php
                                    if ($paypal_setting[0]->payment_gateway == 'paypal') {
                                        echo 'selected';
                                    }
                                    ?>>Paypal</option>
                                    <option value="sandbox" <?php
                                    if ($paypal_setting[0]->payment_gateway == 'sandbox') {
                                        echo 'selected';
                                    }
                                    ?>>Sandbox</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label text-right"><?php echo display('email') ?> <i class="text-danger"> *</i></label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control email" id="email" name="email" value="<?php echo $paypal_setting[0]->payment_mail; ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="currency" class="col-sm-3 col-form-label text-right"><?php echo display('currency') ?> <i class="text-danger"> </i></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" name="currency" id="currency" data-placeholder="-- select one --">
                                    <option value=""></option>
                                    <option value="USD" <?php
                                    if ($paypal_setting[0]->currency == 'USD') {
                                        echo 'selected';
                                    }
                                    ?>>(USD) U.S. Dollar</option>
                                    <option value="EUR" <?php
                                    if ($paypal_setting[0]->currency == 'EUR') {
                                        echo 'selected';
                                    }
                                    ?>>(EUR) Euro</option>
                                    <option value="AUD" <?php
                                    if ($paypal_setting[0]->currency == 'AUD') {
                                        echo 'selected';
                                    }
                                    ?>>(AUD) Australian Dollar</option>
                                    <option value="CAD" <?php
                                    if ($paypal_setting[0]->currency == 'CAD') {
                                        echo 'selected';
                                    }
                                    ?>>(CAD) Canadian Dollar</option>
                                    <option value="CZK" <?php
                                    if ($paypal_setting[0]->currency == 'CZK') {
                                        echo 'selected';
                                    }
                                    ?>>(CZK) Czech Koruna</option>
                                    <option value="DKK" <?php
                                    if ($paypal_setting[0]->currency == 'DKK') {
                                        echo 'selected';
                                    }
                                    ?>>(DKK) Danish Krone</option>
                                    <option value="HKD" <?php
                                    if ($paypal_setting[0]->currency == 'HKD') {
                                        echo 'selected';
                                    }
                                    ?>>(HKD) Hong Kong Dollar</option>
                                    <option value="Yen" <?php
                                    if ($paypal_setting[0]->currency == 'Yen') {
                                        echo 'selected';
                                    }
                                    ?>>(YEN) Japanese</option>
                                    <option value="MXN" <?php
                                    if ($paypal_setting[0]->currency == 'MXN') {
                                        echo 'selected';
                                    }
                                    ?>>(MXN) Mexican Peso</option>
                                    <option value="NOK" <?php
                                    if ($paypal_setting[0]->currency == 'NOK') {
                                        echo 'selected';
                                    }
                                    ?>>(NOK) Norwegian Krone</option>
                                    <option value="NZD" <?php
                                    if ($paypal_setting[0]->currency == 'NZD') {
                                        echo 'selected';
                                    }
                                    ?>>(NZD) New Zealand Dollar</option>
                                    <option value="PHP" <?php
                                    if ($paypal_setting[0]->currency == 'PHP') {
                                        echo 'selected';
                                    }
                                    ?>>(PHP) Philippine Peso</option>
                                    <option value="PLN" <?php
                                    if ($paypal_setting[0]->currency == 'PLN') {
                                        echo 'selected';
                                    }
                                    ?>>(PLN) Polish Zloty</option>
                                    <option value="SGD" <?php
                                    if ($paypal_setting[0]->currency == 'SGD') {
                                        echo 'selected';
                                    }
                                    ?>>(SGD) Singapore Dollar</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mode" class="col-sm-3 col-form-label text-right"><?php echo display('mode') ?> <i class="text-danger"> *</i></label>
                            <div class="col-sm-6">
                                <select name="mode" id="mode" class="form-control select2" data-placeholder="-- select one --">
                                    <option value="0">Development</option>
                                    <option value="1">Production</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-category" class="btn btn-success btn-large" name="add-checklist" value="<?php echo display('update') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new category end -->




