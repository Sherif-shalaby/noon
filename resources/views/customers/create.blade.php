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
                    'id' => 'customer-form'
                ]) !!}
                <div class="container-fluid">
                    <div class="row pt-5">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                        {{-- +++++++++++++++++++++++ min_amount_in_dollar +++++++++++++++++++++++ --}}
                        <div class="col-md-4 mb-3 ">
                            <div class="form-group">
                                <label for="min_amount_in_dollar">@lang('lang.min_amount_in_dollar')</label>
                                <input type="number" class="form-control" name="min_amount_in_dollar" id="min_amount_in_dollar" />
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ max_amount_in_dollar +++++++++++++++++++++++ --}}
                        <div class="col-md-4 mb-3 ">
                            <div class="form-group">
                                <label for="max_amount_in_dollar">@lang('lang.max_amount_in_dollar')</label>
                                <input type="number" class="form-control" name="max_amount_in_dollar" id="max_amount_in_dollar" />
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ min_amount_in_dinar +++++++++++++++++++++++ --}}
                        <div class="col-md-4 mb-3 ">
                            <div class="form-group">
                                <label for="min_amount_in_dinar">@lang('lang.min_amount_in_dinar')</label>
                                <input type="number" class="form-control" name="min_amount_in_dinar" id="min_amount_in_dinar" />
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ max_amount_in_dinar +++++++++++++++++++++++ --}}
                        <div class="col-md-4 mb-3 ">
                            <div class="form-group">
                                <label for="max_amount_in_dinar">@lang('lang.max_amount_in_dinar')</label>
                                <input type="number" class="form-control" name="max_amount_in_dinar" id="max_amount_in_dinar" />
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ balance_in_dollar +++++++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="balance_in_dollar">@lang('lang.balance_in_dollar')</label>
                                <input type="text" class="form-control" name="balance_in_dollar" id="balance_in_dollar" />
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ balance_in_dinar +++++++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="balance_in_dinar">@lang('lang.balance_in_dinar')</label>
                                <input type="text" class="form-control" name="balance_in_dinar" id="balance_in_dinar" />
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ address +++++++++++++++++++++++ --}}
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
                        {{-- +++++++++++++++++++++++ Notes +++++++++++++++++++++++ --}}
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
                        {{-- +++++++++++++++++++++++++++++++ phone ++++++++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <table class="bordered">
                                <thead class="phone_thead">
                                    <tr>
                                        <th class="text-left" style="font-weight: normal;">@lang('lang.phone')</th>
                                    </tr>
                                </thead>
                                <tbody class="phone_tbody">
                                    <tr>
                                        <td class="col-md-12 p-0">
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
                                            <a href="javascript:void(0)" class="btn btn-xs btn-primary addRow" style="margin-bottom: 10px;" type="button"  id="submit-btn">
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
                                <label>@lang('lang.upload_image')</label>
                                <input class="form-control img" name="image" type="file" accept="image/*" id="image">
                                {{-- Crop Image : cropper.js --}}
                                {{-- <div class="dropzone" id="my-dropzone2" required>
                                    <div class="dz-message" data-dz-message><span>@lang('categories.drop_file_here_to_upload')</span></div>
                                </div> --}}
                                @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
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
            <!-- End col -->
            <!-- ++++++++++++ Crop_Image Modal ++++++++++++ -->
            {{-- @include('categories.modalCrop')  --}}
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
    // +++++++++++++++++++++++++++++++ Add New Row in email ++++++++++++++++++++++++
    $('.email_tbody').on('click','.addRow_email', function(){
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

                </td>
            </tr>`;
        $('.email_tbody').append(tr);
    } );
    $('.email_tbody').on('click','.deleteRow_email',function(){
        $(this).parent().parent().remove();
    });
</script>
@endpush
