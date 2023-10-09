<div class="card-body">
    <form action="{{route('products.index')}}" method="get">
    <div class="row">
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'category_id',
                    $categories,null,
                    ['class' => 'form-control select2','placeholder'=>__('lang.category')]
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'subcategory_id1',
                    $subcategories,null,
                    ['class' => 'form-control select2','placeholder'=>__('lang.subcategory')." 1"]
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'subcategory_id2',
                    $subcategories,null,
                    ['class' => 'form-control select2','placeholder'=>__('lang.subcategory')." 2" ]
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'subcategory_id3',
                    $subcategories,null,
                    ['class' => 'form-control select2','placeholder'=>__('lang.subcategory')." 3" ]
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'store_id',
                    $stores,null,
                    ['class' => 'form-control select2','placeholder'=>__('lang.store')]
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'unit_id',
                    $units,null,
                    ['class' => 'form-control select2','placeholder'=>__('lang.unit')]
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'brand_id',
                    $brands,null,
                    ['class' => 'form-control select2','placeholder'=>__('lang.brand')]
                ) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select(
                    'created_by',
                    $users,null,
                    ['class' => 'form-control select2','placeholder'=>__('lang.created_by')]
                ) !!}
            </div>
        </div>
        <div class="col-3">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="dont_show_zero_stocks">
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
