    <div class="row unit-row[{{ $key }}]">
    <input type="hidden" name="products[{{ $key ?? 0 }}][variations][{{$index ?? 0 }}][variation_id]" value="{{$variation->id ?? null}}">
    @if(isset($index) && $index!=='')
        <div class="col-md-2">
            {!! Form::label('equal', __('lang.equal'),['class'=>'h5 pt-3']) !!}
            {!! Form::text('products['.$key.'][variations]['.$index.'][equal]', isset($product->variations[$index-1]->equal) ? $product->variations[$index-1]->equal:null, [
                'class' => 'form-control'
            ]) !!}
        </div>
        <div class="col-md-2">
            {!! Form::label('unit', __('lang.small_filling'), ['class'=>'h5 pt-3']) !!}
            <div class="d-flex justify-content-center">
                <select name="products[{{ $key }}][variations][{{$index}}][new_unit_id]"  data-name='unit_id' data-index="{{$index}}"  class="form-control unit_select select2 unit_id{{$index}}{{$key ??''}}" style="width: 100px;" data-key="{{ $key }}">
                    <option value="">{{__('lang.please_select')}}</option>
                    @foreach($units as $unit)
                        <option @if($key == 0 && isset( $variation->unit_id) &&($variation->unit_id == $unit->id)) selected @endif  value="{{$unit->id}}">{{$unit->name}}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-primary btn-sm ml-2 btn-add-modal add_unit_raw" data-key="{{ $key }}" data-toggle="modal" data-index="{{$index}}" data-target=".add-unit" href="{{route('units.create')}}"><i class="fas fa-plus"></i></button>
            </div>
        </div>
        <div class="col-md-2 pl-5">
            {!! Form::label('sku', __('lang.product_code'),['class'=>'h5 pt-3']) !!}
            {!! Form::text('products['.$key.'][variations]['.$index.'][sku]',$variation->sku ?? null, [
                'class' => 'form-control'
            ]) !!}
            <br>
            @error('products.' . $key .'variations.' . $index .'.sku')
            <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>
        <div class="col-md-2 pt-4">
            <button class="btn btn btn-warning add_small_unit" type="button" data-key="{{ $key }}">
                <i class="fa fa-equals"></i>
            </button>
        </div>
    @endif
</div>
