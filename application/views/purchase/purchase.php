
<!-- Manage Purchase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('manage_purchase') ?></h1>
            <small><?php echo display('manage_your_purchase') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('purchase') ?></a></li>
                <li class="active"><?php echo display('manage_purchase') ?></li>
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


        <div class="panel panel-default">
            <div class="panel-body"> 
                <div class="row">
                    <div class="col-sm-7">
                        <form action="<?php echo base_url('Cpurchase/manage_purchase_date_to_date') ?>" class="form-inline" method="post" accept-charset="utf-8">
                            <?php $today = date('Y-m-d'); ?>
                            <div class="form-group">
                                <label class="" for="from_date"><?php echo display('from') ?></label>
                                <input type="text" name="from_date" class="form-control datepicker" id="from_date" value="<?php echo $today ?>" placeholder="<?php echo display('start_date') ?>" >
                            </div> 

                            <div class="form-group">
                                <label class="" for="to_date"><?php echo display('to') ?></label>
                                <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo $today ?>">
                            </div>  

                            <button type="submit" class="btn btn-success"><?php echo display('find') ?></button>

                        </form>	
                    </div>
                    <div class="col-sm-5">
                        <form action="<?php echo base_url('Cpurchase/purchase_info_id') ?>" class="form-inline" method="post" accept-charset="utf-8">
                            <label for="invoice_no"><?php echo display('purchase_no') ?></label>

                            <input type="text" class="form-control" name="invoice_no" placeholder="<?php echo display('purchase_no') ?>">
                            <button type="submit" class="btn btn-primary"><?php echo display('find') ?></button>     
                        </form>		
                    </div>
                </div>
            </div>


        </div>



        <div class="row">
            <div class="col-sm-12">
                <div class="column m-b-5 float_right">
                    <?php if ($this->permission1->check_label('add_purchase')->create()->access()) { ?>
                        <a href="<?php echo base_url('Cpurchase') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_purchase') ?> </a>
                    <?php } ?>
                </div>
            </div>
        </div>


        <!-- Manage Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <span class="text-center">
                                <a href="<?php echo base_url('Cpurchase/purchase_downloadpdf') ?>" class="btn btn-warning">Pdf</a> 
                                <a href="<?php echo base_url('Cpurchase/exportinvocsv'); ?>" class="btn btn-success">Export CSV </a></span>
                        </div>
                        <span class="text-right">
                            <?php echo form_open('Cpurchase/purchase_search', array('class' => 'form-inline', 'method' => 'get')) ?>
                            <div class="form-group">
                                <input type="text"   name="supplier_name" class="supplierSelection form-control" placeholder='<?php echo display('supplier_name') ?>' id="supplier_name" tabindex="1" />
                                <input id="SchoolHiddenId" class="supplier_hidden_value abc" type="hidden" name="supplier_id">
                            </div>  
                            <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
                            <?php echo form_close() ?>
                        </span>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('purchase_no') ?></th>
                                        <th><?php echo display('purchase_id') ?></th>
                                        <th><?php echo display('supplier_name') ?></th>
                                        <th><?php echo display('purchase_date') ?></th>
                                        <th class="text-right"><?php echo display('total_ammount') ?></th>
                                        <th class="text-center"><?php echo display('action') ?>
                                            <?php echo form_open('Cpurchase/manage_purchase', array('class' => 'form-inline', 'method' => 'post')) ?>
                                            <input type="hidden" name="all" value="all">
                                            <button type="submit" class="btn btn-success"><?php echo display('all') ?></button>
                                            <?php echo form_close() ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $subtotal = '0.00';
                                    if ($purchases_list) {

                                        foreach ($purchases_list as $purchase) {
                                            ?>
                                            <tr>
                                                <td><?php echo $purchase['sl']; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url() . 'Cpurchase/purchase_details_data/' . $purchase['purchase_id']; ?>">
                                                        <?php echo $purchase['chalan_no'] ?>	
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url() . 'Cpurchase/purchase_details_data/' . $purchase['purchase_id']; ?>">
                                                        <?php echo $purchase['purchase_id'] ?>	
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url() . 'Csupplier/supplier_details/' . $purchase['supplier_id']; ?>">
                                                        <?php echo $purchase['supplier_name'] ?>	
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($date_format == 1) {
                                                        echo date('d-m-Y', strtotime($purchase['final_date']));
                                                    } elseif ($date_format == 2) {
                                                        echo date('m-d-Y', strtotime($purchase['final_date']));
                                                    } elseif ($date_format == 3) {
                                                        echo date('Y-m-d', strtotime($purchase['final_date']));
                                                    }
                                                    ?>
                                                </td>
                                                <td style="text-align: right;"><?php
                                                    if (($position == 0)) {
                                                        echo $currency . ' ' . $purchase['grand_total_amount'];
                                                    } else {
                                                        echo $purchase['grand_total_amount'] . ' ' . $currency;
                                                    }
                                                    $subtotal += $purchase['grand_total_amount'];
                                                    ?>
                                                </td>
                                                <td>
                                        <center>
                                            <?php echo form_open() ?>
                                            <?php if ($this->permission1->check_label('manage_purchase')->update()->access()) { ?>								
                                                <a href="<?php echo base_url() . 'Cpurchase/purchase_update_form/' . $purchase['purchase_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <?php } ?>

                                            <?php if ($this->permission1->check_label('manage_purchase')->delete()->access()) { ?>
                                                <a href="<?php echo base_url() . 'Cpurchase/delete_purchase/' . $purchase['purchase_id']; ?>" onclick="return confirm('<?php echo "Are your sure to want to delete ?"; ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('delete') ?> "><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                                        <td class="text-center" colspan="4"><b><?php echo display('total') ?></b></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php
                                            if (($position == 0)) {
                                                echo $currency . ' ' . $subtotal;
                                            } else {
                                                echo $subtotal . ' ' . $currency;
                                            }
                                            ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="text-right"><?php echo $links ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Manage Purchase End -->
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/supplier.js.php" ></script>