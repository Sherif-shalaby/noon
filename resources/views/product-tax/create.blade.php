<!-- Modal -->
<div class="modal animate__animated product-tax-modal animate__rollIn" id="add_product_tax_modal" tabindex="-1"
    role="dialog" aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div
                class="modal-header d-flex justify-content-between py-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{ __('lang.product_tax') }}</h5>
                <button type="button" class="close mx-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => 'product-tax.store',
                'method' => 'post',
                'files' => true,
                'id' => isset($quick_add) && $quick_add ? 'quick_add_product_tax_form' : 'product_tax-form',
            ]) !!}
            <div class="modal-body">
                <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {{-- +++++++++++++++++++++++ tax_name +++++++++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-6 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <input type="hidden" name="quick_add"
                            value="{{ isset($quick_add) && $quick_add ? $quick_add : '' }}">
                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end mx-2 mb-0 @else mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;"
                            for="tax_name">{{ __('lang.tax_name') . '*' }}</label>
                        <div
                            class="select_body input-wrapper width-full d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <input type="text" name="name"
                                class="select form-control category p-0 initial-balance-input my-0 @if (app()->isLocale('ar')) text-end  @else  text-start @endif"
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
                        class="mb-2 col-md-6 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end mx-2 mb-0 @else mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;"
                            for="tax_name">{{ __('lang.tax_rate') . '*%' }}</label>
                        <div
                            class="select_body input-wrapper width-full d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <input type="text" name="rate" id="tax_name"
                                class="form-control initial-balance-input m-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                                style="width: 100%" placeholder="{{ __('lang.tax_rate') }}" required>
                        </div>
                    </div>

                    {{-- +++++++++++++++++++++++ tax_status +++++++++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-12 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end mx-2 mb-0 @else mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;"
                            for="status">{{ __('lang.tax_status') . '*' }}</label>
                        <div
                            class="select_body input-wrapper width-full d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <select name="status" style="width:100%;border-radius:16px;border:2px solid #cececf"
                                class="select category p-0 initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                                data-live-search='true' placeholder="{{ __('lang.please_select') }}" required>
                                <option value="">{{ __('lang.please_select') }}</option>
                                <option value="passive">{{ __('lang.passive') }}</option>
                                <option value="active" selected>{{ __('lang.active') }}</option>
                            </select>
                        </div>
                    </div>
                    {{-- +++++++++++++++++++++++ tax_details +++++++++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-12 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end mx-2 mb-0 @else mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;"
                            for="tax_details">{{ __('lang.tax_details') . '*' }}</label>
                        <div
                            class="select_body width-full d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <textarea name="details" id="tax_details"
                                class="form-control initial-balance-input m-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                                style="width: 100%;background-color: #dedede" placeholder="{{ __('lang.tax_details') }}"></textarea>
                        </div>
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

{{-- <script>
    $(document).ready(function() {
        var modelEl = $('.product-tax-modal');

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
</script> --}}

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CategoryRequest', '#category-form') !!}
