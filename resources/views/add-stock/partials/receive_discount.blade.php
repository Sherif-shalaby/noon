<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 600px!important;">
        <div class="modal-content">
            {!! Form::open(['url' => route('stocks.receive_discount', $transaction_id), 'method' => 'post' ,'enctype' => 'multipart/form-data']) !!}
                <div class="modal-header">
                    <input type="hidden" value="{{$transaction_id}}" id="transaction_id">
                    {{-- <input type="hidden" value="{{$pending_amount}}" id="pending_amount"> --}}
                    <h4 class="modal-title">@lang('lang.add_payment')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="discount_type">@lang('lang.discount_type') :*</label>
                                {!! Form::select('discount_type',  [
                                    'seasonal_discount' =>__('lang.seasonal_discount'),
                                    'annual_discount'=>__('lang.annual_discount'),
                                    ],null, ['class' => 'form-control select','placeholder' => __('lang.please_select'), 'data-live-search' => 'true', 'id' => 'discount_type']) !!}
                                @error('discount_type')
                                <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 discount-div" id="seasonal_discount_divs">
                            @if($seasonal_discount > 0)
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        {!! Form::label('seasonal_discount', __('lang.seasonal_discount') . ':*', []) !!} <br>
                                        {!! Form::text('seasonal_discount',$seasonal_discount, ['class' => 'form-control dueAmount', 'placeholder' => __('lang.seasonal_discount'), 'id' => 'seasonal_discount']) !!}

                                    </div>
                                </div>
                            @endif
                            @if ($seasonal_discount_dollar > 0)

                                <div class="col-md-6">
                                    <div class="form-group" >
                                        {!! Form::label('seasonal_discount', __('lang.seasonal_discount') . ':*', []) !!} <br>
                                        {!! Form::text('seasonal_discount',$seasonal_discount_dollar, ['class' => 'form-control dueDollarAmount', 'placeholder' => __('lang.seasonal_discount'), 'id' => 'seasonal_discount']) !!}

                                    </div>
                                </div>
                                                        
                            @endif
                        </div>
                        <div class="col-md-6 discount-div" id="annual_discount_divs">

                            @if($annual_discount > 0)
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        {!! Form::label('annual_discount', __('lang.annual_discount') . ':*', []) !!} <br>
                                            {!! Form::text('annual_discount',$annual_discount, ['class' => 'form-control dueAmount', 'placeholder' => __('lang.annual_discount'), 'id' => 'annual_discount']) !!}

                                    </div>
                                </div>
                                                        
                            @endif
                            @if($annual_discount_dollar > 0)
                                <div class="col-md-6">
                                    <div class="form-group" 
                                        {!! Form::label('annual_discount', __('lang.annual_discount') . ':*', []) !!} <br>
                                        {!! Form::text('annual_discount',$annual_discount_dollar, ['class' => 'form-control dueDollarAmount', 'placeholder' => __('lang.annual_discount'), 'id' => 'annual_discount']) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" >
                                {!! Form::label('amount', __('lang.amount') . ':*', []) !!} <br>
                                    {!! Form::text('amount',null, ['class' => 'form-control', 'placeholder' => __('lang.amount'), 'id' => 'amount']) !!}
                                    {{-- @if($dinar_remaining > 0) --}}
                                            {{-- <span wire:model="dinar_remaining">Change: {{$dinar_remaining}}</span> --}}
                                    {{-- @endif --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" >
                                {!! Form::label('amount', __('lang.amount') . ':*', []) !!} <br>
                                {!! Form::text('amount_dollar',null, ['class' => 'form-control', 'placeholder' => __('lang.amount'), 'id' => 'amount_dollar']) !!}
                                {{-- @if($dollar_remaining > 0) --}}
                                    {{-- <span wire:model="dollar_remaining">Change: {{$dollar_remaining}}</span>
                                    <button wire:click= "convertRemainingDollar()"><i class="fa-solid fa-retweet"></i></button> --}}
                                {{-- @endif --}}
                            </div>
                        </div>
                        <div class="col-md-6 mt-1 change_dinar_div" hidden>
                            <label class="change_text">@lang('lang.change_dinar'): </label>
                            <span class="change_dinar" class="ml-2">0.00</span>
                            <input type="hidden" name="amount_change_dinar" id="change_dinar" class="change_dinar">
                            <input type="hidden" name="amount_pending_dinar" id="pending_dinar" class="pending_dinar">
                            
                        </div>
                        <div class="col-md-6 mt-1 change_dollar_div" hidden>
                            <label class="change_text">@lang('lang.change_dollar'): </label>
                            <span class="change_dollar" class="ml-2">0.00</span>
                            <input type="hidden" name="amount_change_dollar" id="change_dollar" class="change_dollar">
                            <input type="hidden" name="amount_pending_dollar" id="pending_dollar" class="pending_dollar">
                            
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
     $(document).ready(function() {
        // Initially hide all discount divs
        $('.discount-div').hide();

        // Show relevant discount divs based on the selected discount_type
        $('#discount_type').change(function() {
            var selectedDiscountType = $(this).val();

            // Hide all discount divs
            $('.discount-div').hide();

            // Show the relevant discount divs based on the selected discount_type
            if (selectedDiscountType === 'seasonal_discount') {
                $('#seasonal_discount_divs').show();
            } else if (selectedDiscountType === 'annual_discount') {
                $('#annual_discount_divs').show();
            }
        });
    });
    $('#amount_dollar').on('change', function () {
        var newDollarAmount = parseFloat($(this).val().replace(',', ''));
        console.log(newDollarAmount);
        // if(newDollarAmount < $('.dueDollarAmount').val()){
        //     $("#amountDate").removeAttr("hidden");
        // }
        $('#amount_dollar').val(newDollarAmount);
            if ($('#amount_dollar').val() !== null && $('#amount_dollar').val() !== 0) {
                console.log(1);
                if ($('.dueDollarAmount').val() == 0 && $('#amount_dollar').val() !== 0 && $('#amount').val() !== 0 && $('.dueAmount').val() != 0) {
                    console.log(2);
                    $('.change_dollar').val($('.dueDollarAmount').val() - ($('#amount_dollar').val() + ($('#amount').val() / dollarExchange)));
                } else if ($('.dueDollarAmount').val() == 0 && $('.dueAmount').val() !== 0 && $('#amount_dollar').val() !== 0 && $('#amount').val() != 0) {
                    console.log(3);
                    $('.change_dinar').val($('.dueAmount').val() - ($('#amount').val() + ($('#amount_dollar').val() * dollarExchange)));
                } else if ($('.change_dinar').val() > 0 && $('.dueDollarAmount').val() !== null && $('.dueDollarAmount').val() !== 0 && $('#amount_dollar').val() > $('.dueDollarAmount').val()) {
                    console.log(4);
                    var diff_dollar = $('#amount_dollar').val() - $('.dueDollarAmount').val();
                    $('.change_dinar').val(round250($('.change_dinar').val() - (diff_dollar * dollarExchange)));
                    $('.change_dollar').val(0);
                } else {
                    console.log(5);
                    if ($('.dueAmount').val() != 0 && $('.dueDollarAmount').val() == 0 && $('#amount').val() == 0) {
                        console.log(6);
                        var rounded_final_total = round250($('.dueAmount').val());
                        $('.change_dinar').val(round250(rounded_final_total - ($('#amount_dollar').val() * dollarExchange)));
                    } else if ($('.dueDollarAmount').val() != 0) {
                        console.log(7);
                        $('.change_dollar').val($('.dueDollarAmount').val() - $('#amount_dollar').val());
                        console.log($('.change_dollar').val());
                        if ($('.dueAmount').val() != 0) {
                            console.log(8);
                            $('.change_dinar').val(round250($('.dueAmount').val() - $('#amount').val()));
                            if ($('.change_dinar').val() < 0 && $('.change_dollar').val() > 0) {
                                console.log(9);
                                var diff_dinar = $('#amount').val() - $('.dueAmount').val();
                                $('.change_dollar').val($('.change_dollar').val() - (diff_dinar / dollarExchange));
                                $('.change_dinar').val(0);
                            }
                        }
                    }
                }
            }
            if($('.change_dollar').val() < 0){
                $(".add_to_customer_balance").removeAttr("hidden");
            }
                // $('.change_dollar').text(change_dollar.toFixed(2));
           
            $(".change_dollar_div").removeAttr("hidden");
            $('.change_dinar').text(parseFloat($('.change_dinar').val()).toFixed(2));
            $('.change_dollar').text(parseFloat($('.change_dollar').val()).toFixed(2));

            // $('.change_dollar').val($('.change_dollar').val());
        // }
        // Function to round to the nearest 250 value
        function round250(value) {
            // Replace with your actual rounding logic
            return Math.round(value / 250) * 250;
        }
    });
    $('#amount').on('change', function (){
        var inputValue = $(this).val();
        var newAmount = parseFloat(inputValue.replace(',', ''));
        if(newAmount < $('.dueAmount').val()){
            $("#amountDate").removeAttr("hidden");
        }
        // Check if the conversion was successful
        if (!isNaN(newAmount)) {

                var newAmount = parseFloat($(this).val().replace(',', ''));
                console.log(dollarExchange);
                if ($('#amount').val() !== null && $('#amount').val() !== 0) {
                    if ($('.dueAmount').val() == 0 && $('.dueDollarAmount').val() !== 0 && $('#amount_dollar').val() !== 0 && $('#amount').val() != 0) {
                        $('.change_dollar').val($('.dueDollarAmount').val() - ($('#amount_dollar').val() + ($('#amount').val() / dollarExchange)));
                    } else if ($('.dueDollarAmount').val() == 0 && $('.dueAmount').val() !== 0 && $('#amount_dollar').val() !== 0 && $('#amount').val() != 0) {
                        $('.change_dinar').val($('.dueAmount').val() - ($('#amount').val() + ($('#amount_dollar').val() * dollarExchange)));
                    } else if ($('.change_dollar').val() > 0 && $('.dueAmount').val() !== null && $('.dueAmount').val() !== 0 && $('#amount').val() > $('.dueAmount').val()) {
                        var diff_dinar = $('#amount').val() - $('.dueAmount').val();
                        $('.change_dollar').val($('.change_dollar').val() - (diff_dinar / dollarExchange));
                        $('.change_dinar').val(0);
                    } else {
                        if ($('.dueDollarAmount').val() != 0 && $('.dueAmount').val() == 0 && $('#amount_dollar').val() == 0) {
                            $('.change_dollar').val($('.dueDollarAmount').val() - ($('#amount').val() / dollarExchange));
                        } else if ($('.dueAmount').val() != 0) {
                            $('.change_dinar').val(round_250($('.dueAmount').val()) - $('#amount').val());

                            if ($('.dueDollarAmount').val() != 0) {
                                $('.change_dollar').val($('.dueDollarAmount').val() - $('#amount_dollar').val());
                                if ($('.change_dollar').val() < 0 && $('.change_dinar').val() > 0) {
                                    var diff_dollar = $('#amount_dollar').val() - $('.dueDollarAmount').val();
                                    $('.change_dinar').val(round_250($('.change_dinar').val() - (diff_dollar * dollarExchange)));
                                    $('.change_dollar').val(0);
                                }
                            }
                        }
                    }
                }
                if($('.change_dinar').val() < 0){
                    $(".add_to_customer_balance").removeAttr("hidden");
                }
                    
                    $(".change_dinar_div").removeAttr("hidden");
                    $('.change_dinar').text(parseFloat($('.change_dinar').val()).toFixed(2));
                    $('.change_dollar').text(parseFloat($('.change_dollar').val()).toFixed(2));

                    function round_250(value) {
                        // Replace with your actual rounding logic
                        return Math.round(value / 250) * 250;
                    }
                    // $('.change_dinar').val(change.toFixed(2)); // Update the change value
        }

    });
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
                    exchange_rate : exchange_rate
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
                    exchange_rate : exchange_rate
                },
                success: function(result) {
                    $("#amount").val(result);
                },
            });
        }
    });
</script>


