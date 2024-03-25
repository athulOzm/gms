<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('quotation') ?></h1>
            <small><?php echo display('manage_quotation') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('quotation') ?></a></li>
                <li class="active"><?php echo display('manage_quotation') ?></li>
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
        $currency = $currency_details[0]['currency'];
        $position = $currency_details[0]['currency_position'];
        ?>


        <!-- New category -->
        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="form-group row">
                    <!--                                                        <div class="col-sm-1 dropdown">
                                                                                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"> </i> Action
                                                                                    <span class="caret"></span></button>
                                                                                <ul class="dropdown-menu">
                                                                                    <li><a href="javascript:void(0)" onClick="ExportMethod('<?php echo base_url(); ?>menu-export-csv')" class="dropdown-item">Export to CSV</a></li>
                                                                                    <li><a href="javascript:void(0)"  data-toggle="modal" data-target="#importMenu" class="dropdown-item">Import from CSV</a></li>
                                                                                </ul>
                                                                            </div>-->
                    <label for="keyword" class="col-sm-offset-8 col-sm-2 col-form-label text-right"></label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="keyword" id="keyword" onkeyup="quotationonkeyup_search()" placeholder="Search..." tabindex="">
                    </div>
                </div>          
            </div>
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('manage_quotation') ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive" id="results">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('sl') ?></th>
                                        <th class=""><?php echo display('customer_name') ?></th>
                                        <th class=""><?php echo display('quotation_no') ?></th>
                                        <th class=""><?php echo display('quotation_date') ?></th>
                                        <th class="text-right"><?php echo display('total_amount') ?></th>
                                        <th class=""><?php echo display('status') ?></th>
                                        <th class="text-center"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($quotation_list) {
                                        $sl = 0;
                                        foreach ($quotation_list as $quotation) {
                                            $sl++;
                                            ?>
                                            <tr>
                                                <td><?php echo $sl; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url('Ccustomer/customerledger/' . $quotation->customer_id); ?>">
                                                        <?php echo $quotation->customer_name; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url('Cquotation/quotation_details_data/' . $quotation->quotation_id); ?>">
                                                        <?php echo $quotation->quot_no; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($date_format == 1) {
                                                        echo date('d-m-Y', strtotime($quotation->quotdate));
                                                    } elseif ($date_format == 2) {
                                                        echo date('m-d-Y', strtotime($quotation->quotdate));
                                                    } elseif ($date_format == 3) {
                                                        echo date('Y-m-d', strtotime($quotation->quotdate));
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php echo (($position == 0) ? "$currency $quotation->totalamount" : "$quotation->totalamount $currency"); ?>
                                                </td>
                                                <td><?php
                                                    if ($quotation->status == 1) {
                                                        echo 'New';
                                                    }
                                                    if ($quotation->status == 2) {
                                                        echo 'Pending';
                                                    }
                                                    if ($quotation->status == 3) {
                                                        echo 'Accept';
                                                    }
                                                    if ($quotation->status == 4) {
                                                        echo 'Decline';
                                                    }
                                                    ?></td>

                                                <td class="text-center">
                                                    <?php if ($this->permission1->check_label('manage_quotation')->read()->access()) { ?>
                                                        <a href="<?php echo base_url() . 'Cquotation/quotation_details_data/' . $quotation->quotation_id; ?>" class="btn btn-info btn-sm"   title="" data-original-title="<?php echo 'details' ?> "><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        <?php
                                                    }
                                                    if ($this->permission1->check_label('manage_quotation')->update()->access()) {
                                                        ?>
                                                        <a href="<?php
                                                        if ($quotation->status == 3) {
                                                            echo "javascript:void(0)";
                                                        } else {
                                                            echo base_url('Cquotation/quotation_edit_data/' . $quotation->quotation_id);
                                                        }
                                                        ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="<?php
                                                           if ($quotation->status == 3) {
                                                               echo display('quotation_goto_job');
                                                           } else {
                                                               echo display('edit');
                                                           }
                                                           ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                           <?php
                                                       }
                                                       if ($this->permission1->check_label('manage_quotation')->delete()->access()) {
                                                           ?>
                                                        <a href="<?php echo base_url() . 'Cquotation/delete_quotation/' . $quotation->quotation_id; ?>" class="btn btn-danger btn-sm"  onclick="return confirm('Are You Sure To Want to Delete ??')" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                    <?php } ?>
                                                    <a href="<?php echo base_url('Cquotation/quotation_download/' . $quotation->quotation_id); ?>" class="btn btn-primary btn-sm"  title="" data-original-title="<?php echo display('download') ?> "><i class="fa fa-download" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                                <?php if (empty($quotation_list)) { ?>
                                    <tfoot>
                                        <tr>
                                            <th colspan="7" class="text-danger text-center"><?php echo display('data_not_found'); ?></th>
                                        </tr>
                                    </tfoot>
                                <?php } ?>
                            </table>
                            <?php echo $links; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="quotationkeyupsearch" value="<?php echo base_url('Cquotation/quotaionnkeyup_search'); ?>">
</div>

<script src="<?php echo base_url('assets/custom/quotation.js') ?>"></script>