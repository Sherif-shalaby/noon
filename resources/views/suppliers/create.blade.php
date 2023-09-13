@extends('layouts.app')
@section('title', __('lang.suppliers'))
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
            <a href="{{route('suppliers.index')}}" class="btn btn-info">
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
                        <h5 class="card-title">@lang('lang.suppliers')</h5>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>@lang('lang.required_fields_info')</small></p>
                        <form class="form ajaxform" action="{{ route('suppliers.store') }}" method="post" enctype="multipart/form-data" id='product-form'>
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 ">
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
                                    <div class="col-md-6 ">
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
                                    <div class="col-md-6 ">
                                        <div class="form-group ">
                                            <label for="email">@lang('lang.email')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.email')"
                                                       name="email"
                                                       value="{{ old('email') }}" >
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++++++++++++++++++ mobile_number ++++++++++++++++++++++++ --}}
                                    {{-- <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="mobile_number"> <span class="text-danger">*</span> @lang('lang.phone_number') </label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.phone_number')"
                                                       name="mobile_number"
                                                       value="{{ old('mobile_number') }}" required >
                                                @error('mobile_number')
                                                 <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- +++++++++++++++++++++++++++++++ mobile_number ++++++++++++++++++++++++ --}}
                                    <div class="col-md-6"  style="width: 100%;">
                                        <table class="bordered">
                                            <thead class="phone_thead">
                                                <tr>
                                                    <th class="text-left" style="font-weight: normal;">
                                                        <span class="text-danger">*</span>
                                                        @lang('lang.phone_number')
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="phone_tbody">
                                                <tr>
                                                    <td class="col-md-12">
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
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-primary addRow" style="margin-bottom: 10px;" type="button">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- +++++++++++++++++++++++++++++++ exchange_rate ++++++++++++++++++++++++ --}}
                                    <div class="col-md-6 ">
                                        <div class="form-group ">
                                            <label for="exchange_rate">@lang('lang.exchange_rate')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="number"
                                                       class="form-control"
                                                       placeholder="@lang('lang.exchange_rate')"
                                                       name="exchange_rate"
                                                       value="{{ old('exchange_rate') }}" >
                                                @error('exchange_rate')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
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
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="address">@lang('lang.address')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.address')"
                                                       name="address"
                                                       value="{{ old('address') }}" >
                                                @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                    </div>
                                    <div class="col-md-4">
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
                                    </div>
                                </div>
                                <br>
                                {{-- ====================== notes , images ====================== --}}
                                <div class="row">
                                    {{-- ++++++++++++ notes ++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {!! Form::label('notes', __('lang.notes')) !!}
                                            {!! Form::textarea('notes', null, [
                                                'class' => 'form-control',
                                            ]) !!}
                                            @error('address')
                                                <label class="text-danger error-msg">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- ++++++++++++ images ++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('image')</label>
                                            <input class="form-control img" name="image"  type="file" accept="image/*" >
                                            <div class="dropzone" id="my-dropzone">
                                                <div class="dz-message" data-dz-message><span>@lang('categories.drop_file_here_to_upload')</span></div>
                                            </div>
                                            @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-primary" id="submit-btn">
                                    <i class="la la-check-square-o"></i> {{ __('Add') }}
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
</script>
@endpush
