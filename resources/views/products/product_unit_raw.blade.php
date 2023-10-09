<div class="row unit-row">
    <div class="col-md-2 pl-5">
        {!! Form::label('sku', __('lang.product_code'),['class'=>'h5 pt-3']) !!}
        {!! Form::text('sku['.$index.']',  isset($variation->sku)?$variation->sku:null, [
            'class' => 'form-control'
        ]) !!}
    </div>
{{--    {{dd($variation)}}--}}
    <div class="col-md-2">
        {!! Form::label('unit', __('lang.new_unit'), ['class'=>'h5 pt-3']) !!}
        <div class="d-flex justify-content-center">
            <select name="new_unit_id[{{$index}}]"  data-name='unit_id' data-index="{{$index}}" required class="form-control select2 unit_id{{$index}}" style="width: 100px;">
                <option value="">{{__('lang.please_select')}}</option>
                @foreach($units as $unit)
                    <option @if($variation->unit_id == $unit->id) selected @endif  value="{{$unit->id}}">{{$unit->name}}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal" data-index="{{$index}}" data-target=".add-unit" href="{{route('units.create')}}"><i class="fas fa-plus"></i></button>
        </div>
    </div>
    <div class="col-md-2">
        {!! Form::label('equal', __('lang.equal'),['class'=>'h5 pt-3']) !!}
        {!! Form::text('equal['.$index.']', isset($variation->equal)?$variation->equal:null, [
            'class' => 'form-control'
        ]) !!}
    </div>
    <div class="col-md-2">
        {!! Form::label('basic_unit', __('lang.basic_unit'), ['class'=>'h5 pt-3']) !!}
        <div class="d-flex justify-content-center">
            <select name="basic_unit_id[{{$index}}]'" data-name='basic_unit_id' data-index="{{$index}}" required class="form-control select2 basic_unit_id{{$index}}" style="width: 100px;">
                <option value="">{{__('lang.please_select')}}</option>
                @foreach($units as $unit)
                    <option @if($variation->basic_unit_id == $unit->id) selected @endif value="{{$unit->id}}">{{$unit->name}}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal" data-index="{{$index}}" data-target=".add-unit" data-type="basic_unit" href="{{route('units.create')}}"><i class="fas fa-plus"></i></button>
        </div>
        </div>
    <div class="col-md-2 pt-4">
        <button class="btn btn btn-danger remove_row" type="button">
            <i class="fa fa-close"></i>
        </button>
    </div>
</div>
