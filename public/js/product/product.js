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
$(document).on('change','.width,.height,.length',function(){
    let width=parseFloat($('.width').val());
    let height=parseFloat($('.height').val());
    let length=parseFloat($('.length').val());
    let size=width*height*length;
    $('.size').val(size);
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
$(document).on("change",".is_price_permenant",function () {
    $(this).closest("tr").find(".price_start_date").prop('disabled', (i, v) => !v);
    $(this).closest("tr").find(".price_start_date").val(null);
    $(this).closest("tr").find(".price_end_date").prop('disabled', (i, v) => !v);
    $(this).closest("tr").find(".price_end_date").val(null);
});
$(document).on("change",".category",function () {
    $.ajax({
        type: "get",
        url: "/category/get-subcategories/"+$(this).val(),
        dataType: "html",
        success: function (response) {
            console.log(response)
            $(".subcategory").empty().append(response).change();
        }
    });
});
$(document).ready(function() {
    $('.js-example-basic-multiple').select2(
        {
            placeholder: LANG.please_select,
            tags: true
        }
    );
});
$(document).on("click", ".add_unit_row", function () {
    let row_id = parseInt($("#raw_unit_index").val())+ 1;
    $("#raw_unit_index").val(row_id );
    $.ajax({
        method: "get",
        url: "/product/get-raw-unit",
        data: { row_id: row_id },
        success: function (result) {
            $(".product_unit_raws").append(result);
        },
    });
});
$(document).on("click", ".remove_row", function () {
$(this).closest(".unit-row").remove();
});