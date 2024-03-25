<?php
$user_type = $this->session->userdata('user_type');
$user_id = $this->session->userdata('user_id');
$position = $currency_details[0]['currency_position'];
$currency = $currency_details[0]['currency'];
?>
<!-- Manage service Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('inventory') ?></h1>
            <small><?php echo display('group_price_list') ?></small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('inventory') ?></a></li>
                <li class="active"><?php echo display('group_price_list') ?></li>
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
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <?php echo display('group_price_list'); ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered" id="">
                            <thead>
                                <tr>
                                    <th><?php echo display('sl'); ?></th>
                                    <th><?php echo display('group_name'); ?></th>
                                    <th><?php echo display('product'); ?></th>
                                    <th class="text-right"><?php echo display('cumulative_price'); ?></th>
                                    <th class="text-right"><?php echo display('group_price'); ?></th>
                                    <th class="text-center"><?php echo display('action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sl = 0 + $pagenum;
                                foreach ($get_groupprice_info as $groupinfo) {
                                    $get_groupdetails_info = $this->Products->get_groupdetails_info($groupinfo->group_price_id);
                                    $sl++;
                                    ?>
                                    <tr>
                                        <td><?php echo $sl; ?></td>
                                        <td><?php echo $groupinfo->group_name ?></td>
                                        <td>
                                            <?php
//                                            d($get_groupdetails_info);
                                            foreach ($get_groupdetails_info as $groupdetails) {
                                                echo $groupdetails->product_name . "<br>";
                                            }
                                            ?>
                                        </td>
                                        <td class="text-right">
                                            <?php
                                            echo (($position == 0) ? "$currency $groupinfo->cumulative_price" : "$groupinfo->cumulative_price $currency");
                                            ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo (($position == 0) ? "$currency $groupinfo->groupprice" : "$groupinfo->groupprice $currency"); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($this->permission1->check_label('group_price_list')->update()->access()) { ?>
                                                <a href="<?php echo base_url('Cproduct/edit_groupprice_info/' . $groupinfo->group_price_id); ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="left" title='Edit'> </i></a>
                                                <?php
                                            }
                                            if ($this->permission1->check_label('group_price_list')->delete()->access()) {
                                                ?>
                                                <a href="<?php echo base_url('Cproduct/delete_groupprice_info/' . $groupinfo->group_price_id); ?>"  class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure') ?>')"><i class="fa fa-trash-o" data-toggle="tooltip" data-placement="left" title='Delete'> </i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <?php if (empty($get_groupprice_info)) { ?>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-center text-danger"><?php echo display('data_not_found'); ?></th>
                                    </tr>
                                </tfoot>
                            <?php } ?>
                        </table>
                        <?php echo $links; ?>
                        
                    </div>
                </div>
            </div>
        </div>       
    </section>
</div>
