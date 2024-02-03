@extends('layouts.app')
@section('title', __('lang.employee_module'))

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


        .accordion-button:hover {
            box-shadow: 2px 2px 3px 1px #7489e8 !important;
        }

        .accordion-content {
            display: none;
        }

        .table-head {
            margin-top: 55px;
        }

        @media(max-width:767px) {
            .table-head {
                margin-top: 145px;
            }
        }

        .bootstrap-select {
            width: 100% !important
        }




        @keyframes bounceUpDown {
            0% {
                transform: translateY(0);
            }

            25% {
                transform: translateY(-10px);
            }

            50% {
                transform: translateY(0);
            }

            75% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .accordion-button:hover i {
            animation: bounceUpDown 0.5s ease-in-out;
        }

        .accordion-button i {
            transition: 0.4s;
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.add_employee')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('employees.index') }}">/
            @lang('lang.employees')</a>
    </li>
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.add_employee')</li>
@endsection

@section('button')
    <div class="widgetbar  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a class="btn btn-primary" href="{{ route('employees.index') }}">@lang('lang.employee')</a>
    </div>
@endsection

@section('content')
    <div class="animate-in-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif"
                            style="margin-bottom: 25px">
                            <h6>@lang('lang.add_employee')</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div id="filter-wrap" style="display: none">
                                    {{-- ======== Filters ======== --}}
                                    @include('employees.partials.filters')
                                </div>

                                <div class="col-sm-12">
                                    <form class="form-group" id="productForm" action="{{ route('employees.store') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        {{-- ++++++++++++++++++++++ employee's products ++++++++++++++++++++  --}}
                                        <div class="accordion mb-1 animate__animated animate__bounceInLeft"
                                            style="animation-delay:1.1s">
                                            <div class="accordion-item" style="border: none">
                                                <h2 class="accordion-header d-flex justify-content-end"
                                                    id="employee-products">
                                                    <div class="accordion-button" id="product-accordion-button"
                                                        style="margin-top: -30px;"
                                                        onclick="toggleAccordion(`collapseOneEmployeesProducts`)">
                                                        <span class="collapseOneEmployeesProducts mx-2">
                                                            <i class="fas fa-arrow-down" style="font-size: 0.8rem"></i>
                                                        </span>
                                                        @lang('lang.employee_products')
                                                    </div>
                                                </h2>
                                                <div id="collapseOneEmployeesProducts" class="accordion-content">
                                                    <div class="accordion-body p-0">

                                                        <div class="row table-head"
                                                            style="max-height: 70vh;overflow: scroll;">
                                                            {{-- ++++++++++++++ employee's products Table ++++++++++ --}}
                                                            <table id="datatable-buttons"
                                                                class="table table-striped table-bordered m-auto @if (app()->isLocale('ar')) dir-rtl @endif">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        {{-- "select_all" checkbox --}}
                                                                        <th> <input type="checkbox" id="select_all_ids" />
                                                                        </th>
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
                                                                                <input type="checkbox" name="ids[]"
                                                                                    class="checkbox_ids"
                                                                                    value="{{ $product->id }}" />
                                                                            </td>
                                                                            <td>{{ $product->name }}</td>
                                                                            <td>{{ $product->sku }}</td>
                                                                            <td>{{ $product->category->name ?? '' }}</td>
                                                                            <td>
                                                                                {{ $product->subCategory1->name ?? '' }}
                                                                                <br>
                                                                                {{ $product->subCategory2->name ?? '' }}
                                                                                <br>
                                                                                {{ $product->subCategory3->name ?? '' }}
                                                                            </td>
                                                                            <td>{{ !empty($product->brand) ? $product->brand->name : '' }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            {{-- ######## pagination ######## --}}
                                                            {{-- <div class="pagination my-3 mx-auto">
                                                                {{ $employee_products->links() }}
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- +++++++++++++++++ employee [ name , store , email ] +++++++++++++++++ --}}
                                        <div
                                            class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <div class="col-6 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                                style="animation-delay: 1.2s">
                                                <label
                                                    class="mx-2 mb-0  @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="fname">@lang('lang.name')*</label>
                                                <div class="input-wrapper">

                                                    <input type="text" class="form-control initial-balance-input"
                                                        style="width: 100%;" name="name" id="name" required
                                                        placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                                style="animation-delay: 1.25s">
                                                <label
                                                    class="mx-2 mb-0  @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="email"><small>(@lang('lang.it_will_be_used_for_login'))</small>@lang('lang.email')*
                                                </label>
                                                <div class="input-wrapper">
                                                    <input class="form-control initial-balance-input" style="width: 100%;"
                                                        type="email" name="email" id="email" required
                                                        placeholder="Email">
                                                </div>
                                            </div>

                                            <div class="col-6 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                                style="animation-delay: 1.3s">
                                                <label
                                                    class="mx-2 mb-0  @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="password">@lang('lang.password')*</label>
                                                <div class="input-wrapper">
                                                    <input type="password" class="form-control initial-balance-input"
                                                        style="width: 100%;" name="password" id="password"
                                                        placeholder="Create New Password">
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                                style="animation-delay: 1.35s">
                                                <label
                                                    class="mx-2 mb-0  @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="pass">@lang('lang.confirm_password'):*</label>
                                                <div class="input-wrapper">
                                                    <input type="password" class="form-control initial-balance-input"
                                                        style="width: 100%;" id="password_confirmation"
                                                        name="password_confirmation" placeholder="Conform Password">
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                                style="animation-delay: 1.4s">
                                                <label
                                                    class="mx-2 mb-0  @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="mobile">@lang('lang.phone_number')*</label>
                                                <div class="input-wrapper">
                                                    <input type="mobile"
                                                        class="form-control initial-balance-input width-full"
                                                        name="mobile" id="mobile" placeholder="@lang('lang.mobile')">
                                                </div>
                                            </div>

                                            <div class="col-6 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                                style="animation-delay: 1.45s;position: relative;z-index: 999;">
                                                <label
                                                    class="mx-2 mb-0  @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="branch_id">@lang('lang.branch')</label>
                                                <div class="input-wrapper" style="background-color: transparent">
                                                    {!! Form::select('branch_id', $branches, null, [
                                                        'class' => ' selectpicker p-0',
                                                        'style' => 'width:100% !important',
                                                        'placeholder' => __('lang.please_select'),
                                                        'data-live-search' => 'true',
                                                        'id' => 'branch_id',
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                                style="animation-delay: 1.5s;position: relative;z-index: 999;">
                                                <label
                                                    class="mx-2 mb-0  @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="store_id">@lang('lang.stores')</label>
                                                <div class="input-wrapper" style="background-color: transparent">
                                                    {!! Form::select('store_id[]', $stores, null, [
                                                        'class' => 'selectpicker  p-0',
                                                        'style' => 'width:100% !important',
                                                        'multiple',
                                                        'data-live-search' => 'true',
                                                        'id' => 'store_id',
                                                    ]) !!}
                                                </div>
                                            </div>

                                            <div class="col-6 col-md-3 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                                style="animation-delay: 1.55s;position: relative;z-index: 999;">
                                                <label
                                                    class="mx-2 mb-0  @if (app()->isLocale('ar')) d-block text-end @endif"
                                                    for="job_type">@lang('lang.jobs')</label>
                                                <div class="input-wrapper" style="background-color: transparent">
                                                    {!! Form::select('job_type_id', $jobs, null, [
                                                        'class' => 'selectpicker p-0 ',
                                                        'style' => 'width:100% !important',
                                                        'placeholder' => __('lang.select_job_type'),
                                                        'data-live-search' => 'true',
                                                        'id' => 'job_type_id',
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
                                                                    class="mx-2 mb-0  @if (app()->isLocale('ar')) d-block text-end @endif"
                                                                    for="date_of_start_working">@lang('lang.date_of_start_working')</label>
                                                                <div class="input-wrapper">

                                                                    <input type="date"
                                                                        class="form-control initial-balance-input width-full"
                                                                        name="date_of_start_working"
                                                                        id="date_of_start_working"
                                                                        placeholder="@lang('lang.date_of_start_working')">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                                <label
                                                                    class="mx-2 mb-0  @if (app()->isLocale('ar')) d-block text-end @endif"
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
                                                                <label
                                                                    class="mx-2 mb-0  @if (app()->isLocale('ar')) d-block text-end @endif"
                                                                    for="upload_files">@lang('lang.upload_files')</label>
                                                                <div class="input-wrapper">
                                                                    {!! Form::file('upload_files[]', ['class' => 'form-control initial-balance-input width-full', 'multiple']) !!}
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                                <label
                                                                    class="mx-2 mb-0  @if (app()->isLocale('ar')) d-block text-end @endif"
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

                                        <div class="row animate__animated animate__bounceInLeft"
                                            style="animation-delay: 1.65s">
                                            @foreach ($leave_types as $leave_type)
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="i-checks">
                                                            <input id="number_of_leaves{{ $leave_type->id }}"
                                                                name="number_of_leaves[{{ $leave_type->id }}][enabled]"
                                                                type="checkbox" value="1">
                                                            <label
                                                                for="number_of_leaves{{ $leave_type->id }}"><strong>{{ $leave_type->name }}</strong></label>
                                                            <input type="number" class="form-control"
                                                                name="number_of_leaves[{{ $leave_type->id }}][number_of_days]"
                                                                id="number_of_leaves"
                                                                placeholder="{{ $leave_type->name }}" readonly
                                                                value="{{ $leave_type->number_of_days_per_year }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>


                                        <div class="row justify-content-end mr-0 mb-1 animate__animated animate__bounceInLeft"
                                            style="animation-delay: 1.7s">
                                            <!-- Button salary modal -->
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
                                                class="btn btn-primary" data-toggle="modal"
                                                data-target="#salary_details">
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
                                                                    <th class="text-center">@lang('lang.check_out')</th>
                                                                    <th class="text-center">@lang('lang.evening_shift')</th>
                                                                    <th class="text-center" id="label1"
                                                                        class="hidden">
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
                                                                                        <input type="time"
                                                                                            class="form-control"
                                                                                            name="evening_shift_check_in[{{ $key }}]"
                                                                                            id="input1{{ $key }}">
                                                                                    </td>
                                                                                    {{-- تسجيل الخروج --}}
                                                                                    <td>
                                                                                        {{-- <input type="datetime-local" class="form-control" name="evening_shift_check_out[{{ $key }}]" id="input2{{ $key }}"> --}}
                                                                                        <input type="time"
                                                                                            class="form-control"
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
                                        {{-- . --}}
                                        {{-- +++++++++++++ save Button +++++++++++ --}}
                                        <div class="row mt-4 animate__animated animate__bounceInLeft"
                                            style="animation-delay: 1.85s">
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
            // "edit" column : when check "تعديل checkbox" Then check "all checkboxes" of in the "same row"
            $(document).on('change', '.edit_check_all', function() {
                if ($(this).prop('checked')) {
                    $('.check_box_edit').prop('checked', true);
                } else {
                    $('.check_box_edit').prop('checked', false);
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

            // ======================================== Checkboxes of "products" table ========================================
            // when click on "all checkboxs" , it will checked "all checkboxes"
            $('#select_all_ids').click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'));
            });
            // ++++++++++++++++++++ Get "job_type" Permissions +++++++++++++++++++++++++
            // when select "job_type" , it will get "all permissions" of "selected job type"
            $('#job_type_id').change(function() {
                var jobTypeId = $(this).val();
                console.log("The Selected 'job_type' = " + jobTypeId);
                // Make an AJAX request to fetch permissions based on the selected job type
                $.ajax({
                    url: '/get-job-type-permissions/' + jobTypeId, // Replace with your actual route
                    type: 'GET',
                    success: function(data) {
                        updatePermissionCheckboxes(data);
                        console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching job type permissions:', error);
                    }
                });
            });
            // ------- updatePermissionCheckboxes() -------------
            function updatePermissionCheckboxes(permissions) {
                // Uncheck all checkboxes first
                $('.check_box').prop('checked', false);
                // Check checkboxes based on permissions array
                permissions.forEach(function(permission) {
                    $('input[name="permissions[' + permission + ']"]').prop('checked', true);
                });
            }
        });
    </script>
    <script>
        function toggleAccordion(sectionId) {
            const section = document.getElementById(sectionId);
            let arrow = document.querySelector(`.${sectionId}`);



            if (section.style.display === "block") {

                section.style.display = "none";

                // Check if the element exists
                if (arrow) {
                    // Remove all children from the "wrap" element
                    while (arrow.firstChild) {
                        arrow.removeChild(arrow.firstChild);
                    }

                    // Create a new <i> element with the desired attributes
                    let newIElement = document.createElement('i');
                    newIElement.className = 'fas fa-arrow-down';
                    newIElement.style.fontSize = '0.8rem';

                    // Append the new <i> element to the "wrap" element
                    arrow.appendChild(newIElement);
                }
            } else {

                section.style.display = "block";

                // Check if the element exists
                if (arrow) {
                    // Remove all children from the "wrap" element
                    while (arrow.firstChild) {
                        arrow.removeChild(arrow.firstChild);
                    }

                    // Create a new <i> element with the desired attributes
                    let newIElement = document.createElement('i');
                    newIElement.className = 'fas fa-arrow-up';
                    newIElement.style.fontSize = '0.8rem';

                    // Append the new <i> element to the "wrap" element
                    arrow.appendChild(newIElement);
                }
            }
        }
    </script>
    <script>
        const employeeProducts = document.getElementById('employee-products');
        const filterWrap = document.getElementById('filter-wrap');

        employeeProducts.addEventListener('click', function() {
            if (filterWrap.style.display === 'block') {
                filterWrap.style.display = 'none'
            } else {
                filterWrap.style.display = 'block'
            }
        })
    </script>
@endpush
