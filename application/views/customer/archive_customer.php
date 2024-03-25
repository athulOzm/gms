<!-- Customer js php -->
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/customer.js" ></script>
<!-- Manage Customer Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('customer_archive') ?></h1>
            <small><?php echo display('customer_archive') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('customer') ?></a></li>
                <li class="active"><?php echo display('customer_archive') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Alert Message -->
        <!--<div id="output" class="hide alert alert-danger"></div>-->
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
                <div class="column float-right">
                    <?php if ($this->permission1->check_label('add_customer')->create()->access()) { ?>
                        <a href="<?php echo base_url('Ccustomer') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_customer') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->check_label('credit_customer')->read()->access()) { ?>
                        <a href="<?php echo base_url('Ccustomer/credit_customer') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('credit_customer') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->check_label('paid_customer')->read()->access()) { ?>
                        <a href="<?php echo base_url('Ccustomer/paid_customer') ?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('paid_customer') ?> </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!--        <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-body"> 
                                <form action="<?php echo base_url('Ccustomer/customer_search_item') ?>" class="form-inline" method="post" accept-charset="utf-8">
                                    <label class="select"><?php echo display('customer_name') . '/' . display('phone') ?>:</label>
                                    <input type="text"   name="customer_name" class=" form-control" placeholder='<?php echo display('customer_name') . '/' . display('phone') ?>' id="customer_name"  onkeyup="customer_autocomplete()"/>
                                    <input id="autocomplete_customer_id" class="customer_hidden_value abc" type="hidden" name="customer_id">
                                    <button type="submit" class="btn btn-primary"><?php echo display('search') ?></button>
        
                                </form>		            
                            </div>
                        </div>
                    </div>
                </div>-->

        <!-- Manage Customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h3><?php echo display('customer_archive'); ?></h3>
<!--                            <a href="<?php echo base_url('Ccustomer/customer_downloadpdf') ?>" class="btn btn-warning">Pdf</a> 
                            <a href="<?php echo base_url() . 'Ccustomer/exportCSV'; ?>" class="btn btn-success">Export CSV </a>-->
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <!--dataTableExample3-->
                            <table id="" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('customer_name') ?></th>
                                        <th><?php echo display('phone') ?></th>
                                        <th><?php echo display('email') ?></th>
                                        <th class="text-right"><?php echo display('balance') ?></th>
                                        <th><?php echo display('status'); ?></th>
                                        <th class="text-center"><?php echo display('action') ?>
                                            <?php // echo form_open('Ccustomer/manage_customer', array('class' => 'form-inline', 'method' => 'post')) ?>
                                            <!--<input type="hidden" name="all" value="all">-->
                                            <!--<button type="submit" class="btn btn-success"><?php echo display('all') ?></button>-->
                                            <?php // echo form_close() ?>
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
                                                        <option value=""></option>
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
                                } else {
                                    ?>
                                    <tr>
                                        <th class="text-center text-danger" colspan="7"><?php echo display('not_found'); ?></th>
                                    </tr> 
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="4"><b> <?php echo display('grand_total') ?></b></td>
                                        <td class="text-right">
                                            <b><?php
                                                $sttle = number_format($subtotal, 2, '.', ',');
                                                echo (($position == 0) ? "$currency $sttle" : "$sttle $currency")
                                                ?></b>


                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="text-right"><?php echo $links ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="customerAutocomplete" value="<?php echo base_url('Cinvoice/customer_autocomplete') ?>">
    <input type="hidden" id="customerStuatusURL" value="<?php echo base_url('Ccustomer/customer_status/'); ?>">
</div>
<!-- Manage Customer End -->
