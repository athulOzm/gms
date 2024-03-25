<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('inspection') ?></h1>
            <small><?php echo display('create_checklist') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('inspection') ?></a></li>
                <li class="active"><?php echo display('create_checklist') ?></li>
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
                <div class="column float_right ">
                    <?php if ($this->permission1->check_label('view_checklist')->read()->access()) { ?>
                    <a href="<?php echo base_url('Cinspection/view_checklist') ?>" class="btn btn-info m-b-5 m-r-2">
                        <i class="ti-align-justify"> </i> <?php echo display('view_checklist') ?> </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('create_checklist') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Cinspection/inspection_checklist_save', array('class' => 'form-vertical', 'id' => '')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="checklist_name" class="col-sm-3 col-form-label text-right"><?php echo display('checklist_name') ?> <i class="text-danger"> *</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control checklist_name" id="checklist_name" name="checklist_name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rate" class="col-sm-3 col-form-label text-right"><?php echo display('rate') ?> <i class="text-danger"> *</i></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control rate" id="rate" name="rate" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="standard_timing" class="col-sm-3 col-form-label text-right"><?php echo display('standard_timing') ?> <i class="text-danger"> *</i></label>
                            <div class="col-sm-6">                               
                                <input id="standard_timing" type="text" class="form-control onlyTimePicker" name="standard_timing"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="product_table">
                                    <thead>
                                        <tr>
                                            <th width="30%"><?php echo display('job_category'); ?></th>
                                            <th width="60%"><?php echo display('job_type'); ?></th>   
                                            <th width="10%">
                                                <button type="button" class="btn btn-success" onClick="addProduct('itmetable');"><i class="fa fa-plus"></i></button>
                                            </th>      
                                        </tr>
                                    </thead>
                                    <tbody id="itmetable">
                                        <tr>
                                            <td>
                                                <select name="job_category_id[]" id="job_category_id" class="form-control select2" onchange="job_category_wise_type(this.value, '1')">
                                                    <option value="">Select One</option>
                                                    <?php foreach ($job_category as $category) { ?>
                                                        <option value='<?php echo $category->job_category_id; ?>'>
                                                            <?php echo $category->job_category_name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>       
                                            </td>
                                            <td>
                                                <div id="job_type_list_1">

                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-category" class="btn btn-success btn-large" name="add-checklist" value="<?php echo display('save') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new category end -->
<script type="text/javascript">
//    ============ job_category_wise_type  ============
    function job_category_wise_type(cid, sl) {
//        var t = $("#job_type_list_"+sl);
        $.ajax({
            url: "<?php echo base_url('Cinspection/job_category_wise_type'); ?>",
            type: "POST",
            data: {category_id: cid},
            success: function (r) {
//                console.log(r);
                $("#job_type_list_" + sl).html(r);
            }
        });
    }

    function addProduct(t) {
        var row = $("#product_table tbody tr").length;
        var count = row + 1;
        var limits = 500;
        var i = 2;
        var xTable = document.getElementById('product_table');
        var tr = document.createElement('tr');
        tr.innerHTML = '<td><select name="job_category_id[]" id="job_category_id"  class="form-control select2" onchange="job_category_wise_type(this.value, ' + count + ')"><option value="" >-- select one -- </option><?php foreach ($job_category as $category) { ?><option value="<?php echo $category->job_category_id; ?>"><?php echo $category->job_category_name; ?></option> <?php } ?></select></td>\n\
                                 <td><div id="job_type_list_' + count + '"></div></td>\n\
                                 <td><button  class="btn btn-danger removeitem text-right" type="button"  onclick="" tabindex="8"><i class="fa fa-close"></i></button></td>';
        document.getElementById(t).appendChild(tr),
                // document.getElementById(a).focus(),
                count++, i++;
        //xTable.children[1].appendChild(tr); // appends to the tbody element
        $('.select2').select2();
    }
    $(document).on('click', 'button.removeitem', function () {
        $(this).closest('tr').remove();
        return false;
    });
</script>
<script src="<?php echo base_url('assets/custom/inspection.js'); ?>"></script>



