<link href="<?php echo base_url('assets/custom/inspection.css') ?>" rel="stylesheet" type="text/css"/>

<?php
$CI = & get_instance();
$CI->load->model('Inspection_model');
?>
<div class="row">
    <form action="<?php echo base_url('Cinspection/package_save'); ?>" method="post">
        <p class="text-center fnt_size_12">
            <?php echo $get_inspection->inspection_name; ?>
            <?php //echo $get_inspection->inspection_id; ?>
        </p>
        <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
        <input type="hidden" name="inspection_job_typeid" value="<?php echo $get_inspection->job_type_id; ?>">
        <div class="col-md-12 p-b-20">
            <?php
            $j = 0;
            foreach ($get_jobcategory as $jobcategory) {
                $j++;
                if ($j % 2 == 1) {
                    echo '<div class="col-md-12">';
                }
                ?>
                <div class="col-sm-6">
                    <table class="">
                        <thead>
                            <?php
                            $get_jobtype = $this->db->select('a.*, b.job_type_name')->from('inspection_list a')
                                            ->join('job_type b', 'b.job_type_id = a.job_type_id')
                                            ->where('a.category_id', $jobcategory->category_id)
                                            ->where('a.inspection_id', $get_inspection->inspection_id)
                                            ->get()->result();
//                                            echo $this->db->last_query();
                            ?>
                            <tr class="bg_ddd ">
                                <th width="80%">
                                    <?php echo $jobcategory->job_category_name; ?>
                                    <input type="hidden" name="job_category_id[]" value="<?php echo $jobcategory->category_id; ?>">
                                </th>
                                <th width="10%" class="text-center">Pass</th>
                                <th width="10%" class="text-center">Fail</th>
                            </tr>
                            <?php
                            $i = 0;
                            foreach ($get_jobtype as $jobtype) {
//                                echo $jobtype->job_type_id."<br>";
                                $get_package_data = $CI->Inspection_model->get_package_data($jobtype->job_type_id, $job_id);
                                //d($get_package_data);
                                $i++;
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $jobtype->job_type_name; ?>
                                        <input type="hidden" name="<?php echo $jobcategory->category_id; ?>_job_type_id[]" value="<?php echo $jobtype->job_type_id; ?>">
                                    </td>
                                    <td class="text-center">
                                        <input type="radio" value="1" <?php if(@$get_package_data->pass_fail == 1){ echo 'checked'; }else{ echo ''; } ?>  name="<?php echo $jobtype->job_type_id; ?>_pass_fail">
                                        <label for=""><span><span></span></span></label>
                                    </td>
                                    <td class="text-center">
                                        <input type="radio" value="0" <?php if(empty($get_package_data)){}else{ if(@$get_package_data->pass_fail == 0){ echo 'checked'; }else{ echo ''; }} ?> name="<?php echo $jobtype->job_type_id; ?>_pass_fail">
                                        <label for=""><span><span></span></span></label>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </thead>
                    </table>
                </div>
                <?php
                if ($j % 2 == 0) {
                    echo '</div>';
                }
                ?>
            <?php } ?>
        </div>    
        <div class="col-md-12 m-t-20">
            <div class="form-group ">
                <label for="comment" class="col-sm-2 col-form-label text-right"><?php echo display('comment') ?> <i class="text-danger"> </i></label>
                <div class="col-sm-8">
                    <textarea rows="3" class="form-control" name="comment" id="comment"><?php echo @$get_package_data->comment; ?></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <input type="submit" class="btn btn-success btn-sm float_right" value="Save" > 
        </div>
    </form>
</div>