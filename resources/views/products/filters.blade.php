<div class="card-body">
    <form action="{{route('products.index')}}" method="get">
    <div class="row">
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'store_id',
                    $stores,request()->store_id,
                    ['class' => 'form-control select2','placeholder'=>__('lang.store')]
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'supplier_id',
                    $suppliers,request()->supplier_id,
                    ['class' => 'form-control select2','placeholder'=>__('lang.supplier')]
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'category_id',
                    $categories,request()->category_id,
                    ['class' => 'form-control select2 category','placeholder'=>__('lang.category'),'id' => 'categoryId']
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'subcategory_id1',
                    $subcategories,request()->subcategory_id1,
                    ['class' => 'form-control select2 subcategory','placeholder'=>__('lang.subcategory')." 1",'id' => 'subcategory_id1']
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'subcategory_id2',
                    $subcategories,request()->subcategory_id2,
                    ['class' => 'form-control select2 subcategory2','placeholder'=>__('lang.subcategory')." 2",'id' => 'subCategoryId2' ]
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'subcategory_id3',
                    $subcategories,request()->subcategory_id3,
                    ['class' => 'form-control select2 subcategory3','placeholder'=>__('lang.subcategory')." 3" ,'id' => 'subCategoryId3']
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
