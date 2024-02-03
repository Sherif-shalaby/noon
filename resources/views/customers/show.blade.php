@extends('layouts.app')
@section('title', __('lang.customer'))

@section('page_title')
    @lang('lang.customers')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('customers.index') }}">/
            @lang('lang.customers')</a>
    </li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.customer') {{ $customer->name }}
    </li>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-1">
                    <div
                        class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h6>@lang('lang.employee') </h6>
                        {{--                        <a href="{{action('EmployeeController@sendLoginDetails', $employee->id)}}" --}}
                        {{--                            class="btn btn-primary btn-xs" style="margin-left: 10px;"><i class="fa fa-paper-plane"></i> @lang('lang.send_credentials')</a> --}}
                    </div>
                    <div class="card-body">
                        <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="col-md-10">
                                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <div
                                        class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="fname">@lang('lang.customer_type')
                                        </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            {{ $customer->customer_type->name ?? '' }}
                                        </span>
                                    </div>
                                    <div
                                        class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="name">@lang('lang.name')</label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            {{ $customer->name }}
                                        </span>
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
                                    <div
                                        class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="email">@lang('lang.email') </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            @foreach ($emailArray as $email)
                                                {{ $email }}<br>
                                            @endforeach
                                        </span>
                                    </div>
                                    <div
                                        class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="email">@lang('lang.phone') </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            @foreach ($phoneArray as $phone)
                                                {{ $phone }}<br>
                                            @endforeach
                                        </span>
                                    </div>

                                    <div
                                        class="col-sm-6 dollar-cell d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="date_of_start_working">@lang('lang.min_amount_in_dollar') </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            {{ $customer->min_amount_in_dollar }}
                                        </span>
                                    </div>
                                    <div
                                        class="col-sm-6 dollar-cell d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="date_of_birth">@lang('lang.max_amount_in_dollar') </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            {{ $customer->max_amount_in_dollar }}
                                        </span>
                                    </div>


                                    <div
                                        class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="job_type">@lang('lang.min_amount_in_dinar') </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            {{ $customer->min_amount_in_dinar }}
                                        </span>
                                    </div>
                                    <div
                                        class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="mobile">@lang('lang.max_amount_in_dinar') </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            {{ $customer->max_amount_in_dinar }}
                                        </span>
                                    </div>
                                    <div
                                        class="col-sm-6 dollar-cell d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="mobile">@lang('lang.balance_in_dollar') </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            {{ $customer->balance_in_dollar }}
                                        </span>
                                    </div>
                                    <div
                                        class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="mobile">@lang('lang.balance_in_dinar') </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            {{ $customer->balance_in_dinar }}
                                        </span>
                                    </div>
                                    @php
                                        $state = \App\Models\State::find($customer->state_id);
                                        $city = \App\Models\City::find($customer->city_id);
                                    @endphp
                                    <div
                                        class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="mobile">@lang('lang.state') </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            {{ $state ? $state->name : '' }}
                                        </span>
                                    </div>
                                    <div
                                        class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="mobile">@lang('lang.city') </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            {{ $city ? $city->name : '' }}
                                        </span>
                                    </div>
                                    <div
                                        class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="mobile">@lang('lang.address') </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            {{ $customer->address }}
                                        </span>
                                    </div>
                                    <div
                                        class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label style="font-size: 16px;font-weight: 500" class="mx-2 mb-0"
                                            for="mobile">@lang('lang.notes') </label> :
                                        <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                            {{ $customer->notes }}
                                        </span>
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
                        <div class="row  ">
                            <div
                                class="col-md-12 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label for="mobile" style="font-size: 16px;font-weight: 500" class="mx-2 mb-0">
                                    @lang('lang.important_dates') </label>
                                @if ($customer->customer_important_dates)
                                    @foreach ($customer->customer_important_dates as $date)
                                        <div
                                            class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label style="font-size: 16px;font-weight: 500" class="mb-0 mx-2"
                                                for="important_date">@lang('lang.important_date') </label> :
                                            <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                                {{ $date->details }}
                                            </span>
                                        </div>
                                        <div
                                            class="col-sm-6 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label style="font-size: 16px;font-weight: 500" class="mb-0 mx-2"
                                                for="date">@lang('lang.date') </label> :
                                            <span style="font-size: 16px;font-weight: 500" class="mb-0 mx-2">
                                                {{ $date->date }}
                                            </span>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
