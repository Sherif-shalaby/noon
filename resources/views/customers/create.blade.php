@extends('layouts.app')
@section('title', __('lang.add_customers'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.add_customers')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('customers.index')}}">@lang('lang.customers')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.add_customers')</li>
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
                {!! Form::open([
                    'route' => 'customers.store',
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ]) !!}
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('customer_type_id', __('lang.customer_type') . ':*') !!}
                            {!! Form::select('customer_type_id', $customer_types, null, [
                            'class' => 'form-control select2',
                            'required',
                            'placeholder' => __('lang.please_select'),]) !!}
                             @error('customer_type_id')
                             <label class="text-danger error-msg">{{ $message }}</label>
                             @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        {!! Form::label('name', __('lang.name')) !!}
                        {!! Form::text('name', null, [
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
                        {!! Form::text('phone', null, [
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
                        {!! Form::email('email', null, [
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
                            {!! Form::textarea('address', null, [
                                'class' => 'form-control',
                            ]) !!}
                             @error('address')
                                <label class="text-danger error-msg">{{ $message }}</label>
                             @enderror
                        </div>
                    </div>
        
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                    </div>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection