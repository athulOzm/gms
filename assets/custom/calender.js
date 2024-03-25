
(function ($) {
    "use strict";
    $(document).ready(function () {

    });
//--========== close ready function ========


})(jQuery);
//  ============= its for discount_trade_markup =============
"use strict";
function booking_check(value) {
    var date = $("#bdate").val();
    var nbookingCheck = $("#nbookingCheck").val();
    $.ajax({
        url: nbookingCheck,
        type: 'POST',
        data: {date: date, time: value},
        success: function (r) {
            r = JSON.parse(r);
            if (r.status == true) {
                alert('Already booked ! Please Select Another Time');
                $("#btime").val('');
            } else {
                return true;
            }

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('fail');
        }
    });
}
//--========== close   ===========
//-============= its for booking_vehicle==============
"use strict";
function booking_vehicle(value2) {
    var reg_no = $("#vehi_registration_no").val();
    var value1 = $("#start_date").val();
    var crtbookingCheck = $("#crtbookingCheck").val();
//    alert(reg_no);
    $.ajax({
        url: crtbookingCheck,
        type: 'POST',
        data: {
            startdate: value1, enddate: value2, reg_no: reg_no},
        success: function (r) {

            $('#previous').html(r);
//            $('#start_date').val('');
//            $('#end_date').val('');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $('#previous').html("<p style='color:red'><?php echo 'Please Select Registration'; ?></p>");
        }
    });
}
//--============= close ==============-
//--============= its for customer wise vehicle  ==============-

//    ============ its for customer_wise_vehicle ==============-->
"use strict";
function customer_wise_vehicle(t) {
    var custWiseVehi = $("#custWiseVehi").val();
    $.ajax({
        url: custWiseVehi,
        type: 'POST',
        data: {customer_id: t},
        success: function (r) {
//                console.log(r);-->
            r = JSON.parse(r);
            $("#registration_no").empty();
            $("#registration_no").html("<option value=''>-- select one -- </option>");
            $.each(r, function (ar, typeval) {
                $('#registration_no').append($('<option>').text(typeval.vehicle_registration).attr('value', typeval.vehicle_registration));
            });
        }
    });
}
//--============= close customer wise vehicle ==============-->
//--============= its for booking accept =============-->
"use strict";
function bookingAccept(id, status, btime) {
    var bkingAccept = $("#bkingAccept").val();
    var r = confirm("Are You Sure!");
    if (r == true) {
        var id = id;
        $.ajax({
            url: bkingAccept,
            type: 'POST',
            data: {id: id, status: status, btime: btime},
            success: function (r) {
                r = JSON.parse(r);
                if (r.result == true) {
                    location.reload();
                } else {
                    alert('Already Booked This Time');
                }

            }
        });
    } else {
        return false;
    }
}
//--============ close booking accept ============-->
//--//    =============== its for booking onkeyup search ===============-->
"use strict";
function bookingonkeyup_search() {
    var keyword = $("#keyword").val();
    var bkingSearch = $("#bkingSearch").val();
    $.ajax({
        url: bkingSearch,
        type: 'post',
        data: {keyword: keyword},
        success: function (r) {
//                console.log(r);-->
            $("#results").html(r);
        }
    });
}
//--============ close booking onkeyup search  =============-->
//--============ its  customer wise vehicle info =============-->
"use strict";
function get_customer_info(t) {
    var custVehicleInfo = $("#custVehicleInfo").val();
    $.ajax({
        url: custVehicleInfo,
        type: 'POST',
        data: {customer_id: t},
        success: function (r) {
//                console.log(r);-->
            r = JSON.parse(r);
            $("#registration_no").empty();
            $("#registration_no").html("<option value=''>-- select one -- </option>");
            $.each(r, function (ar, typeval) {
                $('#registration_no').append($('<option>').text(typeval.vehicle_registration).attr('value', typeval.vehicle_registration));
            });
        }
    });
}
//============ close customer wise vehicle info  =============-->
//--//    ============= its for courtesybookingdate_search ============-->
"use strict";
function  courtesybookingdate_search() {
    var courtesyBkingSearch = $("#courtesyBkingSearch").val();
    var startdate = $("#startdate").val();
    var enddate = $("#enddate").val();
    $.ajax({
        url: courtesyBkingSearch,
        type: 'post',
        data: {startdate: startdate, enddate: enddate},
        success: function (r) {
//                console.log(r);-->
            $("#results").html(r);
        }
    });
}
//--============ close courtesybookingdate_search  =============-->
//--//    =============== its for booking onkeyup search ===============-->
"use strict";
function courtesybookingonkeyup_search() {
    var keyword = $("#keyword").val();
    var courtesyBkingkeyupSearch = $("#courtesyBkingkeyupSearch").val();
    $.ajax({
        url: courtesyBkingkeyupSearch,
        type: 'post',
        data: {keyword: keyword},
        success: function (r) {
//                console.log(r);-->
            $("#results").html(r);
        }
    });
}
//--============ close booking onkeyup search  =============-->
