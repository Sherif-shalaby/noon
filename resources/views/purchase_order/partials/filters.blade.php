<div class="card-body">
    <form method="get" id="filter_form">
        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {{-- ++++++++++++++++++ "main_category" filter ++++++++++++++++++ --}}
            <div class="col-6 col-md-1 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                style="animation-delay: 1.15s">
                {!! Form::label('category_id', __('lang.category') . ' 1', [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('category_id', $categories, request()->category_id, [
                        'class' => 'form-control select2 category',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'categoryId',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "sub1_category" filter ++++++++++++++++++ --}}
            <div class="col-6 col-md-1 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                style="animation-delay: 1.15s">
                {!! Form::label('category_id', __('lang.category') . ' 2', [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('subcategory_id1', $subcategories1, request()->subcategory_id1, [
                        'class' => 'form-control select2 subcategory1',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'subcategory_id1',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "sub2_category" filter ++++++++++++++++++ --}}
            <div class="col-6 col-md-1 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                style="animation-delay: 1.15s">
                {!! Form::label('category_id', __('lang.category') . ' 3', [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('subcategory_id2', $subcategories2, request()->subcategory_id2, [
                        'class' => 'form-control select2 subcategory2',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'subcategory_id2',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "sub3_category" filter ++++++++++++++++++ --}}
            <div class="col-6 col-md-1 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                style="animation-delay: 1.15s">
                {!! Form::label('category_id', __('lang.category') . ' 4', [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('subcategory_id3', $subcategories3, request()->subcategory_id3, [
                        'class' => 'form-control select2 subcategory3',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'subcategory_id3',
                    ]) !!}
                </div>
            </div>
            {{-- +++++++++++++++ products filter +++++++++++++++ --}}
            <div class="col-6 col-md-1 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                style="animation-delay: 1.15s">
                {!! Form::label('category_id', __('lang.select_products'), [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('product_id', $products, request()->product_id, [
                        'class' => 'form-control select2 products',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'product_id',
                    ]) !!}
                </div>
            </div>
            {{-- +++++++++++++++ purchase_type filter +++++++++++++++ --}}
            <div class="col-6 col-md-1 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                style="animation-delay: 1.15s">
                {!! Form::label('category_id', __('lang.purchase_type'), [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('purchase_type', [__('lang.local'), __('lang.export')], request()->purchase_type, [
                        'class' => 'form-control select2 purchase_type',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'purchase_type_id',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "filter" and "clear filters" button ++++++++++++++++++ --}}
            <div class="col-6 col-md-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 justify-content-end @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                style="animation-delay: 1.15s">

                {{-- ======= "filter" button ======= --}}
                <button type="button" id="filter_btn" class="btn btn-primary" title="search">
                    <i class="fa fa-eye"></i> {{ __('lang.filter') }}
                </button>

            </div>

        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        // ======================================== Employee Products Table ========================================
        // +++++++++++++++ updateSubcategories() +++++++++++++++
        // Function to update subcategories based on the selected category ID
        function updateSubcategories() {
            $.ajax({
                method: "get",
                url: "/purchase_order/",
                data: {
                    category_id: $('body').find('.category option:selected').val(),
                    subcategory_id1: $('body').find('.subcategory1 option:selected').val(),
                    subcategory_id2: $('body').find('.subcategory2 option:selected').val(),
                    subcategory_id3: $('body').find('.subcategory3 option:selected').val(),
                    product_id: $('body').find('.products option:selected').val(),
                    purchase_type: $('body').find('.purchase_type option:selected').val(),

                },
                success: function(response) {
                    console.log("The Response Data : ");
                    console.log(response)
                    // Clear existing table content
                    $('#datatable-buttons tbody').empty();
                    // +++++++++++++++++++++++++ table content according to filters +++++++++++++++++++++++++++
                    // Assuming response.products is the array of products received from the server response
                    $.each(response, function(index, purchase_order) {
                        console.log(purchase_order);
                        var row = '<tr>' +
                            '<td>' + purchase_order.po_no + '</td>' +
                            '<td>' + purchase_order.transaction_date + '</td>' +
                            '<td>' + purchase_order.created_by + '</td>' +
                            '<td>' + (purchase_order.supplier ? purchase_order.supplier
                                .name : '') + '</td>' +
                            '<td>' + (purchase_order.final_total) + '</td>' +
                            '<td>' + purchase_order.status + '</td>' +
                            '<td>' +
                            '<div class="btn-group">' +
                            '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"' +
                            'aria-haspopup="true" aria-expanded="false">' +
                            '@lang('lang.action')' +
                            '<span class="caret"></span>' +
                            '</button>' +
                            '<ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">' +
                            '<li>' +

                            '<li class="divider"></li>' +
                            '<li>' +
                            '<a data-href="#" data-check_password="#" class="btn text-red delete_item" style="color:#000;">' +
                            '<i class="fa fa-trash"></i>' +
                            '@lang('lang.delete')' +
                            '</a>' +
                            '</li>' +
                            '</ul>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';

                        $('#datatable-buttons tbody').append(row);
                    });
                },
                error: function(error) {
                    console.error("Error fetching filtered products:", error);
                }
            });
        }
        // when clicking on "filter button" , call "updateSubcategories()" method
        $('#filter_btn').click(function() {
            updateSubcategories();
        });
        // +++++++++++++++++++++++++++++++++ subcategory1 filter +++++++++++++++++++++++++++++++++
        $('#categoryId').change(function(event) {
            var idSubcategory1 = this.value;
            // alert(idSubcategory1);
            $('#subcategory_id1').html('');
            $.ajax({
                url: "/api/fetch-sub_categories1",
                type: 'POST',
                dataType: 'json',
                data: {
                    subcategories1_id: idSubcategory1,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#subcategory_id1').html(
                        '<option value="10">{{ __('lang.subcategory') }}</option>');

                    $.each(response.subcategory_id1, function(index, val) {
                        // console.log(val);
                        $('#subcategory_id1').append('<option value="' + val.id +
                            '">' + val.name + '</option>')
                    });
                }
            })
        });
        // +++++++++++++++++++++++++++++++++ subcategory2 filter +++++++++++++++++++++++++++++++++
        $('#subcategory_id1').change(function(event) {
            var idSubcategory2 = this.value;
            // alert(idSubcategory2);
            $('#subcategory_id2').html('');
            $.ajax({
                url: "/api/fetch-sub_categories2",
                type: 'POST',
                dataType: 'json',
                data: {
                    subcategories2_id: idSubcategory2,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#subcategory_id2').html(
                        '<option value="10">{{ __('lang.subcategory') . '2' }}</option>'
                    );
                    $.each(response.subcategory_id2, function(index, val) {
                        console.log(val);
                        $('#subcategory_id2').append('<option value="' + val.id +
                            '">' + val.name + '</option>')
                    });
                }
            })
        });
        // +++++++++++++++++++++++++++++++++ subcategory3 filter +++++++++++++++++++++++++++++++++
        $('#subcategory_id2').change(function(event) {
            var idSubcategory3 = this.value;
            // alert(idSubcategory3);
            $('#subcategory_id3').html('');
            $.ajax({
                url: "/api/fetch-sub_categories3",
                type: 'POST',
                dataType: 'json',
                data: {
                    subcategories3_id: idSubcategory3,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#subcategory_id3').html(
                        '<option value="10">{{ __('lang.subcategory') . '3' }}</option>'
                    );
                    $.each(response.subcategory_id3, function(index, val) {
                        // console.log(val);
                        $('#subcategory_id3').append('<option value="' + val.id +
                            '">' + val.name + '</option>')
                    });
                }
            })
        });

    });
</script>
