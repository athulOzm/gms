
(function ($) {
    "use strict";
    $(document).ready(function () {
//--============ its for customer save btn =========-->
        $("body").on('click', '.customer_btn', function () {
            if ($("#customer_name").val() == '') {
                $("#customer_name").css({'border': '1px solid red'}).focus();
                alert("Customer name must field required");
                return false;
            }
            if ($("#customer_phone").val() == '') {
                $("#customer_phone").css({'border': '1px solid red'}).focus();
                alert("Customer phone must field required");
                return false;
            }
            if ($("#customer_email").val() == '') {
                $("#customer_email").css({'border': '1px solid red'}).focus();
                alert("Customer email must field required");
                return false;
            }
            if ($("#user_name").val() == '') {
                $("#user_name").css({'border': '1px solid red'}).focus();
                alert("Username must field required");
                return false;
            }
            if ($("#password").val() == '') {
                $("#password").css({'border': '1px solid red'}).focus();
                alert("Password must field required");
                return false;
            }
            if ($("#role_id").val() == '') {
                $("#role_id").css({'border': '1px solid red'}).focus();
                alert("Role must field required");
                return false;
            }
        });
        $('.btnPrevious').click(function () {
            $('.nav-tabs > .active').prev('li').find('a').trigger('click');
        });
        $("#customer_name").on('keyup', function () {
            var customername = document.getElementById('customer_name');
            if (customername.value.length === 0)
                return;
            document.getElementById("customer_name").style.borderColor = "green";
        });
        $("#customer_phone").on('keyup', function () {
            var customerphone = document.getElementById('customer_phone');
            if (customerphone.value.length === 0)
                return;
            document.getElementById("customer_phone").style.borderColor = "green";
        });
        $("#customer_email").on('keyup', function () {
            var inpemail = document.getElementById('customer_email');
            if (inpemail.value.length === 0)
                return;
            document.getElementById("customer_email").style.borderColor = "green";
            var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
            if (!(inpemail.value).match(reEmail)) {
//alert("Invalid email address");
                document.getElementById("email_v_message").innerHTML = "Invalid Email address";
                document.getElementById("customer_email").style.borderColor = "red";
                return false;
            }
            document.getElementById("email_v_message").innerHTML = "";
            return true;
        });
    });
//--========== close ready function ========-->
//--================== its for custom mail text editor ============-->
    CKEDITOR.replace('editor1');
//--============== close text editor ==============-->


})(jQuery);
//--//    ============= its for discount_trade_markup =============-->
"use strict";
function discount_trade_markup(t) {
    if (t == 'trade markup' || t == 'retail markup') {
        $(".text_box").html("<input type='number' name='markup_discount' class='form-control markup_discount' id='markup_discount' min='1'>");
    }
    if (t == 'none') {
        $(".text_box").html('');
    }
}
//--========== close discount_trade_markup remove ===========-->

//--//    =========== its for when customer email type then go to username auto ===========-->
"use strict";
function customer_email_to_username(t) {
    var customer_email = t;
    $("#user_name").val(customer_email);
//--//        console.log(customer_email);-->
}
//-/===============-->
"use strict";
function valid_one() {
    var customerName = document.getElementById('customer_name');
    var phoneInput = document.getElementById('customer_phone');
    var emailInput = document.getElementById('customer_email');
    var name = $('#customer_name').val();
    var phone = $('#customer_phone').val();
    var email = $('#customer_email').val();
    if (name == "") {
        document.getElementById("customer_name").style.borderColor = "red";
    } else {
        $("#customer_name").on('keyup', function () {
            document.getElementById("customer_name").style.borderColor = "green";
        });
    }
    if (phone == "") {
        document.getElementById("customer_phone").style.borderColor = "red";
    } else {
        $("#customer_phone").on('keyup', function () {
            document.getElementById("customer_phone").style.borderColor = "green";
        });
    }
    if (email == "") {
        document.getElementById("customer_email").style.borderColor = "red";
        return false;
    } else {
        $("#customer_email").on('keyup', function () {
            document.getElementById("customer_email").style.borderColor = "green";
        });
    }
    var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
    if (email !== "" && email.match(reEmail) && phone !== "" && name !== "") {
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
    }
}
//--================-->
"use strict";
function valid_two() {
    $('.nav-tabs > .active').next('li').find('a').trigger('click');
}
//--=======================-->
"use strict";
function valid_three() {
    $('.nav-tabs > .active').next('li').find('a').trigger('click');
}
//--====================-->
"use strict";
function valid_four() {
    $('.nav-tabs > .active').next('li').find('a').trigger('click');
}
//--===========================-->
"use strict";
function valid_five() {
    var username = document.getElementById('user_name');
    var password = document.getElementById('password');
    var user = $('#user_name').val();
    var password = $('#password').val();
    if (username == "") {
        document.getElementById("user_name").style.borderColor = "red";
        return false;
    } else {
        $("#user_name").on('keyup', function () {
            document.getElementById("user_name").style.borderColor = "green";
        });
    }
    if (password == "") {
        document.getElementById("password").style.borderColor = "red";
        return false;
    } else {
        $("#password").on('keyup', function () {
            document.getElementById("password").style.borderColor = "green";
        });
    }

    if (username !== "" && password !== "") {
        document.getElementById("insert_customer").submit();
    }

}
//--=========== close =============-->
//--============= its for Auto complete ===============-->
function customer_autocomplete(sl) {
    var customerAutocomplete = $("#customerAutocomplete").val();
    var customer_id = $('#customer_id').val();
//--// Auto complete-->
    var options = {
        minLength: 0,
        source: function (request, response) {
            var customer_name = $('#customer_name').val();
            $.ajax({
                url: customerAutocomplete,
                method: 'post',
                dataType: "json",
                data: {
                    term: request.term,
                    customer_id: customer_name,
                },
                success: function (data) {
//--// alert(data);-->
                    response(data);
                }
            });
        },
        focus: function (event, ui) {
            $(this).val(ui.item.label);
            return false;
        },
        select: function (event, ui) {
            $(this).parent().parent().find("#autocomplete_customer_id").val(ui.item.value);
            var customer_id = ui.item.value;
            $(this).unbind("change");
            return false;
        }
    }

    $('body').on('keydown.autocomplete', '#customer_name', function () {
        $(this).autocomplete(options);
    });
}
//--========= close  ==============-->
//--//    =========== its for customer_status ==============-->
function customer_status(customer_id, status) {
    var customerStuatusURL = $("#customerStuatusURL").val();
    $.ajax({
        url: customerStuatusURL,
        type: "POST",
        data: {customer_id: customer_id, status: status},
        success: function (r) {
//--//                    output.empty().html('Successfully Updated').addClass('alert-success').removeClass('alert-danger').removeClass('hide');-->
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    });
}
//--============== close customer_status ===============-->

//--//    =========== its for all_activeInactive ============-->
function all_activeInactive(status) {
    var activeInactiveURL = $("#activeInactiveURL").val();
    $.ajax({
        url: activeInactiveURL,
        type: "POST",
        data: {status: status},
        success: function (r) {
//--//                alert(r);--> 
            if (r == '') {
                $("#active_inactiveResults").html("<p class='text-danger text-center'>Record not found!</p>");
            } else {
                $("#active_inactiveResults").html(r);
            }
        }
    });
}
//--============= close ==============-->