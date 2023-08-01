@extends('layouts.app')
@section('title', __('lang.dashboard'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.suppliers')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        {{-- <li class="breadcrumb-item"><a href="#">Brands</a></li> --}}
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.suppliers')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        @lang('lang.add_supplier')
                    </a>
                </div>
            </div>
   </div>
    </div>
@endsection
@section('content')
     <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->    
            <div class="contentbar">                
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title">@lang('lang.suppliers')</h5>
                            </div>
                            <div class="card-body">
                                {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>@lang('lang.name')</th>
                                            <th>@lang('lang.company_name')</th>
                                            <th>@lang('lang.mobile_number')</th>
                                            <th>@lang('lang.created_by')</th>
                                            <th>@lang('lang.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($suppliers as $supplier)
                                        <tr>
                                            <td>{{$supplier->name}}</td>
                                            <td>{{$supplier->company_name}}</td>
                                            <td>{{$supplier->mobile_number}}</td>
                                            <td>{{$supplier->created_by}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <li>

                                                            <a data-href="#" data-container=".view_modal" class="btn btn-modal" data-toggle="modal"><i class="dripicons-document-edit"></i> @lang('lang.update')</a>
                                                            
                                                        </li>
                                                        <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{route('suppliers.destroy', $supplier->id)}}"
                                                                    {{-- data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}}
                                                                    class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                                    @lang('lang.delete')</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="view_modal no-print" >

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
            <!-- End Contentbar -->
        </div>
        <!-- End Rightbar -->
    </div>
@endsection
