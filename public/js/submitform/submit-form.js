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
                Swal.fire("Success", result.msg, "success");
                $("#createBrandModal").modal("hide");
                var brand_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/brands/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#brand_id").empty().append(data_html);
                        $("#brand_id").val(brand_id).trigger();
                    },
                });
            } else {
                Swal.fire("Error", result.msg, "error");
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
                Swal.fire("Success", result.msg, "success");
                $("#create").modal("hide");
                var unit_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/units/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#unit_id").empty().append(data_html);
                        $("#unit_id").val(unit_id).trigger();
                    },
                });
            } else {
                Swal.fire("Error", result.msg, "error");
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
                Swal.fire("Success", result.msg, "success");
                $(".add-store").modal("hide");
                var store_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/stores/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#store_id").empty().append(data_html);
                        $("#store_id").val(store_id).trigger();
                    },
                });
            } else {
                Swal.fire("Error", result.msg, "error");
            }
        },
    });
});
$("#create-supplier-btn").click(function (e){
    e.preventDefault();
    setTimeout(()=>{
        $("#add_supplier").submit();
        $("#quick_add_supplier_form").submit();
    },500)
});
$(document).on("submit", "form#quick_add_supplier_form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                Swal.fire("Success", result.msg, "success");
                $(".add-supplier").modal("hide");
                var supplier_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/suppliers/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#supplier_id").empty().append(data_html);
                        $("#supplier_id").val(supplier_id).trigger();
                    },
                });
            } else {
                Swal.fire("Error", result.msg, "error");
            }
        },
    });
});
//store form

//category form
var select_category=0;
$(".openCategoryModal").click(function (e){
    select_category=$(this).data('select_category');
});
$("#create-category-btn").click(function (e){
    e.preventDefault();
    setTimeout(()=>{
        $("#category-form").submit();
    },500)
});
$(document).on("submit", "#category-form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    alert(select_category);
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                Swal.fire("Success", result.msg, "success");
                $("#createCategoryModal").modal("hide");
                $("#createSubCategoryModal").modal("hide");
                console.log(result);
                var category_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/categories/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        if(select_category=="0"){
                            $("#categoryId").empty().append(data_html);
                            $("#categoryId").val(category_id).trigger();
                        }else if(select_category=="2"){
                            $("#subCategoryId2").empty().append(data_html);
                            $("#subCategoryId2").val(category_id).trigger();
                        }else if(select_category=="3"){
                            $("#subCategoryId3").empty().append(data_html);
                            $("#subCategoryId3").val(category_id).trigger();
                        }
                        else if(select_category=="1"){
                            $("#subCategoryId1").empty().append(data_html);
                            $("#subCategoryId1").val(category_id).trigger();
                        }
                    }
                });
            } else {
                Swal.fire("Error", result.msg, "error");
            }
        },
    });
});

$(document).ready(function () {
$("#create-product-tax-btn").click(function (e) {
    e.preventDefault();
    setTimeout(() => {
        $("#quick_add_product_tax_form").submit();
    }, 500);
});
});

// $("#create-product-tax-btn").click(function (e){
//     e.preventDefault();
//     setTimeout(()=>{
//         $("#add_product_tax").submit();
//     },500)
// });
$(document).on("submit", "#quick_add_product_tax_form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                Swal.fire("Success", result.msg, "success");
                $("#add_product_tax_modal").modal("hide");
                var product_tax_id = result.id;
                console.log(product_tax_id)
                $.ajax({
                    method: "get",
                    url: "/product-tax/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#product_tax").empty().append(data_html);
                        $("#product_tax").val(product_tax_id).trigger();
                    },
                });
            } else {
                Swal.fire("Error", result.msg, "error");
            }
        },
    });
});

//category form
