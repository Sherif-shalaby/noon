@extends('layouts.app')
@section('title', __('lang.add_customers'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0 mb-2">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.add_customers')
                    </h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ route('customers.index') }}">/
                                    @lang('lang.customers')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                                aria-current="page">@lang('lang.add_customers')</li>
                        </ul>
                    </div>
                </div>
                <div class=" col-md-4 ">
                    <div
                        class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a href="{{ route('customers.index') }}" class="btn btn-primary">
                            @lang('lang.customers')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start row -->
    <div class="animate-in-page">

        <div class="row d-flex justify-content-center">
            {{-- {{ dd($countryName) }}  --}}
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30 p-2">
                    {!! Form::open([
                        'route' => 'customers.store',
                        'method' => 'post',
                        'enctype' => 'multipart/form-data',
                        'id' => 'customer-form',
                    ]) !!}
                    <div class="container-fluid">
                        <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            {{-- +++++++++++++++++++++++++++++++ customer_type ++++++++++++++++++++++++ --}}
                            <div
                                class=" col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('customer_type_id', __('lang.customer_type') . '*', [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper">
                                    {!! Form::select('customer_type_id', $customer_types, null, [
                                        'class' => 'form-control selectpicker',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                    ]) !!}
                                    {{-- "add new customer_type" button --}}
                                    <button type="button" class="add-button" data-toggle="modal"
                                        data-target="#createCustomerTypesModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                @error('customer_type_id')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            {{-- +++++++++++++++++++++++++++++++ name  ++++++++++++++++++++++++ --}}
                            <div
                                class=" col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('name', __('lang.name'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper">
                                    {!! Form::text('name', null, [
                                        'class' => 'form-control initial-balance-input m-auto width-full required',
                                    ]) !!}
                                </div>
                                @error('name')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            {{-- +++++++++++++++++++++++ min_amount_in_dollar +++++++++++++++++++++++ --}}
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center dollar-cell
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;'
                                    for="min_amount_in_dollar">@lang('lang.min_amount_in_dollar')</label>
                                <div class="input-wrapper">

                                    <input type="number" class="form-control initial-balance-input m-auto width-full "
                                        name="min_amount_in_dollar" id="min_amount_in_dollar" />
                                </div>
                            </div>

                            {{-- +++++++++++++++++++++++ max_amount_in_dollar +++++++++++++++++++++++ --}}
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center dollar-cell
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;'
                                    for="max_amount_in_dollar">@lang('lang.max_amount_in_dollar')</label>
                                <div class="input-wrapper">
                                    <input type="number" class="form-control initial-balance-input m-auto width-full"
                                        name="max_amount_in_dollar" id="max_amount_in_dollar" />
                                </div>
                            </div>
                            {{-- +++++++++++++++++++++++ min_amount_in_dinar +++++++++++++++++++++++ --}}
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;'
                                    for="min_amount_in_dinar">@lang('lang.min_amount_in_dinar')</label>
                                <div class="input-wrapper">

                                    <input type="number" class="form-control initial-balance-input m-auto width-full"
                                        name="min_amount_in_dinar" id="min_amount_in_dinar" />
                                </div>
                            </div>
                            {{-- +++++++++++++++++++++++ max_amount_in_dinar +++++++++++++++++++++++ --}}
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center
                                @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;'
                                    for="max_amount_in_dinar">@lang('lang.max_amount_in_dinar')</label>
                                <div class="input-wrapper">

                                    <input type="number" class="form-control initial-balance-input m-auto width-full "
                                        name="max_amount_in_dinar" id="max_amount_in_dinar" />
                                </div>
                            </div>
                            {{-- +++++++++++++++++++++++ balance_in_dollar +++++++++++++++++++++++ --}}
                            <div
                                class=" col-md-3 mb-2 d-flex align-items-center dollar-cell @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;'
                                    for="balance_in_dollar">@lang('lang.balance_in_dollar')</label>
                                <div class="input-wrapper">

                                    <input type="text" class="form-control initial-balance-input m-auto width-full "
                                        name="balance_in_dollar" id="balance_in_dollar" />
                                </div>
                            </div>
                            {{-- +++++++++++++++++++++++ balance_in_dinar +++++++++++++++++++++++ --}}
                            <div
                                class=" col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;'
                                    for="balance_in_dinar">@lang('lang.balance_in_dinar')</label>
                                <div class="input-wrapper">
                                    <input type="text" class="form-control initial-balance-input m-auto width-full"
                                        name="balance_in_dinar" id="balance_in_dinar" />
                                </div>
                            </div>
                            {{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
                            <div
                                class=" col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;' for="country-dd">@lang('lang.country')</label>
                                <div class="input-wrapper">
                                    <select id="country-dd" name="country" class="form-control selectpicker" disabled>
                                        <option value="{{ $countryId }}">
                                            {{ $countryName }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            {{-- ++++++++++++++++ state selectbox +++++++++++++++++ --}}
                            <div
                                class=" col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter"
                                    style='font-size: 12px;font-weight: 500;' for="state-dd">@lang('lang.state')</label>
                                <div class="input-wrapper">
                                    <select id="state-dd" name="state_id" class="form-control selectpicker">
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
                                class=" col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter",
                                    style='font-size: 12px;font-weight: 500;' for="city-dd">@lang('lang.city')</label>
                                <div class="input-wrapper">
                                    <select id="city-dd" name="city_id" class="form-control selectpicker"></select>
                                </div>
                            </div>
                            <div
                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter",
                                    style='font-size: 12px;font-weight: 500;' for="regions_id">@lang('lang.regions')</label>
                                <div class="d-flex justify-content-center">
                                    <div class="input-wrapper">
                                        <select class="form-control select2" name="regions_id" id="regions_id"></select>
                                    </div>
                                    {{--                                    {!! Form::select( --}}
                                    {{--                                        'store_id[]', --}}
                                    {{--                                        $stores,null, --}}
                                    {{--                                       [ --}}
                                    {{--                                        'class' => 'form-control selectpicker', --}}
                                    {{--                                        'placeholder' => __('lang.please_select'), --}}
                                    {{--                                        'id' => 'store_id', --}}
                                    {{--                                       ], --}}
                                    {{--                                    ) !!} --}}
                                    <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                        data-target=".add-store"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>

                            {{-- ++++++++++++ images ++++++++++++ --}}
                            {{-- <div
                                class=" col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <label
                                    class="@if (app()->isLocale('ar')) d-block text-end @endif mx-2 mb-0 width-quarter",
                                    style='font-size: 12px;font-weight: 500;'>@lang('lang.upload_image')</label>
                                <div class="input-wrapper">
                                    <input class="form-control img  initial-balance-input m-auto width-full"
                                        name="image" type="file" accept="image/*" id="image">
                                </div> --}}
                            {{-- Crop Image : cropper.js --}}
                            {{-- <div class="dropzone" id="my-dropzone2" required>
                                    <div class="dz-message" data-dz-message><span>@lang('categories.drop_file_here_to_upload')</span></div>
                                </div> --}}
                            {{-- @error('cover')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}

                            {{-- +++++++++++++++++++++++++++++++ email array ++++++++++++++++++++++++ --}}
                            <div
                                class=" col-md-6 px-5 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <table class="bordered m-0" style="width: 100%">
                                    <thead class="email_thead">
                                        <tr>
                                            <th style="background: transparent !important;color: black !important;"
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
                                                    <input type="text" class=" initial-balance-input m-0"
                                                        width="100%;" style="flex-grow: 1"
                                                        placeholder="@lang('lang.email')" name="email[]" value=""
                                                        required>
                                                    @error('email')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror

                                                    {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                    <a href="javascript:void(0)"
                                                        class="add-button d-flex justify-content-center align-items-center mb-0 text-decoration-none addRow_email"
                                                        type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- +++++++++++++++++++++++++++++++ phone ++++++++++++++++++++++++ --}}
                            <div
                                class="col-md-6 mb-2 px-5 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div class="m-0 " style="width: 100%">
                                    <table class="bordered m-0" style="width: 100%">
                                        <thead class="phone_thead">
                                            <tr>
                                                <th style="background: transparent !important;color: black !important;"
                                                    class="@if (app()->isLocale('ar')) text-end @else text-start @endif">
                                                    <label class="mb-0">
                                                        <span class="text-danger">*</span> @lang('lang.phone')
                                                    </label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="phone_tbody">
                                            <tr>
                                                <td class="col-md-12 p-0 mb-2">
                                                    <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                                                        style="width: 100%">

                                                        {!! Form::text('phone[]', null, [
                                                            'class' => 'form-control required  initial-balance-input m-0 width-full',
                                                            'style' => 'flex-grow: 1',
                                                        ]) !!}
                                                        @error('phone')
                                                            <label class="text-danger error-msg">{{ $message }}</label>
                                                        @enderror

                                                        {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                        <a href="javascript:void(0)"
                                                            class="add-button d-flex justify-content-center mb-0 align-items-center text-decoration-none addRow"
                                                            style="margin-bottom: 10px;" type="button" id="submit-btn">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label>@lang('lang.upload_image')</label>
                                    <input class="form-control img" name="image" type="file" accept="image/*"
                                        id="image">
                                    {{-- Crop Image : cropper.js --}}
                                    {{-- <div class="dropzone" id="my-dropzone2" required>
                                    <div class="dz-message" data-dz-message><span>@lang('categories.drop_file_here_to_upload')</span></div>
                                </div> --}}
                                    @error('cover')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- +++++++++++++++++++++++ address +++++++++++++++++++++++ --}}
                            <div
                                class=" col-md-6 px-5 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('address', __('lang.address'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper width-full" style="height: 100px;border-radius: 9px">
                                    {!! Form::textarea('address', null, [
                                        'class' => 'form-control',
                                        'style' => ' width: 100%;height:100%;background-color:transparent',
                                    ]) !!}
                                </div>
                                @error('address')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            {{-- +++++++++++++++++++++++ Notes +++++++++++++++++++++++ --}}
                            <div
                                class=" col-md-6 px-5 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {!! Form::label('notes', __('lang.notes'), [
                                    'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                    'style' => 'font-size: 12px;font-weight: 500;',
                                ]) !!}
                                <div class="input-wrapper width-full" style="height: 100px;border-radius: 9px">
                                    {!! Form::textarea('notes', null, [
                                        'class' => 'form-control',
                                        'style' => ' width: 100%;height:100%;background-color:transparent',
                                    ]) !!}
                                </div>
                                @error('address')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>



                        </div>
                        <div class="row pt-4 pb-5">
                            <div class="col-md-12">
                                <h3 class=" @if (app()->isLocale('ar')) text-end @endif">@lang('lang.important_dates')</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <table class="table table-bordered  @if (app()->isLocale('ar')) dir-rtl @endif"
                                        id="important_date_table" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 20%;">@lang('lang.important_date')</th>
                                                <th class="text-center" style="width: 20%;">@lang('lang.date')</th>
                                                <th class="text-center" style="width: 20%;">@lang('lang.notify_before_days')</th>
                                                <th class="text-center" style="width: 10%;"><button type="button"
                                                        class="add_date btn btn-success btn-xs"><i
                                                            class="fa fa-plus"></i></button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <input type="hidden" name="important_date_index" id="important_date_index" value="0">
                        </div>
                        <div class="row pb-5">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- End col -->
                <!-- ++++++++++++ Crop_Image Modal ++++++++++++ -->
                {{-- @include('categories.modalCrop')  --}}
                {{-- ++++++++++++ customer_types Model ++++++++++++ --}}
                @include('customer_types.create')
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/product/customer.js') }}"></script>
    {{-- +++++++++++++++++++++++++++++++ Add New Row in phone ++++++++++++++++++++++++ --}}
    <script>
        $('.phone_tbody').on('click', '.addRow', function() {
            console.log('new phone inputField was added');
            var tr = `<tr>
                    <td class="col-md-12 p-0 mb-2">
                           <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                            style="width: 100%">
                        <input type="text" name="phone[]" class=" initial-balance-input m-0"
                                width="100%;" style="flex-grow: 1" placeholder="Enter phone number" />

                        <a href="javascript:void(0)" class="add-button d-flex justify-content-center align-items-center text-decoration-none deleteRow">-</a>
                  </div>


                </td>
            </tr>`;
            $('.phone_tbody').append(tr);
        });
        $('.phone_tbody').on('click', '.deleteRow', function() {
            $(this).parent().parent().remove();
        });
        // +++++++++++++++++++++++++++++++ Add New Row in email ++++++++++++++++++++++++
        $('.email_tbody').on('click', '.addRow_email', function() {
            console.log('new Email inputField was added');
            var tr = `<tr>
                    <td  class="col-md-12 p-0">
                        <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                            style="width: 100%">
                        <input  type="text" class=" initial-balance-input m-0"
                            width="100%"  style="flex-grow: 1" placeholder="@lang('lang.email')" name="email[]"
                                value="" required >
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                        <a href="javascript:void(0)" class="add-button d-flex justify-content-center align-items-center text-decoration-none deleteRow_email">-</a>
                    </div>

                </td>
            </tr>`;
            $('.email_tbody').append(tr);
        });
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
