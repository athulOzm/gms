<table id="" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th><?php echo display('sl') ?></th>
            <th><?php echo display('customer_name') ?></th>
            <th><?php echo display('phone') ?></th>
            <th><?php echo display('email') ?></th>
            <th class="text-center"><?php echo display('balance') ?></th>
            <th><?php echo display('status'); ?></th>
            <th class="text-center"><?php echo display('action') ?>
                <?php echo form_open('Ccustomer/manage_customer', array('class' => 'form-inline', 'method' => 'post')) ?>
                <input type="hidden" name="all" value="all">
                <button type="submit" class="btn btn-success"><?php echo display('all') ?></button>
                <?php echo form_close() ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
//                                    echo '<pre>';                                    print_r($customers_list);
        if ($customers_list) {
            $subtotal = '0.00';
            foreach ($customers_list as $customer) {
                $sql = 'SELECT (SELECT SUM(amount) FROM customer_ledger WHERE d_c = "d" AND customer_id = "' . $customer['customer_id'] . '") dr, 
		(SELECT sum(amount) FROM customer_ledger WHERE d_c = "c" AND customer_id = "' . $customer['customer_id'] . '") cr';
                $result = $this->db->query($sql)->result();
                ?>
                <tr>
                    <td><?php echo $customer['sl']; ?></td>
                    <td>
                        <a href="<?php echo base_url() . 'Ccustomer/customerledger/' . $customer['customer_id']; ?>"><?php echo $customer['customer_name']; ?></a>				
                    </td>
                    <td><?php echo $customer['customer_phone']; ?></td>
                    <td><?php echo $customer['customer_email']; ?></td>

                    <td align="right">
                        <?php
//                                                    echo '<pre>';  print_r($result); 
                        echo (($position == 0) ? "$currency " : " $currency");
                        $balance = $result[0]->dr - $result[0]->cr;
                        echo $total = number_format($balance, '2', '.', ',');
                        $subtotal += $balance;
                        ?>
                    </td>
                    <td>
                        <select class="form-control" id="status" name="status" onchange="customer_status('<?php echo $customer['customer_id']; ?>', this.value)" data-placeholder="-- select one -- ">
                            <option value=""><?php echo display('select_one'); ?></option>
                            <option value="1" <?php
                            if ($customer['status'] == '1') {
                                echo 'selected';
                            }
                            ?>><?php echo display('active'); ?></option>
                            <option value="2" <?php
                            if ($customer['status'] == '2') {
                                echo 'selected';
                            }
                            ?>><?php echo display('inactive'); ?></option>
                        </select>
                    </td>
                    <td>
            <center>
                <?php echo form_open() ?>
                <?php if ($this->permission1->check_label('manage_customer')->update()->access()) { ?>
                    <a href="<?php echo base_url() . 'Ccustomer/customer_update_form/' . $customer['customer_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <?php } ?>
                <?php if ($this->permission1->check_label('manage_customer')->delete()->access()) { ?>

                    <a href="<?php echo base_url() . 'Ccustomer/customer_delete/' . $customer['customer_id']; ?>" onclick="return confirm('Are Your sure to delete?')" class=" btn btn-danger btn-sm" name="{customer_id}" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
        <td class="text-right" colspan="4"><b> <?php echo display('grand_total') ?></b></td>
        <td class="text-right">
            <b><?php
                $sttle = number_format($subtotal, 2, '.', ',');
                echo (($position == 0) ? "$currency $sttle" : "$sttle $currency")
                ?>
            </b>
        </td>
        <td></td>
        <td></td>
    </tr>
</tfoot>
</table>
<div class="text-right"><?php echo $links ?></div>