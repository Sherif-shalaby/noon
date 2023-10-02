@extends('layouts.app')
@section('title', __('lang.edit_customers'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.edit_customers')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('customers.index')}}">@lang('lang.customers')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.edit_customers')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start row -->
    <div class="row d-flex justify-content-center">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">
                {!! Form::open(['route' => ['customers.update',$customer->id],'method'=>'put','id'=>'brand-update-form' ]) !!}
                @csrf
                @method('PUT')
                <div class="container-fluid">
                    <div class="row pt-4">
                        {{-- ++++++++++++++++++ customer_type ++++++++++++++++ --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('customer_type_id', __('lang.customer_type') . ':*') !!}
                                {!! Form::select('customer_type_id', $customer_types, $customer->customer_type_id, [
                                'class' => 'form-control select2',
                                'required',
                                'placeholder' => __('lang.please_select')]) !!}
                                 @error('customer_type_id')
                                 <label class="text-danger error-msg">{{ $message }}</label>
                                 @enderror
                            </div>
                        </div>
                        {{-- ++++++++++++++++++ name ++++++++++++++++ --}}
                        <div class="col-md-6">
                            <div class="form-group">
                            {!! Form::label('name', __('lang.name')) !!}
                            {!! Form::text('name',  $customer->name, [
                                'class' => 'form-control required',
                            ]) !!}
                             @error('name')
                                <label class="text-danger error-msg">{{ $message }}</label>
                             @enderror
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
                                                        $emailArray = explode(',', $customer->email);
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
                        {{-- +++++++++++++++++++++++++++++++ phone array ++++++++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group ">
                                <table class="bordered">
                                    <thead class="phone_thead">
                                        <tr>
                                            <th class="text-left" style="font-weight: normal;">
                                                <label class="mb-2">
                                                    <span class="text-danger">*</span>@lang('lang.phone')
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
                                                        placeholder="@lang('lang.phone')"
                                                        name="phone[]"
                                                        value="{{ old('phone') }}" required >
                                                    <td class="col-md-6">
                                                        {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                        <a href="javascript:void(0)" class="btn btn-xs btn-primary addRow_phone" type="button">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </td>
                                                    @error('phone')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    @php
                                                        $phoneArray = explode(',', $customer->phone);
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
                                                                <input  type="text" class="form-control" placeholder="@lang('lang.phone')" name="phone[]"
                                                                    value="{{ $phone }}" required >
                                                                    @error('phone')
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- ++++++++++++++++++ address ++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('address', __('lang.address')) !!}
                                {!! Form::textarea('address', $customer->address, [
                                    'class' => 'form-control',
                                ]) !!}
                                 @error('address')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                 @enderror
                            </div>
                        </div>
                    </div>
                    {{-- ++++++++++++++++++ important_dates ++++++++++++++++ --}}
                    <div class="row pt-4 pb-5">
                        <div class="col-md-12">
                            <h3>@lang('lang.important_dates')</h3>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <table class="table table-bordered" id="important_date_table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;">@lang('lang.important_date')</th>
                                            <th style="width: 20%;">@lang('lang.date')</th>
                                            <th style="width: 20%;">@lang('lang.notify_before_days')</th>
                                            <th style="width: 10%;"><button type="button"
                                                    class="add_date btn btn-success btn-xs"><i class="fa fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer->customer_important_dates as $important_date)
                                        @include('customers.important_date_row', ['index' => $loop->index,
                                        'important_date' => $important_date])
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <input type="hidden" name="important_date_index" id="important_date_index" value="{{count($customer->customer_important_dates)}}">
                    </div>
                    {{-- ++++++++++++++++++ submit ++++++++++++++++ --}}
                    <div class="row pb-5">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('js')
<script src="{{asset('js/product/customer.js')}}" ></script>
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
    // ================================= phone Repeater =================================
    $('.phone_tbody').on('click','.addRow_phone', function(){
        console.log('new phone_number inputField was added');
        var tr = `<tr>
                    <td>
                        <input  type="text" class="form-control" placeholder="@lang('lang.phone')" name="phone[]"
                                value="{{ old('phone') }}" required >
                                @error('phone')
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
