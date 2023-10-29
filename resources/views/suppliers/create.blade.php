@extends('layouts.app')
@section('title', __('lang.add_supplier'))
@push('css')
@endpush
@section('breadcrumbbar')
    <div class="animate-in-page">

        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.add_supplier')
                    </h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ route('suppliers.index') }}">/
                                    @lang('lang.suppliers')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                                aria-current="page">@lang('lang.add_supplier')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a href="{{ route('suppliers.index') }}" class="btn btn-primary">
                            @lang('lang.suppliers')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">

        <div class="contentbar">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.suppliers')</h5>
                        </div>
                        <div class="card-body">
                            <p class="italic"><small>@lang('lang.required_fields_info')</small></p>
                            <form class="form ajaxform" action="{{ route('suppliers.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div
                                        class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        {{-- {{ dd($countryId);  }} --}}
                                        {{-- ++++++++++++++++++++++ name ++++++++++++++++++++++++ --}}
                                        <div
                                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="name">@lang('lang.name')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                                <input type="text" class="form-control initial-balance-input m-auto"
                                                    style="width: 100%" placeholder="@lang('lang.name')" name="name"
                                                    value="{{ old('name') }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- ++++++++++++++++++++++ company_name ++++++++++++++++++++++++ --}}
                                        <div
                                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="name">@lang('lang.company_name')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                                <input type="text" class="form-control initial-balance-input m-auto"
                                                    style="width: 100%" placeholder="@lang('lang.company_name')" name="company_name"
                                                    value="{{ old('company_name') }}">
                                                @error('company_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- +++++++++++++++++++++++++++++++ email ++++++++++++++++++++++++ --}}
                                        {{-- <div class="col-md-6 ">
                                        <div class="form-group ">
                                            <label for="email">@lang('lang.email')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.email')"
                                                       name="email[]"
                                                       value="{{ old('email') }}" >
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}
                                        {{-- +++++++++++++++++++++++++++++++ exchange_rate ++++++++++++++++++++++++ --}}
                                        <div
                                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                            <label
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
                                        {{-- +++++++++++++++++++++++++++++++ postal_code ++++++++++++++++++++++++ --}}
                                        <div
                                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="postal_code">@lang('lang.postal_code')</label>
                                            <div
                                                class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                                <input type="text" class="form-control initial-balance-input m-auto"
                                                    style="width: 100%" placeholder="@lang('lang.postal_code')" name="postal_code"
                                                    value="{{ old('postal_code') }}">
                                                @error('postal_code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- +++++++++++++++++++++++++++++++ address ++++++++++++++++++++++++ --}}
                                        {{-- <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="address">@lang('lang.address')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <textarea class="form-control" placeholder="@lang('lang.address')" name="address"value="{{ old('address') }}" ></textarea>
                                                @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}
                                        {{-- +++++++++++++++++++++++++++++++ city ++++++++++++++++++++++++ --}}
                                        {{-- <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="city">@lang('lang.city')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.city')"
                                                       name="city"
                                                       value="{{ old('city') }}" >
                                                @error('city')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}
                                        {{-- ========================== country ==================== --}}
                                        {{-- <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="country">@lang('lang.country')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.country')"
                                                       name="country"
                                                       value="{{ old('country') }}" >
                                                @error('country')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}
                                        {{-- +++++++++++++++++++++++ owner_debt_in_dinar +++++++++++++++++++++++ --}}

                                        <div
                                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="owner_debt_in_dinar">@lang('lang.owner_debt_in_dinar')</label>
                                            <div class="input-wrapper">
                                                <input type="number" class="form-control initial-balance-input m-auto"
                                                    style="width: 100%" name="owner_debt_in_dinar"
                                                    id="owner_debt_in_dinar" />
                                            </div>
                                        </div>
                                        {{-- +++++++++++++++++++++++ owner_debt_in_dollar +++++++++++++++++++++++ --}}
                                        <div
                                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="owner_debt_in_dollar">@lang('lang.owner_debt_in_dollar')</label>
                                            <div class="input-wrapper">

                                                <input type="number" class="form-control initial-balance-input m-auto"
                                                    style="width: 100%" name="owner_debt_in_dollar"
                                                    id="owner_debt_in_dollar" />
                                            </div>
                                        </div>
                                        {{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
                                        <div
                                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label
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
                                        <div
                                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="state-dd">@lang('lang.state')</label>
                                            <div class="input-wrapper">

                                                <select id="state-dd" name="state_id"
                                                    class=" initial-balance-input m-auto"
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
                                        {{-- ++++++++++++++++ city selectbox +++++++++++++++++ --}}
                                        <div
                                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="city-dd">@lang('lang.city')</label>
                                            <div class="input-wrapper">
                                                <select id="city-dd" name="city_id"
                                                    class=" initial-balance-input m-auto"
                                                    style="width: 100%; border:2px solid #ccc"></select>
                                            </div>
                                        </div>
                                        {{-- +++++++++++++++++++++++++++++++ email array ++++++++++++++++++++++++ --}}
                                        <div
                                            class="col-md-6 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <div class="m-0 " style="width: 100%">
                                                <table class="bordered m-0" style="width: 100%">
                                                    <thead class="email_thead">
                                                        <tr>
                                                            <th
                                                                class="@if (app()->isLocale('ar')) text-end @else text-start @endif">
                                                                <label class="mb-0">
                                                                    <span class="text-danger">*</span>@lang('lang.email')
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


                                                                    {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                                    <a href="javascript:void(0)"
                                                                        class="add-button d-flex justify-content-center align-items-center text-decoration-none addRow_email"
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
                                        {{-- +++++++++++++++++++++++++++++++ mobile_number array ++++++++++++++++++++++++ --}}
                                        <div
                                            class="col-md-6 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <div class="m-0 " style="width: 100%">
                                                <table class="bordered m-0" style="width: 100%">
                                                    <thead class="phone_thead">
                                                        <tr>
                                                            <th
                                                                class="@if (app()->isLocale('ar')) text-end @else text-start @endif">
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
                                        {{-- ++++++++++++ images ++++++++++++ --}}
                                        <div
                                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                            <label
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
                                        {{-- ====================== notes , address ====================== --}}

                                        {{-- ++++++++++++ notes ++++++++++++ --}}
                                        <div
                                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            {!! Form::label('notes', __('lang.notes'), [
                                                'class' => ' app()->isLocale("ar")? d-block text-end mx-2 mb-0 width-quarter : mx-2 mb-0 width-quarter ',
                                            ]) !!}
                                            <div class="input-wrapper" style="width: 100%;height: 100%;margin: 0">
                                                {!! Form::textarea('notes', null, [
                                                    'class' => 'form-control initial-balance-input m-auto',
                                                    'style' => 'width: 100%',
                                                ]) !!}
                                            </div>
                                            @error('notes')
                                                <label class="text-danger error-msg">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        {{-- ++++++++++++ address ++++++++++++ --}}
                                        <div
                                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            {!! Form::label('address', __('lang.address'), [
                                                'class' => ' app()->isLocale("ar")? d-block text-end mx-2 mb-0 width-quarter : mx-2 mb-0 width-quarter ',
                                            ]) !!}
                                            <div class="input-wrapper" style="width: 100%;height: 100%;margin: 0">
                                                {!! Form::textarea('address', null, [
                                                    'class' => 'form-control initial-balance-input m-auto',
                                                    'style' => 'width: 100%',
                                                ]) !!}
                                            </div>
                                            @error('address')
                                                <label class="text-danger error-msg">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>


                                </div>
                                {{-- ++++++++++++++++ Submit ++++++++++++++++++ --}}
                                <div class="form-actions">
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
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{-- <script src="{{ asset('js/supplier.js') }}"></script> --}}
    {{-- +++++++++++++++++++++++++++++++ Add New Row in mobile_number ++++++++++++++++++++++++ --}}
    <script>
        $('.phone_tbody').on('click', '.addRow', function() {
            console.log('new mobile_number inputField was added');
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
            console.log('new Email inputField was added');
            var tr = `<tr>
                    <td  class="col-md-12 p-0">
                        <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                            style="width: 100%">
                        <input  type="text" class=" initial-balance-input m-0"
                            width="100%"  style="flex-grow: 1" placeholder="@lang('lang.email')" name="email[]"
                                value="{{ old('email') }}" required >
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
