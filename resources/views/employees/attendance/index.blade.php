@extends('layouts.app')
@section('title', __('lang.attend_and_leave'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.attend_and_leave')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.attendance_list')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                        @lang('lang.add_attendance_and_leave')
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="print-title">@lang('lang.attendance_list')</h4>
                    </div>
                    <br/>
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
                                {{-- +++++++++++++++++ checkbox3 : check_in +++++++++++++++++ --}}
                                <label for="col3_id">
                                    <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                    <span>@lang('lang.check_in')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox4 : check_out +++++++++++++++++ --}}
                                <label for="col4_id">
                                    <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                    <span>@lang('lang.check_out')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox5 : status +++++++++++++++++ --}}
                                <label for="col5_id">
                                    <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                    <span>@lang('lang.status')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox6 : created_by +++++++++++++++++ --}}
                                <label for="col6_id">
                                    <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                    <span>@lang('lang.created_by')</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- <br/> --}}
                    <div class="card-body">
                        <div class="row">
                            {{-- ++++++++++++++++++++++++++ Table ++++++++++++++++++++++++++  --}}
                            <div class="col-sm-12">
                                <table class="table dataTable">
                                    <thead>
                                        <tr>
                                            <th class="col1">@lang('lang.date')</th>
                                            <th class="col2">@lang('lang.employee_name')</th>
                                            <th class="col3">@lang('lang.check_in')</th>
                                            <th class="col4">@lang('lang.check_out')</th>
                                            <th class="col5">@lang('lang.status')</th>
                                            <th class="col6">@lang('lang.created_by')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($attendances as $attendance)
                                        <tr>
                                            <td class="col1">
                                                {{@format_date($attendance->date)}}
                                            </td>
                                            <td class="col2">
                                                {{$attendance->employee_name}}
                                            </td>
                                            <td class="col3">
                                                {{\Carbon\Carbon::parse($attendance->check_in)->format('h:i:s A')}}
                                            </td>
                                            <td class="col4">
                                                {{\Carbon\Carbon::parse($attendance->check_out)->format('h:i:s A')}}
                                            </td>
                                            {{-- ++++++++++++++ status ++++++++++++++++ --}}
                                            <td class="col5">
                                                {{-- ///// status == late ///// --}}
                                                @if($attendance->status == 'late')
                                                    <span class="badge badge-danger p-2">
                                                        {{__('lang.' . $attendance->status)}}
                                                    </span>
                                                {{-- ///// status == present ///// --}}
                                                @elseif ($attendance->status == 'present')
                                                    <span class="badge badge-success p-2">
                                                        {{__('lang.' . $attendance->status)}}
                                                    </span>
                                                {{-- ///// status == on_leave ///// --}}
                                                @else
                                                    <span class="badge badge-warning p-2">
                                                        {{__('lang.' . $attendance->status)}}
                                                    </span>
                                                @endif

                                                @if($attendance->status == 'late')
                                                    @php
                                                        $check_in_data = [];
                                                        $employee = App\Models\Employee::find($attendance->employee_id);
                                                        if(!empty($employee))
                                                        {
                                                            $check_in_data = $employee->check_in;
                                                        }
                                                        $day_name = Illuminate\Support\Str::lower(\Carbon\Carbon::parse($attendance->date)->format('l'));
                                                        $late_time = 0;
                                                        if(!empty($check_in_data[$day_name]))
                                                        {
                                                            $check_in_time = $check_in_data[$day_name];
                                                            $late_time = \Carbon\Carbon::parse($attendance->check_in)->diffInMinutes($check_in_time);
                                                        }
                                                    @endphp
                                                    @if($late_time > 0)
                                                        +{{$late_time}}
                                                    @endif
                                                @endif
                                                @if($attendance->status == 'on_leave')
                                                    @php
                                                        $leave = App\Models\Leave::leftjoin('leave_types', 'leave_type_id','leave_types.id')
                                                                                ->where('employee_id', $attendance->employee_id)
                                                                                ->where('start_date', '>=', $attendance->date)
                                                                                ->where('start_date', '<=', $attendance->date)
                                                                                ->select('leave_types.name')
                                                                                ->first()
                                                    @endphp
                                                    @if(!empty($leave))
                                                        {{$leave->name}}
                                                    @endif
                                                @endif
                                            </td>
                                            <td  class="col6">
                                                {{ucfirst($attendance->created_by)}}
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
