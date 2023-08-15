{{--<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"--}}
{{--     style="display: none;" aria-hidden="true">--}}
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            {!! Form::open(['url' => route('stocks.store_payment',$transaction_id), 'method' => 'post', 'id' => 'add_payment_form', 'enctype' => 'multipart/form-data']) !!}

            <div class="modal-header">

                <h4 class="modal-title">@lang('lang.add_payment')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="transaction_id" value="{{ $transaction_id }}">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('amount', __('lang.amount') . ':*', []) !!} <br>
                            @if (isset($transaction->return_parent))
                                {!! Form::text('amount', @num_format($transaction->final_total - $transaction->transaction_payments->sum('amount') - $transaction->return_parent->final_total), ['class' => 'form-control', 'placeholder' => __('lang.amount')]) !!}
                                <input type="hidden" name="total" value="{{  @num_format($transaction->dollar_final_total - $transaction->transaction_payments->sum('amount') - $transaction->return_parent->final_total) }}">
                            @else
                                {!! Form::text('amount', @num_format($transaction->final_total - $transaction->transaction_payments->sum('amount')), ['class' => 'form-control', 'placeholder' => __('lang.amount')]) !!}
                                <input type="hidden" name="total" value="{{@num_format($transaction->dollar_final_total - $transaction->transaction_payments->sum('amount'))}}">
                            @endif

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('method', __('lang.payment_type') . ':*', []) !!}
                            {!! Form::select('method', $payment_type_array, 'cash', ['class' => 'select2 form-control', 'data-live-search' => 'true', 'required', 'style' => 'width: 80%', 'placeholder' => __('lang.please_select')]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="paying_currency">@lang('lang.paying_currency') :*</label>
                            {!! Form::select('paying_currency', $selected_currencies, null, ['class' => 'form-control select','placeholder' => __('lang.please_select'), 'data-live-search' => 'true', 'required', 'id' => 'paying_currency']) !!}
                            @error('paying_currency')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('exchange_rate', __('lang.exchange_rate') . ':', []) !!}
                            <input type="text"  class="form-control" id="exchange_rate" name="exchange_rate" value="{{$exchange_rate}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('source_type', __('lang.source_type'), []) !!} <br>
                            {!! Form::select('source_type', ['user' => __('lang.user'), 'pos' => __('lang.pos'), 'store' => __('lang.store'), 'safe' => __('lang.safe')], 'user', ['class' => 'select2 form-control', 'data-live-search' => 'true', 'style' => 'width: 80%', 'placeholder' => __('lang.please_select')]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('source_of_payment', __('lang.source_of_payment'), []) !!} <br>
                            {!! Form::select('source_id', $users, null, ['class' => 'select2 form-control', 'data-live-search' => 'true', 'style' => 'width: 80%', 'placeholder' => __('lang.please_select'), 'id' => 'source_id']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('paid_on', __('lang.payment_date') . ':', []) !!} <br>
                            {!! Form::text('paid_on', @format_date(date('Y-m-d')), ['class' => 'form-control datepicker', 'readonly', 'required', 'placeholder' => __('lang.payment_date')]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('upload_documents', __('lang.upload_documents') . ':', []) !!} <br>
                            <input type="file" name="upload_documents[]" id="upload_documents" multiple>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.close')</button>
            </div>

            {!! Form::close() !!}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
{{--</div>--}}
<script>
    $('#source_type').change(function() {
        alert($(this).val());
        if ($(this).val() !== '') {
            $.ajax({
                method: 'get',
                url: '/add-stock/get-source-by-type-dropdown/' + $(this).val(),
                data: {},
                success: function(result) {
                    $("#source_id").empty().append(result);
                },
            });
        }
    });

    $('#paying_currency').change(function() {
        if ($(this).val() !== '') {
           if($(this).val() == 2){
                var exchange_rate = document.getElementById("exchange_rate").value;

               alert(exchange_rate);
           }

        }
    });
</script>

