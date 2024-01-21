@extends('layouts.app')
@section('title', __('lang.initial_balance'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.initial_balance')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.initial_balance')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    {{--                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createBrandModal"> --}}
                    {{--                        @lang('lang.add_stock') --}}
                    {{--                    </button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-1">
                <div class="card-header d-flex align-items-center">

                    @if (!empty($is_raw_material))
                        <h6>@lang('lang.add_stock_for_raw_material')</h6>
                    @else
                        <h6>@lang('lang.add_initial_balance')</h6>
                    @endif
                </div>
                {!! Form::open([
                    'route' => 'initial-balance.store',
                    'method' => 'post',
                    'files' => true,
                    'id' => 'add_stock_form',
                ]) !!}
                <div class="card-body">
                    {{-- <div class="col-md-12"> --}}
                    <div class="row">
                        <div class="col-md-3">
                            {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                            {!! Form::select(
                                'store_id',
                                $stores,
                                !empty($recent_stock) && !empty($recent_stock->store_id) ? $recent_stock->store_id : session('user.store_id'),
                                [
                                    'class' => 'select2 form-control',
                                    'data-live-search' => 'true',
                                    'required',
                                    'placeholder' => __('lang.please_select'),
                                ],
                            ) !!}
                            @error('store_id')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('supplier_id ', __('lang.supplier') . ':*', []) !!}
                            {!! Form::select(
                                'supplier_id ',
                                $suppliers,
                                !empty($recent_stock) && !empty($recent_stock->supplier_id)
                                    ? $recent_stock->supplier_id
                                    : session('user.supplier_id '),
                                [
                                    'class' => 'select2 form-control',
                                    'data-live-search' => 'true',
                                    'required',
                                    'placeholder' => __('lang.please_select'),
                                ],
                            ) !!}
                            @error('supplier_id ')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('category', __('lang.category'), ['class' => 'h5']) !!}
                            {!! Form::select('category_id', $categories, null, [
                                'class' => 'form-control select2 category',
                                'placeholder' => __('lang.please_select'),
                                'id' => 'categoryId',
                            ]) !!}
                            @error('category_id')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('subcategory', __('lang.subcategory'), ['class' => 'h5 ']) !!}
                            {!! Form::select(
                                'subcategory_id[]',
                                $categories,
                                [],
                                [
                                    'class' => 'js-example-basic-multiple subcategory',
                                    'multiple' => 'multiple',
                                    'placeholder' => __('lang.please_select'),
                                    'id' => 'subCategoryId',
                                ],
                            ) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('name', __('lang.product_name'), ['class' => 'h5']) !!}
                            {!! Form::text('name', null, [
                                'class' => 'form-control required',
                            ]) !!}
                            @error('name')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('sku', __('lang.product_code'), ['class' => 'h5']) !!}
                            {!! Form::text('sku', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('exchange_rate', __('lang.exchange_rate') . ':', []) !!}
                            <input type="text" class="form-control" id="exchange_rate" name="exchange_rate"
                                value="{{ number_format($exchange_rate, num_of_digital_numbers()) }}" disabled>
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('status', __('lang.status') . ':*', []) !!}
                            {!! Form::select(
                                'status',
                                ['received' => __('lang.received'), 'partially_received' => __('lang.partially_received')],
                                !empty($recent_stock) && !empty($recent_stock->status) ? $recent_stock->status : 'Please Select',
                                [
                                    'class' => 'select form-control select2',
                                    'required',
                                    'placeholder' => __('lang.please_select'),
                                    'wire:model' => 'status',
                                ],
                            ) !!}
                            @error('status')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- sizes --}}
                    <div class="row">
                        <div class="col-md-12 pt-5 ">
                            <h5 class="text-primary">{{ __('lang.product_dimensions') }}</h5>
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('height', __('lang.height'), ['class' => 'h5 pt-3']) !!}
                            {!! Form::text('height', 0, [
                                'class' => 'form-control height',
                            ]) !!}
                            <br>
                            @error('height')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>



                        <div class="col-md-3">
                            {!! Form::label('length', __('lang.length'), ['class' => 'h5 pt-3']) !!}
                            {!! Form::text('length', 0, [
                                'class' => 'form-control length',
                            ]) !!}
                            <br>
                            @error('length')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            {!! Form::label('width', __('lang.width'), ['class' => 'h5 pt-3']) !!}
                            {!! Form::text('width', 0, [
                                'class' => 'form-control width',
                            ]) !!}
                            <br>
                            @error('width')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('size', __('lang.size'), ['class' => 'h5 pt-3']) !!}
                            {!! Form::text('size', 0, [
                                'class' => 'form-control size',
                            ]) !!}
                            <br>
                            @error('size')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>


                    <br>
                    <div class="row">
                        {{-- <div class="col-md-3">
                        {!! Form::label('quantity', __('lang.quantity')."*", ['class' => 'h5']) !!}
                        <input type="number" class="form-control quantity"  name="quantity" required >
                    </div> --}}
                        <div class="col-md-3">
                            {!! Form::label('weight', __('lang.weight'), ['class' => 'h5']) !!}
                            {!! Form::text('weight', 0, [
                                'class' => 'form-control',
                            ]) !!}
                            <br>
                            @error('weight')
                                <label class="text-danger error-msg">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            {{-- {{$divide_costs}} --}}
                            {!! Form::label('divide_costs', __('lang.divide_costs') . ':', []) !!}
                            {!! Form::select(
                                'divide_costs',
                                ['size' => __('lang.size'), 'weight' => __('lang.weight'), 'price' => __('lang.price')],
                                'Please Select',
                                [
                                    'class' => 'select2 form-control',
                                    'data-live-search' => 'true',
                                    'required',
                                    'placeholder' => __('lang.please_select'),
                                    'wire:model' => 'divide_costs',
                                ],
                            ) !!}
                            @error('divide_costs')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3 pt-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="change_current_stock"
                                    name="change_current_stock">
                                <label class="custom-control-label" for="change_current_stock">@lang('lang.change_current_stock')</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    {{-- prices --}}
                    <div class="row">
                        <div class="col-md-12 pt-5 ">
                            <h5 class="text-primary">{{ __('lang.price') }}</h5>
                        </div>
                        <div class="col-md-12 ">
                            <table class="table table-bordered" id="consumption_table_unit">
                                <thead>
                                    <tr>
                                        <th style="width: 7%;">@lang('lang.unit')</th>
                                        <th style="width: 10%;">@lang('lang.number')</th>
                                        <th style="width: 10%;">@lang('lang.base_unit')</th>
                                        <th style="width: 10%;">@lang('lang.quantity')</th>
                                        <th style="width: 10%;">@lang('lang.total_quantity')</th>
                                        <th style="width: 10%;">@lang('lang.purchase_price') $</th>
                                        <th style="width: 11%;">@lang('lang.sell_price') $</th>
                                        <th style="width: 10%;">@lang('lang.purchase_price')</th>
                                        <th style="width: 11%;">@lang('lang.sell_price')</th>
                                        <th style="width: 11%;">@lang('lang.cost') $</th>
                                        <th style="width: 11%;">@lang('lang.cost')</th>
                                        <th style="width: 3%;">
                                            <button class="btn btn-xs btn-primary add_unit_row" type="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('initial-balance.partial.raw_unit', ['row_id' => 0])
                                </tbody>
                            </table>
                            <input type="hidden" name="raw_unit_index" id="raw_unit_index" value="1">
                        </div>
                        {{-- <div class="col-md-3">
                        {!! Form::label('selling_price', __('lang.selling_price')."$", ['class' => 'h5 pt-3']) !!}
                        {!! Form::text('dollar_selling_price', 0, [
                            'class' => 'form-control dollar_selling_price',
                        ]) !!}
                        <br>
                        @error('dollar_selling_price')
                            <label class="text-danger error-msg">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('purchase_price', __('lang.purchase_price')."$", ['class' => 'h5 pt-3']) !!}
                        {!! Form::text('dollar_purchase_price', 0, [
                            'class' => 'form-control dollar_purchase_price',
                        ]) !!}
                        <br>
                        @error('dollar_purchase_price')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('selling_price', __('lang.selling_price'), ['class' => 'h5 pt-3']) !!}
                        {!! Form::text('selling_price', 0, [
                            'class' => 'form-control selling_price',
                        ]) !!}
                        <br>
                        @error('selling_price')
                            <label class="text-danger error-msg">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('purchase_price', __('lang.purchase_price'), ['class' => 'h5 pt-3']) !!}
                        {!! Form::text('purchase_price', 0, [
                            'class' => 'form-control purchase_price',
                        ]) !!}
                        <br>
                        @error('purchase_price')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    </div>
                    <br>
                </div>
                <div class="col-sm-12">
                    <button type="submit" name="submit" id="submit-save" style="margin: 10px" value="save"
                        class="btn btn-primary pull-right btn-flat submit">@lang('lang.save')</button>

                </div>
                {!! Form::close() !!}

            </div>

        </div>
    </div>
