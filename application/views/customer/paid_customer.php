
<!-- Customer js php -->
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/customer.js.php" ></script>
<!-- Paid Customer Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('paid_customer') ?></h1>
            <small><?php echo display('paid_customer_list') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('customer') ?></a></li>
                <li class="active"><?php echo display('paid_customer') ?></li>
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
                <div class="column text-right">
                    <?php if ($this->permission1->check_label('add_customer')->create()->access()) { ?>
                        <a href="<?php echo base_url('Ccustomer') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_customer') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->check_label('manage_customer')->read()->access()) { ?>
                        <a href="<?php echo base_url('Ccustomer/manage_customer') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('manage_customer') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->check_label('credit_customer')->read()->access()) { ?>
                        <a href="<?php echo base_url('Ccustomer/credit_customer') ?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('credit_customer') ?> </a>
                    <?php } ?>

                </div>
            </div>
        </div>
        <!-- Paid Customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('paid_customer') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('customer_name') ?></th>
                                        <th><?php echo display('address') ?></th>
                                        <th><?php echo display('mobile') ?></th>
                                        <th class="text-right"><?php echo display('ammount') ?></th>
                                        <th class="text-right"><?php echo display('action') ?>
                                            <?php echo form_open('Ccustomer/paid_customer', array('class' => 'form-inline', 'method' => 'post')) ?>
                                            <input type="hidden" name="all" value="all">
                                            <button type="submit" class="btn btn-success"><?php echo display('all') ?></button>
                                            <?php echo form_close() ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $stotal = 0;
                                    if ($customers_list) {
                                        foreach ($customers_list as $custlist) {
                                            ?>
                                            <tr>
                                                <td><?php echo $custlist['sl']; ?></td>

                                                <?php if ($this->permission1->check_label('paid_customer')->read()->access()) { ?>
                                                    <td>
                                                        <a href="<?php echo base_url() . 'Ccustomer/customerledger/' . $custlist['customer_id']; ?>"><?php echo $custlist['customer_name']; ?></a>
                                                    </td>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <td>
                                                        <?php echo $custlist['customer_name']; ?>
                                                    </td>
                                                    <?php
                                                }
                                                ?>


                                                <td><?php echo $custlist['customer_address']; ?></td>
                                                <td><?php echo $custlist['customer_mobile']; ?></td>
                                                <td class="text-right"> <?php
                                                    $balance = $custlist['customer_balance'];
                                                    $stotal += $balance;
                                                    if ($balance <> 0) {
                                                        echo (($position == 0) ? "$currency " . number_format($balance, 2, '.', ',') : number_format($balance, 2, '.', ',') . " $currency");
                                                    } else {
                                                        echo 0;
                                                    }
                                                    ?></td>
                                                <td>
                                        <center>
                                            <?php echo form_open() ?>
                                            <?php if ($this->permission1->check_label('paid_customer')->update()->access()) { ?>
                                                <a href="<?php echo base_url() . 'Ccustomer/customer_update_form/' . $customers['customer_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <?php } ?>
                                            <?php if ($this->permission1->check_label('paid_customer')->delete()->access()) { ?>
                                                <a href="<?php echo base_url() . 'Ccustomer/customer_delete/' . $customers['customer_id']; ?>" onclick="return confirm('Are Your sure to delete?')" class=" btn btn-danger btn-sm" name="{customer_id}" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            <?php } ?>
                                            <?php echo form_close() ?>
                                        </center>
                                        </td>
                                        </tr>


                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="4"> <b><?php echo display('grand_total') ?></b></td>
                                        <td class="text-right">
                                            <b><?php
                                                echo (($position == 0) ? "$currency " . number_format($stotal, 2, '.', ',') : number_format($stotal, 2, '.', ',') . " $currency");
                                                ?></b>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="text-right"><?php echo $links ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>




