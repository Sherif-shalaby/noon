@extends('layouts.app')
@section('title', __('lang.suppliers'))

@push('css')
    <style>
        .table-top-head {
            top: 0px;
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.suppliers')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
            style="text-decoration: none;color: #596fd7" href="{{ route('suppliers.create') }}">/
            @lang('lang.add_supplier')</a></li>
    {{-- <li class="breadcrumb-item"><a href="#">Brands</a></li> --}}
    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.suppliers')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            @lang('lang.add_supplier')
        </a>
    </div>
@endsection

@section('content')
    <div class="animate-in-page">
        <!-- Start Contentbar -->
        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h6 class="card-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.suppliers')</h6>
                        </div>
                        <div class="card-body">
                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                            <div class="table-responsive ">

                                {{-- +++++++++++++++++++++++++++ Table +++++++++++++++++++++++++++ --}}
                                <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif"
                                    style="margin-top:40px ">
                                    <div class="div1"></div>
                                </div>
                                <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <div class="div2 table-scroll-wrapper">
                                        <!-- content goes here -->
                                        <div style="min-width: 1300px;max-height: 90vh;overflow: auto">
                                            <table id="example"
                                                class="table table-striped table-bordered table-hover @if (app()->isLocale('ar')) dir-rtl @endif">
                                                <thead>
                                                    <tr>
                                                        <th class="col1">@lang('lang.name')</th>
                                                        <th class="col2">@lang('lang.company_name')</th>
                                                        <th class="col3">@lang('lang.email')</th>
                                                        <th class="col4">@lang('lang.mobile_number')</th>
                                                        <th class="col5">@lang('lang.state')</th>
                                                        <th class="col6">@lang('lang.city')</th>
                                                        <th class="col7">@lang('lang.exchange_rate')</th>
                                                        <th class="col8">@lang('lang.owner_debt_in_dinar')</th>
                                                        <th class="col9 dollar-cell">@lang('lang.owner_debt_in_dollar')</th>
                                                        <th class="col10">@lang('lang.created_by')</th>
                                                        <th class="col11">@lang('lang.updated_by')</th>
                                                        <th class="col12">@lang('lang.action')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($suppliers as $supplier)
                                                        <tr>
                                                            <td class="col1">
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.name')">
                                                                    {{ $supplier->name }}
                                                                </span>
                                                            </td>
                                                            <td class="col2">
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.company_name')">
                                                                    {{ $supplier->company_name }}
                                                                </span>
                                                            </td>
                                                            {{-- Convert the email and phone strings to arrays --}}
                                                            @php
                                                                $emailArray = explode(',', $supplier->email);
                                                                $phoneArray = explode(',', $supplier->mobile_number);
                                                                // Remove square brackets from each element in the emailArray
                                                                foreach ($emailArray as $key => $email) {
                                                                    $emailArray[$key] = str_replace(
                                                                        ['[', ']', '"'],
                                                                        '',
                                                                        $email,
                                                                    );
                                                                }
                                                                // Remove square brackets from each element in the emailArray
                                                                foreach ($phoneArray as $key => $phone) {
                                                                    $phoneArray[$key] = str_replace(
                                                                        ['[', ']', '"'],
                                                                        '',
                                                                        $phone,
                                                                    );
                                                                }
                                                            @endphp
                                                            <td class="col3">
                                                                {{-- Iterate over the email array elements --}}
                                                                @foreach ($emailArray as $email)
                                                                    <span
                                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                        style="font-size: 12px;font-weight: 600"
                                                                        data-tooltip="@lang('lang.email')">
                                                                        {{ $email == 'null' ? '' : $email }}<br>
                                                                    </span>
                                                                @endforeach
                                                            </td>
                                                            <td class="col4">
                                                                {{-- Iterate over the phone array elements --}}
                                                                @foreach ($phoneArray as $phone)
                                                                    <span
                                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                        style="font-size: 12px;font-weight: 600"
                                                                        data-tooltip="@lang('lang.mobile_number')">
                                                                        {{ $phone == 'null' ? '' : $phone }}<br>
                                                                    </span>
                                                                @endforeach
                                                            </td>
                                                            @php
                                                                $state = \App\Models\State::find($supplier->state_id);
                                                                $city = \App\Models\City::find($supplier->city_id);
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
                                                                    data-tooltip="@lang('lang.exchange_rate')">
                                                                    {{ $supplier->exchange_rate }}
                                                                </span>
                                                            </td>
                                                            <td class="col8">
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.owner_debt_in_dinar')">
                                                                    {{ $supplier->owner_debt_in_dinar }}
                                                                </span>
                                                            </td>
                                                            <td class="col9 dollar-cell">
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.owner_debt_in_dollar')">
                                                                    {{ $supplier->owner_debt_in_dollar }}
                                                                </span>
                                                            </td>
                                                            <td class="col10">
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.created_by')">
                                                                    {{ $supplier->created_by_user->name }}
                                                                </span>
                                                            </td>
                                                            <td class="col11">
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('lang.updated_by')">
                                                                    {{ $supplier->updated_by_user->name ?? '' }}
                                                                </span>
                                                            </td>
                                                            <td class="col12">
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
                                                                        {{-- ++++++++++++++++++ Show Supplier ++++++++++++++++++ --}}
                                                                        <li>
                                                                            <a href="{{ route('suppliers.show', $supplier->id) }}"
                                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                                    class="fa fa-eye"></i>
                                                                                @lang('lang.view')</a>
                                                                        </li>

                                                                        {{-- ++++++++++++++++++ Show statement_of_account of Supplier ++++++++++++++++++ --}}
                                                                        <li>
                                                                            <a href="{{ route('suppliers.show', $supplier->id) }}?show=statement_of_account"
                                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                                    class="dripicons-document"></i>
                                                                                @lang('lang.statement_of_account')</a>
                                                                        </li>

                                                                        {{-- ++++++++++++++++++ Edit Supplier ++++++++++++++++++ --}}
                                                                        <li>

                                                                            <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                                                                target="_blank"
                                                                                class="btn edit_supplier drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                                                <i
                                                                                    class="fa fa-pencil-square-o"></i>@lang('lang.edit')</a>
                                                                        </li>

                                                                        <li>
                                                                            <a data-href="{{ route('suppliers.destroy', $supplier->id) }}"
                                                                                {{-- data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}}
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
                                                <tfoot>
                                                    <td colspan="6" style="text-align: right">@lang('lang.total')</td>
                                                    <td id="sum1"></td>
                                                    <td id="sum2"></td>
                                                    <td id="sum3"></td>
                                                    <td colspan="3"></td>
                                                </tfoot>
                                            </table>
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
        </div>
        <!-- End Contentbar -->
    </div>
    <!-- End Rightbar -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: "<'row flex-wrap my-2 justify-content-center table-top-head'<'d-flex justify-content-center col-md-2'l><'d-flex justify-content-center col-md-6 text-center 'B><'d-flex justify-content-center col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'i><'col-sm-4'p>>",
                lengthMenu: [10, 25, 50, 75, 100, 200, 300, 400],
                pageLength: 10,
                buttons: ['copy', 'csv', 'excel', 'pdf',
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ":visible:not(.notexport)"
                        }
                    }
                    // ,'colvis'
                ],
                "fnDrawCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };
                    // Total over all pages
                    total1 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(6)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    total2 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(7)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    total3 = api.rows({
                        'page': 'current'
                    }).nodes().to$().find('td:eq(8)').map(function() {
                        return intVal($(this).text());
                    }).get().reduce(function(a, b) {
                        return a + b;
                    }, 0);
                    // Update status DIV
                    $('#sum1').html('<span>' + total1 + '<span/>');
                    $('#sum2').html('<span>' + total2 + '<span/>');
                    $('#sum3').html('<span>' + total3 + '<span/>');
                }
            });
        });
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
