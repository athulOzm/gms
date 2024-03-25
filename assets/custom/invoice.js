
(function ($) {
    "use strict";
    $(document).ready(function () {

    });
//-========== close ready function ========-->


})(jQuery);


//    ========== its for assign_checklist ============
"use strict";
function is_recurring(invoice_id, job_id) {
//                                           alert(invoice_id);
    $("#invoice_id").val(invoice_id);
    $("#job_id").val(job_id);
    $("#modal_info").html();
    $('#modal_show_info').modal('show');

}
//--========== close   ===========-->
//=================== its for customer autocomplete ==============
"use strict";
function customer_autocomplete(sl) {
    var customer_id = $('#customer_id').val();
    var customerAutocompleteURL = $('#customerAutocompleteURL').val();
    // Auto complete
    var options = {
        minLength: 0,
        source: function (request, response) {
            var customer_name = $('#customer_name').val();
            $.ajax({
                url: customerAutocompleteURL,
                method: 'post',
                dataType: "json",
                data: {
                    term: request.term,
                    customer_id: customer_name,
                },
                success: function (data) {
                    // alert(data);
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

//                                        var doc = new jsPDF();
//                                        var specialElementHandlers = {
//                                            '#pdf': function (element, renderer) {
//                                                return true;
//                                            }
//                                        };
//
//                                        $('#generatepdf').click(function () {
//                                            doc.fromHTML($('#dataTableExample2').html(), 15, 15, {
//                                                'width': 170,
//                                                'elementHandlers': specialElementHandlers
//                                            });
//                                            doc.save('sale.pdf');
//                                        });

//--============= close ==============-->