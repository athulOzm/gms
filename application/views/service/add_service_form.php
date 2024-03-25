
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_service') ?></h1>
            <small><?php echo display('add_new_service') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('service') ?></a></li>
                <li class="active"><?php echo display('add_service') ?></li>
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
                <div class="column">
                    <?php if ($this->permission1->method('manage_service', 'read')->access()) { ?>
                        <a href="<?php echo base_url('Cservice/manage_service') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_service') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->method('create_service', 'create')->access()) { ?>
                        <!--<button type="button" class="btn btn-info m-b-5 m-r-2" data-toggle="modal" data-target="#service_csv"><?php echo display('service_csv_upload') ?></button>-->
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_service') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Cservice/insert_service', array('class' => 'form-vertical', 'id' => 'insert_service')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="service_type" class="col-sm-3 col-form-label text-right"><?php echo display('service_type') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="service_type" name="service_type" onchange="servicetype_wise_category(this.value)" data-placeholder="-- select one -- " required>
                                    <option value=""></option>
                                    <?php
                                    foreach ($get_service_types as $type) {
                                        echo "<option value='$type->service_type_id'>$type->service_type_name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="service_category" class="col-sm-3 col-form-label text-right"><?php echo display('service_category') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="service_category" name="service_category" data-placeholder="-- select one -- ">
                                    <option value=""></option>
                                    <?php ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="service_name" class="col-sm-3 col-form-label text-right"><?php echo display('service_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="service_name" id="service_name" type="text" placeholder="<?php echo display('service_name') ?>"  required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="service_rate" class="col-sm-3 col-form-label text-right"><?php echo display('service_rate') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="service_rate" id="service_rate" type="text" placeholder="<?php echo display('service_rate') ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="standard_timing" class="col-sm-3 col-form-label text-right"><?php echo display('standard_timing') ?> <i class="text-danger"></i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="standard_timing" name="standard_timing">
<!--                                <div class='input-group date' id='datetimepicker3'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>-->
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-service" class="btn btn-success btn-large" name="add-service" value="<?php echo display('save') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <div id="service_csv" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><?php echo display('service_csv_upload'); ?></h4>
                        </div>
                        <div class="modal-body">

                            <div class="panel">
                                <div class="panel-heading">
                                    <div><a href="<?php echo base_url('assets/data/csv/service_csv_sample.csv') ?>" class="btn btn-primary pull-right"><i class="fa fa-download"></i><?php echo display('download_sample_file') ?> </a> </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo form_open_multipart('Cservice/uploadCsv_service', array('class' => 'form-vertical', 'id' => 'validate', 'name' => 'insert_service')) ?>
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="upload_csv_file" class="col-sm-4 col-form-label"><?php echo display('upload_csv_file') ?> <i class="text-danger">*</i></label>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="upload_csv_file" type="file" id="upload_csv_file" placeholder="<?php echo display('upload_csv_file') ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <input type="submit" id="add-product" class="btn btn-primary btn-large" name="add-product" value="<?php echo display('submit') ?>" />
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new customer end -->
<script type="text/javascript">
    $(document).ready(function () {

    });
//   ============= its for servicetype_wise_category =============
    function servicetype_wise_category(t) {
        $.ajax({
            url: "<?php echo base_url('Cservice/servicetype_wise_category'); ?>",
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



