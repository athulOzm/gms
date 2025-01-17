<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
<!--                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('stock_report') ?></h4>
                        </div>
                    </div>-->
                    <div class="panel-body">
                        <div id="printableArea" style="margin-left:2px;">

<!--                            <table>

                                <tr>
                                    <td align="left" style="border-bottom:2px #333 solid;">
                                        <img src="<?php echo $software_info[0]['logo']; ?>" alt="logo">
                                    </td>
                                </tr>            

                            </table>-->
                            <div class="table-responsive" style="margin-top: 10px;">
                                <table border="1" width="100%" style="margin-top:25px;border-collapse:collapse;">
                                    <caption style="text-align: center;">
                                        {company_info}
                                        <address style="margin-top:10px">
                                            <strong style="font-size: 20px; ">{company_name}</strong><br>
                                            {address}<br>
                                            <abbr><b><?php echo display('mobile') ?>:</b></abbr> {mobile}<br>
                                            <abbr><b><?php echo display('email') ?>:</b></abbr> 
                                            {email}<br>
                                            <abbr><b><?php echo display('website') ?>:</b></abbr> 
                                            {website}
                                        </address>

                                        {/company_info}
                                        <h4><?php echo display('stock_report') ?></h4>
                                    </caption>
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?php echo display('sl') ?></th>
                                            <th class="text-center"><?php echo display('product_name') ?></th>
                                            <th class="text-center"><?php echo display('product_model') ?></th>
                                            <th class="text-center"><?php echo display('unit') ?></th>
                                            <th class="text-center"><?php echo display('sell_price') ?></th>
                                            <th class="text-center"><?php echo display('in_qnty') ?></th>
                                            <th class="text-center"><?php echo display('out_qnty') ?></th>
                                            <th class="text-center"><?php echo display('stock') ?></th>
                                            <th class="text-center"><?php echo display('stock_sale') ?>

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($stok_report) {
                                            ?>
                                            <?php $sl = 1; ?>
                                            <?php
                                            foreach ($stok_report as $stok_report) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $sl; ?></td>
                                                    <td align="center">
                                                        <a href="<?php echo base_url() . 'Cproduct/product_details/' . $stok_report['product_id']; ?>">
                                                            <?php echo $stok_report['product_name']; ?>
                                                        </a>	
                                                    </td>
                                                    <td align="center">
                                                        <?php echo $stok_report['product_model']; ?>
                                                        <br><small><?php echo $stok_report['serial_no']; ?></small>
                                                    </td>                                                    
                                                    <td align="center"><?php echo $stok_report['unit']; ?></td>
                                                    <td style="text-align: right;"><?php
                                                        echo (($position == 0) ? "$currency " : "$currency");
                                                        echo $stok_report['sales_price'];
                                                        ?>
                                                    </td>

                                                    <td align="center">
                                                        <?php
                                                        $totalPurchaseQnty = $stok_report['totalPurchaseQnty'];
//                                                        "$currency " . ? sign er por chilo 
                                                        echo (($position == 0) ? number_format($totalPurchaseQnty, 2, '.', ',') : number_format($totalPurchaseQnty, 2, '.', ',') . " $currency");
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php
                                                        $totalSalesQnty = $stok_report['totalSalesQnty'];
                                                        echo (($position == 0) ? number_format($totalSalesQnty, 2, '.', ',') : number_format($totalSalesQnty, 2, '.', ',') . " $currency");
                                                        ?>
                                                    </td>
                                                    <td align="center"><?php
                                                        $stok_quantity_cartoon = $stok_report['stok_quantity_cartoon'];
                                                        echo (($position == 0) ? number_format($stok_quantity_cartoon, 2, '.', ',') : number_format($stok_quantity_cartoon, 2, '.', ',') . " $currency");
                                                        ?></td>
                                                    <td align="center"><?php
                                                        $total_sale_price = $stok_report['total_sale_price'];
                                                        echo (($position == 0) ? "$currency " . number_format($total_sale_price, 2, '.', ',') : number_format($total_sale_price, 2, '.', ',') . " $currency");
                                                        ?></td>
                                                </tr>
                                                <?php $sl++; ?>
                                                <?php
                                            }
                                        } else {
                                            ?>                                            
                                            <tr>
                                                <th class="text-center" colspan="6"><?php echo display('not_found'); ?></th>
                                            </tr> 
                                        <?php }
                                        ?>
                                    </tbody>
                                   <!--  <tfoot>
                                        <tr>
                                            <td colspan="5" align="right"><b><?php echo display('grand_total') ?>:</b></td>
                                            <td align="center"><b>{sub_total_in}</b></td>
                                            <td align="center"><b>{sub_total_out}</b></td>
                                            <td align="center"><b>{sub_total_stock}</td>
                                            <td align="center"><b><?php echo $currency ?> {stock_sale}</td>
                                        </tr>
                                    </tfoot> -->
                                </table>
                            </div>
                        </div>
                        <div class="text-center">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Stock List End