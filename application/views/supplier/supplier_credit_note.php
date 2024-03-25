<!-- Supplier Details Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('credit_notes') ?></h1>
            <small><?php echo display('credit_notes') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('supplier') ?></a></li>
                <li class="active"><?php echo display('credit_notes') ?></li>
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
                <div class="column m-b-10" style="float: right;">
                    <?php if ($this->permission1->check_label('add_supplier')->create()->access()) { ?>
                        <a href="<?php echo base_url('Csupplier') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_supplier') ?> </a>
                        <?php
                    }
                    if ($this->permission1->check_label('manage_supplier')->read()->access()) {
                        ?>
                        <a href="<?php echo base_url('Csupplier/manage_supplier') ?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_supplier') ?> </a>
                        <?php
                    }
                    if ($this->permission1->check_label('supplier_ledger')->read()->access()) {
                        ?>
                        <a href="<?php echo base_url('Csupplier/supplier_ledger_report') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_ledger') ?> </a>
                        <?php
                    }
                    if ($this->permission1->check_label('supplier_sales_details')->read()->access()) {
                        ?>
                        <a href="<?php echo base_url('Csupplier/supplier_sales_details_all') ?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('supplier_sales_details') ?> </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('credit_notes') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo base_url('Csupplier/inser_credit_note'); ?>" method="post">
                            <div class="form-group row">
                                <label for="credit_note_no" class="col-sm-3 col-form-label text-right"><?php echo display('credit_note_no') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="credit_note_no" id="credit_note_no" type="text" placeholder="<?php echo display('credit_note_no') ?>"  required="" tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="date" class="col-sm-3 col-form-label text-right"><?php echo display('date') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control datepicker" name ="date" id="date" value="<?php echo date('Y-m-d'); ?>" type="text" placeholder="<?php echo display('date') ?>"  required="" tabindex="2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="supplier_id" class="col-sm-3 col-form-label text-right"><?php echo display('supplier_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <?php // d($get_supplier);    ?>
                                    <select name="supplier_id" class="form-control" onchange="supplier_chalan_no(this.value)" id="supplier_id" required="" tabindex="3">
                                        <option value=""></option>
                                        <?php
                                        foreach ($get_supplier as $supplier) {
                                            echo "<option value='$supplier->supplier_id'>$supplier->supplier_name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="chalan_no" class="col-sm-3 col-form-label text-right"><?php echo display('purchase_id') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="chalan_no" name="chalan_no"  onchange="chalan_info(this.value)">
                                    </select>
                                    <input class="form-control" name ="purchase_id" id="purchase_id" type="hidden" placeholder="<?php echo display('purchase_id') ?>"  required="">
                                </div>
                            </div>
                            <div class="chalan_info"></div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label text-right"> </label>
                                <div class="col-sm-6">
                                    <input type="submit" class="btn btn-success " value="Save">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
<!-- Supplier Details End  -->
<script type="text/javascript">
//    ============= its for supplier wise chalan no ===========
    function supplier_chalan_no(supplier_id) {
        $.ajax({
            url: "<?php echo base_url('Csupplier/supplier_chalan_no'); ?>",
            type: "POST",
            data: {supplier_id: supplier_id},
            success: function (r) {
//                console.log(r);
                r = JSON.parse(r);
                $("#chalan_no").empty();
                $("#chalan_no").html("<option value=''>-- select one -- </option>");
                $.each(r, function (ar, typeval) {
                    $('#chalan_no').append($('<option>').text(typeval.purchase_id).attr('value', typeval.purchase_id));
                });
            }
        });
    }

//=========== its for return_info ===========
    function chalan_info(purchase_id) {
        $("#purchase_id").val(purchase_id);
        $.ajax({
            url: "<?php echo base_url('Csupplier/return_info'); ?>",
            type: "post",
            data: {purchase_id: purchase_id},
            success: function (r) {
                $(".chalan_info").html(r);
            }
        });
    }
</script>