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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <div class="form-group">
                            {!! Form::label('phone', __('lang.phone')) !!}
                            {!! Form::text('phone',  $customer->phone, [
                                'class' => 'form-control required',
                            ]) !!}
                             @error('phone')
                                <label class="text-danger error-msg">{{ $message }}</label>
                             @enderror
                            </div>
                        </div>
                      
                        <div class="col-md-3">
                            <div class="form-group">
                            {!! Form::label('email', __('lang.email')) !!}
                            {!! Form::email('email',  $customer->email, [
                                'class' => 'form-control',
                            ]) !!}
                             @error('email')
                                <label class="text-danger error-msg">{{ $message }}</label>
                             @enderror
                            </div>
                        </div>
    
                        <div class="col-md-3">
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
@endpush