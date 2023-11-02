@extends('layouts.app')
@section('title', __('lang.jobs'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between mb-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title c">
                        @lang('lang.add_employee')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ route('employees.index') }}">/
                                    @lang('lang.employees')</a>
                            </li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.add_employee')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">

                    <div
                        class="widgetbar  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a class="btn btn-primary" href="{{ route('employees.index') }}">@lang('lang.employee')</a>
                        {{--  <a style="color: white" href="{{ action('EmployeeController@create') }}" class="btn btn-info"><i --}}
                        {{--             class="dripicons-plus"></i> --}}
                        {{--              @lang('lang.add_new_employee')</a> --}}
                    </div>
                </div>
            </div>
            {{-- ///////// right side //////////// --}}
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
                            class="card-header d-flex align-items-center  @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                            <h4>
                                @lang('lang.add_employee')</h4>
                        </div>
                        <div class="card-body">
                            <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                {{-- ////////////////////// employee's products ////////////////////// --}}
                                <div class="col-md-12 text-center">
                                    <h3>@lang('lang.employee_products')</h3>
                                </div>
                                {{-- ======== Filters ======== --}}
                                <div class="col-lg-12">
                                    <div class="container-fluid">
                                        @include('employees.partials.filters')
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <form class="form-group" id="productForm" action="{{ route('employees.store') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        {{-- ++++++++++++++++++++++ employee's products ++++++++++++++++++++  --}}
                                        <div class="row mt-4 m-auto" style="max-height: 70vh;overflow: scroll">
                                            {{-- ++++++++++++++ employee's products Table ++++++++++ --}}
                                            <table id="productTable"
                                                class="table table-striped table-bordered m-auto @if (app()->isLocale('ar')) dir-rtl @endif">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        {{-- "select_all" checkbox --}}
                                                        <th> <input type="checkbox" id="select_all_ids" /> </th>
                                                        <th>@lang('lang.product_name')</th>
                                                        <th>@lang('lang.sku')</th>
                                                        <th>@lang('lang.category')</th>
                                                        <th>@lang('lang.subcategories_name')</th>
                                                        <th>@lang('lang.brand')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($employee_products as $index => $product)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            {{-- "select" checkbox --}}
                                                            <td>
                                                                {{-- get "all checked products" --}}
                                                                <input type="checkbox" name="ids[]" class="checkbox_ids"
                                                                    value="{{ $product->id }}" />
                                                            </td>
                                                            <td>{{ $product->name }}</td>
                                                            <td>{{ $product->sku }}</td>
                                                            <td>{{ $product->category->name ?? '' }}</td>
                                                            <td>
                                                                {{ $product->subCategory1->name ?? '' }} <br>
                                                                {{ $product->subCategory2->name ?? '' }} <br>
                                                                {{ $product->subCategory3->name ?? '' }}
                                                            </td>
                                                            <td>{{ !empty($product->brand) ? $product->brand->name : '' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <br />
                                        {{-- +++++++++++++++++ employee [ name , store , email ] +++++++++++++++++ --}}
                                        <div
                                            class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <div
                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <label style="font-size: 12px;font-weight: 500;"
                                                    class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="fname">@lang('lang.name')*</label>
                                                <div class="input-wrapper">

                                                    <input type="text" class="form-control initial-balance-input"
                                                        style="width: 100%;" name="name" id="name" required
                                                        placeholder="Name">
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <label style="font-size: 12px;font-weight: 500;"
                                                    class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="email">@lang('lang.email')*
                                                    <small>(@lang('lang.it_will_be_used_for_login'))</small></label>
                                                <div class="input-wrapper">
                                                    <input class="form-control initial-balance-input" style="width: 100%;"
                                                        type="email" name="email" id="email" required
                                                        placeholder="Email">
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <label style="font-size: 12px;font-weight: 500;"
                                                    class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="password">@lang('lang.password'):*</label>
                                                <div class="input-wrapper">
                                                    <input type="password" class="form-control initial-balance-input"
                                                        style="width: 100%;" name="password" id="password"
                                                        placeholder="Create New Password">
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <label style="font-size: 12px;font-weight: 500;"
                                                    class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="pass">@lang('lang.confirm_password'):*</label>
                                                <div class="input-wrapper">
                                                    <input type="password" class="form-control initial-balance-input"
                                                        style="width: 100%;" id="password_confirmation"
                                                        name="password_confirmation" placeholder="Conform Password">
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <label style="font-size: 12px;font-weight: 500;"
                                                    class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="branch_id">@lang('lang.branch')</label>
                                                <div class="input-wrapper">
                                                    {!! Form::select('branch_id', $branches, null, [
                                                        'class' => 'form-control selectpicker',
                                                        'placeholder' => __('lang.please_select'),
                                                        'data-live-search' => 'true',
                                                        'id' => 'branch_id',
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <label style="font-size: 12px;font-weight: 500;"
                                                    class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="store_id">@lang('lang.stores')</label>
                                                <div class="input-wrapper">

                                                    {!! Form::select('store_id[]', $stores, null, [
                                                        'class' => 'form-control selectpicker',
                                                        'multiple',
                                                        'data-live-search' => 'true',
                                                        'id' => 'store_id',
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <label style="font-size: 12px;font-weight: 500;"
                                                    class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="date_of_start_working">@lang('lang.date_of_start_working')</label>
                                                <div class="input-wrapper">

                                                    <input type="date"
                                                        class="form-control initial-balance-input width-full"
                                                        name="date_of_start_working" id="date_of_start_working"
                                                        placeholder="@lang('lang.date_of_start_working')">
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <label style="font-size: 12px;font-weight: 500;"
                                                    class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="date_of_birth">@lang('lang.date_of_birth')</label>
                                                <div class="input-wrapper">

                                                    <input type="date"
                                                        class="form-control initial-balance-input width-full"
                                                        name="date_of_birth" id="date_of_birth"
                                                        placeholder="@lang('lang.date_of_birth')">
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <label style="font-size: 12px;font-weight: 500;"
                                                    class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="job_type">@lang('lang.jobs')</label>
                                                <div class="input-wrapper">
                                                    {!! Form::select('job_type_id', $jobs, null, [
                                                        'class' => 'form-control selectpicker initial-balance-input width-full',
                                                        'placeholder' => __('lang.select_job_type'),
                                                        'data-live-search' => 'true',
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <label style="font-size: 12px;font-weight: 500;"
                                                    class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="mobile">@lang('lang.phone_number')*</label>
                                                <div class="input-wrapper">
                                                    <input type="mobile"
                                                        class="form-control initial-balance-input width-full"
                                                        name="mobile" id="mobile" placeholder="@lang('lang.mobile')">
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <label style="font-size: 12px;font-weight: 500;"
                                                    class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="upload_files">@lang('lang.upload_files')</label>
                                                <div class="input-wrapper">
                                                    {!! Form::file('upload_files[]', ['class' => 'form-control initial-balance-input width-full', 'multiple']) !!}
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <label style="font-size: 12px;font-weight: 500;"
                                                    class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="photo">@lang('lang.profile_photo')</label>
                                                <div class="input-wrapper">

                                                    <input type="file" name="photo" id="photo"
                                                        class="form-control initial-balance-input width-full" />
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            @foreach ($leave_types as $leave_type)
                                                <div
                                                    class=" col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                                    <div class="i-checks">

                                                        <input id="number_of_leaves{{ $leave_type->id }}"
                                                            name="number_of_leaves[{{ $leave_type->id }}][enabled]"
                                                            type="checkbox" value="1">

                                                        <label style="font-size: 12px;font-weight: 500;"
                                                            class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                            for="number_of_leaves{{ $leave_type->id }}"><strong>{{ $leave_type->name }}</strong></label>
                                                        <div class="input-wrapper">

                                                            <input type="number"
                                                                class="form-control initial-balance-input width-full"
                                                                name="number_of_leaves[{{ $leave_type->id }}][number_of_days]"
                                                                id="number_of_leaves"
                                                                placeholder="{{ $leave_type->name }}" readonly
                                                                value="{{ $leave_type->number_of_days_per_year }}">
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                        <div
                                            class="row my-2 mr-3  @if (app()->isLocale('ar')) justify-content-end @endif">
                                            <!-- Button salary modal -->
                                            <button type="button" class="btn btn-primary width-fit" data-toggle="modal"
                                                data-target="#salary_details">
                                                @lang('lang.salary_details')
                                            </button>
                                            @include('employees.partials.salary_details')
                                        </div>


                                        {{-- +++++++++++++++++++ حدد أيام العمل في الأسبوع ++++++++++++++++++++ --}}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class=" d-block text-center "
                                                    for="working_day_per_week">@lang('lang.select_working_day_per_week')</label>
                                                <table style="width: 100%"
                                                    class="@if (app()->isLocale('ar')) dir-rtl @endif">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th class="text-center">@lang('lang.check_in')</th>
                                                            <th class="text-center">@lang('lang.check_out')</th>
                                                            <th class="text-center">@lang('lang.evening_shift')</th>
                                                            <th class="text-center" id="label1" class="hidden">
                                                                @lang('lang.check_in')</th>
                                                            <th id="label2" class="hidden text-center">
                                                                @lang('lang.check_out')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($week_days as $key => $week_day)
                                                            <tr>
                                                                {{-- "working_day_per_week" checkbox --}}
                                                                <td class="text-center">
                                                                    <div class="form-group">
                                                                        <div class="i-checks">
                                                                            <input
                                                                                id="working_day_per_week{{ $key }}"
                                                                                name="working_day_per_week[{{ $key }}]"
                                                                                type="checkbox" value="1">
                                                                            <label
                                                                                for="working_day_per_week{{ $key }}"><strong>{{ $week_day }}</strong></label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                {{-- "check_in" inputField --}}
                                                                <td class="text-center">
                                                                    {{-- {!! Form::text('check_in[' . $key . ']', null, ['class' => 'form-control input-md check_in time_picker']) !!}  --}}
                                                                    {{-- <input type="datetime-local" class="form-control" name="check_in[{{ $key }}]" id="input10{{ $key }}"> --}}
                                                                    <input type="time" class="form-control"
                                                                        name="check_in[{{ $key }}]"
                                                                        id="input10{{ $key }}">
                                                                </td>
                                                                {{-- "check_out" inputField --}}
                                                                <td class="text-center">
                                                                    {{-- <input type="datetime-local" class="form-control" name="check_out[{{ $key }}]" id="input20{{ $key }}"> --}}
                                                                    {{-- {!! Form::text('check_out[' . $key . ']', null, ['class' => 'form-control input-md check_out time_picker']) !!} --}}
                                                                    <input type="time" class="form-control"
                                                                        name="check_out[{{ $key }}]"
                                                                        id="input20{{ $key }}">
                                                                    {{-- {!! Form::text('check_out[' . $key . ']', null, ['class' => 'form-control input-md check_out time_picker']) !!} --}}
                                                                </td>
                                                                {{-- ++++++++++++++++++ Evening Shift +++++++++++++++ --}}
                                                                <td class="text-center">
                                                                    <input type="checkbox" class="checkbox-toggle"
                                                                        id="checkbox2{{ $key }}"
                                                                        name="evening_shift_checkbox[{{ $key }}]">
                                                                </td>
                                                                {{--  "تسجيل الدخول" , "تسجيل الخروج" --}}
                                                                <td
                                                                    class="text-center d-flex justify-content-center align-items-center">
                                                                    <table class="hidden inputFields_evening_shift"
                                                                        id="inputFields_evening_shift{{ $key }}">
                                                                        <tr>
                                                                            {{-- تسجيل الدخول --}}
                                                                            <td>
                                                                                {{-- <input type="datetime-local" class="form-control" name="evening_shift_check_in[{{ $key }}]" id="input1{{ $key }}"> --}}
                                                                                <input type="time" class="form-control"
                                                                                    name="evening_shift_check_in[{{ $key }}]"
                                                                                    id="input1{{ $key }}">
                                                                            </td>
                                                                            {{-- تسجيل الخروج --}}
                                                                            <td>
                                                                                {{-- <input type="datetime-local" class="form-control" name="evening_shift_check_out[{{ $key }}]" id="input2{{ $key }}"> --}}
                                                                                <input type="time" class="form-control"
                                                                                    name="evening_shift_check_out[{{ $key }}]"
                                                                                    id="input2{{ $key }}">
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                {{-- <br/>  --}}
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        {{-- +++++++++++++++++++ permission +++++++++++++++++++ --}}
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h3>@lang('lang.user_rights')</h3>
                                            </div>
                                            <div class="col-md-12">
                                                @include('employees.partials.permission')
                                            </div>
                                        </div>

                                        {{-- +++++++++++++ save Button +++++++++++ --}}
                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <div class="text-right">
                                                    <input type="submit" id="submit-btn" class="btn btn-primary"
                                                        value="@lang('lang.save')" name="submit">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
        $(document).ready(function() {
            $('.checked_all').change(function() {
                tr = $(this).closest('tr');
                var checked_all = $(this).prop('checked');

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
            })
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
            $(document).on('focusout', '.check_in', function() {
                $('.check_in').val($(this).val())
            })
            $(document).on('focusout', '.check_out', function() {
                $('.check_out').val($(this).val())
            })
            // +++++++++++++++++ Evening Shift +++++++++++++++++
            // Get all the checkboxes and input fields
            const checkboxes = document.querySelectorAll('.checkbox-toggle');
            const inputFields = document.querySelectorAll('.inputFields_evening_shift');
            const label1 = document.getElementById('label1');
            const label2 = document.getElementById('label2');
            // when checkbox of "evening shift" is "checked" then appear "two input fields"
            checkboxes.forEach((checkbox, index) => {
                checkbox.addEventListener('change', function() {
                    if (checkbox.checked) {
                        inputFields[index].classList.remove('hidden');
                        updateLabelsVisibility();
                    } else {
                        inputFields[index].classList.add('hidden');
                        updateLabelsVisibility();
                    }
                });
                // Check the initial state of checkboxes and show/hide labels accordingly
                if (checkbox.checked) {
                    label1.classList.remove('hidden');
                    label2.classList.remove('hidden');
                } else {
                    label1.classList.add('hidden');
                    label2.classList.add('hidden');
                }
                // ++++++++++++++++++++ updateLabelsVisibility() ++++++++++++++++++++
                function updateLabelsVisibility() {
                    let anyCheckboxChecked = false;
                    checkboxes.forEach(function(checkbox) {
                        if (checkbox.checked) {
                            anyCheckboxChecked = true;
                        }
                    });
                    if (anyCheckboxChecked) {
                        label1.classList.remove('hidden');
                        label2.classList.remove('hidden');
                    } else {
                        label1.classList.add('hidden');
                        label2.classList.add('hidden');
                    }
                }
                // Initially update labels visibility based on the checked state of checkboxes
                updateLabelsVisibility();
            });
            // // ======================================== Employee Products Table ========================================
            // // +++++++++++++++ updateSubcategories() +++++++++++++++
            // // Function to update subcategories based on the selected category ID
            // function updateSubcategories()
            // {
            //     console.log( $('body').find('.category option:selected').val() );
            //     $.ajax({
            //         method : "get",
            //         url: "/employees/create/",
            //         // get "all inputFields of form that have name and value"
            //         // data: $('#filter_form').serialize(),
            //         data : {
            //             category_id : $('body').find('.category option:selected').val(),
            //             subcategory_id1 : $('body').find('.subcategory1 option:selected').val(),
            //             subcategory_id2 : $('body').find('.subcategory2 option:selected').val(),
            //             subcategory_id3 : $('body').find('.subcategory3 option:selected').val(),
            //             brand_id : $('body').find('.brand option:selected').val(),
            //         },
            //         success: function (response) {
            //             console.log("The Response Data : ");
            //             console.log(response)
            //             // Clear existing table content
            //             $('#productTable tbody').empty();
            //             // +++++++++++++++++++++++++ table content according to filters +++++++++++++++++++++++++++
            //             // Assuming response.products is the array of products received from the server response
            //             $.each(response, function(index, product) {
            //                 console.log(product);
            //                 var row = '<tr>' +
            //                     '<td>' + (index + 1) + '</td>' +
            //                     '<td><input type="checkbox" name="ids[]" class="checkbox_ids" value="' + product.id + '" data-product_id="' + product.id + '" /></td>' +
            //                     '<td>' + product.name + '</td>' +
            //                     '<td>' + product.sku + '</td>' +
            //                     '<td>' + (product.category ? product.category.name : '') + '</td>' +
            //                     '<td>' +
            //                     (product.subCategory1 ? product.subCategory1.name + '<br>' : '') +
            //                     (product.subCategory2 ? product.subCategory2.name + '<br>' : '') +
            //                     (product.subCategory3 ? product.subCategory3.name : '') +
            //                     '</td>' +
            //                     '<td>' + (product.brand ? product.brand.name : '') + '</td>' +
            //                     '</tr>';
            //                 $('#productTable tbody').append(row);
            //             });

            //         },
            //         error: function (error) {
            //             console.error("Error fetching filtered products:", error);
            //         }
            //     });
            // }
            // // when clicking on "filter button" , call "updateSubcategories()" method
            // $('#filter_btn').click(function(){
            //     updateSubcategories();
            // });
            // ======================================== Checkboxes of "products" table ========================================
            // when click on "all checkboxs" , it will checked "all checkboxes"
            $('#select_all_ids').click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'));
            });
            // ++++++++++++++++++++++++++++ submit button +++++++++++++++++++++++++
            // $('#submit-btn').click(function(event) {

            //     // Prevent the default form submission behavior
            //     event.preventDefault();
            //     // Serialize the form data from the form with ID 'productForm'
            //     var formData = $('#productForm').serialize();

            //     // Make the AJAX request
            //     $.ajax({
            //         type: 'POST',
            //         url: '/products',
            //         data: formData,
            //         dataType: 'json',
            //         success: function(response) {
            //             console.log(response.message); // Output success message
            //             // Handle success, for example, show a success message to the user
            //         },
            //         error: function(error) {
            //             console.error('Error:', error);
            //             // Handle errors, for example, show an error message to the user
            //         }
            //     });
            // });

        });
    </script>
@endpush
