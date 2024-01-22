@extends('layouts.app')
@section('title', __('lang.general_tax'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.general_tax')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('/')}}">@lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="">@lang('lang.settings')</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.general_tax')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a data-href="{{route('general-tax.create')}}" data-container=".view_modal" class="btn btn-modal btn-primary text-white" data-toggle="modal">
                        @lang('lang.add_general_tax')
                    </a>

                </div>
            </div>
        </div>
    </div>
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
                        <h5 class="card-title">@lang('lang.general_tax')</h5>
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
                                {{-- +++++++++++++++++ checkbox2 : tax_name +++++++++++++++++ --}}
                                <label for="col2_id">
                                    <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                    <span>@lang('lang.tax_name')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox3 : tax_rate +++++++++++++++++ --}}
                                <label for="col3_id">
                                    <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                    <span>@lang('lang.tax_rate')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox4 : tax_method +++++++++++++++++ --}}
                                <label for="col4_id">
                                    <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                    <span>@lang('lang.tax_method')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox5 : tax_details +++++++++++++++++ --}}
                                <label for="col5_id">
                                    <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                    <span>@lang('lang.tax_details')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox6 : tax_status +++++++++++++++++ --}}
                                <label for="col6_id">
                                    <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                    <span>@lang('lang.tax_status')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox7 : stores +++++++++++++++++ --}}
                                <label for="col7_id">
                                    <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                    <span>@lang('lang.stores')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox8 : action +++++++++++++++++ --}}
                                <label for="col8_id">
                                    <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                    <span>@lang('lang.action')</span>
                                </label>
                            </div>
                        </div>
                    </div> <br/>
                    <div class="card-body">
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="col1">#</th>
                                    <th class="col2">@lang('lang.tax_name')</th>
                                    <th class="col3">@lang('lang.tax_rate')</th>
                                    <th class="col4">@lang('lang.tax_method')</th>
                                    <th class="col5">@lang('lang.tax_details')</th>
                                    <th class="col6">@lang('lang.tax_status')</th>
                                    <th class="col7">@lang('lang.stores')</th>
                                    <th class="col8 notexport">@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($general_taxes as $general_tax)
                                    <tr>
                                        <td class="col1">{{$general_tax->id}}</td>
                                        <td class="col2">{{$general_tax->name ?? ''}}</td>
                                        <td class="col3">{{$general_tax->rate}}</td>
                                        <td class="col4">{{$general_tax->method}}</td>
                                        <td class="col5">{{$general_tax->details}}</td>
                                        <td class="col6">{{$general_tax->status}}</td>
                                        <td class="col7">
                                            @foreach ($general_tax->stores as $store_tax )
                                                {{$store_tax->name}}
                                            @endforeach
                                        </td>
                                        <td class="col8">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">@lang('lang.action')
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                    {{-- ++++++++++++ Edit Button ++++++++++++  --}}
                                                    <li>
                                                        <a data-href="{{route('general-tax.edit', $general_tax->id)}}"
                                                           data-container=".view_modal" class="btn btn-modal"><i
                                                                class="dripicons-document-edit"></i> @lang('lang.edit')</a>
                                                    </li>
                                                    {{-- ++++++++++++ destroy Button ++++++++++++  --}}
                                                    <li>
                                                        <a data-href="{{route('general-tax.destroy', $general_tax->id)}}"
                                                           data-check_password=""
                                                           class="btn text-red delete_item">
                                                           <i class="fa fa-trash"></i>@lang('lang.delete')
                                                        </a>
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
    <!-- End Contentbar -->
    </div>
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
