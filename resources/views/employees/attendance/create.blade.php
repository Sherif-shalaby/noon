@extends('layouts.app')
@section('title', __('lang.add_attendance_and_leave'))
@section('breadcrumbbar')
    <style>
        .table-top-head {
            top: 85px;
        }
    </style>
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between mb-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.attend_and_leave')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.attend_and_leave')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a href="{{ route('attendance.index') }}" class="btn btn-primary">
                            @lang('lang.attend_and_leave')
                        </a>
                    </div>
                </div>
            </div>
        </div>
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
                            <h4>@lang('lang.attendance')</h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-sm-12">

                                    {!! Form::open(['url' => route('attendance.store'), 'method' => 'post']) !!}
                                    {{-- "index" of "each row" --}}
                                    <input type="hidden" name="index" id="index" value="0">
                                    <div class="row my-2">
                                        {{-- add "new_row" to table --}}
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary add_row" id="add_row">
                                                +@lang('lang.add_row')
                                            </button>
                                        </div>
                                    </div>
                                    <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif"
                                        style="margin-top:25px ">
                                        <div class="div1"></div>
                                    </div>
                                    <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                        <div class="div2 table-scroll-wrapper">
                                            <!-- content goes here -->
                                            <div style="min-width: 1350px;max-height: 90vh;overflow: hidden">
                                                {{-- ++++++++++++++++++++ Table ++++++++++++++++++++ --}}
                                                <table class="table " id="attendance_table">
                                                    {{-- /////////// table_thead /////////// --}}
                                                    <thead>
                                                        <tr>
                                                            <th>@lang('lang.date')</th>
                                                            <th>@lang('lang.employee')</th>
                                                            <th>@lang('lang.check_in')</th>
                                                            <th>@lang('lang.check_out')</th>
                                                            <th>@lang('lang.status')</th>
                                                            <th>@lang('lang.created_by')</th>
                                                            <th>@lang('lang.action')</th>
                                                        </tr>
                                                    </thead>
                                                    {{-- /////////// table_tbody /////////// --}}
                                                    <tbody class="table_tbody">
                                                        <tr>
                                                            <td>
                                                                <input type="date" class="form-control date"
                                                                    name="attendances[0][date]" required>
                                                            </td>
                                                            <td>
                                                                {!! Form::select('attendances[0][employee_id]', $employees, null, [
                                                                    'class' => 'form-control selectpicker',
                                                                    'placeholder' => __('lang.please_select'),
                                                                    'data-live-search' => 'true',
                                                                    'required',
                                                                ]) !!}
                                                            </td>
                                                            <td>
                                                                <input type="time" class="form-control time"
                                                                    name="attendances[0][check_in]" required>
                                                            </td>
                                                            <td>
                                                                <input type="time" class="form-control time"
                                                                    name="attendances[0][check_out]" required>
                                                            </td>
                                                            <td>
                                                                {!! Form::select(
                                                                    'attendances[0][status]',
                                                                    ['present' => 'Present', 'late' => 'Late', 'on_leave' => 'On Leave'],
                                                                    null,
                                                                    [
                                                                        'class' => 'form-control
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        selectpicker',
                                                                        'data-live-search' => 'true',
                                                                        'placeholder' => __('lang.please_select'),
                                                                        'required',
                                                                    ],
                                                                ) !!}
                                                            </td>
                                                            <td>
                                                                {{ ucfirst(Auth::user()->name) }}
                                                            </td>
                                                            {{-- ++++++++ delete row ++++++++ --}}
                                                            <td>
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-xs btn-danger deleteRow">
                                                                    <i class="fa fa-close"></i>
                                                                </a>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                <div class="row mt-4">
                                                    <div class="col-sm-12">
                                                        <input type="submit" class="btn btn-primary"
                                                            value="@lang('lang.save')" name="submit">
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
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
    </div>
@endsection

@section('javascript')
    <script>
        // +++++++++++++ add "new_row" to table +++++++++++++
        $('#add_row').click(function() {
            row_index = parseInt($('#index').val());
            row_index = row_index + 1;
            $('#index').val(row_index);
            $.ajax({
                method: 'get',
                url: '/attendance/get-attendance-row/' + row_index,
                data: {},
                contentType: 'html',
                success: function(result) {
                    $('#attendance_table tbody').append(result);
                },
            });
        });
        // +++++++++++++ remove "row" to table +++++++++++++
        $('.table_tbody').on('click', '.deleteRow', function() {
            $(this).parent().parent().remove();
        });
    </script>
@endsection
