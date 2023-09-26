<div class="row unit-row">
    <div class="col-md-2 pl-5">
        {!! Form::label('sku', __('lang.product_code'),['class'=>'h5 pt-3']) !!}
        {!! Form::text('sku['.$index.']',  isset($variation->sku)?$variation->sku:null, [
            'class' => 'form-control'
        ]) !!}
    </div>
    <div class="col-md-2">
        {!! Form::label('unit', __('lang.new_unit'), ['class'=>'h5 pt-3']) !!}
            {!! Form::select(
                'new_unit_id['.$index.']',
                $units,isset($variation->unit_id)?$variation->unit_id:null,
                ['class' => 'form-control select2 new_unit','placeholder'=>__('lang.please_select')]
            ) !!}
    </div>
    <div class="col-md-2">
        {!! Form::label('equal', __('lang.equal'),['class'=>'h5 pt-3']) !!}
        {!! Form::text('equal['.$index.']', isset($variation->equal)?$variation->equal:null, [
            'class' => 'form-control'
        ]) !!}
    </div>
    <div class="col-md-2">
        {!! Form::label('basic_unit', __('lang.basic_unit'), ['class'=>'h5 pt-3']) !!}
            {!! Form::select(
                'basic_unit_id['.$index.']',
                $units,isset($variation->basic_unit_id)?$variation->basic_unit_id:null,
                ['class' => 'form-control select2 basic_unit_id','placeholder'=>__('lang.please_select')]
            ) !!}
    </div>
    <div class="col-md-2 pt-4">
        <button class="btn btn btn-danger remove_row" type="button">
            <i class="fa fa-close"></i>
        </button>
    </div>
    
</div>