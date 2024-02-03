@extends('layouts.app')
@section('title', __('lang.edit_wages'))


@push('css')
@endpush

@section('page_title')
    @lang('lang.edit_wages')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('wages.index') }}">/
            @lang('lang.wages')</a></li>
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.edit_wages')</li>
@endsection

@section('content')
    <div class="animate-in-page">

        <!-- Start row -->
        <div class="row d-flex justify-content-center">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30 p-2">
                    {!! Form::open(['route' => ['wages.update', $wage->id], 'method' => 'put', 'id' => 'brand-update-form']) !!}
                    @csrf
                    @method('PUT')
                    <div class="container-fluid">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('employee_id', __('lang.employee') . '*', [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper">

                                    {!! Form::select('employee_id', $employees, $wage->employee_id, [
                                        'class' => 'form-control selectpicker',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                    ]) !!}
                                </div>
                                @error('employee_id')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('payment_type', __('lang.payment_type') . '*', [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper">

                                    {!! Form::select('payment_type', $payment_types, $wage->payment_type, [
                                        'class' => 'form-control selectpicker',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                    ]) !!}
                                </div>
                                @error('payment_type')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div
                                class="col-md-3 mb-2 d-flex align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('other_payment', __('lang.other_payment'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper">

                                    {!! Form::text('other_payment', $wage->other_payment, [
                                        'class' => 'form-control initial-balance-input m-auto width-full',
                                    ]) !!}
                                </div>
                                @error('other_payment')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div
                                class="col-md-3 mb-2 d-flex align-items-center account_period
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;' for="account_period">@lang('lang.account_period')</label>
                                <div class="input-wrapper">

                                    {!! Form::month('account_period', $wage->account_period, [
                                        'class' => 'form-control initial-balance-input m-auto width-full',
                                        'placeholder' => __('lang.account_period'),
                                        'id' => 'account_period',
                                    ]) !!}
                                </div>
                            </div>

                            <div
                                class="col-md-3 mb-2 d-flex align-items-center account_period
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;'
                                    for="acount_period_start_date">@lang('lang.acount_period_start_date')</label>
                                <div class="input-wrapper">

                                    {!! Form::text('acount_period_start_date', @format_date($wage->acount_period_start_date), [
                                        'class' => 'form-control initial-balance-input m-auto width-full datepicker calculate_salary',
                                        'placeholder' => __('lang.acount_period_start_date'),
                                        'id' => 'acount_period_start_date',
                                    ]) !!}
                                </div>
                            </div>
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center account_period
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;'
                                    for="acount_period_end_date">@lang('lang.acount_period_end_date')</label>
                                <div class="input-wrapper">

                                    {!! Form::text('acount_period_end_date', @format_date($wage->acount_period_end_date), [
                                        'class' => 'form-control  initial-balance-input m-auto width-full  datepicker calculate_salary',
                                        'placeholder' => __('lang.acount_period_end_date'),
                                        'id' => 'acount_period_end_date',
                                    ]) !!}
                                </div>
                            </div>


                            <div
                                class="col-md-3 mb-2 d-flex align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;' for="deductibles">@lang('lang.deductibles')</label>
                                <div class="input-wrapper">

                                    {!! Form::text('deductibles', $wage->deductibles, [
                                        'class' => 'form-control  initial-balance-input m-auto width-full ',
                                        'placeholder' => __('lang.deductibles'),
                                        'id' => 'deductibles',
                                    ]) !!}
                                </div>
                            </div>
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter",
                                    style='font-size: 12px;font-weight: 500;'
                                    for="reasons_of_deductibles">@lang('lang.reasons_of_deductibles')</label>
                                <div class="input-wrapper">

                                    {!! Form::text('reasons_of_deductibles', $wage->reasons_of_deductibles, [
                                        'class' => 'form-control  initial-balance-input m-auto width-full',
                                        'rows' => 3,
                                        'placeholder' => __('lang.reasons_of_deductibles'),
                                    ]) !!}
                                </div>
                            </div>
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;' for="net_amount">@lang('lang.net_amount')</label>
                                <div class="input-wrapper">
                                    {!! Form::text('net_amount', $wage->net_amount, [
                                        'class' => 'form-control initial-balance-input m-auto width-full',
                                        'placeholder' => __('lang.net_amount'),
                                        'id' => 'net_amount',
                                    ]) !!}
                                </div>
                            </div>
                            <input type="hidden" name="amount" id="amount" value="{{ $wage->amount }}">
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter",
                                    style='font-size: 12px;font-weight: 500;' for="payment_date">@lang('lang.payment_date')</label>
                                <div class="input-wrapper">

                                    {!! Form::text(
                                        'payment_date',
                                        !empty($wage->payment_date) ? @format_date($wage->payment_date) : @format_date(date('Y-m-d')),
                                        [
                                            'class' => 'form-control datepicker  initial-balance-input m-auto width-full',
                                            'placeholder' => __('lang.payment_date'),
                                        ],
                                    ) !!}
                                </div>
                            </div>
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('source_type', __('lang.source_type'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper">

                                    {!! Form::select(
                                        'source_type',
                                        ['user' => __('lang.user'), 'pos' => __('lang.pos'), 'store' => __('lang.store'), 'safe' => __('lang.safe')],
                                        $wage->source_type,
                                        ['class' => 'selectpicker form-control', 'placeholder' => __('lang.please_select')],
                                    ) !!}
                                </div>
                            </div>
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('source_of_payment', __('lang.source_of_payment'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper">

                                    {!! Form::select('source_id', $users, $wage->source_id, [
                                        'class' => 'selectpicker form-control',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'source_id',
                                        'required',
                                    ]) !!}
                                </div>
                            </div>

                            <div
                                class="col-md-3 mb-2 d-flex align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('notes', __('lang.notes'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper width-full" style="height: 100px;border-radius: 9px">
                                    {!! Form::textarea('notes', $wage->notes, [
                                        'class' => 'form-control',
                                        'style' => ' width: 300px;height:100%;background-color:transparent',
                                    ]) !!}
                                </div>
                                @error('notes')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
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
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/product/wage.js') }}"></script>
@endpush
