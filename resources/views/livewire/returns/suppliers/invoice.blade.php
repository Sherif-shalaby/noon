<!-- Start Contentbar -->
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">@lang('lang.products')</h5>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-fluid">
                            @include('add-stock.partials.filters')
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                    <div class="table-responsive">
                        {{-- +++++++++++++++++++++++++++ Table +++++++++++++++++++++++++++ --}}
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('lang.po_ref_no')</th>
                                <th>@lang('lang.invoice_no')</th>
                                <th>@lang('lang.date_and_time')</th>
                                <th>@lang('lang.invoice_date')</th>
                                <th>@lang('lang.supplier')</th>
                                <th>@lang('lang.products')</th>
                                <th>@lang('lang.created_by')</th>
                                <th>@lang('lang.return_invoice')</th>
                                <th class="notexport">@lang('lang.action')</th>
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
                                    <td>{{$stock->created_by_relationship->first()->name}}</td>
                                    <td>
                                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#paymentModal">
                                            @lang('lang.return_invoice')
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                            @lang('lang.action')
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                            <li>
                                                <a href="{{route('stocks.show', $stock->id)}}"
                                                   class="btn"><i
                                                        class="fa fa-eye"></i>
                                                    @lang('lang.view') </a>
                                            </li>
{{--                                            <li class="divider"></li>--}}
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
        <!-- End col -->
    </div>
    <!-- End row -->
    @include('suppliers.returns.partials.payment')
</div>
<!-- End Contentbar -->
