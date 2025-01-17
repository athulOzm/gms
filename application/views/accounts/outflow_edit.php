<!-- Supplier js php -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/supplier.js.php" ></script>

<!-- Accounts type select by js start -->
<style>
	#bank_info_hide
	{
		display:none;
	}
    #payment_from_2
    {
           display:none;
    }
        
</style>
<script type="text/javascript">
	function bank_info_show(payment_type)
	{
	    if(payment_type.value=="1"){
	        document.getElementById("bank_info_hide").style.display="none";
	    }
	    else{
            
          document.getElementById("bank_info_hide").style.display="block";  
        }
	 
	}
        
    function active_customer(status)
    {
     if(status=="payment_from_2"){
            document.getElementById("payment_from_2").style.display="none";
            document.getElementById("payment_from_1").style.display="block";
            document.getElementById("myRadioButton_2").checked = false;
            document.getElementById("myRadioButton_1").checked = true;
    }else{
         	document.getElementById("payment_from_1").style.display="none";
         	document.getElementById("payment_from_2").style.display="block";
         	document.getElementById("myRadioButton_2").checked = false;
          	document.getElementById("myRadioButton_1").checked = true;
        }
    }
</script>
<!-- Accounts type select by js end -->


<!-- Add new income start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('expense_edit') ?></h1>
            <small><?php echo display('expense_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('accounts') ?></a></li>
                <li class="active"><?php echo display('expense_edit') ?></li>
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

        <!-- New Expense -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('expense_edit') ?> </h4>
                        </div>
                    </div>
                    {edit}
                  	<?php echo form_open_multipart('Caccounts/outflow_edit_receiver/{transaction_id}',array('class' => 'form-vertical', ))?>
                    <div class="panel-body">
                    	<?php $today = date('Y-m-d'); ?>

						<div class="form-group row" id="payment_from_1">
					        <label for="supplier_name" class="col-sm-3 col-form-label"><?php echo display('payment_to') ?> <i class="text-danger">*</i></label>
					        <div class="col-sm-6">
					        	<input id="supplier_name" class="form-control supplierSelection ui-autocomplete-input" type="text" placeholder="<?php echo display('supplier_name') ?>" value="{name}" name="supplier_name" autocomplete="off"/>
                                <input id="suppluerHiddenId" class="supplier_hidden_value" value="{supplier_id}" type="hidden" name="supplier_id">
					        </div>
                            <div class="col-sm-3">
                                <input onClick="active_customer('payment_from_1')" type="button" id="myRadioButton_1" class="btn btn-success checkbox_account" name="customer_confirm" checked="checked" value="<?php echo display('new_supplier') ?>">
                                <label for="myRadioButton_1">  </label>
                            </div>
					    </div>

					    <div class="form-group row" id="payment_from_2">
					        <label for="customer_name_others" class="col-sm-3 col-form-label"><?php echo display('payment_to') ?> <i class="text-danger">*</i></label>
					        <div class="col-sm-6">
						       	<input type="text"  name="customer_name_others" class="form-control" placeholder='<?php echo display('payee_name') ?>' id="customer_name_others" />
					        </div>

                            <div class="col-sm-3">
                                <input  onClick="active_customer('payment_from_2')" type="button" id="myRadioButton_2" class="btn btn-success checkbox_account" name="customer_confirm_others" value="<?php echo display('old_supplier') ?>"> 
                            </div>
					    </div>

					    <div class="form-group row">
					        <label for="payment_type" class="col-sm-3 col-form-label"><?php echo display('payment_type') ?> <i class="text-danger">*</i></label>
					        <div class="col-sm-6">
								<select onchange="bank_info_show(this)" name="payment_type" class="form-control">
                                    <option value="{payment_type}"> {payment} </option>
                                    <option value="1"> <?php echo display('cash') ?> </option>
                                    <option value="2"> <?php echo display('cheque') ?> </option>
                                    <option value="3"> <?php echo display('pay_order') ?> </option>
                                </select>
					        </div>
					    </div>

					    <div id="bank_info_hide">
					    	<div class="form-group row">
						        <label for="cheque_or_pay_order_no" class="col-sm-3 col-form-label"><?php echo display('cheque_or_pay_order_no') ?> <i class="text-danger">*</i></label>
						        <div class="col-sm-6">
							        <input type="test" id="amount" class="form-control" value="{cheque_no}" name="cheque_no" placeholder="<?php echo display('cheque_or_pay_order_no') ?>" />
						        </div>
						    </div>
						    <div class="form-group row">
						        <label for="date" class="col-sm-3 col-form-label"><?php echo display('date') ?> <i class="text-danger">*</i></label>
						        <div class="col-sm-6">
							         <input type="text" name="cheque_mature_date" data-date-format="yyyy-mm-dd" value="<?php echo $today; ?>" id="amount"  class="datepicker form-control"/>
						        </div>
						    </div>

						    <div class="form-group row">
						        <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('bank_name') ?> <i class="text-danger">*</i></label>
						        <div class="col-sm-6">
							       	<select name="bank_name"  class="form-control">
                                        <option value="{selected_bank_id}"> {selected_bank}</option>
                                        {bank}
                                        <option value="{bank_id}"> {bank_name}</option>
                                        {/bank}
                                    </select>
						        </div>
						    </div>
					    </div>
                        <div class="form-group row">
                            <label for="payment_account" class="col-sm-3 col-form-label"><?php echo display('payment_account') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                               	<select name="account_table" class="form-control">
                                    {selected}
                                    <option value="{account_table_name}"> {account_name} </option>
                                    {/selected}
                                    {accounts}
                                    <option value="{account_table_name}"> {account_name} </option>
                                    {/accounts}
                                </select>
                                <input type="hidden" value="{selected_table_id}" name="pre_table"/>    
                            </div>
                        </div>

                       	<div class="form-group row">
                            <label for="amount" class="col-sm-3 col-form-label"><?php echo display('ammount') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
								<input type="number" value="{amount}" id="amount" name="amount" required class="form-control" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label"><?php echo display('description') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <textarea  name="description" required class="form-control">{description}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                            	<input type="reset" id="add-deposit" class="btn btn-danger" name="add-deposit" value="<?php echo display('reset') ?>" />

                            	<input type="submit" id="add-deposit" class="btn btn-success" name="add-deposit" value="<?php echo display('save') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                    {/edit}
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add expense end -->



