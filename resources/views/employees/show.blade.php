@extends('layouts.app')
@section('title', __('lang.employee'))

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
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('employees.index') }}">/
            @lang('lang.employees')</a>
    </li>
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page">
        @lang('lang.employee')
        {{ $employee->employee_name }}</li>
@endsection


@section('content')
    <div class="animate-in-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div
                            class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                            <h6>@lang('lang.employee') </h6>
                            {{--                        <a href="{{action('EmployeeController@sendLoginDetails', $employee->id)}}" --}}
                            {{--                            class="btn btn-primary btn-xs" style="margin-left: 10px;"><i class="fa fa-paper-plane"></i> @lang('lang.send_credentials')</a> --}}
                        </div>
                        <div class="card-body">
                            <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                <div class="col-md-10">
                                    <div
                                        class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                        <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                            style="animation-delay: 1.2s">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="fname">@lang('lang.employee_name') </label>:
                                            <span style="font-size: 16px;font-weight: 500" class="mx-2 mb-0">
                                                {{ $employee->employee_name ?? '' }}
                                            </span>
                                        </div>
                                        <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                            style="animation-delay: 1.25s">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="store_id">@lang('lang.store') </label>:
                                            <span style="font-size: 16px;font-weight: 500" class="mx-2 mb-0">
                                                @if (!empty($employee->store))
                                                    {{ implode(',', $employee->store->pluck('name')->toArray()) }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                            style="animation-delay: 1.3s">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="email">@lang('lang.email') </label>:
                                            <span style="font-size: 16px;font-weight: 500" class="mx-2 mb-0">
                                                {{ $employee->email }}
                                            </span>
                                        </div>
                                        <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                            style="animation-delay: 1.35s">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="date_of_start_working">@lang('lang.date_of_start_working') </label>:
                                            <span style="font-size: 16px;font-weight: 500" class="mx-2 mb-0">
                                                @if (!empty($employee->date_of_start_working))
                                                    {{ @format_date($employee->date_of_start_working) }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                            style="animation-delay: 1.4s">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="date_of_birth">@lang('lang.date_of_birth') </label>:
                                            <span style="font-size: 16px;font-weight: 500" class="mx-2 mb-0">
                                                @if (!empty($employee->date_of_birth))
                                                    {{ @format_date($employee->date_of_birth) }}
                                                @endif
                                            </span>
                                        </div>

                                        <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                            style="animation-delay: 1.45s">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="job_type">@lang('lang.job_type') </label>:
                                            <span style="font-size: 16px;font-weight: 500" class="mx-2 mb-0">
                                                {{-- @if (!empty($employee->job_type_id))
                                            {{ $employee->job_type->title }}
                                        @endif --}}
                                            </span>
                                        </div>
                                        <div class="col-md-3 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                            style="animation-delay: 1.5s">
                                            <label
                                                class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                                for="mobile">@lang('lang.phone_number')</label>:
                                            <span style="font-size: 16px;font-weight: 500" class="mx-2 mb-0">
                                                {{ $employee->mobile }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 animate__bounceInLeft" style="animation-delay: 1.2s">
                                    <div class="thumbnail">
                                        <img src="@if (!empty($employee->photo)) {{ asset('uploads/' . $employee->photo) }}@else{{ asset('images/default.jpg') }} @endif"
                                            style="" class="img-fluid" />
                                    </div>
                                </div>
                            </div>

                            <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                style="animation-delay: 1.55s">
                                <label class="mx-2 mb-0 @if (app()->isLocale('ar')) d-block text-end @endif">
                                    @lang('lang.salary_details') </label>
                                <span style="font-size: 16px;font-weight: 500" class="mx-2 mb-0">
                                    @if ($employee->fixed_wage)
                                        <div class="form-group">
                                            <div class="text-right">
                                                <label class="mx-2 mb-0 @if (app()->isLocale('ar')) text-end @endif"
                                                    for="fixed_wage"><strong>@lang('lang.wage')</strong></label>
                                                <br>
                                                <div
                                                    class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                                                    <div
                                                        class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                        <label
                                                            class="mx-2 mb-0 @if (app()->isLocale('ar')) text-end @endif"
                                                            for="">@lang('lang.fixed_wage_value') </label>:
                                                        <span style="font-size: 16px;font-weight: 500" class="mx-2 mb-0">
                                                            {{ !empty($employee->fixed_wage_value) ? @num_format($employee->fixed_wage_value) : null }}
                                                        </span>
                                                    </div>

                                                    <div
                                                        class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                        <label
                                                            class="mx-2 mb-0 @if (app()->isLocale('ar')) text-end @endif"
                                                            for="">@lang('lang.payment_cycle') </label>:
                                                        <span style="font-size: 16px;font-weight: 500" class="mx-2 mb-0">
                                                            {{ $employee->payment_cycle }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </span>
                            </div>
                            <div class="animate__animated animate__bounceInLeft" style="animation-delay: 1.6s">
                                @if ($employee->commission)
                                    <div class="form-group">
                                        <div>
                                            <label for="commission"><strong>@lang('lang.commission_%'): </strong></label>
                                            {{ !empty($employee->commission_value) ? @num_format($employee->commission_value) : null }}
                                        </div>
                                    </div>
                                    <label for="">@lang('lang.comission_type'): </label>
                                    {{ !empty($employee->commission_type) ? ucfirst($employee->commission_type) : null }}
                                    <br>
                                    <label for="">@lang('lang.commission_calculation_period'): </label>
                                    {{ !empty($commission_calculation_period[$employee->commission_calculation_period]) ? $commission_calculation_period[$employee->commission_calculation_period] : null }}
                                    <br>
                                    <label for="">@lang('lang.commission_customer_types'): </label>
                                    {{ !empty($employee->commission_customer_types) ? implode(', ', $employee->commission_customer_type->pluck('name')->toArray()) : null }}
                                    <br>
                                    <label for="">@lang('lang.commission_stores'): </label>
                                    {{ !empty($employee->commission_stores) ? implode(', ', $employee->commission_store->pluck('name')->toArray()) : null }}
                                    <br>
                                    <label for="">@lang('lang.commission_cashiers'): </label>
                                    {{ !empty($employee->commission_cashiers) ? implode(', ', $employee->commission_cashier->pluck('name')->toArray()) : null }}
                                    <br>
                                @endif
                            </div>

                            <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                style="animation-delay: 1.65s">
                                <div class="col-md-12">
                                    <label
                                        class="mx-2 mb-0 width-quarter @if (app()->isLocale('ar')) d-block text-end @endif"
                                        for="working_day_per_week">@lang('lang.working_day_per_week')</label>
                                    <table class="@if (app()->isLocale('ar')) dir-rtl @endif" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>@lang('lang.check_in')</th>
                                                <th> @lang('lang.check_out')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($week_days as $key => $week_day)
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="i-checks">
                                                                <input id="working_day_per_week{{ $key }}"
                                                                    @if (!empty($employee->working_day_per_week[$key])) checked @endif
                                                                    name="working_day_per_week[{{ $key }}]"
                                                                    type="checkbox" value="1" class=""
                                                                    disabled>
                                                                <label
                                                                    for="working_day_per_week{{ $key }}"><strong>{{ $week_day }}</strong></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {!! Form::text('check_in[' . $key . ']', !empty($employee->check_in[$key]) ? $employee->check_in[$key] : null, [
                                                            'class' => 'form-control input-md ',
                                                            'readonly',
                                                        ]) !!}
                                                    </td>
                                                    <td>
                                                        {!! Form::text(
                                                            'check_out[' . $key . ']',
                                                            !empty($employee->check_out[$key]) ? $employee->check_out[$key] : null,
                                                            [
                                                                'class' => 'form-control input-md',
                                                                'readonly',
                                                            ],
                                                        ) !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>




                            <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                                style="animation-delay: 1.7s">
                                <div class="col-md-12 text-center">
                                    <h3>@lang('lang.user_rights')</h3>
                                </div>
                                <div class="col-md-12">
                                    <table class="table @if (app()->isLocale('ar')) dir-rtl @endif"
                                        id="permission_table">
                                        <thead>
                                            <tr>
                                                <th class="">
                                                    @lang('lang.module')
                                                </th>
                                                <th>
                                                    @lang('lang.sub_module')
                                                </th>

                                                <th class="">
                                                    @lang('lang.view')
                                                </th>
                                                <th class="">
                                                    @lang('lang.create_and_edit')
                                                </th>
                                                <th class="">
                                                    @lang('lang.delete')
                                                </th>
                                            </tr>

                                        <tbody>
                                            @foreach ($modulePermissionArray as $key_module => $moudle)
                                                <div>
                                                    <tr class="module_permission" data-moudle="{{ $key_module }}">
                                                        <td class="">{{ $moudle }} </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @if (!empty($subModulePermissionArray[$key_module]))
                                                        @php
                                                            $sub_module_permission_array = $subModulePermissionArray[$key_module];
                                                        @endphp
                                                        @foreach ($sub_module_permission_array as $key_sub_module => $sub_module)
                                                            <tr class="sub_module_permission_{{ $key_module }}">
                                                                <td class=""></td>
                                                                <td>{{ $sub_module }}</td>

                                                                @php
                                                                    $view_permission = $key_module . '.' . $key_sub_module . '.view';
                                                                    $create_and_edit_permission = $key_module . '.' . $key_sub_module . '.create_and_edit';
                                                                    $delete_permission = $key_module . '.' . $key_sub_module . '.delete';
                                                                @endphp
                                                                @if (Spatie\Permission\Models\Permission::where('name', $view_permission)->first())
                                                                    <td class="">
                                                                        {!! Form::checkbox(
                                                                            'permissions[' . $view_permission . ']',
                                                                            1,
                                                                            !empty($user) && !empty($user->hasPermissionTo($view_permission)) ? true : false,
                                                                            ['class' => 'check_box', 'disabled'],
                                                                        ) !!}
                                                                    </td>
                                                                @endif
                                                                @if (Spatie\Permission\Models\Permission::where('name', $create_and_edit_permission)->first())
                                                                    <td class="">
                                                                        {!! Form::checkbox(
                                                                            'permissions[' . $create_and_edit_permission . ']',
                                                                            1,
                                                                            !empty($user) && !empty($user->hasPermissionTo($create_and_edit_permission)) ? true : false,
                                                                            ['class' => 'check_box', 'disabled'],
                                                                        ) !!}
                                                                    </td>
                                                                @endif
                                                                @if (Spatie\Permission\Models\Permission::where('name', $delete_permission)->first())
                                                                    <td class="">
                                                                        {!! Form::checkbox(
                                                                            'permissions[' . $delete_permission . ']',
                                                                            1,
                                                                            !empty($user) && !empty($user->hasPermissionTo($delete_permission)) ? true : false,
                                                                            ['class' => 'check_box', 'disabled'],
                                                                        ) !!}
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endforeach
                                        </tbody>
                                        </thead>
                                    </table>

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
