<!-- Modal -->
<div class="modal modal-add-tax animate__animated  add-store" data-animate-in="animate__rollIn"
    data-animate-out="animate__rollOut" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content @if (app()->isLocale('ar')) text-end @else text-start @endif">
            {!! Form::open(['url' => route('general-tax.store'), 'method' => 'post']) !!}

            <div
                class="modal-header mb-4 d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                <h4 class="modal-title">@lang('lang.add_general_tax')</h4>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body p-0">
                {{-- +++++++++++++++++++++++ tax_name +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else ml-3 @endif">
                    <label class="modal-label-width" style="font-size: 12px;font-weight: 500"
                        for="tax_name">{{ __('lang.tax_name') . '*' }}</label>
                    <input type="text" name="name"
                        class="form-control initial-balance-input mr-3 my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                        placeholder="{{ __('lang.tax_name') }}" required>
                    {{-- Error Message --}}
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- +++++++++++++++++++++++ tax_rate +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else ml-3 @endif">
                    <label class="modal-label-width" style="font-size: 12px;font-weight: 500"
                        for="tax_name">{{ __('lang.tax_rate') . '*%' }}</label>
                    <input type="text" name="rate" id="tax_name"
                        class="form-control initial-balance-input mr-3 my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                        placeholder="{{ __('lang.tax_rate') }}" required>
                </div>
                {{-- +++++++++++++++++++++++ tax_details +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else ml-3 @endif">
                    <label class="modal-label-width" style="font-size: 12px;font-weight: 500"
                        for="tax_details">{{ __('lang.tax_details') . '*' }}</label>
                    <textarea name="details" id="tax_details"
                        class="form-control initial-balance-input mr-3 my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                        placeholder="{{ __('lang.tax_details') }}" rows="5" cols="10"></textarea>
                </div>
                {{-- +++++++++++++++++++++++ "tax_method" selectbox +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else ml-3 @endif">
                    <label class="modal-label-width" style="font-size: 12px;font-weight: 500"
                        for="method">{{ __('lang.tax_method') . '*' }}</label>
                    <div class="input-wrapper mr-3">
                        <select name="method" id="method"
                            class="form-control initial-balance-input p-0 my-0 width-full @if (app()->isLocale('ar')) text-end @else text-start @endif"
                            data-live-search='true' placeholder="{{ __('lang.please_select') }}" required>
                            <option value="">{{ __('lang.please_select') }}</option>
                            <option value="inclusive">{{ __('lang.inclusive') }}</option>
                            <option value="exclusive">{{ __('lang.exclusive') }}</option>
                        </select>
                    </div>
                </div>
                {{-- +++++++++++++++++++++++ tax_method +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else ml-3 @endif">
                    <label class="modal-label-width" style="font-size: 12px;font-weight: 500"
                        for="status">{{ __('lang.tax_status') . '*' }}</label>
                    <div class="input-wrapper mr-3">

                        <select name="status" id="status"
                            class="form-control initial-balance-input p-0 my-0 width-full @if (app()->isLocale('ar')) text-end @else text-start @endif"
                            data-live-search='true' placeholder="{{ __('lang.please_select') }}" required>
                            <option value="">{{ __('lang.please_select') }}</option>
                            <option value="passive">{{ __('lang.passive') }}</option>
                            <option value="active">{{ __('lang.active') }}</option>
                        </select>
                    </div>
                </div>
                {{-- +++++++++++++++++++++++ "stores" selectbox +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else ml-3 @endif">
                    <label class="modal-label-width" style="font-size: 12px;font-weight: 500"
                        for="store">{{ __('lang.store') . '*' }}</label>
                    <div class="input-wrapper mr-3">

                        <select name="store_id" id="store"
                            class="form-control initial-balance-input p-0 my-0 width-full @if (app()->isLocale('ar')) text-end @else text-start @endif"
                            placeholder="{{ __('lang.please_select') }}" required>
                            <option value="">{{ __('lang.please_select') }}</option>
                            @foreach ($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.close')</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var modelEl = $('.modal-add-tax');

        modelEl.addClass(modelEl.attr('data-animate-in'));

        modelEl.on('hide.bs.modal', function(event) {
                if (!$(this).attr('is-from-animation-end')) {
                    event.preventDefault();
                    $(this).addClass($(this).attr('data-animate-out'))
                    $(this).removeClass($(this).attr('data-animate-in'))
                }
                $(this).removeAttr('is-from-animation-end')
            })
            .on('animationend', function() {
                if ($(this).hasClass($(this).attr('data-animate-out'))) {
                    $(this).attr('is-from-animation-end', true);
                    $(this).modal('hide')
                    $(this).removeClass($(this).attr('data-animate-out'))
                    $(this).addClass($(this).attr('data-animate-in'))
                }
            })
    })
</script>
{!! JsValidator::formRequest('App\Http\Requests\MoneySafeUpdateRequest', '#money-safe-update-form') !!}
