
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header d-flex align-items-center">
                        <h4>@lang('lang.add-stock')</h4>
                    </div>
                    <div class="row ">
                        <div class="col-md-9">
                            <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info')</small></p>
                        </div>
                        <div class="col-md-3">
                            <div class="i-checks">
                                <input id="clear_all_input_form" name="clear_all_input_form"
                                       type="checkbox" @if (isset($clear_all_input_stock_form) && $clear_all_input_stock_form == '1') checked @endif
                                       class="">
                                <label for="clear_all_input_form" style="font-size: 0.75rem">
                                    <strong>
                                        @lang('lang.clear_all_input_form')
                                    </strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    {!! Form::open([ 'id' => 'add_stock_form']) !!}
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                                    {!! Form::select('store_id', $stores, !empty($recent_stock)&&!empty($recent_stock->store_id)?$recent_stock->store_id:session('user.store_id'), ['class' => ' form-control select2','data-name' => 'store_id', 'data-live-search' => 'true', 'required', 'placeholder' => __('lang.please_select'), 'wire:model' => 'store_id']) !!}
                                    @error('store_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('supplier_id', __('lang.supplier') . ':*', []) !!}
                                    {!! Form::select('supplier_id', $suppliers, !empty($recent_stock)&&!empty($recent_stock->supplier_id)?$recent_stock->supplier_id:'Please Select', ['class' => 'form-control select2', 'data-live-search' => 'true',  'placeholder' => __('lang.please_select'),'data-name' => 'supplier', 'wire:model' => 'supplier', 'wire:change' => 'changeExchangeRate()']) !!}
                                    @error('supplier')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('status', __('lang.status') . ':*', []) !!}
                                    {!! Form::select('status', ['received' =>  __('lang.received'), 'partially_received' => __('lang.partially_received')], !empty($recent_stock)&&!empty($recent_stock->status)?$recent_stock->status: 'Please Select', ['class' => 'form-control select2', 'data-live-search' => 'true', 'required',  'placeholder' => __('lang.please_select'), 'data-name' => 'status','wire:model' => 'status']) !!}
                                    @error('status')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('transaction_date', __('lang.date_and_time'), []) !!}
                                    <input type="datetime-local" wire:model="transaction_date"
                                           value="{{ date('Y-m-d\TH:i') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="invoice_currency">@lang('lang.invoice_currency') :*</label>
                                    {!! Form::select('invoice_currency', $selected_currencies, null, ['class' => 'form-control select2','placeholder' => __('lang.please_select'), 'data-live-search' => 'true', 'required', 'data-name' => 'transaction_currency', 'wire:model' => 'transaction_currency']) !!}
                                    @error('paying_currency')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('purchase_type', __('lang.purchase_type') . ':*', []) !!}
                                    {!! Form::select('purchase_type', ['import' =>  __('lang.import'), 'local' => __('lang.local')], !empty($recent_stock)&&!empty($recent_stock->status)?$recent_stock->status: 'Please Select', ['class' => 'form-control select2', 'data-live-search' => 'true', 'required',  'placeholder' => __('lang.please_select'), 'data-name' => 'purchase_type', 'wire:model' => 'purchase_type']) !!}
                                    @error('purchase_type')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('divide_costs', __('lang.divide_costs') . ':', []) !!}
                                    {!! Form::select('divide_costs', ['size' =>  __('lang.size'), 'weight' => __('lang.weight'), 'price' => __('lang.price')], 'Please Select', ['class' => 'form-control select2', 'data-live-search' => 'true', 'required',  'placeholder' => __('lang.please_select'), 'data-name' => 'divide_costs', 'wire:model' => 'divide_costs']) !!}
                                    @error('divide_costs')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('exchange_rate', __('lang.exchange_rate') . ':', []) !!}
                                    <input type="text"  class="form-control" id="exchange_rate" name="exchange_rate" value="{{number_format($exchange_rate,2)}}" disabled>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-8 m-t-15 offset-md-2">
                                <div class="search-box input-group">
                                    <button type="button" class="btn btn-secondary" id="search_button"><i
                                            class="fa fa-search"></i>
                                    </button>
                                    <input type="search" name="search_product" id="search_product" wire:model.debounce.500ms="searchProduct"
                                           placeholder="@lang('lang.enter_product_name_to_print_labels')"
                                           class="form-control" autocomplete="off">
                                    <button type="button" class="btn btn-success  btn-modal"
                                            data-href="{{ route('products.create') }}?quick_add=1"
                                            data-container=".view_modal"><i class="fa fa-plus"></i>
                                    </button>
                                    @if(!empty($search_result))
                                        <ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2" style="top: 37.423px; left: 39.645px; width: 90.2%;">
                                            @foreach($search_result as $product)
                                                <li class="ui-menu-item" wire:click="fetchProduct({{$product->id}})">
                                                    <div id="ui-id-73" tabindex="-1" class="ui-menu-item-wrapper">
                                                        <img src="https://mahmoud.s.sherifshalaby.tech/uploads/995_image.png" width="50px" height="50px">
                                                        {{$product->sku ?? ''}} - {{$product->name}}
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
{{--                                    {{$search_result->links()}}--}}
                                </div>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2 border border-1 mr-3 p-0">
                                <div class="p-3 text-center font-weight-bold "  style="background-color: #eee;">
                                    الأقسام الرئيسيه
                                    <div for="" class="d-flex align-items-center text-nowrap gap-1" wire:ignore>
                                        {{-- الاقسام --}}
                                        <select class="form-control select2" data-name="department_id" wire:model="department_id">
                                            <option  value="" readonly selected >اختر </option>
                                            @foreach ($departments as $depart)
                                                <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="p-2">
                                    @foreach ($products as $product)
                                        <div class="order-btn" wire:click='add_product({{ $product->id }})' >
{{--                                            @if ($product->image)--}}
{{--                                                <img src="{{ asset('uploads/products/' . $product->image) }}"--}}
{{--                                                     alt="{{ $product->name }}" class="img-thumbnail" width="80px" height="80px" >--}}
{{--                                            @else--}}
{{--                                                <img src="{{ asset('uploads/'.$settings['logo']) }}" alt="{{ $product->name }}"--}}
{{--                                                     class="img-thumbnail" width="100px">--}}
{{--                                            @endif--}}
                                            <span>{{ $product->name }}</span>
                                            <span>{{ $product->sku }} </span>
                                        </div>
                                        <hr/>
                                    @endforeach
                                </div>
                            </div>
                            <div class="table-responsive col-md-9 border border-1">
                                <table class="table" style="width: auto" >
                                    <thead>
                                    <tr>
                                        <th>#</th>
{{--                                        <th style="width: 7%" class="col-sm-8">@lang('lang.image')</th>--}}
                                        <th style="width: 10%" class="col-sm-8">@lang('lang.products')</th>
                                        <th style="width: 10%" >@lang('lang.sku')</th>
                                        <th style="width: 10%">@lang('lang.quantity')</th>
                                        <th style="width: 10%">@lang('lang.unit')</th>
                                        <th style="width: 10%">@lang('lang.fill')</th>
{{--                                        <th style="width: 10%">@lang('lang.total_quantity')</th>--}}
{{--                                        @if ($showColumn)--}}
                                            <th style="width: 10%">@lang('lang.purchase_price')$</th>
                                            <th style="width: 10%">@lang('lang.selling_price')$</th>
                                            <th style="width: 10%">@lang('lang.sub_total')$</th>
{{--                                        @endif--}}
                                        <th style="width: 10%">@lang('lang.purchase_price')  </th>
                                        <th style="width: 10%">@lang('lang.selling_price') </th>
                                        <th style="width: 10%">@lang('lang.sub_total')</th>
                                        <th style="width: 10%">@lang('lang.size')</th>
                                        <th style="width: 10%">@lang('lang.total_size')</th>
                                        <th style="width: 10%">@lang('lang.weight')</th>
                                        <th style="width: 10%">@lang('lang.total_weight')</th>
{{--                                        @if ($showColumn)--}}
                                            <th style="width: 10%">@lang('lang.cost')$</th>
                                            <th style="width: 10%">@lang('lang.total_cost')$</th>
{{--                                        @endif--}}
                                        <th style="width: 10%">@lang('lang.cost') </th>
                                        <th style="width: 10%">@lang('lang.total_cost')</th>
                                        <th style="width: 10%">@lang('lang.new_stock')</th>
                                        <th style="width: 10%">@lang('lang.change_current_stock')</th>
                                        <th style="width: 10%">@lang('lang.action')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($items))
                                        @foreach($items  as $index => $product)
                                            @include('add-stock.partials.product_row')
                                        @endforeach
                                        <tr>
                                            <td colspan="8" style="text-align: right"> @lang('lang.total')</td>
{{--                                            @if ($showColumn)--}}
                                                <td> {{$this->sum_dollar_sub_total()}} </td>
                                                <td></td>
                                                <td></td>
{{--                                            @endif--}}
                                            <td> {{$this->sum_sub_total()}} </td>
                                            <td></td>
                                            <td style="">
                                                {{$this->sum_size() ?? 0}}
                                            </td>
                                            <td></td>
                                            <td  style=";">
                                                {{$this->sum_weight() ?? 0}}
                                            </td>
                                            <td></td>
{{--                                            @if ($showColumn)--}}
                                                <td>
                                                    {{$this->sum_dollar_total_cost() ?? 0}}
                                                </td>
                                                <td></td>
{{--                                            @endif--}}
                                            <td  style=";">
                                                {{$this->sum_total_cost() ?? 0}}
                                            </td>

                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 text-center mt-1 ">
                            <h4>@lang('lang.items_count'):
                                <span class="items_count_span" style="margin-right: 15px;">{{!empty($items)? count($items) : 0}}</span>
                                <br> @lang('lang.items_quantity'): <span
                                    class="items_quantity_span" style="margin-right: 15px;">{{ $this->total_quantity() }}</span>
                            </h4>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="col-md-3 offset-md-8 text-right">
                                <h3> @lang('lang.total') :
                                    @if($paying_currency == 2)
                                        {{$this->sum_dollar_total_cost() ?? 0.00}}
                                    @else
                                        {{$this->sum_total_cost() ?? 0.00}}
                                    @endif
                                    <span class="final_total_span"></span> </h3>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('files', __('lang.files'), []) !!} <br>
                                    <input type="file" name="files[]" id="files" multiple>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('invoice_no', __('lang.invoice_no'), []) !!} <br>
                                    {!! Form::text('invoice_no', !empty($recent_stock)&&!empty($recent_stock->invoice_no)?$recent_stock->invoice_no:null, ['class' => 'form-control', 'placeholder' => __('lang.invoice_no'),'wire:model' => 'invoice_no']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('other_expenses', __('lang.other_expenses'), []) !!} <br>
                                    {!! Form::text('other_expenses', !empty($recent_stock)&&!empty($recent_stock->other_expenses)?@num_format($recent_stock->other_expenses):null, ['class' => 'form-control', 'placeholder' => __('lang.other_expenses'), 'id' => 'other_expenses', 'wire:model' => 'other_expenses']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('discount_amount', __('lang.discount'), []) !!} <br>
                                    {!! Form::text('discount_amount', !empty($recent_stock)&&!empty($recent_stock->discount_amount)?@num_format($recent_stock->discount_amount):null, ['class' => 'form-control', 'placeholder' => __('lang.discount'), 'id' => 'discount_amount','wire:model' => 'discount_amount']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('other_payments', __('lang.other_payments'), []) !!} <br>
                                    {!! Form::text('other_payments', !empty($recent_stock)&&!empty($recent_stock->other_payments)?@num_format($recent_stock->other_payments):null, ['class' => 'form-control', 'placeholder' => __('lang.other_payments'), 'id' => 'other_payments', 'wire:model' => 'other_payments']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('source_type', __('lang.source_type'), []) !!} <br>
                                    {!! Form::select('source_type', ['user' => __('lang.user'), 'pos' => __('lang.pos'), 'store' => __('lang.store'), 'safe' => __('lang.safe')], !empty($recent_stock)&&!empty($recent_stock->source_type)?$recent_stock->source_type: 'Please Select', ['class' => 'form-control select2', 'data-live-search' => 'true',  'placeholder' => __('lang.please_select'), 'data-name' => 'source_type', 'wire:model' => 'source_type']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('source_of_payment', __('lang.source_of_payment'), []) !!} <br>
                                    {!! Form::select('source_id', $users, null, ['class' => 'form-control select2', 'data-live-search' => 'true',  'placeholder' => __('lang.please_select'), 'id' => 'source_id', 'required', 'data-name' => 'source_id', 'wire:model' => 'source_id']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('payment_status', __('lang.payment_status') . ':*', []) !!}
                                    {!! Form::select('payment_status', $payment_status_array, !empty($recent_stock)&&!empty($recent_stock->payment_status)?$recent_stock->payment_status:'paid', ['class' => 'form-control select2', 'data-live-search' => 'true', 'required',  'placeholder' => __('lang.please_select'), 'data-name' => 'payment_status', 'wire:model' => 'payment_status']) !!}
                                    @error('payment_status')
                                    <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @include('add-stock.partials.payment_form')
                            @if(!empty($amount))
                                <div class="col-md-3 due_amount_div">
                                    <label for="due_amount" style="margin-top: 25px;" >@lang('lang.duePaid'):
                                        <span class="due_amount_span">
                                            @if($paying_currency == 2)
                                                {{$this->sum_dollar_total_cost() - $amount ?? ''}}
                                            @else
                                                {{$this->sum_total_cost() - $amount ?? ''}}
                                            @endif
                                        </span>
                                    </label>
                                </div>
                            @endif
                            @if($payment_status != 'paid' && isset($payment_status) )
                                <div class="col-md-3 due_amount_div">
                                    <div class="form-group">
                                        <label for="due_date">@lang('lang.due'): </label>
                                        <input class="form-control" placeholder="@lang('lang.due')" name="due_date" type="date" id="due_date" autocomplete="off" fdprocessedid="pipnea" wire:model="due_date">
                                    </div>
                                </div>

                                <div class="col-md-3 due_fields ">
                                    <div class="form-group">
                                        {!! Form::label('notify_before_days', __('lang.due_date') . ':', []) !!} <br>
                                        {!! Form::text('notify_before_days', !empty($transaction_payment)&&!empty($transaction_payment->due_date)?@format_date($transaction_payment->due_date):(!empty($payment) ? @format_date($payment->due_date) : null), ['class' => 'form-control', 'placeholder' => __('lang.due_date'), 'wire:model' => 'notify_before_days']) !!}
                                    </div>
                                </div>

{{--                                <div class="col-md-3 due_fields ">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::label('notify_before_days', __('lang.notify_before_days') . ':', []) !!}--}}
{{--                                        <br>--}}
{{--                                        {!! Form::text('notify_before_days', !empty($transaction_payment)&&!empty($transaction_payment->notify_before_days)?$transaction_payment->notify_before_days:(!empty($payment) ? $payment->notify_before_days : null), ['class' => 'form-control', 'placeholder' => __('lang.notify_before_days'), 'wire:model' => 'notify_before_days']) !!}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            @endif
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('notes', __('lang.notes') . ':', []) !!} <br>
                                    {!! Form::textarea('notes', !empty($recent_stock)&&!empty($recent_stock->notes)?$recent_stock->notes:null, ['class' => 'form-control', 'rows' => 3 , 'wire:model' => 'notes']) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" name="submit" id="submit-save" style="margin: 10px" value="save"
                                class="btn btn-primary pull-right btn-flat submit" wire:click.prevent = "store()">@lang( 'lang.save' )</button>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
{{--<!-- This will be printed -->--}}
<section class="invoice print_section print-only" id="receipt_section"> </section>


@push('javascripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            if (message.updateQueue && message.updateQueue.some(item => item.payload.event === 'updated:selectedProducts')) {
                $('.product_selected').on('click', function (event) {
                    event.stopPropagation();
                    var value = $(this).prop('checked');
                    var productId = $(this).val();
                    Livewire.find(component.fingerprint).set('selectedProducts.' + productId, value);
                });
            }
        });
    });
    document.addEventListener('livewire:load', function () {
        Livewire.on('closeModal', function () {
            // Close the modal using Bootstrap's modal API
            $('#select_products_modal').modal('hide');
        });
    });

    document.addEventListener('livewire:load', function () {
        Livewire.on('printInvoice', function (htmlContent) {
            // Set the generated HTML content
            // $("#receipt_section").html(htmlContent);

            // Trigger the print action
            window.print();
        });
    });
    $(document).on("click", "#clear_all_input_form", function () {
        var value = $('#clear_all_input_form').is(':checked')?1:0;
        $.ajax({
            method: "get",
            url: "/create-or-update-system-property/clear_all_input_stock_form/"+value,
            contentType: "html",
            success: function (result) {
                if (result.success) {
                    swal("Success", response.msg, "success");
                }
            },
        });
    });

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
            // $('select.select2').select2();
        });
    });

</script>
@endpush
