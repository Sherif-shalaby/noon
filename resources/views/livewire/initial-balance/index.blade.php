<div class="animate-in-page">
    <section class="">
        <div class="col-md-22">
            <div class="card mt-1">
                <div class="card-header">
                    <h6 class="print-title @if (app()->isLocale('ar')) text-end @else text-start @endif">

                        @lang('lang.initial_balance')</h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-fluid">
                            @include('initial-balance.partial.filters')
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif" style="margin-top:25px ">
                        <div class="div1"></div>
                    </div>
                    <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                        <div class="div2 table-scroll-wrapper">
                            <!-- content goes here -->
                            <div style="min-width: 1300px;max-height: 90vh;overflow: auto">
                                <table id="datatable-buttons"
                                    class="table dataTable table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>@lang('lang.date_and_time')</th>
                                            <th>@lang('lang.product')</th>
                                            <th>@lang('lang.supplier')</th>
                                            <th>@lang('lang.store')</th>
                                            <th>@lang('lang.branch')</th>
                                            <th>@lang('lang.quantity')</th>
                                            <th>@lang('lang.created_by')</th>
                                            <th class="notexport">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stocks as $index => $stock)
                                            <tr>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.date_and_time')">
                                                        {{ $stock->created_at }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.product')">
                                                        {{ $stock->add_stock_lines->first()->product->name ?? '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.supplier')">
                                                        {{ $stock->supplier->name ?? '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.store')">

                                                        {{ $stock->store->name . ' ( ' . $stock->store->branch->name . ' ) ' }}
                                                        @if (count($stock->childTransactions) > 0)
                                                            @foreach ($stock->childTransactions as $transaction)
                                                                <br>
                                                                {{ $transaction->store->name ?? '' . ' ( ' . $transaction->store->branch->name . ' ) ' }}
                                                            @endforeach
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.quantity')">
                                                        {{ $stock->store?->branch->name ?? '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.quantity')">

                                                        @foreach ($stock->add_stock_lines as $index => $line)
                                                            {{ @num_format($line->quantity) . ' ( ' . $line->variation?->unit->name . ' ) ' }}
                                                            {{ !empty($transaction->add_stock_lines[$index + 1]) }} <br>
                                                        @endforeach
                                                        @if (count($stock->childTransactions) > 0)
                                                            @foreach ($stock->childTransactions as $transaction)
                                                                @foreach ($transaction->add_stock_lines as $index => $line)
                                                                    {{ @num_format($line->quantity) . ' ( ' . $line->variation?->unit->name . ' ) ' }}
                                                                    {{ !empty($transaction->add_stock_lines[$index + 1]) }}
                                                                    <br>
                                                                @endforeach
                                                            @endforeach
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="custom-tooltip d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600"
                                                        data-tooltip="@lang('lang.created_by')">
                                                        {{ $stock->created_by_relationship->name ?? '' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-default btn-sm dropdown-toggle d-flex justify-content-center align-items-center"
                                                        style="font-size: 12px;font-weight: 600" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        @lang('lang.action')
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                        user="menu">
                                                        <li>
                                                            <a href="{{ route('initial-balance.show', $stock->id) }}"
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                    class="fa fa-eye"></i>
                                                                @lang('lang.view') </a>
                                                        </li>

                                                        <li>
                                                            <a href="{{ route('initial-balance.edit', $stock->id) }}"
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                    class="fa fa-edit"></i>
                                                                @lang('lang.edit') </a>
                                                        </li>

                                                        <li>
                                                            <a data-href="{{ route('initial-balance.destroy', $stock->id) }}"
                                                                data-check_password="{{ route('check_password', Auth::user()->id) }}"
                                                                class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif text-red delete_item"
                                                                data-deletetype="1"><i class="fa fa-trash"></i>
                                                                @lang('lang.delete')</a>
                                                        </li>
                                                        @if (!empty($stock->payment_status) && $stock->payment_status != 'paid')
                                                            <li>
                                                                <a data-href="{{ route('stocks.addPayment', $stock->id) }}"
                                                                    data-container=".view_modal"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif btn-modal">
                                                                    <i class="fa fa-money"></i>
                                                                    @lang('lang.pay')
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </td>

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
            </div>
        </div>
</div>

<!-- add Payment Modal -->
{{--    @include('add-stock.partials.add-payment') --}}

</section>
</div>

<div class="view_modal no-print"></div>
@push('javascripts')
    <script>
        window.addEventListener('openAddPaymentModal', event => {
            $("#addPayment").modal('show');
        })

        window.addEventListener('closeAddPaymentModal', event => {
            $("#addPayment").modal('hide');
        })
        $(document).ready(function() {
            $('select').on('change', function(e) {
                var name = $(this).data('name');
                var index = $(this).data('index');
                var select2 = $(this); // Save a reference to $(this)
                Livewire.emit('listenerReferenceHere', {
                    var1: name,
                    var2: select2.select2("val"),
                    var3: index
                });
            });
        });
    </script>
@endpush
