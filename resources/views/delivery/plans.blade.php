@extends('layouts.app')
@section('title', __('lang.show_plans'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.show_plans')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        @if((request()->segment(2).'/'.request()->segment(3)) == "plans/representatives")
                            <li class="breadcrumb-item active"><a href="{{ route('representatives.index') }}">@lang('lang.representatives')</a></li>
                        @else
                            <li class="breadcrumb-item active"><a href="#">@lang('lang.delivery')</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.show_plans')</li>
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
                    <h4 class="print-title">@lang('lang.show_plans')</h4>
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
                                                    <select name="delivery_id" class="form-control select2"
                                                            placeholder="@if((request()->segment(2).'/'.request()->segment(3)) == "plans/representatives") {{ __('lang.representatives') }} @else {{ __('lang.delivery') }}@endif">
                                                        <option value="">@if((request()->segment(2).'/'.request()->segment(3)) == "plans/representatives") {{ __('lang.representatives') }} @else {{ __('lang.delivery') }}@endif</option>
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
                    {{-- +++++++++++++++ Style : checkboxes and labels inside selectbox +++++++++++++++ --}}
                    <style>
                        .selectBox {
                        position: relative;
                        }

                        /* selectbox style */
                        .selectBox select
                        {
                            width: 100%;
                            padding: 0 !important;
                            padding-left: 4px;
                            padding-right: 4px;
                            color: #fff;
                            border: 1px solid #596fd7;
                            background-color: #596fd7;
                            height: 39px !important;
                        }

                        .overSelect {
                        position: absolute;
                        left: 0;
                        right: 0;
                        top: 0;
                        bottom: 0;
                        }

                        #checkboxes {
                        display: none;
                        border: 1px #dadada solid;
                        height: 125px;
                        overflow: auto;
                        padding-top: 10px;
                        /* text-align: end;  */
                        }

                        #checkboxes label {
                        display: block;
                        padding: 5px;

                        }

                        #checkboxes label:hover {
                        background-color: #ddd;
                        }
                        #checkboxes label span
                        {
                            font-weight: normal;
                        }
                    </style>
                    {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                    <div class="col-md-4 col-lg-4">
                        <div class="multiselect col-md-6">
                            <div class="selectBox" onclick="showCheckboxes()">
                                <select class="form-select form-control form-control-lg">
                                    <option>@lang('lang.show_hide_columns')</option>
                                </select>
                                <div class="overSelect"></div>
                            </div>
                            <div id="checkboxes">
                                {{-- +++++++++++++++++ checkbox1 : date +++++++++++++++++ --}}
                                <label for="col1_id">
                                    <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                    <span>@lang('lang.date')</span> &nbsp;
                                </label>
                                {{-- +++++++++++++++++ checkbox2 : city +++++++++++++++++ --}}
                                <label for="col2_id">
                                    <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                    <span>@lang('lang.city')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox3 : delivery +++++++++++++++++ --}}
                                <label for="col3_id">
                                    <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                    <span>@lang('lang.delivery')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox4 : status +++++++++++++++++ --}}
                                <label for="col4_id">
                                    <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                    <span>@lang('lang.status')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox5 : action +++++++++++++++++ --}}
                                <label for="col5_id">
                                    <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                    <span>@lang('lang.action')</span>
                                </label>
                            </div>
                        </div>
                    </div> <br/>
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                                <tr>
                                    <th class="col1">@lang('lang.date')</th>
                                    <th class="col2">@lang('lang.city')</th>
                                    <th class="col3">@lang('lang.delivery')</th>
                                    <th class="col4">@lang('lang.status')</th>
                                    <th class="col5 notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plans as $key => $plan)
                                    <tr>
                                        <td class="col1">
                                            {{$plan->date}}
                                        </td>
                                        <td class="col2">
                                            {{$plan->city->name}}
                                        </td>
                                        <td class="col3">
                                            {{!empty($plan->employee->user) ? $plan->employee->user->name : ''}}
                                        </td>
                                        <td class="col4">
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
                                        <td class="col5">
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
@section('javascript')
    {{-- +++++++++++++++ Show/Hide checkboxes +++++++++++++++ --}}
    <script>
        // +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++
        $("input:checkbox:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });

        $("input:checkbox").click(function(){
            var column = "table ." + $(this).attr("name");
            $(column).toggle();
        });
        // +++++++++++++++++ Checkboxs and label inside selectbox : showCheckboxes() method ++++++++++++++
        var expanded = false;
        function showCheckboxes()
        {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }
    </script>
@endsection

