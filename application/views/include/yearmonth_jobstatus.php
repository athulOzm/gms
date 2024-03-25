<?php //d($job_complet_declinedstatus_yearmonth); ?>
<div id="flotChart8" class="flotChart-demo"></div>
<script type="text/javascript">
    
//    ============ its for pie chart ==============
    var data8 = [
    {label: " Complete Job ( <?php echo $job_complet_declinedstatus_yearmonth[0]->ttl_completejob; ?> )", data: <?php echo $job_complet_declinedstatus_yearmonth[0]->ttl_completejob; ?>, color: "#328F00"},
    {label: " Declined Job ( <?php echo $job_complet_declinedstatus_yearmonth[0]->ttl_declinedjob; ?> )", data: <?php echo $job_complet_declinedstatus_yearmonth[0]->ttl_declinedjob; ?>, color: "#6CABBC"},
    {label: " Declined Job ( <?php echo $job_complet_declinedstatus_yearmonth[0]->ttl_acceptedjob; ?> )", data: <?php echo $job_complet_declinedstatus_yearmonth[0]->ttl_acceptedjob; ?>, color: "#50de05"},
//    {label: "Data 4", data: 32, color: "#64d728"}
    ];
    var chartUsersOptions8 = {
    series: {
    pie: {
    show: true
    }
    },
            grid: {
            hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                    x: 20,
                            y: 0
                    },
                    defaultTheme: false
            }
    };
    $.plot($("#flotChart8"), data8, chartUsersOptions8);
</script>