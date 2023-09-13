@extends('layouts.app')
@section('title', __('lang.add_customers'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.add_customers')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">@lang('lang.customers')</a></li>
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
                <div class="container-fluid">
                    <div class="row pt-5">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('customer_type_id', __('lang.customer_type') . ':*') !!}
                                {!! Form::select('customer_type_id', $customer_types, null, [
                                    'class' => 'form-control select2',
                                    'required',
                                    'placeholder' => __('lang.please_select'),
                                ]) !!}
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
                        {{-- +++++++++++++++++++++++++++++++ phone ++++++++++++++++++++++++ --}}
                        <div class="col-md-3">
                            <table class="bordered">
                                <thead class="phone_thead">
                                    <tr>
                                        <th class="text-left" style="font-weight: normal;">@lang('lang.phone')</th>
                                    </tr>
                                </thead>
                                <tbody class="phone_tbody">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                {!! Form::text('phone[]', null, [
                                                    'class' => 'form-control required',
                                                ])!!}
                                                @error('phone')
                                                    <label class="text-danger error-msg">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                            <a href="javascript:void(0)" class="btn btn-xs btn-primary addRow" style="margin-bottom: 10px;" type="button">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>


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
                        {{-- +++++++++++++++++++++++ address +++++++++++++++++++++++ --}}
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
                        {{-- +++++++++++++++++++++++ Notes +++++++++++++++++++++++ --}}
                        <div class="col-md-3">
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
        </div>
    </div>
@endsection
@push('js')
<script src="{{asset('js/product/customer.js')}}" ></script>
{{-- +++++++++++++++++++++++++++++++ Add New Row in phone ++++++++++++++++++++++++ --}}
<script>
    $('.phone_tbody').on('click','.addRow', function(){
        console.log('new phone inputField was added');
        var tr = `<tr>
                    <td>
                        <input type="text" name="phone[]" class="form-control" placeholder="Enter phone number" />
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
