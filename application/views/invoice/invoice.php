<link href="<?php echo base_url('assets/custom/invoice.css') ?>" rel="stylesheet" type="text/css"/>
<!-- Manage Invoice Start -->
<?php
$user_id = $this->session->userdata('user_id');
$user_type = $this->session->userdata('user_type');
?>
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

        <!-- date between search -->
        <?php
        if ($user_type != 3) {
            ?>
            <div class="row">
                <?php // dd($invoices_list); ?>
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <div class="row col-sm-12">
                            <div class="row col-sm-8">
                                <?php echo form_open('Cinvoice/date_to_date_invoice', array('class' => 'form-inline', 'method' => 'get')) ?>
                                <?php
                                date_default_timezone_set("Asia/Dhaka");
                                $today = date('Y-m-d');
                                ?>
                                <div class="form-group">
                                    <label class="" for="from_date"><?php echo display('start_date') ?></label>
                                    <input type="text" name="from_date" class="form-control datepicker" id="from_date" value="<?php echo $today ?>" placeholder="<?php echo display('start_date') ?>" >
                                </div> 
                                <div class="form-group">
                                    <label class="" for="to_date"><?php echo display('end_date') ?></label>
                                    <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo $today ?>">
                                </div>  
                                <button type="submit" class="btn btn-success"><?php echo display('find') ?></button>
                            </div>
                            <?php echo form_close() ?>
                            <div class="form-group col-sm-4">
                                <form action="<?php echo base_url('Cinvoice/manage_invoice_invoice_id') ?>" class="form-inline" method="post" accept-charset="utf-8">
                                    <label for="invoice_no"><?php echo display('invoice_no') ?></label>
                                    <input type="text" id="invoice_no" class="form-control" name="invoice_no" placeholder="<?php echo display('invoice_no') ?>" required>
                                    <button type="submit" class="btn btn-primary btn-sm"><?php echo display('find') ?></button>     
                                </form>  
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row"> 
        </div>
        <!-- Manage Invoice report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <?php if ($user_type != 3) { ?>
                        <div class="panel-heading">
                            <span class="text-center">
                                <a href="<?php echo base_url('Cinvoice/sale_downloadpdf') ?>" class="btn btn-warning">Pdf</a>
                                <a href="<?php echo base_url('Cinvoice/exportinvocsv'); ?>" class="btn btn-success">Export CSV </a>

                            </span>
                            <span class="text-right">
                                <?php echo form_open('Cinvoice/invoice_search', array('class' => 'form-inline', 'method' => 'get')) ?>
                                <div class="form-group">
                                    <input type="text"   name="customer_name" class=" form-control" placeholder='<?php echo display('customer_name') . '/' . display('phone') ?>' id="customer_name"  onkeyup="customer_autocomplete()"/>
                                    <input id="autocomplete_customer_id" class="customer_hidden_value abc" type="hidden" name="customer_id">
                                </div>  
                                <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
                                <?php echo form_close() ?>
                            </span>
                        </div>
                    <?php } ?>
                    <div class="panel-body">
                        <div class="table-responsive" id="invoic_list">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width='10%'><?php echo display('sl') ?></th>
                                        <th width='10%'><?php echo display('invoice_no') ?></th>
                                        <th width='15%'><?php echo display('invoice_id') ?></th>
                                        <th width='20%'><?php echo display('customer_name') ?></th>
                                        <th width="10%"><?php echo display('recurring_time'); ?></th>
                                        <th width='10%'><?php echo display('date') ?></th>
                                        <th width='10%'><?php echo display('amount') ?></th>
                                        <th class="text-center" width='15%'><?php echo display('action') ?>
                                            <?php echo form_open('Cinvoice/manage_invoice', array('class' => 'form-inline', 'method' => 'post')) ?>
<!--                                            <input type="hidden" name="all" value="all">
                                            <button type="submit" class="btn btn-success"><?php echo display('all') ?></button>-->
                                            <?php echo form_close() ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//                                    dd($invoices_list);
                                    $total = '0.00';
                                    if ($invoices_list) {
                                        foreach ($invoices_list as $invoices_list) {
                                            $get_jobinfo = $this->db->select('a.*')->from('job a')->where('a.job_id', $invoices_list['job_id'])->get()->row();
                                            ?>
                                            <tr>
                                                <td><?php echo $invoices_list['sl']; ?></td>
                                                <td>
                                                    <!--<a href="<?php echo base_url() . 'Cinvoice/invoice_inserted_data/' . $invoices_list['invoice_id']; ?>">-->
                                                    <a href="<?php echo base_url() . 'Cjob/show_job_invoice/' . $invoices_list['job_id']; ?>">
                                                        <?php echo $invoices_list['invoice']; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url() . 'Cjob/show_job_invoice/' . $invoices_list['job_id']; ?>">
                                                        <?php echo $invoices_list['invoice_id'] ?>  
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url() . 'Ccustomer/customerledger/' . $invoices_list['customer_id']; ?>">
                                                        <?php echo $invoices_list['customer_name'] ?>
                                                    </a>				
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
                                                <td class="text-right">
                                                    <?php
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
                                            <?php if ($get_jobinfo->is_quotation == 1) { ?>
                                                <a href="<?php echo base_url() . 'Cquotation/quotation_details_data/' . $get_jobinfo->quotation_id; ?>" class="btn btn-warning btn-xs"   title="<?php echo 'Quotation Details' ?>" data-toggle="tooltip" data-placement="top"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <?php
                                            }
                                            if ($get_jobinfo->is_quotation == 0) {
                                                ?>
                                                <a href="<?php echo base_url('Cjob/show_job/' . $get_jobinfo->job_id); ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="<?php echo display('show_job_information'); ?>">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <?php
                                            }
// echo form_open() 
                                            ?>
        <!--<a href="<?php echo base_url() . 'Cinvoice/invoice_inserted_data/' . $invoices_list['invoice_id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('invoice') ?>"><i class="fa fa-window-restore" aria-hidden="true"></i></a>-->
                                            <?php if ($this->permission1->check_label('manage_invoice')->read()->access()) { ?>
                                                <a href="<?php echo base_url() . 'Cjob/show_job_invoice/' . $invoices_list['job_id']; ?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left" title="<?php echo display('invoice') ?>"><i class="fa fa-window-restore" aria-hidden="true"></i></a>
                                            <?php } ?>
                                            <a href="javascript:void(0)" class="btn btn-info btn-xs" onclick="<?php if ($invoices_list['is_recurring'] != 1) { ?>is_recurring('<?php echo $invoices_list['invoice_id']; ?>', '<?php echo $invoices_list['job_id']; ?>') <?php } ?>" data-toggle="tooltip" data-placement="top" title="<?php
                                            if ($invoices_list['is_recurring'] != 1) {
                                                echo display('is_recurring_invoice');
                                            } else {
                                                echo display('already_assigned');
                                            }
                                            ?>"><i class="fa fa-repeat"> </i></a>
        <!--                                        <a href="<?php echo base_url() . 'Cinvoice/min_invoice_inserted_data/' . $invoices_list['invoice_id']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo 'Mini Invoice' ?>"><i class="fa fa-fax" aria-hidden="true"></i></a>
                        <a href="<?php echo base_url() . 'Cinvoice/pos_invoice_inserted_data/' . $invoices_list['invoice_id']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('pos_invoice') ?>"><i class="fa fa-fax" aria-hidden="true"></i></a>-->
                                            <?php if ($this->permission1->method('manage_invoice', 'update')->access()) { ?>

                                                                                                <!--<a href="<?php echo base_url() . 'Cinvoice/invoice_update_form/' . $invoices_list['invoice_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>-->
                                            <?php } ?>
                                            <?php if ($this->permission1->method('manage_invoice', 'delete')->access()) { ?>
                                                                                                <!--<a href="" class="deleteInvoice btn btn-danger btn-sm" name="<?php echo $invoices_list['invoice_id'] ?>" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>-->
                                            <?php } ?>
                                            <?php // echo form_close()    ?>
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
                <h5 class="modal-title leftfloat" ><?php echo display('recurring_invoice_generate'); ?></h5>
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
    <input type="hidden" id="customerAutocompleteURL" value="<?php echo base_url('Cinvoice/customer_autocomplete') ?>">
</div>

<!-- Delete Invoice ajax code -->
<script src="<?php echo base_url('assets/custom/invoice.js'); ?>"></script>