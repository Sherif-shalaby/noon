@extends('layouts.app')
@section('title', __('lang.moneysafes'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.moneysafes')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('/')}}">@lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.moneysafes')</li>
                    </ol>
                </div>
            </div>
            {{-- +++++++++++++++++ اضافة خزينة +++++++++++++++++ --}}
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createMoneySafeModal">
                        @lang('lang.add_moneysafe')
                      </button>
                </div>
            </div>
   </div>
    </div>
     @include('money_safe.create')
@endsection
@section('content')
     <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->
            <div class="contentbar">
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title">@lang('lang.moneysafe')</h5>
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
                                        {{-- +++++++++++++++++ checkbox2 : name +++++++++++++++++ --}}
                                        <label for="col2_id">
                                            <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                            <span>@lang('lang.name')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox3 : type +++++++++++++++++ --}}
                                        <label for="col3_id">
                                            <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                            <span>@lang('lang.type')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox4 : currency +++++++++++++++++ --}}
                                        <label for="col4_id">
                                            <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                            <span>@lang('lang.currency')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox5 : balance +++++++++++++++++ --}}
                                        <label for="col5_id">
                                            <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                            <span>@lang('lang.balance')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox6 : added_by +++++++++++++++++ --}}
                                        <label for="col6_id">
                                            <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                            <span>@lang('lang.added_by')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox7 : updated_by +++++++++++++++++ --}}
                                        <label for="col7_id">
                                            <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                            <span>@lang('lang.updated_by')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox8 : action +++++++++++++++++ --}}
                                        <label for="col8_id">
                                            <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                            <span>@lang('lang.action')</span>
                                        </label>

                                    </div>
                                </div>
                            </div> <br/>
                            <div class="card-body">
                                {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="col1">#</th>
                                            <th class="col2">@lang('lang.name')</th>
                                            <th class="col3">@lang('lang.type')</th>
                                            <th class="col4">@lang('lang.currency')</th>
                                            <th class="col5">@lang('lang.balance')</th>
                                            <th class="col6">@lang('added_by')</th>
                                            <th class="col7">@lang('updated_by')</th>
                                            <th class="col8">@lang('lang.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($moneysafe as $index=>$m_safe)
                                        <tr>
                                            <td class="col1">{{ $index+1 }}</td>
                                            <td class="col2">{{$m_safe->name}}</td>
                                            <td class="col3">@lang('lang.'.$m_safe->type.'')</td>
                                            <td class="col4">{{$m_safe->currency->currency}}</td>
                                            <td class="col5">
                                               {{$m_safe->currency->symbol}} {{@num_format($m_safe->latest_balance)}}
                                            </td>
                                            <td class="col6">
                                                @if ($m_safe->created_by  > 0 and $m_safe->created_by != null)
                                                    {{ $m_safe->created_at->diffForHumans() }} <br>
                                                    {{ $m_safe->created_at->format('Y-m-d') }}
                                                    ({{ $m_safe->created_at->format('h:i') }})
                                                    {{ ($m_safe->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                    {{ $m_safe->createBy?->name }}
                                                @else
                                                {{ __('no_update') }}
                                                @endif
                                            </td>
                                            <td class="col7">
                                                @if ($m_safe->edited_by  > 0 and $m_safe->edited_by != null)
                                                    {{ $m_safe->updated_at->diffForHumans() }} <br>
                                                    {{ $m_safe->updated_at->format('Y-m-d') }}
                                                    ({{ $m_safe->updated_at->format('h:i') }})
                                                    {{ ($m_safe->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                    {{ $m_safe->updateBy?->name }}
                                                @else
                                                   {{ __('no_update') }}
                                                @endif
                                            </td>
                                            <td class="col8">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <li>
                                                            <a data-href="{{route('moneysafe.get-add-money-to-safe', $m_safe->id)}}" data-container=".view_modal" class="btn btn-modal" data-toggle="modal"> <i class="fas fa-plus"></i> @lang('lang.add_to_money_safe')</a>
                                                        </li>
                                                        <li>
                                                            <a data-href="{{route('moneysafe.get-take-money-to-safe', $m_safe->id)}}" data-container=".view_modal" class="btn btn-modal" data-toggle="modal"> <i class="fas fa-minus"></i> @lang('lang.take_money_safe')</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{route('moneysafe.watch-money-to-safe-transaction', $m_safe->id)}}" class="btn" target="_blank" > <i class="fas fa-eye"></i> @lang('lang.watch_statement')</a>
                                                        </li>
                                                        <li>
                                                            <a data-href="{{route('moneysafe.edit', $m_safe->id)}}" data-container=".view_modal" class="btn btn-modal" data-toggle="modal"><i class="dripicons-document-edit"></i> @lang('lang.update')</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{route('moneysafe.destroy', $m_safe->id)}}"
                                                                    {{-- data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}}
                                                                    class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                                    @lang('lang.delete')</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="view_modal no-print" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
            <!-- End Contentbar -->
        </div>
        <!-- End Rightbar -->
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
