@extends('layouts.app')
@section('title', __('lang.sell_price_less_purchase_price'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.sell_price_less_purchase_price')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="">@lang('lang.reports')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.product_report')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.sell_price_less_purchase_price')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
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
                        <h5 class="card-title">@lang('lang.sell_price_less_purchase_price')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
{{--                                    @include('reports.products.filters')--}}
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div id="status"></div>
                            <table id="datatable-buttons" class="table dataTable table-striped table-bordered">
                                <thead>
                                <tr>
                                    <<th>@lang('lang.date_and_time')</th>
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
                                    <th>@lang('lang.due_date')</th>
                                    <th>@lang('lang.payment_date')</th>
                                    <th>@lang('lang.cashier_man')</th>
                                    <th>@lang('lang.commission')</th>
                                    <th>@lang('lang.products')</th>
                                    <th>@lang('lang.sale_note')</th>
                                    <th>@lang('lang.receipts')</th>
                                    <th class="notexport">@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sell_lines as $index => $line)
                                    <tr>
                                        <td>
                                            {{$line->transaction_date ?? ''}}
                                        </td>
                                        <td>
                                            {{$line->invoice_no ?? '' }}
                                        </td>
                                        <td>
                                            {{$line->store->name ?? '' }}
                                        </td>
                                        <td>
                                            {{$line->customer->name ?? '' }}
                                        </td>
                                        <td>
                                            {{$line->customer->phone ?? '' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-success">{{$line->status ?? '' }}</span>
                                        </td>
                                        <td>{{$line->payment_status}}</td>
                                        <td>
                                            @foreach($line->transaction_payments as $payment)
                                                {{__('lang.'.$payment->method)}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($line->transaction_payments as $payment)
                                                {{$payment->ref_no ?? ''}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($line->transaction_payments as $payment)
                                                {{$payment->received_currency_relation->symbol ?? ''}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{number_format($line->final_total,2)}}
                                        </td>
                                        <td>
                                            {{$line->transaction_payments->sum('amount')}}
                                        </td>
                                        <td>
                                            {{$line->final_total - $line->transaction_payments->sum('amount')}}
                                        </td>
                                        <td>
                                            {{$line->transaction_payments->last()->due_date ?? ''}}
                                        </td>
                                        <td>
                                            {{$line->transaction_payments->last()->paid_on ?? ''}}
                                        </td>
                                        <td>
                                            {{$line->created_by_user->name}}
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            @foreach($line->transaction_sell_lines as $sell_line)
                                                @if(!empty($sell_line->product))
                                                    {{$sell_line->product->name ?? ' ' }} -
                                                    {{ $sell_line->product->sku ?? ' ' }}<br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($line->transaction_payments as $payment)
                                                {{$payment->received_currency_relation->payment_note ?? ''}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if(count($line->receipts) > 0)
                                                <a data-href=" {{route('show_receipt', $line->id)}}"
                                                   data-container=".view_modal"
                                                   class="btn btn-default btn-modal"> {{__('lang.view')}}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                <li>
                                                    <a data-href="{{route('print_invoice', $line->id)}}"
                                                       class="btn print-invoice"><i class="dripicons-print"></i>
                                                        {{ __('lang.generate_invoice') }}</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href=" {{route('pos.show', $line->id)}}" data-container=".view_modal"
                                                       class="btn btn-modal"><i class="fa fa-eye"></i>{{ __('lang.view') }}
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{route('sell.return',$line->id)}}" class="btn"><i class="fa fa-undo"></i>@lang('lang.return') </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{ route('show_payment', $line->id) }}"
                                                       data-container=".view_modal" class="btn btn-modal"><i class="fa fa-money"></i>
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
                                                    <a data-href=" {{route('upload_receipt', $line->id)}}" data-container=".view_modal" data-dismiss="modal"
                                                       class="btn btn-modal"><i class="fa fa-plus"></i>{{ __('lang.upload_receipt') }}
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{ route('pos.destroy', $line->id) }}"
                                                       {{--                                                       data-check_password="{{ action('UserController@checkPassword', Auth::user()->id) }} "--}}
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
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
    <div class="view_modal no-print" >@endsection
        @push('javascripts')
            <script src="{{ asset('js/product/product.js') }}"></script>
            <script>

                $(document).on('click', '.product_unit', function() {
                    var $this=$(this);
                    var variation_id=$(this).data('variation_id');
                    var product_id=$(this).data('product_id');
                    $.ajax({
                        type: "get",
                        url: "/product/get-unit-store",
                        data: {variation_id:variation_id,product_id:product_id},
                        success: function (response) {
                            $this.closest('td').find('.product_unit').each(function() {
                                $(this).find('.unit_value').text(0); // Change "New Value" to the desired value
                            });
                            $this.children('.unit_value').text(response.store);
                        }
                    });
                });
            </script>

    @endpush
