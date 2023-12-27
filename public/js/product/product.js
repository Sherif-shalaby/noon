$(() => {
    let usrCfg = {
        height: "200",
        toolbar: [
            ["style", ["bold", "italic", "underline", "clear"]],
            ["font", ["strikethrough", "superscript", "subscript"]],
            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["height", ["height"]],
            ["table", ["table"]],
            ["insert", ["link", "picture", "video"]],
            ["view", ["fullscreen", "codeview", "help"]],
        ],
        width: "inherit",
    };
    $("#product_details").summernote(usrCfg);
});
$(document).on('change', '.width,.height,.length', function () {
    var key = $(this).data('key');
    let width = parseFloat($('#width' + key).val());
    let height = parseFloat($('#height' + key).val());
    let length = parseFloat($('#length' + key).val());
    let size = width * height * length;
    console.log(size)
    $('#size' + key).val(size);
});
$(document).on("click", ".add_price_row", function () {
    let row_id = parseInt($("#raw_price_index").val());
    $("#raw_price_index").val(row_id + 1);
    $.ajax({
        method: "get",
        url: "/product/get-raw-price",
        data: { row_id: row_id },
        success: function (result) {
            $("#consumption_table_price > tbody").prepend(result);
        },
    });
});
$(document).on("click", ".remove_row", function () {
    row_id = $(this).closest("tr").data("row_id");
    $(this).closest("tr").remove();
});
$(document).on("change", ".is_price_permenant", function () {
    $(this).closest("tr").find(".price_start_date").prop('disabled', (i, v) => !v);
    $(this).closest("tr").find(".price_start_date").val(null);
    $(this).closest("tr").find(".price_end_date").prop('disabled', (i, v) => !v);
    $(this).closest("tr").find(".price_end_date").val(null);
});
// $(document).on("change",".category",function () {
//     var key = $(this).closest('.col-md-3').data('key');
//     console.log(key);
//     $.ajax({
//         type: "get",
//         url: "/category/get-subcategories/"+$(this).val(),
//         dataType: "html",
//         success: function (response) {
//             console.log(response)
//             $("#subcategory_id1" + key).empty().append(response).change();
//             $("#subCategoryId2" + key).empty();
//             $("#subCategoryId3" + key).empty();
//         }
//     });
// });
// $(document).on("change",".subcategory",function () {
//     var key = $(this).data('key');
//     $.ajax({
//         type: "get",
//         url: "/category/get-subcategories/"+$(this).val(),
//         dataType: "html",
//         success: function (response) {
//             console.log(response)
//             $("#subCategoryId2" + key).empty().append(response).change();
//             $("#subCategoryId3" + key).empty();
//         }
//     });
// });
// $(document).on("change",".subcategory2",function () {
//     var key = $(this).data('key');
//     $.ajax({
//         type: "get",
//         url: "/category/get-subcategories/"+$(this).val(),
//         dataType: "html",
//         success: function (response) {
//             console.log(response)
//             $("#subCategoryId3" + key).empty().append(response).change();
//         }
//     });
// });
// >>>>>>> new_test+
$(document).ready(function () {
    $('.js-example-basic-multiple').select2(
        {
            placeholder: LANG.please_select,
            tags: true
        }
    );
});
$(document).on("click", ".add_unit_row", function () {
    let key = $(this).data('key');
    let row_id = parseInt($("#raw_unit_index\\[" + key + "\\]").val()) + 1;
    console.log(row_id, key);
    if (row_id === 1) {
        $("#raw_unit_index\\[" + key + "\\]").val(row_id);
        $.ajax({
            method: "get",
            url: "/product/get-raw-unit",
            data: { row_id: row_id, key: key },
            success: function (result) {
                $(".product_unit_raws\\[" + key + "\\]").prepend(result);
                $('.select2').select2();
            },
        });
    }
});
$(document).on("click", ".add_small_unit", function () {
    let key = $(this).data('key');
    let row_id = parseInt($("#raw_unit_index\\[" + key + "\\]").val()) + 1;
    console.log(row_id, key);
    $("#raw_unit_index\\[" + key + "\\]").val(row_id);
    $.ajax({
        method: "get",
        url: "/product/get-raw-unit",
        data: { row_id: row_id, key: key },
        success: function (result) {
            $(".product_unit_raws\\[" + key + "\\]").append(result);
            $('.select2').select2();
        },
    });
});
// +++++++++++++ delete "unit_row" +++++++++++++
$(document).on("click", ".remove_row", function () {
    let key = $(this).data('key');
    $(this).closest(".unit-row\\[" + key + "\\]").remove();
});
$(document).on("change", ".unit_select", function () {
    let key = $(this).data('key');
    console.log(key)
    var selectBox1 = $('#products\\[' + key + '\\]\\[variation_id\\]');
    selectBox1.empty();
    let selectBoxValues = {};
    $(".unit_select[data-key='" + key + "']").each(function () {
        let name = $(this).attr('name');
        let value = $(this).val();
        selectBoxValues[name] = value;
    });

    var jsonData = JSON.stringify(selectBoxValues);

    // var jsonData = JSON.stringify(getSelectBoxValues());
    $.ajax({
        method: "get",
        url: "/variations/units/get-dropdown",
        data: { selectBoxValues: jsonData },
        traditional: true,
        contactType: "html",
        success: function (data_html) {
            console.log(data_html)
            selectBox1.empty().append(data_html);
            // selectBox1.val(brand_id).trigger();
        },
    });

});

function getSelectBoxValues() {
    var selectedValues = [];
    $('.unit_select').each(function () {
        if ($(this).val() !== '') {
            selectedValues.push($(this).val());
        }
    });
    return selectedValues;
}

$(document).on("click", ".add_product_row", function () {
    let row_id = parseInt($("#raw_product_index").val()) + 1;
    $("#raw_product_index").val(row_id);
    console.log(row_id)
    $.ajax({
        method: "get",
        url: "/product/add_product_raw",
        data: { row_id: row_id },
        success: function (result) {
            $(".product_raws").append(result);
            $('.select2').select2();
        },
    });
});

