@extends('layouts.app')
@section('title', __('lang.add_wages'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.add_wages')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('wages.index') }}">@lang('lang.wages')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.add_wages')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('wages.index')}}" class="btn btn-primary">
                        @lang('lang.wages')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start row -->
    <div class="row d-flex justify-content-center">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">
                {!! Form::open([
                    'route' => 'wages.store',
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ]) !!}
                <div class="container-fluid">
                    <div class="row pt-5">
                        {{-- +++++++++++++++++ employee_id +++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('employee_id', __('lang.employee') . ':*') !!}
                                {!! Form::select('employee_id', $employees, null, [
                                    'class' => 'form-control select2',
                                    'required',
                                    'placeholder' => __('lang.please_select'),
                                ]) !!}
                                @error('employee_id')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        {{-- +++++++++++++++++ طريقة الدفع +++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('payment_type', __('lang.wage_payment_type') . ':*') !!}
                                {!! Form::select('payment_type', $payment_types, null, [
                                    'class' => 'form-control select2',
                                    'required',
                                    'placeholder' => __('lang.please_select'),
                                ]) !!}
                                @error('payment_type')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        {{-- +++++++++++++++++ مدفوعات اخري (المبلغ) +++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('other_payment', __('lang.other_payment')) !!}
                                {!! Form::text('other_payment', null, [
                                    'class' => 'form-control', 'id' => 'other_payment',
                                ]) !!}
                                <span id="otherPaymentResult"></span> <!-- New span element for displaying the result -->
                                @error('other_payment')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        {{-- +++++++++++++++++ account_period +++++++++++++++++ --}}
                        <div class="col-md-4 account_period">
                            <div class="form-group">
                                <label for="account_period">@lang('lang.account_period')</label>
                                {!! Form::month('account_period', null, [
                                    'class' => 'form-control',
                                    'placeholder' => __('lang.account_period'),
                                    'id' => 'account_period',
                                ]) !!}
                            </div>
                        </div>
                        {{-- +++++++++++++++++ acount_period_start_date +++++++++++++++++ --}}
                        <div class="col-md-4 account_period">
                            <div class="form-group">
                                <label for="acount_period_start_date">@lang('lang.acount_period_start_date')</label>
                                {!! Form::text('acount_period_start_date', null, [
                                    'class' => 'form-control  datepicker calculate_salary',
                                    'placeholder' => __('lang.acount_period_start_date'),
                                    'id' => 'acount_period_start_date',
                                ]) !!}
                            </div>
                        </div>
                        {{-- +++++++++++++++++ acount_period_end_date +++++++++++++++++ --}}
                        <div class="col-md-4 account_period">
                            <div class="form-group">
                                <label for="acount_period_end_date">@lang('lang.acount_period_end_date')</label>
                                {!! Form::text('acount_period_end_date', null, [
                                    'class' => 'form-control datepicker calculate_salary',
                                    'placeholder' => __('lang.acount_period_end_date'),
                                    'id' => 'acount_period_end_date',
                                ]) !!}
                            </div>
                        </div>
                        {{-- ============= deductibles :  الخصومات ============= --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="deductibles">@lang('lang.deductibles')</label>
                                {!! Form::text('deductibles', null, ['class' => 'form-control', 'placeholder' => __('lang.deductibles'), 'id' => 'deductibles']) !!}
                            </div>
                        </div>
                        {{-- ============= reasons_of_deductibles : أسباب الخصومات ============= --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reasons_of_deductibles">@lang('lang.reasons_of_deductibles')</label>
                                {!! Form::text('reasons_of_deductibles', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('lang.reasons_of_deductibles')]) !!}
                            </div>
                        </div>
                        {{-- ============= increases :  الزيادات ============= --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="increases">@lang('lang.increases')</label>
                                {!! Form::text('increases', null, ['class' => 'form-control', 'placeholder' => __('lang.increases'), 'id' => 'increases']) !!}
                            </div>
                        </div>
                        {{-- ============= reasons_of_increases : أسباب الزيادات ============= --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reasons_of_increases">@lang('lang.reasons_of_increases')</label>
                                {!! Form::text('reasons_of_increases', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('lang.reasons_of_increases')]) !!}
                            </div>
                        </div>
                        {{-- ============= net_amount : الصافي ============= --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="net_amount">@lang('lang.net_amount')</label>
                                {!! Form::text('net_amount', null, ['class' => 'form-control', 'placeholder' => __('lang.net_amount'), 'id' => 'net_amount']) !!}
                            </div>
                        </div>
                        <input type="hidden" name="amount" id="amount">
                        {{-- ============= payment_date : تاريخ السداد ============= --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="payment_date">@lang('lang.payment_date')</label>
                                {!! Form::text('payment_date', @format_date(date('Y-m-d')), ['class' => 'form-control datepicker', 'placeholder' => __('lang.payment_date')]) !!}
                            </div>
                        </div>
                        {{-- ++++++++++++++++++++ source_type +++++++++++++++++  --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('source_type', __('lang.wage_source_type'), []) !!} <br>
                                {!! Form::select('source_type', ['user' => __('lang.user'), 'pos' => __('lang.pos') , 'safe' => __('lang.safe')], null,
                                                                ['class' => 'select2 form-control','placeholder' => __('lang.please_select')]) !!}
                            </div>
                        </div>
                        {{-- ++++++++++++++++ اسم الموظف ++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('source_of_payment', __('lang.wage_source_of_payment'), []) !!} <br>
                                {!! Form::select('source_id',[], null, ['class' => 'select2 form-control', 'placeholder' => __('lang.please_select'), 'id' => 'source_id', 'required']) !!}
                            </div>
                        </div>
                        {{-- ++++++++++++++++++ upload_files ++++++++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="upload_files">@lang('lang.upload_files')</label>
                                {!! Form::file('upload_files[]', ['class' => 'form-control', 'multiple']) !!}
                            </div>
                        </div>
                        {{-- ++++++++++++++++++ notes ++++++++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('notes', __('lang.notes')) !!}
                                {!! Form::textarea('notes', null, [
                                    'class' => 'form-control','rows' => '3',
                                ]) !!}
                                @error('notes')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/product/wage.js') }}"></script>
    {{-- ++++++++++++++++ Ajax Request ++++++++++++++++ --}}
    {{-- get "other_payment" according to "employee_id" , "payment_type" --}}
    <script>
        $(document).ready(function()
        {
            // Event handler for employee_id dropdown change
            $('#employee_id').on('change', function()
            {
                updateOtherPayment();
            });

            // Event handler for payment_type dropdown change
            $('#payment_type').on('change', function()
            {
                updateOtherPayment();

            });
            // ++++++++++ updateOtherPayment() +++++++++++++
            function updateOtherPayment()
            {
                var employeeId = $('#employee_id').val();
                var paymentType = $('#payment_type').val();
                // Make an AJAX request to fetch other_payment based on employee_id and payment_type
                $.ajax({
                    url: '{{ route('update_other_payment') }}', // Using the named route
                    type: 'POST',
                    data: {
                        employee_id: employeeId,
                        payment_type: paymentType
                    },
                    success: function(response) {
                        console.log(response.other_payment);
                        // Update the other_payment field with the fetched value
                        $('#other_payment').val(response.other_payment);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
            // +++++++++++++++++ Calculate "net_value" : When Change "الخصومات" +++++++++++++++++
            // $('#deductibles').on('keyup', function()
            // {
            //     // console.log("keyup keyup keyup keyup");
            //     let deductibles = parseFloat($('#deductibles').val());
            //     let other_payment = parseFloat($('#other_payment').val());
            //     let net_val = 0.00 ;
            //     if ( $('#deductibles').val() != '' && $('#deductibles').val() != undefined )
            //     {
            //         net_val = other_payment - deductibles;
            //         $('#net_amount').val(net_val);
            //     }
            //     else
            //     {
            //         $('#net_amount').val(other_payment);
            //     }
            // })
            // +++++++++++++++++ Calculate "salary" : When Change "الراتب" +++++++++++++++++
            $('#other_payment').on('change', function()
            {
                net_salary();
            })
            // +++++++++++++++++ Calculate "increases" : When Change "الزيادات" +++++++++++++++++
            $('#increases').on('change', function()
            {
                net_salary();
            })
            // +++++++++++++++++ Calculate "deductibles" : When Change "الخصومات" +++++++++++++++++
            $('#deductibles').on('change', function()
            {
                net_salary();
            })
            // ++++++++++++++++++++++++ net_salary ++++++++++++++++++++++++++++
            function net_salary()
            {
                let deductibles = parseFloat($('#deductibles').val());
                let increases = parseFloat($('#increases').val());
                let other_payment = parseFloat($('#other_payment').val());

                if ( !isNaN(deductibles) && !isNaN(other_payment) && !isNaN(increases) )
                {
                    let netAmount = (other_payment + increases) - deductibles;
                    $('#net_amount').val(netAmount);
                    console.log(netAmount);
                }
                else if (!isNaN(deductibles) && !isNaN(other_payment) && isNaN(increases))
                {
                    let netAmount = other_payment - deductibles;
                    $('#net_amount').val(netAmount);
                    console.log(netAmount);
                }
                else if (deductibles !== '' && deductibles !== undefined && isNaN(other_payment) && isNaN(increases) )
                {
                    netAmount = -deductibles;
                    $('#net_amount').val(netAmount);
                    console.log(netAmount);
                }
                else
                {
                    netAmount = other_payment;
                    $('#net_amount').val(netAmount);
                    console.log(netAmount);
                }
            }
            // +++++++++++++++++ Get "مصدر الاموال" depending on "طريقة الدفع" +++++++++++++++++
            $('#source_type').change(function() {
            if ($(this).val() !== '') {
                $.ajax({
                    method: 'get',
                    url: '/wage/get-source-by-type-dropdown/' + $(this).val(),
                    data: {},
                    success: function(result) {
                        $("#source_id").empty().append(result);
                        $("#source_id").selectpicker("refresh");
                    },
                });
            }
        });
        });
    </script>

@endpush
