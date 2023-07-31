@extends('layouts.app')
@section('title', __('lang.moneysafes'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.moneysafes')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.moneysafes')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createMoneySafeModal">
                        @lang('lang.add_moneysafe')
                      </button>
                </div>
            </div>
   </div>
    </div>
     @include('money_safe.create')
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
                                <h5 class="card-title">@lang('lang.moneysafe')</h5>
                            </div>
                            <div class="card-body">
                                {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('lang.name')</th>
                                            <th>@lang('lang.type')</th>
                                            <th>@lang('lang.currency')</th>
                                            <th>@lang('lang.balance')</th>
                                            <th>@lang('added_by')</th>
                                            <th>@lang('updated_by')</th>
                                            <th>@lang('lang.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($moneysafe as $index=>$m_safe)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{$m_safe->name}}</td>
                                            <td>@lang('lang.'.$m_safe->type.'')</td>
                                            <td>{{$m_safe->currency->currency}}</td>
                                            <td>
                                                {{$m_safe->latest_balance}}
                                            </td>
                                            <td>
                                                @if ($m_safe->created_by  > 0 and $m_safe->created_by != null)
                                                    {{ $m_safe->created_at->diffForHumans() }} <br>
                                                    {{ $m_safe->created_at->format('Y-m-d') }}
                                                    ({{ $m_safe->created_at->format('h:i') }})
                                                    {{ ($m_safe->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                    {{ $m_safe->createBy?->name }}
                                                @else
                                                {{ __('no_update') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($m_safe->edited_by  > 0 and $m_safe->edited_by != null)
                                                    {{ $m_safe->updated_at->diffForHumans() }} <br>
                                                    {{ $m_safe->updated_at->format('Y-m-d') }}
                                                    ({{ $m_safe->updated_at->format('h:i') }})
                                                    {{ ($m_safe->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                    {{ $m_safe->updateBy?->name }}
                                                @else
                                                   {{ __('no_update') }}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <li>
                                                            <a data-href="{{route('moneysafe.get-add-money-to-safe', $m_safe->id)}}" data-container=".view_modal" class="btn btn-modal" data-toggle="modal"> <i class="fas fa-plus"></i> @lang('lang.add_to_money_safe')</a>
                                                        </li>
                                                        <li>
                                                            <a data-href="{{route('moneysafe.get-take-money-to-safe', $m_safe->id)}}" data-container=".view_modal" class="btn btn-modal" data-toggle="modal"> <i class="fas fa-minus"></i> @lang('lang.take_money_safe')</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{route('moneysafe.watch-money-to-safe-transaction', $m_safe->id)}}" class="btn" target="_blank" > <i class="fas fa-eye"></i> @lang('lang.watch_statement')</a>
                                                        </li>
                                                        <li>
                                                            <a data-href="{{route('moneysafe.edit', $m_safe->id)}}" data-container=".view_modal" class="btn btn-modal" data-toggle="modal"><i class="dripicons-document-edit"></i> @lang('lang.update')</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{route('moneysafe.destroy', $m_safe->id)}}"
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