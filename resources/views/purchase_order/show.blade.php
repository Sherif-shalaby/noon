@extends('layouts.app')
@section('title', __('lang.purchase_order'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.purchase_order')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('stocks.index')}}">@lang('lang.purchase_order')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.view')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a type="button" class="btn btn-primary" href="{{route('purchase_order.index')}}">@lang('lang.purchase_order')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="col-md-12 print-only">
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center no-print">
                            <h4>@lang('lang.po_no'): {{$purchase_order_transaction->po_no}}</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    {!! Form::label('supplier_name', __('lang.supplier_name'), []) !!}:
                                    <b>{{$purchase_order_transaction->supplier->name ?? ''}}</b>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::label('email', __('lang.email'), []) !!}: <b>{{$purchase_order_transaction->supplier->email ?? ''}}</b>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::label('mobile_number', __('lang.mobile_number'), []) !!}:
                                    <b>{{$purchase_order_transaction->supplier->mobile_number ?? ''}}</b>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::label('address', __('lang.address'), []) !!}: <b>{{$purchase_order_transaction->supplier->address ?? ''}}</b>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::label('store', __('lang.store'), []) !!}: <b>{{$purchase_order_transaction->store->name ??
                                    ''}}</b>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped table-condensed" id="product_table">
                                        <thead>
                                        <tr>
                                            <th style="width: 15%" class="col-sm-8">@lang( 'lang.products' )</th>
                                            <th style="width: 10%" class="col-sm-4">@lang( 'lang.quantity' )</th>
                                            <th style="width: 12%" class="col-sm-4">@lang( 'lang.purchase_price' )</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($purchase_order_transaction->transaction_purchase_order_lines as $line)
                                            <tr>
                                                <td>
                                                    {{$line->product->name ?? ''}}
                                                </td>
                                                <td>
                                                    @if(isset($line->quantity)){{number_format($line->quantity,App\Models\System::getProperty('numbers_length_after_dot'))}}@else{{1}}@endif
                                                </td>
                                                <td>
                                                    @if(isset($line->purchase_price)){{@num_format($line->purchase_price)}}@else{{0}}@endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3 offset-md-8 text-right">
                                    <h3> @lang('lang.total'): <span
                                            class="final_total_span">{{@num_format($purchase_order_transaction->final_total)}}</span>
                                    </h3>

                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('notes', __('lang.notes'), []) !!}: <br>
                                        {{$purchase_order_transaction->details}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 print-only">
            </div>
        </div>


    </section>
@endsection

@push('javascripts')
    <script type="text/javascript">
        @if(!empty(request()->print))
        $(document).ready(function(){
            setTimeout(() => {
                window.print();
            }, 1000);
        })
        @endif
    </script>
@endpush
