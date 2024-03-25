
(function ($) {
    "use strict";
    $(document).ready(function () {
        $('#jstree1').jstree({
            'core': {
                'check_callback': true
            },
            'plugins': ['types', 'dnd'],
            'types': {
                'default': {
                    'icon': 'fa fa-folder'
                },
                'html': {
                    'icon': 'fa fa-file-code-o'
                },
                'svg': {
                    'icon': 'fa fa-file-picture-o'
                },
                'css': {
                    'icon': 'fa fa-file-code-o'
                },
                'img': {
                    'icon': 'fa fa-file-image-o'
                },
                'js': {
                    'icon': 'fa fa-file-text-o'
                }

            }
        });
    });
//-========== close ready function ========-->


})(jQuery);


//    ============= its for selectedformURL =============-->
"use strict";
function loadData(id) {
    var selectedformURL = $("#selectedformURL").val();
    // alert(id);
    $.ajax({
        url: selectedformURL,
        type: "POST",
        data: {id: id},
        dataType: "json",
        success: function (data)
        {
            $('#newform').html(data);
            $('#btnSave').hide();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
//--========== close   ===========-->
//=================== its for new entry form open ============
function newdata(id) {
    var newformURL = $("#newformURL").val();
    $.ajax({
        url: newformURL,
        type: "POST",
        data: {id: id},
        dataType: "json",
        success: function (data) {
            // console.log(data.headcode);
            console.log(data.rowdata);
            var headlabel = data.headlabel;
            $('#txtHeadCode').val(data.headcode);
            document.getElementById("txtHeadName").value = '';
            $('#txtPHead').val(data.rowdata.HeadName);
            $('#txtHeadLevel').val(headlabel);
            $('#btnSave').prop("disabled", false);
            $('#btnSave').show();
            $('#btnUpdate').hide();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
//--============= close ==============-->