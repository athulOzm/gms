//Add Input Field Of Row
function addInputField(t) {
    var row = $("#addinvoice tbody tr").length;
    var count = row + 1;
    var limits = 500;
     var taxnumber = $("#txfieldnum").val();
    var tbfild ='';
    for(var i=0;i<taxnumber;i++){
        var taxincrefield = '<input id="total_tax'+i+'_'+count+'" class="total_tax'+i+'_'+count+'" type="hidden"><input id="all_tax'+i+'_'+count+'" class="total_tax'+i+'" type="hidden" name="tax[]">';
         tbfild +=taxincrefield;
    }
    if (count == limits)
        alert("You have reached the limit of adding " + count + " inputs");
    else {
        var a = "product_name" + count,
                tabindex = count * 5,
                e = document.createElement("tr");
        //e.setAttribute("id", count);
        tab1 = tabindex + 1;
        tab2 = tabindex + 2;
        tab3 = tabindex + 3;
        tab4 = tabindex + 4;
        tab5 = tabindex + 5;
        tab6 = tabindex + 6;
        tab7 = tabindex + 7;
        tab8 = tabindex + 8;
        tab9 = tabindex + 9;
        e.innerHTML = "<td><input type='text' name='product_name' onkeypress='invoice_productList(" + count + ");' class='form-control productSelection common_product' placeholder='Product Name' id='" + a + "' required tabindex='" + tab1 + "'><input type='hidden' class='common_product autocomplete_hidden_value  product_id_" + count + "' name='product_id[]' id='SchoolHiddenId'/></td><td><input type='text' name='desc[]'' class='form-control text-right ' /> <td><input type='text' name='available_quantity[]' id='' class='form-control text-right common_avail_qnt available_quantity_" + count + "' value='0' readonly='readonly' /></td><td><input class='form-control text-right common_name unit_" + count + " valid' value='None' readonly='' aria-invalid='false' type='text'></td><td> <input type='text' name='product_quantity[]' required='required' onkeyup='quantity_calculate(" + count + ");' onchange='quantity_calculate(" + count + ");' id='total_qntt_" + count + "' class='common_qnt total_qntt_" + count + " form-control text-right'  placeholder='0.00' min='0' tabindex='" + tab2 + "'/></td><td><input type='text' name='product_rate[]' onkeyup='quantity_calculate(" + count + ");' onchange='quantity_calculate(" + count + ");' id='price_item_" + count + "' class='common_rate price_item" + count + " form-control text-right' required placeholder='0.00' min='0' tabindex='" + tab3 + "'/></td><td><input type='text' name='discount[]' onkeyup='quantity_calculate(" + count + ");' onchange='quantity_calculate(" + count + ");' id='discount_" + count + "' class='form-control text-right common_discount' placeholder='0.00' min='0' tabindex='" + tab4 + "' /><input type='hidden' value='' name='discount_type' id='discount_type_" + count + "'></td><td class='text-right'><input class='common_total_price total_price form-control text-right' type='text' name='total_price[]' id='total_price_" + count + "' value='0.00' readonly='readonly'/></td><td>"+tbfild+"<input type='hidden' id='all_discount_" + count + "' class='total_discount' name='discount_amount[]'/><button tabindex='" + tab5 + "' style='text-align: right;' class='btn btn-danger' type='button' value='Delete' onclick='deleteRow(this)'><i class='fa fa-close'></i></button></td>",
                document.getElementById(t).appendChild(e),
                document.getElementById(a).focus(),
                document.getElementById("add_invoice_item").setAttribute("tabindex", tab6);
        document.getElementById("paidAmount").setAttribute("tabindex", tab7);
        document.getElementById("full_paid_tab").setAttribute("tabindex", tab8);
        document.getElementById("add_invoice").setAttribute("tabindex", tab9);
        count++
    }
}
//Quantity calculat
function quantity_calculate(item) {
//    alert(item);
    var quantity = $("#total_qntt_" + item).val();
    var available_quantity = $("#available_quantity_" + item).val();
    var price_item = $("#price_item_" + item).val();
    var invoice_discount = $("#invoice_discount").val();
    var taxnumber = $("#txfieldnum").val();
    var discount = $("#discount_" + item).val();
    var total_tax = $("#total_tax_" + item).val();
    var total_discount = $("#total_discount_" + item).val();
    var dis_type = $("#discount_type_" + item).val();
//    alert(available_quantity);
    if (parseInt(quantity) > parseInt(available_quantity)) {
        var message = "You can Sale maximum " + available_quantity + " Items";
        alert(message);
        $("#total_qntt_" + item).val('');
    }

//    alert(invoice_discount);
    if (quantity > 0 || discount > 0) {
        //alert(invoice_discount+"test");
        if (dis_type == 1) {
         var price = quantity * price_item;

            // Discount cal per product
//            var dis = +(price * discount / 100) + +invoice_discount;
            var dis = +(price * discount / 100)+  + invoice_discount;
            var invdis = $("#total_discount_ammount").val()

            $("#all_discount_" + item).val(dis);
            $("#total_price_" + item).val(price);
            //Total price calculate per product
            var temp = price - dis;
            var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
           var tax = (temp-ttletax) * $("#total_tax"+i+"_" + item).val();
           ttletax += Number(tax);

            $("#all_tax"+i+"_" + item).val(tax);
    }

          
        } else if (dis_type == 2) {
            var price = quantity * price_item;

            // Discount cal per product
            var dis = (discount * quantity) + invoice_discount;

            $("#all_discount_" + item).val(dis);

            //Total price calculate per product
            var temp = price - dis;
            $("#total_price_" + item).val(price);

           var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
           var tax = (temp-ttletax) * $("#total_tax"+i+"_" + item).val();
           ttletax += Number(tax);

            $("#all_tax"+i+"_" + item).val(tax);
        }
        } else if (dis_type == 3) {
            var total_price = quantity * price_item;
            var dis = discount + invoice_discount;
            // Discount cal per product
            $("#all_discount_" + item).val(discount);

            //Total price calculate per product
            var price = total_price - dis;
            $("#total_price_" + item).val(total_price);

            //Tax cal per product
                   var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
           var tax = (price-ttletax) * $("#total_tax"+i+"_" + item).val();
           ttletax += Number(tax);
            $("#all_tax"+i+"_" + item).val(tax);
    }
        }
    } else {
        var n = quantity * price_item;
        var c = quantity * price_item * total_tax;
        $("#total_price_" + item).val(n),
                $("#all_tax_" + item).val(c)
    }
    calculateSum();
    invoice_paidamount();
}
//Calculate Sum
function calculateSum() {
     var taxnumber = $("#txfieldnum").val();
    var t = 0,
            a = 0,
            e = 0,
            o = 0,
            p = 0,
            f = 0,
            s_cost =  $("#shipping_cost").val();

    //Total Tax
   for(var i=0;i<taxnumber;i++){
      
var j = 0;
    $(".total_tax"+i).each(function () {
        isNaN(this.value) || 0 == this.value.length || (j += parseFloat(this.value))
    });
            $("#total_tax_ammount"+i).val(j.toFixed(2, 2));
             
    }
            //Total Discount
            $(".total_discount").each(function () {
        isNaN(this.value) || 0 == this.value.length || (p += parseFloat(this.value))
    }),
            $("#total_discount_ammount").val(p.toFixed(2, 2)),


        $(".totalTax").each(function () {
        isNaN(this.value) || 0 == this.value.length || (f += parseFloat(this.value))
    }),
            $("#total_tax_amount").val(f.toFixed(2, 2)),
         
            //Total Price
            $(".total_price").each(function () {
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }),
            o = a.toFixed(2, 2),
            e = t.toFixed(2, 2),
            tx = f.toFixed(2, 2),
         ds = p.toFixed(2, 2);

   var test = +tx + +s_cost + +e + -ds;
    $("#grandTotal").val(test.toFixed(2, 2));

    var gt = $("#grandTotal").val();
    var invdis = $("#invoice_discount").val();
    var total_discount_ammount = $("#total_discount_ammount").val();
    var ttl_discount = +invdis + +total_discount_ammount;
    $("#total_discount_ammount").val(ttl_discount);
    var grnt_totals = gt - invdis;
    $("#grandTotal").val(grnt_totals.toFixed(2, 2));
    invoice_paidamount();
}

