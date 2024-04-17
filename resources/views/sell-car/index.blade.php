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
                {{-- +++++++++++++++ Style : checkboxes and labels inside selectbox +++++++++++++++ --}}
                <style>
                    .selectBox {
                    position: relative;
                    }

                    /* selectbox style */
                    .selectBox select
                    {
                        width: 100%;
                        padding: 0 !important;
                        padding-left: 4px;
                        padding-right: 4px;
                        color: #fff;
                        border: 1px solid #596fd7;
                        background-color: #596fd7;
                        height: 39px !important;
                    }

                    .overSelect {
                    position: absolute;
                    left: 0;
                    right: 0;
                    top: 0;
                    bottom: 0;
                    }

                    #checkboxes {
                    display: none;
                    border: 1px #dadada solid;
                    height: 125px;
                    overflow: auto;
                    padding-top: 10px;
                    /* text-align: end;  */
                    }

                    #checkboxes label {
                    display: block;
                    padding: 5px;

                    }

                    #checkboxes label:hover {
                    background-color: #ddd;
                    }
                    #checkboxes label span
                    {
                        font-weight: normal;
                    }
                </style>
                {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                <div class="col-md-4 col-lg-4 mt-3">
                    <div class="multiselect col-md-6">
                        <div class="selectBox" onclick="showCheckboxes()">
                            <select class="form-select form-control form-control-lg">
                                <option>@lang('lang.show_hide_columns')</option>
                            </select>
                            <div class="overSelect"></div>
                        </div>
                        <div id="checkboxes">
                            {{-- +++++++++++++++++ checkbox1 : # +++++++++++++++++ --}}
                            <label for="col1_id">
                                <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                <span>#</span> &nbsp;
                            </label>
                            {{-- +++++++++++++++++ checkbox2 : driver_name +++++++++++++++++ --}}
                            <label for="col2_id">
                                <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                <span>@lang('lang.driver_name')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox3 : car_name +++++++++++++++++ --}}
                            <label for="col3_id">
                                <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                <span>@lang('lang.car_name')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox4 : car_number +++++++++++++++++ --}}
                            <label for="col4_id">
                                <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                <span>@lang('lang.car_number')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox5 : sell_representative +++++++++++++++++ --}}
                            <label for="col5_id">
                                <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                <span>@lang('lang.sell_representative')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox6 : car_type +++++++++++++++++ --}}
                            <label for="col6_id">
                                <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                <span>@lang('lang.car_type')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox7 : car_size +++++++++++++++++ --}}
                            <label for="col7_id">
                                <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                <span>@lang('lang.car_size')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox8 : car_license +++++++++++++++++ --}}
                            <label for="col8_id">
                                <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                <span>@lang('lang.car_license')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox9 : car_model +++++++++++++++++ --}}
                            <label for="col9_id">
                                <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                <span>@lang('lang.car_model')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox10 : car_license_end_date +++++++++++++++++ --}}
                            <label for="col10_id">
                                <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                <span>@lang('lang.car_license_end_date')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox11 : stock_module +++++++++++++++++ --}}
                            <label for="col11_id">
                                <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                <span>@lang('lang.stock_module')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox12 : total_sells driver_name +++++++++++++++++ --}}
                            <label for="col12_id">
                                <input type="checkbox" id="col12_id" name="col12" checked="checked" />
                                <span>@lang('lang.total_sells') @lang('lang.driver_name')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox13 : total_sells sell_representative +++++++++++++++++ --}}
                            <label for="col13_id">
                                <input type="checkbox" id="col13_id" name="col13" checked="checked" />
                                <span>@lang('lang.total_sells') @lang('lang.sell_representative')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox14 : added_by +++++++++++++++++ --}}
                            <label for="col14_id">
                                <input type="checkbox" id="col14_id" name="col14" checked="checked" />
                                <span>@lang('lang.added_by')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox15 : updated_by +++++++++++++++++ --}}
                            <label for="col15_id">
                                <input type="checkbox" id="col15_id" name="col15" checked="checked" />
                                <span>@lang('lang.updated_by')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox16 : action +++++++++++++++++ --}}
                            <label for="col16_id">
                                <input type="checkbox" id="col16_id" name="col16" checked="checked" />
                                <span>@lang('lang.action')</span>
                            </label>
                        </div>
                    </div>
                </div> <br/>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                                <tr>
                                    <th class="col1">#</th>
                                    <th class="col2">@lang('lang.driver_name')</th>
                                    <th class="col3">@lang('lang.car_name')</th>
                                    <th class="col4">@lang('lang.car_number')</th>
                                    <th class="col5">@lang('lang.sell_representative')</th>
                                    <th class="col6">@lang('lang.car_type')</th>
                                    <th class="col7">@lang('lang.car_size')</th>
                                    <th class="col8">@lang('lang.car_license')</th>
                                    <th class="col9">@lang('lang.car_model')</th>
                                    <th class="col10">@lang('lang.car_license_end_date')</th>
                                    <th class="col11">@lang('lang.stock_module')</th>
                                    <th class="col12">@lang('lang.total_sells') @lang('lang.driver_name')</th>
                                    <th class="col13">@lang('lang.total_sells') @lang('lang.sell_representative')</th>
                                    <th class="col14">@lang('lang.added_by')</th>
                                    <th class="col15">@lang('lang.updated_by')</th>
                                    <th class="col16 notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sell_cars as $index=>$sell_car)
                                    <tr>
                                        <td class="col1">{{$index+1}}</td>
                                        <td class="col2">{{$sell_car->driver->employee_name ?? ''}}</td>
                                        <td class="col3">{{$sell_car->car_name}}</td>
                                        <td class="col4">{{$sell_car->car_no}}</td>
                                        <td class="col5">{{$sell_car->representative->employee_name??''}}</td>
                                        <td class="col6">{{$sell_car->car_type}}</td>
                                        <td class="col7">{{$sell_car->car_size}}</td>
                                        <td class="col8">{{$sell_car->car_license}}</td>
                                        <td class="col9">{{$sell_car->car_model}}</td>
                                        <td class="col10">{{$sell_car->car_license_end_date}}</td>
                                        @php
                                            $branchExists = false;
                                            if($sell_car->branch){
                                                $branchExists = true;
                                                $store_sell_car = $sell_car->branch->stores->first();
                                                $products_store = \App\Models\ProductStore::where('store_id',$store_sell_car->id)->get();
                                                $transaction_sell_lines_for_driver  = \App\Models\TransactionSellLine::where('store_pos_id',$sell_car->driver_id)
                                                    ->where('store_id',$store_sell_car->id)->get();
                                                $transaction_sell_lines_for_rep  = \App\Models\TransactionSellLine::where('store_pos_id',$sell_car->representative_id)
                                                    ->where('store_id',$store_sell_car->id)->get();

                                                }
                                        @endphp
                                        <td class="col11">
                                            @if(isset($store_sell_car) && !empty($store_sell_car))$
                                            @endif

                                        </td>
                                        <td class="col12">
                                            @if(isset($transaction_sell_lines_for_driver) && !empty($transaction_sell_lines_for_driver))
                                                <span> {{ '( $ '. $transaction_sell_lines_for_driver->sum('dollar_final_total') . ')' }} </span><br>
                                                <span> {{ '( '. $transaction_sell_lines_for_driver->sum('final_total') . ')' }} </span><br>
                                            @endif
                                        </td>
                                        <td class="col13">
                                            @if(isset($transaction_sell_lines_for_rep) && !empty($transaction_sell_lines_for_rep))
                                                <span> {{ '( $ '. $transaction_sell_lines_for_rep->sum('dollar_final_total') . ')' }} </span><br>
                                                <span> {{ '( '. $transaction_sell_lines_for_rep->sum('final_total') . ')' }} </span><br>
                                            @endif
                                        </td>
                                        <td class="col14">
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
                                        <td class="col15">
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
                                        <td class="col16 no-print">
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
@section('javascript')
    {{-- +++++++++++++++ Show/Hide checkboxes +++++++++++++++ --}}
    <script>
        // +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++
        $("input:checkbox:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });

        $("input:checkbox").click(function(){
            var column = "table ." + $(this).attr("name");
            $(column).toggle();
        });
        // +++++++++++++++++ Checkboxs and label inside selectbox : showCheckboxes() method ++++++++++++++
        var expanded = false;
        function showCheckboxes()
        {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }
    </script>
@endsection
