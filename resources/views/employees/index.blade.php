@extends('layouts.app')
@section('title', __('lang.employees'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.employees')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        {{--                        <li class="breadcrumb-item active"><a href="#">@lang('lang.employees')</a></li>--}}
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.employees')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a  class="btn btn-primary" href="{{route('employees.create')}}">@lang('lang.add_employee')</a>
                    {{--                    <a style="color: white" href="{{ action('EmployeeController@create') }}" class="btn btn-info"><i--}}
                    {{--                            class="dripicons-plus"></i>--}}
                    {{--                        @lang('lang.add_new_employee')</a>--}}
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
@endsection
@section('content')
    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
                    <h4 class="print-title">@lang('lang.employees')</h4>
                </div><br/>
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
                            {{-- +++++++++++++++++ checkbox1 : profile_photo +++++++++++++++++ --}}
                            <label for="col1_id">
                                <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                <span>@lang('lang.profile_photo')</span> &nbsp;
                            </label>
                            {{-- +++++++++++++++++ checkbox2 : employee_name +++++++++++++++++ --}}
                            <label for="col2_id">
                                <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                <span>@lang('lang.employee_name')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox3 : email +++++++++++++++++ --}}
                            <label for="col3_id">
                                <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                <span>@lang('lang.email')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox4 : phone_number +++++++++++++++++ --}}
                            <label for="col4_id">
                                <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                <span>@lang('lang.phone_number')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox5 : job_title +++++++++++++++++ --}}
                            <label for="col5_id">
                                <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                <span>@lang('lang.job_title')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox6 : wage +++++++++++++++++ --}}
                            <label for="col6_id">
                                <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                <span>@lang('lang.wage')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox7 : age +++++++++++++++++ --}}
                            <label for="col7_id">
                                <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                <span>@lang('lang.age')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox8 : date_of_start_working +++++++++++++++++ --}}
                            <label for="col8_id">
                                <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                <span>@lang('lang.date_of_start_working')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox9 : stores +++++++++++++++++ --}}
                            <label for="col9_id">
                                <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                <span>@lang('lang.stores')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox10 : pos +++++++++++++++++ --}}
                            <label for="col10_id">
                                <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                <span>@lang('lang.pos')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox11 : commission +++++++++++++++++ --}}
                            <label for="col11_id">
                                <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                <span>@lang('lang.commission')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox12 : total_paid +++++++++++++++++ --}}
                            <label for="col12_id">
                                <input type="checkbox" id="col12_id" name="col12" checked="checked" />
                                <span>@lang('lang.total_paid')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox13 : pending +++++++++++++++++ --}}
                            <label for="col13_id">
                                <input type="checkbox" id="col13_id" name="col13" checked="checked" />
                                <span>@lang('lang.pending')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox14 : action +++++++++++++++++ --}}
                            <label for="col14_id">
                                <input type="checkbox" id="col14_id" name="col14" checked="checked" />
                                <span>@lang('lang.action')</span>
                            </label>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                                <tr>
                                    <th class="col1">@lang('lang.profile_photo')</th>
                                    <th class="col2">@lang('lang.employee_name')</th>
                                    <th class="col3">@lang('lang.email')</th>
                                    <th class="col4">@lang('lang.phone_number')</th>
                                    <th class="col5">@lang('lang.job_title')</th>
                                    <th class="col6 sum">@lang('lang.wage')</th>

                                    <th class="col7">@lang('lang.age')</th>
                                    <th class="col8">@lang('lang.date_of_start_working')</th>
                                    <th class="col9">@lang('lang.stores')</th>

                                    <th class="col10">@lang('lang.pos')</th>
                                    <th class="col11">@lang('lang.commission')</th>
                                    <th class="col12">@lang('lang.total_paid')</th>
                                    <th class="col13">@lang('lang.pending')</th>
                                    <th class="col14 notexport">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $key => $employee)
                                    <tr>
                                        <td class="col1" title="@lang('lang.profile_photo')">
                                            @if (!empty($employee->photo))
                                                <img src="{{"/uploads/". $employee->photo}}" alt="photo" width="50" height="50">
                                            @else
                                                <img src="{{"/uploads/". session('logo')}}" alt="photo" width="50" height="50">
                                            @endif
                                        </td>
                                        <td  class="col2" title="@lang('lang.employee_name')">
                                            {{!empty($employee->user) ? $employee->user->name : ''}}
                                        </td>
                                        <td  class="col3" title="@lang('lang.email')">
                                            {{!empty($employee->user) ? $employee->user->email : ''}}
                                        </td>
                                        <td  class="col4" title="@lang('lang.phone_number')">
                                            {{$employee->mobile}}
                                        </td>
                                        <td  class="col5" title="@lang('lang.job_title')">
                                            {{!empty($employee->job_type) ? $employee->job_type->title : '' }}
                                        </td>
                                        <td  class="col6" title="@lang('lang.wage')">
                                            {{$employee->fixed_wage_value}}
                                        </td>
                                        <td  class="col7" title="@lang('lang.age')">
                                            {{\Carbon\Carbon::parse($employee->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y')}}
                                        </td>
                                        <td  class="col8" title="@lang('lang.date_of_start_working')">
                                            {{$employee->date_of_start_working}}
                                        </td>
                                        <td  class="col9" title="@lang('lang.stores')">
                                            @foreach($employee->stores()->get() as $store)
                                                {{$store->name}}
                                            @endforeach
                                        </td>
                                        <td class="col10"></td>
                                        <td class="col11"></td>
                                        <td class="col12"></td>
                                        <td class="col13"></td>
                                        <td class="col14" title="@lang('lang.action')">
                                             <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                     aria-haspopup="true" aria-expanded="false">
                                                 @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">';
                                                <li>
                                                    <a href="{{route('employees.show', $employee->id)}}"
                                                       class="btn"><i
                                                            class="fa fa-eye"></i>
                                                         @lang('lang.view') </a>
                                                </li>
                                                <li class="divider"></li>

                                                <li>
                                                    <a href="{{route('employees.edit', $employee->id)}}"  target="_blank"
                                                       class="btn edit_employee"><i
                                                            class="fa fa-pencil-square-o"></i>
                                                        @lang('lang.edit')</a>
                                                </li>
                                               <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{route('employees.destroy', $employee->id)}}"
                                                        class="btn delete_item text-red delete_item"><i
                                                            class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>
                                                @if(!empty($employee->job_type) && $employee->job_type->title == 'Representative')
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{route('employees.add_points')}}"
                                                           class="btn add_point"><i
                                                                class="fa fa-plus"></i>
                                                            @lang('lang.add_points')
                                                        </a>
                                                    </li>
                                                @endif
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
@push('javascripts')
    <script>
        window.addEventListener('openAddPaymentModal', event => {
            $("#addPayment").modal('show');
        })

        window.addEventListener('closeAddPaymentModal', event => {
            $("#addPayment").modal('hide');
        })

        $(document).ready(function() {
            $('select').on('change', function(e) {
                var name = $(this).data('name');
                var index = $(this).data('index');
                var select2 = $(this); // Save a reference to $(this)
                Livewire.emit('listenerReferenceHere',{
                    var1 :name,
                    var2 :select2.select2("val") ,
                    var3:index
                });

            });
        });
    </script>
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
@endpush
