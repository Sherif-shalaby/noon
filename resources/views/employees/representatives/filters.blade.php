<div class="card-body">
    <form action="{{ route('representatives.index') }}" method="get">
        <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                <div class="input-wrapper">
                    {!! Form::select('store_id', $stores, request()->store_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.store'),
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                <div class="input-wrapper">
                    {!! Form::select('representative_id', $users, request()->representative_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.representative'),
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                <div class="input-wrapper">
                    {!! Form::select('customer_id', $customers, request()->customer_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.customer'),
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">

                <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                    <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>

            </div>
            {{-- <div class="col-2">
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

        <div class="col-3">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" {{!empty(request()->dont_show_zero_stocks) ? 'checked' : ''}} name="dont_show_zero_stocks">
                <label class="custom-control-label" for="customSwitch1">@lang('lang.dont_show_zero_stocks')</label>
            </div>
        </div>

         --}}
        </div>
    </form>
</div>
