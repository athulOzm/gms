
(function ($) {
    "use strict";
    $(document).ready(function () {

    });
//-========== close ready function ========-->


})(jQuery);


//    ====== its for timepicker information ===========
"use strict";
$(function () {
    $('#standard_timing').timepicker({
        'format': "HH:mm", // HH:mm:ss its for 24 hours format
//                    format: 'LT'  /// its for 12 hours format
    });
});
//--========== close   ===========-->
//--========== its for printDiv    ===========-->
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    // document.body.style.marginTop="-45px";
    window.print();
    location.reload();
    document.body.innerHTML = originalContents;
}
//--============= close ==============-->