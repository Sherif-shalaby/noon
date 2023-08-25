<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            {!! Form::open(['url' => route('product-tax.store'), 'method' => 'post']) !!}

            <div class="modal-header">

                <h4 class="modal-title">@lang( 'lang.add_general_tax')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                {{-- +++++++++++++++++++++++ tax_name +++++++++++++++++++++++ --}}
                <div class="form-group">
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
                    <select name="status" id="status" class="form-control"
                            data-live-search='true' placeholder="{{  __('lang.please_select') }}" required>
                        <option value="">{{  __('lang.please_select') }}</option>
                        <option value="passive">{{ __('lang.passive') }}</option>
                        <option value="active">{{ __('lang.active') }}</option>
                    </select>
                </div>
                {{-- +++++++++++++++++++++++ "tax_method" selectbox +++++++++++++++++++++++ --}}
                {{-- <div class="form-group">
                    <label for="method">{{ __('lang.tax_method').':*' }}</label>
                    <select name="method" id="method" class="form-control"
                            data-live-search='true' placeholder="{{  __('lang.please_select') }}" required>
                        <option value="">{{  __('lang.please_select') }}</option>
                        <option value="inclusive">{{ __('lang.inclusive') }}</option>
                        <option value="exclusive">{{ __('lang.exclusive') }}</option>
                    </select>
                </div> --}}

                {{-- +++++++++++++++++++++++ "products" selectbox +++++++++++++++++++++++ --}}
                {{-- <div class="form-group">
                    <label for="product">{{ __('lang.products').':*' }}</label>
                    <select name="product_id" id="product" class="form-control" placeholder="{{  __('lang.please_select') }}" required>
                        <option value="">{{  __('lang.please_select') }}</option>
                        @foreach ($products as $product )
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div> --}}
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang( 'lang.save' )</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'lang.close' )</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\MoneySafeUpdateRequest','#money-safe-update-form'); !!}