@endsection
@push('javascripts')
    <script>
        $(document).on("change", ".category", function() {
            $.ajax({
                type: "get",
                url: "/category/get-subcategories/" + $(this).val(),
                dataType: "html",
                success: function(response) {
                    console.log(response)
                    $(".subcategory").empty().append(response).change();
                }
            });
        });
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: LANG.please_select,
                tags: true
            });
        });
        //     $(document).on('change', '.width,.height,.length', function() {
        //         let width = parseFloat($('.width').val());
        //         let height = parseFloat($('.height').val());
        //         let length = parseFloat($('.length').val());
        //         let size = width * height * length;
        //         $('.size').val(size);
        //     });
        //     $(document).on("click", ".add_unit_row", function () {
        //         let row_id = parseInt($("#raw_unit_index").val());
        //         $("#raw_unit_index").val(row_id + 1);
        //         $.ajax({
        //             method: "get",
        //             url: "/initial-balance/get-raw-unit",
        //             data: { row_id: row_id },
        //             success: function (result) {
        //                 $("#consumption_table_unit > tbody").prepend(result);
        //             },
        //         });
        //     });
        // $(document).on("click", ".remove_row", function () {
        //     $(this).closest("tr").remove();
        // });

        // $(document).on('change','.unit_id',function(){
        //     var row = $(this).closest("tr");
        //     $.ajax({
        //         type: "get",
        //         url: "/units/get-unit-data/"+$(this).val(),
        //         success: function (response) {
        //             row.find('.base_unit_multiplier').val(response.base_unit_multiplier);
        //             row.find('.base_unit_id').val(response.base_unit_id).trigger('change');
        //         }
        //     });
        // });
        // $(document).on('change','.quantity',function(){
        //     var row = $(this).closest("tr");
        //     row.find('.total_quantity').val(parseInt($(this).val())*parseFloat(row.find('.base_unit_multiplier').val()));
        // });
        // $(document).on('change','.dollar_purchase_price',function(){
        //     var row = $(this).closest("tr");
        //     row.find('.purchase_price').val({{ number_format($exchange_rate, 2) }}* parseFloat($(this).val()) * parseInt(row.find('.total_quantity').val()));
        // });
        // $(document).on('change','.dollar_selling_price',function(){
        //     var row = $(this).closest("tr");
        //     row.find('.selling_price').val({{ number_format($exchange_rate, 2) }}* parseFloat($(this).val())* parseInt(row.find('.total_quantity').val()));
        // });
        // $(document).on('change','.dollar_cost',function(){
        //     var row = $(this).closest("tr");
        //     row.find('.cost').val({{ number_format($exchange_rate, 2) }}* parseFloat($(this).val())* parseInt(row.find('.total_quantity').val()));
        // });
    </script>
@endpush
