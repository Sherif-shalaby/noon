    <div
        class="d-flex animate__animated  animate__bounceInRight unit-row[{{ $key }}]  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        <input type="hidden" name="product[{{ $key ?? 0 }}]variation_ids[{{ $index ?? 0 }}]"
            value="{{ $variation->id ?? null }}">
        @if (isset($index) && $index !== '')
            @if ($index == 1)
                <div class="px-1 animate__animated  animate__bounceInRight d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                    style="width: 75px">
                    {{-- {!! Form::label('sku', __('lang.product_code'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!} --}}
                    {!! Form::text('products[' . $key . '][variations][' . $index . '][sku]', $variation->sku ?? null, [
                        'class' => 'form-control initial-balance-input',
                        'style' => 'width:100%;margin:0 !important;border:2px solid #ccc',
                        'placeholder' => __('lang.product_code'),
                    ]) !!}

                    @error('sku.' . $index)
                        <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
                <div
                    class="pl-1 animate__animated  animate__bounceInRight d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                    {{-- {!! Form::label('unit', __('lang.large_filling'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!} --}}
                    <div class="d-flex justify-content-center align-items-center"
                        style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                        <select name="products[{{ $key }}][variations][{{ $index }}][new_unit_id]"
                            data-name='unit_id' data-index="{{ $index }}" required
                            class="form-control unit_select select2 unit_id{{ $index }}" style="width: 100px;"
                            data-key="{{ $key }}">
                            <option value="">{{ __('lang.large_filling') }}</option>
                            @foreach ($units as $unit)
                                <option @if ($key == 0 && isset($variation->unit_id) && $variation->unit_id == $unit->id) selected @endif value="{{ $unit->id }}">
                                    {{ $unit->name }}</option>
                            @endforeach
                        </select>
                        <button type="button"
                            class="add-button d-flex justify-content-center align-items-center add_unit_raw"
                            data-toggle="modal" data-index="{{ $index }}" data-target=".add-unit"
                            href="{{ route('units.create') }}"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-2 d-flex justify-content-center align-items-end">
                    <button class="btn btn btn-primary add_small_unit" type="button" data-key="{{ $key }}">
                        <i class="fa fa-equals"></i>
                    </button>
                </div>
            @else
                <div class="px-1 animate__animated  animate__bounceInRight d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                    style="width: 75px">
                    {{-- {!! Form::label('equal', __('lang.equal'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!} --}}
                    {!! Form::text(
                        'products[' . $key . '][variations][' . $index . '][equal]',
                        isset($variation->equal) ? $variation->equal : null,
                        [
                            'class' => 'form-control initial-balance-input',
                            'style' => 'width:100%;margin:0 !important;border:2px solid #ccc',
                            'placeholder' => __('lang.equal'),
                        ],
                    ) !!}
                </div>
                <div
                    class="pl-1 animate__animated  animate__bounceInRight d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                    {{-- {!! Form::label('unit', __('lang.small_filling'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!} --}}
                    <div class="d-flex justify-content-center align-items-center"
                        style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 100%;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                        <select name="products[{{ $key }}][variations][{{ $index }}][new_unit_id]"
                            data-name='unit_id' data-index="{{ $index }}" required
                            class="form-control unit_select select2 unit_id{{ $index }}" style="width: 100px;"
                            data-key="{{ $key }}">
                            <option value="">{{ __('lang.small_filling') }}</option>
                            @foreach ($units as $unit)
                                <option @if ($key == 0 && isset($variation->unit_id) && $variation->unit_id == $unit->id) selected @endif value="{{ $unit->id }}">
                                    {{ $unit->name }}</option>
                            @endforeach
                        </select>
                        <button type="button"
                            class="add-button d-flex justify-content-center align-items-center add_unit_raw"
                            data-toggle="modal" data-index="{{ $index }}" data-target=".add-unit"
                            href="{{ route('units.create') }}"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="pl-1 animate__animated  animate__bounceInRight d-flex flex-column justify-content-center @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                    style="width: 75px">
                    {{-- {!! Form::label('sku', __('lang.product_code'), [
                        'class' => app()->isLocale('ar') ? 'd-block text-end   mb-0' : ' mb-0 ',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!} --}}
                    {!! Form::text('products[' . $key . '][variations][' . $index . '][sku]', $variation->sku ?? null, [
                        'class' => 'form-control initial-balance-input',
                        'style' => 'width:100%;margin:0 !important;border:2px solid #ccc',
                        'placeholder' => __('lang.product_code'),
                    ]) !!}

                    @error('sku.' . $index)
                        <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-md-2 d-flex justify-content-center align-items-end">
                    <button class="btn btn btn-primary add_small_unit" type="button" data-key="{{ $key }}">
                        <i class="fa fa-equals"></i>
                    </button>
                </div>
            @endif


            {{--        <div class="col-md-2"> --}}
            {{--            {!! Form::label('basic_unit', __('lang.basic_unit'), ['class'=>'h5 pt-3']) !!} --}}
            {{--            <div class="d-flex justify-content-center"> --}}
            {{--                <select name="products[{{ $key }}][basic_unit_id][{{$index}}]'" data-name='basic_unit_id' data-index="{{$index}}" class="form-control select2 basic_unit_id{{$index}}" style="width: 100px;"> --}}
            {{--                    <option value="">{{__('lang.please_select')}}</option> --}}
            {{--                    @foreach ($units as $unit) --}}
            {{--                        <option @if (isset($variation->basic_unit_id) && $variation->basic_unit_id == $unit->id) selected @endif value="{{$unit->id}}">{{$unit->name}}</option> --}}
            {{--                    @endforeach --}}
            {{--                </select> --}}
            {{--                <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal" data-index="{{$index}}" data-target=".add-unit" data-type="basic_unit" href="{{route('units.create')}}"><i class="fas fa-plus"></i></button> --}}
            {{--            </div> --}}
            {{--            </div> --}}
            {{--        <div class="col-md-2 pt-4"> --}}
            {{--            <button class="btn btn btn-danger remove_row" type="button" data-key="{{ $key }}"> --}}
            {{--                <i class="fa fa-close"></i> --}}
            {{--            </button> --}}
            {{--        </div> --}}
        @endif
    </div>
