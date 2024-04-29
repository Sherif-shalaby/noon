<section class="">
    <div class="col-md-22">
        <div class="card mt-3">
            <div class="card-header d-flex align-items-center">
                <h3 class="print-title">@lang('lang.initial_balance')</h3>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="container-fluid">
                        @include('initial-balance.partial.filters')
                    </div>
                </div>
            </div>
            {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
            <div class="col-md-3 col-lg-3">
                <div class="multiselect col-md-6">
                    <div class="selectBox" onclick="showCheckboxes()">
                        <select class="form-select form-control form-control-lg">
                            <option>@lang('lang.show_hide_columns')</option>
                        </select>
                        <div class="overSelect"></div>
                    </div>
                    <div id="checkboxes">
                        {{-- +++++++++++++++++ checkbox1 : date_and_time +++++++++++++++++ --}}
                        <label for="col1_id">
                            <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                            <span>@lang('lang.date_and_time')</span> &nbsp;
                        </label>
                        {{-- +++++++++++++++++ checkbox2 : product +++++++++++++++++ --}}
                        <label for="col2_id">
                            <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                            <span>@lang('lang.product')</span>
                        </label>
                        {{-- +++++++++++++++++ checkbox3 : supplier +++++++++++++++++ --}}
                        <label for="col3_id">
                            <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                            <span>@lang('lang.supplier')</span>
                        </label>
                        {{-- +++++++++++++++++ checkbox4 : store +++++++++++++++++ --}}
                        <label for="col4_id">
                            <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                            <span>@lang('lang.store')</span>
                        </label>
                        {{-- +++++++++++++++++ checkbox5 : quantity +++++++++++++++++ --}}
                        <label for="col5_id">
                            <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                            <span>@lang('lang.quantity')</span>
                        </label>
                        {{-- +++++++++++++++++ checkbox6 : created_by +++++++++++++++++ --}}
                        <label for="col6_id">
                            <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                            <span>@lang('lang.created_by')</span>
                        </label>
                        {{-- +++++++++++++++++ checkbox7 : action +++++++++++++++++ --}}
                        <label for="col7_id">
                            <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                            <span>@lang('lang.action')</span>
                        </label>
                    </div>
                </div>
            </div>
            <br/><br/>
            {{-- ++++++++++++++++++ table ++++++++++++++++++ --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table dataTable">
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
                        @foreach($stocks as $index => $stock)
                            <tr>
                                <td class="col1">{{$stock->created_at }}</td>
                                <td class="col2">
                                    {{$stock->add_stock_lines->first()->product->name ?? '' }}
                                </td>
                                <td class="col3">{{$stock->supplier->name ?? ''}}</td>
                                <td class="col4">
                                    {{$stock->store->name .' ( ' . $stock->store->branch->name .' ) '}}
                                    @if(count($stock->childTransactions) > 0)
                                        @foreach($stock->childTransactions as $transaction)
                                                <br>
                                                {{ $transaction->store->name??'' .' ( ' . $transaction->store->branch->name .' ) ' }}
                                            @endforeach
                                    @endif
                                </td>

                                <td>{{$stock->store?->branch->name??''}}</td>
                                <td>
                                     @foreach($stock->add_stock_lines as $index => $line)
                                     {{ @num_format($line->quantity) . ' (' . ($line->variation && $line->variation->unit ? $line->variation->unit->name : '-') . ')' }}

                                        {{ !empty($transaction->add_stock_lines[$index+1]) ? '<br>' : '' }}
                                    @endforeach
                                         @if(count($stock->childTransactions) > 0)
                                             @foreach($stock->childTransactions as $transaction)
                                                 @foreach($transaction->add_stock_lines as $index => $line)
                                                     {{ @num_format( $line->quantity) .' ( '. $line->variation?->unit->name .' ) ' }}
                                                     {{ !empty($transaction->add_stock_lines[$index+1]) ? '<br>' : '' }}
                                                 @endforeach
                                             @endforeach
                                         @endif
                                </td>
                                <td class="col6">{{$stock->created_by_relationship->name}}</td>
                                <td class="col7">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        @lang('lang.action')
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                        <li>
                                            <a href="{{route('initial-balance.show', $stock->id)}}"
                                               class="btn"><i
                                                    class="fa fa-eye"></i>
                                                @lang('lang.view') </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="{{route('initial-balance.edit', $stock->id)}}"
                                               class="btn"><i
                                                    class="fa fa-edit"></i>
                                                @lang('lang.edit') </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a data-href="{{route('initial-balance.destroy', $stock->id)}}"
                                                data-check_password="{{route('check_password', Auth::user()->id)}}"
                                               class="btn text-red delete_item" data-deletetype="1"><i class="fa fa-trash"></i>
                                                @lang('lang.delete')</a>
                                        </li>
                                        @if ( !empty($stock->payment_status) && $stock->payment_status != 'paid')
                                            <li class="divider"></li>
                                            <li>
                                                <a data-href="{{route('stocks.addPayment', $stock->id)}}" data-container=".view_modal"
                                                   class="btn btn-modal">
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
    <!-- add Payment Modal -->
    {{--    @include('add-stock.partials.add-payment')--}}
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
</section>
<div class="view_modal no-print" ></div>
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
                Livewire.emit('listenerReferenceHere',{
                    var1 :name,
                    var2 :select2.select2("val") ,
                    var3:index
                });

            });
        });
    </script>
    {{-- +++++++++++++++ Show/Hide checkboxes +++++++++++++++ --}}
    <script>
        // +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++
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
@endpush
