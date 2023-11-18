<!-- Modal -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
    
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit">@lang('lang.edit')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['url' => route('customers.pay_due',$due->id), 'method' => 'post']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job_title">@lang('lang.due')</label>
                            <input type="text" class="form-control dueAmount" name="dueAmount" value="{{@num_format($dueAmount)}}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job_title">@lang('lang.due')</label>
                            <input type="text" class="form-control dueDollarAmount"  name="dueDollarAmount" value="{{@num_format($dueDollarAmount)}}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job_title">@lang('lang.pay')</label>
                            <input type="text" class="form-control" name="due"  id="due" value="{{@num_format($dueAmount)}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job_title">@lang('lang.pay_dollar')</label>
                            <input type="text" class="form-control" name="due_dollar" id="due_dollar"  value="{{@num_format($dueDollarAmount)}}">
                        </div>
                    </div>

                    <div class="col-md-6 mt-1 change_dinar_div" hidden>
                        <label class="change_text">@lang('lang.change_dinar'): </label>
                        <span class="change_dinar" class="ml-2">0.00</span>
                        <input type="hidden" name="amount_change_dinar" id="change_dinar" class="change_dinar">
                        
                    </div>
                    <div class="col-md-6 mt-1 change_dollar_div" hidden>
                        <label class="change_text">@lang('lang.change_dollar'): </label>
                        <span class="change_dollar" class="ml-2">0.00</span>
                        <input type="hidden" name="amount_change_dollar" id="change_dollar" class="change_dollar">
                        
                    </div>
                    <div class="col-md-6 add_to_customer_balance" hidden>
                        <button type="button" 
                            class="ml-1 btn btn-danger add_to_customer_balance">@lang('lang.add_to_customer_balance')</button>
                        <input type="hidden" name="add_to_customer_balance_dinar" id="add_to_customer_balance_dinnar" class="add_to_customer_balance_in">
                        <input type="hidden" name="add_to_customer_balance_dollar" id="add_to_customer_balance_dollar" class="add_to_customer_balance_in">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script>
var inputdueValue = $('#due').val();
if (inputdueValue !== undefined) {
    var initialAmount = parseFloat(inputdueValue.replace(',', ''));
    console.log(initialAmount);
    // Rest of your code using initialAmount
} else {
    console.error("Error: The element with id 'due' does not exist or is undefined.");
}
$('#due').on('change', function () {
    var newAmount = parseFloat($(this).val().replace(',', ''));
    // console.log('newAmount'+newAmount);
    // console.log('initialAmount'+initialAmount);
    if (!isNaN(newAmount) && newAmount > initialAmount) {
        var change = Math.abs(newAmount - initialAmount);
                $(".add_to_customer_balance").removeAttr("hidden");
                $(".change_dinar_div").removeAttr("hidden");
                $('.change_dinar').text(change.toFixed(2));
                $('.change_dinar').val(change.toFixed(2)); // Update the change value
                
    }
});
var inputduedollarValue = $('#due_dollar').val();
if (inputduedollarValue !== undefined) {
    var initialDollarAmount = parseFloat(inputduedollarValue.replace(',', ''));
    console.log(initialDollarAmount);
    // Rest of your code using initialAmount
} else {
    console.error("Error: The element with id 'due_dollar' does not exist or is undefined.");
}

