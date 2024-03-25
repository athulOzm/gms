
(function ($) {
    "use strict";
    $(document).ready(function () {

    });
//-========== close ready function ========-->


})(jQuery);


//    ============= its for discount_trade_markup =============-->
"use strict";
function quotationonkeyup_search() {
    var keyword = $("#keyword").val();
    var quotationkeyupsearch = $("#quotationkeyupsearch").val();
    $.ajax({
        url: quotationkeyupsearch,
        type: 'post',
        data: {keyword: keyword},
        success: function (r) {
//                console.log(r);
            $("#results").html(r);
        }
    });
}
//--========== close   ===========-->
//--========== c statis function start   ===========-->
"use strict";
function c_statis(id) {
    var id = id;
    var quot_id = $("#quotation_id").val();
    var cStacomment = $("#cStacomment").val();
    $.ajax({
        url: cStacomment,
        type: 'POST',
        data: {id: id, quot_id: quot_id},
        success: function (r) {
//                            console.log(r);
            location.reload();
        }
    });
}
//--============= close ==============-->
//--============= its for messagesent  ==============--
"use strict";
function messagesent() {
    var message = $("#custormchat").val();
    var quot_id = $("#quotation_id").val();
    var quotation_customer_chat = $("#quotation_customer_chat").val();
    $.ajax({
        url: quotation_customer_chat,
        type: 'POST',
        data: {quot_id: quot_id, message: message},
        success: function (r) {
            location.reload();
        }
    });
}
//--============= close ==============-->
//--============= new function ==============-->
"use strict";
$(function () {
    $('.fa-minus').click(function () {
        $(this).closest('.chatbox').toggleClass('chatbox-min');
    });
    $('.fa-close').click(function () {
        $(this).closest('.chatbox').hide();
    });
});
//--============= close ==============-->
//--============= its for printDiv ==============-->
"use strict";
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        // document.body.style.marginTop="-45px";
        window.print();
        document.body.innerHTML = originalContents;
    }
//--============= close ==============-->