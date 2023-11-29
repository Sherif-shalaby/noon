<div class="card-body">
    <form action="{{ route('reports.add_stock') }}" method="get">
        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.1s">
                {!! Form::label('product_name', __('lang.product_name'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                {!! Form::text('product_name', request()->product_name, [
                    'class' => 'form-control mt-0 initial-balance-input width-full',
                    'placeholder' => __('lang.product_name'),
                    'wire:model' => 'product_name',
                ]) !!}
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                {!! Form::label('product_sku', __('lang.sku'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                {!! Form::text('product_sku', request()->product_sku, [
                    'class' => 'form-control  mt-0 initial-balance-input width-full',
                    'placeholder' => __('lang.sku'),
                    'wire:model' => 'product_sku',
                ]) !!}
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.2s">
                {!! Form::label('product_symbol', __('lang.product_symbol'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                {!! Form::text('product_symbol', request()->product_symbol, [
                    'class' => 'form-control  mt-0 initial-balance-input width-full',
                    'placeholder' => __('lang.product_symbol'),
                    'wire:model' => 'product_symbol',
                ]) !!}
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
                {!! Form::label('supplier_id', __('lang.supplier'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('supplier_id', $suppliers, request()->supplier_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                        'data-name' => 'supplier_id',
                        'wire:model' => 'supplier_id',
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
                        ' data-name' => 'created_by',
                        'placeholder' => __('lang.please_select'),
                        'wire:model' => 'created_by',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.55s">
                {!! Form::label('brand_id', __('lang.brand'), [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('brand_id', $brands, request()->brand_id, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.please_select'),
                        'data-name' => 'brand_id',
                        'wire:model' => 'brand_id',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.6s">
                {!! Form::label('purchase_type', __('lang.purchase_type') . '*', [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select(
                        'purchase_type',
                        ['import' => __('lang.import'), 'local' => __('lang.local')],
                        request()->purchase_type,
                        ['class' => 'form-control select2', 'placeholder' => __('lang.please_select')],
                    ) !!}
                </div>
            </div>
            <div class="col-md-2  mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.65s">
                {!! Form::label('payment_status', __('lang.payment_status') . ':*', [
                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                    'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper">
                    {!! Form::select('payment_status', $payment_status_array, request()->payment_status, [
                        'class' => 'form-control select2',
                        'data-live-search' => 'true',
                        'placeholder' => __('lang.please_select'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.7s">
                <label style="font-size: 12px;font-weight: 500;"
                    class="@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                    for="due_date">{{ __('lang.payment_date') }}</label>
                {!! Form::date('due_date', null, [
                    'class' => 'form-control mt-0 initial-balance-input width-full',
                    'placeholder' => __('lang.due_date'),
                ]) !!}
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.75s">
                <label style="font-size: 12px;font-weight: 500;"
                    class="@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                    for="from">{{ __('site.From') }}</label>
                {!! Form::date('from', request()->from, [
                    'class' => 'form-control mt-0 initial-balance-input width-full',
                    'placeholder' => __('lang.from'),
                    'wire:model' => 'from',
                ]) !!}
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.8s">
                <label style="font-size: 12px;font-weight: 500;"
                    class="@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 @else mx-2 mb-0 @endif"
                    for="to">{{ __('site.To') }}</label>
                {!! Form::date('to', request()->to ?? date('Y-m-d'), [
                    'class' => 'form-control mt-0 initial-balance-input width-full',
                    'placeholder' => __('lang.to'),
                ]) !!}
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft"
                style="animation-delay: 1.85s">
                <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                    <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
            </div>
        </div>
    </form>
</div>
@push('javascripts')
    <script>
        $(document).ready(function() {
            $('select').on('change', function(e) {

                var name = $(this).data('name');
                var index = $(this).data('index');
                var select2 = $(this); // Save a reference to $(this)
                Livewire.emit('listenerReferenceHere', {
                    var1: name,
                    var2: select2.select2("val"),
                    var3: index
                });

            });
        });
    </script>
@endpush
