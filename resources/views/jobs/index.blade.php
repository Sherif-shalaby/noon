@extends('layouts.app')
@section('title', __('lang.jobs'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.jobs')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="#">@lang('lang.employees')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.jobs')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-job">@lang('lang.add_job')</button>
                </div>
            </div>
        </div>
    </div>
    {{--     create job modal      --}}
    @include('jobs.create')
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
                    <h4 class="print-title">@lang('lang.jobs')</h4>
                </div><br/>
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
                            {{-- +++++++++++++++++ checkbox1 : job_title +++++++++++++++++ --}}
                            <label for="col1_id">
                                <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                <span>@lang('lang.job_title')</span> &nbsp;
                            </label>
                            {{-- +++++++++++++++++ checkbox2 : date_of_creation +++++++++++++++++ --}}
                            <label for="col2_id">
                                <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                <span>@lang('lang.date_of_creation')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox3 : created_by +++++++++++++++++ --}}
                            <label for="col3_id">
                                <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                <span>@lang('lang.created_by')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox4 : updated_by +++++++++++++++++ --}}
                            <label for="col4_id">
                                <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                <span>@lang('lang.updated_by')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox5 : action +++++++++++++++++ --}}
                            <label for="col5_id">
                                <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                <span>@lang('lang.action')</span>
                            </label>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                            <tr>
                                <th class="col1">@lang('lang.job_title')</th>
                                <th class="col2">@lang('lang.date_of_creation')</th>
                                <th class="col3">@lang('lang.created_by')</th>
                                <th class="col4">@lang('lang.updated_by')</th>
                                <th class="col5 notexport">@lang('lang.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($jobs as $job)
                                <tr>
                                    <td class="col1">
                                        @if(in_array($job->title, ['Cashier', 'Deliveryman', 'Representative','Preparer']))
                                            @lang('lang.'.$job->title)
                                        @else
                                            {{ $job->title }}
                                        @endif
                                    </td>
                                    <td class="col2">
                                        {{@format_date($job->date_of_creation)}}
                                    </td>
                                    <td class="col3">
                                         {{$job->created_by()->get()[0]->name}}
                                    </td>
                                    <td class="col4">
                                        @if(isset($job->updated_by))
                                            {{$job->updated_by()->get()[0]->name}}
                                        @endif
                                    </td>
                                    {{-- +++++++++++++++ Actions +++++++++++++++ --}}
                                    <td class="col5">
                                        <a data-href="{{route('jobs.edit', $job->id)}}" data-container=".view_modal" class="btn btn-primary btn-modal text-white edit_job">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        {{-- @if(!in_array($job->title, ['Cashier', 'Deliveryman','Representative','Preparer']) ) --}}
                                        @if(!in_array($job->id, [1,2,3,4]))
                                            <a data-href="{{route('jobs.destroy', $job->id)}}" class="btn btn-danger text-white delete_item">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endif
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
<div class="view_modal no-print" ></div>

@push('javascripts')
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
            console.log("000000000000000000000000000000");
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
@endpush
