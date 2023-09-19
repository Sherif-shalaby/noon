
<section class="app my-3 no-print" style="margin-top: 35px!important;">
    <div class="container-fluid" >
        {!! Form::open(['route' => 'pos.store','method'=>'post' ]) !!}
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                    {!! Form::select('store_id', $stores, null, ['class' => 'select form-control', 'data-live-search' => 'true', 'required', 'placeholder' => __('lang.please_select'), 'wire:model' => 'store_id']) !!}
                    @error('store_id')
                    <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
{{--            <div class="col-md-2">--}}
{{--                <div class="form-group">--}}
{{--                    {!! Form::label('customer_id', __('lang.customer') . ':*', []) !!}--}}
{{--                    <div class="d-flex justify-content-center">--}}
{{--                        <select class="form-control client select" wire:model="client_id">--}}
{{--                            <option  value="0 " readonly selected >اختر </option>--}}
{{--                            @foreach ($customers as $customer)--}}
{{--                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        <button type="button" class="btn btn-sm ml-2 text-white" style="background-color: #6e81dc;" data-toggle="modal" data-target="#add_customer"><i class="fas fa-plus"></i></button>--}}
{{--                    </div>--}}

{{--                    @error('client_id')<span class="text-danger">{{ $message }}</span>@enderror--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('store_pos_id', __('lang.pos') . ':*', []) !!}
                    {!! Form::select('store_pos_id', $store_pos, null, ['class' => 'select form-control', 'data-live-search' => 'true', 'required', 'placeholder' => __('lang.please_select'), 'wire:model' => 'store_pos_id']) !!}
                    @error('store_pos_id')
                    <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('invoice_lang', __('lang.invoice_lang') . ':', []) !!}
                    {!! Form::select('invoice_lang', $languages + ['ar_and_en' => 'Arabic and English'], null, ['class' => 'form-control select', 'data-live-search' => 'true', 'placeholder' => __('lang.please_select') , 'wire:model' => 'invoice_lang']) !!}
                    @error('invoice_lang')
                    <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('payment_status', __('lang.payment_status') . ':', []) !!}
                    {!! Form::select('payment_status', ['pending' => __('lang.pending'),'paid' => __('lang.paid'), 'partial' => __('lang.partial')],null, ['class' => 'form-control select' , 'data-live-search' => 'true', 'placeholder' => __('lang.please_select'), 'wire:model' => 'payment_status']) !!}
                    @error('payment_status')
                    <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
{{--            <div class="col-md-1">--}}
{{--                <div class="form-group">--}}
{{--                    <button type="button" id="dollar_section" class="btn ml-4" style="margin-top: 15px;background-color: #6e81dc;" wire:click="ShowDollarCol">  </button>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <div class="row g-3 cards hide-print ">
            @include('invoices.partials.products')
            <div class="col-xl-7 special-medal-col">
                <div class="card-app ">
                    <div class="body-card-app content py-2 ">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="body-card-app">
                                <div class="table-responsive box-table ">
                                    <table class="table">
                                        <tr>
                                            <th >@lang('lang.product')</th>
                                            <th >@lang('lang.quantity')</th>
                                            <th >@lang('lang.unit')</th>
                                            <th >@lang('lang.fill')</th>
                                            <th >@lang('lang.total_quantity')</th>
                                            <th >@lang('lang.price')</th>
{{--                                            @if(!empty($showColumn))--}}
                                                <th >@lang('lang.price') $ </th>
                                                <th> @lang('lang.exchange_rate')</th>
{{--                                            @endif--}}
                                            <th >@lang('lang.discount')</th>
                                            <th >@lang('lang.discount_category')</th>
                                            <th >@lang('lang.sub_total')</th>
                                            <th >@lang('lang.sub_total') $</th>
{{--                                            <th> @lang('lang.stores')</th>--}}
                                            <th >@lang('lang.current_stock')</th>
{{--                                            <th style="width: 12%">@lang('lang.exchange_rate')</th>--}}
                                            <th >@lang('lang.action')</th>
                                        </tr>
                                        @php
                                          $total = 0;
                                        @endphp
                                        @foreach ($items as $key => $item)
                                            <tr>
                                                <td >
                                                    {{$item['product']['name']}}
                                                </td>
                                                <td >
                                                    <div class="d-flex align-items-center gap-1 " style="width: 80px">
                                                        <div class=" add-num control-num"
                                                            wire:click="increment({{$key}})">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </div>
                                                        <input class="form-control p-1 text-center" style="width: 50px" type="text" min="1"
                                                            wire:model="items.{{ $key }}.quantity" Wire:change="subtotal({{$key}})">
                                                        @error("items.$key.quantity")
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <div class="decrease-num control-num"
                                                            wire:click="decrement({{ $key }})">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>{{$item['unit_name'] ?? ''}}</td>
                                                <td>{{$item['base_unit_multiplier'] ?? 1}}</td>
                                                <td>{{$item['total_quantity'] ?? 1}}</td>
                                                <td >
                                                    {{$item['price']}}
                                                </td>
{{--                                                @if(!empty($showColumn))--}}
                                                    <td >
                                                        {{ number_format($item['dollar_price'] , 2)}}
                                                    </td>
                                                    <td>
                                                        <input class="form-control p-1 text-center" style="width: 65px" type="text" min="1"
                                                               wire:model="items.{{ $key }}.exchange_rate">
                                                    </td>
{{--                                                @endif--}}

                                                <td >
                                                    <input class="form-control p-1 text-center" style="width: 65px" type="text" min="1" readonly
                                                                              wire:model="items.{{ $key }}.discount_price">
                                                </td>
                                                <td>
                                                    <select class="select discount_category " style="height:30% !important" wire:model="items.{{ $key }}.discount" wire:change="subtotal({{$key}})">
                                                        <option selected value="0.00">select</option>
                                                        @if(!empty($item['discount_categories']))
                                                            @if(!empty($client_id))
                                                                @foreach($item['discount_categories'] as $discount)
                                                                    @if(in_array($client_id, $discount['price_customer_types']))
                                                                    <option value="{{$discount['id']}}" >{{$discount['price_category']}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                @foreach($item['discount_categories'] as $discount)
                                                                        <option value="{{$discount['id']}}">{{$discount['price_category']}}</option>
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </select>
                                                </td>
                                                <td >
                                                    {{ $item['sub_total'] }}
                                                </td>
                                                <td>
                                                    {{$item['dollar_sub_total']}}
                                                </td>
{{--                                                <td>--}}
{{--                                                    <select class="select" style="height:30% !important" wire:model="items.{{ $key }}.store" >--}}
{{--                                                        <option selected value="0.00">select</option>--}}
{{--                                                        @foreach($item['stores'] as $store)--}}
{{--                                                            <option value="{{$store->store->id}}">{{$store->store->name}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                </td>--}}
                                                <td >
                                                    <span class="current_stock"> {{$item['quantity_available']}} </span>
                                                </td>
                                                <td  class="text-center">
                                                    <div class="btn btn-sm btn-success py-0 px-1 my-1"
                                                         wire:click="changePrice({{ $key }})">
                                                        <i class="fas fa-undo"></i>
                                                    </div>
                                                    <div class="btn btn-sm btn-danger py-0 px-1"
                                                        wire:click="delete_item({{ $key }})">
                                                        <i class="fas fa-trash-can"></i>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('invoices.partials.rightSidebar')
        </div>

{{--        <button type="submit" class="btn btn-primary">@lang('lang.save')</button>--}}
        {!! Form::close() !!}
    </div>
</section>


{{--<!-- This will be printed -->--}}
<section class="invoice print_section print-only" id="receipt_section"> </section>
@push('javascripts')
    <script>
        document.addEventListener('livewire:load', function () {
            $('.depart').select().on('change', function (e) {
                @this.set('department_id', $(this).val());
            });
        });
        document.addEventListener('livewire:load', function () {
            $('.client').select();
            // Trigger Livewire updates when the select2 value changes
            $('.client').on('change', function (e) {
            @this.set('client_id', $(this).val());
            });
        });
        document.addEventListener('livewire:load', function () {
            Livewire.on('printInvoice', function (htmlContent) {
                // Set the generated HTML content
                $("#receipt_section").html(htmlContent);
                // Trigger the print action
                window.print("#receipt_section");
            });
        });
        document.addEventListener('livewire:load', function () {
            Livewire.on('hideModal', function ($customer) {
                $(".modal-backdrop").removeClass("show");
                $("#add_customer").removeClass("show");

            });
        });
        document.addEventListener('livewire:load', function () {
            Livewire.on('customerAdded', function ($customer) {
                // Re-render the Livewire component to refresh the <select>
                Livewire.emit('refreshSelect');
            });
        });
    </script>

@endpush
