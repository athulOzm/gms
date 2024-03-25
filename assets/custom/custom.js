
(function ($) {
    "use strict";
    var segment1 = $("#segment1").val();
    var segment2 = $("#segment2").val();
    var segment3 = $("#segment3").val();
    $(document).ready(function () {
//--============= its for autocomplete ================-->
        $("form :input").attr("autocomplete", "off");
//--   =========== its for sidebar menu active ===========-->
        if (segment1 == 'Ccustomer') {
            $('.customer').addClass('active show');
            $('#customer').addClass('displayblock ');
        } else if (segment1 == "Cvehicles") {
            $('.vehicles').addClass('active show');
            $('#vehicles').addClass('displayblock ');
        } else if (segment1 == "Ccalender") {
            $('.calenders').addClass('active show');
            $('#calenders').addClass('displayblock ');
        } else if (segment1 == "Cquotation") {
            $('.quotation').addClass('active show');
            $('#quotation').addClass('displayblock ');
        } else if (segment1 == "Cjob") {
            $('.jobs').addClass('active show');
            $('#jobs').addClass('displayblock ');
        } else if (segment1 == 'Cservice') {
            $(".service").addClass('active show');
            $("#service").addClass('displayblock');
        } else if (segment1 == "Cinspection") {
            $('.inspection').addClass('active show');
            $('#inspection').addClass('displayblock ');
        } else if (segment1 == "Cinvoice") {
            $('.invoice').addClass('active show');
            $('#invoice').addClass('displayblock ');
        } else if (segment1 == "Csupplier") {
            $('.supplier').addClass('active show');
            $('#supplier').addClass('displayblock ');
        } else if (segment1 == "Ccategory" || segment1 == 'Cproduct' || segment1 == 'Cunit') {
            $('.inventory').addClass('active show');
            $('#inventory').addClass('displayblock ');
        } else if (segment1 == "Cpurchase") {
            $('.purchase').addClass('active show');
            $('#purchase').addClass('displayblock ');
        } else if (segment1 == "Chrm") {
            $('.HRM').addClass('active show');
            $('#HRM').addClass('displayblock ');
        } else if (segment1 == "Cretrun_m") {
            $('.return').addClass('active show');
            $('#return').addClass('displayblock ');
        } else if (segment1 == "Creport") {
            $('.stock').addClass('active show');
            $('#stock').addClass('displayblock ');
        } else if (segment1 == "Admin_dashboard" || segment2 == 'productivity_report' || segment2 == 'buying_report') {
            $('.report').addClass('active show');
            $('#report').addClass('displayblock ');
        } else if (segment1 == "Csettings") {
            $('.bank').addClass('active show');
            $('#bank').addClass('displayblock ');
        } else if (segment1 == "accounts") {
            $('.accounts').addClass('active show');
            $('#accounts').addClass('displayblock ');
        } else if (segment1 == "data_synchronizer" || segment1 == 'Backup_restore') {
            $('.data_synchronisation').addClass('active show');
            $('#data_synchronisation').addClass('displayblock ');
        } else if (segment1 == "Company_setup" || segment1 == 'Cweb_setting' || segment1 == 'Caccounts' || segment1 == 'Language' || segment1 == 'User' || segment1 == 'Currency') {
            $('.software_settings').addClass('active show');
            $('#software_settings').addClass('displayblock ');
        } else if (segment1 == "Permission") {
            $('.role_permission').addClass('active show');
            $('#role_permission').addClass('displayblock ');
        } else if (segment1 == "Csms") {
            $('.support').addClass('active show');
            $('#role_permission').addClass('displayblock ');
        }
//--========== its for sidebar menu active ============-->

//--========== its for datetime picker ============-->
        if (segment1 == "Ccalender" || segment1 == 'Cjob' || segment2 == 'create_checklist' || segment2 == 'inspection_edit') {
            $('.basic_example_3').datetimepicker({
//-- timeFormat: "hh:mm tt"-->
                dateFormat: "yy-mm-dd",
                timeFormat: "HH:mm",
                showButtonPanel: false,
            });
        }
//--========== close datetime picker ==========-->
//--    ============= its for jquery timepicker ============-->
        /*$('.onlyTimePicker').timepicker({'scrollDefault': 'now'});
         $('#standard_timing').timepicker({'scrollDefault': 'now'});*/
        $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});

        $('.select2').select2();
// select 2 dropdown--> 
        $("select.form-control:not(.dont-select-me)").select2({
            placeholder: "Select option",
            allowClear: true
        });
//--//Insert supplier-->
        $("#insert_supplier").validate();
        $("#validate").validate();
//Update supplier-->
        $("#supplier_update").validate();
//Update customer-->
        $("#customer_update").validate();
//Insert customer-->
        $("#insert_customer").validate();
//Update product-->
        $("#product_update").validate();
//Insert product-->
        $("#insert_product").validate();
//Insert pos invoice
        $("#insert_pos_invoice").validate();
//Insert invoice-->
        $("#insert_invoice").validate();
//Update invoice-->
        $("#invoice_update").validate();
//Insert purchase-->
        $("#insert_purchase").validate();
//Update purchase-->
        $("#purchase_update").validate();
//Add category-->
        $("#insert_category").validate();
//Update category-->
        $("#category_update").validate();
//Stock report-->
        $("#stock_report").validate();
//Stock report-->
        $("#stock_report_supplier_wise").validate();
//Stock report-->
        $("#stock_report_product_wise").validate();
//Create account-->
        $("#create_account_data").validate();
//Update account-->
        $("#update_account_data").validate();
//Inflow entry-->
        $("#inflow_entry").validate();
//Outflow entry-->
        $("#outflow_entry").validate();
//Tax entry-->
        $("#tax_entry").validate();
//Update tax-->
        $("#update_tax").validate();
//Account summary-->
        $("#summary_datewise").validate();
//Comission generate-->
        $("#commission_generate").validate();
//================ its for phrase input field focus =========
        $("#addphrase").focus();


//========== its for forgot password ============
//        var checkoutFrm = $("#passrecoveryform");
//        var outputPreview = $('#outputPreview');
//        checkoutFrm.on('submit', function (e) {
//            e.preventDefault();
//            $.ajax({
//                method: checkoutFrm.attr('method'),
//                url: checkoutFrm.attr('action'),
//                data: checkoutFrm.serialize(),
//                dataType: 'json',
//                success: function (data)
//                {
//                    if (data.status == true) {
//                        outputPreview.removeClass("hide").removeClass("alert-danger").addClass('alert-success').html(data.success);
//                        setTimeout(function () {// wait for 5 secs(2)
//                            location.reload();
//                        }, 5000);
//                    } else {
//                        outputPreview.removeClass("hide").removeClass("alert-danger").addClass('alert-danger').html(data.exception);
//                    }
//                },
//                error: function (xhr)
//                {
//                    alert('some error here!');
//                }
//            });
//        });
//            ============= close forgot password =========
//========== its for login table click ==========
        var info = $('table tbody tr');
        info.click(function () {
            var email = $(this).children().first().text();
            var password = $(this).children().first().next().text();
            var user_role = $(this).attr('data-role');

            $("input[type=email]").val(email);
            $("input[type=password]").val(password);
            $('select option[value=' + user_role + ']').attr("selected", "selected");
        });
//========= close login table click ============
//============== its for role form select deselect check box start=============
        $('body').on('click', '#select_deselect', function () {
            $(".sameChecked").prop('checked', $(this).prop('checked'));
        });
        $('body').on('click', '.can_create_all', function () {
            var create_value = $(this).val();
            $("." + create_value + "_can_create").prop('checked', $(this).prop('checked'));
        });
        $('body').on('click', '.can_read_all', function () {
            var read_value = $(this).val();
            $("." + read_value + "_can_read").prop('checked', $(this).prop('checked'));
        });
        $('body').on('click', '.can_edit_all', function () {
            var edit_value = $(this).val();
            $("." + edit_value + "_can_edit").prop('checked', $(this).prop('checked'));
        });
        $('body').on('click', '.can_delete_all', function () {
            var delete_value = $(this).val();
            $("." + delete_value + "_can_delete").prop('checked', $(this).prop('checked'));
        });
//============== its for role form select deselect check box close=============

    });
