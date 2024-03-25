<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
$currency = $currency_details[0]['currency'];
$position = $currency_details[0]['currency_position'];
?>
<link href="<?php echo base_url('assets/custom/quotation.css') ?>" rel="stylesheet" type="text/css"/>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('quotation') ?></h1>
            <small><?php echo display('quotation_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('quotation') ?></a></li>
                <li class="active"><?php echo display('quotation_details') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
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
                <div class="panel panel-bd">
                    <div id="printableArea">
                        <div class="panel-body">
                            <div class="row" >
                                <div class="col-sm-12 text-right"> <img src="<?php
                                    if (isset($Web_settings[0]['logo'])) {
                                        echo $Web_settings[0]['logo'];
                                    }
                                    ?>" class="" alt="" style="margin-bottom:20px"></div>
                            </div>

                            <div class="row" style="margin-left: 5px;">
                                <div class="firts_section" style="display: flex;">
                                    <div class="first_section_left" style="width: 40%; margin-top: 5px; ">
                                        <h2 class=""><?php echo display('quotation') ?></h2>
                                        {company_info}
                                        <address>
                                            <strong style="font-size: 20px; ">{company_name}</strong><br>
                                            {address}<br>
                                            <abbr><b><?php echo display('mobile') ?>:</b></abbr> {mobile}<br>
                                            <abbr><b><?php echo display('email') ?>:</b></abbr> 
                                            {email}<br>
                                            <abbr><b><?php echo display('website') ?>:</b></abbr> 
                                            {website}<br>
                                            {/company_info}
                                            </div>
                                            <div class="first_section_middle" style="width: 30%; margin-top: 30px;">
                                                <address>
                                                    <abbr>
                                                        <b><?php echo display('quotation_date'); ?> : </b> <?php echo $quot_main[0]['quotdate'] ?><br>
                                                        <b><?php echo display('quotation_no'); ?> : </b> <?php echo $quot_main[0]['quot_no'] ?>
                                                    </abbr>
                                                </address>
                                            </div>
                                            <div class="first_section_right"  style="width: 30%; margin-top: 30px;">
                                                <address> 
                                                    <strong style="font-size: 20px; "><?php echo $customer_info[0]['customer_name']; ?> </strong><br>
                                                    <?php echo $customer_info[0]['customer_address']; ?>
                                                    <br>
                                                    <?php if ($customer_info[0]['customer_mobile']) { ?>
                                                        <abbr><b><?php echo display('mobile') ?>:</b></abbr>
                                                        <?php
                                                        echo $customer_info[0]['customer_mobile'];
                                                    }
                                                    ?>
                                                    <br>
                                                    <?php if ($customer_info[0]['customer_email']) { ?>
                                                        <abbr><b><?php echo display('email') ?>:</b></abbr> 
                                                        <?php echo $customer_info[0]['customer_email']; ?>
                                                    <?php } ?>
                                                    <br>
                                                    <?php if ($customer_info[0]['website']) { ?>
                                                        <abbr><b><?php echo display('website') ?>:</b></abbr> 
                                                        <?php echo $customer_info[0]['website']; ?>
                                                    <?php } ?>
                                                </address>
                                            </div>
                                    </div>
                                </div>
                                <!--      <div class="row" style="border-bottom:2px #333 solid;">
                                          <table class="table table-responsive">
                                              <tr>
                                                  <td> <h2 class="m-t-0"><?php echo display('quotation') ?></h2>
                                                      {company_info}
                                                      <address>
                                                          <strong style="font-size: 20px; ">{company_name}</strong><br>
                                                          {address}<br>
                                                          <abbr><b><?php echo display('mobile') ?>:</b></abbr> {mobile}<br>
                                                          <abbr><b><?php echo display('email') ?>:</b></abbr> 
                                                          {email}<br>
                                                          <abbr><b><?php echo display('website') ?>:</b></abbr> 
                                                          {website}<br>
                                                          {/company_info}
          
                                                      </address></td>
                                                  <td>  <div class="row">
          
                                                          <div class="col-sm-6">
                                                              <div class="m-b-15"><?php echo display('quotation_date') ?>: <?php echo $quot_main[0]['quotdate'] ?></div>
                                                              <div><?php echo display('quotation_no') ?>: <?php echo $quot_main[0]['quot_no'] ?></div>
          
                                                          </div>
                                                          <div class="col-sm-6">
                                                              <address> 
                                                                  <strong style="font-size: 20px; "><?php echo $customer_info[0]['customer_name']; ?> </strong><br>
                                <?php echo $customer_info[0]['customer_address']; ?>
                                                                  <br>
                                <?php if ($customer_info[0]['customer_mobile']) { ?>
                                                                                                                              <abbr><b><?php echo display('mobile') ?>:</b></abbr>
                                    <?php
                                    echo $customer_info[0]['customer_mobile'];
                                }
                                ?>
                                                                  <br>
                                <?php if ($customer_info[0]['customer_email']) { ?>
                                                                                                                              <abbr><b><?php echo display('email') ?>:</b></abbr> 
                                    <?php echo $customer_info[0]['customer_email']; ?>
                                <?php } ?>
                                                                  <br>
                                <?php if ($customer_info[0]['website']) { ?>
                                                                                                                                  <abbr><b><?php echo display('website') ?>:</b></abbr> 
                                    <?php echo $customer_info[0]['website']; ?>
                                <?php } ?>
                                                              </address>
                                                          </div>
          
                                                      </div>
                                                  </td>
                                              </tr>
                                          </table>
                                      </div>-->






                                <?php
                                $amount = 0;
                                if ($quot_labour) {
                                    ?>
                                    <div class="table-responsive m-b-20">
                                        <table class="table table-striped">
                                            <caption class="text-center"> <h2>Jobs Information </h2></caption>
                                            <thead>
                                                <tr>
                                                    <th><?php echo display('sl') ?></th>
                                                    <th class="text-left"><?php echo display('jobs') ?></th>
                                                    <th class="text-left"><?php echo display('note') ?></th>
                                                    <th class="text-right"><?php echo display('rate') ?></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sl = 1;
                                                foreach ($quot_labour as $labours) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sl ?></td>
                                                        <td class="text-left"><?php echo $labours['job_type_name'] ?></td>
                                                        <td class="text-left"><?php echo $labours['note'] ?></td>
                                                        <td class="text-right">
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
        <!--                                    <tfoot>
                                            
                                            </tfoot>-->
                                        </table>
                                    </div>
                                    <?php
                                }
//                                dd($quot_product);
                                if ($quot_product) {
                                    ?>
                                    <div class="table-responsive m-b-20">
                                        <table class="table table-striped">
                                            <caption class="text-center"> <h2>Item Information </h2></caption>
                                            <thead>
                                                <tr>
                                                    <th><?php echo display('sl') ?></th>
                                                    <th class="text-left"><?php echo display('item') ?></th>
                                                    <th class="text-center"><?php echo display('qty') ?></th>
                                                    <th class="text-right"><?php echo display('price') ?></th>
                                                    <th class="text-right"><?php echo display('total') ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sl = 1;
                                                foreach ($quot_product as $item) {
                                                    if (!$item['group_price_id']) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $sl ?></td>
                                                            <td class="text-left"><?php echo $item['product_name']; ?></td>
                                                            <td class="text-center"><?php echo $item['used_qty']; ?></td>
                                                            <td class="text-right">
                                                                <?php
                                                                $rate = $item['rate'];
                                                                echo (($position == 0) ? "$currency $rate" : "$rate $currency");
                                                                ?>
                                                            </td>
                                                            <td class="text-right">
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
                                                                <td><?php echo $sl ?></td>
                                                                <td class="text-left"><?php echo $groupproduct->product_name; ?></td>
                                                                <td class="text-center">
                                                                    <?php echo $itemQty = $item['used_qty'] * $groupproduct->group_product_qty; ?>
                                                                </td>
                                                                <td class="text-right">
                                                                    <?php
                                                                    $rate = $groupproduct->product_rate;
                                                                    echo (($position == 0) ? "$currency $rate" : "$rate $currency");
                                                                    ?>
                                                                </td>
                                                                <td class="text-right">
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
        <!--                                    <tfoot>
                                            
                                            </tfoot>-->
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-right"><b><?php echo display('sub_total'); ?></b></td>
                                                    <td class="text-right"><b>
                                                            <?php
//                                                            $format_subttl = $quot_main[0]['totalamount'] - $quot_main[0]['total_discount'];
                                                            echo (($position == 0) ? "$currency $amount" : "$amount $currency");
                                                            ?>
                                                        </b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-right"><b>Discount</b></td>
                                                    <td class="text-right"><b>
                                                            <?php
                                                            $ttldiscountamount = $quot_main[0]['total_discount'];
                                                            echo (($position == 0) ? "$currency $ttldiscountamount" : "$ttldiscountamount $currency");
                                                            ?>
                                                        </b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-right"><b>Grand Total</b></td>
                                                    <td class="text-right"><b>
                                                            <?php
                                                            $ttlamount = number_format($quot_main[0]['totalamount'], 2);
                                                            echo (($position == 0) ? "$currency $ttlamount" : "$ttlamount $currency");
                                                            ?>
                                                        </b>
                                                        <input type="hidden" name="" id="quotation_id" value="<?php echo $quot_main[0]['quotation_id'] ?>">
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <div  style="float:right;width:100%;text-align:center;border-top:dashed #e4e5e7;"></div>
                                    <?php // if ($user_type == 1) {   ?>
                                    <div class="row" style="margin-top: 50px">
                                        <div style="width: 50%; margin-left: 30px; ">
                                            <strong><?php echo display('terms') ?> : </strong> <?php echo $quot_main[0]['terms'] ?>
                                        </div>
                                    </div>
                                    <?php // }   ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
//                        if ($quot_main[0]['status'] != 3 && $this->session->userdata('user_type') != 3) {
                            if ($this->session->userdata('user_type') == 3) {
                                ?>
                                <div class="form-group row" style="margin-left: 15px">
                                    <label for="status" class="col-sm-2 col-form-label"><?php echo display('status'); ?> </label>
                                    <div class="col-sm-4">
                                        <select name="aprove_status" class="form-control" onchange="c_statis(this.value)">
                                            <option value="">Select Item</option>
                                            <option value="3" <?php
                                            if ($quot_main[0]['status'] == 3) {
                                                echo 'selected';
                                            }
                                            ?>>Accept</option>
                                            <option value="4" <?php
                                            if ($quot_main[0]['status'] == 4) {
                                                echo 'selected';
                                            }
                                            ?>>Decline</option>
                                        </select>
                                    </div>

                                </div>
                            <?php } ?>
                            <div class="panel-footer text-left">
                                <a  class="btn btn-danger" href="<?php echo base_url('Cquotation/manage_quotation'); ?>"><?php echo display('cancel') ?></a>
                                <button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>

                            </div>
                        </div>

                        <div class="row">
                            <div class="chatbox-holder">
                                <div class="chatbox">
                                    <div class="chatbox-top">
                                        <div class="chatbox-avatar">
                                            <a target="_blank" href="#"><img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" /></a> 
                                        </div>
                                        <div class="chat-partner-name">
                                            <span class="">Comments </span>
                                            <a target="_blank" href="">(
                                                <?php
                                                $customer_info = $this->db->select('customer_name')->from('customer_information')->where('customer_id', $quot_main[0]['customer_id'])->get()->row();
                                                if ($this->session->userdata('user_type') == 3) {
                                                    ?> 
                                                    <?php echo "Admin"; ?>
                                                    <?php
                                                } else {
                                                    echo $customer_info->customer_name;
                                                }
                                                ?>)</a>
                                        </div>
                                        <div class="chatbox-icons">
                                            <a href="javascript:void(0);"><i class="fa fa-minus"></i></a>
                                            <!-- <a href="javascript:void(0);"><i class="fa fa-close"></i></a>  -->      
                                        </div>      
                                    </div>

                                    <div class="chat-messages">
                                        <?php foreach ($messagesss as $messag) { ?>
                                            <?php if ($messag['sent_by'] == $this->session->userdata('user_id')) { ?>      
                                                <div class="message-box-holder">

                                                    <div class="message-box">
                                                        <?php echo $messag['message']; ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($messag['sent_by'] != $this->session->userdata('user_id')) { ?>
                                                <div class="message-box-holder">
                                                    <div class="message-sender">
                                                        <?php
                                                        if ($this->session->userdata('user_type') == 1) {
                                                            echo $customer_info->customer_name;
                                                        } else {
                                                            echo 'Admin';
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="message-box message-partner">
                                                        <?php echo $messag['message']; ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>

                                    <div class="chat-input-holder">
                                        <textarea class="chat-input" id="custormchat" placeholder="Write Message ...."></textarea>
                                        <input type="button" value="Send" class="message-send" onclick="messagesent()"/>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                </section> <!-- /.content -->
                <input type="hidden" id="cStacomment" value="<?php echo base_url('Cquotation/quotation_customer_status'); ?>">
                <input type="hidden" id="quotation_customer_chat" value="<?php echo base_url('Cquotation/quotation_customer_chat'); ?>">
            </div> <!-- /.content-wrapper -->
            <script src="<?php echo base_url('assets/custom/quotation.js') ?>"></script>