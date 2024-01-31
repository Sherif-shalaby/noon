<!-- Modal -->
<div class="modal add-store" id="createBrandModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog rollIn  animated" role="document">
        <div class="modal-content">
            <div
                class="modal-header d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{ __('lang.add_brand') }}</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => 'brands.store',
                'method' => 'post',
                'files' => true,
                'id' => isset($quick_add) && $quick_add ? 'quick_add_brand_form' : 'brand-form',
            ]) !!}
            <div class="modal-body">
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <input type="hidden" name="quick_add"
                        value="{{ isset($quick_add) && $quick_add ? $quick_add : '' }}">
                    {!! Form::label('name', __('lang.brand_name') . '*', [
                        'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 width-quarter' : ' mx-2 mb-0 width-quarter',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    {!! Form::text('name', null, [
                        'class' => 'initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                        'placeholder' => __('lang.brand_name'),
                        'required',
                    ]) !!}
                    @error('name')
                        <span style="font-size: 10px;font-weight: 700;"
                            class="text-danger error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button id="create-brand-btn" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\BrandRequest', '#brand-form') !!}
{!! JsValidator::formRequest('App\Http\Requests\BrandRequest', '#quick_add_brand_form') !!}
