@extends('layouts.app')
@section('title', __('lang.representative_salary_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.representative_salary_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.representative_salary_report')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    {{-- <!-- Start row -->
    <div class="row d-flex justify-content-center">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">


            </div>
        </div>
    </div> --}}
       <!-- Start Contentbar -->
       <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.representative_salary_report')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{-- @include('products.filters')  --}}
                                </div>
                            </div>
                        </div>
                        <br/>
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
                        <div class="col-md-4 col-lg-4">
                            <div class="multiselect col-md-6">
                                <div class="selectBox" onclick="showCheckboxes()">
                                    <select class="form-select form-control form-control-lg">
                                        <option>@lang('lang.show_hide_columns')</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="checkboxes">
                                    {{-- +++++++++++++++++ checkbox1 : date +++++++++++++++++ --}}
                                    <label for="col1_id">
                                        <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                        <span>@lang('lang.date')</span> &nbsp;
                                    </label>
                                    {{-- +++++++++++++++++ checkbox2 : employee_name +++++++++++++++++ --}}
                                    <label for="col2_id">
                                        <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                        <span>@lang('lang.employee_name')</span>
                                    </label>
                                    {{-- +++++++++++++++++ checkbox3 : payment_method +++++++++++++++++ --}}
                                    <label for="col3_id">
                                        <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                        <span>@lang('lang.payment_method')</span>
                                    </label>
                                    {{-- +++++++++++++++++ checkbox4 : salary +++++++++++++++++ --}}
                                    <label for="col4_id">
                                        <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                        <span>@lang('lang.salary')</span>
                                    </label>
                                    {{-- +++++++++++++++++ checkbox5 : commission +++++++++++++++++ --}}
                                    <label for="col5_id">
                                        <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                        <span>@lang('lang.commission')</span>
                                    </label>
                                    {{-- +++++++++++++++++ checkbox6 : paid_amount +++++++++++++++++ --}}
                                    <label for="col6_id">
                                        <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                        <span>@lang('lang.paid_amount')</span>
                                    </label>
                                    {{-- +++++++++++++++++ checkbox7 : duePaid +++++++++++++++++ --}}
                                    <label for="col7_id">
                                        <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                        <span>@lang('lang.duePaid')</span>
                                    </label>
                                    {{-- +++++++++++++++++ checkbox8 : payment_status +++++++++++++++++ --}}
                                    <label for="col8_id">
                                        <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                        <span>@lang('lang.payment_status')</span>
                                    </label>
                                </div>
                            </div>
                        </div> <br/>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="col1">@lang('lang.date')</th>
                                    <th class="col2">@lang('lang.employee_name')</th>
                                    <th class="col3">@lang('lang.payment_method')</th>
                                    <th class="col4">@lang('lang.salary')</th>
                                    <th class="col5">@lang('lang.commission')</th>
                                    <th class="col6">@lang('lang.paid_amount')</th>
                                    <th class="col7">@lang('lang.duePaid')</th>
                                    <th class="col8">@lang('lang.payment_status')</th>
                                    {{-- <th>@lang('lang.action')</th>  --}}
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wages as $wage)
                                        @php
                                            $totalAmount = 0; // Initialize the totalAmount for each wage record
                                            foreach ($wage->wage_transaction->transaction_payments as $payment) {
                                                $totalAmount += $payment->amount;
                                            }
                                        @endphp
                                        <tr>
                                            <td class="col1" title="@lang('lang.date')">{{ \Carbon\Carbon::parse($wage->wage_transaction->transaction_date)->format('Y-m-d') }}</td>
                                            <td class="col2" title="@lang('lang.employee_name')">{{ $wage->employee->employee_name }}</td>
                                            <td class="col3" title="@lang('lang.payment_method')">{{ $wage->payment_type }}</td>
                                            <td class="col4" title="@lang('lang.salary')">{{ $wage->employee->fixed_wage_value }}</td>
                                            <td class="col5" title="@lang('lang.commission')">{{ number_format($wage->employee->commission_value,2) }}</td>
                                            <td class="col6" title="@lang('lang.paid_amount')">{{ number_format($totalAmount,2) }}</td>
                                            <td class="col7" title="@lang('lang.duePaid')">{{ number_format($wage->wage_transaction->final_total - $totalAmount,num_of_digital_numbers()) }}</td>
                                            <td class="col8" title="@lang('lang.payment_status')">{{ $wage->wage_transaction->payment_status }}</td>
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
@endsection
@section('javascript')
    {{-- +++++++++++++++ Show/Hide checkboxes +++++++++++++++ --}}
    <script>
        // ++++++++ Checkboxs and label inside selectbox ++++++++
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

