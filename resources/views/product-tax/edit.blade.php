<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content @if (app()->isLocale('ar')) text-end @else text-start @endif">

            {!! Form::open([
                'url' => route('product-tax.update', $product_tax->id),
                'method' => 'put',
                'id' => 'product_tax_edit_form',
            ]) !!}

            <div class="modal-header  mb-4 d-flex justify-content-between py-0 ">

                <h4 class="modal-title">@lang('lang.edit_product_tax')</h4>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body p-0">
                {{-- +++++++++++ tax_name inputField +++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else flex-row ml-3 @endif">
                    {!! Form::label('name', __('lang.tax_name') . '*', ['class' => 'modal-label-width']) !!}
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::text('name', $product_tax->name, [
                            'class' =>
                                'select form-control datepicker category p-0 initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                            'style' => 'width:100%;border-radius:16px;border:2px solid #cececf',
                            'placeholder' => __('lang.tax_name'),
                            'required',
                        ]) !!}
                    </div>
                </div>
                {{-- +++++++++++++++++++++++ tax_rate inputField +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else flex-row ml-3 @endif">
                    <label class="modal-label-width" for="tax_rate">{{ __('lang.tax_rate') . '*%' }}</label>
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <input type="text" name="rate" id="tax_rate"
                            class="form-control initial-balance-input m-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                            style="width: 100%" placeholder="{{ __('lang.tax_rate') }}"
                            value="{{ $product_tax->rate }}">
                    </div>
                </div>
                {{-- +++++++++++++++++++++++ tax_details inputField +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex my-4 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else flex-row ml-3 @endif">
                    <label class="modal-label-width" for="tax_details">{{ __('lang.tax_details') . '*' }}</label>
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <textarea name="details" id="tax_details"
                            class="form-control initial-balance-input m-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                            style="width: 100%" placeholder="{{ __('lang.tax_details') }}">{{ $product_tax->details }}</textarea>
                    </div>
                </div>
                {{-- +++++++++++++++++++++++ "tax_status" selectbox +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else flex-row ml-3 @endif">
                    <label class="modal-label-width" for="status">{{ __('lang.tax_status') . '*' }}</label>
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <select name="status" id="status"
                            style="width:100%;border-radius:16px;border:2px solid #cececf"
                            class="select category p-0 initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                            data-live-search='true' placeholder="{{ __('lang.please_select') }}" required>
                            <option value="">{{ __('lang.please_select') }}</option>
                            <option {{ old('status', $product_tax['status']) == 'passive' ? 'selected' : '' }}
                                value="passive">{{ __('lang.passive') }}</option>
                            <option {{ old('status', $product_tax['status']) == 'active' ? 'selected' : '' }}
                                value="active">{{ __('lang.active') }}</option>
                        </select>
                    </div>
                </div>
                {{-- +++++++++++++++++++++++ "tax_method" selectbox +++++++++++++++++++++++ --}}
                {{-- <div class="form-group">
                    <label for="method">{{ __('lang.tax_method').':*' }}</label>
                    <select name="method" id="method" class="form-control" data-live-search='true' placeholder="{{  __('lang.please_select') }}" required>
                        <option value="">{{  __('lang.please_select') }}</option>
                        <option {{ old('method', $product_tax['method']) == 'inclusive' ? 'selected' : '' }} value="inclusive">{{ __('lang.inclusive') }}</option>
                        <option {{ old('method', $product_tax['method']) == 'exclusive' ? 'selected' : '' }} value="exclusive">{{ __('lang.exclusive') }}</option>
                    </select>
                </div> --}}
                {{-- +++++++++++++++++++++++ "stores" selectbox +++++++++++++++++++++++ --}}
                {{-- <div class="form-group">
                    <label for="product">{{ __('lang.products').':*' }}</label>
                    <select name="product_id" id="product" class="form-control" placeholder="{{  __('lang.please_select') }}" required>
                        <option value="">{{  __('lang.please_select') }}</option>
                        @foreach ($products_data as $x)
                            @foreach ($product_tax->products as $y)
                                @if ($product_tax->id == $x->id)
                                    <option value="{{ $x->id }}" selected>{{$x->name}}</option>
                                @else
                                    <option value="{{ $x->id }}">{{$x->name}}</option>
                                @endif
                            @endforeach
                        @endforeach
                    </select>
                </div> --}}

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.close')</button>
            </div>

            {!! Form::close() !!}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>
