<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 600px!important;">
        <div class="modal-content">
            {!! Form::open([
                'url' => route('stocks.storePayment', $transaction_id),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
            ]) !!}
            <div class="modal-header d-flex justify-content-between flex-row-reverse width-full">
                <input type="hidden" value="{{ $transaction_id }}" id="transaction_id">
                <input type="hidden" value="{{ $pending_amount }}" id="pending_amount">
                <h4 class="modal-title">@lang('lang.add_payment')</h4>
                <button type="button" class="close mx-0" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div
                        class=" col-6 flex-column col-md-6 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">

                        {!! Form::label('amount', __('lang.amount') . '*', [
                            'class' => 'mb-0',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            @if (isset($transaction->return_parent))
                                {!! Form::text('amount', $pending_amount - $transaction->return_parent, [
                                    'class' => 'form-control  m-0 initial-balance-input width-full',
                                    'placeholder' => __('lang.amount'),
                                    'id' => 'amount',
                                ]) !!}
                            @else
                                {!! Form::text('amount', $pending_amount, [
                                    'class' => 'form-control  m-0 initial-balance-input width-full',
                                    'placeholder' => __('lang.amount'),
                                    'id' => 'amount',
                                ]) !!}
                            @endif

                        </div>
                    </div>
                    <div
                        class=" col-6 flex-column col-md-6 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('method', __('lang.payment_type') . '*', [
                            'class' => 'mb-0',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            {!! Form::select('method', $payment_type_array, 'cash', [
                                'class' => ' form-select',
                                'data-live-search' => 'true',
                                'required',
                                'placeholder' => __('lang.please_select'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class=" col-6 flex-column col-md-6 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <label class="mb-0" for="paying_currency">@lang('lang.paying_currency') *</label>
                        <div class="input-wrapper width-full">
                            {!! Form::select('paying_currency', $selected_currencies, null, [
                                'class' => 'form-select',
                                'placeholder' => __('lang.please_select'),
                                'data-live-search' => 'true',
                                'id' => 'paying_currency',
                            ]) !!}
                            @error('paying_currency')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div
                        class=" col-6 flex-column col-md-6 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">

                        {!! Form::label('exchange_rate', __('lang.exchange_rate'), [
                            'class' => 'mb-0',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            <input type="text" class="form-control  m-0 initial-balance-input width-full"
                                id="exchange_rate" name="exchange_rate" value="{{ $exchange_rate }}">
                        </div>
                    </div>
                    <div
                        class=" col-6 flex-column col-md-6 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">

                        {!! Form::label('source_type', __('lang.source_type'), [
                            'class' => 'mb-0',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            {!! Form::select(
                                'source_type',
                                ['user' => __('lang.user'), 'pos' => __('lang.pos'), 'store' => __('lang.store'), 'safe' => __('lang.safe')],
                                null,
                                [
                                    'class' => ' form-select',
                                    'data-live-search' => 'true',
                                    'placeholder' => __('lang.please_select'),
                                    'wire:model' => 'source_type',
                                ],
                            ) !!}
                        </div>
                    </div>
                    <div
                        class=" col-6 flex-column col-md-6 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">

                        {!! Form::label('source_of_payment', __('lang.source_of_payment'), [
                            'class' => 'mb-0',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            {!! Form::select('source_id', $users, null, [
                                'class' => ' form-select',
                                'data-live-search' => 'true',
                                'placeholder' => __('lang.please_select'),
                                'id' => 'source_id',
                            ]) !!}
                        </div>
                    </div>

                    <div
                        class=" col-6 flex-column col-md-6 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('paid_on', __('lang.payment_date'), [
                            'class' => 'mb-0',
                        ]) !!}
                        <div class="input-wrapper width-full">

                            {!! Form::text('paid_on', @format_date(date('Y-m-d')), [
                                'class' => 'form-control datepicker  m-0 initial-balance-input width-full',
                                'readonly',
                                'required',
                                'placeholder' => __('lang.payment_date'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class=" col-6 flex-column col-md-6 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('upload_documents', __('lang.upload_documents'), [
                            'class' => 'mb-0',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            <input type="file" class=" m-0 initial-balance-input width-full"
                                name="upload_documents[]" id="upload_documents" multiple>
                        </div>
                    </div>
                    <div
                        class=" col-6 flex-column col-md-6 mb-2 d-flex @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">

                        <label>
                            {!! Form::checkbox('change_exchange_rate_to_supplier', 1, false) !!}
                            @lang('lang.change_exchange_rate_to_supplier')
                        </label>

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"> @lang('lang.save') </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.close')</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>
    $('#source_type').change(function() {
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
        var transaction = $("#transaction_id").val();
        var pending_amount = $("#pending_amount").val();
        var exchange_rate = $("#exchange_rate").val();
        if ($(this).val() !== '') {
            $.ajax({
                method: 'get',
                url: '/add-stock/get-paying-currency/' + $(this).val(),
                data: {
                    transaction: transaction,
                    pending_amount: pending_amount,
                    exchange_rate: exchange_rate
                },
                success: function(result) {
                    $("#amount").val(result);
                },
            });
        }
    });
    $('#exchange_rate').change(function() {
        var transaction = $("#transaction_id").val();
        var pending_amount = $("#pending_amount").val();
        var exchange_rate = $("#exchange_rate").val();
        var paying_currency = $("#paying_currency").val();
        if ($(this).val() !== '') {
            $.ajax({
                method: 'get',
                url: '/add-stock/get-paying-currency/' + paying_currency,
                data: {
                    transaction: transaction,
                    pending_amount: pending_amount,
                    exchange_rate: exchange_rate
                },
                success: function(result) {
                    $("#amount").val(result);
                },
            });
        }
    });
</script>
