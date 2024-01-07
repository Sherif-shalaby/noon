@extends('layouts.app')
@section('title', __('lang.edit_supplier'))
@push('css')
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.add_supplier')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">@lang('lang.suppliers')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.add_supplier')</li>
                    </ol>
                </div>
            </div>
            <a href="{{ route('suppliers.index') }}" class="btn btn-info">
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
                        <h6 class="card-title">@lang('lang.suppliers')</h6>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ route('suppliers.update', $supplier->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-body">
                                <div class="row">
                                    {{-- ++++++++++++++++++++ name ++++++++++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="name"> <span class="text-danger">*</span>
                                                @lang('lang.name')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center">
                                                <input type="text" required class="form-control"
                                                    placeholder="@lang('lang.name')" name="name"
                                                    value="{{ $supplier->name }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ company_name ++++++++++++++++++++ --}}
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="name"> <span class="text-danger">*</span>
                                                @lang('lang.company_name')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center">
                                                <input type="text" class="form-control" placeholder="@lang('lang.company_name')"
                                                    name="company_name" value="{{ $supplier->company_name }}" required>
                                                @error('company_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++++++++++++++++++ mobile_number array ++++++++++++++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <table class="bordered">
                                                <thead class="phone_thead">
                                                    <tr>
                                                        <th class="text-left" style="font-weight: normal;">
                                                            <label class="mb-2">
                                                                <span class="text-danger">*</span>@lang('lang.mobile_number')
                                                            </label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="phone_tbody">
                                                    <tr>
                                                        <td class="col-md-12 p-0">
                                                            <div
                                                                class="select_body d-flex justify-content-between align-items-center">
                                                                @php
                                                                    $phoneArray = explode(',', $supplier->mobile_number);
                                                                    // Remove square brackets from each element in the emailArray
                                                                    foreach ($phoneArray as $key => $phone) {
                                                                        $phoneArray[$key] = str_replace(['[', ']', '"'], '', $phone);
                                                                    }
                                                                @endphp
                                                                @foreach ($phoneArray as $index => $phone)
                                                                    @if ($index == 0)
                                                                        <input type="text" class="form-control"
                                                                            placeholder="@lang('lang.phone_number')"
                                                                            name="mobile_number[]"
                                                                            value="{{ $phone }}" required>
                                                        <td class="col-md-6">
                                                            {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-xs btn-primary addRow_phone" type="button">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </td>
                                                        @error('mobile_number')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    @else
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                placeholder="@lang('lang.mobile_number')" name="mobile_number[]"
                                                                value="{{ $phone }}" required>
                                                            @error('mobile_number')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-xs btn-danger deleteRow_phone">-</a>
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
                                {{-- ++++++++++++++++++++ exchange_rate ++++++++++++++++++++ --}}
                                <div class="col-md-4 ">
                                    <div class="form-group ">
                                        <label for="exchange_rate">@lang('lang.exchange_rate')</label>
                                        <div class="select_body d-flex justify-content-between align-items-center">
                                            <input type="number" class="form-control" placeholder="@lang('lang.exchange_rate')"
                                                name="exchange_rate" value="{{ $supplier->exchange_rate }}">
                                            @error('exchange_rate')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label for="start_date">@lang('lang.start_date')</label>
                                        <div class="select_body d-flex justify-content-between align-items-center">
                                            <input type="date" class="form-control" placeholder="@lang('lang.start_date')"
                                                name="start_date" style="border-color:#aaa"
                                                value="{{ $supplier->start_date }}">
                                            @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- --}}
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label for="end_date">@lang('lang.end_date')</label>
                                        <div class="select_body d-flex justify-content-between align-items-center">
                                            <input type="date" class="form-control" placeholder="@lang('lang.end_date')"
                                                name="end_date" style="border-color:#aaa"
                                                value="{{ $supplier->end_date }}">
                                            @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{--                                    {-- ++++++++++++++++++++ country ++++++++++++++++++++ --}}
                                <div class="col-md-4">
                                    <label for="country-dd">@lang('lang.country')</label>
                                    <select id="country-dd" name="country" class="form-control" disabled>
                                        <option value="{{ $countryId }}">
                                            {{ $countryName }}
                                        </option>
                                    </select>
                                </div>
                                {{-- ++++++++++++++++ state selectbox +++++++++++++++++ --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state-dd">@lang('lang.state')</label>
                                        <select id="state-dd" name="state_id" class="form-control select2">
                                            <option value=""> @lang('lang.please_select')</option>
                                            @php
                                                $states = \App\Models\State::where('country_id', $countryId)->get(['id', 'name']);
                                                if (!empty($supplier->state)) {
                                                    $cities = \App\Models\City::where('state_id', $supplier->state_id)->get(['id', 'name']);
                                                }
                                            @endphp
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ $supplier->state_id == $state->id ? 'selected' : '' }}>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- ++++++++++++++++ city selectbox +++++++++++++++++ --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city-dd">@lang('lang.city')</label>
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
                                {{-- +++++++++++++++++++++++ owner_debt_in_dinar +++++++++++++++++++++++ --}}
                                <div class="col-md-4">
                                    <label for="owner_debt_in_dinar">@lang('lang.owner_debt_in_dinar')</label>
                                    <input type="number" class="form-control" style="border-color:#aaa"
                                        name="owner_debt_in_dinar" id="owner_debt_in_dinar"
                                        value="{{ $supplier->owner_debt_in_dinar }}" />
                                </div>
                                {{-- +++++++++++++++++++++++ owner_debt_in_dollar +++++++++++++++++++++++ --}}
                                <div class="col-md-4">
                                    <label for="owner_debt_in_dollar">@lang('lang.owner_debt_in_dollar')</label>
                                    <input type="number" class="form-control" style="border-color:#aaa"
                                        name="owner_debt_in_dollar" id="owner_debt_in_dollar"
                                        value="{{ $supplier->owner_debt_in_dollar }}" />
                                </div>
                                {{-- +++++++++++++++++++++++++++++++ email array ++++++++++++++++++++++++ --}}
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <table class="bordered">
                                            <thead class="email_thead">
                                                <tr>
                                                    <th class="text-left" style="font-weight: normal;">
                                                        <label class="mb-2">
                                                            @lang('lang.email')
                                                        </label>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="email_tbody">
                                                <tr>
                                                    <td class="col-md-12 p-0">
                                                        <div
                                                            class="select_body d-flex justify-content-between align-items-center">
                                                            @php
                                                                $emailArray = explode(',', $supplier->email);
                                                                // Remove square brackets from each element in the emailArray
                                                                foreach ($emailArray as $key => $email) {
                                                                    $emailArray[$key] = str_replace(['[', ']', '"'], '', $email);
                                                                }
                                                            @endphp
                                                            @foreach ($emailArray as $index => $email)
                                                                @if ($index == 0)
                                                                    <input type="text" class="form-control"
                                                                        placeholder="@lang('lang.email')" name="email[]"
                                                                        value="{{ $email == 'null' ? '' : $email }}">
                                                    <td class="col-md-6">
                                                        {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-xs btn-primary addRow_email" type="button">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </td>
                                                    @error('email')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                @else
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            placeholder="@lang('lang.email')" name="email[]"
                                                            value="{{ $email }}" required>
                                                        @error('email')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-xs btn-danger deleteRow_email">-</a>
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
                            {{-- ++++++++++++++++++++ image ++++++++++++++++++++ --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('image')</label>
                                    <input class="form-control img" name="image" type="file" accept="image/*"
                                        value="{{ $supplier->image }}">
                                    {{--                                            @if ($supplier->image) --}}
                                    {{--                                                <img src="{{ asset('uploads/' . $supplier->image) }}" alt="Supplier Image" width="100" height="100"> --}}
                                    {{--                                            @endif --}}
                                    @error('cover')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                    </div>
                    <br>
                    {{-- ====================== notes , address ====================== --}}
                    <div class="row">
                        {{-- ++++++++++++ notes ++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('notes', __('lang.notes')) !!}
                                {!! Form::textarea('notes', $supplier->notes, [
                                    'class' => 'form-control',
                                ]) !!}
                                @error('notes')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        {{-- ++++++++++++ address ++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('address', __('lang.address')) !!}
                                {!! Form::textarea('address', $supplier->address, [
                                    'class' => 'form-control',
                                ]) !!}
                                @error('address')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </div>



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
                                value="{{ old('email') }}" >
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
