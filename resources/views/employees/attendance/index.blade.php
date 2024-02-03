@extends('layouts.app')
@section('title', __('lang.attend_and_leave'))

@push('css')
    <style>
        .table-top-head {
            top: 85px;
        }

        .table-scroll-wrapper {
            width: fit-content;
        }

        @media(min-width:1900px) {
            .table-scroll-wrapper {
                width: 100%;
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.attend_and_leave')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.attendance_list')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a href="{{ route('attendance.create') }}" class="btn btn-primary">
            @lang('lang.add_attendance_and_leave')
        </a>
    </div>
@endsection

@section('content')
    <div class="animate-in-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div
                            class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                            <h6 class="print-title">@lang('lang.attendance_list')</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- +++++++++++++ Table +++++++++++++ --}}
                                <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <div class="div1"></div>
                                </div>
                                <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <div class="div2 table-scroll-wrapper">
                                        <!-- content goes here -->
                                        <div style="min-width: 1340px;max-height: 90vh;overflow: auto">

                                            <table class="table dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('lang.date')</th>
                                                        <th>@lang('lang.employee_name')</th>
                                                        <th>@lang('lang.check_in')</th>
                                                        <th>@lang('lang.check_out')</th>
                                                        <th>@lang('lang.status')</th>
                                                        <th>@lang('lang.created_by')</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($attendances as $attendance)
                                                        <tr>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.date')">
                                                                    {{ @format_date($attendance->date) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.employee_name')">
                                                                    {{ $attendance->employee_name }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.check_in')">
                                                                    {{ \Carbon\Carbon::parse($attendance->check_in)->format('h:i:s A') }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.check_out')">
                                                                    {{ \Carbon\Carbon::parse($attendance->check_out)->format('h:i:s A') }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.status')">
                                                                    {{-- ///// status == late ///// --}}
                                                                    @if ($attendance->status == 'late')
                                                                        <span class="badge badge-danger p-2">
                                                                            {{ __('lang.' . $attendance->status) }}
                                                                        </span>
                                                                        {{-- ///// status == present ///// --}}
                                                                    @elseif ($attendance->status == 'present')
                                                                        <span class="badge badge-success p-2">
                                                                            {{ __('lang.' . $attendance->status) }}
                                                                        </span>
                                                                        {{-- ///// status == on_leave ///// --}}
                                                                    @else
                                                                        <span class="badge badge-warning p-2">
                                                                            {{ __('lang.' . $attendance->status) }}
                                                                        </span>
                                                                    @endif

                                                                    @if ($attendance->status == 'late')
                                                                        @php
                                                                            $check_in_data = [];
                                                                            $employee = App\Models\Employee::find($attendance->employee_id);
                                                                            if (!empty($employee)) {
                                                                                $check_in_data = $employee->check_in;
                                                                            }
                                                                            $day_name = Illuminate\Support\Str::lower(\Carbon\Carbon::parse($attendance->date)->format('l'));
                                                                            $late_time = 0;
                                                                            if (!empty($check_in_data[$day_name])) {
                                                                                $check_in_time = $check_in_data[$day_name];
                                                                                $late_time = \Carbon\Carbon::parse($attendance->check_in)->diffInMinutes($check_in_time);
                                                                            }
                                                                        @endphp
                                                                        @if ($late_time > 0)
                                                                            +{{ $late_time }}
                                                                        @endif
                                                                    @endif
                                                                    @if ($attendance->status == 'on_leave')
                                                                        @php
                                                                            $leave = App\Models\Leave::leftjoin('leave_types', 'leave_type_id', 'leave_types.id')
                                                                                ->where('employee_id', $attendance->employee_id)
                                                                                ->where('start_date', '>=', $attendance->date)
                                                                                ->where('start_date', '<=', $attendance->date)
                                                                                ->select('leave_types.name')
                                                                                ->first();
                                                                        @endphp
                                                                        @if (!empty($leave))
                                                                            {{ $leave->name }}
                                                                        @endif
                                                                    @endif
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="custom-tooltip  d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.created_by')">
                                                                    {{ ucfirst($attendance->created_by) }}
                                                                </span>
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
        </div>
    </div>
@endsection

@section('javascript')
    <script></script>
@endsection
