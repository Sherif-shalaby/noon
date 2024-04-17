@extends('layouts.app')
@section('title', __('lang.supplier_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.supplier_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.supplier_report')</li>
                    </ol>
                </div>
            </div>
            {{-- <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('products.create')}}" class="btn btn-primary">
                        @lang('lang.add_products')
                      </a>
                </div>
            </div> --}}
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

        #checkboxes ,
        #checkboxes2 ,
        #checkboxes3 {
        display: none;
        border: 1px #dadada solid;
        height: 125px;
        overflow: auto;
        padding-top: 10px;
        /* text-align: end;  */
        }

        #checkboxes  label  ,
        #checkboxes2 label  ,
        #checkboxes3 label
        {
        display: block;
        padding: 5px;

        }

        #checkboxes  label:hover  ,
        #checkboxes2 label:hover  ,
        #checkboxes  label:hover
        {
        background-color: #ddd;
        }
        #checkboxes  label span  ,
        #checkboxes2 label span  ,
        #checkboxes3 label span
        {
            font-weight: normal;
        }
    </style>
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
                        <h5 class="card-title">@lang('lang.supplier_report')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{-- @include('products.filters')  --}}
                                </div>
                            </div>
                        </div>
                        {{-- ================================ Tabs Header ================================ --}}
                        {{-- <div> --}}
                            <ul class="nav nav-pills">
                                {{-- ####### Tab 1 ####### --}}
                                <li class="nav-item">
                                    <a class="nav-link active pt-2 pb-2" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                        شراء
                                    </a>
                                </li>
                                {{-- ####### Tab 2 ####### --}}
                                <li class="nav-item">
                                    <a class="nav-link pt-2 pb-2" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                        امر شراء
                                    </a>
                                </li>
                                {{-- ####### Tab 3 ####### --}}
                                <li class="nav-item">
                                    <a class="nav-link pt-2 pb-2" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">
                                        المدفوعات
                                    </a>
                                </li>
                            </ul>
                        {{-- </div> --}}
                        <br/>
                        {{-- ================================ Tabs Body ================================ --}}
                        <div class="tab-content" id="nav-tabContent">
                            {{-- +++++++++++++++++++++ Table 1 +++++++++++++++++++++ --}}
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                {{-- ////////// Show/Hide Table Columns ////////// --}}
                                <div class="col-md-4 col-lg-4">
                                    <div class="multiselect col-md-6">
                                        <div class="selectBox" onclick="showCheckboxes(1)">
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
                                            {{-- +++++++++++++++++ checkbox2 : reference_no +++++++++++++++++ --}}
                                            <label for="col2_id">
                                                <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                                <span>@lang('lang.reference_no')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox3 : supplier +++++++++++++++++ --}}
                                            <label for="col3_id">
                                                <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                                <span>@lang('lang.supplier')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox4 : product +++++++++++++++++ --}}
                                            <label for="col4_id">
                                                <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                                <span>@lang('lang.product')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox5 : grand_total +++++++++++++++++ --}}
                                            <label for="col5_id">
                                                <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                                <span>@lang('lang.grand_total')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox6 : paid +++++++++++++++++ --}}
                                            <label for="col6_id">
                                                <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                                <span>@lang('lang.paid')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox7 : duePaid +++++++++++++++++ --}}
                                            <label for="col7_id">
                                                <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                                <span>@lang('lang.duePaid')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox8 : status +++++++++++++++++ --}}
                                            <label for="col8_id">
                                                <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                                <span>@lang('lang.status')</span>
                                            </label>
                                        </div>
                                    </div>
                                </div> <br/>
                                {{-- ////////// Table 1 ////////// --}}
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="col1">@lang('lang.date')</th>
                                            <th class="col2">@lang('lang.reference_no')</th>
                                            <th class="col3">@lang('lang.supplier')</th>
                                            <th class="col4">@lang('lang.product')</th>
                                            <th class="col5 sum">@lang('lang.grand_total')</th>
                                            <th class="col6 sum">@lang('lang.paid')</th>
                                            <th class="col7 sum">@lang('lang.duePaid')</th>
                                            <th class="col8">@lang('lang.status')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ( $add_stocks as $add_stock )
                                                <tr>
                                                {{-- @foreach ($add_stocks->transaction as $line) --}}
                                                        <td class="col1">{{ @format_date($add_stock->transaction->transaction_date??null) }}</td>
                                                        <td class="col2">{{$add_stock->transaction->invoice_no??''}}</td>
                                                        <td class="col3">@if(!empty($add_stock->transaction->supplier??'')){{$add_stock->transaction->supplier->name??''}}@endif</td>
                                                        <td class="col4">@if(!empty($add_stock->product)){{$add_stock->product->name}}@endif</td>
                                                        <td class="col5">{{@num_format($add_stock->transaction->final_total??'')}}</td>
                                                        <td class="col6">{{@num_format($add_stock->transaction->transaction_payments->sum('amount'))}}</td>
                                                        <td class="col7">{{@num_format($add_stock->transaction->final_total - $add_stock->transaction->transaction_payments->sum('amount'))}}</td>
                                                        <td class="col8">{{ $add_stock->transaction->payment_status }}</td>
                                                {{-- @endforeach --}}
                                                </tr>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- +++++++++++++++++++++ Table 2 +++++++++++++++++++++ --}}
                            <div class="tab-pane fade"id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                {{-- ////////// Show/Hide Table Columns ////////// --}}
                                <div class="col-md-4 col-lg-4">
                                    <div class="multiselect col-md-6">
                                        <div class="selectBox" onclick="showCheckboxes(2)">
                                            <select class="form-select form-control form-control-lg">
                                                <option>@lang('lang.show_hide_columns')</option>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>
                                        <div id="checkboxes2">
                                            {{-- +++++++++++++++++ checkbox9 : date +++++++++++++++++ --}}
                                            <label for="col9_id">
                                                <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                                <span>@lang('lang.date')</span> &nbsp;
                                            </label>
                                            {{-- +++++++++++++++++ checkbox10 : reference_no +++++++++++++++++ --}}
                                            <label for="col10_id">
                                                <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                                <span>@lang('lang.reference_no')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox11 : supplier_name +++++++++++++++++ --}}
                                            <label for="col11_id">
                                                <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                                <span>@lang('lang.supplier_name')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox12 : product_name +++++++++++++++++ --}}
                                            <label for="col12_id">
                                                <input type="checkbox" id="col12_id" name="col12" checked="checked" />
                                                <span>@lang('lang.product_name')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox13 : quantity +++++++++++++++++ --}}
                                            <label for="col13_id">
                                                <input type="checkbox" id="col13_id" name="col13" checked="checked" />
                                                <span>@lang('lang.quantity')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox14 : paid +++++++++++++++++ --}}
                                            <label for="col14_id">
                                                <input type="checkbox" id="col14_id" name="col14" checked="checked" />
                                                <span>@lang('lang.paid')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox15 : duePaid +++++++++++++++++ --}}
                                            <label for="col15_id">
                                                <input type="checkbox" id="col15_id" name="col15" checked="checked" />
                                                <span>@lang('lang.duePaid')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox8 : status +++++++++++++++++ --}}
                                            <label for="col16_id">
                                                <input type="checkbox" id="col16_id" name="col16" checked="checked" />
                                                <span>@lang('lang.status')</span>
                                            </label>
                                        </div>
                                    </div>
                                </div> <br/>
                                {{-- ////////// Table 2 ////////// --}}
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="col9">@lang('lang.date')</th>
                                            <th class="col10">@lang('lang.reference_no')</th>
                                            <th class="col11">@lang('lang.supplier_name')</th>
                                            <th class="col12">@lang('lang.product_name')</th>
                                            <th class="col13">@lang('lang.quantity')</th>
                                            <th class="col14">@lang('lang.paid')</th>
                                            <th class="col15">@lang('lang.duePaid')</th>
                                            <th class="col16">@lang('lang.status')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($supplier_purchase_orders as $purchase_order)
                                            <tr>
                                                <td class="col9">{{@format_date($purchase_order->transaction->transaction_date)}}</td>
                                                <td class="col10">{{$purchase_order->transaction->po_no}}</td>
                                                <td class="col11">
                                                    @if(!empty($purchase_order->transaction->supplier))
                                                        {{$purchase_order->transaction->supplier->name}}
                                                    @endif
                                                </td>
                                                {{-- <td>{{$purchase_order->product->name}}</td> --}}
                                                <td class="col12"> {{@num_format($purchase_order->quantity)}} </td>
                                                <td class="col13"></td>
                                                {{-- <td>{{ $purchase_order->transaction->final_total }}</td> --}}
                                                {{-- <td>{{@num_format($purchase_order->transaction_payments->sum('amount'))}}</td> --}}
                                                <td class="col14"></td>
                                                <td class="col15"></td>
                                                {{-- <td>{{@num_format($purchase_order->final_total - $purchase_order->transaction_payments->sum('amount'))}}</td> --}}
                                                <td class="col16">@if($purchase_order->status == 'final')<span
                                                        class="badge badge-success">@lang('lang.completed')</span>@elseif($purchase_order->status == 'sent_admin') Sent Admin @else
                                                    {{ucfirst($purchase_order->status)}} @endif</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- +++++++++++++++++++++ Table 3 +++++++++++++++++++++ --}}
                            <div class="tab-pane fade"id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                {{-- ////////// Show/Hide Table Columns ////////// --}}
                                <div class="col-md-4 col-lg-4">
                                    <div class="multiselect col-md-6">
                                        <div class="selectBox" onclick="showCheckboxes(3)">
                                            <select class="form-select form-control form-control-lg">
                                                <option>@lang('lang.show_hide_columns')</option>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>
                                        <div id="checkboxes3">
                                            {{-- +++++++++++++++++ checkbox17 : date +++++++++++++++++ --}}
                                            <label for="col17_id">
                                                <input type="checkbox" id="col17_id" name="col17" checked="checked" />
                                                <span>@lang('lang.date')</span> &nbsp;
                                            </label>
                                            {{-- +++++++++++++++++ checkbox18 : payment_ref +++++++++++++++++ --}}
                                            <label for="col18_id">
                                                <input type="checkbox" id="col18_id" name="col18" checked="checked" />
                                                <span>@lang('lang.payment_ref')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox19 : sale_ref +++++++++++++++++ --}}
                                            <label for="col19_id">
                                                <input type="checkbox" id="col19_id" name="col19" checked="checked" />
                                                <span>@lang('lang.sale_ref')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox20 : purchase_ref +++++++++++++++++ --}}
                                            <label for="col20_id">
                                                <input type="checkbox" id="col20_id" name="col20" checked="checked" />
                                                <span>@lang('lang.purchase_ref')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox21 : paid +++++++++++++++++ --}}
                                            <label for="col21_id">
                                                <input type="checkbox" id="col21_id" name="col21" checked="checked" />
                                                <span>@lang('lang.paid')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox22 : amount +++++++++++++++++ --}}
                                            <label for="col22_id">
                                                <input type="checkbox" id="col22_id" name="col22" checked="checked" />
                                                <span>@lang('lang.amount')</span>
                                            </label>
                                            {{-- +++++++++++++++++ checkbox23 : created_by +++++++++++++++++ --}}
                                            <label for="col23_id">
                                                <input type="checkbox" id="col23_id" name="col23" checked="checked" />
                                                <span>@lang('lang.created_by')</span>
                                            </label>
                                        </div>
                                    </div>
                                </div> <br/>
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="col17">@lang('lang.date')</th>
                                            <th class="col18">@lang('lang.payment_ref')</th>
                                            <th class="col19">@lang('lang.sale_ref')</th>
                                            <th class="col20">@lang('lang.purchase_ref')</th>
                                            <th class="col21">@lang('lang.paid')</th>
                                            <th class="col22 sum">@lang('lang.amount')</th>
                                            <th class="col23">@lang('lang.created_by')</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>


                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        {{-- <div class="table-responsive">

                            <div class="view_modal no-print" >

                            </div>
                        </div> --}}
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
        function showCheckboxes(num)
        {
            var checkboxes = document.getElementById("checkboxes");
            var checkboxes2 = document.getElementById("checkboxes2");
            var checkboxes3 = document.getElementById("checkboxes3");
            if( num == 1 )
            {
                if (!expanded) {
                    checkboxes.style.display = "block";
                    expanded = true;
                } else {
                    checkboxes.style.display = "none";
                    expanded = false;
                }
            }
            else if( num == 2 )
            {
                if (!expanded) {
                    checkboxes2.style.display = "block";
                    expanded = true;
                } else {
                    checkboxes2.style.display = "none";
                    expanded = false;
                }
            }
            else if( num == 3 )
            {
                if (!expanded) {
                    checkboxes3.style.display = "block";
                    expanded = true;
                } else {
                    checkboxes3.style.display = "none";
                    expanded = false;
                }
            }
        }
    </script>
@endsection

