@extends('layouts.app')
@section('title', __('lang.recent_transactions'))


@section('content')

    <div class="row pt-5">
        <div class="card-body no-print">
            <form action="{{ route('recent_transactions') }}" method="get">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                {!! Form::select('customer_id', $customers, null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang.customer'),
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                {!! Form::select('method', $payment_types, null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang.payment_type'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                {!! Form::select('employee_id', $employees, null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang.cashier_man'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                {!! Form::select('deliveryman_id', $delivery_men, null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang.deliveryman'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-3 pt-4">
                            <div class="form-group">
                                {!! Form::select('created_by', $users, null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang.created_by'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="from">{{ __('site.From') }}</label>
                                {!! Form::date('from', null, ['class' => 'form-control', 'placeholder' => __('lang.from')]) !!}
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="to">{{ __('site.To') }}</label>
                                {!! Form::date('to', null, ['class' => 'form-control', 'placeholder' => __('lang.to')]) !!}
                            </div>
                        </div>
                        <div class="col-2 pt-4">
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-success width-100" title="search">
                                    {{ __('lang.filter') }}</button>
                            </div>
                        </div>
                        {{-- <div class="col-2">
                                <div class="form-group">
                                    <button type="button" name="submit" class="btn btn-danger width-100" title="search" wire:click="clear_filters">
                                         {{ __('lang.clear_filters') }}</button>
                                </div>
                            </div> --}}
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </form>
        </div>
        <div class="table-responsive no-print">
            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>@lang('lang.date_and_time')</th>
                        <th>@lang('lang.reference')</th>
                        <th>@lang('lang.store')</th>
                        <th>@lang('lang.customer')</th>
                        <th>@lang('lang.phone')</th>
                        <th>@lang('lang.sale_status')</th>
                        <th>@lang('lang.payment_status')</th>
                        <th>@lang('lang.payment_type')</th>
                        <th>@lang('lang.ref_number')</th>
                        <th class="currencies">@lang('lang.received_currency')</th>
                        <th class="sum">@lang('lang.grand_total')</th>
                        <th class="sum">@lang('lang.paid')</th>
                        <th class="sum">@lang('lang.due_sale_list')</th>
                        <th>@lang('lang.payment_date')</th>
                        <th>@lang('lang.cashier_man')</th>
                        <th>@lang('lang.products')</th>
                        <th class="notexport">@lang('lang.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    @endphp
                    @foreach ($sell_lines as $index => $line)
                        <tr>
                            <td>
                                {{ $line->transaction_date ?? '' }}
                            </td>
                            <td>
                                {{ $line->invoice_no ?? '' }}
                            </td>
                            <td>
                                {{ $line->store->name ?? '' }}
                            </td>
                            <td>
                                {{ $line->customer->name ?? '' }}
                            </td>
                            <td>
                                {{ $line->customer->phone ?? '' }}
                            </td>
                            <td>
                                <span class="badge badge-success">{{ $line->status ?? '' }}</span>
                            </td>
                            <td>{{ $line->payment_status }}</td>
                            <td>
                                @foreach ($line->transaction_payments as $payment)
                                    {{ __('lang.' . $payment->method) }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($line->transaction_payments as $payment)
                                    {{ $payment->ref_no ?? '' }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($line->transaction_payments as $payment)
                                    {{ $payment->received_currency_relation->symbol ?? '' }}<br>
                                @endforeach
                            </td>
                            <td>
                                {{ number_format($line->final_total, 2) }}
                            </td>
                            <td>
                                {{ $line->transaction_payments->sum('amount') }}
                            </td>
                            <td>
                                {{ $line->final_total - $line->transaction_payments->sum('amount') }}
                            </td>
                            <td>
                                {{ $line->transaction_payments->last()->paid_on ?? '' }}
                            </td>
                            <td>
                                {{ $line->created_by_user->name }}
                            </td>
                            <td>
                                @foreach ($line->transaction_sell_lines as $sell_line)
                                    @if (!empty($sell_line->product))
                                        {{ $sell_line->product->name ?? ' ' }} -
                                        {{ $sell_line->product->sku ?? ' ' }}<br>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    @lang('lang.action')
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                    <li>
                                        <a data-href="{{ route('print_invoice', $line->id) }}" class="btn print-invoice"><i
                                                class="dripicons-print"></i>
                                            {{ __('lang.generate_invoice') }}</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a data-href=" {{ route('pos.show', $line->id) }}" data-container=".view_modal"
                                            class="btn btn-modal"><i class="fa fa-eye"></i>{{ __('lang.view') }}
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{ route('sell.return', $line->id) }}" class="btn"><i
                                                class="fa fa-undo"></i>@lang('lang.return') </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a data-href="{{ route('show_payment', $line->id) }}" data-container=".view_modal"
                                            class="btn btn-modal"><i class="fa fa-money"></i>
                                            {{ __('lang.view_payments') }}
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{ route('invoices.edit', $line->id) }}" class="btn"><i
                                                class="dripicons-document-edit"></i> {{ __('lang.edit') }}</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a data-href=" {{ route('upload_receipt', $line->id) }}"
                                            data-container=".view_modal" data-dismiss="modal" class="btn btn-modal"><i
                                                class="fa fa-plus"></i>{{ __('lang.upload_receipt') }}
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a data-href="{{ route('pos.destroy', $line->id) }}"
                                            class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                            {{ __('lang.delete') }}
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="view_modal no-print"></div>

    </div>
    <section class="invoice print_section print-only col-md-10" id="receipt_section_print"></section>

@endsection
@push('javascripts')
    <script>
        $(document).on("click", ".print-invoice", function() {
            // $(".modal").modal("hide");
            $.ajax({
                method: "get",
                url: $(this).data("href"),
                data: {},
                success: function(result) {
                    if (result.success) {
                        setTimeout(() => {
                            pos_print(result.html_content);
                            // $("#receipt_section_print").html(result.html_content);
                            // window.print(); 
                        }, 3000);
                    }
                },
            });
        });

        function pos_print(receipt) {
            $("#receipt_section_print").html(receipt);
            const sectionToPrint = document.getElementById('receipt_section_print');
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
