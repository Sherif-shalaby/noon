@extends('layouts.app')
@section('title', __('lang.stores'))
{{-- ++++++++++++++ start : breadcrumbbar ++++++++++++++ --}}
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.stores')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="#">@lang('lang.settings')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.stores')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-store" href="{{route('store.create')}}">@lang('lang.add_store')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- ++++++++++++++ end : breadcrumbbar ++++++++++++++ --}}
@section('content')

    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.stores')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    <form action="{{route('store.index')}}" method="get" id="filters_form">
                                        <div class="row">
                                            {{-- ++++++++++++++++++++ branches filter ++++++++++++++++++++ --}}
                                            <div class="col-2">
                                                <div class="form-group">
                                                    {!! Form::label('branch_id' ,__('lang.branch')) !!}
                                                    {!! Form::select('branch_id',$branches,request()->brach_id,
                                                        ['class' => 'form-control select2 store','placeholder'=>__('lang.please_select'), 'id' => 'branch_id']
                                                    ) !!}
                                                </div>
                                            </div>
                                            {{-- ++++++++++++++++++++ stores filter ++++++++++++++++++++ --}}
                                            <div class="col-2">
                                                <div class="form-group">
                                                    {!! Form::label('store_id' ,__('lang.store')) !!}
                                                    {!! Form::select(
                                                        'store_id',[],request()->store_id,['class' => 'form-control select2 store','placeholder'=>__('lang.please_select'), 'id' => 'store_id']
                                                    ) !!}
                                                </div>
                                            </div>
                                            <div class="col-2 mt-4">
                                                <div class="form-group">
                                                    <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                                                        <i class="fa fa-eye"></i> {{ __('lang.filter') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                            <tr>
                                <th>@lang('lang.name')</th>
                                <th>@lang('lang.branch')</th>
                                <th>@lang('lang.phone_number')</th>
                                <th>@lang('lang.email')</th>
                                <th>@lang('lang.manager_name')</th>
                                <th>@lang('lang.manager_mobile_number')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stores as $store)
                                <tr>
                                    <td>{{$store->name}}</td>
                                    <td>{{!empty($store->branch) ? $store->branch->name : ''}}</td>
                                    <td>{{$store->phone_number}}</td>
                                    <td>{{$store->email}}</td>
                                    <td>{{$store->manager_name}}</td>
                                    <td>{{$store->manager_mobile_number}}</td>
                                    <td class="no-print">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span></button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <li>
                                                    <a data-href="{{route('store.edit', $store->id)}}"
                                                       data-container=".view_modal" class="btn btn-modal"><i
                                                            class="dripicons-document-edit"></i> @lang('lang.edit')</a>                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{route('store.destroy', $store->id)}}"
                                                       class="btn delete_item text-red delete_item"><i
                                                            class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
     @include('store.create')
@endsection
<div class="view_modal no-print" ></div>
@push('javascripts')
    <script>
        // +++++++++++++++++++++++++++++++++ branches and stores filter +++++++++++++++++++++++++++++++++
        $('#branch_id').change(function(event) {
            var idBranch = this.value;
            // alert(idSubcategory1);
            $('#store_id').html('');
                $.ajax({
                    url: "/api/fetch_branch_stores",
                    type: 'POST',
                    dataType: 'json',
                    data: {branch_id: idBranch,_token:"{{ csrf_token() }}"},
                    success:function(response)
                    {
                        console.log(response);
                        $('#store_id').html('<option value="">{{ __("lang.store") }}</option>');
                        // $.each(response.branch_id,function(index, val)
                        $.each(response.store_id,function(index, val)
                        {
                            console.log("id = "+val.id ,"value = "+val.name);
                            $('#store_id').append('<option value="'+val.id+'">'+val.name+'</option>')
                        });
                    },
                    error: function (error)
                    {
                        console.error("Error fetching filtered stores:", error);
                    }

                })
        });
    </script>
@endpush
