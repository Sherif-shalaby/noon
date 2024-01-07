@extends('layouts.app')
@section('title', __('lang.customers'))
@section('breadcrumbbar')
    {{-- +++++++++++++++ Style : checkboxes and labels inside selectbox +++++++++++++++ --}}
    <style>
        .table-scroll-wrapper {
            width: fit-content;
        }

        @media(min-width:1900px) {
            .table-scroll-wrapper {
                width: 100%;
            }
        }

        .selectBox {
            position: relative;
        }

        /* selectbox style */
        .selectBox select {
            width: 100%;
            padding: 0 !important;
            padding-left: 4px;
            padding-right: 4px;
            color: #fff;
            border: 1px solid #596fd7;
            background-color: #596fd7;
            /* height: 39px !important; */
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

        #checkboxes label span {
            font-weight: normal;
        }

        .wrapper1,
        .wrapper2 {
            overflow-x: scroll;
            overflow-y: hidden;
        }

        .wrapper1 {
            height: 20px;
        }

        .div1 {
            height: 20px;
        }

        .div2 {
            overflow: auto;
            width: fit-content;
        }
    </style>

    <div class="breadcrumbbar m-0 px-3 py-0">
        <div
            class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            <div>
                <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.customers')
                </h4>
                <div class="breadcrumb-list">
                    <ul style=" list-style: none;"
                        class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                @lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                            aria-current="page">@lang('lang.customers')</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div
                    class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                    <a href="{{ route('customers.create') }}" class="btn btn-primary">
                        @lang('lang.add_customers')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h6 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                            @lang('lang.customers')</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{-- @include('customers.filters') --}}
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive @if (app()->isLocale('ar')) dir-rtl @endif"
                            style="overflow: hidden">
                            {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                            <div class="col-md-3 col-lg-3 filter-wrapper">
                                {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                                <div class="multiselect col-md-12">
                                    <div class="selectBox" onclick="showCheckboxes()">
                                        <select class="form-select form-control form-control-lg">
                                            <option>@lang('lang.show_hide_columns')</option>
                                        </select>
                                        <div class="overSelect"></div>
                                    </div>

                                    <div id="checkboxes">
                                        {{-- +++++++++++++++++ checkbox1 : customer_name +++++++++++++++++ --}}
                                        <label for="col1_id">
                                            <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                            <span>@lang('lang.customer_name')</span> &nbsp;
                                        </label>
                                        {{-- +++++++++++++++++ checkbox2 : customer_type +++++++++++++++++ --}}
                                        <label for="col2_id">
                                            <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                            <span>@lang('lang.customer_type')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox3 : email +++++++++++++++++ --}}
                                        <label for="col3_id">
                                            <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                            <span>@lang('lang.email')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox4 : phone +++++++++++++++++ --}}
                                        <label for="col4_id">
                                            <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                            <span>@lang('lang.phone')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox5 : state +++++++++++++++++ --}}
                                        <label for="col5_id">
                                            <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                            <span>@lang('lang.state')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox6 : city +++++++++++++++++ --}}
                                        <label for="col6_id">
                                            <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                            <span>@lang('lang.city')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox7 : min_amount_in_dinar +++++++++++++++++ --}}
                                        <label for="col7_id">
                                            <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                            <span>@lang('lang.min_amount_in_dinar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox8 : max_amount_in_dinar +++++++++++++++++ --}}
                                        <label for="col8_id">
                                            <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                            <span>@lang('lang.max_amount_in_dinar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox9 : min_amount_in_dollar +++++++++++++++++ --}}
                                        <label for="col9_id">
                                            <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                            <span>@lang('lang.min_amount_in_dollar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox10 : max_amount_in_dollar +++++++++++++++++ --}}
                                        <label for="col10_id">
                                            <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                            <span>@lang('lang.max_amount_in_dollar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox11 : balance_in_dinar +++++++++++++++++ --}}
                                        <label for="col11_id">
                                            <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                            <span>@lang('lang.balance_in_dinar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox12 : balance_in_dollar +++++++++++++++++ --}}
                                        <label for="col12_id">
                                            <input type="checkbox" id="col12_id" name="col12" checked="checked" />
                                            <span>@lang('lang.balance_in_dollar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox13 : balance +++++++++++++++++ --}}
                                        <label for="col13_id">
                                            <input type="checkbox" id="col13_id" name="col13" checked="checked" />
                                            <span>@lang('lang.balance')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox14 : purchases +++++++++++++++++ --}}
                                        <label for="col14_id">
                                            <input type="checkbox" id="col14_id" name="col14" checked="checked" />
                                            <span>@lang('lang.purchases')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox15 : discount +++++++++++++++++ --}}
                                        <label for="col15_id">
                                            <input type="checkbox" id="col15_id" name="col15" checked="checked" />
                                            <span>@lang('lang.discount')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox16 : points +++++++++++++++++ --}}
                                        <label for="col16_id">
                                            <input type="checkbox" id="col16_id" name="col16" checked="checked" />
                                            <span>@lang('lang.points')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox17 : updated_by +++++++++++++++++ --}}
                                        <label for="col17_id">
                                            <input type="checkbox" id="col17_id" name="col17" checked="checked" />
                                            <span>@lang('lang.updated_by')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox18 : action +++++++++++++++++ --}}
                                        <label for="col18_id">
                                            <input type="checkbox" id="col18_id" name="col18" checked="checked" />
                                            <span>@lang('lang.action')</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{-- +++++++++++++++++++++++++++ Table +++++++++++++++++++++++++++ --}}
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width: 2100px;max-height: 90vh;overflow: auto">
                                        <table id="datatable-buttons"
                                            class="table table-striped table-hover table-bordered hideShowTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th class="col1">@lang('lang.customer_name')</th>
                                                    <th class="col2">@lang('lang.customer_type')</th>
                                                    <th class="col3">@lang('lang.email')</th>
                                                    <th class="col4">@lang('lang.phone')</th>
                                                    <th class="col5">@lang('lang.state')</th>
                                                    <th class="col6">@lang('lang.city')</th>
                                                    <th class="col7">@lang('lang.min_amount_in_dinar')</th>
                                                    <th class="col8">@lang('lang.max_amount_in_dinar')</th>
                                                    <th class="col9 dollar-cell">@lang('lang.min_amount_in_dollar')</th>
                                                    <th class="col10 dollar-cell">@lang('lang.max_amount_in_dollar')</th>
                                                    <th class="col11">@lang('lang.balance_in_dinar')</th>
                                                    <th class="col12 dollar-cell">@lang('lang.balance_in_dollar')</th>
                                                    <th class="col13">@lang('lang.balance')</th>
                                                    <th class="col14">@lang('lang.purchases')</th>
                                                    <th class="col15">@lang('lang.discount')</th>
                                                    <th class="col16">@lang('lang.points')</th>
                                                    <th class="col17">@lang('updated_by')</th>
                                                    <th class="col18">@lang('lang.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customers as $index => $customer)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td class="col1">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.customer_name')">
                                                                {{ $customer->name }}
                                                            </span>
                                                        </td>
                                                        <td class="col2">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.customer_type')">
                                                                {{ $customer->customer_type->name }}
                                                            </span>
                                                        </td>
                                                        {{-- Convert the email and phone strings to arrays --}}
                                                        @php
                                                            $emailArray = explode(',', $customer->email);
                                                            $phoneArray = explode(',', $customer->phone);
                                                            // Remove square brackets from each element in the emailArray
                                                            foreach ($emailArray as $key => $email) {
                                                                $emailArray[$key] = str_replace(['[', ']', '"'], '', $email);
                                                            }
                                                            // Remove square brackets from each element in the emailArray
                                                            foreach ($phoneArray as $key => $phone) {
                                                                $phoneArray[$key] = str_replace(['[', ']', '"'], '', $phone);
                                                            }
                                                        @endphp
                                                        <td class="col3">
                                                            {{-- Iterate over the email array elements --}}
                                                            @foreach ($emailArray as $email)
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.email')">
                                                                    {{ $email }}<br>
                                                                </span>
                                                            @endforeach
                                                        </td>
                                                        <td class="col4">
                                                            {{-- Iterate over the phone array elements --}}
                                                            @foreach ($phoneArray as $phone)
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.phone')">
                                                                    {{ $phone }}<br>
                                                                </span>
                                                            @endforeach
                                                        </td>

                                                        @php
                                                            $state = \App\Models\State::find($customer->state_id);
                                                            $city = \App\Models\City::find($customer->city_id);
                                                        @endphp
                                                        <td class="col5">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.state')">
                                                                {{ $state ? $state->name : '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col6">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.city')">
                                                                {{ $city ? $city->name : '' }}
                                                            </span>
                                                        </td>
                                                        <td class="col7">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.min_amount_in_dinar')">
                                                                {{ $customer->min_amount_in_dinar }}
                                                            </span>
                                                        </td>
                                                        <td class="col8">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.max_amount_in_dinar')">
                                                                {{ $customer->max_amount_in_dinar }}
                                                            </span>
                                                        </td>
                                                        <td class="col9 dollar-cell">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.min_amount_in_dollar')">
                                                                {{ $customer->min_amount_in_dollar }}
                                                            </span>
                                                        </td>
                                                        <td class="col10 dollar-cell">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.max_amount_in_dollar')">
                                                                {{ $customer->max_amount_in_dollar }}
                                                            </span>
                                                        </td>
                                                        <td class="col11">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.balance_in_dinar')">
                                                                {{ $customer->balance_in_dinar }}
                                                            </span>
                                                        </td>
                                                        <td class="col12 dollar-cell">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.balance_in_dollar')">
                                                                {{ $customer->balance_in_dollar }}
                                                            </span>
                                                        </td>
                                                        <td class="col13">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.balance')">
                                                                {{ $customer->added_balance }}
                                                            </span>
                                                        </td>
                                                        <td class="col14">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.purchases')">
                                                                {{ $customer->added_balance }}
                                                            </span>
                                                        </td>
                                                        <td class="col15">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.discount')">
                                                                {{ $customer->added_balance }}
                                                            </span>
                                                        </td>
                                                        <td class="col16">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('lang.points')">
                                                                @if ($customer->created_by > 0 and $customer->created_by != null)
                                                                    {{ $customer->created_at->diffForHumans() }} <br>
                                                                    {{ $customer->created_at->format('Y-m-d') }}
                                                                    ({{ $customer->created_at->format('h:i') }})
                                                                    {{ $customer->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                    <br>
                                                                    {{ $customer->createBy?->name }}
                                                                @else
                                                                    {{ __('no_update') }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td class="col17">
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('updated_by')">
                                                                @if ($customer->updated_by > 0 and $customer->updated_by != null)
                                                                    {{ $customer->updated_at->diffForHumans() }}
                                                                    ({{ $customer->updated_at->format('h:i') }})
                                                                    {{ $customer->updated_at->format('Y-m-d') }}
                                                                    {{ $customer->updated_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                    <br>
                                                                    {{ $customer->updateBy?->name }}
                                                                @else
                                                                    <span
                                                                        class=" d-flex justify-content-center align-items-center"
                                                                        style="font-size: 12px;font-weight: 600">
                                                                        {{ __('no_update') }}
                                                                    </span>
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td class="col18">
                                                            <div class="btn-group">
                                                                <button type="button"
                                                                    class="btn btn-default btn-sm dropdown-toggle d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">خيارات <span
                                                                        class="caret"></span>
                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                </button>
                                                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                    user="menu" x-placement="bottom-end"
                                                                    style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                    <li>
                                                                        <a href="{{ route('customer_dues', $customer->id) }}"
                                                                            class="btn  drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                            target="_blank"><i
                                                                                class="dripicons-document-edit"></i>
                                                                            @lang('lang.dues')</a>
                                                                    </li>

                                                                    <li>
                                                                        <a href="{{ route('customers.edit', $customer->id) }}"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                            target="_blank"><i
                                                                                class="dripicons-document-edit"></i>
                                                                            @lang('lang.update')</a>
                                                                    </li>

                                                                    <li>
                                                                        <a data-href="{{ route('customers.destroy', $customer->id) }}"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item"><i
                                                                                class="fa fa-trash"></i>
                                                                            @lang('lang.delete')</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
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
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Select both elements by their class names
        var div1 = document.querySelector('.div1');
        var div2 = document.querySelector('.div2');

        // Get the width of the "div2" element
        var div2Width = div2.offsetWidth;

        // Set the width of "div1" to the width of "div2"
        div1.style.width = div2Width + 'px';

        document.addEventListener("DOMContentLoaded", function() {
            var wrapper1 = document.querySelector(".wrapper1");
            var wrapper2 = document.querySelector(".wrapper2");

            wrapper1.addEventListener("scroll", function() {
                wrapper2.scrollLeft = wrapper1.scrollLeft;
            });

            wrapper2.addEventListener("scroll", function() {
                wrapper1.scrollLeft = wrapper2.scrollLeft;
            });
        });
    </script>
    <script>
        // +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++
        $("input:checkbox:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });

        $("input:checkbox").click(function() {
            var column = "table ." + $(this).attr("name");
            $(column).toggle();
        });
        // +++++++++++++++++ Checkboxs and label inside selectbox : showCheckboxes() method ++++++++++++++
        var expanded = false;

        function showCheckboxes() {
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
