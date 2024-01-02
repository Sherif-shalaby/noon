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
                        <h5 class="card-title">@lang('lang.add_supplier')</h5>
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
                                            <label for="name"> <span class="text-danger">*</span> @lang('lang.name')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.name')"
                                                       name="name"
                                                       value="{{ old('name') }}" required >
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++++ company_name ++++++++++++++++++++++++ --}}
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="name"> <span class="text-danger">*</span> @lang('lang.company_name')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.company_name')"
                                                       name="company_name"
                                                       value="{{ old('company_name') }}" required >
                                                @error('company_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
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
                                                       value="{{ date('Y-m-d') }}"  >
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
                                    {{-- ++++++++++++++++ countries selectbox : الدولة : (countries table) +++++++++++++++++ --}}
                                    <div class="col-md-4 mb-3">
                                        <label for="country-dd">@lang('lang.country')</label>
                                        <select id="country-dd" name="country" class="form-control" disabled>
                                            <option value="{{ $countryId }}">
                                                {{ $countryName }}
                                            </option>
                                        </select>
                                    </div>
                                    {{-- ++++++++++++++++ state selectbox : المحافظة : (states table) +++++++++++++++++ --}}
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="state-dd">@lang('lang.state')</label>
                                            <select id="state-dd" name="state_id" class="form-control select2">
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
                                    {{-- ++++++++++++++++ regions selectbox : المناطق : (cities table) +++++++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city-dd">@lang('lang.regions')</label>
                                            <div class="d-flex justify-content-center">
                                                <select id="city-dd" name="city_id" class="form-control select2"></select>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" id="cities_id" data-target="#createRegionModal">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++ quarter selectbox : الاحياء +++++++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="quarters_id">@lang('lang.quarters')</label>
                                            <div class="d-flex justify-content-center">
                                                <select id="quarter-dd" class="form-control select2" name="quarter_id"></select>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" id="add_quarters_btn_id" data-target="#createQuarterModal">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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
            {{-- ++++++++++++ Quick_Add "city","quarter" Modal ++++++++++++ --}}
            @include('suppliers.partials.quick_add')
        </div>
    </div>
@endsection
@push('js')
{{-- <script src="{{ asset('js/supplier.js') }}"></script> --}}
{{-- +++++++++++++++++++++++++++++++ Add New Row in mobile_number ++++++++++++++++++++++++ --}}
<script>
    $('.phone_tbody').on('click','.addRow', function(){
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
        var tr =`<tr>
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
    } );
    // +++++++++++++ Delete Row in email +++++++++++++
    $('.email_tbody').on('click','.deleteRow_email',function(){
        $(this).parent().parent().remove();
    });
    // ++++++++++++++++++++++ Countries , State , Cities Selectbox ++++++++++++++++
    // ================ state selectbox ================
    $('#state-dd').change(function(event) {
        // Capture the selected state value
        var idState = this.value;
        $('#city-dd').html('');
        $.ajax({
            url: "/api/customers/fetch-cities",
            type: 'POST',
            dataType: 'json',
            data: {state_id: idState,_token:"{{ csrf_token() }}"},
            success:function(response)
            {
                $('#city-dd').html('<option value="">Select State</option>');
                $.each(response.cities,function(index, val)
                {
                    $('#city-dd').append('<option value="'+val.id+'">'+val.name+'</option>')
                });
            }
        })
    });
    // ================ city selectbox ================
    // ++++++++++++ store "state_id" in hidden inputField in "cities modal" ++++++++++
    $("#cities_id").on('click', function(){
        var state_id = $("#state-dd").val();
        $("#stateId").val(state_id);
        console.log("+++++++++++++++++++++++++++ "+state_id+" +++++++++++++++++++++++++++");
    });
    // ================ quarter selectbox ================
    $('#city-dd').change(function(event) {
        // Capture the selected city value
        var idCity = this.value;
        $('#quarter-dd').html('');
        $.ajax({
            url: "/api/customers/fetch-quarters",
            type: 'POST',
            dataType: 'json',
            data: {city_id: idCity,_token:"{{ csrf_token() }}"},
            success:function(response)
            {
                console.log("Quarter = "+response.quarters);
                $('#quarter-dd').html('<option value="">Select Quarter</option>');
                $.each(response.quarters,function(index, val)
                {
                    $('#quarter-dd').append('<option value="'+val.id+'">'+val.name+'</option>')
                });
            }
        })
    });
    // ++++++++++++ store "cities_id" in hidden inputField in "quarter modal" ++++++++++
    $("#add_quarters_btn_id").on('click', function(){
        var city_id = $("#city-dd").val();
        $("#cityId").val(city_id);
        console.log("+++++++++++++++++++++++++++ "+city_id+" +++++++++++++++++++++++++++");
    });
</script>

@endpush
