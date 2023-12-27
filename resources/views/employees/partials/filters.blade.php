<div class="card-body" style="margin-bottom: 25px">
    <form method="get" id="filter_form">
        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {{-- ++++++++++++++++++ "main_category" filter ++++++++++++++++++ --}}
            <div
                class="col-6 col-md-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="input-wrapper">
                    {!! Form::select('category_id', $categories, null, [
                        'class' => 'form-control select2 category',
                        'placeholder' => __('lang.category'),
                        'id' => 'categoryId',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "sub1_category" filter ++++++++++++++++++ --}}
            <div
                class="col-6 col-md-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="input-wrapper">
                    {!! Form::select('subcategory_id1', $subcategories1, null, [
                        'class' => 'form-control select2 subcategory1',
                        'placeholder' => __('lang.category') . ' 1',
                        'id' => 'subcategory_id1',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "sub2_category" filter ++++++++++++++++++ --}}
            <div
                class="col-6 col-md-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="input-wrapper">
                    {!! Form::select('subcategory_id2', $subcategories2, null, [
                        'class' => 'form-control select2 subcategory2',
                        'placeholder' => __('lang.category') . ' 2',
                        'id' => 'subcategory_id2',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "sub3_category" filter ++++++++++++++++++ --}}
            <div
                class="col-6 col-md-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="input-wrapper">
                    {!! Form::select('subcategory_id3', $subcategories3, null, [
                        'class' => 'form-control select2 subcategory3',
                        'placeholder' => __('lang.category') . ' 3',
                        'id' => 'subcategory_id3',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "brand" filter ++++++++++++++++++ --}}
            <div
                class="col-6 col-md-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="input-wrapper">
                    {!! Form::select('brand_id', $brands, null, [
                        'class' => 'form-control select2 brand',
                        'placeholder' => __('lang.brand'),
                        'id' => 'brand_id',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++ "filter" and "clear filters" button ++++++++++++++++++ --}}
            <div
                class="col-6 col-md-2 p-1 mb-2 d-flex align-items-center animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="form-group">
                    {{-- ======= "filter" button ======= --}}
                    <button type="button" id="filter_btn" class="btn btn-primary" title="search">
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
        // ======================================== Employee Products Table ========================================
        // +++++++++++++++ updateSubcategories() +++++++++++++++
        // Function to update subcategories based on the selected category ID
        function updateSubcategories() {
            console.log($('body').find('.category option:selected').val());
            $.ajax({
                method: "get",
                url: "/employees/create/",
                // get "all inputFields of form that have name and value"
                // data: $('#filter_form').serialize(),
                data: {
                    category_id: $('body').find('.category option:selected').val(),
                    subcategory_id1: $('body').find('.subcategory1 option:selected').val(),
                    subcategory_id2: $('body').find('.subcategory2 option:selected').val(),
                    subcategory_id3: $('body').find('.subcategory3 option:selected').val(),
                    brand_id: $('body').find('.brand option:selected').val(),
                },
                success: function(response) {
                    console.log("The Response Data : ");
                    console.log(response)
                    // Clear existing table content
                    $('#datatable-buttons tbody').empty();
                    // +++++++++++++++++++++++++ table content according to filters +++++++++++++++++++++++++++
                    // Assuming response.products is the array of products received from the server response
                    $.each(response, function(index, product) {
                        console.log(product);
                        var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><input type="checkbox" name="ids[]" class="checkbox_ids" value="' +
                            product.id + '" data-product_id="' + product.id + '" /></td>' +
                            '<td>' + product.name + '</td>' +
                            '<td>' + product.sku + '</td>' +
                            '<td>' + (product.category ? product.category.name : '') +
                            '</td>' +
                            '<td>' +
                            (product.subCategory1 ? product.subCategory1.name + '<br>' :
                                '') +
                            (product.subCategory2 ? product.subCategory2.name + '<br>' :
                                '') +
                            (product.subCategory3 ? product.subCategory3.name : '') +
                            '</td>' +
                            '<td>' + (product.brand ? product.brand.name : '') + '</td>' +
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
