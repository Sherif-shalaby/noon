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
                                    <div
                                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="name">@lang('lang.name')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <input type="text" required class="form-control initial-balance-input m-auto"
                                                style="width: 100%" placeholder="@lang('lang.name')" name="name"
                                                value="{{ $supplier->name }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ categories ++++++++++++++++++++ --}}
                                    <div
                                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="parent_id">@lang('categories.categories')</label>
                                        <div class="input-wrapper">
                                            <select name="supplier_category_id" class="form-control select2" id="my-select">
                                                <option value="" selected disabled readonly>---{{ __('select') }}---
                                                </option>
                                                @forelse($supplier_categories as $key=> $val)
                                                    <option value="{{ $key }}"
                                                        @if ($supplier->supplier_category_id == $key) selected @else '' @endif>
                                                        {{ $val }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        @error('supplier_category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- ++++++++++++++++++++ exchange_rate ++++++++++++++++++++ --}}
                                    <div
                                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label
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

                                    {{-- ++++++++++++++++++++ email ++++++++++++++++++++ --}}
                                    {{-- <div class="col-md-6 ">
                                        <div class="form-group ">
                                            <label for="email">@lang('lang.email')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text" required
                                                       class="form-control"
                                                       placeholder="@lang('lang.email')"
                                                       name="email"
                                                       value="{{ $supplier->email }}" >
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- ++++++++++++++++++++ mobile_number ++++++++++++++++++++ --}}
                                    {{-- <div class="col-md-6 ">
                                        <div class="form-group ">
                                            <label for="mobile_number">@lang('lang.phone_number')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.phone_number')"
                                                       name="mobile_number"
                                                       value="{{$supplier->mobile_number }}" >
                                                @error('mobile_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- ++++++++++++++++++++ company_name ++++++++++++++++++++ --}}
                                    <div
                                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="name">@lang('lang.company_name')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <input type="text" class="form-control initial-balance-input m-auto"
                                                style="width: 100%" placeholder="@lang('lang.company_name')" name="company_name"
                                                value="{{ $supplier->company_name }}">
                                            @error('company_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ vat_number ++++++++++++++++++++ --}}
                                    <div
                                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="vat_number">@lang('lang.vat_number')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <input type="text" class="form-control initial-balance-input m-auto"
                                                style="width: 100%" placeholder="@lang('lang.vat_number')" name="vat_number"
                                                value="{{ $supplier->vat_number }}">
                                            @error('vat_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ address ++++++++++++++++++++ --}}
                                    <div
                                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
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
                                    {{-- ++++++++++++++++++++ city ++++++++++++++++++++ --}}
                                    <div
                                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="city">@lang('lang.city')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <input type="text" class="form-control initial-balance-input m-auto"
                                                style="width: 100%" placeholder="@lang('lang.city')" name="city"
                                                value="{{ $supplier->city }}">
                                            @error('city')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ country ++++++++++++++++++++ --}}
                                    <div
                                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="country">@lang('lang.country')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <input type="text" class="form-control initial-balance-input m-auto"
                                                style="width: 100%" placeholder="@lang('lang.country')" name="country"
                                                value="{{ $supplier->country }}">
                                            @error('country')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ postal_code ++++++++++++++++++++ --}}
                                    <div
                                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <label
                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                            for="postal_code">@lang('lang.postal_code')</label>
                                        <div
                                            class="select_body input-wrapper d-flex justify-content-between align-items-center">
                                            <input type="text" class="form-control initial-balance-input m-auto"
                                                style="width: 100%" placeholder="@lang('lang.postal_code')" name="postal_code"
                                                value="{{ $supplier->postal_code }}">
                                            @error('postal_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
                                                        <td class="col-md-12 p-0  mb-2">
                                                            <div class="select_body input-wrapper  d-flex justify-content-between align-items-center"
                                                                style="width: 100%">
                                                                <input type="text" class=" initial-balance-input m-0"
                                                                    width="100%;" style="flex-grow: 1"
                                                                    placeholder="@lang('lang.email')" name="email[]"
                                                                    value="{{ old('email') }}" required>

                                                                {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                                <a href="javascript:void(0)"
                                                                    class="add-button d-flex justify-content-center align-items-center text-decoration-none addRow_email"
                                                                    type="button">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        @error('email')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                        @php
                                                            $emailArray = explode(',', $supplier->email);
                                                            // Remove square brackets from each element in the emailArray
                                                            foreach ($emailArray as $key => $email) {
                                                                $emailArray[$key] = str_replace(['[', ']', '"'], '', $email);
                                                            }
                                                        @endphp
                                                        {{-- Iterate over the email array elements --}}
                                                        @foreach ($emailArray as $email)
                                                    <tr>
                                                        <td class="col-md-12 p-0 mb-2">
                                                            <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                                                                style="width: 100%">
                                                                <input type="text" class=" initial-balance-input m-0"
                                                                    width="100%;" style="flex-grow: 1"
                                                                    placeholder="@lang('lang.email')" name="email[]"
                                                                    value="{{ $email }}" required>
                                                                @error('email')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror

                                                                <a href="javascript:void(0)"
                                                                    class="add-button d-flex justify-content-center align-items-center text-decoration-none deleteRow_email">
                                                                    <i class="fa fa-minus"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tr>
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
                                                            <input type="text"class=" initial-balance-input m-0"
                                                                width="100%;" style="flex-grow: 1"
                                                                placeholder="@lang('lang.phone_number')" name="mobile_number[]"
                                                                value="{{ old('mobile_number') }}" required>

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
                                                    @php
                                                        $phoneArray = explode(',', $supplier->mobile_number);
                                                        // Remove square brackets from each element in the emailArray
                                                        foreach ($phoneArray as $key => $phone) {
                                                            $phoneArray[$key] = str_replace(['[', ']', '"'], '', $phone);
                                                        }
                                                    @endphp
                                                    {{-- Iterate over the email array elements --}}
                                                    @foreach ($phoneArray as $phone)
                                                <tr>
                                                    <td class="col-md-12 p-0 mb-2">
                                                        <div class="select_body input-wrapper d-flex justify-content-between align-items-center m-2"
                                                            style="width: 100%">
                                                            <input type="text" class=" initial-balance-input m-0"
                                                                width="100%;" style="flex-grow: 1"
                                                                placeholder="@lang('lang.mobile_number')" name="mobile_number[]"
                                                                value="{{ $phone }}" required>
                                                            @error('mobile_number')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror

                                                            <a href="javascript:void(0)"
                                                                class="add-button d-flex justify-content-center align-items-center  text-decoration-none  deleteRow_phone">
                                                                <i class="fa fa-minus"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                    </div>
                                    </td>
                                    </tr>
                                </div>
                                </td>

                                </tr>
                                </tbody>
                                </table>
                            </div>
                    </div>
                    {{-- ++++++++++++++++++++ image ++++++++++++++++++++ --}}
                    <div
                        class="col-md-6 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <label
                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif">@lang('image')</label>
                        <div class="input-wrapper">

                            <input class="initial-balance-input m-auto form-control img"
                                style="width: 100%; border:2px solid #ccc;padding: 0" name="image" type="file"
                                accept="image/*">
                        </div>
                        <div class="dropzone" id="my-dropzone">
                            <div class="dz-message" data-dz-message><span>@lang('categories.drop_file_here_to_upload')</span></div>
                        </div>
                        @error('cover')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <br>
            </div>
            <div class="form-actions">
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
                    <td>
                        <input  type="text" class="form-control" placeholder="@lang('lang.email')" name="email[]"
                                value="{{ old('email') }}" required >
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger deleteRow_email">-</a>
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
                    <td>
                        <input  type="text" class="form-control" placeholder="@lang('lang.phone_number')" name="mobile_number[]"
                                value="{{ old('mobile_number') }}" required >
                                @error('mobile_number')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger deleteRow_phone">-</a>
                    </td>

                </td>
            </tr>`;
            $('.phone_tbody').append(tr);
        });
        $('.phone_tbody').on('click', '.deleteRow_phone', function() {
            $(this).parent().parent().remove();
        });
    </script>
@endpush
