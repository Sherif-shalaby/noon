<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content @if (app()->isLocale('ar')) text-end @else text-start @endif">

            {!! Form::open([
                'url' => route('general-tax.update', $general_taxes->id),
                'method' => 'put',
                'id' => 'general_tax_edit_form',
            ]) !!}

            <div
                class="modal-header mb-4 d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                <h4 class="modal-title">@lang('lang.edit_general_tax')</h4>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body p-0">
                {{-- +++++++++++ tax_name inputField +++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else ml-3 @endif">
                    {!! Form::label('name', __('lang.tax_name') . '*', [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 14px',
                    ]) !!}
                    {!! Form::text('name', $general_taxes->name, [
                        'class' => 'initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                        'placeholder' => __('lang.tax_name'),
                        'required',
                    ]) !!}
                </div>
                {{-- +++++++++++++++++++++++ tax_rate inputField +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else ml-3 @endif">
                    <label class="modal-label-width" style="font-size: 14px"
                        for="tax_rate">{{ __('lang.tax_rate') . '*%' }}</label>
                    <input
                        class="form-control initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                        type="text" name="rate" id="tax_rate" placeholder="{{ __('lang.tax_rate') }}"
                        value="{{ $general_taxes->rate }}">
                </div>
                {{-- +++++++++++++++++++++++ tax_details inputField +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else ml-3 @endif">
                    <label class="modal-label-width" style="font-size: 14px"
                        for="tax_details">{{ __('lang.tax_details') . '*' }}</label>
                    <textarea name="details" id="tax_details"
                        class="form-control initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                        placeholder="{{ __('lang.tax_details') }}" rows="5" cols="10">{{ $general_taxes->details }}</textarea>
                </div>
                {{-- +++++++++++++++++++++++ "tax_method" selectbox +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else ml-3 @endif">
                    <label class="modal-label-width" style="font-size: 14px"
                        for="method">{{ __('lang.tax_method') . '*' }}</label>
                    <select name="method" id="method"
                        class="form-control initial-balance-input my-0 p-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                        data-live-search='true' placeholder="{{ __('lang.please_select') }}" required>
                        <option value="">{{ __('lang.please_select') }}</option>
                        <option {{ old('method', $general_taxes['method']) == 'inclusive' ? 'selected' : '' }}
                            value="inclusive">{{ __('lang.inclusive') }}</option>
                        <option {{ old('method', $general_taxes['method']) == 'exclusive' ? 'selected' : '' }}
                            value="exclusive">{{ __('lang.exclusive') }}</option>
                    </select>
                </div>
                {{-- +++++++++++++++++++++++ "tax_method" selectbox +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else ml-3 @endif">
                    <label class="modal-label-width" style="font-size: 14px"
                        for="status">{{ __('lang.tax_status') . '*' }}</label>
                    <select name="status" id="status"
                        class="form-control initial-balance-input my-0 p-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                        data-live-search='true' placeholder="{{ __('lang.please_select') }}" required>
                        <option value="">{{ __('lang.please_select') }}</option>
                        <option {{ old('status', $general_taxes['status']) == 'passive' ? 'selected' : '' }}
                            value="passive">{{ __('lang.passive') }}</option>
                        <option {{ old('status', $general_taxes['status']) == 'active' ? 'selected' : '' }}
                            value="active">{{ __('lang.active') }}</option>
                    </select>
                </div>
                {{-- +++++++++++++++++++++++ "stores" selectbox +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else ml-3 @endif">
                    <label class="modal-label-width" style="font-size: 14px"
                        for="store">{{ __('lang.store') . '*' }}</label>
                    <select name="store_id" id="store"
                        class="form-control initial-balance-input my-0 p-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                        placeholder="{{ __('lang.please_select') }}" required>
                        <option value="">{{ __('lang.please_select') }}</option>

                        @foreach ($stores_data as $store)
                            @foreach ($general_taxes->stores as $store_tax)
                                @if ($store_tax->id == $store->id)
                                    <option value="{{ $store->id }}" selected>{{ $store->name }}</option>
                                @else
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endif
                            @endforeach
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.close')</button>
            </div>

            {!! Form::close() !!}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>
