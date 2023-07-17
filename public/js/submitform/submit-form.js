//brand form
$("#create-brand-btn").click(function (e){
    e.preventDefault();
    setTimeout(()=>{
        $("#brand-form").submit();
        $("#quick_add_brand_form").submit();
    },500)
});
$(document).on("submit", "form#quick_add_brand_form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $("#createBrandModal").modal("hide");
                var brand_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/brands/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#brand_id").empty().append(data_html);
                        $("#brand_id").val(brand_id).change();
                    },
                });
            } else {
                swal("Error", result.msg, "error");
            }
        },
    });
});
//brand form
//unit form
$("#create-unit-btn").click(function (e){
    e.preventDefault();
    setTimeout(()=>{
        $("#unit-form").submit();
        $("#quick_add_unit_form").submit();
    },500)
});
$(document).on("submit", "form#quick_add_unit_form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $("#create").modal("hide");
                var unit_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/units/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#unit_id").empty().append(data_html);
                        $("#unit_id").val(unit_id).change();
                    },
                });
            } else {
                swal("Error", result.msg, "error");
            }
        },
    });
});
//unit form

//store form
$("#create-store-btn").click(function (e){
    e.preventDefault();
    setTimeout(()=>{
        $("#add_store").submit();
        $("#quick_add_store_form").submit();
    },500)
});
$(document).on("submit", "form#quick_add_store_form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                swal("Success", result.msg, "success");
                $(".add-store").modal("hide");
                var store_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/stores/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#store_id").empty().append(data_html);
                        $("#store_id").val(store_id).change();
                    },
                });
            } else {
                swal("Error", result.msg, "error");
            }
        },
    });
});
//store form