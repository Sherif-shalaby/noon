@extends('layouts.app')
@section('title', __('lang.add_supplier'))
@push('css')
    <style>
        .width-quarter {
            width: 100% !important
        }

        @media(min-width:768px) {
            .width-quarter {
                width: 25% !important
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.add_supplier')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
            style="text-decoration: none;color: #596fd7" href="{{ route('suppliers.index') }}">/
            @lang('lang.suppliers')</a></li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.add_supplier')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a href="{{ route('suppliers.index') }}" class="btn btn-primary">
            @lang('lang.suppliers')
        </a>
    </div>
@endsection

@section('content')
    <div class="animate-in-page">

        <div class="contentbar">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h6 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.add_supplier')</h6>
                        </div>
                        <div class="card-body">
                            {{-- <p class="italic"><small>@lang('lang.required_fields_info')</small></p> --}}
                            <form class="form ajaxform" action="{{ route('suppliers.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div
                                        class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        {{-- ++++++++++++++++++++++ name ++++++++++++++++++++++++ --}}
                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.1s">
                                            <label style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="name"><span class="text-danger">*</span> @lang('lang.name')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                                <input type="text" class="form-control initial-balance-input m-auto"
                                                    style="width: 100%" placeholder="@lang('lang.name')" name="name"
                                                    value="{{ old('name') }}" required>
                                                @error('name')
                                                    <span style="font-size: 10px;font-weight: 700;"
                                                        class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- ++++++++++++++++++++++ company_name ++++++++++++++++++++++++ --}}
                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.15s">
                                            <label style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="name"><span class="text-danger">*</span> @lang('lang.company_name')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                                <input type="text" class="form-control initial-balance-input m-auto"
                                                    style="width: 100%" placeholder="@lang('lang.company_name')" name="company_name"
                                                    value="{{ old('company_name') }}" required>
                                                @error('company_name')
                                                    <span style="font-size: 10px;font-weight: 700;"
                                                        class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- +++++++++++++++++++++++++++++++ exchange_rate ++++++++++++++++++++++++ --}}
                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.2s">

                                            <label style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="exchange_rate">@lang('lang.exchange_rate')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                                <input type="number" class="form-control initial-balance-input m-auto"
                                                    style="width: 100%" placeholder="@lang('lang.exchange_rate')"
                                                    name="exchange_rate" value="{{ old('exchange_rate') }}">
                                                @error('exchange_rate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.25s">

                                            <label style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="start_date">@lang('lang.start_date')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                                <input type="date"
                                                    style="background: transparent;outline: none !important;border: none;width: 100%;padding: 15px;"
                                                    placeholder="@lang('lang.start_date')" name="start_date"
                                                    style="border-color:#aaa" value="{{ date('Y-m-d') }}">
                                                @error('start_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        {{-- --}}
                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.3s">

                                            <label style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="end_date">@lang('lang.end_date')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                                <input type="date"
                                                    style="background: transparent;outline: none !important;border: none;width: 100%;padding: 15px;"
                                                    placeholder="@lang('lang.end_date')" name="end_date"
                                                    style="border-color:#aaa" value="{{ old('end_date') }}">
                                                @error('end_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        {{-- +++++++++++++++++++++++++++++++ postal_code ++++++++++++++++++++++++ --}}
                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.35s">

                                            <label style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="postal_code">@lang('lang.postal_code')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                                <input type="text" class="form-control initial-balance-input m-auto"
                                                    style="width: 100%" placeholder="@lang('lang.postal_code')"
                                                    name="postal_code" value="{{ old('postal_code') }}">
                                                @error('postal_code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- +++++++++++++++++++++++ owner_debt_in_dinar +++++++++++++++++++++++ --}}

                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.4s">
                                            <label style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="owner_debt_in_dinar">@lang('lang.owner_debt_in_dinar')</label>
                                            <div class="input-wrapper">
                                                <input type="number" class="form-control initial-balance-input m-auto"
                                                    style="width: 100%" name="owner_debt_in_dinar"
                                                    id="owner_debt_in_dinar" />
                                            </div>
                                        </div>
                                        {{-- +++++++++++++++++++++++ owner_debt_in_dollar +++++++++++++++++++++++ --}}
                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.45s">
                                            <label style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="owner_debt_in_dollar">@lang('lang.owner_debt_in_dollar')</label>
                                            <div class="input-wrapper">

                                                <input type="number" class="form-control initial-balance-input m-auto"
                                                    style="width: 100%" name="owner_debt_in_dollar"
                                                    id="owner_debt_in_dollar" />
                                            </div>
                                        </div>
                                        {{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.5s">
                                            <label style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="country-dd">@lang('lang.country')</label>
                                            <div class="input-wrapper">
                                                <select id="country-dd" name="country"
                                                    class=" initial-balance-input m-auto"
                                                    style="width: 100%; border:2px solid #ccc" disabled>
                                                    <option value="{{ $countryId }}">
                                                        {{ $countryName }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- ++++++++++++++++ state selectbox +++++++++++++++++ --}}
                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.55s">
                                            <label style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="state-dd">@lang('lang.state')</label>
                                            <div class="input-wrapper">

                                                <select id="state-dd" name="state_id"
                                                    class=" initial-balance-input select2 m-auto"
                                                    style="width: 100%; border:2px solid #ccc">
                                                    @php
                                                        $states = \App\Models\State::where('country_id', $countryId)->get(['id', 'name']);
                                                    @endphp
                                                    @foreach ($states as $state)
                                                        <option value="{{ $state->id }}">
                                                            {{ $state->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- ++++++++++++++++ regions selectbox : المناطق : (cities table) +++++++++++++++++ --}}
                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.55s">

                                            <label for="city-dd" style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif">@lang('lang.regions')</label>
                                            <div class="input-wrapper">
                                                <select id="city-dd" name="city_id"
                                                    class="form-control select2"></select>
                                                <button type="button"
                                                    class="add-button d-flex justify-content-center align-items-center text-decoration-none"
                                                    data-toggle="modal" id="cities_id" data-target="#createRegionModal">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>

                                        </div>
                                        {{-- ++++++++++++++++ quarter selectbox : الاحياء +++++++++++++++++ --}}
                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.55s">

                                            <label for="quarters_id" style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif">@lang('lang.quarters')</label>
                                            <div class="input-wrapper">
                                                <select id="quarter-dd" class="form-control select2"
                                                    name="quarter_id"></select>
                                                <button type="button"
                                                    class="add-button d-flex justify-content-center align-items-center text-decoration-none"
                                                    data-toggle="modal" id="add_quarters_btn_id"
                                                    data-target="#createQuarterModal">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>

                                        </div>

                                        {{-- +++++++++++++++++++++++++++++++ email array ++++++++++++++++++++++++ --}}
                                        <div class="col-md-6 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                            style="animation-delay: 1.7s">
                                            <div class="m-0 " style="width: 100%">
                                                <table class="bordered m-0" style="width: 100%">
                                                    <thead class="email_thead">
                                                        <tr>
                                                            <th style="background: transparent !important;color: black !important;"
                                                                class="pb-0 pt-1 @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                                                <label class="mb-0">
                                                                    @lang('lang.email')
                                                                </label>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="email_tbody">
                                                        <tr>
                                                            <td class="col-md-12 p-0 mb-2">
                                                                <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                                                                    style="width: 100%">
                                                                    <input type="text"
                                                                        class=" initial-balance-input m-0" width="100%;"
                                                                        style="flex-grow: 1"
                                                                        placeholder="@lang('lang.email')" name="email[]"
                                                                        value="{{ old('email') }}" required>
                                                                    @error('email')
                                                                        <div class="alert alert-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                    {{-- +++++++++++++ Add New Email +++++++++ --}}
                                                                    <a href="javascript:void(0)"
                                                                        class="add-button d-flex justify-content-center align-items-center text-decoration-none addRow_email"
                                                                        type="button">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- +++++++++++++++++++++++++++++++ mobile_number array ++++++++++++++++++++++++ --}}
                                        <div class="col-md-6 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                            style="animation-delay: 1.75s">
                                            <div class="m-0 " style="width: 100%">
                                                <table class="bordered m-0" style="width: 100%">
                                                    <thead class="phone_thead">
                                                        <tr>
                                                            <th style="background: transparent !important;color: black !important;"
                                                                class="pb-0 pt-1 @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                                                <label class="mb-0">
                                                                    <span class="text-danger">*</span>@lang('lang.phone_number')
                                                                </label>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="phone_tbody">
                                                        <tr>
                                                            <td class="col-md-12 p-0 mb-2">
                                                                <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                                                                    style="width: 100%">
                                                                    <input type="text"
                                                                        class=" initial-balance-input m-0" width="100%;"
                                                                        style="flex-grow: 1"
                                                                        placeholder="@lang('lang.phone_number')"
                                                                        name="mobile_number[]"
                                                                        value="{{ old('mobile_number') }}" required>
                                                                    @error('mobile_number')
                                                                        <div class="alert alert-danger">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                    {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                                    <a href="javascript:void(0)"
                                                                        class="add-button d-flex justify-content-center align-items-center  text-decoration-none addRow"
                                                                        type="button">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- ====================== notes , address ====================== --}}

                                        {{-- ++++++++++++ notes ++++++++++++ --}}
                                        <div class="col-md-6 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.8s">
                                            {!! Form::label('notes', __('lang.notes'), [
                                                'class' => ' app()->isLocale("ar")? d-block text-end mx-2 mb-0  : mx-2 mb-0  ',
                                                'style' => 'font-weight: 700;font-size: 13px;width:25%',
                                            ]) !!}
                                            <div style="width: 100%">
                                                {!! Form::textarea('notes', null, [
                                                    'class' => 'form-control width-full initial-balance-input m-0',
                                                    'rows' => 3,
                                                    'style' => 'background-color:#dedede',
                                                ]) !!}
                                            </div>
                                            @error('notes')
                                                <label class="text-danger error-msg">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        {{-- ++++++++++++ address ++++++++++++ --}}
                                        <div class="col-md-6 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.85s">
                                            {!! Form::label('address', __('lang.address'), [
                                                'class' => ' app()->isLocale("ar")? d-block text-end mx-2 mb-0  : mx-2 mb-0  ',
                                                'style' => 'font-weight: 700;font-size: 13px;width:25%',
                                            ]) !!}
                                            <div style="width: 100%">
                                                {!! Form::textarea('address', null, [
                                                    'class' => 'form-control width-full initial-balance-input m-0',
                                                    'rows' => 3,
                                                    'style' => 'background-color:#dedede',
                                                ]) !!}
                                            </div>
                                            @error('address')
                                                <label class="text-danger error-msg">{{ $message }}</label>
                                            @enderror
                                        </div>

                                        {{-- ++++++++++++ images ++++++++++++ --}}
                                        <div class="col-6 col-md-3 flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                            style="animation-delay: 1.65s">

                                            <label style="font-weight: 700;font-size: 13px;"
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif">@lang('lang.image')</label>
                                            <div class="input-wrapper">
                                                <input class=" initial-balance-input m-auto form-control img"
                                                    style="width: 100%; border:2px solid #ccc;padding: 0" name="image"
                                                    type="file" accept="image/*">
                                            </div>
                                            {{-- <div class="dropzone" id="my-dropzone">
                                                <div class="dz-message" data-dz-message><span>@lang('categories.drop_file_here_to_upload')</span></div>
                                            </div> --}}
                                            @error('cover')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>


                                </div>
                                {{-- ++++++++++++++++ Submit ++++++++++++++++++ --}}
                                <div class="form-actions animate__animated animate__bounceInLeft"
                                    style="animation-delay: 1.9s">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> {{ __('Add') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End col -->
                {{-- @include('categories.modalCrop')  --}}
                @include('suppliers.partials.quick_add')
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{-- <script src="{{ asset('js/supplier.js') }}"></script> --}}
    {{-- +++++++++++++++++++++++++++++++ Add New Row in mobile_number ++++++++++++++++++++++++ --}}
    <script>
        $('.phone_tbody').on('click', '.addRow', function() {

            var tr = `<tr>
                    <td class="col-md-12 p-0 mb-2">
                        <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                            style="width: 100%">
                            <input  type="text" class=" initial-balance-input m-0"
                                width="100%;" style="flex-grow: 1" placeholder="@lang('lang.phone_number')" name="mobile_number[]"
                                value="{{ old('mobile_number') }}" required >
                                @error('mobile_number')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                        <a href="javascript:void(0)" class="add-button d-flex justify-content-center align-items-center  text-decoration-none deleteRow"> <i class="fa fa-minus"></i></a>
                        </div>
                    </td>

                </td>
            </tr>`;
            $('.phone_tbody').append(tr);
        });
        $('.phone_tbody').on('click', '.deleteRow', function() {
            $(this).parent().parent().remove();
        });
        // ============================== Email Repeater ==============================
        // +++++++++++++ Add New Row in email +++++++++++++
        $('.email_tbody').on('click', '.addRow_email', function() {
            var tr = `<tr>
                    <td  class="col-md-12 p-0">
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
