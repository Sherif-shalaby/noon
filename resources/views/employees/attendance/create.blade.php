@extends('layouts.app')
@section('title', __('lang.add_attendance_and_leave'))

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
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.attend_and_leave')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a href="{{ route('attendance.index') }}" class="btn btn-primary">
            @lang('lang.attend_and_leave')
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
                            <h6>@lang('lang.attendance')</h6>
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
                                    <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
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
                                                                <input type="date"
                                                                    class="form-control initial-balance-input width-full m-0 date"
                                                                    name="date" required>
                                                            </td>
                                                            <td>
                                                                <div class="input-wrapper width-full">

                                                                    {!! Form::select('employees', $employees, null, [
                                                                        'class' => 'form-control select2',
                                                                        'placeholder' => __('lang.please_select'),
                                                                        'data-live-search' => 'true',
                                                                        'required',
                                                                    ]) !!}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="time"
                                                                    class="form-control initial-balance-input width-full m-0 time"
                                                                    name="check_in" id="check_in_id" required>
                                                            </td>
                                                            <td>
                                                                <input type="time"
                                                                    class="form-control initial-balance-input width-full m-0 time"
                                                                    name="check_out" id="check_out_id" required>
                                                            </td>
                                                            <td>
                                                                <div class="input-wrapper width-full">

                                                                    {!! Form::select('status', ['present' => 'Present', 'late' => 'Late', 'on_leave' => 'On Leave'], null, [
                                                                        'class' => 'form-control select2',
                                                                        'id' => 'status_id',
                                                                        'data-live-search' => 'true',
                                                                        'placeholder' => __('lang.please_select'),
                                                                        'required',
                                                                    ]) !!}
                                                                </div>
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
        // Assuming check_in and check_out are the IDs of your input fields
        $('#check_in_id, #check_out_id').on('change', function() {
            var checkInValue = $('#check_in_id').val();
            var checkOutValue = $('#check_out_id').val();
            // Check if both check_in and check_out values are set
            if (checkInValue && checkOutValue) {
                // Set the value of the status select box to "present"
                $('#status_id').val('present').trigger(
                    'change'); // Use trigger('change') to trigger the change event
            }
        });
    </script>
@endsection
