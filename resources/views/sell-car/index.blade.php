@extends('layouts.app')
@section('title', __('lang.sell_car'))


@push('css')
    <style>
        .table-top-head {
            top: 35px;
        }

        .wrapper1 {
            margin-top: 35px;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 120px;
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.sell_car')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.sell_car')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-store"
            href="{{ route('store.create') }}">@lang('lang.add')</button>
    </div>
@endsection

@section('content')
    <div class="animte-in-page">

        <div class="container-fluid">
            <div class="col-md-12  no-print">
                <div class="card mt-1">
                    <div
                        class="card-header d-flex align-items-center  @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h6>@lang('lang.sell_car')</h6>
                    </div>
                    <div class="card-body">
                        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif ">
                            <div class="div1"></div>
                        </div>
                        <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div2 table-scroll-wrapper">
                                <!-- content goes here -->
                                <div style="min-width: 1300px;max-height: 90vh;overflow: auto">
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
                                            @foreach ($sell_cars as $index => $sell_car)
                                                <tr>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600">
                                                            {{ $index + 1 }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.driver_name')">
                                                            {{ $sell_car->driver->employee_name ?? '' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.car_name')">
                                                            {{ $sell_car->car_name }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.car_number')">
                                                            {{ $sell_car->car_no }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.sell_representative')">
                                                            {{ $sell_car->representative->employee_name ?? '' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.car_type')">
                                                            {{ $sell_car->car_type }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.car_size')">
                                                            {{ $sell_car->car_size }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.car_license')">
                                                            {{ $sell_car->car_license }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.car_model')">
                                                            {{ $sell_car->car_model }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.car_license_end_date')">
                                                            {{ $sell_car->car_license_end_date }}
                                                        </span>
                                                    </td>
                                                    @php
                                                        $branchExists = false;
                                                        if ($sell_car->branch) {
                                                            $branchExists = true;
                                                            // Assuming you want to get the first store of the first sell car with a branch
                                                            $store_sell_car = $sell_car->branch->stores->first();
                                                            $products_store = \App\Models\ProductStore::where('store_id', $store_sell_car->id)->get();
                                                            $transaction_sell_lines_for_driver = \App\Models\TransactionSellLine::where('store_pos_id', $sell_car->driver_id)
                                                                ->where('store_id', $store_sell_car->id)
                                                                ->get();
                                                            $transaction_sell_lines_for_rep = \App\Models\TransactionSellLine::where('store_pos_id', $sell_car->representative_id)
                                                                ->where('store_id', $store_sell_car->id)
                                                                ->get();
                                                        }
                                                    @endphp
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.stock_module')">

                                                            @if (isset($store_sell_car) && !empty($store_sell_car))
                                                                $
                                                            @endif

                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.total_sells')">

                                                            @if (isset($transaction_sell_lines_for_driver) && !empty($transaction_sell_lines_for_driver))
                                                                <span>
                                                                    {{ '( $ ' . $transaction_sell_lines_for_driver->sum('dollar_final_total') . ')' }}
                                                                </span><br>
                                                                <span>
                                                                    {{ '( ' . $transaction_sell_lines_for_driver->sum('final_total') . ')' }}
                                                                </span><br>
                                                            @endif
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.total_sells')">

                                                            @if (isset($transaction_sell_lines_for_rep) && !empty($transaction_sell_lines_for_rep))
                                                                <span>
                                                                    {{ '( $ ' . $transaction_sell_lines_for_rep->sum('dollar_final_total') . ')' }}
                                                                </span><br>
                                                                <span>
                                                                    {{ '( ' . $transaction_sell_lines_for_rep->sum('final_total') . ')' }}
                                                                </span><br>
                                                            @endif
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span style="font-size: 10px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.added_by')">

                                                            @if ($sell_car->created_by > 0 and $sell_car->created_by != null)
                                                                {{ $sell_car->created_at->diffForHumans() }} <br>
                                                                {{ $sell_car->created_at->format('Y-m-d') }}
                                                                ({{ $sell_car->created_at->format('h:i') }})
                                                                {{ $sell_car->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                <br>
                                                                {{ $sell_car->createBy?->name }}
                                                            @else
                                                                {{ __('no_update') }}
                                                            @endif
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span style="font-size: 12px;font-weight: 600"
                                                            class="custom-tooltip" data-tooltip="@lang('lang.updated_by')">

                                                            @if ($sell_car->edited_by > 0 and $sell_car->edited_by != null)
                                                                {{ $sell_car->updated_at->diffForHumans() }} <br>
                                                                {{ $sell_car->updated_at->format('Y-m-d') }}
                                                                ({{ $sell_car->updated_at->format('h:i') }})
                                                                {{ $sell_car->updated_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                <br>
                                                                {{ $sell_car->updateBy?->name }}
                                                            @else
                                                                {{ __('no_update') }}
                                                            @endif
                                                        </span>

                                                    </td>
                                                    <td class="no-print">
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                class="btn btn-default btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                style="font-size: 12px;font-weight: 600"
                                                                aria-expanded="false">خيارات
                                                                <span class="caret"></span></button>
                                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                user="menu" x-placement="bottom-end"
                                                                style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                <li>
                                                                    <a data-href="{{ route('sell-car.edit', $sell_car->id) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal"><i
                                                                            class="dripicons-document-edit"></i>
                                                                        @lang('lang.edit')</a>
                                                                </li>
                                                                <li>
                                                                    <a data-href="{{ route('sell-car.destroy', $sell_car->id) }}"
                                                                        {{--                                                       data-check_password="{{action('UserController@checkPassword', Auth::user()->id) }}" --}}
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif delete_item text-red delete_item"><i
                                                                            class="fa fa-trash"></i>
                                                                        @lang('lang.delete')</a>
                                                                </li>
                                                                @if (!empty($sell_car->branch))
                                                                    <li>
                                                                        <a href="{{ route('transfer.import', $sell_car->id) }}"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                                            <i class="fas fa-plus"></i>@lang('lang.import_stock')
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="{{ route('transfer.export', $sell_car->id) }}"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
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
            </div>
        </div>
    </div>

    {{--     create sell_car modal      --}}
    @include('sell-car.create')
@endsection
<div class="view_modal no-print"></div>
