@extends('layouts.app')
@section('title', __('lang.edit_supplier'))
@push('css')
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.add_supplier')
                </h4>
                <div class="breadcrumb-list">
                    <ul style=" list-style: none;"
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                @lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                style="text-decoration: none;color: #596fd7" href="{{ route('suppliers.index') }}">/
                                @lang('lang.suppliers')</a></li>
                        <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                            aria-current="page">@lang('lang.add_supplier')</li>
                    </ul>
                </div>
            </div>
            <a href="{{ route('suppliers.index') }}" style="width: fit-content" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i>
                @lang('Back')
            </a>
        </div>
    </div>
@endsection
@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('lang.suppliers')</h5>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ route('suppliers.update', $supplier->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-body">
                                <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    {{-- ++++++++++++++++++++ name ++++++++++++++++++++ --}}
                                    <div class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                        style="animation-delay: 1.1s">
                                        <label
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            style="font-weight: 700;font-size: 13px;" for="name"><span
                                                class="text-danger">*</span>
                                            @lang('lang.name')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <input type="text" required class="form-control initial-balance-input m-auto"
                                                style="width: 100%" placeholder="@lang('lang.name')" name="name"
                                                value="{{ $supplier->name }}">
                                            @error('name')
                                                <span style="font-size: 10px;font-weight: 700;"
                                                    class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ company_name ++++++++++++++++++++ --}}
                                    <div class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                        style="animation-delay: 1.15s">
                                        <label style="font-weight: 700;font-size: 13px;"
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="name"> <span class="text-danger">*</span>
                                            @lang('lang.company_name')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <input type="text" class="form-control initial-balance-input m-auto"
                                                style="width: 100%" placeholder="@lang('lang.company_name')" name="company_name"
                                                value="{{ $supplier->company_name }}" required>
                                            @error('company_name')
                                                <span style="font-size: 10px;font-weight: 700;"
                                                    class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ exchange_rate ++++++++++++++++++++ --}}
                                    <div class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                        style="animation-delay: 1.2s">
                                        <label style="font-weight: 700;font-size: 13px;"
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="exchange_rate">@lang('lang.exchange_rate')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <input type="number"class="form-control initial-balance-input m-auto"
                                                style="width: 100%" placeholder="@lang('lang.exchange_rate')" name="exchange_rate"
                                                value="{{ $supplier->exchange_rate }}">
                                            @error('exchange_rate')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                        style="animation-delay: 1.25s">

                                        <label style="font-weight: 700;font-size: 13px;"
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="start_date">@lang('lang.start_date')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <input type="date"
                                                style="background: transparent;outline: none !important;border: none;width: 100%;padding: 15px;"
                                                placeholder="@lang('lang.start_date')" name="start_date" style="border-color:#aaa"
                                                value="{{ $supplier->start_date }}">
                                            @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    {{-- --}}
                                    <div class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                        style="animation-delay: 1.3s">

                                        <label style="font-weight: 700;font-size: 13px;"
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="end_date">@lang('lang.end_date')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <input type="date"
                                                style="background: transparent;outline: none !important;border: none;width: 100%;padding: 15px;"
                                                placeholder="@lang('lang.end_date')" name="end_date" style="border-color:#aaa"
                                                value="{{ $supplier->end_date }}">
                                            @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    {{-- +++++++++++++++++++++++ owner_debt_in_dinar +++++++++++++++++++++++ --}}
                                    <div class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                        style="animation-delay: 1.35s">
                                        <label style="font-weight: 700;font-size: 13px;"
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="owner_debt_in_dinar">@lang('lang.owner_debt_in_dinar')</label>
                                        <div class="input-wrapper">
                                            <input type="number" class="form-control initial-balance-input m-auto"
                                                style="width: 100%" style="border-color:#aaa" name="owner_debt_in_dinar"
                                                id="owner_debt_in_dinar" value="{{ $supplier->owner_debt_in_dinar }}" />
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++++++++++ owner_debt_in_dollar +++++++++++++++++++++++ --}}
                                    <div class="col-md-4 mb-2 d-flex align-items-center dollar-cell @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                        style="animation-delay: 1.4s">
                                        <label style="font-weight: 700;font-size: 13px;"
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="owner_debt_in_dollar">@lang('lang.owner_debt_in_dollar')</label>
                                        <div class="input-wrapper">
                                            <input type="number" class="form-control  initial-balance-input m-auto"
                                                style="width: 100%" style="border-color:#aaa" name="owner_debt_in_dollar"
                                                id="owner_debt_in_dollar"
                                                value="{{ $supplier->owner_debt_in_dollar }}" />
                                        </div>
                                    </div>

                                    {{-- ++++++++++++++++++++ address ++++++++++++++++++++ --}}
                                    <div class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                        style="animation-delay: 1.45s">
                                        <label
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="address">@lang('lang.address')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <input type="text" class="form-control initial-balance-input m-auto"
                                                style="width: 100%" placeholder="@lang('lang.address')" name="address"
                                                value="{{ $supplier->address }}">
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ country ++++++++++++++++++++ --}}
                                    <div class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                        style="animation-delay: 1.5s">
                                        <label style="font-weight: 700;font-size: 13px;"
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="country-dd">@lang('lang.country')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <select id="country-dd" name="country" class="form-control" disabled>
                                                <option value="{{ $countryId }}">
                                                    {{ $countryName }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ city ++++++++++++++++++++ --}}
                                    <div class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                        style="animation-delay: 1.55s">
                                        <label style="font-weight: 700;font-size: 13px;"
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="city-dd">@lang('lang.city')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <select id="city-dd" name="city_id" class="form-control select2">
                                                <option value=""> @lang('lang.please_select')</option>
                                                @if (isset($cities))
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ $supplier->city_id == $city->id ? 'selected' : '' }}>
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ image ++++++++++++++++++++ --}}
                                    <div class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                        style="animation-delay: 1.6s">
                                        <label style="font-weight: 700;font-size: 13px;"
                                            class="mx-2 mb-0 width-fit @if (app()->isLocale('ar')) d-block text-end @endif">@lang('image')</label>
                                        <div class="input-wrapper">

                                            <input class="initial-balance-input m-auto form-control img"
                                                style="width: 100%; border:2px solid #ccc;padding: 0" name="image"
                                                type="file" accept="image/*" value="{{ $supplier->image }}">
                                        </div>
                                        {{-- <div class="dropzone" style="opacity: 0;width: 20px;height: 20px;" id="my-dropzone">
                                        <div class="dz-message" data-dz-message><span>@lang('categories.drop_file_here_to_upload')</span></div>
                                    </div> --}}
                                        @error('cover')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- +++++++++++++++++++++++++++++++ email array ++++++++++++++++++++++++ --}}
                                    <div class="col-md-6 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                        style="animation-delay: 1.65s">
                                        <div class="m-0 " style="width: 100%">
                                            <table class="bordered m-0" style="width: 100%">
                                                <thead class="email_thead">
                                                    <tr>
                                                        <th style="background: transparent !important;color: black !important;"
                                                            class="@if (app()->isLocale('ar')) text-end @else text-start @endif">
                                                            <label class="mb-0">
                                                                @lang('lang.email')
                                                            </label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="email_tbody">
                                                    <tr>
                                                        <td class="col-md-12 p-0  mb-2">
                                                            <div class="select_body input-wrapper m-2 d-flex justify-content-between align-items-center"
                                                                style="width: 100%">
                                                                @php
                                                                    $emailArray = explode(',', $supplier->email);
                                                                    // Remove square brackets from each element in the emailArray
                                                                    foreach ($emailArray as $key => $email) {
                                                                        $emailArray[$key] = str_replace(['[', ']', '"'], '', $email);
                                                                    }
                                                                @endphp
                                                                @foreach ($emailArray as $index => $email)
                                                                    @if ($index == 0)
                                                                        <input type="text"
                                                                            class="form-control width-full initial-balance-input m-0"
                                                                            width="100%;"
                                                                            placeholder="@lang('lang.email')"
                                                                            name="email[]"
                                                                            value="{{ $email == 'null' ? '' : $email }}">
                                                                        {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                                        <a href="javascript:void(0)"
                                                                            class="add-button d-flex justify-content-center align-items-center text-decoration-none addRow_email"
                                                                            type="button">
                                                                            <i class="fa fa-plus"></i>
                                                                        </a>
                                                        </td>
                                                        @error('email')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    @else
                                                    <tr>
                                                        <td class="col-md-12 p-0 mb-2">
                                                            <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                                                                style="width: 100%">
                                                                <input type="text"
                                                                    class="width-full initial-balance-input m-0"
                                                                    width="100%;" style="flex-grow: 1"
                                                                    placeholder="@lang('lang.email')" name="email[]"
                                                                    value="{{ $email }}" required>
                                                                @error('email')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                        </td>

                                                        <a href="javascript:void(0)"
                                                            class="add-button d-flex justify-content-center align-items-center text-decoration-none deleteRow_email">-</a>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                        </div>
                                        </td>

                                        </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- +++++++++++++++++++++++++++++++ mobile_number array ++++++++++++++++++++++++ --}}
                                <div class="col-md-6 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                    style="animation-delay: 1.7s">
                                    <div class="m-0 " style="width: 100%">
                                        <table class="bordered m-0" style="width: 100%">
                                            <thead class="phone_thead">
                                                <tr>
                                                    <th style="background: transparent !important;color: black !important;"
                                                        class="@if (app()->isLocale('ar')) text-end @else text-start @endif">
                                                        <label class="mb-0">
                                                            <span class="text-danger">*</span>@lang('lang.mobile_number')
                                                        </label>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="phone_tbody">
                                                <tr>
                                                    <td class="col-md-12 p-0 mb-2">
                                                        <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                                                            style="width: 100%">
                                                            @php
                                                                $phoneArray = explode(',', $supplier->mobile_number);
                                                                // Remove square brackets from each element in the emailArray
                                                                foreach ($phoneArray as $key => $phone) {
                                                                    $phoneArray[$key] = str_replace(['[', ']', '"'], '', $phone);
                                                                }
                                                            @endphp
                                                            @foreach ($phoneArray as $index => $phone)
                                                                @if ($index == 0)
                                                                    <input type="text"
                                                                        class=" initial-balance-input m-0" width="100%;"
                                                                        style="flex-grow: 1"
                                                                        placeholder="@lang('lang.phone_number')"
                                                                        name="mobile_number[]"
                                                                        value="{{ $phone }}" required>

                                                                    {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                                    <a href="javascript:void(0)"
                                                                        class="add-button d-flex justify-content-center align-items-center  text-decoration-none addRow_phone"
                                                                        type="button">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                    </td>
                                                    @error('mobile_number')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                @else
                                                <tr>
                                                    <td>
                                                        <input type="text" class=" initial-balance-input m-0"
                                                            width="100%;" style="flex-grow: 1"
                                                            placeholder="@lang('lang.mobile_number')" name="mobile_number[]"
                                                            value="{{ $phone }}" required>
                                                        @error('mobile_number')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)"
                                                            class="add-button d-flex justify-content-center align-items-center  text-decoration-none deleteRow_phone">-</a>
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                    </div>
                                    </td>

                                    </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>

                    </div>
                    <br>
                </div>
                <div class="form-actions animate__animated animate__bounceInLeft" style="animation-delay: 1.75s">
                    <button type="submit" class="btn btn-primary">
                        <i class="la la-check-square-o"></i> {{ __('edit') }}
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End col -->
    @include('categories.modalCrop')
    </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/supplier.js') }}"></script>
    <script>
        // ============================== Email Repeater ==============================
        // +++++++++++++ Add New Row in email +++++++++++++
        $('.email_tbody').on('click', '.addRow_email', function() {
            console.log('new Email inputField was added');
            var tr = `<tr>
                    <td class="col-md-12 p-0">
                        <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                            style="width: 100%">
                        <input  type="text" class=" initial-balance-input m-0"
                            width="100%"  style="flex-grow: 1" placeholder="@lang('lang.email')" name="email[]"
                                value="{{ old('email') }}" >
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                        <a href="javascript:void(0)" class="add-button d-flex justify-content-center align-items-center text-decoration-none deleteRow_email"> <i class="fa fa-minus"></i></a>
                        </div>
                    </td>
                </tr>`;
            $('.email_tbody').append(tr);
        });
        // +++++++++++++ Delete Row in email +++++++++++++
        $('.email_tbody').on('click', '.deleteRow_email', function() {
            $(this).parent().parent().remove();
        });
        // ================================= mobile_phone Repeater =================================
        $('.phone_tbody').on('click', '.addRow_phone', function() {
            console.log('new mobile_number inputField was added');
            var tr = `<tr>
                    <td class="col-md-12 p-0 mb-2">
                          <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                            style="width: 100%">
                        <input  type="text" class=" initial-balance-input m-0"  width="100%;" style="flex-grow: 1" placeholder="@lang('lang.phone_number')" name="mobile_number[]"
                                value="{{ old('mobile_number') }}" required >
                                @error('mobile_number')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                        <a href="javascript:void(0)" class="add-button d-flex justify-content-center align-items-center  text-decoration-none deleteRow_phone"> <i class="fa fa-minus"></i></a>
                   </div>
                        </td>

                </td>
            </tr>`;
            $('.phone_tbody').append(tr);
        });
        $('.phone_tbody').on('click', '.deleteRow_phone', function() {
            $(this).parent().parent().remove();
        });
        // ++++++++++++++++++++++ Countries , State , Cities Selectbox +++++++++++++++++
        // ================ state selectbox ================
        $('#state-dd').change(function(event) {
            var idState = this.value;
            $('#city-dd').html('');
            $.ajax({
                url: "/api/fetch-cities",
                type: 'POST',
                dataType: 'json',
                data: {
                    state_id: idState,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#city-dd').html('<option value="">Select State</option>');
                    console.log(response);
                    $.each(response.cities, function(index, val) {
                        $('#city-dd').append('<option value="' + val.id + '">' + val.name +
                            '</option>')
                    });
                }
            })
        });
    </script>
@endpush
