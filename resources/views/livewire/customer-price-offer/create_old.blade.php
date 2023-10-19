
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header d-flex align-items-center">
                        <h4>@lang('lang.customer_price_offer')</h4>
                    </div>
                    <div class="row ">
                        <div class="col-md-9">
                            <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info') </small></p>
                        </div>
                        <div class="col-md-3">
                            <div class="i-checks">
                                <input id="clear_all_input_form" name="clear_all_input_form"
                                       type="checkbox" @if(isset($clear_all_input_stock_form) && $clear_all_input_stock_form == '1') checked @endif
                                       class="">
                                <label for="clear_all_input_form" style="font-size: 0.75rem">
                                    <strong>
                                        @lang('lang.clear_all_input_form')
                                    </strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- {!! Form::open([ 'id' => 'add_st ock_form']) !!} --}}
                    <form action="{{ route('pos.store') }}">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    {{-- ++++++++++++++++++++++ stores filter ++++++++++++++++++++++ --}}
                                    <div class="col-md-4" wire:ignore>
                                        <label for="store_id" class="text-primary">@lang('lang.store')</label>
                                        <div class="d-flex justify-content-center">
                                            <select class="form-control client" wire:model="store_id" id="Client_Select" >
                                                <option  value="0 " readonly selected> {{ __('lang.please_select') }} </option>
                                                @foreach ($stores as $store)
                                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++++ customer filter ++++++++++++++++++++++ --}}
                                    <div class="col-md-4" wire:ignore>
                                        <label for="customer_id" class="text-primary">@lang('lang.customers')</label>
                                        <div class="d-flex justify-content-center">
                                            <select class="form-control client" wire:model="customer_id" id="Client_Select">
                                                <option  value="0 " readonly selected > {{ __('lang.please_select') }} </option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="row">
                                <div class="col-md-8 m-t-15 offset-md-2">
                                    <div class="search-box input-group">
                                        {{-- ++++++++++++++++++++++ search_button ++++++++++++++++++++++ --}}
                                        <button type="button" class="btn btn-secondary" id="search_button"><i
                                                class="fa fa-search"></i>
                                        </button>
                                        <input type="search" name="search_product" id="search_product" wire:model.debounce.500ms="searchProduct"
                                            placeholder="@lang('lang.enter_product_name_to_print_labels')"
                                            class="form-control" autocomplete="off">
                                        {{-- ++++++++++ search_result  ++++++++++ --}}
                                        @if(!empty($search_result))
                                            <ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2" style="top: 37.423px; left: 39.645px; width: 90.2%;">
                                                @foreach($search_result as $product)
                                                    <li class="ui-menu-item" wire:click="add_product({{$product->id}})">
                                                        <div id="ui-id-73" tabindex="-1" class="ui-menu-item-wrapper">
                                                            <img src="https://mahmoud.s.sherifshalaby.tech/uploads/995_image.png" width="50px" height="50px">
                                                            {{$product->sku ?? ''}} - {{$product->name}}
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2 border border-1 mr-3 p-0">
                                    {{-- +++++++++++++++++++++ الأقسام الرئيسيه ++++++++++++++++++++++ --}}
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
                                    {{-- +++++++++++++++++++++ المنتجات +++++++++++++++++++++ --}}
                                    <div class="p-2">
                                        @foreach ($products as $product)
                                            <div class="order-btn" wire:click='add_product({{ $product->id }})' >
                                                <span>{{ $product->name }}</span>
                                                <span>{{ $product->sku }} </span>
                                            </div>
                                            <hr/>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="table-responsive col-md-9 border border-1">
                                    {{-- +++++++++++++++++++++ جدول المنتجات +++++++++++++++++++++ --}}
                                    <table class="table" style="width: auto" >
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="width: 10%" class="col-sm-8">@lang('lang.products')</th>
                                                <th style="width: 10%">@lang('lang.quantity')</th>
                                                {{-- <th style="width: 10%">@lang('lang.purchase_price')$</th>  --}}
                                                <th style="width: 25%">@lang('lang.selling_price')$</th>
                                                {{-- <th style="width: 10%">@lang('lang.sub_total')$</th>  --}}
                                                {{-- <th style="width: 10%">@lang('lang.purchase_price')  </th> --}}
                                                <th style="width: 25%">@lang('lang.selling_price') </th>
                                                {{-- <th style="width: 10%">@lang('lang.sub_total')</th> --}}
                                                {{-- <th style="width: 10%">@lang('lang.cost')$</th>  --}}
                                                <th style="width: 10%">@lang('lang.total_cost')$</th>
                                                {{-- <th style="width: 10%">@lang('lang.cost') </th>  --}}
                                                <th style="width: 10%">@lang('lang.total_cost')</th>
                                                <th style="width: 10%">@lang('lang.delete')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($items))
                                            @foreach($items  as $index => $product)
                                                @include('customer_price_offer.partials.product_row')
                                            @endforeach
                                            <tr>
                                                {{-- +++++++++ Task : "مجموع اجمالي التكاليف" +++++++++ --}}
                                                <td colspan="5" style="text-align: right"> @lang('lang.total')</td>
                                                <td> {{$this->sum_dollar_sub_total()}} </td>
                                                {{-- <td></td>  --}}
                                                {{-- <td></td>
                                                <td> {{$this->sum_sub_total()}} </td>
                                                <td></td> --}}
                                                <td>
                                                    {{$this->sum_dinar_sub_total() ?? 0}}
                                                </td>
                                                {{-- <td></td>
                                                <td  style=";">
                                                    {{$this->sum_total_cost() ?? 0}}
                                                </td> --}}

                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- ++++++++ total_quantity ++++++++++  --}}
                            <div class="col-md-12 text-center mt-1 ">
                                <h4>@lang('lang.items_count'):
                                    <span class="items_count_span" style="margin-right: 15px;">{{!empty($items)? count($items) : 0}}</span>
                                    <br> @lang('lang.items_quantity'): <span
                                        class="items_quantity_span" style="margin-right: 15px;">{{ $this->total_quantity() }}</span>
                                </h4>
                            </div>
                            <br>
                            {{-- ++++++++ total ++++++++++  --}}
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
                            {{-- ++++++++++++++++++++++++++++++++++ الفاتورة ++++++++++++++++++++++++++++++++++ --}}
                            {{-- <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('files', __('lang.files'), []) !!} <br>
                                        <input type="file" name="files[]" id="files"  wire:model="files">
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

                            </div> --}}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{-- ========= block_qty ========= --}}
                                        <div class="i-checks">
                                            <input type="checkbox" id="block_qty" name="block_qty" class="form-control-custom" value="" wire:model="block_qty"/>
                                            <label for="block_qty"><strong>@lang('lang.block_qty')</strong></label>
                                        </div>
                                    </div>
                                </div>
                                {{-- ========= block_for_days ========= --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('block_for_days', __('lang.block_for_days') . ':') !!}
                                        {!! Form::text('block_for_days', 1, ['class' => 'form-control', 'placeholder' => __('lang.block_for_days') , 'wire:model' => 'block_for_days']) !!}
                                    </div>
                                </div>
                                {{-- ========= validity_days ========= --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('validity_days', __('lang.validity_days') . ':') !!}
                                        {!! Form::text('validity_days', null, ['class' => 'form-control', 'placeholder' => __('lang.validity_days') , 'wire:model' => 'validity_days']) !!}
                                    </div>
                                </div>
                                {{-- ========= tax ========= --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tax_method">@lang('lang.tax')</label>
                                        <select class="form-control" name="tax_method" id="tax_method" wire:model='tax_method'>
                                            <option value="" selected>{{ __('lang.please_select') }}</option>
                                            @foreach ($taxes as $tax)
                                                <option data-rate="{{ $tax->rate }}" value="{{ $tax->id }}">
                                                    {{ $tax->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- ========= discount_type ========= --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('discount_type', __('lang.discount_type') . ':') !!}
                                        {!! Form::select('discount_type', ['fixed' => 'Fixed', 'percentage' => 'Percentage'], 'fixed', ['class' => 'form-control', 'placeholder' => __('lang.please_select') , 'data-live-search' => 'true' , 'wire:model' => 'discount_type']) !!}
                                    </div>
                                </div>
                                {{-- ========= discount_value ========= --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('discount_value', __('lang.discount_value') . ':') !!}
                                        {!! Form::text('discount_value', null, ['class' => 'form-control', 'placeholder' => __('lang.discount_value') , 'wire:model' => 'discount_value']) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- ++++++++++++++++++++ submit ++++++++++++++++++++ --}}
                        <div class="col-sm-12">
                            <button type="submit" name="submit" id="submit-save" style="margin: 10px" value="save"
                                    class="btn btn-primary pull-right btn-flat submit" wire:click.prevent = "store()">@lang( 'lang.save' )</button>

                        </div>
                    </form>
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
                    Swal.fire("Success", response.msg, "success");
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

        });
    });

</script>
@endpush
