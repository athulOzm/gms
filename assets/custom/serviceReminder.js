
(function ($) {
    "use strict";
    $(document).ready(function () {

    });
//-========== close ready function ========-->


})(jQuery);


//    ====== its for customer wise vehicle information ===========
"use strict";
function get_customer_info(t) {
    var custinfo = $("#custinfo").val();
    $.ajax({
        url: custinfo,
        type: 'POST',
        data: {customer_id: t},
        success: function (r) {
//                console.log(r);
            r = JSON.parse(r);
            $("#registration_no").empty();
            $("#registration_no").html("<option value=''>-- select one -- </option>");

            $.each(r, function (ar, typeval) {
                $('#registration_no').append($('<option>').text(typeval.vehicle_registration).attr('value', typeval.vehicle_id));
            });
        }
    });
}
//--========== close   ===========-->

//--============= close ==============-->