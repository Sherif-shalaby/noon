<div class="card-body py-0">
    <form action="{{ route('products.index') }}" method="get" id="filters_form">
        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {{-- ++++++++++++++++++++ branches filter ++++++++++++++++++++ --}}
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                {!! Form::label('branch_id', __('lang.branch'), [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('branch_id[]', $branches, request()->brach_id, [
                        'class' => 'form-control select2',
                        'multiple',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'branch_id',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ stores filter ++++++++++++++++++++ --}}
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                {!! Form::label('store_id', __('lang.store'), [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('store_id[]', [], request()->store_id, [
                        'class' => 'form-control select2 store',
                        'multiple',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'store_id',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ suppliers filter ++++++++++++++++++++ --}}
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                {!! Form::label('supplier_id', __('lang.supplier'), [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('supplier_id', $suppliers, request()->supplier_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ categories filter ++++++++++++++++++++ --}}
            {{--   <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                <div class="input-wrapper width-full">
                    {!! Form::select(
                        'category_id',
                        $categories,request()->category_id,
                        ['class' => 'form-control select2 category','placeholder'=>__('lang.category'),'id' => 'categoryId']
                    ) !!}
                </div>
            </div> --}}
            {{-- ++++++++++++++++++++ subcategories1 filter ++++++++++++++++++++ --}}
            {{--   <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                <div class="input-wrapper width-full">
                    {!! Form::select(
                        'subcategory_id1', [] ,request()->subcategory_id1,
                        ['class' => 'form-control select2 subcategory','placeholder'=>__('lang.subcategory')." 1",'id' => 'subcategory_id1']
                    ) !!}
                </div>
            </div> --}}
            {{-- ++++++++++++++++++++ subcategories2 filter ++++++++++++++++++++ --}}
            {{--   <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                <div class="input-wrapper width-full">
                    {!! Form::select(
                        'subcategory_id2',[] ,request()->subcategory_id2,
                        ['class' => 'form-control select2 subcategory2','placeholder'=>__('lang.subcategory')." 2",'id' => 'subcategory_id2' ]
                    ) !!}
                </div>
            </div> --}}
            {{-- ++++++++++++++++++++ subcategories3 filter ++++++++++++++++++++ --}}
            {{--   <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                <div class="input-wrapper width-full">
                    {!! Form::select(
                        'subcategory_id3', [] ,request()->subcategory_id3,
                        ['class' => 'form-control select2 subcategory3','placeholder'=>__('lang.subcategory')." 3" ,'id' => 'subcategory_id3']
                    ) !!}
                </div>
            </div> --}}
            {{-- ++++++++++++++++++++ categories filter ++++++++++++++++++++ --}}
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                {!! Form::label('category_id', __('lang.category') . ' 1', [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('category_id', $categories1, request()->category_id, [
                        'class' => 'form-control select2 category',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'categoryId',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ subcategories1 filter ++++++++++++++++++++ --}}
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                {!! Form::label('subcategory_id1', __('lang.category') . ' 2', [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('subcategory_id1', $categories2, request()->subcategory_id1, [
                        'class' => 'form-control select2 subcategory',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'subcategory_id1',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ subcategories2 filter ++++++++++++++++++++ --}}
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                {!! Form::label('subcategory_id2', __('lang.category') . ' 3', [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('subcategory_id2', $categories3, request()->subcategory_id2, [
                        'class' => 'form-control select2 subcategory2',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'subcategory_id2',
                    ]) !!}
                </div>
            </div>
            {{-- ++++++++++++++++++++ subcategories3 filter ++++++++++++++++++++ --}}
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                {!! Form::label('subcategory_id3', __('lang.category') . ' 4', [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('subcategory_id3', $categories4, request()->subcategory_id3, [
                        'class' => 'form-control select2 subcategory3',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'subcategory_id3',
                    ]) !!}
                </div>
            </div>

            {{-- @endfor --}}
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                {!! Form::label('brand_id', __('lang.brand'), [
                    'class' => 'mb-0',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('brand_id', $brands, request()->brand_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                {!! Form::label('created_by', __('lang.created_by')) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select('created_by', $users, request()->created_by, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1"
                        {{ !empty(request()->dont_show_zero_stocks) ? 'checked' : '' }} name="dont_show_zero_stocks">
                    <label class="custom-control-label" for="customSwitch1">@lang('lang.dont_show_zero_stocks')</label>
                </div>
            </div>
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">

                <button type="submit" name="submit" class="btn btn-primary width-100 py-1" title="search">
                    <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>

            </div>
            {{-- +++++++++ delete_all button ++++++++ --}}
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                <a data-href="{{ url('product/multiDeleteRow') }}" id="delete_all"
                    data-check_password="{{ url('user/check-password') }}" style="font-size: 12px;font-weight: 500"
                    class="btn btn-danger text-white delete_all"><i class="fa fa-trash"></i>
                    @lang('lang.delete_all')</a>
            </div>
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
        //                 $('#subcategory_id1').html('<option value="10">{{ __('lang.subcategory') }}</option>');

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
        //             $('#subcategory_id2').html('<option value="10">{{ __('lang.subcategory') . '2' }}</option>');
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
        //             $('#subcategory_id3').html('<option value="10">{{ __('lang.subcategory') . '3' }}</option>');
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
        //                 $('#store_id').html('<option value="">{{ __('lang.store') }}</option>');
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
