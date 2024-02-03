@extends('layouts.app')
@section('title', __('lang.edit_wages'))


@section('page_title')
    @lang('lang.edit_wages')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('wages.index') }}">@lang('lang.wages')</a></li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
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
                        <div class="row pt-5">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('employee_id', __('lang.employee') . ':*') !!}
                                    {!! Form::select('employee_id', $employees, $wage->employee_id, [
                                        'class' => 'form-control select2',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                    ]) !!}
                                    @error('employee_id')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('payment_type', __('lang.payment_type') . ':*') !!}
                                    {!! Form::select('payment_type', $payment_types, $wage->payment_type, [
                                        'class' => 'form-control select2',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                    ]) !!}
                                    @error('payment_type')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('other_payment', __('lang.other_payment')) !!}
                                    {!! Form::text('other_payment', $wage->other_payment, [
                                        'class' => 'form-control',
                                    ]) !!}
                                    @error('other_payment')
                                        <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 account_period">
                                <div class="form-group">
                                    <label for="account_period">@lang('lang.account_period')</label>
                                    {!! Form::month('account_period', $wage->account_period, [
                                        'class' => 'form-control',
                                        'placeholder' => __('lang.account_period'),
                                        'id' => 'account_period',
                                    ]) !!}
                                </div>
                            </div>

                            <div class="col-md-4 account_period">
                                <div class="form-group">
                                    <label for="acount_period_start_date">@lang('lang.acount_period_start_date')</label>
                                    {!! Form::text('acount_period_start_date', @format_date($wage->acount_period_start_date), [
                                        'class' => 'form-control  datepicker calculate_salary',
                                        'placeholder' => __('lang.acount_period_start_date'),
                                        'id' => 'acount_period_start_date',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-4 account_period">
                                <div class="form-group">
                                    <label for="acount_period_end_date">@lang('lang.acount_period_end_date')</label>
                                    {!! Form::text('acount_period_end_date', @format_date($wage->acount_period_end_date), [
                                        'class' => 'form-control datepicker calculate_salary',
                                        'placeholder' => __('lang.acount_period_end_date'),
                                        'id' => 'acount_period_end_date',
                                    ]) !!}
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deductibles">@lang('lang.deductibles')</label>
                                    {!! Form::text('deductibles', $wage->deductibles, [
                                        'class' => 'form-control',
                                        'placeholder' => __('lang.deductibles'),
                                        'id' => 'deductibles',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reasons_of_deductibles">@lang('lang.reasons_of_deductibles')</label>
                                    {!! Form::text('reasons_of_deductibles', $wage->reasons_of_deductibles, [
                                        'class' => 'form-control',
                                        'rows' => 3,
                                        'placeholder' => __('lang.reasons_of_deductibles'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="net_amount">@lang('lang.net_amount')</label>
                                    {!! Form::text('net_amount', $wage->net_amount, [
                                        'class' => 'form-control',
                                        'placeholder' => __('lang.net_amount'),
                                        'id' => 'net_amount',
                                    ]) !!}
                                </div>
                            </div>
                            <input type="hidden" name="amount" id="amount" value="{{ $wage->amount }}">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_date">@lang('lang.payment_date')</label>
                                    {!! Form::text(
                                        'payment_date',
                                        !empty($wage->payment_date) ? @format_date($wage->payment_date) : @format_date(date('Y-m-d')),
                                        ['class' => 'form-control datepicker', 'placeholder' => __('lang.payment_date')],
                                    ) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('source_type', __('lang.source_type'), []) !!} <br>
                                    {!! Form::select(
                                        'source_type',
                                        ['user' => __('lang.user'), 'pos' => __('lang.pos'), 'store' => __('lang.store'), 'safe' => __('lang.safe')],
                                        $wage->source_type,
                                        ['class' => 'select2 form-control', 'placeholder' => __('lang.please_select')],
                                    ) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('source_of_payment', __('lang.source_of_payment'), []) !!} <br>
                                    {!! Form::select('source_id', $users, $wage->source_id, [
                                        'class' => 'select2 form-control',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'source_id',
                                        'required',
                                    ]) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('notes', __('lang.notes')) !!}
                                    {!! Form::textarea('notes', $wage->notes, [
                                        'class' => 'form-control',
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
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/product/wage.js') }}"></script>
@endpush