$('#due_dollar').on('change', function () {
    var newDollarAmount = parseFloat($(this).val().replace(',', ''));
    // console.log('newAmount'+newAmount);
    // console.log('inputduedollarValue'+inputduedollarValue);
    if (!isNaN(newDollarAmount) && newDollarAmount > inputduedollarValue) {
        var change_dollar = Math.abs(newDollarAmount - inputduedollarValue);
                $(".add_to_customer_balance").removeAttr("hidden");
                $(".change_dollar_div").removeAttr("hidden");
                $('.change_dollar').text(change_dollar.toFixed(2));
                $('.change_dollar').val(change_dollar.toFixed(2)); // Update the change value
                
    }
    $this->dollar_amount = $('#due_dollar').val()
    $this->amount = $('#due').val()
    $this->final_total =$('.dueAmount').val()
    $this->dollar_final_total = $('.dueDollarAmount').val()
    $this->dollar_remaining =$('.change_dollar').val()
    $this->dinar_remaining = $('.change_dinar').val()
    if ($('#due_dollar').val() !== null && $('#due_dollar').val() !== 0) {
        if ($('.dueDollarAmount').val() == 0 && $('#due_dollar').val() !== 0 && $('#due').val() !== 0 && $('.dueAmount').val() != 0) {
            $('.change_dollar').val($('.dueDollarAmount').val() - ($('#due_dollar').val() + ($('#due').val() / getDollarExchange())));
        } else if ($('.dueDollarAmount').val() == 0 && $('.dueAmount').val() !== 0 && $('#due_dollar').val() !== 0 && $('#due').val() != 0) {
            $('.change_dinar').val($('.dueAmount').val() - ($('#due').val() + ($('#due_dollar').val() * getDollarExchange())));
        } else if ($('.change_dinar').val() > 0 && $('.dueDollarAmount').val() !== null && $('.dueDollarAmount').val() !== 0 && $('#due_dollar').val() > $('.dueDollarAmount').val()) {
            var diff_dollar = $('#due_dollar').val() - $('.dueDollarAmount').val();
            $('.change_dinar').val(round250($('.change_dinar').val() - (diff_dollar * getDollarExchange())));
            $('.change_dollar').val(0);
        } else {
            if ($('.dueAmount').val() != 0 && $('.dueDollarAmount').val() == 0 && $('#due').val() == 0) {
                var rounded_final_total = round250($('.dueAmount').val());
                $('.change_dinar').val(round250(rounded_final_total - ($('#due_dollar').val() * getDollarExchange())));
            } else if ($('.dueDollarAmount').val() != 0) {
                $('.change_dollar').val($('.dueDollarAmount').val() - $('#due_dollar').val());
                if ($('.dueAmount').val() != 0) {
                    $('.change_dinar').val(round250($('.dueAmount').val() - $('#due').val()));
                    if ($('.change_dinar').val() < 0 && $('.change_dollar').val() > 0) {
                        var diff_dinar = $('#due').val() - $('.dueAmount').val();
                        $('.change_dollar').val($('.change_dollar').val() - (diff_dinar / getDollarExchange()));
                        $('.change_dinar').val(0);
                    }
                }
            }
        }
    }
    // Function to get dollar exchange rate
    function getDollarExchange() {
        return System.getProperty('dollar_exchange'); // Replace with your actual method to get the exchange rate
    }

    // Function to round to the nearest 250 value
    function round250(value) {
        // Replace with your actual rounding logic
        return Math.round(value / 250) * 250;
    }
});
$(document).on("click", ".add_to_customer_balance", function () {
                    if($('.change_dollar').val() > 0){
                        $('#add_to_customer_balance_dollar').val($('.change_dollar').val());
                    }
                    if($('.change_dinar').val() > 0){
                        $('#add_to_customer_balance_dinnar').val($('.change_dinar').val());
                    }
                       
                        var newDinnarAmount = $('#due').val();
                        var newDollarAmount = $('#due_dollar').val();
                        // Assuming you have a 'received_amount' variable
                        var newReceivedAmount = newAmount - $('.change_dinar').val();
                        var newDollarReceivedAmount = newAmount - $('.change_dollar').val();
                        $('#due').val(newReceivedAmount.toFixed(2));
                        $('#due_dollar').val(newDollarReceivedAmount.toFixed(2));
});

$(document).on("click", ".close , #close_modal_button", function () {
                    $('.add_to_customer_balance').addClass('hide');
                    $('.add_to_customer_balance_in').val('0');
});
</script>

