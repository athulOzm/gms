
(function ($) {
    "use strict";
    $(document).ready(function () {
        $('.btnNext').click(function () {
            $('.nav-tabs > .active').next('li').find('a').trigger('click');
        });
        $('.btnPrevious').click(function () {
            $('.nav-tabs > .active').prev('li').find('a').trigger('click');
        });
    });
//-========== close ready function ========-->


})(jQuery);


//    ============= its for discount_trade_markup =============-->
"use strict";
//    function jobkeyup_search() {
//        var keyword = $("#keyword").val();
//        var jobkeyupsearch = $("#jobkeyupsearch").val();
//        $.ajax({
//            url: jobkeyupsearch,
//            type: 'post',
//            data: {keyword: keyword},
//            success: function (r) {
////                console.log(r);
//                $("#results").html(r);
//            }
//        });
//    }
//--========== close   ===========-->
//--========== its for job category edit   ===========-->
"use strict";
function show_job_category_edit(id) {
    var jobcateditUrl = $("#jobcateditUrl").val();
    $.ajax({
        url: jobcateditUrl,
        type: 'POST',
        data: {job_category_id: id},
        success: function (t) {
            $("#category_info").html(t);
            $('#category_modal_info').modal('show');
        }
    });
}
//--============= close ==============-->
//--============= its for time picker ==============-->
$(function () {
    $('#standard_timing').timepicker({
        'format': "HH:mm", // HH:mm:ss its for 24 hours format
//                    format: 'LT'  /// its for 12 hours format
    });
});
//--============= close ==============-->
//    =============== its for view_checklist only show -===============
"use strict";
function view_checklist(inspection_id, job_id) {
    var viewChecklistUrl = $("#viewChecklistUrl").val();
    $.ajax({
        url: viewChecklistUrl,
        type: "POST",
        data: {inspection_id: inspection_id, job_id: job_id},
        success: function (r) {
            $("#modal_info").html(r);
            $('#modal_show_info').modal('show');
        }
    });
}
//--============= close view_checklist==============-->