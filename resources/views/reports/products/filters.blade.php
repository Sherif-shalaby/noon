@php
    if (request()->branch_id) {
        $stores = \App\Models\Store::where('branch_id', request()->branch_id)->pluck('name', 'id');
    }
@endphp
<div class="card-body">
    <form action="{{ route('reports.products') }}" method="get">
        <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-6 col-lg-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
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
            <div class="col-6 col-lg-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                {!! Form::label('store_id', __('lang.store'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">

                    {!! Form::select('store_id[]', $stores, request()->store_id, [
                        'class' => 'form-control select2 elect2-search__field',
                        'multiple',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'store_id',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.2s">
                {!! Form::label('supplier_id', __('lang.supplier'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">

                    {!! Form::select('supplier_id[]', $suppliers, request()->supplier_id, [
                        'class' => 'form-control select2 select2-search__field',
                        'multiple',
                        'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.25s">
                {!! Form::label('category_id', __('lang.category') . ' 1', [
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
            <div class="col-6 col-lg-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.3s">
                {!! Form::label('subcategory_id1', __('lang.category') . ' 2', [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">

                    {!! Form::select('subcategory_id1', $subcategories1, request()->subcategory_id1, [
                        'class' => 'form-control select2 subcategory',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'subcategory_id1',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.35s">
                {!! Form::label('subcategory_id2', __('lang.category') . ' 3', [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">

                    {!! Form::select('subcategory_id2', $subcategories2, request()->subcategory_id2, [
                        'class' => 'form-control select2 subcategory2',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'subCategoryId2',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.4s">
                {!! Form::label('subcategory_id3', __('lang.category') . ' 4', [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">

                    {!! Form::select('subcategory_id3', $subcategories3, request()->subcategory_id3, [
                        'class' => 'form-control select2 subcategory3',
                        'placeholder' => __('lang.please_select'),
                        'id' => 'subCategoryId3',
                    ]) !!}
                </div>
            </div>

            <div class="col-6 col-lg-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.45s">
                {!! Form::label('brand_id', __('lang.brand'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">

                    {!! Form::select('brand_id[]', $brands, request()->brand_id, [
                        'class' => 'form-control select2 select2-search__field',
                        'multiple',
                        'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.5s">
                {!! Form::label('created_by', __('lang.created_by'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">

                    {!! Form::select('created_by[]', $users, request()->created_by, [
                        'class' => 'form-control select2 select2-search__field',
                        'multiple',
                        'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>
            <div class="col-6"></div>
            <div class="col-6 col-lg-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.55s">
                <div class="form-check">
                    {!! Form::radio('selling_filter', 'best', request()->selling_filter === 'best', ['class' => 'form-check-input']) !!}
                    {!! Form::label('best_seller', __('lang.best_selling'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
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
            <div class="col-6 col-lg-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.65s">
                <div class="form-check">
                    {!! Form::radio(
                        'selling_filter',
                        'all',
                        request()->selling_filter === 'all' || !request()->has('selling_filter'),
                        ['class' => 'form-check-input', 'id' => 'all_sellers'],
                    ) !!}
                    {!! Form::label('all_sellers', __('lang.all_selling'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.7s">
                <div class="form-check">
                    {!! Form::radio('stock_filter', 'most', request()->stock_filter === 'most', ['class' => 'form-check-input']) !!}
                    {!! Form::label('most_stock', __('lang.most_stock'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.75s">
                <div class="form-check">
                    {!! Form::radio('stock_filter', 'lowest', request()->stock_filter === 'lowest', ['class' => 'form-check-input']) !!}
                    {!! Form::label('lowest_stock', __('lang.lowest_stock'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.8s">
                <div class="form-check">
                    {!! Form::radio('stock_filter', 'all', request()->stock_filter === 'all' || !request()->has('stock_filter'), [
                        'class' => 'form-check-input',
                    ]) !!}
                    {!! Form::label('all_stock', __('lang.all_stock'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.85s">
                <div class="form-check">
                    {!! Form::radio('stocks', 'no_zero', request()->stocks === 'zero', ['class' => 'form-check-input']) !!}
                    {!! Form::label('no_zero', __('lang.dont_show_zero_stocks'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.9s">
                <div class="form-check">
                    {!! Form::radio('stocks', 'zero', request()->stocks === 'zero', ['class' => 'form-check-input']) !!}
                    {!! Form::label('zero', __('lang.zero_stocks'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 2s">
                <div class="form-check">
                    {!! Form::radio('stocks', 'all', request()->stocks === 'all' || !request()->stocks, [
                        'class' => 'form-check-input',
                    ]) !!}
                    {!! Form::label('all', __('lang.all'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 2.1s">
                <div class="form-check">
                    {!! Form::radio('expiry', 'nearest', request()->expiry === 'nearest', ['class' => 'form-check-input']) !!}
                    {!! Form::label('nearest', __('lang.nearest_expiry_filter'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 2.15s">
                <div class="form-check">
                    {!! Form::radio('expiry', 'expired', request()->expiry === 'expired', ['class' => 'form-check-input']) !!}
                    {!! Form::label('expired', __('lang.expired'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 2.2s">
                <div class="form-check">
                    {!! Form::radio('expiry', 'non', request()->expiry === 'non' || !request()->expiry, [
                        'class' => 'form-check-input',
                    ]) !!}
                    {!! Form::label('non', __('lang.all'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end form-check-label mx-2 mb-0' : ' form-check-label mx-2 mb-0',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                </div>
            </div>
            <div class="col-6 col-lg-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 2.25s">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="checkbox" id="balance_return_request"
                        {{ !empty(request()->balance_return_request) ? 'checked' : '' }} name="balance_return_request">
                    <label style="font-size: 12px;font-weight: 500;"
                        class="checkbox @if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        for="balance_return_request">@lang('lang.balance_return_request')</label>
                </div>
            </div>
            <div class="col-6 col-lg-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 2.3s">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="checkbox" id="sell_price_less_purchase_price"
                        {{ !empty(request()->sell_price_less_purchase_price) ? 'checked' : '' }}
                        name="sell_price_less_purchase_price">
                    <label style="font-size: 12px;font-weight: 500;"
                        class="checkbox @if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                        for="sell_price_less_purchase_price">@lang('lang.sell_price_less_purchase_price')</label>
                </div>
            </div>
            <div class="col-6 col-lg-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 2.35s">
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                        <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script></script>
