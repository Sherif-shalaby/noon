@extends('layouts.app')
@section('title', __('lang.add_supplier'))
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
                        <li class="breadcrumb-item"><a href="{{route('suppliers.index')}}">@lang('lang.suppliers')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.add_supplier')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-primary">
                        @lang('lang.suppliers')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.suppliers')</h5>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>@lang('lang.required_fields_info')</small></p>
                        <form class="form ajaxform" action="{{ route('suppliers.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    {{-- {{ dd($countryId);  }} --}}
                                    {{-- ++++++++++++++++++++++ name ++++++++++++++++++++++++ --}}
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="name">@lang('lang.name')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.name')"
                                                       name="name"
                                                       value="{{ old('name') }}" >
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++++ company_name ++++++++++++++++++++++++ --}}
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="name">@lang('lang.company_name')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.company_name')"
                                                       name="company_name"
                                                       value="{{ old('company_name') }}" >
                                                @error('company_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
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
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="exchange_rate">@lang('lang.exchange_rate')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="number"
                                                       class="form-control"
                                                       placeholder="@lang('lang.exchange_rate')"
                                                       name="exchange_rate"
                                                       style="border-color:#aaa"
                                                       value="{{ old('exchange_rate') }}" >
                                                @error('exchange_rate')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++++++++++++++++++ start_date +++++++++++++++++++++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="start_date">@lang('lang.start_date')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="date"
                                                       class="form-control"
                                                       placeholder="@lang('lang.start_date')"
                                                       name="start_date"
                                                       style="border-color:#aaa"
                                                       value="{{ date('Y-m-d') }}" >
                                                @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++++++++++++++++++ end_date +++++++++++++++++++++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="end_date">@lang('lang.end_date')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="date"
                                                       class="form-control"
                                                       placeholder="@lang('lang.end_date')"
                                                       name="end_date"
                                                       style="border-color:#aaa"
                                                       value="{{ old('end_date') }}" >
                                                @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++++++++++++++++++ postal_code ++++++++++++++++++++++++ --}}
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="postal_code">@lang('lang.postal_code')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.postal_code')"
                                                       name="postal_code"
                                                       value="{{ old('postal_code') }}" >
                                                @error('postal_code')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
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
                                    <div class="col-md-4">
                                        <label for="owner_debt_in_dinar">@lang('lang.owner_debt_in_dinar')</label>
                                        <input type="number" class="form-control" style="border-color:#aaa" name="owner_debt_in_dinar" id="owner_debt_in_dinar" />
                                    </div>
                                    {{-- +++++++++++++++++++++++ owner_debt_in_dollar +++++++++++++++++++++++ --}}
                                    <div class="col-md-4">
                                        <label for="owner_debt_in_dollar">@lang('lang.owner_debt_in_dollar')</label>
                                        <input type="number" class="form-control" style="border-color:#aaa" name="owner_debt_in_dollar" id="owner_debt_in_dollar" />
                                    </div>
                                    {{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
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
                                            <select id="state-dd" name="state_id" class="form-control">
                                                @php
                                                    $states = \App\Models\State::where('country_id', $countryId)->get(['id','name']);
                                                @endphp
                                                @foreach ( $states as $state)
                                                    <option value="{{ $state->id }}">
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
                                            <select id="city-dd" name="city_id" class="form-control"></select>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++++++++++++++++++ email array ++++++++++++++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <table class="bordered">
                                                <thead class="email_thead">
                                                    <tr>
                                                        <th class="text-left" style="font-weight: normal;">
                                                            <label class="mb-2">
                                                                <span class="text-danger">*</span>@lang('lang.email')
                                                            </label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="email_tbody">
                                                    <tr>
                                                        <td class="col-md-12 p-0">
                                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                                <input type="text"
                                                                    class="form-control"
                                                                    placeholder="@lang('lang.email')"
                                                                    name="email[]"
                                                                    value="{{ old('email') }}"  >
                                                                @error('email')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                        <td  class="col-md-6">
                                                            {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                            <a href="javascript:void(0)" class="btn btn-xs btn-primary addRow_email" type="button">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++++++++++++++++++ mobile_number array ++++++++++++++++++++++++ --}}
                                    <div class="col-md-4"  style="width: 100%;">
                                        <table class="bordered">
                                            <thead class="phone_thead">
                                                <tr>
                                                    <th class="text-left" style="font-weight: normal;">
                                                        <label class="mb-2">
                                                            <span class="text-danger">*</span>@lang('lang.phone_number')
                                                        </label>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="phone_tbody">
                                                <tr>
                                                    <td class="col-md-12 p-0">
                                                        <div class="select_body d-flex justify-content-between align-items-center" >
                                                            <input type="text"
                                                                   class="form-control"
                                                                   placeholder="@lang('lang.phone_number')"
                                                                   name="mobile_number[]"
                                                                   value="{{ old('mobile_number') }}" required >
                                                            @error('mobile_number')
                                                             <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td  class="col-md-6">
                                                        {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-primary addRow" type="button">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- ++++++++++++ images ++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('lang.image')</label>
                                            <input class="form-control img" name="image"  type="file" accept="image/*" >
                                            {{-- <div class="dropzone" id="my-dropzone">
                                                <div class="dz-message" data-dz-message><span>@lang('categories.drop_file_here_to_upload')</span></div>
                                            </div> --}}
                                            @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                {{-- ====================== notes , address ====================== --}}
                                <div class="row">
                                    {{-- ++++++++++++ notes ++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('notes', __('lang.notes')) !!}
                                            {!! Form::textarea('notes', null, [
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
                                            {!! Form::textarea('address', null, [
                                                'class' => 'form-control',
                                            ]) !!}
                                            @error('address')
                                                <label class="text-danger error-msg">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ++++++++++++++++ Submit ++++++++++++++++++ --}}
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" >
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
@endsection
@push('js')
{{-- <script src="{{ asset('js/supplier.js') }}"></script> --}}
{{-- +++++++++++++++++++++++++++++++ Add New Row in mobile_number ++++++++++++++++++++++++ --}}
<script>
    $('.phone_tbody').on('click','.addRow', function(){
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
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger deleteRow">-</a>
                    </td>

                </td>
            </tr>`;
        $('.phone_tbody').append(tr);
    } );
    $('.phone_tbody').on('click','.deleteRow',function(){
        $(this).parent().parent().remove();
    });
    // ============================== Email Repeater ==============================
    // +++++++++++++ Add New Row in email +++++++++++++
    $('.email_tbody').on('click','.addRow_email', function(){
        console.log('new Email inputField was added');
        var tr =`<tr>
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
    } );
    // +++++++++++++ Delete Row in email +++++++++++++
    $('.email_tbody').on('click','.deleteRow_email',function(){
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
        data: {state_id: idState,_token:"{{ csrf_token() }}"},
        success:function(response)
        {
            $('#city-dd').html('<option value="">Select State</option>');
            console.log(response);
            $.each(response.cities,function(index, val)
                {
                    $('#city-dd').append('<option value="'+val.id+'">'+val.name+'</option>')
                });
            }
        })
    });
</script>

@endpush
