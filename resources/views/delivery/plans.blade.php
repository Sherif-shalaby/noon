@extends('layouts.app')
@section('title', __('lang.show_plans'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        {{ __('lang.show_plans') }}</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            @if (request()->segment(2) . '/' . request()->segment(3) == 'plans/representatives')
                                <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active">
                                    <a style="text-decoration: none;color: #596fd7"
                                        href="{{ route('representatives.index') }}">@lang('lang.representatives')</a>
                                </li>
                            @else
                                <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active">
                                    <a style="text-decoration: none;color: #596fd7" href="#">@lang('lang.delivery')</a>
                                </li>
                            @endif
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.show_plans')</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">
        <div class="container-fluid">
            <div class="col-md-12  no-print">
                <div class="card mt-3">
                    <div
                        class="card-header d-flex align-items-center  @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h4 class="print-title">{{ __('lang.show_plans') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    <div class="card-body">
                                        <form action="{{ route('delivery_plan.plansList') }}" method="get">
                                            <div
                                                class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        {!! Form::select('city_id', $cities, null, [
                                                            'class' => 'form-control select2',
                                                            'placeholder' => __('lang.cities'),
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <select name="delivery_id" class="form-control select2"
                                                            placeholder="@if (request()->segment(2) . '/' . request()->segment(3) == 'plans/representatives') {{ __('lang.representatives') }} @else {{ __('lang.delivery') }} @endif">
                                                            <option value="">
                                                                @if (request()->segment(2) . '/' . request()->segment(3) == 'plans/representatives')
                                                                    {{ __('lang.representatives') }}
                                                                @else
                                                                    {{ __('lang.delivery') }}
                                                                @endif
                                                            </option>
                                                            @foreach ($delivery_men_data as $id => $name)
                                                                <option value="{{ $id }}">{{ $name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        {{-- <label for="date">@lang('lang.date')</label> --}}
                                                        <input type="date" class="form-control" name="date"
                                                            id="date" placeholder="@lang('lang.date')">
                                                    </div>
                                                </div>

                                                {{-- <div class="col-2"></div> --}}
                                                <div class="col-1">
                                                    <div class="form-group">
                                                        <button type="submit" name="submit"
                                                            class="btn btn-primary width-100" title="search">
                                                            <i class="fa fa-eye"></i> {{ __('Search') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif">
                            <table id="datatable-buttons" class="table dataTable">
                                <thead>
                                    <tr>
                                        <th>@lang('lang.date')</th>
                                        <th>@lang('lang.city')</th>
                                        {{-- @can('') --}}
                                        <th>@lang('lang.delivery')</th>
                                        <th>@lang('lang.status')</th>
                                        {{-- @endcan --}}
                                        <th class="notexport">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($plans as $key => $plan)
                                        <tr>

                                            <td>
                                                {{ $plan->date }}
                                            </td>
                                            <td>
                                                {{ $plan->city->name }}
                                            </td>
                                            <td>
                                                {{--                                            @dd($plan->employee) --}}
                                                {{ !empty($plan->employee->user) ? $plan->employee->user->name : '' }}
                                            </td>
                                            <td>
                                                @php
                                                    $delivery_plan = App\Models\DeliveryCustomerPlan::where('delivery_location_id', $plan->id)->get();
                                                    $allPlansSignedAndSubmitted = true;

                                                    foreach ($delivery_plan as $plan_customer) {
                                                        if ($plan_customer->signed_at === null || $plan_customer->submitted_at === null) {
                                                            $allPlansSignedAndSubmitted = false;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                @if ($allPlansSignedAndSubmitted)
                                                    {{ 'completed' }}
                                                @else
                                                    {{ '-' }}
                                                @endif

                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    @lang('lang.action')
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                    user="menu">
                                                    <li>
                                                        <a href="{{ route('delivery.show', $plan->id) }}" class="btn"><i
                                                                class="fa fa-pencil-square-o"></i>
                                                            @lang('lang.view_details') </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{ route('delivery.edit', $plan->id) }}"
                                                            class="btn text-red "><i class="fa fa-pencil-square-o"></i>
                                                            @lang('lang.edit')</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a data-href="{{ route('delivery.destroy', $plan->id) }}"
                                                            class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                            @lang('lang.delete')</a>
                                                    </li>


                                                </ul>
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


@endsection
