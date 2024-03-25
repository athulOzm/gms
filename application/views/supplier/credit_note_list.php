<!-- Supplier Details Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('credit_note_list') ?></h1>
            <small><?php echo display('credit_note_list') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('supplier') ?></a></li>
                <li class="active"><?php echo display('credit_note_list') ?></li>
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
                <div class="column m-b-10" style="float: right;">
                    <?php if ($this->permission1->check_label('add_supplier')->create()->access()) { ?>
                        <a href="<?php echo base_url('Csupplier') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_supplier') ?> </a>
                        <?php
                    }
                    if ($this->permission1->check_label('manage_supplier')->read()->access()) {
                        ?>
                        <a href="<?php echo base_url('Csupplier/manage_supplier') ?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_supplier') ?> </a>
                        <?php
                    }
                    if ($this->permission1->check_label('supplier_ledger')->read()->access()) {
                        ?>
                        <a href="<?php echo base_url('Csupplier/supplier_ledger_report') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_ledger') ?> </a>
                        <?php
                    }
                    if ($this->permission1->check_label('supplier_credit_note')->read()->access()) {
                        ?>
                        <a href="<?php echo base_url('Csupplier/supplier_credit_note') ?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_credit_note') ?> </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('credit_note_list') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?php echo display('sl'); ?></th>
                                    <th><?php echo display('credit_note_no'); ?></th>
                                    <th style="text-align: left;"><?php echo display('supplier_name'); ?></th>
                                    <th style="text-align: left;"><?php echo display('purchase_id'); ?></th>
                                    <th style="text-align: center;"><?php echo display('date'); ?></th>
                                    <th style="text-align: right;"><?php echo display('amount'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
//                                dd($currency_details);
                                $currency = $currency_details[0]['currency'];
                                $position = $currency_details[0]['currency_position'];
                                if ($get_creditnote_list) {
                                    $sl = 0;
                                    foreach ($get_creditnote_list as $creditnote) {
                                        $sl++;
                                        ?>
                                        <tr>
                                            <td><?php echo $sl; ?></td>
                                            <td><?php echo $creditnote->credit_note_no; ?></td>
                                            <td>
                                                <a href="<?php echo base_url('Csupplier/supplier_ledger_info/' . $creditnote->supplier_id); ?>">
                                                    <?php echo $creditnote->supplier_name; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url('Cpurchase/purchase_details_data/' . $creditnote->purchase_id); ?>">
                                                    <?php echo $creditnote->purchase_id; ?>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $CI = & get_instance();
                                                $CI->load->library('occational');
//                                                if ($date_format == 1) {
//                                                    echo date('d-m-Y', strtotime($creditnote->date));
//                                                } elseif ($date_format == 2) {
//                                                    echo date('m-d-Y', strtotime($creditnote->date));
//                                                } elseif ($date_format == 3) {
//                                                    echo date('Y-m-d', strtotime($creditnote->date));
//                                                }
                                                echo $CI->occational->dateConvertMyformat($creditnote->date);
                                                ?>                                            
                                            </td>
                                            <td class="text-right">
                                                <?php
                                                echo (($position == 0) ? "$currency " : " $currency");
                                                echo $creditnote->amount;
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <?php if (empty($get_creditnote_list)) { ?>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-center text-danger"><?php echo display('record_not_found'); ?></th>
                                    </tr>
                                </tfoot>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
<!-- Supplier Details End  -->