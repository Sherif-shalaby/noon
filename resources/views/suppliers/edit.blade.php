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
                        <form class="form" action="{{ route('suppliers.update', $supplier->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-body">
                                <div class="row">
                                    {{-- ++++++++++++++++++++ name ++++++++++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="name">@lang('lang.name')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text" required
                                                       class="form-control"
                                                       placeholder="@lang('lang.name')"
                                                       name="name"
                                                       value="{{ $supplier->name }}" >
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ categories ++++++++++++++++++++ --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="parent_id">@lang('categories.categories')</label>
                                            <select name="supplier_category_id" class="form-control select2"  id="my-select">
                                                <option value="" selected disabled readonly>---{{ __('select') }}---</option>
                                                @forelse($supplier_categories as $key=> $val)
                                                    <option value="{{ $key }}" @if($supplier->supplier_category_id == $key) selected @else ''@endif >
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
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="exchange_rate">@lang('lang.exchange_rate')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="number"
                                                       class="form-control"
                                                       placeholder="@lang('lang.exchange_rate')"
                                                       name="exchange_rate"
                                                       value="{{ $supplier->exchange_rate }}" >
                                                @error('exchange_rate')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="start_date">@lang('lang.start_date')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="date"
                                                       class="form-control"
                                                       placeholder="@lang('lang.start_date')"
                                                       name="start_date"
                                                       style="border-color:#aaa"
                                                       value="{{ $supplier->start_date }}" >
                                                @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{----}}
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="end_date">@lang('lang.end_date')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="date"
                                                       class="form-control"
                                                       placeholder="@lang('lang.end_date')"
                                                       name="end_date"
                                                       style="border-color:#aaa"
                                                       value="{{ $supplier->end_date }}" >
                                                @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
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
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="name">@lang('lang.company_name')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.company_name')"
                                                       name="company_name"
                                                       value="{{ $supplier->company_name }}" >
                                                @error('company_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ vat_number ++++++++++++++++++++ --}}
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="vat_number">@lang('lang.vat_number')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.vat_number')"
                                                       name="vat_number"
                                                       value="{{ $supplier->vat_number }}" >
                                                @error('vat_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ address ++++++++++++++++++++ --}}
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="address">@lang('lang.address')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.address')"
                                                       name="address"
                                                       value="{{ $supplier->address }}" >
                                                @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ city ++++++++++++++++++++ --}}
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="city">@lang('lang.city')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.city')"
                                                       name="city"
                                                       value="{{ $supplier->city }}" >
                                                @error('city')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ country ++++++++++++++++++++ --}}
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="country">@lang('lang.country')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.country')"
                                                       name="country"
                                                       value="{{ $supplier->country }}" >
                                                @error('country')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++ postal_code ++++++++++++++++++++ --}}
                                    <div class="col-md-4 ">
                                        <div class="form-group ">
                                            <label for="postal_code">@lang('lang.postal_code')</label>
                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="@lang('lang.postal_code')"
                                                       name="postal_code"
                                                       value="{{ $supplier->postal_code }}" >
                                                @error('postal_code')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
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
                                                                    value="{{ old('email') }}" required >
                                                                <td  class="col-md-6">
                                                                    {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-primary addRow_email" type="button">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                </td>
                                                                @error('email')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                                @php
                                                                    $emailArray = explode(',', $supplier->email);
                                                                    // Remove square brackets from each element in the emailArray
                                                                    foreach ($emailArray as $key => $email)
                                                                    {
                                                                        $emailArray[$key] = str_replace(['[', ']','"'], '', $email);
                                                                    }
                                                                @endphp
                                                                    {{-- Iterate over the email array elements --}}
                                                                    @foreach ($emailArray as $email)
                                                                    <tr>
                                                                        <td>
                                                                            <input  type="text" class="form-control" placeholder="@lang('lang.email')" name="email[]"
                                                                                    value="{{ $email }}" required >
                                                                                    @error('email')
                                                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                                                    @enderror
                                                                        </td>
                                                                        <td>
                                                                            <a href="javascript:void(0)" class="btn btn-xs btn-danger deleteRow_email">-</a>
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
                                                            <div class="select_body d-flex justify-content-between align-items-center" >
                                                                <input type="text"
                                                                    class="form-control"
                                                                    placeholder="@lang('lang.phone_number')"
                                                                    name="mobile_number[]"
                                                                    value="{{ old('mobile_number') }}" required >
                                                                <td  class="col-md-6">
                                                                    {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-primary addRow_phone" type="button">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                </td>
                                                                @error('mobile_number')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                                @php
                                                                    $phoneArray = explode(',', $supplier->mobile_number);
                                                                    // Remove square brackets from each element in the emailArray
                                                                    foreach ($phoneArray as $key => $phone)
                                                                    {
                                                                        $phoneArray[$key] = str_replace(['[', ']','"'], '', $phone);
                                                                    }
                                                                @endphp
                                                                {{-- Iterate over the email array elements --}}
                                                                @foreach ($phoneArray as $phone)
                                                                    <tr>
                                                                        <td>
                                                                            <input  type="text" class="form-control" placeholder="@lang('lang.mobile_number')" name="mobile_number[]"
                                                                                    value="{{ $phone }}" required >
                                                                                    @error('mobile_number')
                                                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                                                    @enderror
                                                                        </td>
                                                                        <td>
                                                                            <a href="javascript:void(0)" class="btn btn-xs btn-danger deleteRow_phone">-</a>
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
    });
    // +++++++++++++ Delete Row in email +++++++++++++
    $('.email_tbody').on('click','.deleteRow_email',function(){
        $(this).parent().parent().remove();
    });
    // ================================= mobile_phone Repeater =================================
    $('.phone_tbody').on('click','.addRow_phone', function(){
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
    } );
    $('.phone_tbody').on('click','.deleteRow_phone',function(){
        $(this).parent().parent().remove();
    });
</script>
@endpush
