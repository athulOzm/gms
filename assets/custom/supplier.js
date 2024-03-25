
(function ($) {
    "use strict";
    $(document).ready(function () {
        $("body").on('click', '.supplier_btn', function () {
            if ($("#company_name").val() == '') {
                $("#company_name").css({'border': '1px solid red'}).focus();
                alert("Company name must field required");
                return false;
            }
            if ($("#company_phone").val() == '') {
                $("#company_phone").css({'border': '1px solid red'}).focus();
                alert("Compnay phone must field required");
                return false;
            }
            if ($("#company_email").val() == '') {
                $("#company_email").css({'border': '1px solid red'}).focus();
                alert("Company email must field required");
                return false;
            }
        });
        $('.btnNext').click(function () {
            $('.nav-tabs > .active').next('li').find('a').trigger('click');
        });

        $('.btnPrevious').click(function () {
            $('.nav-tabs > .active').prev('li').find('a').trigger('click');
        });

//================== some validation ===========
// $("#company_name").on('keyup', function () {
//        var company_name = document.getElementById('company_name');
//        if (company_name.value.length === 0)
//            return;
//        document.getElementById("company_name").style.borderColor = "green";
//    });
//
//    $("#company_phone").on('keyup', function () {
//        var company_phone = document.getElementById('company_phone');
//        if (company_phone.value.length === 0)
//            return;
//        document.getElementById("company_phone").style.borderColor = "green";
//    });
//    $("#company_email").on('keyup', function () {
//        var company_email = document.getElementById('company_email');
//        if (company_email.value.length === 0)
//            return;
//        document.getElementById("company_email").style.borderColor = "green";
//        var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
//
//        if (!(company_email.value).match(reEmail)) {
//            //alert("Invalid email address");
//            document.getElementById("email_v_message").innerHTML = "Invalid Email address";
//            document.getElementById("company_email").style.borderColor = "red";
//            return false;
//        }
//        document.getElementById("email_v_message").innerHTML = "";
//        return true;
    });
//-========== close ready function ========-->


})(jQuery);


//    ============== its for next button  validation ===============
//"use strict";
//    function valid_one() {
//        var company_name = document.getElementById('company_name');
//        var company_phone = document.getElementById('company_phone');
//        var company_email = document.getElementById('company_email');
//        var name = $('#company_name').val();
//        var phone = $('#company_phone').val();
//        var email = $('#company_email').val();
//        if (name == "") {
//            document.getElementById("company_name").style.borderColor = "red";
//        } else {
//            $("#company_name").on('keyup', function () {
//                document.getElementById("company_name").style.borderColor = "green";
//            });
//
//        }
//        if (phone == "") {
//            document.getElementById("company_phone").style.borderColor = "red";
//        } else {
//            $("#company_phone").on('keyup', function () {
//                document.getElementById("company_phone").style.borderColor = "green";
//            });
//
//        }
//        if (email == "") {
//            document.getElementById("company_email").style.borderColor = "red";
//        } else {
//            $("#company_email").on('keyup', function () {
//                document.getElementById("company_email").style.borderColor = "green";
//            });
//        }
//
//        var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
//        if (email !== "" && email.match(reEmail) && phone !== "" && name !== "") {
//            $('.nav-tabs > .active').next('li').find('a').trigger('click');
//        }
//    }
//--========== close   ===========-->
//--========== its for supplier delete   ===========-->
$(".deleteSupplier").click(function () {
    var supplier_id = $(this).attr('name');
    var supplierDeleteURL = $("#supplierDeleteURL").val();
    var csrf_test_name = $("[name=csrf_test_name]").val();
    var x = confirm("Are You Sure,Want to Delete ?");
    if (x == true) {
        $.ajax
                ({
                    type: "POST",
                    url: supplierDeleteURL,
                    data: {supplier_id: supplier_id, csrf_test_name: csrf_test_name},
                    cache: false,
                    success: function (datas)
                    {
                        location.reload();
                    }
                });
    }
});
//--============= close ==============-->