@extends('layouts.app')
@section('title', __('lang.plans'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.plans')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        @if((request()->segment(2).'/'.request()->segment(3)) == "representative/plan")
                            <li class="breadcrumb-item active"><a href="{{ route('representatives.index') }}">@lang('lang.representatives')</a></li>
                        @else
                        <li class="breadcrumb-item active"><a href="#">@lang('lang.delivery')</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.plans')</li>
                    </ol>
                </div>
            </div>
             <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    @if((request()->segment(2).'/'.request()->segment(3)) == "representative/plan")
                        <a class="btn btn-primary" href="{{ route('representatives.plansList') }}">@lang('lang.show_plans')</a>
                    @else

                        <a class="btn btn-primary" href="{{route('delivery_plan.plansList')}}">@lang('lang.show_plans')</a>
                    @endif
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

    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
                    <h4 class="print-title">@lang('lang.delivery')</h4>
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
                            {{-- +++++++++++++++++ checkbox1 : profile_photo +++++++++++++++++ --}}
                            <label for="col1_id">
                                <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                <span>@lang('lang.profile_photo')</span> &nbsp;
                            </label>
                            {{-- +++++++++++++++++ checkbox2 : employee_name +++++++++++++++++ --}}
                            <label for="col2_id">
                                <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                <span>@lang('lang.employee_name')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox3 : email +++++++++++++++++ --}}
                            <label for="col3_id">
                                <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                <span>@lang('lang.email')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox4 : phone_number +++++++++++++++++ --}}
                            <label for="col4_id">
                                <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                <span>@lang('lang.phone_number')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox5 : stores +++++++++++++++++ --}}
                            <label for="col5_id">
                                <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                <span>@lang('lang.stores')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox6 : action +++++++++++++++++ --}}
                            <label for="col6_id">
                                <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                <span>@lang('lang.action')</span>
                            </label>
                        </div>
                    </div>
                </div>
                {{-- ++++++++++++++++++ table +++++++++++++++++ --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                            <tr>
                                <th class="col1">@lang('lang.profile_photo')</th>
                                <th class="col2">@lang('lang.employee_name')</th>
                                <th class="col3">@lang('lang.email')</th>
                                <th class="col4">@lang('lang.phone_number')</th>
                                <th class="col5">@lang('lang.stores')</th>
                                <th class="col6 notexport">@lang('lang.action')</th>
                            </tr>
                            </thead>
                            <tbody>

                                @foreach($delivery_men as $key => $employee)
                                    <tr>
                                        <td class="col1">
                                            @if (!empty($employee->photo))
                                                <img src="{{"/uploads/". $employee->photo}}" alt="photo" width="50" height="50">
                                            @else
                                                <img src="{{"/uploads/". session('logo')}}" alt="photo" width="50" height="50">
                                            @endif
                                        </td>
                                        <td class="col2">
                                            {{!empty($employee->user) ? $employee->user->name : ''}}
                                        </td>
                                        <td class="col3">
                                            {{!empty($employee->user) ? $employee->user->email : ''}}
                                        </td>
                                        <td class="col4">
                                            {{$employee->mobile}}
                                        </td>
                                        <td class="col5">
                                            @foreach($employee->stores()->get() as $store)
                                                {{$store->name}}
                                            @endforeach
                                        </td>
                                        <td class="col6">
                                             <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                     aria-haspopup="true" aria-expanded="false">
                                                 @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                <li>
                                                    <a href="{{route('delivery.create', $employee->id)}}"
                                                       class="btn"><i
                                                            class="fa fa-pencil-square-o"></i>
                                                         @lang('lang.add_plan') </a>
                                                </li>
                                                <li class="divider"></li>

                                            </ul>
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
