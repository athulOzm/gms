<!-- customer details Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('customer_details') ?></h1>
            <small><?php echo display('manage_customer_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('customer') ?></a></li>
                <li class="active"><?php echo display('customer_details') ?></li>
            </ol>
        </div>
    </section>

    <!-- Supplier information -->
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
                <div class="column">
                <?php if($this->permission1->method('add_customer','create')->access()){ ?>
                    <a href="<?php echo base_url('Ccustomer') ?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_customer') ?> </a>
                <?php }?>
                <?php if($this->permission1->method('manage_customer','read')->access()){ ?>
                    <a href="<?php echo base_url('Ccustomer/manage_customer') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_customer') ?> </a>
                <?php }?>
                  <?php if($this->permission1->method('credit_customer','read')->access()){ ?>
                    <a href="<?php echo base_url('Ccustomer/credit_customer') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('credit_customer') ?> </a>
                   <?php }?>
                   <?php if($this->permission1->method('paid_customer','read')->access()){ ?>
                    <a href="<?php echo base_url('Ccustomer/paid_customer') ?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('paid_customer') ?> </a>
                     <?php }?>

                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('customer_information') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div style="float:left">
                            <h4>{customer_name}</h4>
                            <h4>{customer_email}</h4>
                            <h4>{customer_mobile}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manage Supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('customer_information') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('date') ?></th>
                                        <th class="text-center"><?php echo display('receipt_no') ?></th>
                                        <th class="text-center"><?php echo display('description') ?></th>
                                        <th class="text-center"><?php echo display('ammount') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($receipt_info) {
                                        ?>
                                        {receipt_info}
                                        <tr>
                                            <td>{final_date}</td>
                                            <td>
                                                {receipt_no}
                                            </td>
                                            <td>{description}</td>
                                            <td class="text-right"><?php echo (($position == 0) ? "$currency {amount}" : "{amount} $currency") ?></td>
                                        </tr>
                                        {/receipt_info}
                                        <?php } else {
                                        ?>
                                        <tr>
                                            <th class="text-center" colspan="6"><?php echo display('not_found'); ?></th>
                                        </tr> 
                                    <?php } ?>
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="3"><strong><?php echo display('total_ammount'); ?> :</strong></td>
                                        <td class="text-right"><b><?php echo (($position == 0) ? "$currency {receipt_amount}" : "{receipt_amount} $currency") ?></b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- customer details End  -->