<?php echo form_open('Cjob/job_category_update', array('class' => 'form-vertical', 'id' => 'insert_customer')) ?>
<div class="panel-body">
    <!--    <div class="form-group row">
            <label for="service_type" class="col-sm-3 col-form-label"><?php echo display('service_type') ?> <i class="text-danger">*</i></label>
            <div class="col-sm-6">
                <select class="form-control select2" name ="service_type" id="service_type" data-placeholder="" tabindex="1">
                    <option value="">-- select one --</option>
    <?php foreach ($get_service_types as $type) { ?>
                            <option value='<?php echo $type->service_type_id; ?>' <?php
        if ($type->service_type_id == $service_category_edit->service_type_id) {
            echo 'selected';
        }
        ?>>
        <?php echo $type->service_type_name; ?>
                            </option>
    <?php } ?>
                </select>
            </div>
        </div>-->
    <div class="form-group row">
        <label for="job_category" class="col-sm-3 col-form-label"><?php echo display('job_category') ?> <i class="text-danger">*</i></label>
        <div class="col-sm-6">
            <input class="form-control" name ="job_category" id="job_category" type="text" value="<?php echo $job_category_edit->job_category_name; ?>" placeholder="<?php echo display('job_category') ?>"  required="" tabindex="1">
        </div>
    </div>
    <div class="form-group row">
        <label for="example-text-input" class="col-sm-4 col-form-label"></label>
        <div class="col-sm-6">
            <input type="hidden" name="job_category_id" value="<?php echo $job_category_edit->job_category_id; ?>">
            <input type="submit" id="add-customer" class="btn btn-primary btn-large" name="add-customer" value="<?php echo display('update') ?>" tabindex="2"/>
        </div>
    </div>
</div>
<?php echo form_close() ?>