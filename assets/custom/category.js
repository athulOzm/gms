
(function ($) {
    "use strict";
    $(document).ready(function () {
//Delete Category 
        $("body").on('click', '.DeleteCategory', function () {
            var category_id = $(this).attr('name');
            var csrf_test_name = $("[name=csrf_test_name]").val();
            var x = confirm("Are You Sure,Want to Delete ?");
            var categoryDeleteURL = $("#categoryDeleteURL").val();
          //  alert(categoryDeleteURL);return false;
            if (x == true) {
                $.ajax
                        ({
                            type: "POST",
                            url: categoryDeleteURL,
                            data: {category_id: category_id, csrf_test_name: csrf_test_name},
                            cache: false,
                            success: function (datas)
                            {
                                alert(datas);
                                location.reload();
                            }
                        });
            }
        });
    });
//-========== close ready function ========-->


})(jQuery);


//    ============= its for discount_trade_markup =============-->
"use strict";
function discount_trade_markup(t) {

}
//--========== close   ===========-->

//--============= close ==============-->