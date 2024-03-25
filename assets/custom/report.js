
(function ($) {
    "use strict";
    $(document).ready(function () {

    });
//-========== close ready function ========-->


})(jQuery);


//    ============= its for discount_trade_markup =============-->
"use strict";
function calculator() {
    var mul1 = $('.text_1').val();
    var text_1_bal = mul1 * 1000;
    $('.text_1_bal').val(text_1_bal);

    var mul2 = $('.text_2').val();
    var text_2_bal = mul2 * 500;
    $('.text_2_bal').val(text_2_bal);

    var mul3 = $('.text_3').val();
    var text_3_bal = mul3 * 100;
    $('.text_3_bal').val(text_3_bal);

    var mul4 = $('.text_4').val();
    var text_4_bal = mul4 * 50;
    $('.text_4_bal').val(text_4_bal);

    var mul5 = $('.text_5').val();
    var text_5_bal = mul5 * 20;
    $('.text_5_bal').val(text_5_bal);

    var mul6 = $('.text_6').val();
    var text_6_bal = mul6 * 10;
    $('.text_6_bal').val(text_6_bal);

    var mul7 = $('.text_7').val();
    var text_7_bal = mul7 * 5;
    $('.text_7_bal').val(text_7_bal);

    var mul8 = $('.text_8').val();
    var text_8_bal = mul8 * 2;
    $('.text_8_bal').val(text_8_bal);

    var mul9 = $('.text_9').val();
    var text_9_bal = mul9 * 1;
    $('.text_9_bal').val(text_9_bal);


    var total_money = (text_1_bal + text_2_bal + text_3_bal + text_4_bal + text_5_bal + text_6_bal + text_7_bal + text_8_bal + text_9_bal);

    $('.total_money').val(total_money);
}
//--========== close   ===========-->
"use strict";
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
"use strict";
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    // add a zero in front of numbers<10
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
    t = setTimeout(function () {
        startTime()
    }, 500);
}
startTime();

//--============= close ==============-->