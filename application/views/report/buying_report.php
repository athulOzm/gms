
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('report') ?></h1>
            <small><?php echo display('buying_report') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('report') ?></a></li>
                <li class="active"><?php echo display('buying_report') ?></li>
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
        $currency = $currency_details[0]['currency'];
        $position = $currency_details[0]['currency_position'];
        ?>


        <div class="row">
            <div class="col-sm-12">
                <!--                <div class="column">
                <?php if ($this->permission1->check_label('add_job_type')->create()->access()) { ?>
                                                <a href="<?php echo base_url('Cjob/add_job_type') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('add_job_type') ?> </a>
                <?php } ?>
                                </div>-->
            </div>
        </div>
        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('buying_report') ?> </h4>
                            <a  class="btn btn-info" href="#" onclick="printDiv('printableArea')"><i class="fa fa-print"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php //d($buying_report); ?>
                        <div class="row">
                            <div class="table-responsive" id="printableArea">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('sl'); ?></th>
                                            <th><?php echo display('product_name'); ?></th>
                                            <th><?php echo display('purchase_date'); ?></th>
                                            <th class="text-center"><?php echo display('quantity'); ?></th>
                                            <th class="text-right"><?php echo display('supplier_price'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // d($allmechanic);
                                        $sl = 0 + $pagenum;
                                        foreach ($buying_report as $single) {
                                            $sl++;
                                            ?>
                                            <tr>
                                                <td><?php echo $sl; ?></td>
                                                <td><?php echo $single->product_name; ?></td>
                                                <td><?php echo $single->purchase_date; ?></td>
                                                <td class="text-center"><?php echo $single->quantity; ?></td>
                                                <td class="text-right">
                                                    <?php echo (($position == 0) ? "$currency  $single->supplier_price " : " $single->supplier_price $currency"); ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php echo $links; ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
    </section>
</div>
<!-- Add new category end -->