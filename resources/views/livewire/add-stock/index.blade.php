<section class="">
    <div class="col-md-22">
        <div class="card mt-3">
            <div class="card-header d-flex align-items-center">
                <h3 class="print-title">@lang('lang.add_stock_list')</h3>
            </div>
            {{--                <div class="card-body">--}}
            {{--                    <form action="">--}}
            {{--                        <input type="hidden" name="is_raw_material" id="is_raw_material"--}}
            {{--                               value="@if (request()->segment(1) == 'raw-material') {{ 1 }}@else{{ 0 }} @endif">--}}
            {{--                        <div class="row">--}}
            {{--                            <div class="col-md-3">--}}
            {{--                                <div class="form-group">--}}
            {{--                                    {!! Form::label('store_id', __('lang.store'), []) !!}--}}
            {{--                                    {!! Form::select('store_id', $stores, request()->store_id, ['class' => 'form-control filters', 'placeholder' => __('lang.all'), 'data-live-search' => 'true']) !!}--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                            <div class="col-md-3">--}}
            {{--                                <div class="form-group">--}}
            {{--                                    {!! Form::label('supplier_id', __('lang.supplier'), []) !!}--}}
            {{--                                    {!! Form::select('supplier_id', $suppliers, request()->supplier_id, ['class' => 'form-control filters', 'placeholder' => __('lang.all'), 'data-live-search' => 'true']) !!}--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                            <div class="col-md-3">--}}
            {{--                                <div class="form-group">--}}
            {{--                                    {!! Form::label('created_by', __('lang.added_by'), []) !!}--}}
            {{--                                    {!! Form::select('created_by', $users, request()->created_by, ['class' => 'form-control filters', 'placeholder' => __('lang.all'), 'data-live-search' => 'true']) !!}--}}
            {{--                                </div>--}}
            {{--                            </div>--}}

            {{--                            <div class="col-md-3">--}}
            {{--                                <div class="form-group">--}}
            {{--                                    {!! Form::label('product_id', __('lang.product'), []) !!}--}}
            {{--                                    {!! Form::select('product_id', $products, request()->product_id, ['class' => 'form-control filters', 'placeholder' => __('lang.all'), 'data-live-search' => 'true']) !!}--}}
            {{--                                </div>--}}
            {{--                            </div>--}}

            {{--                            <div class="col-md-2">--}}
            {{--                                <div class="form-group">--}}
            {{--                                    {!! Form::label('start_date', __('lang.start_date'), []) !!}--}}
            {{--                                    {!! Form::text('start_date', request()->start_date, ['class' => 'form-control ', 'id' => 'start_date']) !!}--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                            <div class="col-md-2">--}}
            {{--                                <div class="form-group">--}}
            {{--                                    {!! Form::label('start_time', __('lang.start_time'), []) !!}--}}
            {{--                                    {!! Form::text('start_time', null, ['class' => 'form-control time_picker sale_filter']) !!}--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                            <div class="col-md-2">--}}
            {{--                                <div class="form-group">--}}
            {{--                                    {!! Form::label('end_date', __('lang.end_date'), []) !!}--}}
            {{--                                    {!! Form::text('end_date', request()->end_date, ['class' => 'form-control ', 'id' => 'end_date']) !!}--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                            <div class="col-md-2">--}}
            {{--                                <div class="form-group">--}}
            {{--                                    {!! Form::label('end_time', __('lang.end_time'), []) !!}--}}
            {{--                                    {!! Form::text('end_time', null, ['class' => 'form-control time_picker sale_filter']) !!}--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                            <div class="col-md-3">--}}
            {{--                                <button type="button"--}}
            {{--                                        class="btn btn-danger clear_filters mt-2 ml-2">@lang('lang.clear_filter')</button>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </form>--}}
            {{--                </div>--}}
        </div>
    </div>

    <div class="table-responsive">
        <table class="table" id="add_stock_table">
            <thead>
            <tr>
                <th>@lang('lang.po_ref_no')</th>
                <th>@lang('lang.invoice_no')</th>
                <th>@lang('lang.date_and_time')</th>
                <th>@lang('lang.invoice_date')</th>
                <th>@lang('lang.supplier')</th>
                <th>@lang('lang.created_by')</th>
                <th class="currencies">@lang('lang.paying_currency')</th>
                <th class="sum">@lang('lang.value')</th>
                <th class="sum">@lang('lang.paid_amount')</th>
                <th class="sum">@lang('lang.pending_amount')</th>
                <th>@lang('lang.due_date')</th>
                <th>@lang('lang.notes')</th>
                <th class="notexport">@lang('lang.action')</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <th class="table_totals" style="text-align: right">@lang('lang.total')</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
</section>
