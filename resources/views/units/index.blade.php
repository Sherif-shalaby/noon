@extends('layouts.app')
@section('title', __('units.units'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('units.units')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('units.units')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
                        <i class="fa fa-plus"></i> {{ __('Add') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('units.create')
@endsection
@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('units.units')</h5>
                    </div>
                    <br/>
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
                                {{-- +++++++++++++++++ checkbox1 : # +++++++++++++++++ --}}
                                <label for="col1_id">
                                    <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                    <span>#</span> &nbsp;
                                </label>
                                {{-- +++++++++++++++++ checkbox2 : unitname +++++++++++++++++ --}}
                                <label for="col2_id">
                                    <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                    <span>@lang('units.unitname')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox3 : added_by +++++++++++++++++ --}}
                                <label for="col3_id">
                                    <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                    <span>@lang('lang.added_by')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox4 : updated_by +++++++++++++++++ --}}
                                <label for="col4_id">
                                    <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                    <span>@lang('lang.updated_by')</span>
                                </label>
                                {{-- +++++++++++++++++ checkbox5 : action +++++++++++++++++ --}}
                                <label for="col5_id">
                                    <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                    <span>@lang('lang.action')</span>
                                </label>
                            </div>
                        </div>
                    </div> <br/>
                    <div class="card-body">
                        @if (@isset($units) && !@empty($units) && count($units) > 0 )
                            <div class="table-responsive">
                                <table  class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="col1">#</th>
                                            <th class="col2">@lang('units.unitname')</th>
                                            <th class="col3">@lang('added_by')</th>
                                            <th class="col4">@lang('updated_by')</th>
                                            <th class="col5">@lang('action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($units as $index=>$unit)
                                            <tr>
                                                <td class="col1">{{ $index+1 }}</td>
                                                <td class="col2">{{ $unit->name }}</td>
                                                <td class="col3">
                                                    @if ($unit->user_id  > 0 and $unit->user_id != null)
                                                        {{ $unit->created_at->diffForHumans() }} <br>
                                                        {{ $unit->created_at->format('Y-m-d') }}
                                                        ({{ $unit->created_at->format('h:i') }})
                                                        {{ ($unit->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                        {{ $unit->createBy?->name }}
                                                    @else
                                                    {{ __('no_update') }}
                                                    @endif
                                                </td>
                                                <td class="col4">
                                                    @if ($unit->last_update  > 0 and $unit->last_update != null)
                                                        {{ $unit->updated_at->diffForHumans() }} <br>
                                                        {{ $unit->updated_at->format('Y-m-d') }}
                                                        ({{ $unit->updated_at->format('h:i') }})
                                                        {{ ($unit->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                        {{ $unit->updateBy?->name }}
                                                    @else
                                                    {{ __('no_update') }}
                                                    @endif
                                                </td>
                                                <td class="col5">
                                                    @include('units.action')
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <tfoot>
                                    <tr>
                                        <th colspan="12">
                                            <div class="float-right">
                                                {!! $units->appends(request()->all())->links() !!}
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </div>
                        @else
                        <div class="alert alert-danger">
                            {{ __('categories.data_no_found') }}
                        </div>
                        @endif
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
