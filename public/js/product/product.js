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
            $(".selectpicker").selectpicker("refresh");
            $(".datepicker").datepicker({refresh:"refresh",todayHighlight: true});
        },
    });
});
$(document).on("click", ".remove_row", function () {
    row_id = $(this).closest("tr").data("row_id");
    $(this).closest("tr").remove();
});
// $(".js-example-basic-multiple-limit").select2({
//     multiple:true,
//     maximumSelectionLength: 10,
//     placeholder: "Select a state"
// });
$(document).on("change","#is_price_permenant",function () {
    $(".price_start_date").prop('disabled', (i, v) => !v);
    $(".price_start_date").val(null);
    $(".price_end_date").prop('disabled', (i, v) => !v);
    $(".price_end_date").val(null);
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