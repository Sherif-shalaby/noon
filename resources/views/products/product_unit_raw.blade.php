<div class="row unit-row">
    <div class="col-md-3 pl-5">
        {!! Form::label('sku', __('lang.product_code'),['class'=>'h5 pt-3']) !!}
        {!! Form::text('sku['.$index.']',  isset($variation->sku)?$variation->sku:null, [
            'class' => 'form-control'
        ]) !!}
    </div>
    <div class="col-md-3">
        {!! Form::label('unit', __('lang.unit'), ['class'=>'h5 pt-3']) !!}
        <div class="d-flex justify-content-center">
            {!! Form::select(
                'unit_id['.$index.']',
                $units,isset($variation->unit_id)?$variation->unit_id:null,
                ['class' => 'form-control select2','placeholder'=>__('lang.please_select'),'id'=>'unit_id']
            ) !!}
         <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#create">
            <i class="fa fa-plus"></i>
        </button>
        </div>
    </div>
    <div class="col-md-3 pt-4">
        <button class="btn btn btn-danger remove_row" type="button">
            <i class="fa fa-close"></i>
        </button>
    </div>
    
</div>