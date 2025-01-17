<!-- Purchase Report Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Return form</h1>
            <small>Return form</small>

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
                    <?php if ($this->permission1->check_label('stock_return_list')->read()->access()) { ?>
                        <a href="<?php echo base_url('Cretrun_m/return_list') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('c_r_slist') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->check_label('supplier_return_list')->read()->access()) { ?>
                        <a href="<?php echo base_url('Cretrun_m/supplier_return_list') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_return') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->check_label('wastage_return_list')->read()->access()) { ?>
                        <a href="<?php echo base_url('Cretrun_m/wastage_return_list') ?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('wastage_list') ?> </a>
                    <?php } ?>

                </div>
            </div>
        </div>
        <!-- Add Product Form -->
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <?php echo form_open('Cretrun_m/invoice_return_form', array('class' => 'form-inline')) ?>
                        <div class="form-group">
                            <strong>Return From Customer</strong><br><br>
                            <label for="to_date">Sale ID:</label>
                            <input type="text" name="invoice_id" class="form-control" id="to_date" placeholder="<?php echo display('invoice_id') ?>" required="required">
                        </div>  
                        <br><br>
                        <div class="salesIdSearch_btn">
                            <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-body"> 
                        <?php echo form_open('Cretrun_m/supplier_return_form', array('class' => 'form-inline')) ?>
                        <div class="form-group">
                            <strong>Return To Supplier</strong><br><br>
                            <label for="sto_date">Purchase ID:</label>
                            <input type="text" name="purchase_id" class="form-control" id="sto_date" placeholder="Return Purchase Id" required="required">
                        </div>  
                        <br><br>
                        <div class="supplierIdSearch_btn">
                            <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add category -->
    </section>
</div>