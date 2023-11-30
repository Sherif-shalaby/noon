@php
    if (request()->branch_id) {
        $stores = \App\Models\Store::where('branch_id', request()->branch_id)->pluck('name', 'id');
    }
@endphp
<div class="card-body">
    <form action="{{ route('reports.products') }}" method="get">
        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                {!! Form::label('branch_id', __('lang.branch'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('branch_id', $branches, request()->branch_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'branch_id',
                    ]) !!}
                </div>
            </div>

            @php
                if (!empty(request()->branch_id)) {
                    $stores = \App\Models\Store::where('branch_id', request()->branch_id)->pluck('name', 'id');
                }
            @endphp
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">

                {!! Form::label('store_id', __('lang.store'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('store_id', $stores, request()->store_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'store_id',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.2s">

                {!! Form::label('supplier_id', __('lang.supplier'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('supplier_id', $suppliers, request()->supplier_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.25s">

                {!! Form::label('category_id', __('lang.category'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('category_id', $categories, request()->category_id, [
                        'class' => 'form-control select2 category',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'categoryId',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.3s">

                {!! Form::label('subcategory_id1', __('lang.subcategory') . ' 1', [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('subcategory_id1', $subcategories, request()->subcategory_id1, [
                        'class' => 'form-control select2 subcategory',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'subcategory_id1',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.35s">

                {!! Form::label('subcategory_id2', __('lang.subcategory') . ' 2', [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('subcategory_id2', $subcategories, request()->subcategory_id2, [
                        'class' => 'form-control select2 subcategory2',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'subCategoryId2',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.4s">

                {!! Form::label('subcategory_id3', __('lang.subcategory') . ' 3', [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('subcategory_id3', $subcategories, request()->subcategory_id3, [
                        'class' => 'form-control select2 subcategory3',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'subCategoryId3',
                    ]) !!}
                </div>
            </div>

            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.45s">

                {!! Form::label('brand_id', __('lang.brand'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('brand_id', $brands, request()->brand_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.5s">

                {!! Form::label('created_by', __('lang.created_by'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('created_by', $users, request()->created_by, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.55s">
                <div class="form-check">
                    {!! Form::radio('selling_filter', 'best', request()->selling_filter === 'best', ['class' => 'form-check-input']) !!}

                    {!! Form::label('best_seller', __('lang.best_selling'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.6s">
                <div class="form-check">
                    {!! Form::radio('selling_filter', 'least', request()->selling_filter === 'least', [
                        'class' => 'form-check-input',
                    ]) !!}
                    {!! Form::label('worst_seller', __('lang.least_selling'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.65s">
                <div class="form-check">
                    {!! Form::radio('stock_filter', 'most', request()->stock_filter === 'most', ['class' => 'form-check-input']) !!}
                    {!! Form::label('most_stock', __('lang.most_stock'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.7s">
                <div class="form-check">
                    {!! Form::radio('stock_filter', 'lowest', request()->stock_filter === 'lowest', ['class' => 'form-check-input']) !!}
                    {!! Form::label('lowest_stock', __('lang.lowest_stock'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.75s">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1"
                        {{ !empty(request()->nearest_expiry_filter) ? 'checked' : '' }} name="nearest_expiry_filter">
                    <label
                        class="custom-control-label @if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        style="font-size: 12px;font-weight: 500;" for="customSwitch1">@lang('lang.nearest_expiry_filter')</label>
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.8s">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="expired"
                        {{ !empty(request()->expired) ? 'checked' : '' }} name="expired">
                    <label style="font-size: 12px;font-weight: 500;"
                        class="custom-control-label @if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        for="expired">@lang('lang.expired')</label>
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.85s">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="dont_show_zero_stocks"
                        {{ !empty(request()->dont_show_zero_stocks) ? 'checked' : '' }} name="dont_show_zero_stocks">
                    <label style="font-size: 12px;font-weight: 500;"
                        class="custom-control-label @if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        for="dont_show_zero_stocks">@lang('lang.dont_show_zero_stocks')</label>
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.9s">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="zero_stocks"
                        {{ !empty(request()->zero_stocks) ? 'checked' : '' }} name="zero_stocks">
                    <label style="font-size: 12px;font-weight: 500;"
                        class="custom-control-label @if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        for="zero_stocks">@lang('lang.zero_stocks')</label>
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.95s">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="balance_return_request"
                        {{ !empty(request()->balance_return_request) ? 'checked' : '' }} name="balance_return_request">
                    <label style="font-size: 12px;font-weight: 500;"
                        class="custom-control-label @if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        for="balance_return_request">@lang('lang.balance_return_request')</label>
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay:2s">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="sell_price_less_purchase_price"
                        {{ !empty(request()->sell_price_less_purchase_price) ? 'checked' : '' }}
                        name="sell_price_less_purchase_price">
                    <label style="font-size: 12px;font-weight: 500;"
                        class="custom-control-label @if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        for="sell_price_less_purchase_price">@lang('lang.sell_price_less_purchase_price')</label>
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 2.1s">

                <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                    <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>

            </div>
        </div>
    </form>
</div>
<script></script>
