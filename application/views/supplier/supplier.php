<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/supplier.js.php" ></script>
<!-- Manage Supplier Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('manage_suppiler') ?></h1>
            <small><?php echo display('manage_your_supplier') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('supplier') ?></a></li>
                <li class="active"><?php echo display('manage_suppiler') ?></li>
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
                <div class="column m-b-10 float_right">
                    <?php if ($this->permission1->check_label('add_supplier')->create()->access()) { ?>
                        <a href="<?php echo base_url('Csupplier') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_supplier') ?> </a>
                        <?php
                    }
                    if ($this->permission1->check_label('supplier_ledger')->read()->access()) {
                        ?>
                        <!--<a href="<?php echo base_url('Csupplier/supplier_ledger_report') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_ledger') ?> </a>-->
                        <?php
                    }
                    if ($this->permission1->check_label('supplier_sales_details')->read()->access()) {
                        ?>
                        <!--<a href="<?php echo base_url('Csupplier/supplier_sales_details_all') ?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_sales_details') ?> </a>-->
                    <?php } ?>
                </div>
            </div>
        </div>


        <!-- Manage Supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <span class="text-center">
                                <a href="<?php echo base_url('Csupplier/supplier_downloadpdf') ?>" class="btn btn-warning">Pdf</a> 
                                <!--<a href="<?php echo base_url('Csupplier/exportCSV'); ?>" class="btn btn-success">Export CSV </a></span>-->
                        </div>
                        <span class="text-right">
                            <?php echo form_open('Csupplier/search_supplier', array('class' => 'form-inline', 'method' => 'post')) ?>

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
                            <table id="dataTableExample" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <!--<th>id</th>-->
                                        <th><?php echo display('supplier_id') ?></th>
                                        <th><?php echo display('supplier_name') ?></th>
                                        <th><?php echo display('address') ?></th>
                                        <th><?php echo display('phone') ?></th>
                                        <th class="text-right"><?php echo display('balance') ?></th>
                                        <th class="text-center"><?php echo display('action') ?>
                                            <?php echo form_open('Csupplier/manage_supplier', array('class' => 'form-inline', 'method' => 'post')) ?>
                                            <input type="hidden" name="all" value="all">
                                            <button type="submit" class="btn btn-success"><?php echo display('all') ?></button>
                                            <?php echo form_close() ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//                                    echo '<pre>'; print_r($suppliers_list);echo '</pre>';
                                    $total_balance = 0;
                                    if ($suppliers_list) {
                                        foreach ($suppliers_list as $supplier) {
                                            ?>
                                            <tr>
                                                <!--<td><?php echo $supplier['id']; ?></td>-->
                                                <td>
                                                    <a href="<?php echo base_url() . 'Csupplier/supplier_ledger_info/' . $supplier['supplier_id']; ?>">
                                                        <?php echo $supplier['supplier_id']; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url() . 'Csupplier/supplier_ledger_info/' . $supplier['supplier_id']; ?>">
                                                        <?php echo $supplier['supplier_name']; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $supplier['address']; ?></td>
                                                <td><?php echo $supplier['phone']; ?></td>
                                                <td class="text-right"><?php
                                                    $debit = $this->db->select('SUM(amount) as total_debit')->from('supplier_ledger')->where('supplier_id', $supplier['supplier_id'])->where('d_c', 'd')->get()->row();
                                                    $credit = $this->db->select('SUM(amount) as total_credit')->from('supplier_ledger')->where('supplier_id', $supplier['supplier_id'])->where('d_c', 'c')->get()->row();
                                                    $balance = $debit->total_debit - $credit->total_credit;
                                                    if ($position == 0) {
                                                        echo $currency . ' ' . number_format($balance, 2, '.', ',');
                                                    } else {
                                                        echo number_format($balance, 2, '.', ',') . '' . $currency;
                                                    }

                                                    $total_balance += $balance;
                                                    ?></td>
                                                <td class="text-center">
                                                    <?php echo form_open() ?>
                                                    <?php if ($this->permission1->check_label('manage_supplier')->update()->access()) { ?>
                                                        <a href="<?php echo base_url() . 'Csupplier/supplier_update_form/' . $supplier['supplier_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        <?php
                                                    }
                                                    if ($this->permission1->check_label('manage_supplier')->delete()->access()) {
                                                        ?>
                                                        <a href="javascript:void(0)" class="deleteSupplier btn btn-danger btn-sm" name="<?php echo $supplier['supplier_id']; ?>" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                    <?php } ?>
                                                    <?php echo form_close() ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right"><b><?php echo display('total') ?></b></td><td class="text-right"><?php
                                            if ($position == 0) {
                                                echo $currency . ' ' . number_format($total_balance, 2, '.', ',');
                                            } else {
                                                echo number_format($total_balance, 2, '.', ',') . '' . $currency;
                                            }
                                            ?></td><td></td></tr>
                                </tfoot>

                            </table>
                            <!--<div class="text-center"><?php echo $links ?></div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="supplierDeleteURL" value="<?php echo base_url('Csupplier/supplier_delete') ?>">
</div>
<script src="<?php echo base_url('assets/custom/supplier.js'); ?>"></script>