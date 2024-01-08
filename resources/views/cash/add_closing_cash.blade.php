<div class="modal-dialog modal-lg add_closing_cash " role="document" >
    <div class="modal-content">
        {!! Form::open([
           'url' => route('cash.save-add-closing-cash'),
            'method' => 'post',
            'id' => 'add_closing_cash_form',
            'files' => true,
            'class' => 'add_closing_cash_form_class',
        ]) !!}

        <div class="modal-header">

            <h4 class="modal-title">@lang('lang.add_closing_cash')</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
            <div class="col-md-12">
                <div class="well">
                    <table class="table">
                        <tr>
                            <td><b>@lang('lang.date_and_time')</b></td>
                            <td>{{ $cash_register->created_at ? \Carbon\Carbon::parse($cash_register->created_at)->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.cash_in')</b></td>
                            <td>{{ @num_format($cash_register->dinar_total_cash_in) }} </td>
                            <td>{{ @num_format($cash_register->dollar_total_cash_in) }} $</td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.cash_out')</b></td>
                            <td>{{ @num_format($cash_register->dinar_total_cash_out) }}</td>
                            <td>{{ @num_format($cash_register->dollar_total_cash_out) }} $</td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.total_card_sale')</b></td>
                            <td>{{ @num_format($cash_register->dinar_total_card_sales) }}</td>
                            <td>{{ @num_format($cash_register->dollar_total_card_sales) }} $</td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.total_cheque_sale')</b></td>
                            <td>{{ @num_format($cash_register->dinar_total_cheque_sales) }}</td>
                            <td>{{ @num_format($cash_register->dollar_total_cheque_sales) }} $</td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.total_bank_transfer_sale')</b></td>
                            <td>{{ @num_format($cash_register->dinar_total_bank_transfer_sales) }}</td>
                            <td>{{ @num_format($cash_register->dollar_total_bank_transfer_sales) }} $</td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.total_gift_card_sale')</b></td>
                            <td>{{ @num_format($cash_register->dinar_total_gift_card_sales) }}</td>
                            <td>{{ @num_format($cash_register->dollar_total_gift_card_sales) }} $</td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.other_cash_sales')</b></td>
                            <td>
                                @if(($cash_register->dinar_total_cash_sales )>0)
                                    {{ @num_format($cash_register->dinar_total_cash_sales - $cash_register->dinar_total_latest_payments) }}
                                @else
                                    {{ @num_format($cash_register->dinar_total_cash_sales ) }}
                                @endif
                            </td>
                            <td>
                                @if(($cash_register->dollar_total_cash_sales )>0)
                                    {{ @num_format($cash_register->dollar_total_cash_sales - $cash_register->dollar_total_latest_payments) }}
                                @else
                                    {{ @num_format($cash_register->dollar_total_cash_sales ) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.total_cash_sale')</b></td>
                            <td>
                                @if($cash_register->dinar_total_cash_sales>0)
                                    {{ @num_format($cash_register->dinar_total_cash_sales - $cash_register->dinar_total_latest_payments) }}
                                @else
                                    {{ @num_format($cash_register->dinar_total_cash_sales) }}
                                @endif
                            </td>
                            <td>
                                @if($cash_register->dollar_total_cash_sales>0)
                                    {{ @num_format($cash_register->dollar_total_cash_sales-$cash_register->dollar_total_latest_payments) }}
                                @else
                                    {{ @num_format($cash_register->dollar_total_cash_sales) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
{{--                            @dd($cash_register->dinar_total_sale,$cash_register->dollar_total_sale)--}}
                            <td><b>@lang('lang.total_sales')</b></td>
                            <td>
                                @if(($cash_register->dinar_total_sale - $cash_register->total_refund) > 0)
                                    {{ @num_format($cash_register->dinar_total_sale - $cash_register->dinar_total_refund - $cash_register->dinar_total_latest_payments) }}
                                @else
                                    {{ @num_format($cash_register->dinar_total_sale - $cash_register->dinar_total_refund) }}
                                @endif
                            </td>
                            <td>
                                @if($cash_register->dollar_total_sale - $cash_register->dollar_total_refund>0)
                                    {{ @num_format($cash_register->dollar_total_sale - $cash_register->dollar_total_refund - $cash_register->dollar_total_latest_payments) }}
                                @else
                                    {{ @num_format($cash_register->dollar_total_sale - $cash_register->dollar_total_refund) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.total_latest_payments')</b></td>
                            <td>{{ @num_format($cash_register->dinar_total_latest_payments) }}</td>
                            <td>{{ @num_format($cash_register->dollar_total_latest_payments) }}</td>
{{--                            @if(!empty($cash_register->total_latest_payments) && $cash_register->total_latest_payments>0)--}}
{{--                                <td><a data-href="{{action('CashController@showLatestPaymentDetails', $cash_register_id)}}"--}}
{{--                                       data-container=".view_modal" class="btn btn-modal btn-danger text-white close_cash"><i--}}
{{--                                            class="fa fa-eye"></i> @lang('lang.view')</a></td>--}}
{{--                            @endif--}}
                        </tr>
                        <tr>
                            <td><b>@lang('lang.return_sales')</b></td>
                            <td>{{ @num_format($cash_register->dinar_total_sell_return) }}</td>
                            <td>{{ @num_format($cash_register->dollar_total_sell_return) }}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.purchases')</b></td>
                            <td>{{ @num_format($cash_register->dinar_total_purchases) }}</td>
                            <td>{{ @num_format($cash_register->dollar_total_purchases) }}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.expenses')</b></td>
                            <td>{{ @num_format($cash_register->dinar_total_expenses) }}</td>
                            <td>{{ @num_format($cash_register->dollar_total_expenses) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12">
                    <button type="button" id="print-closing-cash-btn" data-cash_register_id="{{ $cash_register_id }}"
                            class="btn btn-primary pull-right">@lang('lang.print')</button>
                </div>
            </div>
            <br>
            <br>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('current_cash', __('lang.current_cash') . ':*') !!}
                            {!! Form::text('current_cash', @num_format($total_cash), [
                                'class' => 'form-control',
                                'placeholder' => __('lang.current_cash'),
                                'readonly',
                                'id' => 'closing_current_cash',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('current_cash', __('lang.current_cash') . '$ :*') !!}
                            {!! Form::text('current_cash', @num_format($dollar_total_cash), [
                                'class' => 'form-control',
                                'placeholder' => __('lang.current_cash'),
                                'readonly',
                                'id' => 'closing_current_cash',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('amount', __('lang.amount') . ':*') !!}
                            {!! Form::text('amount', null, [
                                'class' => 'form-control',
                                'placeholder' => __('lang.amount'),
                                'required',
                                'id' => 'closing_amount',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('amount', __('lang.amount') . '$ :*') !!}
                            {!! Form::text('dollar_amount', null, [
                                'class' => 'form-control',
                                'placeholder' => __('lang.amount').' $',
                                'required',
                                'id' => 'closing_dollar_amount',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('source_type', __('lang.given_to', ['value' => __('lang.user')]), ['id' => 'source_type_label']) !!} <br>
                            {!! Form::select('source_type', ['user' => __('lang.user'), 'safe' => __('lang.safe')], 'user', [
                                'class' => 'form-control',
                                'required',
                                'data-live-search' => 'true',
                                'style' => 'width: 80%',
                                'placeholder' => __('lang.please_select'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('cash_given_to', __('lang.cash_given_to') . ':*') !!}
                            {!! Form::select('cash_given_to', $users, false, [
                                'class' => 'form-control selectpicker',
                                'data-live-search' => 'true',
                                'required',
                                'placeholder' => __('lang.please_select'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('discrepancy', __('lang.discrepancy') . ':*') !!}
                            {!! Form::text('discrepancy', 0, [
                                'class' => 'form-control',
                                'placeholder' => __('lang.discrepancy'),
                                'required',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('discrepancy', __('lang.discrepancy') . '$ :*') !!}
                            {!! Form::text('dollar_discrepancy', 0, [
                                'class' => 'form-control',
                                'placeholder' => __('lang.discrepancy').' $',
                                'required',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('notes', __('lang.notes'), []) !!}
                            {!! Form::textarea('notes', null, ['class' => 'form-control', 'placeholder' => __('lang.notes'), 'rows' => 3]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="cash_register_id" value="{{ $cash_register_id }}">
        </div>

        <div class="modal-footer">
            <button type="submit" name="submit" class="btn btn-primary hide" value="adjustment"
                    id="adjust-btn">@lang('lang.adjustment')</button>
            <button type="submit" name="submit" class="btn btn-primary" value="save"
                    id="closing-save-btn">@lang('lang.save')</button>
            <button type="button"
                    class="btn btn-default @if ($type == 'logout') close-btn-add-closing-cash @endif"
                    @if ($type != 'logout') data-dismiss="modal" @endif>@lang('lang.close')</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $('.selectpicker').selectpicker('render');
    $(document).on('change', '#closing_amount', function() {
        let amount = __read_number($(this));
        let current_cash = __read_number($('#closing_current_cash'));

        let discrepancy = amount - current_cash;

        $('#discrepancy').val(discrepancy);

        if (discrepancy !== 0) {
            $('#adjust-btn').removeClass('hide');
        } else {
            $('#adjust-btn').addClass('hide');
        }

    });
    $('#source_type').change();
    $(document).on('change', '#source_type', function() {
        var selectedValue = $('#source_type').find(":selected").val();
        if (selectedValue == "safe") {
            var langKey = "@lang('lang.given_to') (@lang('lang.safe'))";
        } else if (selectedValue == "user") {
            var langKey = "@lang('lang.given_to') (@lang('lang.user'))";

        } else {
            var langKey = "@lang('lang.given_to')";
        }
        $('#source_type_label').html(langKey);

        if ($(this).val() !== '') {
            $.ajax({
                method: 'get',
                url: '/add-stock/get-source-by-type-dropdown/' + $(this).val(),
                data: {},
                success: function(result) {
                    $("#cash_given_to").empty().append(result);
                    $("#cash_given_to").selectpicker("refresh");
                },
            });
        }
    });
    $(document).on('click', '#adjust-btn', function(e) {
        e.preventDefault();
        var title = "{!! __('lang.are_you_sure') !!}";
        Swal.fire({
            title: title,
            text: "{!! __('lang.are_you_sure_you_wanna_update_it') !!}",
            icon: 'warning',
        }).then(willDelete => {
            if (willDelete) {
                // var check_password = $(this).data('check_password');
                var href = $(this).data('href');
                var data = $(this).serialize();

                Swal.fire({
                    title: "{!! __('lang.please_enter_your_password') !!}",
                    input: 'password',
                    inputAttributes: {
                        placeholder: "{!! __('lang.type_your_password') !!}",
                        autocomplete: 'off',
                        autofocus: true,
                    },
                }).then((result) => {
                    if (result) {
                        $.ajax({
                            url: '{{ route('check_password') }}',
                            method: 'POST',
                            data: {
                                value: result,
                            },
                            dataType: 'json',
                            success: (data) => {

                                if (data.success == true) {
                                    $('#add_closing_cash_form').submit();

                                    Swal.fire(
                                        'success',
                                        "{!! __('lang.correct_password') !!}",
                                        'success'
                                    );


                                } else {
                                    Swal.fire(
                                        'Failed!',
                                        'Wrong Password!',
                                        'error'
                                    )

                                }
                            }
                        });
                    }
                });
            }
        });
    });
    $(document).ready(function() {
        $('#add_closing_cash_form').submit(function(e) {
            e.preventDefault();
            $(this).validate();
            $.ajax({
                type: 'POST', // or 'GET' depending on your form's method
                url: "{{ url('cash/save-add-closing-cash') }}",
                data: $('#add_closing_cash_form').serialize(), // Serialize the form data
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'success',
                            response.msg,
                            'success'
                        );
                        location.reload();
                    } else {
                        Swal.fire(
                            'Failed!',
                            response.msg,
                            'error'
                        )
                        // location.reload();
                    }

                }
            });
        });
    });
</script>
