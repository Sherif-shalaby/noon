
<section class="app my-3" style="margin-top: 100px!important;">
    <div class="container-fluid" >
{{--        <x-messages></x-messages>--}}
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
                    {!! Form::label('invoice_currency', __('lang.invoice_currency') . ':', []) !!}
                    {!! Form::select('invoice_currency', $selected_currencies,null, ['class' => 'form-control select' , 'data-live-search' => 'true', 'placeholder' => __('lang.please_select'), 'wire:model' => 'transaction_currency']) !!}
                    @error('transaction_currency')
                    <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <button type="button" id="dollar_section"class="btn ml-4" style="margin-top: 15px;background-color: #6e81dc;" wire:click="ShowDollarCol">  </button>
                </div>
            </div>
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
                                            <th style="width: 12%">@lang('lang.product')</th>
                                            <th style="width: 15%">@lang('lang.quantity')</th>
                                            <th style="width: 12%">@lang('lang.price')</th>
                                            @if(!empty($showColumn))
                                                <th style="width: 12%">@lang('lang.price') $ </th>
                                            @endif
                                            <th style="width: 12%">@lang('lang.discount')</th>
                                            <th style="width: 12%">@lang('lang.discount_category')</th>
                                            <th style="width: 12%">@lang('lang.sub_total')</th>
                                            <th style="width: 12%">@lang('lang.current_stock')</th>
{{--                                            <th style="width: 12%">@lang('lang.exchange_rate')</th>--}}
                                            <th style="width: 12%">@lang('lang.action')</th>
                                        </tr>
                                        @php
                                          $total = 0;
                                        @endphp
                                        @foreach ($items as $key => $item)
                                            <tr>
                                                <td style="width: 12%">
                                                    {{$item['product']['name']}}
                                                </td>
                                                <td style="width: 15%; text-align: center">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <div class=" add-num control-num"
                                                            wire:click="increment({{$key}})">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </div>
                                                        <input class="form-control p-1 text-center" style="width: 60%" type="text" min="1"
                                                            wire:model="items.{{ $key }}.quantity" Wire:change="subtotal({{$key}})">
                                                        <div class="decrease-num control-num"
                                                            wire:click="decrement({{ $key }})">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 12%">
                                                    {{$item['price']}}
                                                </td>
                                                @if(!empty($showColumn))
                                                    <td style="width: 12%">
                                                        {{ number_format($item['dollar_price'] , 2)}}
                                                    </td>
                                                @endif

                                                <td style="width: 12%">
                                                    <input class="form-control p-1 text-center" style="width: 75%" type="text" min="1" readonly
                                                                              wire:model="items.{{ $key }}.discount_price">
                                                </td>
                                                <td style="width: 12%">
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
                                                <td style="width: 12%">
                                                    {{ $item['sub_total'] }}
                                                </td>
                                                <td style="width: 12%">
                                                    <span class="current_stock"> {{$item['quantity_available']}} </span>
                                                </td>
{{--                                                <td>--}}
{{--                                                    <input class="form-control p-1 text-center" style="width: 75%" type="text" value="{{$item['exchange_rate']}}" readonly>--}}
{{--                                                </td>--}}
                                                <td style="width: 12%" class="text-center">
                                                    <div class="btn btn-sm btn-danger py-0 px-1"
                                                        wire:click="delete_item({{ $key }})">
                                                        <i class="fas fa-trash-can"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php
                                            @endphp
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
    </div>
</section>
@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            $('.depart').select().on('change', function (e) {
                @this.set('department_id', $(this).val());
            });
        });

        document.addEventListener('livewire:load', function () {
            $('.client').select().on('change', function (e) {
                @this.set('client_id', $(this).val());
            });
        });
    </script>

@endpush
