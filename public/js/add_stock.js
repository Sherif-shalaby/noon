
function get_label_product_row(product_id, variation_id,is_batch=false) {
    //Get item addition method
    var add_via_ajax = true;
    var store_id = $("#store_id").val();
    var is_added = false;
    var qty;
    //Search for variation id in each row of pos table
    $("#product_table tbody")
        .find("tr")
        .each(function () {
            var row_v_id = $(this).find(".variation_id").val();
            if (row_v_id == variation_id && !is_added) {
                add_via_ajax = false;
                is_added = true;
                //Increment product quantity
                //get product qty
                var index=$(this).find(".row_count").val()
                qty_element = $(this).find(".quantity");
                qty = __read_number(qty_element);
                qty+=1;
                // calculate_sub_totals();
                // $("input#search_product").val("");
                // $("input#search_product").focus();
                //remove if exist
                $(this).closest("tr").remove();
                // $('.row_details_'+index).remove();
                // $('.bounce_details_td_'+index).remove();
            }
        });
    // }
    // if (add_via_ajax) {
    var row_count = parseInt($("#row_count").val());
    let currency_id = $('#paying_currency_id').val()
    $("#row_count").val(row_count + 1);
    $.ajax({
        method: "GET",
        url: "/add-stock/add-product-row",
        dataType: "html",
        async: false,
        data: {
            product_id: product_id,
            row_count: row_count,
            variation_id: variation_id,
            store_id: store_id,
            currency_id: currency_id,
            qty:qty,
            is_batch:is_batch,
        },
        success: function (result) {
            $("#product_table tbody").prepend(result);
            $("input#search_product").val("");
            $("input#search_product").focus();
            calculate_sub_totals();
            reset_row_numbering();
        },
    });
    // }
}
