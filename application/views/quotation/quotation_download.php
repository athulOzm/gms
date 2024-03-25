<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
$logo = $Web_settings[0]['logo'];
$currency = $currency_details[0]['currency'];
$position = $currency_details[0]['currency_position'];
?>
<style type="text/css">
    table {
        border-collapse: collapse;
        width: 100%;
    }

    table, th, td {
        border: 1px solid black;
    }
</style>
<div class="printableArea" id="printableArea">
    <div class="row">
        <?php // echo dd($company_info); ?>
        <div class="" style="text-align: center;">
            <img src="<?php
            echo getcwd() . '/assets/dist/img/garage_logo.JPG';
            ?>" class="" alt="" style="margin-bottom:20px">
            <!--<img src="<?php echo $logo; ?>" class="" alt="" style="margin-bottom:20px">-->
        </div>
    </div>
    <div class="firts_section" style="">
        <div class="first_section_left"  style="width: 38%; display: inline-block;">
            <!--<h3><?php echo display('quotation'); ?></h3>-->
            <address>
                <strong style="font-size: 20px; "><?php echo $company_info[0]['company_name']; ?></strong><br>
                <abbr><b><?php echo display('mobile') ?>:</b></abbr> <?php echo $company_info[0]['mobile']; ?><br>
                <abbr><b><?php echo display('email') ?>:</b></abbr> <?php echo $company_info[0]['email']; ?><br>
                <abbr><b><?php echo display('website') ?>:</b></abbr> <?php echo $company_info[0]['website']; ?><br>
            </address>
            <br>
        </div>
        <div class="first_section_middle" style="width: 28%; display: inline-block;">
            <address> 
                <abbr><b><?php echo display('quotation_date') ?>:</b></abbr> <?php echo $quot_main[0]['quotdate'] ?><br>
                <abbr><b><?php echo display('quotation_no') ?>:</b></abbr> <?php echo $quot_main[0]['quot_no'] ?><br>
            </address>
        </div>
        <div class="first_section_right"  style="width: 28%; display: inline-block;">
            <address> 
                <strong style="font-size: 20px; "><?php echo $customer_info[0]['customer_name']; ?> </strong><br>
                <?php echo $customer_info[0]['customer_address']; ?>
                <br>
                <?php if ($customer_info[0]['customer_mobile']) { ?>
                                                                                    <!--<abbr><b><?php echo display('mobile') ?>:</b></abbr>-->
                    <?php
                    echo $customer_info[0]['customer_mobile'];
                }
                ?>
                <br>
                <?php if ($customer_info[0]['customer_email']) { ?>
                                                                                    <!--<abbr><b><?php echo display('email') ?>:</b></abbr>--> 
                    <?php echo $customer_info[0]['customer_email']; ?>
                <?php } ?>
                <br>
                <?php if ($customer_info[0]['website']) { ?>
                                                                                    <!--<abbr><b><?php echo display('website') ?>:</b></abbr>--> 
                    <?php echo $customer_info[0]['website']; ?>
                <?php } ?>
            </address>
        </div>
    </div>
    <div class="">
        <?php
        $amount = 0;
        if ($quot_labour) {
            ?>
            <div class="">
                <table class="table table-striped">
                    <caption class="text-center"> <h2>Jobs Information </h2></caption>
                    <thead>
                        <tr>
                            <th style="text-align: center; "><?php echo display('sl') ?></th>
                            <th  style="text-align: left;  padding: 5px; padding: 5px;"><?php echo display('jobs') ?></th>
                            <th  style="text-align: left;  padding: 5px;"><?php echo display('note') ?></th>
                            <th  style="text-align: right;  padding: 5px;"><?php echo display('rate') ?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl = 1;
                        foreach ($quot_labour as $labours) {
                            ?>
                            <tr>
                                <td style="text-align: center;  padding: 5px;"><?php echo $sl ?></td>
                                <td  style="text-align: left;  padding: 5px;"><?php echo $labours['job_type_name'] ?></td>
                                <td  style="text-align: left;  padding: 5px;"><?php echo $labours['note'] ?></td>
                                <td  style="text-align: right;  padding: 5px;">
                                    <?php
                                    $amount += $labours['rate'];
                                    $jobtyperate = $labours['rate'];
                                    echo (($position == 0) ? "$currency $jobtyperate" : "$jobtyperate $currency");
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $sl++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        if ($quot_product) {
            ?>
            <div class="">
                <table class="table table-striped">
                    <caption class="text-center"> <h2>Item Information </h2></caption>
                    <thead>
                        <tr>
                            <th style="text-align: center; "><?php echo display('sl') ?></th>
                            <th  style="text-align: left;  padding: 5px;"><?php echo display('item') ?></th>
                            <th  style="text-align: center;  padding: 5px;"><?php echo display('qty') ?></th>
                            <th  style="text-align: right; padding: 5px; "><?php echo display('price') ?></th>
                            <th  style="text-align: right;  padding: 5px;"><?php echo display('total') ?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl = 1;
                        foreach ($quot_product as $item) {
                            if (!$item['group_price_id']) {
                                ?>
                                <tr>
                                    <td style="text-align: center;  padding: 5px;"><?php echo $sl ?></td>
                                    <td  style="text-align: left;  padding: 5px;"><?php echo $item['product_name'] ?></td>
                                    <td  style="text-align: center;  padding: 5px;"><?php echo $item['used_qty'] ?></td>
                                    <td  style="text-align: right; padding: 5px;">
                                        <?php
//                                echo $item['rate'];
                                        $rate = $item['rate'];
                                        echo (($position == 0) ? "$currency $rate" : "$rate $currency");
                                        ?>
                                    </td>
                                    <td  style="text-align: right; ">
                                        <?php
                                        $amount += $item['rate'] * $item['used_qty'];
                                        $rate_total = $item['rate'] * $item['used_qty'];
                                        echo (($position == 0) ? "$currency $rate_total" : "$rate_total $currency");
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $sl++;
                            } else {
                                $this->db->select('*')->from('group_pricing_details a');
                                $this->db->join('product_information b', 'b.product_id = a.product_id');
                                $this->db->where('a.group_price_id', $item['group_price_id']);
                                $getgroupproducts = $this->db->get()->result();
                                foreach ($getgroupproducts as $groupproduct) {
                                    ?>
                                    <tr>
                                        <td style="text-align: center"><?php echo $sl ?></td>
                                        <td class="text-left"><?php echo $groupproduct->product_name; ?></td>
                                        <td style="text-align: center;">
                                            <?php echo $itemQty = $item['used_qty'] * $groupproduct->group_product_qty; ?>
                                        </td>
                                        <td  style="text-align: right;">
                                            <?php
                                            $rate = $groupproduct->product_rate;
                                            echo (($position == 0) ? "$currency $rate" : "$rate $currency");
                                            ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <?php
                                            $amount += $groupproduct->product_rate * $itemQty;
                                            $rate_total = $groupproduct->product_rate * $itemQty;
                                            $formatrate_total = number_format($groupproduct->product_rate * $itemQty, 2);
//                                                                    $format_grouprate = number_format($only_grouprate * $groupqty, 2);
                                            echo (($position == 0) ? "$currency $formatrate_total" : "$formatrate_total $currency");
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"  style="text-align: right;  padding: 5px;"><b><?php echo display('sub_total'); ?></b></td>
                            <td  style="text-align: right;  padding: 5px;">
                                <b>
                                    <?php
//                                    $sub_total = $quot_main[0]['totalamount'] - $quot_main[0]['total_discount'];
                                    echo (($position == 0) ? "$currency " . $amount : $amount . "$currency");
                                    ?>
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"  style="text-align: right;  padding: 5px;"><b>Discount</b></td>
                            <td  style="text-align: right;  padding: 5px;"><b>
                                    <?php
//                                echo $quot_main[0]['total_discount'];
                                    $ttldiscountamount = $quot_main[0]['total_discount'];
                                    echo (($position == 0) ? "$currency $ttldiscountamount" : "$ttldiscountamount $currency");
                                    ?>
                                </b></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right;  padding: 5px;"><b>Grand Total</b></td>
                            <td  style="text-align: right;  padding: 5px;"><b>
                                    <?php // echo $quot_main[0]['totalamount']  ?>
                                    <?php echo (($position == 0) ? "$currency " . $quot_main[0]['totalamount'] : $quot_main[0]['totalamount'] . " $currency") ?>
                                </b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php
        }
        // if ($user_type == 1) { 
        ?>
        <div class="" style="margin-top: 50px">
            <div style="width: 50%;">
                <strong><?php echo display('terms') ?> : </strong> <?php echo $quot_main[0]['terms'] ?>
            </div>
        </div>
        <?php // }     ?>
    </div>

</div>
