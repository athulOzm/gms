<!-- Stock report start -->
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        document.body.style.marginTop = "0px";
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<!-- Supplier Ledger Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('supplier_ledger') ?></h1>
            <small><?php echo display('manage_supplier_ledger') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('supplier') ?></a></li>
                <li class="active"><?php echo display('supplier_ledger') ?></li>
            </ol>
        </div>
    </section>

    <!-- Supplier information -->
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

        <div class="row">
            <div class="col-sm-12">
                <div class="column m-b-10 float_right">
                    <?php if ($this->permission1->check_label('add_supplier')->create()->access()) { ?>
                        <a href="<?php echo base_url('Csupplier') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_supplier') ?> </a>
                        <?php
                    }
                    if ($this->permission1->check_label('manage_supplier')->read()->access()) {
                        ?>
                        <a href="<?php echo base_url('Csupplier/manage_supplier') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('manage_supplier') ?> </a>
                        <?php
                    }
                    if ($this->permission1->check_label('supplier_sales_details')->read()->access()) {
                        ?>
                        <!--<a href="<?php echo base_url('Csupplier/supplier_sales_details_all') ?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_sales_details') ?> </a>-->
                    <?php } ?>
                </div>
            </div>
        </div>



        <!-- Supplier ledger -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('supplier_ledger') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="printableArea m-l-2">
                            <?php if ($supplier_name) { ?>
                                <div class="text-center">
                                    <h3> {supplier_name} </h3>
                                    <h4><?php echo display('address') ?> : {address} </h4>
                                    <h4> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
                                </div>
                            <?php } ?>

                            <div class="table-responsive">

                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?php echo display('date') ?></th>
                                            <th class="text-center"><?php echo display('description') ?></th>
                                            <th class="text-center"><?php echo display('invoice_no') ?></th>
                                            <th class="text-center"><?php echo display('deposite_id') ?></th>
                                            <th class="text-right"><?php echo display('debit') ?></th>
                                            <th class="text-right"><?php echo display('credit') ?></th>
                                            <th class="text-right"><?php echo display('balance') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($ledgers) {
//                                        echo '<pre>';                                        print_r($ledgers);die();
                                            $sl = 0;
                                            $debit = $credit = $balance = 0;
                                            foreach ($ledgers as $ledger) {
                                                $sl++;
                                                ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php
                                                        if ($date_format == 1) {
                                                            echo date('d-m-Y', strtotime($ledger['date']));
                                                        } elseif ($date_format == 2) {
                                                            echo date('m-d-Y', strtotime($ledger['date']));
                                                        } elseif ($date_format == 3) {
                                                            echo date('Y-m-d', strtotime($ledger['date']));
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $ledger['description']; ?></td>
                                                    <td><a href="<?php echo base_url(); ?>Cpurchase/purchase_details_data/<?php echo $ledger['transaction_id']; ?>"><?php echo $ledger['chalan_no']; ?></a></td>
                                                    <td><?php echo @$ledger['deposit_no']; ?></td>
                                                    <td align="right">
                                                        <?php
                                                        if ($ledger['d_c'] == 'd') {
                                                            echo (($position == 0) ? "$currency " : " $currency");
                                                            echo number_format($ledger['amount'], 2, '.', ',');
                                                            $debit += $ledger['amount'];
//                                                         $d = 12;
                                                        } else {
                                                            $debit += '0.00';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td align="right">
                                                        <?php
                                                        if ($ledger['d_c'] == 'c') {
                                                            echo (($position == 0) ? "$currency " : " $currency");
                                                            echo number_format($ledger['amount'], 2, '.', ',');
                                                            $credit += $ledger['amount'];
                                                        } else {
                                                            $credit += '0.00';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td align='right'>
                                                        <?php
                                                        $balance = $debit - $credit;
                                                        echo (($position == 0) ? "$currency " : " $currency");
                                                        echo number_format($balance, 2, '.', ',');
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" align="right"><b><?php echo display('grand_total') ?>:</b></td>
                                            <td align="right"><b><?php
                                                    echo (($position == 0) ? "$currency " : "$currency");
                                                    echo number_format((@$debit), 2, '.', ',');
                                                    ?></b>
                                            </td>
                                            <td align="right"><b><?php
                                                    echo (($position == 0) ? "$currency " : "$currency");
                                                    echo number_format((@$credit), 2, '.', ',');
                                                    ?></b>
                                            </td>
                                            <td align="right"><b><?php
                                                    echo (($position == 0) ? "$currency " : "$currency");
                                                    echo number_format((@$balance), 2, '.', ',');
                                                    ?></b></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="text-right"><?php echo $links ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>