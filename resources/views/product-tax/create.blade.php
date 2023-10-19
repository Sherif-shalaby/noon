<!-- Modal -->
<div class="modal fade" id="add_product_tax_modal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content  @if (app()->isLocale('ar')) text-end @else text-start @endif">
            <div class="modal-header  mb-4 d-flex justify-content-between py-0 ">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{ __('lang.product_tax') }}</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => 'product-tax.store',
                'method' => 'post',
                'files' => true,
                'id' => isset($quick_add) && $quick_add ? 'quick_add_product_tax_form' : 'product_tax-form',
            ]) !!}
            <div class="modal-body p-0">
                {{-- +++++++++++++++++++++++ tax_name +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else flex-row ml-3 @endif">
                    <input type="hidden" name="quick_add"
                        value="{{ isset($quick_add) && $quick_add ? $quick_add : '' }}">
                    <label class="modal-label-width" for="tax_name">{{ __('lang.tax_name') . '*' }}</label>
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <input type="text" name="name"
                            class="select form-control datepicker category p-0 initial-balance-input my-0 @if (app()->isLocale('ar')) text-end  @else  text-start @endif"
                            style="width:100%;border-radius:16px;border:2px solid #cececf"
                            placeholder="{{ __('lang.tax_name') }}" required>
                        {{-- Error Message --}}
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- +++++++++++++++++++++++ tax_rate +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else flex-row ml-3 @endif">
                    <label class="modal-label-width" for="tax_name">{{ __('lang.tax_rate') . '*%' }}</label>
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <input type="text" name="rate" id="tax_name"
                            class="form-control initial-balance-input m-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                            style="width: 100%" placeholder="{{ __('lang.tax_rate') }}" required>
                    </div>
                </div>
                {{-- +++++++++++++++++++++++ tax_details +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex my-4 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else flex-row ml-3 @endif">
                    <label class="modal-label-width" for="tax_details">{{ __('lang.tax_details') . '*' }}</label>
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <textarea name="details" id="tax_details"
                            class="form-control initial-balance-input m-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                            style="width: 100%" placeholder="{{ __('lang.tax_details') }}"></textarea>
                    </div>
                </div>
                {{-- +++++++++++++++++++++++ tax_status +++++++++++++++++++++++ --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse mr-3 @else flex-row ml-3 @endif">
                    <label class="modal-label-width" for="status">{{ __('lang.tax_status') . '*' }}</label>
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <select name="status" style="width:100%;border-radius:16px;border:2px solid #cececf"
                            class="select category p-0 initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                            data-live-search='true' placeholder="{{ __('lang.please_select') }}" required>
                            <option value="">{{ __('lang.please_select') }}</option>
                            <option value="passive">{{ __('lang.passive') }}</option>
                            <option value="active" selected>{{ __('lang.active') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button id="create-product-tax-btn" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CategoryRequest', '#category-form') !!}
<script>
    {{-- $(document).ready(function () { --}}
    {{--    // Attach a click event handler to the button --}}
    {{--    $('.select_sub_category').click(function () { --}}
    {{--        // Get the data-select_category attribute value --}}
    {{--         {{ $selectCategoryValue }} = $(this).data('select_category'); --}}
    {{--        // Set the value in the modal --}}
    {{--        $('#selectedCategoryValue').text(selectCategoryValue); --}}
    {{--    }); --}}
    {{-- }); --}}
</script>
