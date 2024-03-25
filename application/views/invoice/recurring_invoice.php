<link href="<?php echo base_url('assets/custom/invoice.css') ?>" rel="stylesheet" type="text/css"/>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('manage_invoice') ?></h1>
            <small><?php echo display('manage_your_invoice') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('invoice') ?></a></li>
                <li class="active"><?php echo display('manage_invoice') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Alert Message -->
        <?php
        $date_format = $this->session->userdata('date_format');
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

        <!--        <div class="row">
                    <div class="col-sm-12">
                        <div class="column">
        <?php if ($this->permission1->check_label('new_invoice')->create()->access()) { ?>
                                                        <a href="<?php echo base_url('Cinvoice') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('new_invoice') ?> </a>
        <?php } ?>
        <?php if ($this->permission1->check_label('pos_invoice')->create()->access()) { ?>
                                                        <a href="<?php echo base_url('Cinvoice/pos_invoice') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('pos_invoice') ?> </a>
        <?php } ?>
        
                        </div>
                    </div>
                </div>-->

        <!-- Manage Invoice report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-body">
                        <div class="table-responsive" id="invoic_list">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('invoice_no') ?></th>
                                        <th><?php echo display('invoice_id') ?></th>
                                        <th><?php echo display('customer_name') ?></th>
                                        <th><?php echo display('recurring_time') ?></th>
                                        <th><?php echo display('date') ?></th>
                                        <th><?php echo display('total_amount') ?></th>
                                        <th><?php echo display('action') ?>
                                            <?php echo form_open('Cinvoice/manage_invoice', array('class' => 'form-inline', 'method' => 'post')) ?>
                                            <input type="hidden" name="all" value="all">
                                            <button type="submit" class="btn btn-success"><?php echo display('all') ?></button>
                                            <?php echo form_close() ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = '0.00';
                                    if ($invoices_list) {
                                        foreach ($invoices_list as $invoices_list) {
                                            ?>
                                            <tr>
                                                <td><?php echo $invoices_list['sl']; ?></td>
                                                <td>
                                                    <!--<a href="<?php echo base_url() . 'Cinvoice/invoice_inserted_data/' . $invoices_list['invoice_id']; ?>">-->
                                                    <?php echo $invoices_list['invoice']; ?>
                                                    <!--</a>-->
                                                </td>
                                                <td>
                                                    <!--<a href="<?php echo base_url() . 'Cinvoice/invoice_inserted_data/' . $invoices_list['invoice_id']; ?>">-->
                                                    <?php echo $invoices_list['invoice_id'] ?>  
                                                    <!--</a>-->
                                                </td>
                                                <td>
                                                    <!--<a href="<?php echo base_url() . 'Ccustomer/customerledger/' . $invoices_list['invoice_id']; ?>">-->
                                                    <?php echo $invoices_list['customer_name'] ?>
                                                    <!--</a>-->				
                                                </td>
                                                <td><?php echo $invoices_list['recurring_time']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($date_format == 1) {
                                                        echo date('d-m-Y', strtotime($invoices_list['final_date']));
                                                    } elseif ($date_format == 2) {
                                                        echo date('m-d-Y', strtotime($invoices_list['final_date']));
                                                    } elseif ($date_format == 3) {
                                                        echo date('Y-m-d', strtotime($invoices_list['final_date']));
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-right"><?php
                                                    if ($position == 0) {
                                                        echo $currency . $invoices_list['total_amount'];
                                                    } else {
                                                        echo $invoices_list['total_amount'] . $currency;
                                                    }
                                                    $total += $invoices_list['total_amount'];
                                                    ?>
                                                </td>
                                                <td>
                                        <center>
                                            <a href="javascript:void(0)" class="btn btn-info btn-xs" onclick="is_recurring('<?php echo $invoices_list['invoice_id']; ?>', '<?php echo $invoices_list['job_id']; ?>')" data-toggle="tooltip" data-placement="top" title="<?php echo display('is_recurring_invoice'); ?>"><i class="fa fa-repeat"> </i></a>
                                            <?php // echo form_open() ?>
                                                        <!--<a href="<?php echo base_url() . 'Cinvoice/invoice_inserted_data/' . $invoices_list['invoice_id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('invoice') ?>"><i class="fa fa-window-restore" aria-hidden="true"></i></a>-->
                                            <?php if ($this->permission1->check_label('manage_invoice')->read()->access()) { ?>
                                                <a href="<?php echo base_url() . 'Cjob/show_job_invoice/' . $invoices_list['job_id']; ?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left" title="<?php echo display('invoice') ?>"><i class="fa fa-window-restore" aria-hidden="true"></i></a>
                                            <?php } ?>
        <!--                                        <a href="<?php echo base_url() . 'Cinvoice/min_invoice_inserted_data/' . $invoices_list['invoice_id']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo 'Mini Invoice' ?>"><i class="fa fa-fax" aria-hidden="true"></i></a>
                        <a href="<?php echo base_url() . 'Cinvoice/pos_invoice_inserted_data/' . $invoices_list['invoice_id']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('pos_invoice') ?>"><i class="fa fa-fax" aria-hidden="true"></i></a>-->
                                            <?php if ($this->permission1->method('manage_invoice', 'update')->access()) { ?>

                                                                                                                                        <!--<a href="<?php echo base_url() . 'Cinvoice/invoice_update_form/' . $invoices_list['invoice_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->
                                            <?php } ?>
                                            <?php if ($this->permission1->method('manage_invoice', 'delete')->access()) { ?>
                                                                                                                                        <!--<a href="" class="deleteInvoice btn btn-danger btn-sm" name="<?php echo $invoices_list['invoice_id'] ?>" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>-->
                                            <?php } ?>
                                            <?php // echo form_close() ?>
                                        </center>
                                        </td>
                                        </tr>

                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                    <tr><td colspan="6"></td><td class="text-right"><?php
                                            $sttle = number_format($total, 2, '.', ',');
                                            if ($position == 0) {
                                                echo $currency . '' . $sttle;
                                            } else {
                                                echo $sttle . '' . $currency;
                                            }
                                            ?></td><td></td></tr>
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
<!-- Manage Invoice End -->
<div class="modal fade" id="modal_show_info" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title leftfloat"><?php echo display('recurring_invoice_generate'); ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="modal_info">
                <form action="<?php echo base_url('Cjob/recurring_invoice_save'); ?>" method="post">
                    <div class="form-group row">
                        <label for="recurring_time" class="col-sm-4 text-right"><?php echo display('recurring_invoice') ?> <i class="text-danger">*</i></label>
                        <div class="col-sm-3">
                            <select class="form-control" name ="recurring_time" id="recurring_time" data-placeholder="-- select one --" required>
                                <option value=""></option>
                                <?php for ($i = 1; $i < 12; $i++) { ?>
                                    <option value="<?php echo $i; ?>">Every <?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-control" name ="recurring_period" id="recurring_period" data-placeholder="-- select one --" required>
                                <option value=""></option>
                                <option value="week">Weeks</option>
                                <option value="month">Months</option>
                                <option value="year">Years</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-6">
                            <input type="hidden" name="job_id" id="job_id" value="">
                            <input type="hidden" name="invoice_id" id="invoice_id" value="">
                            <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save') ?>" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/custom/invoice.js'); ?>"></script>