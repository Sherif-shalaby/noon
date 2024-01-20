@extends('layouts.app')
@section('title', __('lang.wages'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.wages')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.wages')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('wages.create')}}" class="btn btn-primary">
                        @lang('lang.add_wages')
                      </a>
                </div>
            </div>
        </div>
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
@endsection
@section('content')
       <!-- Start Contentbar -->
       <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.wages')</h5>
                    </div>
                    {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                    <div class="col-md-4 col-lg-4">
                        <div class="multiselect col-md-6">
                            <div class="selectBox" onclick="showCheckboxes()">
                                <select class="form-select form-control form-control-lg">
                                    <option>@lang('lang.show_hide_columns')</option>
                                </select>
                                <div class="overSelect"></div>
                            </div>
                            <div id="checkboxes">
                                {{-- +++++++++++++++++ checkbox1 : date_of_creation +++++++++++++++++ --}}
                                <label for="col1_id">
                                    <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                    <span>@lang('lang.date_of_creation')</span> &nbsp;
                                </label>
                                {{-- +++++++++++++++++ checkbox2 : name +++++++++++++++++ --}}
                                <label for="col2_id">
                                    <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                    <span>@lang('lang.name')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox3 : account_period +++++++++++++++++ --}}
                                <label for="col3_id">
                                    <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                    <span>@lang('lang.account_period')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox4 : job_title +++++++++++++++++ --}}
                                <label for="col4_id">
                                    <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                    <span>@lang('lang.job_title')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox5 : amount_paid +++++++++++++++++ --}}
                                <label for="col5_id">
                                    <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                    <span>@lang('lang.amount_paid')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox6 : type_of_payment +++++++++++++++++ --}}
                                <label for="col6_id">
                                    <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                    <span>@lang('lang.type_of_payment')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox7 : date_of_payment +++++++++++++++++ --}}
                                <label for="col7_id">
                                    <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                    <span>@lang('lang.date_of_payment')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox8 : paid_by +++++++++++++++++ --}}
                                <label for="col8_id">
                                    <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                    <span>@lang('lang.paid_by')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox9 : type_of_payment +++++++++++++++++ --}}
                                <label for="col9_id">
                                    <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                    <span>@lang('lang.type_of_payment')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox10 : added_by +++++++++++++++++ --}}
                                <label for="col10_id">
                                    <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                    <span>@lang('lang.added_by')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox11 : updated_by +++++++++++++++++ --}}
                                <label for="col11_id">
                                    <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                    <span>@lang('lang.updated_by')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox12 : action +++++++++++++++++ --}}
                                <label for="col12_id">
                                    <input type="checkbox" id="col12_id" name="col12" checked="checked" />
                                    <span>@lang('lang.action')</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- ++++++++++++++++++ Table ++++++++++++++++++ --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{-- @include('wages.filters') --}}
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="col1">@lang('lang.date_of_creation')</th>
                                    <th class="col2">@lang('lang.name')</th>
                                    <th class="col3">@lang('lang.account_period')</th>
                                    <th class="col4">@lang('lang.job_title')</th>
                                    <th class="col5">@lang('lang.amount_paid')</th>
                                    <th class="col6">@lang('lang.type_of_payment')</th>
                                    <th class="col7">@lang('lang.date_of_payment')</th>
                                    <th class="col8">@lang('lang.paid_by')</th>
                                    <th class="col9">@lang('lang.status')</th>
                                    <th class="col10">@lang('added_by')</th>
                                    <th class="col11">@lang('updated_by')</th>
                                    <th class="col12">@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($wages as $index=>$wage)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td class="col1">{{$wage->date_of_creation}}</td>
                                   <td class="col2">{{$wage->employee->employee_name}}</td>
                                   <td class="col3">
                                        @if ($wage->payment_type == 'salary')
                                        {{ \Carbon\Carbon::parse($wage->account_period)->format('F') }}
                                        @else
                                            @if (!empty($wage->acount_period_start_date))
                                                {{ @format_date($wage->acount_period_start_date) }}
                                            @endif
                                            -
                                            @if (!empty($wage->acount_period_end_date))
                                                {{ @format_date($wage->acount_period_end_date) }}
                                            @endif
                                        @endif
                                   </td>
                                   <td class="col4"></td>
                                    {{-- <td>{{$wage->employee->job_type->title}}</td> --}}
                                    <td class="col5">
                                        {{-- {{ $settings['currency'] }} --}}
                                        {{ @num_format($wage->net_amount) }}
                                    </td>
                                    <td class="col6">
                                        @if (!empty($payment_types[$wage->payment_type]))
                                        {{ $payment_types[$wage->payment_type] }}
                                        @endif
                                    </td>
                                    <td class="col7">{{ @format_date($wage->payment_date) }}</td>
                                    <td class="col8">
                                        @if (!empty($wage->wage_transaction))
                                        {{ $wage->wage_transaction->source->name }}
                                        @endif
                                    </td>
                                    <td class="col9">{{ ucfirst($wage->status) }}</td>
                                    <td class="col10">
                                        @if ($wage->created_by  > 0 and $wage->created_by != null)
                                            {{ $wage->created_at->diffForHumans() }} <br>
                                            {{ $wage->created_at->format('Y-m-d') }}
                                            ({{ $wage->created_at->format('h:i') }})
                                            {{ ($wage->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                            {{ $wage->createBy?->name }}
                                        @else
                                        {{ __('no_update') }}
                                        @endif
                                    </td>
                                    <td class="col11">
                                        @if ($wage->updated_by  > 0 and $wage->updated_by != null)
                                            {{ $wage->updated_at->diffForHumans() }} <br>
                                            {{ $wage->updated_at->format('Y-m-d') }}
                                            ({{ $wage->updated_at->format('h:i') }})
                                            {{ ($wage->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                            {{ $wage->updateBy?->name }}
                                        @else
                                           {{ __('no_update') }}
                                        @endif
                                    </td>
                                    <td class="col12">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <li>
                                                    <a href="{{route('wages.edit', $wage->id)}}" class="btn" target="_blank"><i class="dripicons-document-edit"></i> @lang('lang.update')</a>
                                                </li>
                                                <li class="divider"></li>
                                                    <li>
                                                        <a data-href="{{route('wages.destroy', $wage->id)}}"
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
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection
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
