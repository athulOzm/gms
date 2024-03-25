<link href="<?php echo base_url('assets/custom/inspection.css') ?>" rel="stylesheet" type="text/css"/>
<?php
$CI = & get_instance();
$CI->load->model('Inspection_model');
?>
<!-- Printable area start -->
<div class="row">
    <div id="printableArea">
        <p style="text-align: center; font-size: 12px;">
            <?php echo $get_inspection->inspection_name; ?>
        </p>
        <div class="col-md-12 p-b-20">
            <?php
//            $package_value = array();
//            foreach ($get_package_data as $package) {
//                echo $package_value[] = $package->pass_fail;
//            }
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
                            ?>
                            <tr style="background: #ddd; ">
                                <th width="80%" class="p-l-2" >
                                    <?php echo $jobcategory->job_category_name; ?>
                                </th>
                                <th width="10%" class="text-center">Pass</th>
                                <th width="10%" class="text-center">Fail</th>
                            </tr>
                            <?php
                            $i = 0;
//                            dd($package_value);
                            foreach ($get_jobtype as $jobtype) {
//                                echo $jobtype->job_type_id;
                                $get_package_data = $CI->Inspection_model->get_package_data($jobtype->job_type_id, $job_id);
                                $i++;
                                ?>
                                <tr>
                                    <td class="p-l-2">
                                        <?php echo $jobtype->job_type_name; // . " " . $jobtype->job_type_id; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($get_package_data->pass_fail == 1) {
                                            echo '<strong style="color : green"> ✓</strong>';
                                        }
                                        ?>   
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($get_package_data->pass_fail == 0) {
                                            echo '<strong style="color :red;" > ×</strong>';
                                        }
                                        ?>   
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
        <div class="col-sm-12 m-t-20">
            <div class="form-group col-sm-12">
                <label for="comment" class="col-sm-2 col-form-label"><?php echo display('comment') ?> :</label>
                <div class="col-sm-8">
                    <?php echo $package_info->comment; ?>
                </div>
            </div>
            <div class="form-group col-sm-6">
                <label for="comment" class="col-sm-4 col-form-label"><?php echo display('serviceman') ?> :</label>
                <div class="col-sm-8">
                    <?php echo $package_info->name; ?>
                </div>
            </div>
            <div class="form-group col-sm-6">
                <label for="comment" class="col-sm-3 col-form-label"><?php echo display('date') ?> :</label>
                <div class="col-sm-8">
                    <?php
                    $date_format = $this->session->userdata('date_format');
                    if ($date_format == 1) {
                        echo date('d-m-Y', strtotime($package_info->created_date));
                    } elseif ($date_format == 2) {
                        echo date('m-d-Y', strtotime($package_info->created_date));
                    } elseif ($date_format == 3) {
                        echo date('Y-m-d', strtotime($package_info->created_date));
                    }

//                    echo date('d-m-Y', strtotime($package_info->created_date));
                    ?>
                </div>
            </div>
        </div>
        <!--        <div style="text-align: right; ">
                    <button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>
                </div>-->
    </div>
</div>
<script src="<?php echo base_url('assets/custom/inspection.js'); ?>"></script>