<!--Edit customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('service_edit') ?></h1>
            <small><?php echo display('service_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('service') ?></a></li>
                <li class="active"><?php echo display('service_edit') ?></li>
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

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('service_edit') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cservice/service_update', array('class' => 'form-vertical', 'id' => 'service_update')) ?>
                    <div class="panel-body">
                        <?php // dd(); ?>
                        <div class="form-group row">
                            <label for="service_type" class="col-sm-3 col-form-label text-right"><?php echo display('service_type') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="service_type" name="service_type" onchange="servicetype_wise_category(this.value)" data-placeholder="-- select one -- " required>
                                    <option value=""></option>
                                    <?php foreach ($get_service_types as $type) { ?>
                                        <option value='<?php echo $type->service_type_id; ?>' <?php
                                        if ($type->service_type_id == $service_type_id) {
                                            echo 'selected';
                                        }
                                        ?>>
                                                    <?php echo $type->service_type_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="service_category" class="col-sm-3 col-form-label text-right"><?php echo display('service_category') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="service_category" name="service_category" data-placeholder="-- select one -- ">
                                    <option value=""></option>
                                    <?php foreach ($servicetype_wise_category as $single) { ?>
                                        <option value="<?php echo $single->service_category_id; ?>" <?php
                                        if ($single->service_category_id == $service_category_id) {
                                            echo 'selected';
                                        }
                                        ?>>
                                                    <?php echo $single->service_category_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="service_name" class="col-sm-3 col-form-label text-right"><?php echo display('service_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="service_name" id="service_name" type="text" placeholder="<?php echo display('service_name') ?>"  required="" value="{service_name}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="service_rate" class="col-sm-3 col-form-label text-right"><?php echo display('service_rate') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="service_rate" id="service_rate" type="text" value="{service_rate}" placeholder="<?php echo display('service_rate') ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="standard_timing" class="col-sm-3 col-form-label text-right"><?php echo display('standard_timing') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="standard_timing" name="standard_timing" value="{standard_timing}">
                            </div>
                        </div>
                        <input type="hidden" value="{service_id}" name="service_id">

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-service" class="btn btn-success btn-large" name="add-service" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit customer end -->


<script type="text/javascript">
//   ============= its for servicetype_wise_category =============
    function servicetype_wise_category(t) {
        $.ajax({
            url: "<?php echo base_url('CService/servicetype_wise_category'); ?>",
            type: 'POST',
            data: {type_id: t},
            success: function (r) {
                console.log(r);
                r = JSON.parse(r);
                $('#service_category').empty();
                $("#service_category").html("<option value=''>-- select one -- </option>");
                $.each(r, function (ar, typeval) {
                    $("#service_category").append($('<option>').text(typeval.service_category_name).attr('value', typeval.service_category_id));
                });
            }
        });
    }
</script>