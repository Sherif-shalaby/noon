@extends('layouts.app')
@section('title', __('lang.stock'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.stock')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('stocks.create')}}">@lang('lang.add-stock')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.stock')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a type="button" class="btn btn-primary" href="{{route('stocks.create')}}">@lang('lang.add-stock')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    {{--@livewire('add-stock.add-payment')--}}
    <section class="">
        <div class="col-md-22">
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
                    <h3 class="print-title">@lang('lang.stock')</h3>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-fluid">
                            @include('reports.add_stock.filters')
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                            <tr>
                                <th>@lang('lang.po_ref_no')</th>
                                <th>@lang('lang.invoice_no')</th>
                                <th>@lang('lang.date_and_time')</th>
                                <th>@lang('lang.invoice_date')</th>
                                <th>@lang('lang.supplier')</th>
                                <th>@lang('lang.products')</th>
                                <th>@lang('lang.purchase_type')</th>
                                <th>@lang('lang.created_by')</th>
                                <th>@lang('lang.payment_status')</th>
                                <th class="sum">@lang('lang.value')</th>
                                <th class="sum">@lang('lang.paid_amount')</th>
                                <th class="sum">@lang('lang.pending_amount')</th>
                                <th>@lang('lang.payment_date')</th>
                                <th>@lang('lang.notes')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stocks as $index => $stock)
                                <tr>
                                    <td>{{$stock->po_no ?? ''}}</td>
                                    <td>{{$stock->invoice_no ?? ''}}</td>
                                    <td>{{$stock->created_at }}</td>
                                    <td>{{$stock->transaction_date }}</td>
                                    <td>{{$stock->supplier->name??''}}</td>
                                    <td>
                                        @if(!empty($stock->add_stock_lines))
                                            @foreach($stock->add_stock_lines as $stock_line)
                                                {{ $stock_line->product->name ?? '' }}<br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        {{ $stock->purchase_type }}
                                    </td>

                                    <td>{{$stock->created_by_relationship->first()->name}}</td>
                                    <td>
                                        @lang('lang.'. $stock->payment_status)
                                    </td>
                                    @if($stock->transaction_currency == 2)
                                        <td>{{@num_format($stock->dollar_final_total)}}</td>
                                    @else
                                        <td>{{@num_format($stock->final_total)}}</td>
                                    @endif
                                    @php
                                        $final_total = 0;
                                        $paid = 0;
                                        $payments = $stock->transaction_payments;
                                        if($stock->transaction_currency == 2){
                                            $final_total = $stock->dollar_final_total;
                                            foreach ($payments as $payment){
                                                if($payment->paying_currency == 2){
                                                    $paid = $payment->amount;
                                                }
                                                else{
                                                    $paid = $payment->amount / $payment->exchange_rate;
                                                }
                                            }
                                        }
                                        else {
                                            $final_total = $stock->final_total;
                                            foreach ($payments as $payment){
                                                if($payment->paying_currency == 2){
                                                    $paid = $payment->amount * $payment->exchange_rate;
                                                }
                                                else{
                                                    $paid = $payment->amount;
                                                }
                                            }
                                        }
                                    @endphp
                                    <td>
                                        {{ @num_format($paid) }}
{{--                                        {{$this->calculatePaidAmount($stock->id)}}--}}
                                    </td>
                                    @php
                                       $final_total = 0;
                                       $pending = 0;
                                       $amount = 0;
                                       $payments = $stock->transaction_payments;
                                       if($stock->transaction_currency == 2){
                                           $final_total = $stock->dollar_final_total;
                                           foreach ($payments as $payment){
                                               if($payment->paying_currency == 2){
                                                   $amount += $payment->amount;
                                                   $pending = $final_total - $amount;
                                               }
                                               else{
                                                   $amount += $payment->amount / $payment->exchange_rate ?? \App\Models\System::getProperty('dollar_exchange');
                                                   $pending = $final_total - $amount;
                                               }
                                           }
                                       }
                                       else {
                                           $final_total = $stock->final_total;
                                           foreach ($payments as $payment){
                                               if($payment->paying_currency == 2){
                                                   $amount += $payment->amount * $payment->exchange_rate ?? \App\Models\System::getProperty('dollar_exchange');
                                                   $pending = $final_total - $amount;
                                               }
                                               else{
                                                   $amount += $payment->amount;
                                                   $pending = $final_total - $amount;;
                                               }
                                           }
                                       }
                                    @endphp
                                    <td>
                                        {{ @num_format($pending) }}
{{--                                        {{$this->calculatePendingAmount($stock->id)}}--}}
                                    </td>
                                    <td>{{$stock->due_date ?? ''}}</td>
                                    <td>{{$stock->notes ?? ''}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- add Payment Modal -->
        {{--    @include('add-stock.partials.add-payment')--}}

    </section>
    <div class="view_modal no-print" ></div>
    @push('javascripts')
        <script src="{{ asset('js/product/product.js') }}"></script>

        <script>
            window.addEventListener('openAddPaymentModal', event => {
                $("#addPayment").modal('show');
            })

            window.addEventListener('closeAddPaymentModal', event => {
                $("#addPayment").modal('hide');
            })
        </script>
    @endpush
@endsection

