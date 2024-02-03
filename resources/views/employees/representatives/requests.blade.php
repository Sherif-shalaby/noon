@extends('layouts.app')
@section('title', __('lang.representatives_requests'))

@push('css')
    <style>
        .table-top-head {
            top: 83px;
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.representatives')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('lang.representatives')</li>
@endsection


@section('content')
    <div class="animate-in-page">

        <div class="container-fluid">
            <div class="col-md-12  no-print">
                <div class="card mt-1">
                    <div
                        class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h6 class="print-title">@lang('lang.employees')</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    @include('employees.representatives.filters')
                                </div>
                            </div>
                        </div>
                        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif" style="margin-top:25px ">
                            <div class="div1"></div>
                        </div>
                        <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div2 table-scroll-wrapper">
                                <!-- content goes here -->
                                <div style="min-width: 1300px;max-height: 90vh;overflow: auto">
                                    <table id="datatable-buttons" class="table dataTable">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.invoice_no')</th>
                                                <th>@lang('lang.employee_name')</th>
                                                <th>@lang('lang.location')</th>
                                                <th>@lang('lang.stores')</th>
                                                <th>@lang('lang.pos')</th>
                                                <th>@lang('lang.customers')</th>
                                                <th>@lang('lang.date')</th>
                                                <th>@lang('lang.amount')</th>
                                                <th>@lang('lang.remaining')</th>
                                                <th>@lang('lang.product')</th>
                                                <th>@lang('lang.quantity')</th>
                                                <th>@lang('lang.unit')</th>
                                                <th>@lang('lang.purchase_price') </th>
                                                <th>@lang('lang.sell_price') </th>
                                                <th class="notexport">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactions as $key => $transaction)
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.invoice_no')">
                                                            {{ $transaction->invoice_no }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.employee_name')">
                                                            {{ !empty($transaction->employee->user) ? $transaction->employee->user->name : '' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.location')">
                                                            {{ App\Models\DeliveryLocation::where('delivery_id', $transaction->employee_id)->latest()->first()->city->name }}
                                                        </span>
                                                        {{-- {{ !empty($transaction->employee->delivery_locations) ? $transaction->employee->delivery_locations : '' }} --}}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.stores')">
                                                            {{ !empty($transaction->store) ? $transaction->store->name : '' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.pos')">
                                                            {{ !empty($transaction->store_pos) ? $transaction->store_pos->name : '' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.customers')">
                                                            {{ !empty($transaction->customer) ? $transaction->customer->name : '' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.date')">
                                                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.amount')">
                                                            {{ @number_format($transaction->final_total) }} <br>
                                                            {{ @number_format($transaction->dollar_final_total) }} $
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.remaining')">
                                                            {{ @number_format($transaction->dinar_remaining) }} <br>
                                                            {{ @number_format($transaction->dollar_remaining) }} $
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.product')">

                                                            @if ($transaction->transaction_sell_lines)
                                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                                    {{ $sellLine->product->name ?? '' }} <br>
                                                                @endforeach
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.quantity')">
                                                            {{ $transaction->quantity ?? 0 }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.unit')">
                                                            @if ($transaction->transaction_sell_lines)
                                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                                    {{ $sellLine->variation->unit->name ?? '' }} <br>
                                                                @endforeach
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.purchase_price')">

                                                            @if ($transaction->transaction_sell_lines)
                                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                                    {{ $sellLine->purchase_price ?? 0 }} ,
                                                                    {{ $sellLine->dollar_purchase_price ?? 0 }} $ <br>
                                                                @endforeach
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.sell_price')">

                                                            @if ($transaction->transaction_sell_lines)
                                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                                    {{ $sellLine->sell_price ?? 0 }},{{ $sellLine->dollar_sell_price ?? 0 }}$
                                                                    <br>
                                                                @endforeach
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" style="font-size: 12px;font-weight: 600">
                                                            @lang('lang.action')
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu">';
                                                            <li>
                                                                <a href="{{ route('employees.show', $transaction->id) }}"
                                                                    class="btn"><i class="fa fa-eye"></i>
                                                                    @lang('lang.view') </a>
                                                            </li>
                                                            <li class="divider"></li>

                                                            {{-- <li>
                                                    <a href="{{ route('employees.edit', $transaction->id) }}"
                                                        target="_blank" class="btn edit_employee"><i
                                                            class="fa fa-pencil-square-o"></i>
                                                        @lang('lang.edit')</a>
                                                </li> --}}
                                                            <li>
                                                                <a data-href="{{ route('representatives.destroy', $transaction->id) }}"
                                                                    class="btn delete_item text-red delete_item"><i
                                                                        class="fa fa-trash"></i>
                                                                    @lang('lang.delete')</a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{ route('representatives.print_representative_invoice', $transaction->id) }}"
                                                                    class="btn text-red print_representative_invoice"><i
                                                                        class="fa fa-print"></i>
                                                                    @lang('lang.print')</a>
                                                            </li>
                                                            @if (empty($transaction->transaction_payments->first()))
                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a href="{{ route('representatives.pay', $transaction->id) }}"
                                                                        class="btn text-red"><i class="fa fa-money"></i>
                                                                        @lang('lang.pay')</a>
                                                                </li>
                                                            @endif
                                                            {{-- @if (!empty($transaction->job_type) && $transaction->job_type->title == 'Representative')
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{ route('employees.add_points') }}"
                                                            class="btn add_point"><i class="fa fa-plus"></i>
                                                            @lang('lang.add_points')
                                                        </a>
                                                    </li>
                                                @endif --}}
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
        </div>
    </div>
    <!-- This will be printed -->
    <section class="invoice print_section print-only" id="receipt_section"> </section>

@endsection
@push('javascripts')
    <script>
        $(document).on('click', '.print_representative_invoice', function() {
            $.ajax({
                method: "get",
                url: $(this).data('href'),
                success: function(response) {
                    console.log(response)
                    if (response !== '') {
                        pos_print(response);
                    }
                }
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
@endpush
