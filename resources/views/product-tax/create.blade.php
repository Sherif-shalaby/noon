<!-- Modal -->
<div class="modal fade" id="add_product_tax_modal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" style="display: none;"
     aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{__('lang.product_tax')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => 'product-tax.store', 'method' => 'post', 'files' => true,'id' => isset($quick_add)&&$quick_add ? 'quick_add_product_tax_form' : 'product_tax-form']) !!}
            <div class="modal-body">
                {{-- +++++++++++++++++++++++ tax_name +++++++++++++++++++++++ --}}
                <div class="form-group">
                    <input type="hidden" name="quick_add" value="{{ isset($quick_add)&&$quick_add?$quick_add:'' }}">
                    <label for="tax_name">{{ __( 'lang.tax_name').':*' }}</label>
                    <input type="text" name="name" class="form-control" placeholder="{{ __( 'lang.tax_name' ) }}" required>
                    {{-- Error Message --}}
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- +++++++++++++++++++++++ tax_rate +++++++++++++++++++++++ --}}
                <div class="form-group">
                    <label for="tax_name">{{ __('lang.tax_rate').':*%' }}</label>
                    <input type="text" name="rate" id="tax_name" class="form-control" placeholder="{{ __( 'lang.tax_rate' ) }}" required>
                </div>
                {{-- +++++++++++++++++++++++ tax_details +++++++++++++++++++++++ --}}
                <div class="form-group">
                    <label for="tax_details">{{ __('lang.tax_details').':*' }}</label>
                    <textarea name="details" id="tax_details" class="form-control" placeholder="{{ __( 'lang.tax_details' ) }}" rows="5" cols="10"></textarea>
                </div>
                {{-- +++++++++++++++++++++++ tax_status +++++++++++++++++++++++ --}}
                <div class="form-group">
                    <label for="status">{{ __('lang.tax_status').':*' }}</label>
                    <select name="status" class="form-control select2"
                            data-live-search='true' placeholder="{{  __('lang.please_select') }}" required>
                        <option value="">{{  __('lang.please_select') }}</option>
                        <option value="passive">{{ __('lang.passive') }}</option>
                        <option value="active">{{ __('lang.active') }}</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button  id="create-product-tax-btn" class="btn btn-primary">{{__('lang.save')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CategoryRequest','#category-form'); !!}
<script>
    {{--$(document).ready(function () {--}}
    {{--    // Attach a click event handler to the button--}}
    {{--    $('.select_sub_category').click(function () {--}}
    {{--        // Get the data-select_category attribute value--}}
    {{--         {{ $selectCategoryValue }} = $(this).data('select_category');--}}
    {{--        // Set the value in the modal--}}
    {{--        $('#selectedCategoryValue').text(selectCategoryValue);--}}
    {{--    });--}}
    {{--});--}}
</script>
