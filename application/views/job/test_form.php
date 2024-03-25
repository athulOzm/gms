
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('jobs') ?></h1>
            <small><?php echo display('manage_job_type') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('jobs') ?></a></li>
                <li class="active"><?php echo display('manage_job_type') ?></li>
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


        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('manage_job_type') ?> </h4>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th>Phrase</th>
                                        <th>English</th>
                                    </tr>
                                </thead>
                                <tbody id="load_data">
                                </tbody>    
                            </table>                              
                            <div id="load_data_message" style="display: none; text-align: center; "><img src="<?php echo base_url('assets/dist/img/loader.gif'); ?>" alt="" width="10%" style="position: fixed; left: 50%; top: 35%; z-index: 999;"></div>
                            <!--<div id="load_data_message2" style="display: none; "><button class='btn btn-warning' type='button'>Data Not Found</button></div>-->
                        </div>
                    </div>
                </div>

            </div>
    </section>
</div>
<!-- Add new category end -->
<script type="text/javascript">
    $(document).ready(function () {
        var limit = 5;
        var start = 0;
        var action = 'inactive';
        function load_country_data(limit, start) {
             $("#load_data_message").show();
            $.ajax({
                url: "<?php echo base_url('Cjob/get_all_record'); ?>",
                type: "POST",
                data: {limit: limit, start: start},
                cache: false,
                success: function (data) {
                    // alert(data);
                   
                    if (data == '') {
                        action = 'active';
                    } else {                       
                        action = 'inactive';
//                     $("#load_data_message2").show();
                    }
                setTimeout(function () {
                     $("#load_data_message").hide();
//                        $("#load_data_message2").hide();
                }, 700);
                     $("#load_data").append(data);
                }
            });
        }

        if (action == 'inactive') {
            action = 'active';
            load_country_data(limit, start);
        }
        $(window).scroll(function () {
//            if ($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
            if ($(window).scrollTop()  > 450 && action == 'inactive')
            {
                action = 'active';
                start = start + limit; 
                load_country_data(limit, start);
            }
        });
    });
</script>