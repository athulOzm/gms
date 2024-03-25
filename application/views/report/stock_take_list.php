
<?php
$position = $currency_details[0]['currency_position'];
$currency = $currency_details[0]['currency'];
?>
<!-- Stock List Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('stock') ?></h1>
            <small><?php echo display('stock_take_list') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('stock') ?></a></li>
                <li class="active"><?php echo display('stock_take_list') ?></li>
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
                <div class="column m-b-5 float_right">
                    <?php if ($this->permission1->check_label('stock_report_supplier_wise')->read()->access()) { ?>
                        <a href="<?php echo base_url('Creport/stock_report_supplier_wise') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('stock_report_supplier_wise') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->check_label('stock_report_product_wise')->read()->access()) { ?>
                        <a href="<?php echo base_url('Creport/stock_report_product_wise') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('stock_report_product_wise') ?> </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <?php echo display('stock_take_list'); ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="printableArea" class="table-responsive m-l-2">
                            <table id="" class="table table-bordered table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <th><?php echo display('sl'); ?></th>
                                        <th class='text-center'><?php echo display('date'); ?></th>
                                        <th class='text-center'><?php echo display('adjustment_type'); ?></th>
                                        <th><?php echo display('notes'); ?></th>
                                        <th><?php echo display('product'); ?></th>
                                        <th class="text-right"><?php echo display('total_amount'); ?></th>
                                    </tr>
                                    <?php
                                    $sl = 0+$pagenum;
                                    foreach ($get_stocktakelist as $stocktake) {
                                        $this->db->select('b.product_name, a.in_qty, a.out_qty');
                                        $this->db->from('stock_tbl a');
                                        $this->db->join('product_information b', 'b.product_id = a.product_id');
                                        $this->db->where('a.voucher_no', $stocktake->adjustment_id);
                                        $product_info = $this->db->get()->result();
//                                        d($product_info);
                                        $sl++;
                                        ?>
                                        <tr>
                                            <td><?php echo $sl; ?></td>
                                            <td class='text-center'><?php echo $stocktake->date; ?></td>
                                            <td class='text-center'>
                                                <?php
                                                if ($stocktake->adjustment_type == 1) {
                                                    echo 'Stock In';
                                                } elseif ($stocktake->adjustment_type == 2) {
                                                    echo 'Stock Out';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $stocktake->details; ?></td>
                                            <td>
                                                <?php foreach ($product_info as $product) { ?>
                                                    <?php
                                                    echo $product->product_name . " -> ";
                                                    if ($stocktake->adjustment_type == 1) {
                                                        echo $product->in_qty;
                                                    }
                                                    if ($stocktake->adjustment_type == 2) {
                                                        echo $product->out_qty;
                                                    }
                                                    echo '<br>';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-right">
                                                <?php
                                                echo (($position == 0) ? "$currency $stocktake->grand_total" : "$stocktake->grand_total $currency");
                                                ?>
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
<!-- Stock List End