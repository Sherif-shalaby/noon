<div class="card-body">
    <form  method="get" id="filter_form">
        <div class="row">
            {{-- +++++++++++++++ store filter +++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('store_id', __('lang.store'), []) !!}
                    {!! Form::select('store_id', $stores,null, ['class' => 'form-control select2 stores','placeholder'=>__('lang.please_select'),'id' => 'store_id']
                    ) !!}
                </div>
            </div>
            {{-- +++++++++++++++ supplier filter +++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('supplier_id', __('lang.supplier'), []) !!}
                    {!! Form::select('supplier_id', $suppliers,null, ['class' => 'form-control select2 suppliers','placeholder'=>__('lang.please_select'),'id' => 'supplier_id']
                    ) !!}
                </div>
            </div>
            {{-- +++++++++++++++ products filter +++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('product_id', __('lang.products'), []) !!}
                    {!! Form::select('product_id', $products,null, ['class' => 'form-control select2 products','placeholder'=>__('lang.please_select'),'id' => 'product_id']
                    ) !!}
                </div>
            </div>
            {{-- +++++++++++++++ start_date filter +++++++++++++++ --}}
            <div class="col-2">
                <div class="d-flex align-items-center gap-2 flex-wrap flex-lg-nowrap">
                    <div class=" w-100">
                        {!! Form::label('from', __('site.From'), []) !!}
                        {!! Form::date('from', null, ['class' => 'form-control start_date w-100']) !!}
                    </div>
                </div>
            </div>
            {{-- +++++++++++++++ end_date filter +++++++++++++++ --}}
            <div class="col-2">
                <div class="d-flex align-items-center gap-2 flex-wrap flex-lg-nowrap">
                    <div class="w-100">
                        {!! Form::label('to', __('site.To'), []) !!}
                        {!! Form::date('to', null, ['class' => 'form-control end_date w-100']) !!}
                    </div>
                </div>
            </div>
            {{-- ++++++++++++++++++ "filter" and "clear filters" button ++++++++++++++++++ --}}
            <div class="col-2">
                <div class="d-flex align-items-center gap-2 mt-4">
                        {{-- ======= "filter" button ======= --}}
                        <button type="button" id="filter_btn" class="btn btn-primary mt-2" title="search">
                            <i class="fa fa-eye"></i> {{ __('lang.filter') }}
                        </button>
                        {{-- ======= clear "filters" button ======= --}}
                        {{-- <button class="btn btn-danger mt-0 clear_filters">@lang('lang.clear_filters')</button> --}}
                </div>
            </div>

        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        // +++++++++++++++++++++++++++++++++ clear filters +++++++++++++++++++++++++++++++++
        // $('.clear_filters').on('click', function() {
        //     // Reset the values of the select boxes
        //     $('#categoryId').val('').trigger('change'); // Reset main_category select box
        //     $('#subcategory_id1').val('').trigger('change'); // Reset sub1_category select box
        //     $('#subcategory_id2').val('').trigger('change'); // Reset sub2_category select box
        //     $('#subcategory_id3').val('').trigger('change'); // Reset sub3_category select box
        //     $('#brand_id').val('').trigger('change'); // Reset brand select box
        // });
        // ================================== Employee Products Table ==================================
        // +++++++++++++++ updateSubcategories() +++++++++++++++
        // Function to update subcategories based on the selected category ID
        function updateSubcategories()
        {
            $.ajax({
                method : "get",
                url: "{{ route('required-products.index') }}",
                // get "all inputFields of form that have name and value"
                data : {
                    store_id    : $('body').find('.stores').val(),
                    supplier_id : $('body').find('.suppliers option:selected').val(),
                    product_id  : $('body').find('.products option:selected').val(),
                    start_date  : $('body').find('.start_date').val(),
                    end_date    : $('body').find('.end_date').val(),
                },
                success: function (response) {
                    console.log("The Response Data : ");
                    console.log(response)
                    // Clear existing table content
                    $('#datatable-buttons .tbody').empty();
                    // +++++++++++++++++++++++++ table content according to filters +++++++++++++++++++++++++++
                    // Assuming response.products is the array of products received from the server response
                    $.each(response, function(index, product) {
                        // console.log(product);
                        var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><input type="checkbox" name="products[' + index + '][checkbox]" class="checkbox_ids"  value="1" /></td>' +
                            '<td>' +
                                '<input type="hidden" class="form-control" name="products[' + index + '][employee_id]" value="' + product.employee_id + '">' +
                                (product.employee ? product.employee.employee_name : '') +
                            '</td>' +
                            '<td>' +
                                '<input type="hidden" class="form-control" name="products[' + index + '][order_date]" value="' + product.order_date + '">' +
                                (product.order_date ? product.order_date : '') +
                            '</td>' +
                            '<td>' +
                                '<input type="hidden" class="form-control" name="products[' + index + '][product_id]" value="' + product.product_id + '">' +
                                (product.product? product.product.name : '') +
                            '</td>' +
                            '<td>' +
                                '<input type="hidden" class="form-control" name="products[' + index + '][store_id]" value="' + product.store_id + '">' +
                                (product.stores ? product.stores.name : '') +
                            '</td>' +
                            '<td>' +
                                '<input type="hidden" class="form-control" name="products[' + index + '][status]" value="' + product.status + '">' +
                                (product.status ? product.status : '') +
                            '</td>' +
                            '<td>' +
                                '<input type="hidden" class="form-control" name="products[' + index + '][supplier_id]" value="' + product.supplier_id + '">' +
                                (product.supplier ? product.supplier.name : '') +
                            '</td>' +
                            '<td>' +
                                '<input type="hidden" class="form-control" name="products[' + index + '][branch_id]" value="' + product.branch_id + '">' +
                                (product.branch ? product.branch.name : '') +
                            '</td>' +
                            '<td>' +
                                // dinar_purchase_price
                                '<input type="hidden" class="form-control" name="products[' + index + '][purchase_price]" id="purchase_price" value="' + (product.purchase_price ? product.purchase_price : '0')  + '">' +
                                (product.purchase_price ? product.purchase_price : '0') + '<br/>' +
                                // dollar_purchase_price
                                '<input type="hidden" class="form-control" name="products[' + index + '][dollar_purchase_price]" id="dollar_purchase_price" value="' + (product.dollar_purchase_price ? product.dollar_purchase_price : '0') + '">' +
                                (product.dollar_purchase_price ? product.dollar_purchase_price : '0') + ' $' +
                            '</td>' +
                            '<td>' +
                                '<input type="text" class="form-control" name="products[' + index + '][required_quantity]" value="' + (product.required_quantity ? product.required_quantity : '1') + '">' +
                            '</td>' +
                            '<td>' +
                                '<a href="javascript:void(0)" class="btn btn-xs btn-danger deleteRow">' +
                                    '<i class="fa fa-trash"></i>' +
                                '</a>' +
                            '</td>' +
                        '</tr>';
                        $('#datatable-buttons .tbody').append(row);
                    });

                },
                error: function (error) {
                    console.error("Error fetching filtered products:", error);
                }
            });
        }
        // when clicking on "filter button" , call "updateSubcategories()" method
        $('#filter_btn').click(function(){
            updateSubcategories();
        });

    });
</script>

