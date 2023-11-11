@extends('layouts.app')
@section('title', __('lang.delivery_plans'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.delivery_plans')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        {{--                        <li class="breadcrumb-item active"><a href="#">@lang('lang.employees')</a></li>--}}
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.delivery_plans')</li>
                    </ol>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
                    <h4 class="print-title">@lang('lang.delivery_plans')</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container-fluid">
                                <div class="card-body">
                                    <form action="{{route('delivery_plan.plansList')}}" method="get">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    {!! Form::select(
                                                        'city_id',
                                                        $cities,null,
                                                        ['class' => 'form-control select2','placeholder'=>__('lang.cities')]
                                                    ) !!}
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <select name="delivery_id" class="form-control select2" placeholder="{{ __('lang.delivery') }}">
                                                        <option value="">{{ __('lang.delivery') }}</option>
                                                        @foreach($delivery_men_data as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}</option>
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
                                                    <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                                                        <i class="fa fa-eye"></i> {{ __('Search') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
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

                                @foreach($plans as $key => $plan)
                                    <tr>

                                        <td>
                                            {{$plan->date}}
                                        </td>
                                        <td>
                                            {{$plan->city->name}}
                                        </td>
                                        <td>
{{--                                            @dd($plan->employee)--}}
                                            {{!empty($plan->employee->user) ? $plan->employee->user->name : ''}}
                                        </td>
                                        <td>
                                            @php
                                                $delivery_plan = App\Models\DeliveryCustomerPlan::where('delivery_location_id',$plan->id)->get();
                                                $allPlansSignedAndSubmitted = true;

                                                foreach ($delivery_plan as $plan_customer) {
                                                    if ($plan_customer->signed_at === null || $plan_customer->submitted_at === null) {
                                                        $allPlansSignedAndSubmitted = false;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                                @if($allPlansSignedAndSubmitted)
                                                {{'completed'}}
                                                @else
                                                {{'-'}}
                                                @endif

                                        </td>
                                        <td>
                                             <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                     aria-haspopup="true" aria-expanded="false">
                                                 @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                <li>
                                                    <a href="{{route('delivery.show', $plan->id)}}"
                                                       class="btn"><i
                                                            class="fa fa-pencil-square-o"></i>
                                                         @lang('lang.view_details') </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{route('delivery.edit', $plan->id)}}"
                                                        class="btn text-red "><i class="fa fa-pencil-square-o"></i>
                                                        @lang('lang.edit')</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{route('delivery.destroy', $plan->id)}}"
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


@endsection

