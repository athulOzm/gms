<!-- Manage Invoice Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('report') ?></h1>
            <small><?php echo display('supplier_return') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('report') ?></a></li>
                <li class="active"><?php echo display('supplier_return') ?></li>
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
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <?php echo form_open('Admin_dashboard/supplier_return', array('class' => 'form-inline')) ?>
                        <?php $today = date('Y-m-d'); ?>
                        <div class="form-group">
                            <label class="" for="from_date"><?php echo display('start_date') ?></label>
                            <input type="text" name="from_date" class="form-control datepicker" id="from_date" value="{start_date}" placeholder="<?php echo display('start_date') ?>" >
                        </div> 

                        <div class="form-group">
                            <label class="" for="to_date"><?php echo display('end_date') ?></label>
                            <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="{end_date}">
                        </div>  

                        <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>

                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>


        <!-- Manage Invoice report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                          <!--   <span class="text-center">
                     <a href="<?php echo base_url('Cretrun_m/supplier_return_downloadpdf') ?>" class="btn btn-warning">Pdf</a> 
                     </span> -->
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('purchase_id') ?></th>
                                        <th><?php echo display('supplier_name') ?></th>
                                        <th><?php echo display('date') ?></th>
                                        <th><?php echo display('total_amount') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($return_list) {
                                        ?>
                                        {return_list}
                                        <tr>
                                            <td>{sl}</td>
                                            <td>
                                                <a href="<?php echo base_url() . 'Cretrun_m/supplier_inserted_data/{purchase_id}'; ?>">
                                                    {purchase_id}
                                                </a>
                                            </td>
                                            <td>
                                                {supplier_name}			
                                            </td>

                                            <td>{final_date}</td>
                                            <td style="text-align: right;"><?php echo (($position == 0) ? "$currency {net_total_amount}" : "{net_total_amount} $currency") ?></td>

                                        </tr>
                                        {/return_list}
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="text-right"><?php echo $links ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Manage Invoice End -->

