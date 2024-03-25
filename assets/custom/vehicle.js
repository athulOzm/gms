"use strict";
function vehiclekeyup_search() {
    var keyword = $("#keyword").val();
    var vehiclesearch = $("#vehiclesearch").val();
    $.ajax({
        url: vehiclesearch,
        type: 'post',
        data: {keyword: keyword},
        success: function (r) {
//                console.log(r);
            $("#results").html(r);
        }
    });
}