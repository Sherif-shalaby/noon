@extends('layouts.app')
@section('title', __('lang.representatives_requests'))
@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.representatives')</h4>
                    <div class="breadcrumb-list">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            {{--                        <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"><a href="#">@lang('lang.employees')</a></li> --}}
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                                aria-current="page">@lang('lang.representatives')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    {{-- <div class="widgetbar"> --}}
                    {{-- <a class="btn btn-primary" href="{{ route('employees.create') }}">@lang('lang.add_employee')</a> --}}
                    {{--                    <a style="color: white" href="{{ action('EmployeeController@create') }}" class="btn btn-info"><i --}}
                    {{--                            class="dripicons-plus"></i> --}}
                    {{--                        @lang('lang.add_new_employee')</a> --}}
                    {{-- </div> --}}
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
                    <h4 class="print-title">@lang('lang.employees')</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container-fluid">
                                @include('employees.representatives.filters')
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
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
                                        <td>{{ $transaction->invoice_no }}</td>
                                        <td>
                                            {{ !empty($transaction->employee->user) ? $transaction->employee->user->name : '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\DeliveryLocation::where('delivery_id', $transaction->employee_id)->latest()->first()->city->name }}
                                            {{-- {{ !empty($transaction->employee->delivery_locations) ? $transaction->employee->delivery_locations : '' }} --}}
                                        </td>
                                        <td>
                                            {{ !empty($transaction->store) ? $transaction->store->name : '' }}
                                        </td>
                                        <td>
                                            {{ !empty($transaction->store_pos) ? $transaction->store_pos->name : '' }}
                                        </td>
                                        <td>
                                            {{ !empty($transaction->customer) ? $transaction->customer->name : '' }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d') }}
                                        </td>
                                        <td>{{ @number_format($transaction->final_total) }} <br>
                                            {{ @number_format($transaction->dollar_final_total) }} $</td>
                                        <td>{{ @number_format($transaction->dinar_remaining) }} <br>
                                            {{ @number_format($transaction->dollar_remaining) }} $</td>
                                        <td>
                                            @if ($transaction->transaction_sell_lines)
                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                    {{ $sellLine->product->name ?? '' }} <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $transaction->quantity ?? 0 }}</td>
                                        <td>
                                            @if ($transaction->transaction_sell_lines)
                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                    {{ $sellLine->variation->unit->name ?? '' }} <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if ($transaction->transaction_sell_lines)
                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                    {{ $sellLine->purchase_price ?? 0 }} ,
                                                    {{ $sellLine->dollar_purchase_price ?? 0 }} $ <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if ($transaction->transaction_sell_lines)
                                                @foreach ($transaction->transaction_sell_lines as $sellLine)
                                                    {{ $sellLine->sell_price ?? 0 }},{{ $sellLine->dollar_sell_price ?? 0 }}$
                                                    <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
