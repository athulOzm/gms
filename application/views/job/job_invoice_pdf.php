<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$company_info = $CI->db->get('company_information')->row();
//dd($Web_settings);
$currency = $currency_details[0]['currency'];
$position = $currency_details[0]['currency_position'];
?>
<style type="text/css">
    .invoice_details_table{
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    table, th, td {
        border: 1px solid black;
    }
</style>
<div class="printableArea" id="printableArea">
    <div class="row" >
        <?php // dd($get_invoice_info); ?>
        <div class="" style="text-align: center;">
            <img src="<?php
            echo getcwd() . '/assets/dist/img/garage_logo.JPG';
//            if (isset($Web_settings[0]['invoice_logo'])) {
//                echo $Web_settings[0]['invoice_logo'];
//            }
            ?>" class="" alt="" style="margin-bottom:20px">
        </div>
    </div>
    <div class="firts_section" style="">
        <div class="first_section_left"  style="width: 38%; display: inline-block;">
            <h3 style="margin: 0 0 5px;"><?php echo display('invoice_details'); ?></h3>
            <address>
                <strong style="font-size: 20px; "><?php echo $get_invoice_info[0]->company_name; ?></strong><br>
                <abbr><b><?php echo display('address'); ?>: <?php echo nl2br($get_invoice_info[0]->customer_address) ?></b></abbr><br>
                <abbr><b><?php echo display('attention'); ?> :</b></abbr> <?php echo $get_invoice_info[0]->customer_name; ?><br>
                <abbr><b><?php echo display('email'); ?> :</b></abbr> <?php echo $get_invoice_info[0]->customer_email; ?> <br>
                <abbr><b><?php echo display('phone'); ?>: </b></abbr> <?php echo $get_invoice_info[0]->customer_phone; ?>
            </address>
            <br>
            <?php if ($get_invoice_info[0]->show_hide_status == 1) { ?>
                <address style="font-size: 12px;"> 
                    <?php if ($get_invoice_info[0]->vehicle_registration) { ?>
                        <abbr><b><?php echo display('vehicle_registration'); ?> : </b><?php echo $get_invoice_info[0]->vehicle_registration; ?></abbr><br>
                        <?php
                    }
                    if ($get_invoice_info[0]->odometer) {
                        ?>
                        <abbr><b><?php echo display('odometer'); ?> : </b><?php echo $get_invoice_info[0]->odometer; ?></abbr><br>
                        <?php
                    }
                    if ($get_invoice_info[0]->hubo_meter) {
                        ?>
                        <abbr><b><?php echo display('hubo_meter'); ?> : </b><?php echo $get_invoice_info[0]->hubo_meter; ?></abbr><br>
                        <?php
                    }
                    if ($get_invoice_info[0]->hour_meter) {
                        ?>
                        <abbr><b><?php echo display('hour_meter'); ?> : </b><?php echo $get_invoice_info[0]->hour_meter; ?></abbr><br>
                        <?php
                    }
                    if ($get_invoice_info[0]->cof_wof_date) {
                        ?>
                        <abbr><b><?php echo display('cof_wof_date'); ?> : </b><?php echo $get_invoice_info[0]->cof_wof_date; ?></abbr><br>
                        <?php
                    }
                    if ($get_invoice_info[0]->registration_date) {
                        ?>
                        <abbr><b><?php echo display('registration_date'); ?> : </b><?php echo $get_invoice_info[0]->registration_date; ?></abbr><br>
                        <?php
                    }
                    if ($get_invoice_info[0]->fuel_burn) {
                        ?>
                        <abbr><b><?php echo display('fuel_burn'); ?> : </b><?php echo $get_invoice_info[0]->fuel_burn; ?></abbr><br>
                    <?php } ?>
                </address>
            <?php } ?>
        </div>
        <div class="first_section_middle" style="width: 28%; display: inline-block;">
            <address> 
                <?php if ($get_invoice_info[0]->date != '0000-00-00') { ?>
                    <abbr><b><?php echo display('invoice_date'); ?> : </b> </abbr>
                    <?php
                    $date_format = $this->session->userdata('date_format');
                    if ($date_format == 1) {
                        echo date('d-m-Y', strtotime($get_invoice_info[0]->date));
                    } elseif ($date_format == 2) {
                        echo date('m-d-Y', strtotime($get_invoice_info[0]->date));
                    } elseif ($date_format == 3) {
                        echo date('Y-m-d', strtotime($get_invoice_info[0]->date));
                    }
                    ?>              <br>
                    <?php
                }
                if ($get_invoice_info[0]->invoice_id) {
                    ?>
                    <abbr><b><?php echo display('invoice_number'); ?> : </b></abbr>
                    <?php echo $get_invoice_info[0]->invoice_id; ?><br>
                    <?php
                }
                if ($get_invoice_info[0]->customer_ref) {
                    ?>
                    <abbr><b><?php echo display('reference'); ?> : </b></abbr>
                    <?php echo $get_invoice_info[0]->customer_ref; ?><br>                                                       
                    <?php
                }
                if ($get_invoice_info[0]->date) {
                    ?>
                    <abbr><b><?php echo display('due_date'); ?> : </b></abbr>
                    <?php
                    $payment_period = '';
                    if ($get_invoice_info[0]->payment_period) {
                        $due_date = strtotime($get_invoice_info[0]->date);
                        $payment_period = $get_invoice_info[0]->payment_period;
                        if ($date_format == 1) {
                            echo date('d-m-Y', strtotime("+$payment_period day", $due_date));
                        } elseif ($date_format == 2) {
                            echo date('m-d-Y', strtotime("+$payment_period day", $due_date));
                        } elseif ($date_format == 3) {
                            echo date('Y-m-d', strtotime("+$payment_period day", $due_date));
                        }
                    } else {
                        if ($date_format == 1) {
                            echo date('d-m-Y', strtotime($get_invoice_info[0]->date));
                        } elseif ($date_format == 2) {
                            echo date('m-d-Y', strtotime($get_invoice_info[0]->date));
                        } elseif ($date_format == 3) {
                            echo date('Y-m-d', strtotime($get_invoice_info[0]->date));
                        }
                    }
                    ?><br>                                                       
                <?php } ?>
            </address>
        </div>
        <div class="first_section_right"  style="width: 28%; display: inline-block;">
            <address style="font-size: 12px;"> 
                <abbr><b><?php echo $company_info->company_name; ?></b></abbr><br>
                <abbr><b><?php echo $company_info->email; ?></b></abbr><br>
                <abbr><b><?php echo $company_info->mobile; ?></b></abbr><br>
                <abbr><b><?php echo $company_info->address; ?></b></abbr><br>
                <abbr><b><?php echo $company_info->website; ?></b></abbr><br>
            </address>
        </div>
    </div>

    <div class="invoice_details_section">
        <table class="invoice_details_table">
            <thead>
                <tr>
                    <th class="text-left" width="13%"><?php echo display('date') ?></th>
                    <th style="text-align: left;" width="25%"><?php echo display('service') ?></th>
                    <th class="text-left" width="18%"><?php echo display('notes') ?></th>
                    <th class="text-center" width="10%"><?php echo display('spent_time') ?></th>
                    <th style="text-align: center;" width="10%"><?php echo display('qty') ?></th>
                    <th style="text-align: right;" width="12%"><?php echo display('unit_price') ?></th>
                    <th style="text-align: right;" width="12%"><?php echo display('amount') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $amount = $spent_time = $sptime = 0;
                if ($get_invoicedetails) {
                    foreach ($get_invoicedetails as $jobdetails) {
                        $jod_details_item = $this->db->select('*')->from('job_details')->where('job_type_id', $jobdetails->product_id)
                                        ->where('job_id', $jobdetails->job_id)->get()->row();
//                                                echo $this->db->last_query();
                        ?>
                        <tr>
                            <td style="padding: 4px;">
                                <?php
                                if ($jod_details_item->end_datetime != '0000-00-00 00:00:00') {
//                                    echo date('Y-m-d', strtotime($jod_details_item->end_datetime));
                                    if ($date_format == 1) {
                                        echo date('d-m-Y', strtotime($jod_details_item->end_datetime));
                                    } elseif ($date_format == 2) {
                                        echo date('m-d-Y', strtotime($jod_details_item->end_datetime));
                                    } elseif ($date_format == 3) {
                                        echo date('Y-m-d', strtotime($jod_details_item->end_datetime));
                                    }
                                }
                                ?>
                            </td>
                            <td style="padding: 4px;"><?php echo $jobdetails->job_type_name; ?></td>
                            <td style="padding: 4px;"><?php echo $jod_details_item->mechanic_notes; ?></td>
                            <td style="text-align: center; padding: 4px;">
                                <?php
                                $spent_time += $jod_details_item->spent_time;
                                echo $jod_details_item->spent_time;
                                ?>
                            </td>
                            <td style="text-align: center;padding: 4px;">1</td>
                            <td style="text-align: right;padding: 4px;">
                                <?php
//                                echo $rate = $jobdetails->rate;
                                $rate = $jobdetails->rate;
                                echo (($position == 0) ? "$currency $rate" : "$rate $currency");
                                ?>
                            </td>
                            <td style="text-align: right;padding: 4px;">
                                <?php
                                $amount += $rate * 1;
//                                echo number_format($rate * 1, 2);
                                $format_servicettlrate = number_format($rate * 1, 2);
                                echo (($position == 0) ? "$currency $format_servicettlrate" : "$format_servicettlrate $currency")
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                if ($get_job_products_used) {
                    foreach ($get_job_products_used as $product_used) {
                        if (!$product_used->group_price_id) {
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    if ($date_format == 1) {
                                        echo date('d-m-Y', strtotime($product_used->created_date));
                                    } elseif ($date_format == 2) {
                                        echo date('m-d-Y', strtotime($product_used->created_date));
                                    } elseif ($date_format == 3) {
                                        echo date('Y-m-d', strtotime($product_used->created_date));
                                    }
                                    ?>
                                </td>
                                <td><?php echo $product_used->product_name; ?></td>
                                <td><?php echo $product_used->mechanic_note; ?></td>
                                <td style="text-align: center;">N/A</td>
                                <td style="text-align: center;padding: 4px;">
                                    <?php echo $quantity = $product_used->used_qty; ?>
                                </td>
                                <td style="text-align: right; padding: 4px;">
                                    <?php
                                    $only_rate = $product_used->rate;
                                    $prd_rate = number_format($product_used->rate, 2);
                                    echo (($position == 0) ? "$currency $prd_rate" : "$prd_rate $currency");
                                    ?>
                                </td>
                                <td style="text-align: right;padding: 4px;">
                                    <?php
                                    $amount += $only_rate * $quantity;
                                    $format_rate = number_format($only_rate * $quantity, 2);
                                    echo (($position == 0) ? "$currency $format_rate" : "$format_rate $currency");
                                    ?>
                                </td>
                            </tr>
                            <?php
                        } else {
                            $this->db->select('*')->from('group_pricing_details a');
                            $this->db->join('product_information b', 'b.product_id = a.product_id');
                            $this->db->where('a.group_price_id', $product_used->group_price_id);
                            $getgroupproducts = $this->db->get()->result();
                            foreach ($getgroupproducts as $groupproduct) {
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        if ($date_format == 1) {
                                            echo date('d-m-Y', strtotime($product_used->created_date));
                                        } elseif ($date_format == 2) {
                                            echo date('m-d-Y', strtotime($product_used->created_date));
                                        } elseif ($date_format == 3) {
                                            echo date('Y-m-d', strtotime($product_used->created_date));
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $groupproduct->product_name; ?></td>
                                    <td></td>
                                    <td style="text-align: center;" style="font-size: 11px;">N/A</td>
                                    <td style="text-align: center;"><?php echo $groupqty = ($groupproduct->group_product_qty) * ($product_used->used_qty); ?></td>
                                    <td style="text-align: right;">
                                        <?php
                                        $only_grouprate = $groupproduct->product_rate;
                                        $prd_grouprate = number_format($groupproduct->product_rate, 2);
                                        echo (($position == 0) ? "$currency $prd_grouprate" : "$prd_grouprate $currency");
                                        ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php
                                        $amount += $only_grouprate * $groupqty;
                                        $format_grouprate = number_format($only_grouprate * $groupqty, 2);
                                        echo (($position == 0) ? "$currency $format_grouprate" : "$format_grouprate $currency");
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <tr>
                    <td></td>
                    <td style="padding: 4px;"><?php echo display('labour_cost'); ?></td>
                    <td style="padding: 4px;"> </td>
                    <td style="text-align: center">
                        <?php echo $spent_time; ?>
                    </td>
                    <td style="text-align: center;" style="font-size: 11px;">N/A</td>
                    <td style="text-align: right; padding: 4px;">
                        <?php
//                        echo $Web_settings[0]['labour_cost']; 
                        $laboutcost = $Web_settings[0]['labour_cost'];
                        echo (($position == 0) ? "$currency $laboutcost" : "$laboutcost $currency");
                        ?>
                    </td>
                    <th style="text-align: right; padding: 4px;">
                        <?php
                        $labour_cost_spenttime = $Web_settings[0]['labour_cost'] * $spent_time;
//                        echo number_format($Web_settings[0]['labour_cost'] * $spent_time, 2);
                        $format_labourcost = number_format($Web_settings[0]['labour_cost'] * $spent_time, 2);
                        echo (($position == 0) ? "$currency $format_labourcost " : "$format_labourcost $currency");
                        ?>
                    </th>
                </tr>
                <tr>
                    <th colspan="5" rowspan="2" style="text-align: left;  padding: 4px;">
                        <strong><?php echo display('recommendation_notes'); ?></strong>
                        <p>
                            <?php echo nl2br($get_invoice_info[0]->recommendation); ?>
                        </p>
                    </th>
                    <th colspan="1" style="text-align: right; padding: 4px;"><?php echo display('sub_total'); ?></th>
                    <th style="text-align: right; padding: 5px;">
                        <?php
                        $sub_amount = $amount + $labour_cost_spenttime;
//                        echo number_format($sub_amount, 2);
                        $format_subamount = number_format($sub_amount, 2);
                        echo (($position == 0) ? "$currency $format_subamount" : "$format_subamount $currency");
                        ?>
                    </th>
                </tr>
                <tr>
                    <th colspan="1" style="text-align: right; padding: 5px;"><?php echo display('discount'); ?> </th>
                    <th style="text-align: right; padding: 4px;">
                        <?php
//                        echo $get_invoice_info[0]->invoice_discount;
                        $invoice_discount = $get_invoice_info[0]->invoice_discount;
                        echo (($position == 0) ? "$currency $invoice_discount" : "$invoice_discount $currency");
                        ?>
                    </th>
                </tr>
                <tr>
                    <th colspan="6" style="text-align: right; padding: 4px;"><?php echo display('gst') . " (" . $get_tax[0]->tax . "%)"; ?></th>
                    <th style="text-align: right; padding: 4px;">
                        <?php
//                                                $tax = ($amount * $get_tax[0]->tax) / 100;
                        $tax = (($sub_amount - $get_invoice_info[0]->invoice_discount) * $get_tax[0]->tax) / 100;
                        $format_tax = number_format($tax, 2);
                        echo (($position == 0) ? "$currency $format_tax" : "$format_tax $currency");
                        ?>
                    </th>
                </tr>
                <tr>
                    <th colspan="6" style="text-align: right; padding: 4px;"><?php echo display('total'); ?></th>
                    <th style="text-align: right; padding: 4px;">
                        <?php
                        $total_amount = ($sub_amount - $get_invoice_info[0]->invoice_discount) + $tax;
                        $format_ttlamount = number_format($total_amount, 2);
                        echo (($position == 0) ? "$currency $format_ttlamount" : "$format_ttlamount $currency");
                        ?>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>


</div>

<!--<div class="printableArea"  id="printableArea">
    <div class="top_section">
        <img src="<?php
echo getcwd() . '/assets/dist/img/garage_logo.JPG';
//                                    if (isset($Web_settings[0]['logo'])) {
//                                        echo $Web_settings[0]['logo'];
//                                    }
?>" class="" alt="" style="margin-bottom:20px">
    </div>
    <div class="invoice_section">
        <table class="table table-responsive">
            <tr>
                <td> <h2 class="m-t-0"><?php echo display('invoice_details') ?></h2>


                    <address>
                        <strong style="font-size: 20px; "><?php echo $get_invoice_info[0]->company_name; ?></strong><br>
                        <abbr><b><?php echo display('address'); ?>: <?php echo $get_invoice_info[0]->customer_address ?></b></abbr><br>
                        <abbr><b><?php echo display('dear'); ?> :</b></abbr> <?php echo $get_invoice_info[0]->customer_name; ?><br>
                        <abbr><b><?php echo display('email'); ?> :</b></abbr> <?php echo $get_invoice_info[0]->customer_email; ?> <b>/ <?php echo display('phone'); ?>: </b> <?php echo $get_invoice_info[0]->customer_phone; ?>

                    </address></td>
                <td>  <div class="row">

                        <div class="col-sm-5">
<?php if ($get_invoice_info[0]->show_hide_status == 1) { ?>
                                                                                                                                                                                                                                                    <address> 
                                                                                                                                                                                                                                                        <abbr><b>
    <?php echo display('vehicle_registration'); ?>:<?php echo $get_invoice_info[0]->vehicle_registration; ?></b></abbr><br>
                                                                                                                                                                                                                                                        <abbr><b><?php echo display('odometer'); ?>:<?php echo $get_invoice_info[0]->odometer; ?></b></abbr><br>
                                                                                                                                                                                                                                                        <abbr><b><?php echo display('hubo_meter'); ?>:<?php echo $get_invoice_info[0]->hubo_meter; ?></b></abbr></address>
<?php } ?>

                        </div>
                        <div class="col-sm-7">
                            <address> 
                                <abbr><b><?php echo display('invoice_date'); ?> : <?php echo $get_invoice_info[0]->date; ?></b></abbr><br>
                                <abbr><b><?php echo display('invoice_number'); ?> : <?php echo $get_invoice_info[0]->invoice; ?></b></abbr><br>
                                <abbr><b> Payment Terms 7 days </b></abbr><br>
                                <abbr> <?php echo display('payment_status'); ?> : <strong class="text-danger">Unpaid</strong></abbr><br>
                                <abbr><b><?php echo display('registration_due'); ?> : <?php echo $get_invoice_info[0]->registration_date; ?></b></abbr><br>
                                <abbr><b> <?php echo display('cof_due'); ?> : <?php echo $get_invoice_info[0]->cof_wof_date; ?></b></abbr>
                            </address>

                        </div>

                    </div></td>

            </tr>
        </table>
    </div>
    <div class="invoice_details_section">
        <table class="invoice_details_table">
            <thead>
                <tr>
                    <th><?php echo display('date') ?></th>
                    <th class="text-left"><?php echo display('description') ?></th>
                    <th class="text-center"><?php echo display('qty') ?></th>
                    <th class="text-right"><?php echo display('unit_price') ?></th>
                    <th class="text-right"><?php echo display('amount') ?></th>
                </tr>
            </thead>
            <tbody>
<?php
$amount = 0;
if ($get_invoicedetails) {
    foreach ($get_invoicedetails as $jobdetails) {
        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td><?php echo $jobdetails->job_type_name; ?></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td style="text-align: center;">1</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td style="text-align: right;"><?php echo $rate = $jobdetails->rate; ?></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td style="text-align: right;">
        <?php
        $amount += $rate * 1;
        echo number_format($rate * 1, 2);
        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>
        <?php
    }
}
if ($get_job_products_used) {
    foreach ($get_job_products_used as $product_used) {
        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td><?php echo $product_used->product_name; ?></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td style="text-align: center;">
        <?php echo $quantity = $product_used->used_qty; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td style="text-align: right;"><?php echo $rate = $product_used->rate; ?></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td style="text-align: right;">
        <?php
        $amount += $rate * $quantity;
        echo number_format($rate * $quantity, 2);
        ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>
        <?php
    }
}
?>
                <tr>
                    <th colspan="2" rowspan="2">

                        <p>
<?php echo $get_invoice_info[0]->recommendation; ?>
                        </p>
                    </th>
                </tr>
                <tr>
                    <th colspan="1" style="text-align: right;"><?php echo display('sub_total'); ?></th>
                    <th style="text-align: right;">
<?php echo number_format($amount, 2);
?>
                    </th>
                </tr>
                <tr>
                    <th colspan="1" style="text-align: right;"><?php echo display('discount'); ?> </th>
                    <th style="text-align: right;">
<?php
echo $get_invoice_info[0]->invoice_discount;
?>
                    </th>
                </tr>
                <tr>
                    <th colspan="3" style="text-align: right;"><?php echo display('gst') . " (" . $get_tax[0]->tax . "%)"; ?></th>
                    <th style="text-align: right;">
<?php
//                                                $tax = ($amount * $get_tax[0]->tax) / 100;
$tax = (($amount - $get_invoice_info[0]->invoice_discount) * $get_tax[0]->tax) / 100;
echo number_format($tax, 2);
?>
                    </th>
                </tr>
                <tr>
                    <th colspan="3" style="text-align: right;"><?php echo display('total'); ?></th>
                    <th style="text-align: right;">
<?php
$total_amount = ($amount - $get_invoice_info[0]->invoice_discount) + $tax;
echo number_format($total_amount, 2);
?>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="print_footer">
        <center style="font-size: 11px; line-height: 8px;    font-weight: bold;">
            <p>Truck Systems NZ LTD</p>
            <p>P.O Box 85061, Mt Wellington, Auckland 1060, NZ</p>
            <p>GST: 105372230 | Incorporation Number: 3084205 | Acct No: 12-3021-0354872-00</p>
            <p>P: +64 9 580 1089│M: +64 21 494 164│E: trucksystems@gmail.com | W: www.trucksystems.co.nz</p>
        </center>
    </div>
</div>-->