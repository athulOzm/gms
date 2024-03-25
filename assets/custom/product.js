
(function ($) {
    "use strict";
    $(document).ready(function () {

    });
//-========== close ready function ========-->


})(jQuery);


//    ============ its for unit delete use jquery start ==============
"use strict";
$('body').on('click', '.DeleteUnit', function () {
    var unit_id = $(this).attr('name');
    var msg = confirm("Are you sure, want to delete it ?");
    var unitDeleteUrl = $("#unitDeleteUrl").val();
    if (msg == true) {
//            alert("Yes");
        $.ajax({
            type: "POST",
            url: unitDeleteUrl,
            data: {unit_id: unit_id},
            cache: false,
            success: function (r) {
                alert(r);
                location.reload();
            }
        });
    }
});
//--========== close   ===========-->

//--============= close ==============-->