//Invoice Paid Amount
function invoice_paidamount() {
    var  prb = parseFloat($("#previous").val(), 10);
    if(prb > 0){
        pr =  prb;
    }else{
        pr = 0;
    }
    var t = $("#grandTotal").val(),
            a = $("#paidAmount").val(),
            e = t - a,
            f = e + pr,
            nt = parseFloat(t, 10) + pr;
          
    $("#dueAmmount").val(f.toFixed(2, 2))
     $("#n_total").val(nt.toFixed(2, 2));
}
// function shippingCost(){
   
//         var t = $("#grandTotal").val();
// alert(t);
//     //         a = $("#shipping_cost").val(),
//     //         e = +t+ + a;
          
//     // $("#grandTotal").val(e);
// }
//Stock Limit
function stockLimit(t) {
    var a = $("#total_qntt_" + t).val(),
            e = $(".product_id_" + t).val(),
            o = $(".baseUrl").val();

    $.ajax({
        type: "POST",
        url: o + "Cinvoice/product_stock_check",
        data: {
            product_id: e
        },
        cache: !1,
        success: function (e) {
            alert(e);
            if (a > Number(e)) {
                var o = "You can Sale maximum " + e + " Items";
                alert(o), $("#qty_item_" + t).val("0"), $("#total_qntt_" + t).val("0"), $("#total_price_" + t).val("0")
            }
        }
    })
}

