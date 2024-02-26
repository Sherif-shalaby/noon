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
                            <input type="text" class="form-control dueAmount" name="dueAmount" value="{{ @num_format($dueAmount) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job_title">@lang('lang.due')</label>
                            <input type="text" class="form-control dueDollarAmount"  name="dueDollarAmount" value="{{ @num_format($dueDollarAmount) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job_title">@lang('lang.pay')</label>
                            <input type="text" class="form-control" name="due"  id="due" value="{{ @num_format($dueAmount) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job_title">@lang('lang.pay_dollar')</label>
                            <input type="text" class="form-control" name="due_dollar" id="due_dollar"  value="{{ @num_uf($dueDollarAmount) }}">
                        </div>
                    </div>
                    <div class="col-md-6" id="dueDate" hidden>
                        <label for="dueDate">Due Date:</label>
                        <input type="date" name="due_date" class="form-control" >
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
$(document).ready(function () {
    // Your code here

    var dollarExchange = {{ $dollarExchange }};
    var inputdueValue = $('#due').val();
    if (inputdueValue !== undefined) {
        var initialAmount = parseFloat(inputdueValue.replace(',', ''));
        console.log(initialAmount);
        // Rest of your code using initialAmount
    } else {
        console.error("Error: The element with id 'due' does not exist or is undefined.");
    }
    // $('#due').on('change', function () {
    //     var newAmount = parseFloat($(this).val().replace(',', ''));
    //     // console.log('newAmount'+newAmount);
    //     // console.log('initialAmount'+initialAmount);
    //     if (!isNaN(newAmount) && newAmount > initialAmount) {
    //         var change = Math.abs(newAmount - initialAmount);
    //                 $(".add_to_customer_balance").removeAttr("hidden");
    //                 $(".change_dinar_div").removeAttr("hidden");
    //                 $('.change_dinar').text(change.toFixed(2));
    //                 $('.change_dinar').val(change.toFixed(2)); // Update the change value

    //     }
    // });
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
        console.log(newDollarAmount);
        if(newDollarAmount < $('.dueDollarAmount').val()){
            $("#dueDate").removeAttr("hidden");
        }
        $('#due_dollar').val(newDollarAmount);
        // console.log('newAmount'+newAmount);
        // console.log('inputduedollarValue'+inputduedollarValue);
        // if (!isNaN(newDollarAmount) && newDollarAmount > inputduedollarValue) {
        //     var change_dollar = Math.abs(newDollarAmount - inputduedollarValue);
        //             $(".add_to_customer_balance").removeAttr("hidden");
        //             $(".change_dollar_div").removeAttr("hidden");
        //             $('.change_dollar').text(change_dollar.toFixed(2));
        //             $('.change_dollar').val(change_dollar.toFixed(2)); // Update the change value

        // }else if (!isNaN(newDollarAmount) && newDollarAmount < inputduedollarValue){
        //     $('.change_text').text("Pending Amount :");

            // $this->dollar_amount = $('#due_dollar').val()
            // $this->amount = $('#due').val()
            // $this->final_total =$('.dueAmount').val()
            // $this->dollar_final_total = $('.dueDollarAmount').val()
            // $this->dollar_remaining =$('.change_dollar').val()
            // $this->dinar_remaining = $('.change_dinar').val()
            if ($('#due_dollar').val() !== null && $('#due_dollar').val() !== 0) {
                console.log(1);
                if ($('.dueDollarAmount').val() == 0 && $('#due_dollar').val() !== 0 && $('#due').val() !== 0 && $('.dueAmount').val() != 0) {
                    console.log(2);
                    $('.change_dollar').val($('.dueDollarAmount').val() - ($('#due_dollar').val() + ($('#due').val() / dollarExchange)));
                } else if ($('.dueDollarAmount').val() == 0 && $('.dueAmount').val() !== 0 && $('#due_dollar').val() !== 0 && $('#due').val() != 0) {
                    console.log(3);
                    $('.change_dinar').val($('.dueAmount').val() - ($('#due').val() + ($('#due_dollar').val() * dollarExchange)));
                } else if ($('.change_dinar').val() > 0 && $('.dueDollarAmount').val() !== null && $('.dueDollarAmount').val() !== 0 && $('#due_dollar').val() > $('.dueDollarAmount').val()) {
                    console.log(4);
                    var diff_dollar = $('#due_dollar').val() - $('.dueDollarAmount').val();
                    $('.change_dinar').val(round250($('.change_dinar').val() - (diff_dollar * dollarExchange)));
                    $('.change_dollar').val(0);
                } else {
                    console.log(5);
                    if ($('.dueAmount').val() != 0 && $('.dueDollarAmount').val() == 0 && $('#due').val() == 0) {
                        console.log(6);
                        var rounded_final_total = round250($('.dueAmount').val());
                        $('.change_dinar').val(round250(rounded_final_total - ($('#due_dollar').val() * dollarExchange)));
                    } else if ($('.dueDollarAmount').val() != 0) {
                        console.log(7);
                        $('.change_dollar').val($('.dueDollarAmount').val() - $('#due_dollar').val());
                        console.log($('.change_dollar').val());
                        if ($('.dueAmount').val() != 0) {
                            console.log(8);
                            $('.change_dinar').val(round250($('.dueAmount').val() - $('#due').val()));
                            if ($('.change_dinar').val() < 0 && $('.change_dollar').val() > 0) {
                                console.log(9);
                                var diff_dinar = $('#due').val() - $('.dueAmount').val();
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
    $('#due').on('change', function (){
        var inputValue = $(this).val();
        var newAmount = parseFloat(inputValue.replace(',', ''));
        if(newAmount < $('.dueAmount').val()){
            $("#dueDate").removeAttr("hidden");
        }
        // Check if the conversion was successful
        if (!isNaN(newAmount)) {

                var newAmount = parseFloat($(this).val().replace(',', ''));
                console.log(dollarExchange);
                if ($('#due').val() !== null && $('#due').val() !== 0) {
                    if ($('.dueAmount').val() == 0 && $('.dueDollarAmount').val() !== 0 && $('#due_dollar').val() !== 0 && $('#due').val() != 0) {
                        $('.change_dollar').val($('.dueDollarAmount').val() - ($('#due_dollar').val() + ($('#due').val() / dollarExchange)));
                    } else if ($('.dueDollarAmount').val() == 0 && $('.dueAmount').val() !== 0 && $('#due_dollar').val() !== 0 && $('#due').val() != 0) {
                        $('.change_dinar').val($('.dueAmount').val() - ($('#due').val() + ($('#due_dollar').val() * dollarExchange)));
                    } else if ($('.change_dollar').val() > 0 && $('.dueAmount').val() !== null && $('.dueAmount').val() !== 0 && $('#due').val() > $('.dueAmount').val()) {
                        var diff_dinar = $('#due').val() - $('.dueAmount').val();
                        $('.change_dollar').val($('.change_dollar').val() - (diff_dinar / dollarExchange));
                        $('.change_dinar').val(0);
                    } else {
                        if ($('.dueDollarAmount').val() != 0 && $('.dueAmount').val() == 0 && $('#due_dollar').val() == 0) {
                            $('.change_dollar').val($('.dueDollarAmount').val() - ($('#due').val() / dollarExchange));
                        } else if ($('.dueAmount').val() != 0) {
                            $('.change_dinar').val(round_250($('.dueAmount').val()) - $('#due').val());

                            if ($('.dueDollarAmount').val() != 0) {
                                $('.change_dollar').val($('.dueDollarAmount').val() - $('#due_dollar').val());
                                if ($('.change_dollar').val() < 0 && $('.change_dinar').val() > 0) {
                                    var diff_dollar = $('#due_dollar').val() - $('.dueDollarAmount').val();
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


    $(document).on("click", ".close , #close_modal_button", function () {
                        $('.add_to_customer_balance').addClass('hide');
                        $('.add_to_customer_balance_in').val('0');
    });
});
$(document).on("click", ".add_to_customer_balance", function () {
        if ($('.change_dollar').val() < 0) {
            $('#add_to_customer_balance_dollar').val($('.change_dollar').val());
        }
        if ($('.change_dinar').val() < 0) {
            $('#add_to_customer_balance_dinnar').val($('.change_dinar').val());
        }

        // var newDinnarAmount = parseFloat($('.dueAmount').val()); // Convert to number, default to 0 if conversion fails
        // var newDollarAmount = parseFloat($('.dueDollarAmount').val());
        // // Assuming you have a 'received_amount' variable
        // var newReceivedAmount = newDinnarAmount + parseFloat($('.change_dinar').val());
        // var newDollarReceivedAmount = newDollarAmount + parseFloat($('.change_dollar').val());

        // console.log('newDinnarAmount' + newDinnarAmount);
        // console.log('newDollarAmount' + newDollarAmount);
        // console.log('newReceivedAmount' + newReceivedAmount);
        // console.log('newDollarReceivedAmount' + newDollarReceivedAmount);

        // $('#due').val(newReceivedAmount.toFixed(2));
        // $('#due_dollar').val(newDollarReceivedAmount.toFixed(2));
    });

</script>

