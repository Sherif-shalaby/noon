<div class="card-body">
    {{--    <form action="{{route('initial-balance.index')}}" method="get"> --}}
    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.15s">
            <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                for="product_name">{{ __('lang.product_name') }}</label>
            <div class="input-wrapper">
                {!! Form::text('product_name', null, [
                    'class' => 'form-control  m-0 initial-balance-input width-full',
                    'placeholder' => __('lang.product_name'),
                    'wire:model' => 'product_name',
                ]) !!}
            </div>
        </div>
        <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.15s">
            <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                for="product_sku">{{ __('lang.sku') }}</label>
            <div class="input-wrapper">
                {!! Form::text('product_sku', null, [
                    'class' => 'form-control  m-0 initial-balance-input width-full',
                    'placeholder' => __('lang.sku'),
                    'wire:model' => 'product_sku',
                ]) !!}
            </div>
        </div>
        <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.15s">
            <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                for="product_symbol">{{ __('lang.product_symbol') }}</label>
            <div class="input-wrapper">
                {!! Form::text('product_symbol', null, [
                    'class' => 'form-control  m-0 initial-balance-input width-full',
                    'placeholder' => __('lang.product_symbol'),
                    'wire:model' => 'product_symbol',
                ]) !!}
            </div>
        </div>
        <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.15s">
            <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                for="supplier">{{ __('lang.supplier') }}</label>
            <div class="input-wrapper">
                {!! Form::select('supplier_id', $suppliers, $supplier_id, [
                    'class' => 'form-control select2',
                    'placeholder' => __('lang.supplier'),
                    'data-name' => 'supplier_id',
                    'wire:model' => 'supplier_id',
                ]) !!}
            </div>
        </div>
        <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.15s">
            <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                for="created_by">{{ __('lang.created_by') }}</label>
            <div class="input-wrapper">
                {!! Form::select('created_by', $users, $created_by, [
                    'class' => 'form-control select2',
                    ' data-name' => 'created_by',
                    'placeholder' => __('lang.created_by'),
                    'wire:model' => 'created_by',
                ]) !!}
            </div>
        </div>
        <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.15s">
            <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                for="brand">{{ __('lang.brand') }}</label>
            <div class="input-wrapper">
                {!! Form::select('brand_id', $brands, $brand_id, [
                    'class' => 'form-control select2',
                    'placeholder' => __('lang.brand'),
                    'data-name' => 'brand_id',
                    'wire:model' => 'brand_id',
                ]) !!}
            </div>
        </div>
        <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.15s">
            <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                for="from">{{ __('site.From') }}</label>
            <div class="input-wrapper">
                {!! Form::date('from', $from, [
                    'class' => 'form-control  m-0 initial-balance-input width-full',
                    'placeholder' => __('lang.from'),
                    'wire:model' => 'from',
                ]) !!}
            </div>
        </div>
        <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
            style="animation-delay: 1.15s">
            <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                for="to">{{ __('site.To') }}</label>
            <div class="input-wrapper">
                {!! Form::date('to', $to, [
                    'class' => 'form-control  m-0 initial-balance-input width-full',
                    'placeholder' => __('lang.to'),
                    'wire:model' => 'to',
                ]) !!}
            </div>
        </div>
        {{--   <div class="col-6 col-md-2 p-1 mb-2 d-flex align-items-end animate__animated animate__bounceInLeft flex-column"
                style="animation-delay: 1.15s">
                <div class="input-wrapper">
                    <button type="button" name="submit" class="btn btn-danger width-100" title="search" wire:click="clear_filters">
                         {{ __('lang.clear_filters') }}</button>
                </div>
            </div> --}}

    </div>
    {{--    </form> --}}
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