function stockLimitAjax(t) {
    var a = $("#total_qntt_" + t).val(),
            e = $(".product_id_" + t).val(),
            o = $(".baseUrl").val();
            
    $.ajax({
        type: "POST",
        url: o + "Cinvoice/product_stock_check",
        data: {
            product_id: e
        },
        cache: !1,
        success: function (e) {
            alert(e);
            if (a > Number(e)) {
                var o = "You can Sale maximum " + e + " Items";
                alert(o), $("#qty_item_" + t).val("0"), $("#total_qntt_" + t).val("0"), $("#total_price_" + t).val("0.00"), calculateSum()
            }
        }
    })
}

//Invoice full paid
function full_paid() {
    var grandTotal = $("#n_total").val();
    $("#paidAmount").val(grandTotal);
    invoice_paidamount();
    calculateSum();
}

//Delete a row of table
function deleteRow(t) {
    var a = $("#addinvoice > tbody > tr").length;
//    alert(a);
    if (1 == a)
        alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e),
                calculateSum();
        invoice_paidamount();
//        alert(a);
        var current = 1;
        $("#addinvoice > tbody > tr td input.productSelection").each(function () {
            current++;
            $(this).attr('id', 'product_name' + current);
        });
        var common_qnt = 1;
        $("#addinvoice > tbody > tr td input.common_qnt").each(function () {
            common_qnt++;
            $(this).attr('id', 'total_qntt_' + common_qnt);
            $(this).attr('onkeyup', 'quantity_calculate('+common_qnt+');');
            $(this).attr('onchange', 'quantity_calculate('+common_qnt+');');
        });
        var common_rate = 1;
        $("#addinvoice > tbody > tr td input.common_rate").each(function () {
            common_rate++;
            $(this).attr('id', 'price_item_' + common_rate);
            $(this).attr('onkeyup', 'quantity_calculate('+common_qnt+');');
            $(this).attr('onchange', 'quantity_calculate('+common_qnt+');');
        });
        var common_discount = 1;
        $("#addinvoice > tbody > tr td input.common_discount").each(function () {
            common_discount++;
            $(this).attr('id', 'discount_' + common_discount);
            $(this).attr('onkeyup', 'quantity_calculate('+common_qnt+');');
            $(this).attr('onchange', 'quantity_calculate('+common_qnt+');');
        });
        var common_total_price = 1;
        $("#addinvoice > tbody > tr td input.common_total_price").each(function () {
            common_total_price++;
            $(this).attr('id', 'total_price_' + common_total_price);
        });




    }
}
var count = 2,
        limits = 500;
//$('body').on('keyup', '#invoice_discount', function () {
//    var invoiceDis = $("#invoice_discount").val();
//    var ttlDis = $("#total_discount_ammount").val();
//    var xx = invoiceDis * ttlDis;
//    alert(xx);
//})