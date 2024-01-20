@extends('layouts.app')
@section('title', __('lang.customer_report'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.customer_report')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.reports')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.customer_report')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <!-- Start Contentbar -->
    <div class="contentbar no-print">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.customer_report')</h5>
                    </div>
                    <div class="card-body">
                        @include('reports.customers-report.filters')
                        {{-- ================================ Tabs Header ================================ --}}
                        {{-- <div> --}}
                        <ul class="nav nav-pills">
                            {{-- ####### Tab 1 ####### --}}
                            <li class="nav-item">
                                <a class="nav-link active pt-2 pb-2" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                    role="tab" aria-controls="nav-home" aria-selected="true">
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
                        <br /><br />
                        {{-- ================================ Tabs Body ================================ --}}
                        <div class="tab-content" id="nav-tabContent">
                            {{-- +++++++++++++++++++++ Table 1 +++++++++++++++++++++ --}}
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
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
                                                <td>{{ $customer_transactions_sell_line->created_at->format('Y-m-d') }}</td>
                                                <td>{{ $customer_transactions_sell_line->invoice_no ?? '' }}</td>
                                                <td>{{ $customer_transactions_sell_line->customer->name ?? '' }}</td>
                                                {{-- Get All_sell_lines of transaction Then Get "product name" --}}
                                                <td>
                                                    <ul>
                                                        @foreach ($customer_transactions_sell_line->transaction_sell_lines as $transaction_sell_lines)
                                                            <li>{{ $transaction_sell_lines->product->name ?? '' }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{ number_format($customer_transactions_sell_line->final_total, num_of_digital_numbers()) }}
                                                </td>
                                                {{-- Get All_Payments of transaction Then Get "payment amount" --}}
                                                <td>{{ number_format($customer_transactions_sell_line->transaction_payments->sum('amount'), num_of_digital_numbers()) }}
                                                </td>
                                                {{-- متاخرات --}}
                                                <td>
                                                    {{ @num_format($customer_transactions_sell_line->transaction_payments->sum('amount') - $customer_transactions_sell_line->final_total) ?? '' }}
                                                </td>
                                                {{-- sells status --}}
                                                <td>{{ $customer_transactions_sell_line->status ?? '' }}</td>
                                                {{-- payment status --}}
                                                <td>{{ $customer_transactions_sell_line->payment_status }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
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
                                                                    data-container=".view_modal" class="btn btn-modal">
                                                                    <i class="fa fa-money"></i>
                                                                    @lang('lang.view_payments')
                                                                </a>
                                                            </li>
                                                            @if (
                                                                $customer_transactions_sell_line->status != 'draft' &&
                                                                    $customer_transactions_sell_line->payment_status != 'paid' &&
                                                                    $customer_transactions_sell_line->status != 'canceled')
                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a data-href="{{ route('add_payment', $customer_transactions_sell_line->id) }}"
                                                                        data-container=".view_modal" class="btn btn-modal">
                                                                        <i class="fa fa-plus"></i>
                                                                        @lang('lang.add_payments')
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{ route('pos.show', $customer_transactions_sell_line->id) }}"
                                                                    data-container=".view_modal" class="btn btn-modal">
                                                                    <i class="fa fa-eye"></i>
                                                                    @lang('lang.view')
                                                                </a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{ route('print_invoice', $customer_transactions_sell_line->id) }}"
                                                                    class="btn print-invoice"><i class="fa fa-print"></i>
                                                                    @lang('lang.print_invoice')
                                                                </a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a href="{{ route('sell.return', $customer_transactions_sell_line->id) }}"
                                                                    class="btn" target="_blank">
                                                                    <i class="fa fa-undo"></i>
                                                                    @lang('lang.sale_return')
                                                                </a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{ route('customers-report.destroy', $customer_transactions_sell_line->id) }}"
                                                                    class="btn text-red delete_item">
                                                                    <i class="fa fa-trash"></i>
                                                                    @lang('lang.delete')
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- +++++++++++++++++++++ Table 2 +++++++++++++++++++++ --}}
                            <div class="tab-pane fade"id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <table  id="datatable-buttons" class="table table-striped table-bordered">
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
                                                <td>{{ $transaction_payment->created_at->format('Y-m-d') }}</td>
                                                <td>{{ $transaction_payment->customer->name }}</td>
                                                <td>{{ $transaction_payment->invoice_no }}</td>
                                                <td>{{ $transaction_payment->method }}</td>
                                                {{-- Get All_Payments of transaction Then Get sum of "payment amounts" --}}
                                                <td>{{ number_format($transaction_payment->transaction_payments->sum('amount'), num_of_digital_numbers()) }}
                                                </td>
                                                {{-- Created_by --}}
                                                <td>{{ !empty($transaction_payment->transaction_payments->first()) ? $transaction_payment->transaction_payments->first()->created_by_user->name ?? '' : '' }}
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
