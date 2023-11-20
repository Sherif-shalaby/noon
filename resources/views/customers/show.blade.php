@extends('layouts.app')
@section('title', __('lang.customer'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.customers')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('customers.index') }}">@lang('lang.customers')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.customer') {{ $customer->name }}</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header d-flex align-items-center">
                        <h4>@lang('lang.employee') </h4>
                        {{--                        <a href="{{action('EmployeeController@sendLoginDetails', $employee->id)}}" --}}
                        {{--                            class="btn btn-primary btn-xs" style="margin-left: 10px;"><i class="fa fa-paper-plane"></i> @lang('lang.send_credentials')</a> --}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="fname">@lang('lang.customer_type') : </label>
                                        {{ $customer->customer_type->name ?? '' }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="name">@lang('lang.name') : </label> {{ $customer->name }}

                                    </div>
                                    @php
                                        $emailArray = explode(',', $customer->email);
                                        $phoneArray = explode(',', $customer->phone);
                                        // Remove square brackets from each element in the emailArray
                                        foreach ($emailArray as $key => $email) {
                                            $emailArray[$key] = str_replace(['[', ']', '"'], '', $email);
                                        }
                                        // Remove square brackets from each element in the emailArray
                                        foreach ($phoneArray as $key => $phone) {
                                            $phoneArray[$key] = str_replace(['[', ']', '"'], '', $phone);
                                        }
                                    @endphp
                                    <div class="col-sm-6">
                                        <label for="email">@lang('lang.email') : </label>
                                        @foreach ($emailArray as $email)
                                            {{ $email }}<br>
                                        @endforeach
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="email">@lang('lang.phone') : </label>
                                        @foreach ($phoneArray as $phone)
                                            {{ $phone }}<br>
                                        @endforeach
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="date_of_start_working">@lang('lang.min_amount_in_dollar') : </label>
                                        {{ $customer->min_amount_in_dollar }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="date_of_birth">@lang('lang.max_amount_in_dollar') : </label>
                                        {{ $customer->max_amount_in_dollar }}
                                    </div>


                                    <div class="col-sm-6">
                                        <label for="job_type">@lang('lang.min_amount_in_dinar') : </label>
                                        {{ $customer->min_amount_in_dinar }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.max_amount_in_dinar') : </label>
                                        {{ $customer->max_amount_in_dinar }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.balance_in_dollar') : </label>
                                        {{ $customer->balance_in_dollar }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.balance_in_dinar') : </label>
                                        {{ $customer->balance_in_dinar }}
                                    </div>
                                    @php
                                        $state = \App\Models\State::find($customer->state_id);
                                        $city = \App\Models\City::find($customer->city_id);
                                    @endphp
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.state') : </label>
                                        {{ $state ? $state->name : '' }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.city') : </label>
                                        {{ $city ? $city->name : '' }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.address') : </label>
                                        {{ $customer->address }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.notes') : </label>
                                        {{ $customer->notes }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="thumbnail">
                                    <img src="@if (!empty($customer->image)) {{ asset('uploads/' . $customer->image) }}@else{{ asset('images/default.jpg') }} @endif"
                                        style="" class="img-fluid" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <label for="mobile"> @lang('lang.important_dates') </label>
                                @if ($customer->customer_important_dates)
                                    @foreach ($customer->customer_important_dates as $date)
                                        <br>
                                        <div class="col-sm-6">
                                            <label for="important_date">@lang('lang.important_date') : </label>
                                            {{ $date->details }}
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="date">@lang('lang.date') : </label>
                                            {{ $date->date }}
                                        </div>
                                        <br>
                                    @endforeach
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