//========== close ready function ========-->

})(jQuery);

//=========== its for only number allow=========-->
"use strict";
function onlynumber_allow(vtext, id) {
    var specialChars = "<>@!#$%^&*()_+[]{}?:;|'\"\\/~`-=abcdefghijklmnopqrstuvwxyz"
    var check = function (string) {
        for (i = 0; i < specialChars.length; i++) {
            if (string.indexOf(specialChars[i]) > -1) {
                return true
            }
        }
        return false;
    }
    if (check($('#' + id).val()) == false) {
// Code that needs to execute when none of the above is in the string-->
    } else {
        alert(specialChars + " these special character are not allows");
        $("#" + id).val('').focus();
    }
}
//========== close onlynumber allow =============-->

//=========== its for special character remove =========-->
"use strict";
function special_character_remove(vtext, id) {
    var special_character_remove = $("#specialcharacterremove").val();
    var specialChars = special_character_remove;
    var check = function (string) {
        for (i = 0; i < specialChars.length; i++) {
            if (string.indexOf(specialChars[i]) > -1) {
                return true
            }
        }
        return false;
    }
    if (check($('#' + id).val()) == false) {
// Code that needs to execute when none of the above is in the string-->
    } else {
        alert(specialChars + " these special character are not allows");
        $("#" + id).val('').focus();
    }
}
//========== close character remove ===========-->]
//========== its employee_email_to_username ===========-->]
"use strict";
function employee_email_to_username(t) {
    var customer_email = t;
    $("#user_name").val(customer_email);
}
//========== close employee_email_to_username  ===========-->
//========== its for menu key up search ==========
function menukeyup_search() {
    var menukeyup_search = $("#menukeyup_search").val();
    var keyword = $("#keyword").val();
    $.ajax({
        url: menukeyup_search,
        type: 'post',
        data: {keyword: keyword},
        success: function (r) {
//                console.log(r);
            $("#results_menu").html(r);
        }
    });
}
//    ========== close menu keyup search ============
//=================== its for assign user role check start ==========
function userRole(id) {
    var assignRoleURL = $("#assignRoleURL").val();
    $.ajax({
        url: assignRoleURL,
        type: "POST",
        data: {id: id},
        dataType: "json",
        success: function (data)
        {
            $('#existrole').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $('#existrole').html("<p style='color:red'>Record not found</p>");
        }
    });
}
//=================== its for assign user role check close ==========
//======= its for bank book =========
function cmbCode_onchange() {
    var Sel = $('#cmbCode').val();
    var Text = $('#cmbCode').text();
    var select = $("option:selected", $("#cmbCode")).text()
    $("#txtName").val(select);
    $("#txtCode").val(Sel);
}
//    =========== close bank book ============
//    ============== its general ledger -=============
$('#cmbGLCode').on('change', function () {
    var general_ledURL = $("#general_ledURL").val();
    var Headid = $(this).val();
    $.ajax({
        url: general_ledURL,
        type: 'POST',
        data: {
            Headid: Headid
        },
        success: function (data) {
            $("#ShowmbGLCode").html(data);
        }
    });
});
//    ============== its general ledger close-=============
//============= its for print view ============
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    document.body.style.marginTop = "0px";
    window.print();
    document.body.innerHTML = originalContents;
}
//============= close its for print view ============