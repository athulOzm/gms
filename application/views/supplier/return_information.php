<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo display('sl'); ?></th>
            <th><?php echo display('product_name'); ?></th>
            <th style="text-align: center;"><?php echo display('qty'); ?></th>
            <th style="text-align: right;"><?php echo display('rate'); ?></th>
            <th style="text-align: right;"><?php echo display('amount'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
//        d($get_return_info);
        $sl = $amount = 0;
        foreach ($get_return_info as $return) {
            $sl++;
            ?>
            <tr>
                <td><?php echo $sl; ?></td>
                <td><?php echo $return->product_name; ?></td>
                <td style="text-align: center;"><?php echo $return->ret_qty; ?></td>
                <td style="text-align: right;"><?php echo $return->product_rate; ?></td>
                <td style="text-align: right;">
                    <?php
                    $amount += $return->total_ret_amount;
                    echo $return->total_ret_amount;
                    ?>
                </td>
            </tr>
        <?php } ?>
        <tr>                
            <th colspan="4" class="text-right"><?php echo display('total_amount'); ?></th>
            <th class="text-right">
                <?php echo number_format($amount, 2, '.',','); ?>
                <input type="hidden" name="amount" value="<?php echo $amount; ?>">
            </th>
        </tr>
    </tbody>
    <?php if (empty($get_return_info)) { ?>
        <tfoot>
            <tr>
                <th colspan="6" class="text-center text-danger"><?php echo display('data_not_found'); ?></th>
            </tr>
        </tfoot>
    <?php } ?>
</table>