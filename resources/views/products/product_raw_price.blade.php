<div class="d-flex align-items-center unit-row justify-content-between py-2 mb-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
    style="background-color: #ededed; border-radius: 7px">

    <div
        class="col-md-11 d-flex justify-content-between py-2  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        <div
            class="col-md-3 px-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {!! Form::label('sku', __('lang.product_code'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end mb-0 width-half' : ' mb-0 width-half',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::text('sku[' . $index . ']', isset($variation->sku) ? $variation->sku : null, [
                'class' => 'form-control mater-name-input m-0',
            ]) !!}
            @error('sku.' . $index)
                <label class="text-danger error-msg">{{ $message }}</label>
            @enderror
        </div>

        <div
            class="col-md-3 px-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {!! Form::label('unit', __('lang.new_unit'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mb-0 width-half' : 'mb-0 width-half',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="d-flex justify-content-center align-items-center"
                style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                <select name="new_unit_id[{{ $index }}]" data-name='unit_id' data-index="{{ $index }}"
                    required class="form-control select2 unit_id{{ $index }}" style="width: 100px;">
                    <option value="">{{ __('lang.please_select') }}</option>
                    @foreach ($units as $unit)
                        <option @if (isset($variation->unit_id) && $variation->unit_id == $unit->id) selected @endif value="{{ $unit->id }}">
                            {{ $unit->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="add-button add_unit_raw" data-toggle="modal"
                    data-index="{{ $index }}" data-target=".add-unit" href="{{ route('units.create') }}"><i
                        class="fas fa-plus"></i></button>
            </div>
        </div>
        <div
            class="col-md-3 px-2 d-flex align-items-center justify-content-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {!! Form::label('equal', __('lang.equal'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end mb-0 width-fit ml-2' : ' mb-0 width-fit mr-2',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            {!! Form::text('equal[' . $index . ']', isset($variation->equal) ? $variation->equal : null, [
                'class' => 'form-control mater-name-input m-0 width-30',
            ]) !!}
        </div>
        <div
            class="col-md-3 px-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {!! Form::label('basic_unit', __('lang.basic_unit'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end mb-0 width-65' : ' mb-0 width-65',
                'style' => 'font-size: 12px;font-weight: 500;',
            ]) !!}
            <div class="d-flex justify-content-center align-items-center"
                style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                <select name="basic_unit_id[{{ $index }}]'" data-name='basic_unit_id'
                    data-index="{{ $index }}" class="form-control select2 basic_unit_id{{ $index }}"
                    style="width: 100px;">
                    <option value="">{{ __('lang.please_select') }}</option>
                    @foreach ($units as $unit)
                        <option @if (isset($variation->basic_unit_id) && $variation->basic_unit_id == $unit->id) selected @endif value="{{ $unit->id }}">
                            {{ $unit->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="add-button add_unit_raw" data-toggle="modal"
                    data-index="{{ $index }}" data-target=".add-unit" data-type="basic_unit"
                    href="{{ route('units.create') }}"><i class="fas fa-plus"></i></button>
            </div>
        </div>
    </div>

    <div class="col-md-1 p-0 d-flex justify-content-center align-items-center">
        <div>
            <button class="btn btn btn-danger remove_row" type="button">
                <i class="fa fa-close"></i>
            </button>
        </div>
    </div>

</div>
