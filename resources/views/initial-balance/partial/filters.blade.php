<div class="card-body">
    {{--    <form action="{{route('initial-balance.index')}}" method="get"> --}}
    <div class="row">
        <div class="col-2">
            <div class="form-group">
                {!! Form::text('product_name', null, [
                    'class' => 'form-control',
                    'placeholder' => __('lang.product_name'),
                    'wire:model' => 'product_name',
                ]) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::text('product_sku', null, [
                    'class' => 'form-control',
                    'placeholder' => __('lang.sku'),
                    'wire:model' => 'product_sku',
                ]) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::text('product_symbol', null, [
                    'class' => 'form-control',
                    'placeholder' => __('lang.product_symbol'),
                    'wire:model' => 'product_symbol',
                ]) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select('supplier_id', $suppliers, $supplier_id, [
                    'class' => 'form-control select2',
                    'data-name' => 'supplier_id',
                    'placeholder' => __('lang.supplier'),
                    'wire:model' => 'supplier_id',
                ]) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                {!! Form::select('created_by', $users, $created_by, [
                    'class' => 'form-control select2',
                    'data-name' => 'created_by',
                    'placeholder' => __('lang.created_by'),
                    'wire:model' => 'created_by',
                ]) !!}
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <button type="button" name="submit" class="btn btn-danger width-100" title="search"
                    wire:click="clear_filters">
                    {{ __('lang.clear_filters') }}</button>
            </div>
        </div>
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
