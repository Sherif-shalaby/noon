@extends('layouts.app')
@section('title', __('lang.add_wages'))

@push('css')
    <style>
        . {
            width: 100% !important
        }

        @media(min-width:768px) {
            . {
                width: 25% !important
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.add_wages')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('wages.index') }}">/
            @lang('lang.wages')</a></li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.add_wages')</li>
@endsection

@section('button')
    <div class="widgetbar  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a href="{{ route('wages.index') }}" class="btn btn-primary">
            @lang('lang.wages')
        </a>
    </div>
@endsection

@section('content')
    <!-- Start row -->
    <div class="animate-in-page">

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
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {{-- +++++++++++++++++ employee_id +++++++++++++++++ --}}
                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.1s">
                                {!! Form::label('employee_id', __('lang.employee') . '*', [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 ' : 'mx-2 mb-0 ',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper">
                                    {!! Form::select('employee_id', $employees, null, [
                                        'class' => 'form-control selectpicker',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'employee_id', // Add an id to the employee select for easier identification in JavaScript
                                    ]) !!}
                                </div>
                                @error('employee_id')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            {{-- +++++++++++++++++ طريقة الدفع +++++++++++++++++ --}}
                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.15s">
                                {!! Form::label('payment_type', __('lang.wage_payment_type') . '*', [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 ' : 'mx-2 mb-0 ',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper">
                                    {!! Form::select('payment_type', $payment_types, null, [
                                        'class' => 'select2 form-control',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'payment_type',
                                    ]) !!}
                                </div>
                                @error('payment_type')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            {{-- +++++++++++++++++ مدفوعات اخري (المبلغ) +++++++++++++++++ --}}
                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.2s">
                                {!! Form::label('other_payment', __('lang.other_payment'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 ' : 'mx-2 mb-0 ',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper">
                                    {!! Form::text('other_payment', null, [
                                        'class' => 'form-control initial-balance-input m-auto width-full',
                                        'id' => 'other_payment',
                                    ]) !!}
                                </div>
                                <span id="otherPaymentResult"></span>
                                <!-- New span element for displaying the result -->
                                @error('other_payment')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.25s">
                                <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                                    style='font-size: 12px;font-weight: 500;' for="payment_cycle">@lang('lang.select_payment_cycle')</label>
                                <div class="input-wrapper">
                                    {!! Form::select('payment_cycle', [], null, [
                                        'class' => 'form-control select2',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'payment_cycle',
                                    ]) !!}
                                </div>
                            </div>

                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.3s">
                                <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                                    style='font-size: 12px;font-weight: 500;'
                                    for="acount_period_start_date">@lang('lang.acount_period_start_date')</label>
                                <div class="input-wrapper">
                                    {!! Form::text('acount_period_start_date', null, [
                                        'class' => 'form-control initial-balance-input m-auto width-full datepicker ',
                                        'placeholder' => __('lang.acount_period_start_date'),
                                        'id' => 'acount_period_start_date',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.35s">
                                <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                                    style='font-size: 12px;font-weight: 500;'
                                    for="acount_period_end_date">@lang('lang.acount_period_end_date')</label>
                                <div class="input-wrapper">
                                    {!! Form::text('acount_period_end_date', null, [
                                        'class' => 'form-control initial-balance-input m-auto width-full datepicker ',
                                        'placeholder' => __('lang.acount_period_end_date'),
                                        'id' => 'acount_period_end_date',
                                    ]) !!}
                                </div>
                            </div>


                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.4s">
                                <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 ",
                                    style='font-size: 12px;font-weight: 500;' for="deductibles">@lang('lang.deductibles')</label>
                                <div class="input-wrapper">

                                    {!! Form::text('deductibles', null, [
                                        'class' => 'form-control  initial-balance-input m-auto width-full',
                                        'placeholder' => __('lang.deductibles'),
                                        'id' => 'deductibles',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.45s">
                                <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                                    style='font-size: 12px;font-weight: 500;'
                                    for="reasons_of_deductibles">@lang('lang.reasons_of_deductibles')</label>
                                <div class="input-wrapper">

                                    {!! Form::text('reasons_of_deductibles', null, [
                                        'class' => 'form-control  initial-balance-input m-auto width-full',
                                        'rows' => 3,
                                        'placeholder' => __('lang.reasons_of_deductibles'),
                                    ]) !!}
                                </div>
                            </div>
                            {{-- ============= increases :  الزيادات ============= --}}
                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.5s">
                                <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                                    style='font-size: 12px;font-weight: 500;' for="increases">@lang('lang.increases')</label>
                                <div class="input-wrapper">

                                    {!! Form::text('increases', null, [
                                        'class' => 'form-control initial-balance-input m-auto width-full',
                                        'placeholder' => __('lang.increases'),
                                        'id' => 'increases',
                                    ]) !!}
                                </div>
                            </div>
                            {{-- ============= reasons_of_increases : أسباب الزيادات ============= --}}
                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.55s">
                                <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                                    style='font-size: 12px;font-weight: 500;'
                                    for="reasons_of_increases">@lang('lang.reasons_of_increases')</label>
                                <div class="input-wrapper">

                                    {!! Form::text('reasons_of_increases', null, [
                                        'class' => 'form-control initial-balance-input m-auto width-full',
                                        'rows' => 3,
                                        'placeholder' => __('lang.reasons_of_increases'),
                                    ]) !!}
                                </div>
                            </div>
                            {{-- ============= net_amount : الصافي ============= --}}
                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.6s">
                                <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 "
                                    style='font-size: 12px;font-weight: 500;' for="net_amount">@lang('lang.net_amount')</label>
                                <div class="input-wrapper">

                                    {!! Form::text('net_amount', null, [
                                        'class' => 'form-control  initial-balance-input m-auto width-full',
                                        'placeholder' => __('lang.net_amount'),
                                        'id' => 'net_amount',
                                    ]) !!}
                                </div>
                            </div>
                            <input type="hidden" name="amount" id="amount">
                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.65s">
                                <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 ",
                                    style='font-size: 12px;font-weight: 500;' for="payment_date">@lang('lang.payment_date')</label>
                                <div class="input-wrapper">

                                    {!! Form::text('payment_date', @format_date(date('Y-m-d')), [
                                        'class' => 'form-control datepicker  initial-balance-input m-auto width-full',
                                        'placeholder' => __('lang.payment_date'),
                                    ]) !!}
                                </div>
                            </div>
                            {{-- ++++++++++++++++++++ source_type +++++++++++++++++  --}}
                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.7s">
                                {!! Form::label('source_type', __('lang.wage_source_type'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 ' : 'mx-2 mb-0 ',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper">

                                    {!! Form::select(
                                        'source_type',
                                        ['user' => __('lang.user'), 'pos' => __('lang.pos'), 'safe' => __('lang.safe')],
                                        null,
                                        ['class' => 'selectpicker form-control', 'placeholder' => __('lang.please_select')],
                                    ) !!}
                                </div>
                            </div>
                            {{-- ++++++++++++++++ اسم الموظف ++++++++++ --}}
                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.75s">
                                {!! Form::label('source_of_payment', __('lang.wage_source_of_payment'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 ' : 'mx-2 mb-0 ',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper">

                                    {!! Form::select('source_id', [], null, [
                                        'class' => 'selectpicker form-control',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'source_id',
                                        'required',
                                    ]) !!}
                                </div>
                            </div>
                            {{-- ++++++++++++++++++ upload_files ++++++++++++++++++++++++ --}}
                            <div class="col-6 mb-2 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.8s">
                                <label class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 ",
                                    style='font-size: 12px;font-weight: 500;' for="upload_files">@lang('lang.upload_files')</label>
                                <div class="input-wrapper">
                                    {!! Form::file('upload_files[]', [
                                        'class' => 'form-control  initial-balance-input m-auto width-full',
                                        'multiple',
                                    ]) !!}
                                </div>
                            </div>
                            {{-- ++++++++++++++++++ notes ++++++++++++++++++++++++ --}}
                            <div class="col-8 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                style="animation-delay: 1.85s">
                                {!! Form::label('notes', __('lang.notes'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 ' : 'mx-2 mb-0 ',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="width-full" style="height: 100px;border-radius: 9px">
                                    {!! Form::textarea('notes', null, [
                                        'class' => 'form-control',
                                        'style' => ' width: 100%;height:100%;background-color:#dedede',
                                    ]) !!}
                                </div>
                                @error('notes')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="row animate__animated animate__bounceInLeft" style="animation-delay: 1.9s">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/product/wage.js') }}"></script>
    <script>
        $(document).ready(function() {
            // ++++++++++++++++ get "other_payment" according to "employee_id" , "payment_type" ++++++++++++++++ --}}
            // Event handler for employee_id dropdown change
            $('#employee_id').on('change', function() {
                var employeeId = $('#employee_id').val();
                var paymentType = $('#payment_type').val();
                // 1- Make an AJAX request to get the payment cycle for the selected employee
                $.ajax({
                    url: '/get-employee-payment-cycle/' + employeeId,
                    type: 'GET',
                    success: function(data) {
                        // Clear existing options
                        $('#payment_cycle').empty();
                        // Add new options from the payment_cycles array
                        $('#payment_cycle').append(
                            '<option value="" disabled selected>{{ __('lang.please_select') }}</option>'
                        );
                        $.each(data.payment_cycles, function(index, cycle) {
                            var selectedAttribute = (cycle == data.payment_cycle) ?
                                'selected' : '';
                            $('#payment_cycle').append('<option value="' + cycle +
                                '" ' + selectedAttribute + '>' + cycle + '</option>'
                            );
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
                // 2- Make an AJAX request to get the payment cycle for the selected employee
                $.ajax({
                    url: '/get-employee-payment-cycle/' + employeeId,
                    type: 'GET',
                    success: function(data) {
                        // Update the payment_cycle select box
                        $('#payment_cycle').val(data.payment_cycle);
                        console.log(data.payment_cycle);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            // Event handler for payment_type dropdown change
            $('#payment_type').on('change', function() {
                updateOtherPayment();
            });
            // ++++++++++ updateOtherPayment() +++++++++++++
            function updateOtherPayment() {
                var employeeId = $('#employee_id').val();
                var paymentType = $('#payment_type').val();
                // 1- Make an AJAX request to fetch other_payment(salary) based on employee_id and payment_type
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
            $('#other_payment').on('change', function() {
                net_salary();
            })
            // +++++++++++++++++ Calculate "increases" : When Change "الزيادات" +++++++++++++++++
            $('#increases').on('change', function() {
                net_salary();
            })
            // +++++++++++++++++ Calculate "deductibles" : When Change "الخصومات" +++++++++++++++++
            $('#deductibles').on('change', function() {
                net_salary();
            })
            // ++++++++++++++++++++++++ net_salary ++++++++++++++++++++++++++++
            function net_salary() {
                let deductibles = parseFloat($('#deductibles').val());
                let increases = parseFloat($('#increases').val());
                let other_payment = parseFloat($('#other_payment').val());
                if (!isNaN(deductibles) && !isNaN(other_payment) && !isNaN(increases)) {
                    let netAmount = (other_payment + increases) - deductibles;
                    $('#net_amount').val(netAmount);
                    console.log(netAmount);
                } else if (!isNaN(deductibles) && !isNaN(other_payment) && isNaN(increases)) {
                    let netAmount = other_payment - deductibles;
                    $('#net_amount').val(netAmount);
                    console.log(netAmount);
                } else if (deductibles !== '' && deductibles !== undefined && isNaN(other_payment) && isNaN(
                        increases)) {
                    netAmount = -deductibles;
                    $('#net_amount').val(netAmount);
                    console.log(netAmount);
                } else {
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
