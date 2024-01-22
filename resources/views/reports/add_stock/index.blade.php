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
                            {{-- +++++++++++++++++ checkbox1 : po_ref_no +++++++++++++++++ --}}
                            <label for="col1_id">
                                <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                <span>@lang('lang.po_ref_no')</span> &nbsp;
                            </label>
                            {{-- +++++++++++++++++ checkbox2 : invoice_no +++++++++++++++++ --}}
                            <label for="col2_id">
                                <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                <span>@lang('lang.invoice_no')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox3 : date_and_time +++++++++++++++++ --}}
                            <label for="col3_id">
                                <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                <span>@lang('lang.date_and_time')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox4 : invoice_date +++++++++++++++++ --}}
                            <label for="col4_id">
                                <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                <span>@lang('lang.invoice_date')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox5 : supplier +++++++++++++++++ --}}
                            <label for="col5_id">
                                <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                <span>@lang('lang.supplier')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox6 : products +++++++++++++++++ --}}
                            <label for="col6_id">
                                <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                <span>@lang('lang.products')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox7 : purchase_type +++++++++++++++++ --}}
                            <label for="col7_id">
                                <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                <span>@lang('lang.purchase_type')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox8 : created_by +++++++++++++++++ --}}
                            <label for="col8_id">
                                <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                <span>@lang('lang.created_by')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox9 : payment_status +++++++++++++++++ --}}
                            <label for="col9_id">
                                <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                <span>@lang('lang.payment_status')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox10 : value +++++++++++++++++ --}}
                            <label for="col10_id">
                                <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                <span>@lang('lang.value')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox11 : paid_amount +++++++++++++++++ --}}
                            <label for="col11_id">
                                <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                <span>@lang('lang.paid_amount')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox12 : pending_amount +++++++++++++++++ --}}
                            <label for="col12_id">
                                <input type="checkbox" id="col12_id" name="col12" checked="checked" />
                                <span>@lang('lang.pending_amount')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox13 : payment_date +++++++++++++++++ --}}
                            <label for="col13_id">
                                <input type="checkbox" id="col13_id" name="col13" checked="checked" />
                                <span>@lang('lang.payment_date')</span>
                            </label>
                            {{-- +++++++++++++++++ checkbox14 : notes +++++++++++++++++ --}}
                            <label for="col14_id">
                                <input type="checkbox" id="col14_id" name="col14" checked="checked" />
                                <span>@lang('lang.notes')</span>
                            </label>
                        </div>
                    </div>
                </div> <br/>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                            <tr>
                                <th class="col1">@lang('lang.po_ref_no')</th>
                                <th class="col2">@lang('lang.invoice_no')</th>
                                <th class="col3">@lang('lang.date_and_time')</th>
                                <th class="col4">@lang('lang.invoice_date')</th>
                                <th class="col5">@lang('lang.supplier')</th>
                                <th class="col6">@lang('lang.products')</th>
                                <th class="col7">@lang('lang.purchase_type')</th>
                                <th class="col8">@lang('lang.created_by')</th>
                                <th class="col9">@lang('lang.payment_status')</th>
                                <th class="col10 sum">@lang('lang.value')</th>
                                <th class="col11 sum">@lang('lang.paid_amount')</th>
                                <th class="col12 sum">@lang('lang.pending_amount')</th>
                                <th class="col13">@lang('lang.payment_date')</th>
                                <th class="col14">@lang('lang.notes')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stocks as $index => $stock)
                                <tr>
                                    <td class="col1">{{$stock->po_no ?? ''}}</td>
                                    <td class="col2">{{$stock->invoice_no ?? ''}}</td>
                                    <td class="col3">{{$stock->created_at }}</td>
                                    <td class="col4">{{$stock->transaction_date }}</td>
                                    <td class="col5">{{$stock->supplier->name??''}}</td>
                                    <td class="col6">
                                        @if(!empty($stock->add_stock_lines))
                                            @foreach($stock->add_stock_lines as $stock_line)
                                                {{ $stock_line->product->name ?? '' }}<br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="col7">
                                        {{ $stock->purchase_type }}
                                    </td>

                                    <td class="col8">{{$stock->created_by_relationship->first()->name}}</td>
                                    <td class="col9">
                                        @lang('lang.'. $stock->payment_status)
                                    </td>
                                    @if($stock->transaction_currency == 2)
                                        <td class="col10">{{@num_format($stock->dollar_final_total)}}</td>
                                    @else
                                        <td class="col10">{{@num_format($stock->final_total)}}</td>
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
                                    <td class="col11">
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
                                    <td class="col12">
                                        {{ @num_format($pending) }}
{{--                                        {{$this->calculatePendingAmount($stock->id)}}--}}
                                    </td>
                                    <td class="col13">{{$stock->due_date ?? ''}}</td>
                                    <td class="col14">{{$stock->notes ?? ''}}</td>
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
        {{-- @section('javascript') --}}
        {{-- +++++++++++++++ Show/Hide checkboxes +++++++++++++++ --}}
        <script>
            // ++++++++ Checkboxs and label inside selectbox ++++++++
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
    {{-- @endsection --}}
    @endpush
@endsection

