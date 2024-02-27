@extends('layouts.app')
@section('title', __('lang.due_sale_list'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.due_sale_list')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.due_sale_list')</li>
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
                        <h5 class="card-title">@lang('lang.due_sale_list')</h5>
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
                                {{-- +++++++++++++++++ checkbox1 : # +++++++++++++++++ --}}
                                <label for="col1_id">
                                    <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                    <span>#</span> &nbsp;
                                </label>
                                {{-- +++++++++++++++++ checkbox2 : date +++++++++++++++++ --}}
                                <label for="col2_id">
                                    <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                    <span>@lang('lang.date')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox3 : reference +++++++++++++++++ --}}
                                <label for="col3_id">
                                    <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                    <span>@lang('lang.reference')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox4 : customer +++++++++++++++++ --}}
                                <label for="col4_id">
                                    <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                    <span>@lang('lang.customer')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox5 : amount +++++++++++++++++ --}}
                                <label for="col5_id">
                                    <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                    <span>@lang('lang.amount')</span>
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
                                {{-- +++++++++++++++++ checkbox8 : actions +++++++++++++++++ --}}
                                <label for="col8_id">
                                    <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                    <span>@lang('lang.action')</span>
                                </label>

                            </div>
                        </div>
                    </div> <br/>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    <form action="{{route('dues')}}" method="get">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    {{-- <label for="date">@lang('lang.date')</label> --}}
                                                    <input type="date" class="form-control" name="date"
                                                        id="date" placeholder="@lang('lang.date')">
                                                </div>

                                            </div>
                                            {{-- <div class="col-3">
                                                <div class="form-group">
                                                    {!! Form::select(
                                                        'city_id',
                                                        $cities,null,
                                                        ['class' => 'form-control select2','placeholder'=>__('lang.cities')]
                                                    ) !!}
                                                </div>
                                            </div> --}}
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                                                        <i class="fa fa-eye"></i> {{ __('Search') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col1">#</th>
                                        <th class="col2">@lang('lang.date')</th>
                                        <th class="col3">@lang('lang.reference')</th>
                                        <th class="col4">@lang('lang.customer')</th>
                                        <th class="col5">@lang('lang.amount')</th>
                                        <th class="col6">@lang('lang.paid')</th>
                                        <th class="col7">@lang('lang.duePaid')</th>
                                        <th class="col7">@lang('lang.total_dues_for_this_customer')</th>
                                        <th class="col8">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1 ;
                                        $total_paid = 0;
                                        $total_due = 0;
                                        $total_dues=0;
                                    @endphp
                                    @foreach ($dues as $due)
                                    <tr>
                                        <td class="col1">{{ $i }}</td>
                                        <td class="col2">{{@format_date($due->transaction_date)}}</td>
                                        <td class="col3"> {{$due->invoice_no}}</td>
                                        <td class="col4"> {{$due->customer->name ?? ''}}</td>
                                        <td class="col5"> {{@num_format($due->final_total)}}</td>
                                        <td class="col6"> {{@num_format($due->transaction_payments->sum('amount'))}}</td>
                                        <td class="col7"> {{@num_format($due->final_total - $due->transaction_payments->sum('amount'))}}
                                        @php
                                            $total_dues+= ($due->final_total - $due->transaction_payments->sum('amount'));
                                        @endphp
                                        </td>
                                        <td class="col7">{{$total_dues}}</td>
                                        <td class="col8 col18">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm" aria-haspopup="true" aria-expanded="false">
                                                    <a data-href="{{route('customers.pay_due_view', ['id' => $due->id])}}"   data-container=".view_modal" class="btn btn-modal" ><i class="dripicons-document-edit"></i> @lang('lang.pay_due')</a>
                                                    <span class="caret"></span>
                                                </button>
{{--                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">--}}
{{--                                                    <li>--}}
{{--                                                        <a data-href="{{route('customers.pay_due_view', ['id' => $due->id])}}"   data-container=".view_modal" class="btn btn-modal" ><i class="dripicons-document-edit"></i> @lang('lang.pay_due')</a>--}}
{{--                                                    </li>--}}
{{--                                                    --}}{{-- <li class="divider"></li>--}}
{{--                                                        <li>--}}
{{--                                                            <a data-href="{{route('customers.destroy', $customer->id)}}"--}}
{{--                                                                class="btn text-red delete_item"><i class="fa fatrash"></i>--}}
{{--                                                                @lang('lang.delete')</a>--}}
{{--                                                    </li> --}}
{{--                                                </ul>--}}
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $i++ ;
                                        $total_paid += $due->transaction_payments->sum('amount');
                                        $total_due += $due->final_total - $due->transaction_payments->sum('amount');
                                    @endphp
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
    <div class="view_modal no-print" >

    </div>
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


