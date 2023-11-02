@extends('layouts.app')
@section('title', __('lang.employee'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between mb-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.employees')</h4>
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
                                aria-current="page">@lang('lang.employee')
                                {{ $employee->employee_name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="widgetbar">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <style>
        label {
            font-weight: bold
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div
                        class="card-header d-flex align-items-center  @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h4>@lang('lang.employee') </h4>
                        {{--                        <a href="{{action('EmployeeController@sendLoginDetails', $employee->id)}}" --}}
                        {{--                            class="btn btn-primary btn-xs" style="margin-left: 10px;"><i class="fa fa-paper-plane"></i> @lang('lang.send_credentials')</a> --}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="fname">@lang('lang.employee_name'): </label>
                                        {{ $employee->employee_name ?? '' }}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="store_id">@lang('lang.store'): </label>
                                        @if (!empty($employee->store))
                                            {{ implode(',', $employee->store->pluck('name')->toArray()) }}
                                        @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="email">@lang('lang.email'): </label> {{ $employee->email }}
                                    </div>


                                    <div class="col-sm-6">
                                        <label for="date_of_start_working">@lang('lang.date_of_start_working'): </label>
                                        @if (!empty($employee->date_of_start_working))
                                            {{ @format_date($employee->date_of_start_working) }}
                                        @endif

                                    </div>
                                    <div class="col-sm-6">
                                        <label for="date_of_birth">@lang('lang.date_of_birth'): </label>
                                        @if (!empty($employee->date_of_birth))
                                            {{ @format_date($employee->date_of_birth) }}
                                        @endif
                                    </div>


                                    <div class="col-sm-6">
                                        <label for="job_type">@lang('lang.job_type'): </label>
                                        @if (!empty($employee->job_type_id))
                                            {{ $employee->job_type->title }}
                                        @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="mobile">@lang('lang.phone_number'): </label> {{ $employee->mobile }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="thumbnail">
                                    <img src="@if (!empty($employee->photo)) {{ asset('uploads/' . $employee->photo) }}@else{{ asset('images/default.jpg') }} @endif"
                                        style="" class="img-fluid" />
                                </div>
                            </div>
                        </div>

                        {{--                        <div class="row"> --}}
                        {{--                            @foreach ($number_of_leaves as $number_of_leave) --}}
                        {{--                                <div class="col-sm-6"> --}}
                        {{--                                    <div class="i-checks"> --}}
                        {{--                                        <label --}}
                        {{--                                            for="number_of_leaves{{$number_of_leave->id}}"><strong>{{$number_of_leave->name ?? ''}}</strong></label> --}}
                        {{--                                        {{$number_of_leave->number_of_days}} --}}
                        {{--                                    </div> --}}
                        {{--                                </div> --}}
                        {{--                            @endforeach --}}
                        {{--                        </div> --}}


                        <div class="row">
                            <div class="col-md-5">
                                <label for="mobile"> @lang('lang.salary_details'): </label>
                                @if ($employee->fixed_wage)
                                    <div class="form-group">
                                        <div class="" style="margin-top: 20px">
                                            <label for="fixed_wage"><strong>@lang('lang.wage')</strong></label> <br>
                                            <label for="">@lang('lang.fixed_wage_value') :</label>
                                            {{ !empty($employee->fixed_wage_value) ? @num_format($employee->fixed_wage_value) : null }}
                                            <br>
                                            <label for="">@lang('lang.payment_cycle') :</label>
                                            {{ $employee->payment_cycle }}
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="col-md-5">
                                @if ($employee->commission)
                                    <div class="form-group">
                                        <div class="" style="margin-top: 20px">
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
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label for="working_day_per_week">@lang('lang.working_day_per_week')</label>
                                <table>
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
                                                                type="checkbox" value="1" class="" disabled>
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
                                                            'class' => 'form-control input-md
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ',
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


                        <br>
                        <br>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h3>@lang('lang.user_rights')</h3>
                            </div>
                            <div class="col-md-12">
                                <table class="table" id="permission_table">
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


@endsection

@section('javascript')
    <script></script>
@endsection
