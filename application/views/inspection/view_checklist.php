<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('inspection') ?></h1>
            <small><?php echo display('view_checklist') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('inspection') ?></a></li>
                <li class="active"><?php echo display('view_checklist') ?></li>
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
                <div class="column float_right">
                    <?php if ($this->permission1->check_label('create_checklist')->create()->access()) { ?>
                        <a href="<?php echo base_url('Cinspection/create_checklist') ?>" class="btn btn-info m-b-5 m-r-2">
                            <i class=""> </i> <?php echo display('create_checklist') ?> </a>
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
                            <h4><?php echo display('view_checklist') ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Name</th>
                                            <th>Job Category</th>
                                            <th>Type</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sl = 0;
                                        foreach ($get_inspectionlist as $inspection) {
                                            $inspection_category = $this->db->select('a.inspection_id, a.category_id, b.job_category_name')
                                                            ->from('inspection_list a')
                                                            ->join('job_category b', 'b.job_category_id = a.category_id')
                                                            ->where('a.inspection_id', $inspection->inspection_id)
                                                            ->group_by('a.category_id')
                                                            ->get()->result();
                                            $inspection_job_types = $this->db->select('*')
                                                            ->from('inspection_list a')
                                                            ->join('job_type b', 'b.job_type_id = a.job_type_id')
                                                            ->where('a.inspection_id', $inspection->inspection_id)
//                                                            ->where('a.inspection_id', $inspection->inspection_id)
                                                            ->order_by('a.category_id', 'asc')
                                                            ->group_by('a.job_type_id')
                                                            ->get()->result();
                                            $sl++;
                                            ?>
                                            <tr>
                                                <td><?php echo $sl; ?></td>
                                                <td><?php echo $inspection->inspection_name; ?></td>
                                                <td>
                                                    <?php
                                                    foreach ($inspection_category as $category) {
                                                        echo "<ul>";
                                                        echo "<li>$category->job_category_name</li>";
                                                        echo "</ul>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    foreach ($inspection_job_types as $job_type) {
                                                        echo "<ul>";
                                                        echo "<li>$job_type->job_type_name</li>";
                                                        echo "</ul>";
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($this->permission1->check_label('view_checklist')->update()->access()) { ?>
                                                        <a href="<?php echo base_url('Cinspection/inspection_edit/' . $inspection->inspection_id); ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>    
                                                        <?php
                                                    }
                                                    if ($this->permission1->check_label('view_checklist')->delete()->access()) {
                                                        ?>
                                                        <a href="<?php echo base_url('Cinspection/inspection_delete/' . $inspection->inspection_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete?')"><i class="fa fa-close"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <?php if (empty($get_inspectionlist)) { ?>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-center text-danger">Record not found!</th>
                                            </tr>
                                        </tfoot>
                                    <?php } ?>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
<!-- Add new category end -->



