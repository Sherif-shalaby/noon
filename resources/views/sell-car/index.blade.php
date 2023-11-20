@extends('layouts.app')
@section('title', __('lang.sell_car'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.sell_car')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.sell_car')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-store" href="{{route('store.create')}}">@lang('lang.add')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
                    <h4 >@lang('lang.sell_car')</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang.driver_name')</th>
                                <th>@lang('lang.car_name')</th>
                                <th>@lang('lang.car_number')</th>
                                <th>@lang('lang.sell_representative')</th>
                                <th>@lang('lang.car_type')</th>
                                <th>@lang('lang.car_size')</th>
                                <th>@lang('lang.car_license')</th>
                                <th>@lang('lang.car_model')</th>
                                <th>@lang('lang.car_license_end_date')</th>
                                <th>@lang('lang.stock_module')</th>
                                <th>@lang('lang.total_sells') @lang('lang.driver_name')</th>
                                <th>@lang('lang.total_sells') @lang('lang.sell_representative')</th>
                                <th>@lang('lang.added_by')</th>
                                <th>@lang('lang.updated_by')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sell_cars as $index=>$sell_car)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$sell_car->driver->employee_name ?? ''}}</td>
                                    <td>{{$sell_car->car_name}}</td>
                                    <td>{{$sell_car->car_no}}</td>
                                    <td>{{$sell_car->representative->employee_name??''}}</td>
                                    <td>{{$sell_car->car_type}}</td>
                                    <td>{{$sell_car->car_size}}</td>
                                    <td>{{$sell_car->car_license}}</td>
                                    <td>{{$sell_car->car_model}}</td>
                                    <td>{{$sell_car->car_license_end_date}}</td>
                                    @php
                                        $branchExists = false;
                                        if($sell_car->branch){
                                            $branchExists = true;
                                            // Assuming you want to get the first store of the first sell car with a branch
                                            $store_sell_car = $sell_car->branch->stores->first();
                                            $products_store = \App\Models\ProductStore::where('store_id',$store_sell_car->id)->get();
                                             $transaction_sell_lines_for_driver  = \App\Models\TransactionSellLine::where('store_pos_id',$sell_car->driver_id)
                                                ->where('store_id',$store_sell_car->id)->get();
                                             $transaction_sell_lines_for_rep  = \App\Models\TransactionSellLine::where('store_pos_id',$sell_car->representative_id)
                                                ->where('store_id',$store_sell_car->id)->get();

                                            }
                                    @endphp
                                    <td>
                                        @if(isset($store_sell_car) && !empty($store_sell_car))$
                                        @endif

                                    </td>
                                    <td>
                                        @if(isset($transaction_sell_lines_for_driver) && !empty($transaction_sell_lines_for_driver))
                                            <span> {{ '( $ '. $transaction_sell_lines_for_driver->sum('dollar_final_total') . ')' }} </span><br>
                                            <span> {{ '( '. $transaction_sell_lines_for_driver->sum('final_total') . ')' }} </span><br>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($transaction_sell_lines_for_rep) && !empty($transaction_sell_lines_for_rep))
                                            <span> {{ '( $ '. $transaction_sell_lines_for_rep->sum('dollar_final_total') . ')' }} </span><br>
                                            <span> {{ '( '. $transaction_sell_lines_for_rep->sum('final_total') . ')' }} </span><br>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($sell_car->created_by  > 0 and $sell_car->created_by != null)
                                            {{ $sell_car->created_at->diffForHumans() }} <br>
                                            {{ $sell_car->created_at->format('Y-m-d') }}
                                            ({{ $sell_car->created_at->format('h:i') }})
                                            {{ ($sell_car->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                            {{ $sell_car->createBy?->name }}
                                        @else
                                        {{ __('no_update') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($sell_car->edited_by  > 0 and $sell_car->edited_by != null)
                                            {{ $sell_car->updated_at->diffForHumans() }} <br>
                                            {{ $sell_car->updated_at->format('Y-m-d') }}
                                            ({{ $sell_car->updated_at->format('h:i') }})
                                            {{ ($sell_car->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                            {{ $sell_car->updateBy?->name }}
                                        @else
                                           {{ __('no_update') }}
                                        @endif
                                    </td>
                                    <td class="no-print">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات <span class="caret"></span></button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <li>
                                                    <a data-href="{{route('sell-car.edit', $sell_car->id)}}"
                                                       data-container=".view_modal" class="btn btn-modal"><i
                                                            class="dripicons-document-edit"></i> @lang('lang.edit')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{route('sell-car.destroy', $sell_car->id)}}"
{{--                                                       data-check_password="{{action('UserController@checkPassword', Auth::user()->id) }}"--}}
                                                       class="btn delete_item text-red delete_item"><i
                                                            class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>
                                                @if(!empty($sell_car->branch))
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{route('transfer.import', $sell_car->id)}}" class="btn">
                                                            <i class="fas fa-plus"></i>@lang('lang.import_stock')
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{route('transfer.export', $sell_car->id)}}" class="btn">
                                                            <i class="fas fa-minus"></i>@lang('lang.export_stock')
                                                        </a>
                                                    </li>
                                                @endif
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
    {{--     create sell_car modal      --}}
    @include('sell-car.create')
@endsection
<div class="view_modal no-print" ></div>
