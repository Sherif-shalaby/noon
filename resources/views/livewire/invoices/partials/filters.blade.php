<div class="card-body">
    <form action="{{route('pos.index')}}" method="get" id="filters_form">
        <div class="row">
            {{-- ++++++++++++++ start_date filter ++++++++++++++ --}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('start_date', __('lang.start_date'), []) !!}
                    {!! Form::date('start_date', request()->start_date, ['class' => 'form-control sale_filter']) !!}
                </div>
            </div>
            {{-- ++++++++++++++ start_time filter ++++++++++++++ --}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('start_time', __('lang.start_time'), []) !!}
                    {!! Form::time('start_time', request()->start_time, [
                        'class' => 'form-control sale_filter time_picker',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++ end_date filter ++++++++++++++ --}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('end_date', __('lang.end_date'), []) !!}
                    {!! Form::date('end_date', request()->end_date, ['class' => 'form-control']) !!}
                </div>
            </div>
            {{-- ++++++++++++++ end_time filter ++++++++++++++ --}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('end_time', __('lang.end_time'), []) !!}
                    {!! Form::time('end_time', request()->end_time, [
                        'class' => 'form-control sale_filter time_picker',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++ customers filter ++++++++++++++ --}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('customer_id', __('lang.customer'), []) !!}
                    {!! Form::select('customer_id', $customers, request()->customer_id, [
                        'class' => 'form-control select2 sale_filter',
                        'placeholder' => __('lang.all'),
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++ customer_types filter ++++++++++++++ --}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('customer_type_id', __('lang.customer_type'), []) !!}
                    {!! Form::select('customer_type_id', $customer_types, request()->customer_type_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.all'),
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++ customer_phone filter +++++++++++++ --}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('phone_number', __('lang.phone_number'), []) !!}
                    {!! Form::text(
                        'phone_number', request()->phone_number,
                        ['class' => 'form-control', 'placeholder' => __('lang.phone_number')]
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++ payment_status filter ++++++++++++++ --}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('payment_status', __('lang.payment_status'), []) !!}
                    {!! Form::select('payment_status', $payment_status_array, request()->payment_status, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.all'),
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++ sale_status filter ++++++++++++++ --}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('sale_status', __('lang.sale_status'), []) !!}
                    {!! Form::select('sale_status', $sale_status, request()->sale_status, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.all'),
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++ deliveryman filter ++++++++++++++ --}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('deliveryman_id', __('lang.deliveryman'), []) !!}
                    {!! Form::select('deliveryman_id', $delivery_men, null, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.deliveryman'),
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ products filter ++++++++++++++++++++ --}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('product_id', __('lang.product'), []) !!}
                    {!! Form::select('product_id', $products, request()->product_id, [
                        'class' => 'form-control select2 sale_filter',
                        'placeholder' => __('lang.all'),
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ categories filter ++++++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('category_id' ,__('lang.category').' 1') !!}
                    {!! Form::select('category_id', $categories1, request()->category_id, [
                        'class' => 'form-control select2 category',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'categoryId',

                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ subcategories1 filter ++++++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('subcategory_id1' ,__('lang.category').' 2') !!}
                    {!! Form::select('subcategory_id1', $categories2, request()->subcategory_id1, [
                        'class' => 'form-control select2 subcategory',
                        'placeholder' =>  __('lang.please_select'),
                        'id' => 'subcategory_id1'
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ subcategories2 filter ++++++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('subcategory_id2' ,__('lang.category').' 3') !!}
                    {!! Form::select('subcategory_id2', $categories3, request()->subcategory_id2, [
                        'class' => 'form-control select2 subcategory2',
                        'placeholder' =>  __('lang.please_select'),
                        'id' => 'subcategory_id2'
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ subcategories3 filter ++++++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('subcategory_id3' ,__('lang.category').' 4') !!}
                    {!! Form::select('subcategory_id3', $categories4, request()->subcategory_id3, [
                        'class' => 'form-control select2 subcategory3',
                        'placeholder' => __('lang.please_select') ,
                        'id' => 'subcategory_id3'
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ branches filter ++++++++++++++++++++ --}}
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('brand_id' ,__('lang.brand')) !!}
                    {!! Form::select(
                        'brand_id',$brands,request()->brand_id,
                        ['class' => 'form-control select2','placeholder'=>__('lang.please_select')]
                    ) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ store_pos filter ++++++++++++++++++++ --}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('pos_id', __('lang.pos'), []) !!}
                    {!! Form::select('pos_id', $store_pos, request()->pos_id, [
                        'class' => 'form-control select2 sale_filter',
                        'placeholder' => __('lang.all'),
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ submit filter ++++++++++++++++++++ --}}
            <div class="col-2 mt-4">
                {{-- <div class="form-group"> --}}
                    <button type="submit" name="submit" class="btn btn-primary" title="search">
                        <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
                {{-- </div> --}}
            </div>
            <div class="col-2 mt-4">
                <a href="{{route('pos.index')}}" class="btn btn-danger">@lang('lang.clear_filters')</a>
            </div>
            {{-- +++++++++ delete_all button ++++++++ --}}
            {{-- <div class="col-2">
                <a data-href="{{url('product/multiDeleteRow')}}" id="delete_all"
                data-check_password="{{url('user/check-password')}}"
                class="btn btn-danger text-white delete_all"><i class="fa fa-trash"></i>
                    @lang('lang.delete_all')</a>
            </div> --}}
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        // +++++++++++++++++++++++++++++++++ subcategory1 filter +++++++++++++++++++++++++++++++++
        // $('#categoryId').change(function(event) {
        //     var idSubcategory1 = this.value;
        //     // alert(idSubcategory1);
        //     $('#subcategory_id1').html('');
        //         $.ajax({
        //             url: "/api/products/fetch_product_sub_categories1",
        //             type: 'POST',
        //             dataType: 'json',
        //             data: {subcategories1_id: idSubcategory1,_token:"{{ csrf_token() }}"},
        //             success:function(response)
        //             {
        //                 $('#subcategory_id1').html('<option value="10">{{ __("lang.subcategory") }}</option>');

        //                 $.each(response.subcategory_id1,function(index, val)
        //                 {
        //                     // console.log(val);
        //                     $('#subcategory_id1').append('<option value="'+val.id+'">'+val.name+'</option>')
        //                 });
        //             }
        //     })
        // });
        // // +++++++++++++++++++++++++++++++++ subcategory2 filter +++++++++++++++++++++++++++++++++
        // $('#subcategory_id1').change(function(event) {
        //         var idSubcategory2 = this.value;
        //         // alert(idSubcategory2);
        //         $('#subcategory_id2').html('');
        //         $.ajax({
        //         url: "/api/products/fetch_product_sub_categories2",
        //         type: 'POST',
        //         dataType: 'json',
        //         data: {subcategories2_id: idSubcategory2,_token:"{{ csrf_token() }}"},
        //         success:function(response)
        //         {
        //             $('#subcategory_id2').html('<option value="10">{{ __("lang.subcategory").'2' }}</option>');
        //             $.each(response.subcategory_id2,function(index, val)
        //             {
        //                 console.log(val);
        //                 $('#subcategory_id2').append('<option value="'+val.id+'">'+val.name+'</option>')
        //             });
        //         }
        //     })
        // });
        // // +++++++++++++++++++++++++++++++++ subcategory3 filter +++++++++++++++++++++++++++++++++
        // $('#subcategory_id2').change(function(event) {
        //         var idSubcategory3 = this.value;
        //         // alert(idSubcategory3);
        //         $('#subcategory_id3').html('');
        //         $.ajax({
        //         url: "/api/products/fetch_product_sub_categories3",
        //         type: 'POST',
        //         dataType: 'json',
        //         data: {subcategories3_id: idSubcategory3,_token:"{{ csrf_token() }}"},
        //         success:function(response)
        //         {
        //             $('#subcategory_id3').html('<option value="10">{{ __("lang.subcategory").'3' }}</option>');
        //             $.each(response.subcategory_id3,function(index, val)
        //             {
        //                 // console.log(val);
        //                 $('#subcategory_id3').append('<option value="'+val.id+'">'+val.name+'</option>')
        //             });
        //         }
        //     })
        // });
        // // +++++++++++++++++++++++++++++++++ branches and stores filter +++++++++++++++++++++++++++++++++
        // $('#branch_id').change(function(event) {
        //     var idBranch = this.value;
        //     // alert(idSubcategory1);
        //     $('#store_id').html('');
        //         $.ajax({
        //             url: "/api/fetch_branch_stores",
        //             type: 'POST',
        //             dataType: 'json',
        //             data: {branch_id: idBranch,_token:"{{ csrf_token() }}"},
        //             success:function(response)
        //             {
        //                 console.log(response);
        //                 $('#store_id').html('<option value="">{{ __("lang.store") }}</option>');
        //                 // $.each(response.branch_id,function(index, val)
        //                 $.each(response.store_id,function(index, val)
        //                 {
        //                     console.log("id = "+val.id ,"value = "+val.name);
        //                     $('#store_id').append('<option value="'+val.id+'">'+val.name+'</option>')
        //                 });
        //             },
        //             error: function (error)
        //             {
        //                 console.error("Error fetching filtered stores:", error);
        //             }

        //         })
        // });
    });


</script>
