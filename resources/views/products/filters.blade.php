<div class="card-body">
    <form action="{{route('products.index')}}" method="get">
    <div class="row">
        {{-- ++++++++++++++++++++ stores filter ++++++++++++++++++++ --}}
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'store_id',
                    $stores,request()->store_id,
                    ['class' => 'form-control select2','placeholder'=>__('lang.store')]
                ) !!}
            </div>
        </div>
        {{-- ++++++++++++++++++++ suppliers filter ++++++++++++++++++++ --}}
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'supplier_id',
                    $suppliers,request()->supplier_id,
                    ['class' => 'form-control select2','placeholder'=>__('lang.supplier')]
                ) !!}
            </div>
        </div>
        {{-- ++++++++++++++++++++ categories filter ++++++++++++++++++++ --}}
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'category_id',
                    $categories,request()->category_id,
                    ['class' => 'form-control select2 category','placeholder'=>__('lang.category'),'id' => 'categoryId']
                ) !!}
            </div>
        </div>
        {{-- ++++++++++++++++++++ subcategories1 filter ++++++++++++++++++++ --}}
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'subcategory_id1', [] ,request()->subcategory_id1,
                    ['class' => 'form-control select2 subcategory','placeholder'=>__('lang.subcategory')." 1",'id' => 'subcategory_id1']
                ) !!}
            </div>
        </div>
        {{-- ++++++++++++++++++++ subcategories2 filter ++++++++++++++++++++ --}}
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'subcategory_id2',[] ,request()->subcategory_id2,
                    ['class' => 'form-control select2 subcategory2','placeholder'=>__('lang.subcategory')." 2",'id' => 'subcategory_id2' ]
                ) !!}
            </div>
        </div>
        {{-- ++++++++++++++++++++ subcategories3 filter ++++++++++++++++++++ --}}
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'subcategory_id3', [] ,request()->subcategory_id3,
                    ['class' => 'form-control select2 subcategory3','placeholder'=>__('lang.subcategory')." 3" ,'id' => 'subcategory_id3']
                ) !!}
            </div>
        </div>

        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'brand_id',
                    $brands,request()->brand_id,
                    ['class' => 'form-control select2','placeholder'=>__('lang.brand')]
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'created_by',
                    $users,request()->created_by,
                    ['class' => 'form-control select2','placeholder'=>__('lang.created_by')]
                ) !!}
            </div>
        </div>
        <div class="col-3">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" {{!empty(request()->dont_show_zero_stocks) ? 'checked' : ''}} name="dont_show_zero_stocks">
                <label class="custom-control-label" for="customSwitch1">@lang('lang.dont_show_zero_stocks')</label>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                    <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
            </div>
        </div>
    </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        // +++++++++++++++++++++++++++++++++ subcategory1 filter +++++++++++++++++++++++++++++++++
        $('#categoryId').change(function(event) {
            var idSubcategory1 = this.value;
            // alert(idSubcategory1);
            $('#subcategory_id1').html('');
                $.ajax({
                    url: "/api/products/fetch_product_sub_categories1",
                    type: 'POST',
                    dataType: 'json',
                    data: {subcategories1_id: idSubcategory1,_token:"{{ csrf_token() }}"},
                    success:function(response)
                    {
                        $('#subcategory_id1').html('<option value="10">{{ __("lang.subcategory") }}</option>');

                        $.each(response.subcategory_id1,function(index, val)
                        {
                            // console.log(val);
                            $('#subcategory_id1').append('<option value="'+val.id+'">'+val.name+'</option>')
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
                url: "/api/products/fetch_product_sub_categories2",
                type: 'POST',
                dataType: 'json',
                data: {subcategories2_id: idSubcategory2,_token:"{{ csrf_token() }}"},
                success:function(response)
                {
                    $('#subcategory_id2').html('<option value="10">{{ __("lang.subcategory").'2' }}</option>');
                    $.each(response.subcategory_id2,function(index, val)
                    {
                        console.log(val);
                        $('#subcategory_id2').append('<option value="'+val.id+'">'+val.name+'</option>')
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
                url: "/api/products/fetch_product_sub_categories3",
                type: 'POST',
                dataType: 'json',
                data: {subcategories3_id: idSubcategory3,_token:"{{ csrf_token() }}"},
                success:function(response)
                {
                    $('#subcategory_id3').html('<option value="10">{{ __("lang.subcategory").'3' }}</option>');
                    $.each(response.subcategory_id3,function(index, val)
                    {
                        // console.log(val);
                        $('#subcategory_id3').append('<option value="'+val.id+'">'+val.name+'</option>')
                    });
                }
            })
        });

    });


</script>
