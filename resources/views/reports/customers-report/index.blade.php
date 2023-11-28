@extends('layouts.app')
@section('title', __('lang.customer_report'))
@section('breadcrumbbar')
    <style>
        .table-top-head {
            margin-top: 60px !important;
        }
    </style>
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.customer_report')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">/ @lang('lang.reports')</li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.customer_report')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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
                            <h5 class="card-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                                @lang('lang.customer_report')</h5>
                        </div>
                        <div class="card-body">
                            @include('reports.customers-report.filters')
                            {{-- ================================ Tabs Header ================================ --}}
                            {{-- <div> --}}
                            <ul class="nav nav-pills" style="margin-top: 35px">
                                {{-- ####### Tab 1 ####### --}}
                                <li class="nav-item">
                                    <a class="nav-link active pt-2 pb-2" id="nav-home-tab" data-toggle="tab"
                                        href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                        المبيعات
                                    </a>
                                </li>
                                {{-- ####### Tab 2 ####### --}}
                                <li class="nav-item">
                                    <a class="nav-link pt-2 pb-2" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                        role="tab" aria-controls="nav-profile" aria-selected="false">
                                        المدفوعات
                                    </a>
                                </li>
                            </ul>
                            {{-- </div> --}}

                            {{-- ================================ Tabs Body ================================ --}}
                            <div class="tab-content" id="nav-tabContent">
                                {{-- +++++++++++++++++++++ Table 1 +++++++++++++++++++++ --}}
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <table id="datatable-buttons"
                                        class="table table-striped  table-button-wrapper table-hover  table-bordered">
                                        <thead>
                                            <tr>
                                                <th>التاريخ</th>
                                                <th>رقم المرجع</th>
                                                <th>عميل</th>
                                                <th>منتج</th>
                                                <th>المبلغ الاجمالي</th>
                                                <th>دفٌعت</th>
                                                <th>متأخرات</th>
                                                <th>حالة المبيعات</th>
                                                <th>حالة السداد</th>
                                                <th>@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer_transactions_sell_lines as $key => $customer_transactions_sell_line)
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600" data-tooltip="التاريخ">
                                                            {{ $customer_transactions_sell_line->created_at->format('Y-m-d') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="رقم المرجع">
                                                            {{ $customer_transactions_sell_line->invoice_no ?? '' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600" data-tooltip="عميل">
                                                            {{ $customer_transactions_sell_line->customer->name ?? '' }}
                                                        </span>
                                                    </td>
                                                    {{-- Get All_sell_lines of transaction Then Get "product name" --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600" data-tooltip="منتج">

                                                            <ul>
                                                                @foreach ($customer_transactions_sell_line->transaction_sell_lines as $transaction_sell_lines)
                                                                    <li>{{ $transaction_sell_lines->product->name ?? '' }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="المبلغ الاجمالي">

                                                            {{ number_format($customer_transactions_sell_line->final_total, 2) }}
                                                        </span>
                                                    </td>
                                                    {{-- Get All_Payments of transaction Then Get "payment amount" --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600" data-tooltip="دفٌعت">
                                                            {{ number_format($customer_transactions_sell_line->transaction_payments->sum('amount'), 2) }}
                                                        </span>
                                                    </td>
                                                    {{-- متاخرات --}}
                                                    {{--                                                <td> --}}
                                                    {{--                                                    {{ number_format($customer_transactions_sell_line->transaction_payments->sum('amount') - $customer_transactions_sell_line->final_total, 2) }} --}}
                                                    {{--                                                        @foreach ($customer_transactions_sell_line->transaction_sell_lines as $transaction_sell_lines) --}}
                                                    {{--                                                                <li>{{ $transaction_sell_lines->product->name ?? ''}}</li> --}}
                                                    {{--                                                        @endforeach --}}
                                                    {{--                                                    </ul> --}}
                                                    {{--                                                </td> --}}
                                                    {{--                                                <td>{{ @num_format($customer_transactions_sell_line->final_total ) ?? ''}}</td> --}}
                                                    {{-- Get All_Payments of transaction Then Get "payment amount" --}}
                                                    {{--                                                <td>{{ @num_format( $customer_transactions_sell_line->transaction_payments->sum('amount')) ?? ''}}</td> --}}
                                                    {{-- متاخرات --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600" data-tooltip="متأخرات">
                                                            {{ @num_format($customer_transactions_sell_line->transaction_payments->sum('amount') - $customer_transactions_sell_line->final_total) ?? '' }}
                                                        </span>
                                                    </td>
                                                    {{-- sells status --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="حالة المبيعات">

                                                            {{ $customer_transactions_sell_line->status ?? '' }}
                                                        </span>
                                                    </td>
                                                    {{-- payment status --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="حالة السداد">

                                                            {{ $customer_transactions_sell_line->payment_status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" style="font-size: 12px;font-weight: 600"
                                                                class="btn btn-default btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">خيارات <span class="caret"></span>
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                                user="menu" x-placement="bottom-end"
                                                                style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                <li>
                                                                    <a data-href="{{ route('show_payment', $customer_transactions_sell_line->id) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal">
                                                                        <i class="fa fa-money"></i>
                                                                        @lang('lang.view_payments')
                                                                    </a>
                                                                </li>
                                                                @if (
                                                                    $customer_transactions_sell_line->status != 'draft' &&
                                                                        $customer_transactions_sell_line->payment_status != 'paid' &&
                                                                        $customer_transactions_sell_line->status != 'canceled')
                                                                    <li>
                                                                        <a data-href="{{ route('add_payment', $customer_transactions_sell_line->id) }}"
                                                                            data-container=".view_modal"
                                                                            class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal">
                                                                            <i class="fa fa-plus"></i>
                                                                            @lang('lang.add_payments')
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                <li>
                                                                    <a data-href="{{ route('pos.show', $customer_transactions_sell_line->id) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal">
                                                                        <i class="fa fa-eye"></i>
                                                                        @lang('lang.view')
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a data-href="{{ route('print_invoice', $customer_transactions_sell_line->id) }}"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif print-invoice"><i
                                                                            class="fa fa-print"></i>
                                                                        @lang('lang.print_invoice')
                                                                    </a>
                                                                </li>
                                                                {{--
                                                            <li>
                                                                <a target="_blank" href="{{route('get_remove_damage',$product->id)}}"
                                                                   class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i class="fa fa-filter"></i>
                                                                     @lang('lang.remove_damage')
                                                                </a>
                                                            </li> --}}
                                                                {{--
                                                            <li>
                                                                <a target="_blank" href="{{url('add-stock/create?product_id='.$product->id)}}"
                                                                   class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i class="fa fa-plus"></i>
                                                                     @lang('lang.add_new_stock')
                                                                </a>
                                                            </li> --}}

                                                                <li>
                                                                    <a href="{{ route('sell.return', $customer_transactions_sell_line->id) }}"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                                                        target="_blank">
                                                                        <i class="fa fa-undo"></i>
                                                                        @lang('lang.sale_return')
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a data-href="{{ route('customers-report.destroy', $customer_transactions_sell_line->id) }}"
                                                                        class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item">
                                                                        <i class="fa fa-trash"></i>
                                                                        @lang('lang.delete')
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    {{--                                                <td>{{ $customer_transactions_sell_line->payment_status ?? ''}}</td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- +++++++++++++++++++++ Table 2 +++++++++++++++++++++ --}}
                                <div class="tab-pane fade"id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <table id="datatable-buttons"
                                        class="table table-button-wrapper table-hover  table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>التاريخ</th>
                                                <th>اسم العميل</th>
                                                <th>مرجع البيع</th>
                                                <th>مدفوعة</th>
                                                <th>المبلغ</th>
                                                <th>انشئ بواسطة</th>
                                                {{-- <th>@lang('lang.action')</th>  --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer_transactions_sell_lines as $key => $transaction_payment)
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="التاريخ">

                                                            {{ $transaction_payment->created_at->format('Y-m-d') }}
                                                    </td>
                                                    </span>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="اسم العميل">

                                                            {{ $transaction_payment->customer->name }}
                                                    </td>
                                                    </span>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="مرجع البيع">

                                                            {{ $transaction_payment->invoice_no }}
                                                    </td>
                                                    </span>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="مدفوعة">

                                                            {{ $transaction_payment->method }}
                                                    </td>
                                                    </span>
                                                    {{-- Get All_Payments of transaction Then Get sum of "payment amounts" --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="المبلغ">

                                                            {{ number_format($transaction_payment->transaction_payments->sum('amount'), 2) }}
                                                        </span>
                                                    </td>
                                                    {{-- Created_by --}}
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="انشئ بواسطة">

                                                            {{ !empty($transaction_payment->transaction_payments->first()) ? $transaction_payment->transaction_payments->first()->created_by_user->name ?? '' : '' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                            {{-- {{-- <div class="table-responsive"> --}}

                            <div class="view_modal no-print">

                            </div>
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
    </div>
    <section class="invoice print_section print-only" id="receipt_section"> </section>

    <!-- End Contentbar -->
@endsection
@section('javascript')
    <script>
        $(document).on('click', '.print-invoice', function() {
            $.ajax({
                method: 'get',
                url: $(this).data('href'),
                data: {},
                success: function(result) {
                    if (result.success) {
                        pos_print(result.html_content);
                    }
                },
            });
        });

        function pos_print(receipt) {
            $("#receipt_section").html(receipt);
            const sectionToPrint = document.getElementById('receipt_section');
            __print_receipt(sectionToPrint);
        }

        function __print_receipt(section = null) {
            setTimeout(function() {
                section.style.display = 'block';
                window.print();
                section.style.display = 'none';

            }, 1000);
        }
    </script>
@endsection
