@php
    if(request()->branch_id){
        $stores  = \App\Models\Store::where('branch_id', request()->branch_id)->pluck('name','id');
    }
@endphp
<div class="card-body">
    <form action="{{route('reports.products')}}" method="get">
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('branch_id', __('lang.branch'))  !!}
                    {!! Form::select(
                        'branch_id',
                        $branches,request()->branch_id,
                        ['class' => 'form-control select2','placeholder'=>__('lang.please_select'), 'id' => 'branch_id']
                    ) !!}
                </div>
            </div>
            @php
                if(!empty(request()->branch_id)){
                    $stores = \App\Models\Store::where('branch_id',request()->branch_id)->pluck('name', 'id');
                }
            @endphp
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('store_id', __('lang.store'))  !!}
                    {!! Form::select(
                        'store_id',
                        $stores, request()->store_id,
                        ['class' => 'form-control select2','placeholder'=>__('lang.please_select'), 'id' => 'store_id']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('supplier_id', __('lang.supplier'))  !!}
                    {!! Form::select(
                        'supplier_id',
                        $suppliers,request()->supplier_id,
                        ['class' => 'form-control select2','placeholder'=>__('lang.please_select')]
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('category_id', __('lang.category'))  !!}
                    {!! Form::select(
                        'category_id',
                        $categories,request()->category_id,
                        ['class' => 'form-control select2 category','placeholder'=>__('lang.please_select'),'id' => 'categoryId']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('subcategory_id1', __('lang.subcategory')." 1")  !!}
                    {!! Form::select(
                        'subcategory_id1',
                        $subcategories,request()->subcategory_id1,
                        ['class' => 'form-control select2 subcategory','placeholder'=>__('lang.please_select'),'id' => 'subcategory_id1']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('subcategory_id2', __('lang.subcategory')." 2")  !!}
                    {!! Form::select(
                        'subcategory_id2',
                        $subcategories,request()->subcategory_id2,
                        ['class' => 'form-control select2 subcategory2','placeholder'=>__('lang.please_select'),'id' => 'subCategoryId2' ]
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('subcategory_id3', __('lang.subcategory')." 3")  !!}
                    {!! Form::select(
                        'subcategory_id3',
                        $subcategories,request()->subcategory_id3,
                        ['class' => 'form-control select2 subcategory3','placeholder'=>__('lang.please_select') ,'id' => 'subCategoryId3']
                    ) !!}
                </div>
            </div>

            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('brand_id', __('lang.brand'))  !!}
                    {!! Form::select(
                        'brand_id',
                        $brands,request()->brand_id,
                        ['class' => 'form-control select2','placeholder'=>__('lang.please_select')]
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('created_by', __('lang.created_by'))  !!}
                    {!! Form::select(
                        'created_by',
                        $users,request()->created_by,
                        ['class' => 'form-control select2','placeholder'=>__('lang.please_select')]
                    ) !!}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-check">
                    {!! Form::radio('selling_filter', 'best', request()->selling_filter === 'best', ['class' => 'form-check-input']) !!}
                    {!! Form::label('best_seller', __('lang.best_selling'), ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-check">
                    {!! Form::radio('selling_filter', 'least', request()->selling_filter === 'least', ['class' => 'form-check-input']) !!}
                    {!! Form::label('worst_seller', __('lang.least_selling'), ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-check">
                    {!! Form::radio('stock_filter', 'most', request()->stock_filter === 'most', ['class' => 'form-check-input']) !!}
                    {!! Form::label('most_stock', __('lang.most_stock'), ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-check">
                    {!! Form::radio('stock_filter', 'lowest', request()->stock_filter === 'lowest', ['class' => 'form-check-input']) !!}
                    {!! Form::label('lowest_stock', __('lang.lowest_stock'), ['class' => 'form-check-label']) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" {{!empty(request()->nearest_expiry_filter) ? 'checked' : ''}} name="nearest_expiry_filter">
                    <label class="custom-control-label" for="customSwitch1">@lang('lang.nearest_expiry_filter')</label>
                </div>
            </div>
            <div class="col-2">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="expired" {{!empty(request()->expired) ? 'checked' : ''}} name="expired">
                    <label class="custom-control-label" for="expired">@lang('lang.expired')</label>
                </div>
            </div>
            <div class="col-2">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="dont_show_zero_stocks" {{!empty(request()->dont_show_zero_stocks) ? 'checked' : ''}} name="dont_show_zero_stocks">
                    <label class="custom-control-label" for="dont_show_zero_stocks">@lang('lang.dont_show_zero_stocks')</label>
                </div>
            </div>
            <div class="col-2">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="zero_stocks" {{!empty(request()->zero_stocks) ? 'checked' : ''}} name="zero_stocks">
                    <label class="custom-control-label" for="zero_stocks">@lang('lang.zero_stocks')</label>
                </div>
            </div>
            <div class="col-2">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="balance_return_request" {{!empty(request()->balance_return_request) ? 'checked' : ''}} name="balance_return_request">
                    <label class="custom-control-label" for="balance_return_request">@lang('lang.balance_return_request')</label>
                </div>
            </div>
            <div class="col-2">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="sell_price_less_purchase_price" {{!empty(request()->sell_price_less_purchase_price) ? 'checked' : ''}} name="sell_price_less_purchase_price">
                    <label class="custom-control-label" for="sell_price_less_purchase_price">@lang('lang.sell_price_less_purchase_price')</label>
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

</script>
