<div class="card-body">
{{--    <form action="{{route('initial-balance.index')}}" method="get">--}}
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    {!! Form::text(
                        'product_name', null,
                        ['class' => 'form-control','placeholder'=>__('lang.product_name'),'wire:model' => 'product_name']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::text(
                        'product_sku',null,
                        ['class' => 'form-control','placeholder'=>__('lang.sku'),'wire:model' => 'product_sku']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::text(
                        'product_symbol',null,
                        ['class' => 'form-control','placeholder'=>__('lang.product_symbol'),'wire:model' => 'product_symbol']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::select(
                        'supplier_id',
                        $suppliers,null,
                        ['class' => 'form-control select2','placeholder'=>__('lang.supplier'),'wire:model' => 'supplier_id']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::select(
                        'created_by',
                        $users,null,
                        ['class' => 'form-control select2','data-name'=>'created_by','placeholder'=>__('lang.created_by'),'wire:model' => 'created_by']
                    ) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                        <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
                </div>
            </div>
        </div>
{{--    </form>--}}
</div>
