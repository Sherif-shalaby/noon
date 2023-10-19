<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            {!! Form::open(['url' => route('product-tax.update', $product_tax->id), 'method' => 'put', 'id' => 'product_tax_edit_form' ]) !!}

            <div class="modal-header">

                <h4 class="modal-title">@lang( 'lang.edit_product_tax' )</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                {{-- +++++++++++ tax_name inputField +++++++++++ --}}
                <div class="form-group">
                    {!! Form::label('name', __( 'lang.tax_name' ) . ':*') !!}
                    {!! Form::text('name', $product_tax->name, ['class' => 'form-control', 'placeholder' => __( 'lang.tax_name' ), 'required']); !!}
                </div>
                {{-- +++++++++++++++++++++++ tax_rate inputField +++++++++++++++++++++++ --}}
                <div class="form-group">
                    <label for="tax_rate">{{ __('lang.tax_rate').':*%' }}</label>
                    <input type="text" name="rate" id="tax_rate" class="form-control" placeholder="{{ __( 'lang.tax_rate' ) }}" value="{{ $product_tax->rate }}">
                </div>
                {{-- +++++++++++++++++++++++ tax_details inputField +++++++++++++++++++++++ --}}
                <div class="form-group">
                    <label for="tax_details">{{ __('lang.tax_details').':*' }}</label>
                    <textarea name="details" id="tax_details" class="form-control" placeholder="{{ __( 'lang.tax_details' ) }}" rows="5" cols="10">{{ $product_tax->details }}</textarea>
                </div>
                {{-- +++++++++++++++++++++++ "tax_status" selectbox +++++++++++++++++++++++ --}}
                <div class="form-group">
                    <label for="status">{{ __('lang.tax_status').':*' }}</label>
                    <select name="status" id="status" class="form-control"
                            data-live-search='true' placeholder="{{  __('lang.please_select') }}" required>
                        <option value="">{{  __('lang.please_select') }}</option>
                        <option {{ old('status', $product_tax['status']) == 'passive' ? 'selected' : '' }} value="passive">{{ __('lang.passive') }}</option>
                        <option {{ old('status', $product_tax['status']) == 'active' ? 'selected' : '' }} value="active">{{ __('lang.active') }}</option>
                    </select>
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
                        @foreach ($products_data as $x )
                            @foreach ($product_tax->products as $y )
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
                <button type="submit" class="btn btn-primary">@lang( 'lang.save' )</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'lang.close' )</button>
            </div>

            {!! Form::close() !!}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>
