@extends('layouts.app')
@section('title', __('lang.edit_employee'))

@push('css')
    <style>
        .accordion-item {
            background-color: transparent
        }

        .accordion-button {
            padding: 8px !important;
            width: 300px !important;
            background-color: #596fd7 !important;
            color: white !important;
            border-radius: 6px !important;
            cursor: pointer;
            display: flex;
            justify-content: space-between
        }

        .accordion-content {
            display: none;
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.employees')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('employees.index') }}">/
            @lang('lang.employees')</a></li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"><a
            style="text-decoration: none;color: #596fd7"
            href="{{ route('employees.edit', $employee->id) }}">@lang('lang.edit_employee')</a></li>
@endsection

@section('content')
    <div class="animate-in-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div
                            class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                            <h6>@lang('lang.edit_employee')</h6>
                        </div>
                        <div class="card-body">
                            {!! Form::open([
                                'url' => route('employees.update', $employee->id),
                                'method' => 'put',
                                'id' => 'edit_employee_form',
                                'enctype' => 'multipart/form-data',
                            ]) !!}

                            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                    style="animation-delay: 1.2s">
                                    <label
                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                        for="fname">@lang('lang.name')*</label>
                                    <div class="input-wrapper">
                                        <input type="text" class="form-control initial-balance-input"
                                            style="width: 100%;" name="name" value="{{ $employee->employee_name }}"
                                            @if ($employee->name == 'Admin') readonly @endif id="name" required
                                            placeholder="Name">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                    style="animation-delay: 1.25s">
                                    <label
                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                        for="email">@lang('lang.email')*<small>(@lang('lang.it_will_be_used_for_login'))</small></label>
                                    <div class="input-wrapper">
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $employee->user->email }}" id="email" required
                                            placeholder="Email">
                                    </div>
                                </div>
                                {{-- ============= password ============= --}}
                                <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                    style="animation-delay: 1.3s">
                                    <label
                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                        for="password">@lang('lang.password')</label>
                                    <div class="input-wrapper">
                                        <input type="password" class="form-control initial-balance-input"
                                            style="width: 100%;" name="password" id="password"
                                            placeholder="Create New Password">
                                    </div>
                                </div>
                                {{-- ============= confirm_password ============= --}}
                                <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                    style="animation-delay: 1.35s">
                                    <label
                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                        for="pass">@lang('lang.confirm_password')</label>
                                    <div class="input-wrapper">

                                        <input type="password" class="form-control initial-balance-input"
                                            style="width: 100%;" id="password_confirmation" name="password_confirmation"
                                            placeholder="Conform Password">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                    style="animation-delay: 1.4s">
                                    <label
                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                        for="mobile">@lang('lang.mobile')*</label>
                                    <div class="input-wrapper">
                                        <input type="mobile" class="form-control initial-balance-input width-full"
                                            name="mobile" id="mobile" value="{{ $employee->mobile }}"
                                            placeholder="@lang('lang.mobile')">
                                    </div>
                                </div>

                                {{-- ============= branch_id ============= --}}
                                <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                    style="animation-delay: 1.45s">
                                    <label
                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                        for="branch_id">@lang('lang.branch')</label>
                                    <div class="input-wrapper" style="background-color: transparent">
                                        {!! Form::select('branch_id', $branches, $employee->branch_id, [
                                            'class' => 'form-control selectpicker p-0 width-full',
                                            'placeholder' => __('lang.please_select'),
                                            'data-live-search' => 'true',
                                            'id' => 'branch_id',
                                        ]) !!}
                                    </div>
                                </div>
                                {{-- ============= store_id ============= --}}
                                <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                    style="animation-delay: 1.5s">
                                    <label
                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                        for="store_id">@lang('lang.store')</label>
                                    <div class="input-wrapper" style="background-color: transparent">
                                        {!! Form::select('store_id[]', $stores, $selected_stores, [
                                            'class' => 'selectpicker  p-0 width-full',
                                            'multiple',
                                            'placeholder' => __('lang.please_select'),
                                            'data-live-search' => 'true',
                                            'id' => 'store_id',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                    style="animation-delay: 1.55s">
                                    <label
                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                        for="job_type">@lang('lang.job_type')</label>
                                    <div class="input-wrapper" style="background-color: transparent">
                                        {!! Form::select('job_type_id', $jobs, $employee->job_type_id, [
                                            'class' => 'selectpicker p-0 width-full',
                                            'placeholder' => __('lang.select_job_type'),
                                        ]) !!}
                                    </div>
                                </div>
                            </div>


                            <div class="accordion mb-1 animate__animated animate__bounceInLeft"
                                style="animation-delay: 1.6s">
                                <div class="accordion-item" style="border: none">
                                    <h2 class="accordion-header d-flex justify-content-end">
                                        <div class="accordion-button"
                                            onclick="toggleAccordion(`collapseOneEmployeesOtherDetails`)">
                                            <span class="collapseOneEmployeesOtherDetails mx-2">
                                                <i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>
                                            </span>
                                            @lang('lang.more_details')
                                        </div>
                                    </h2>
                                    <div id="collapseOneEmployeesOtherDetails" class="accordion-content">
                                        <div class="accordion-body p-0">
                                            <div
                                                class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                                <div
                                                    class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                    <label
                                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                        for="date_of_start_working">@lang('lang.date_of_start_working')</label>
                                                    <div class="input-wrapper">

                                                        <input type="date_of_start_working"
                                                            class="form-control initial-balance-input width-full"
                                                            name="date_of_start_working"
                                                            value="@if (!empty($employee->date_of_start_working)) {{ @format_date($employee->date_of_start_working) }} @endif"
                                                            id="date_of_start_working" placeholder="@lang('lang.date_of_start_working')">
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                    <label
                                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                        for="date_of_birth">@lang('lang.date_of_birth')</label>
                                                    <div class="input-wrapper">

                                                        <input type="date_of_birth"
                                                            class="form-control initial-balance-input width-full"
                                                            name="date_of_birth" id="date_of_birth"
                                                            value="@if (!empty($employee->date_of_birth)) {{ @format_date($employee->date_of_birth) }} @endif"
                                                            placeholder="@lang('lang.date_of_birth')">
                                                    </div>
                                                </div>

                                                <div
                                                    class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                    <label
                                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                        for="upload_files">@lang('lang.upload_files')</label>
                                                    <div class="input-wrapper">

                                                        {!! Form::file('upload_files[]', ['class' => 'form-control initial-balance-input width-full', 'multiple']) !!}
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                    <label
                                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                        for="photo">@lang('lang.profile_photo')</label>
                                                    <div class="input-wrapper">

                                                        <input type="file" name="photo" id="photo"
                                                            class="form-control initial-balance-input width-full" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>








                            <div class="row justify-content-end mr-0 mb-1 animate__animated animate__bounceInLeft"
                                style="animation-delay: 1.7s">
                                <!-- Button trigger modal -->
                                <button type="button"
                                    style=" padding: 6px;
                                                        width: 300px;
                                                        background-color: #596fd7;
                                                        color: white;
                                                        border-radius: 6px;
                                                        cursor: pointer;
                                                        font-size: 15px;
                                                        font-weight: 700;
                                                        text-align: end"
                                    class="btn btn-primary" data-toggle="modal" data-target="#salary_details">
                                    @lang('lang.salary_details')
                                </button>

                            </div>
                            @include('employees.partials.salary_details')



                            {{-- +++++++++++++++++++ حدد أيام العمل في الأسبوع ++++++++++++++++++++ --}}
                            <div class="accordion mb-1 animate__animated animate__bounceInLeft"
                                style="animation-delay: 1.75s">
                                <div class="accordion-item" style="border: none">
                                    <h2 class="accordion-header d-flex justify-content-end">
                                        <div class="accordion-button"
                                            onclick="toggleAccordion(`collapseOneEmployeesWorkDays`)">
                                            <span class="collapseOneEmployeesWorkDays mx-2">
                                                <i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>
                                            </span>
                                            @lang('lang.select_working_day_per_week')
                                        </div>
                                    </h2>
                                    <div id="collapseOneEmployeesWorkDays" class="accordion-content">
                                        <div class="accordion-body p-0">
                                            <table style="width: 100%"
                                                class="@if (app()->isLocale('ar')) dir-rtl @endif">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-center">@lang('lang.check_in')</th>
                                                        <th class="text-center"> @lang('lang.check_out')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($week_days as $key => $week_day)
                                                        <tr>
                                                            <td class="text-center">
                                                                <div class="form-group">
                                                                    <div class="i-checks">
                                                                        <input id="working_day_per_week{{ $key }}"
                                                                            @if (!empty($employee->working_day_per_week[$key])) checked @endif
                                                                            name="working_day_per_week[{{ $key }}]"
                                                                            type="checkbox" value="1">
                                                                        <label
                                                                            for="working_day_per_week{{ $key }}"><strong>{{ $week_day }}</strong></label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                {!! Form::text('check_in[' . $key . ']', !empty($employee->check_in[$key]) ? $employee->check_in[$key] : null, [
                                                                    'class' => 'form-control input-md check_in time_picker ',
                                                                ]) !!}
                                                            </td>
                                                            <td class="text-center">
                                                                {!! Form::text(
                                                                    'check_out[' . $key . ']',
                                                                    !empty($employee->check_out[$key]) ? $employee->check_out[$key] : null,
                                                                    ['class' => 'form-control input-md check_out time_picker'],
                                                                ) !!}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- +++++++++++++++++++ permission +++++++++++++++++++ --}}
                            <div class="accordion mb-1 animate__animated animate__bounceInLeft"
                                style="animation-delay: 1.8s">
                                <div class="accordion-item" style="border: none">
                                    <h2 class="accordion-header d-flex justify-content-end">
                                        <div class="accordion-button"
                                            onclick="toggleAccordion(`collapseOneEmployeesRights`)">
                                            <span class="collapseOneEmployeesRights mx-2">
                                                <i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>
                                            </span>
                                            @lang('lang.user_rights')
                                        </div>
                                    </h2>
                                    <div id="collapseOneEmployeesRights" class="accordion-content">
                                        <div class="accordion-body p-0">
                                            @include('employees.partials.permission')
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="row mt-4 animate__animated animate__bounceInLeft" style="animation-delay: 1.85s">

                                <div class="col-sm-12">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary"
                                            id="submit-btn">@lang('lang.update_employee')</button>
                                    </div>
                                </div>

                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('javascripts')
    <script>
        $(document).on("change", "#branch_id", function() {
            $.ajax({
                type: "get",
                url: "/get_branch_stores/" + $(this).val(),
                dataType: "html",
                success: function(response) {
                    console.log(response)
                    $("#store_id").empty().append(response).change();
                }
            });
        });

        $('.js-example-basic-multiple').select2({
            placeholder: "{{ __('lang.please_select') }}",
            tags: true
        });
        $('#date_of_start_working').datepicker({
            language: '{{ session('language') }}',
            todayHighlight: true,
        });
        $('#date_of_birth').datepicker({
            language: '{{ session('language') }}',
        });


        $('#fixed_wage').change(function() {
            console.log($(this).prop('checked'));
        })

        $('.checked_all').change(function() {
            tr = $(this).closest('tr');
            var checked_all = $(this).prop('checked');
            console.log(checked_all);

            tr.find('.check_box').each(function(item) {
                if (checked_all === true) {
                    $(this).prop('checked', true)
                } else {
                    $(this).prop('checked', false)
                }
            })
        })
        $('.all_module_check_all').change(function() {
            var all_module_check_all = $(this).prop('checked');
            $('#permission_table > tbody > tr').each((i, tr) => {
                $(tr).find('.check_box').each(function(item) {
                    if (all_module_check_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })
                $(tr).find('.module_check_all').each(function(item) {
                    if (all_module_check_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })
                $(tr).find('.checked_all').each(function(item) {
                    if (all_module_check_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })

            })
        })
        $('.module_check_all').change(function() {
            let moudle_id = $(this).closest('tr').data('moudle');
            if ($(this).prop('checked')) {
                $('.sub_module_permission_' + moudle_id).find('.checked_all').prop('checked', true);
                $('.sub_module_permission_' + moudle_id).find('.check_box').prop('checked', true);
            } else {
                $('.sub_module_permission_' + moudle_id).find('.checked_all').prop('checked', false);
                $('.sub_module_permission_' + moudle_id).find('.check_box').prop('checked', false);
            }
        });
        $(document).on('change', '.view_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_view').prop('checked', true);
            } else {
                $('.check_box_view').prop('checked', false);
            }
        });
        $(document).on('change', '.create_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_create').prop('checked', true);
            } else {
                $('.check_box_create').prop('checked', false);
            }
        });
        $(document).on('change', '.delete_check_all', function() {
            if ($(this).prop('checked')) {
                $('.check_box_delete').prop('checked', true);
            } else {
                $('.check_box_delete').prop('checked', false);
            }
        });

        $(document).on('click', '#submit-btn', function(e) {
            jQuery('#edit_employee_form').validate({
                rules: {
                    password: {
                        minlength: function() {
                            return $('#password').val().length > 0 ? 6 : 0;
                        }
                    },
                    password_confirmation: {
                        minlength: function() {
                            return $('#password').val().length > 0 ? 6 : 0;
                        },
                        equalTo: {
                            depends: function() {
                                return $('#password').val().length > 0;
                            },
                            param: "#password"
                        }
                    }
                }
            });
            if ($('#edit_employee_form').valid()) {
                $('form#edit_employee_form').submit();
            }
        })
        $(document).on('focusout', '.check_in', function() {
            $('.check_in').val($(this).val())
        })
        $(document).on('focusout', '.check_out', function() {
            $('.check_out').val($(this).val())
        })
        $(document).on('click', '.salary_cancel', function() {
            $('.salary_fields').val('');
            $('.salary_select').val('');
            $('.salary_select').selectpicker('refresh');
            $('.salary_checkbox').prop('checked', false);

        })
    </script>
@endpush
