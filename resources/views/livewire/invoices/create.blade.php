
<section class="app my-3" style="margin-top: 195px!important;">
    <div class="container-fluid" >
        <x-messages></x-messages>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                    {!! Form::select('store_id', $stores, $store_pos->store_id, ['class' => 'select2 form-control', 'data-live-search' => 'true', 'required', 'placeholder' => __('lang.please_select')]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('store_pos_id', __('lang.pos') . ':*', []) !!}
                    {!! Form::select('store_pos_id', $store_poses, $store_pos->name, ['class' => 'select2 form-control', 'data-live-search' => 'true', 'required', 'placeholder' => __('lang.please_select')]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="hidden" name="setting_invoice_lang" id="setting_invoice_lang"
                           value="{{ !empty(App\Models\System::getProperty('invoice_lang')) ? App\Models\System::getProperty('invoice_lang') : 'en' }}">
                    {!! Form::label('invoice_lang', __('lang.invoice_lang') . ':', []) !!}
                    {!! Form::select('invoice_lang', $languages + ['ar_and_en' => 'Arabic and English'], !empty(App\Models\System::getProperty('invoice_lang')) ? App\Models\System::getProperty('invoice_lang') : 'en', ['class' => 'form-control select2', 'data-live-search' => 'true']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('received_currency_id', __('lang.received_currency') . ':', []) !!}
                    {!! Form::select('received_currency_id', $selected_currencies, !empty(App\Models\System::getProperty('currency')) ? App\Models\System::getProperty('currency') : null, ['class' => 'form-control select2', 'data-live-search' => 'true']) !!}
                </div>
            </div>
{{--            <div class="col-md-2">--}}
{{--                <div class="form-group">--}}
{{--                    {!! Form::label('exchange_rate', __('lang.received_currency') . ':', []) !!}--}}
{{--                    {!! Form::text('exchange_rate', null, ['class' => 'form-control']) !!}--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <div class="row g-3 cards hide-print ">
            <div class="col-xl-2 special-col">
                <div class="card-app" >
                    <div class="title-card-app">
                        الأصناف الرئيسية
                        <div for="" class="d-flex align-items-center text-nowrap gap-1" wire:ignore>
                            {{-- الاقسام --}}
                            <select class="form-control depart" wire:model="department_id">
                                <option  value="0 " readonly selected >اختر </option>
                                @foreach ($departments as $depart)
                                    <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="body-card-app">
                        <div class="nav flex-column nav-pills main-tap " id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            {{-- @foreach ($departments as $depart)
                            <button class="nav-link mb-2 {{ $depart->id == $department_id ? 'active' : '' }}"
                                type="button"
                                wire:click='$set("department_id",{{ $depart->id }})'>{{ $depart->name }}</button>
                            @endforeach --}}

                            @if($products and $products != null)
                                @forelse ($products as $product)
                                    <div class="order-btn" wire:click='add_product({{ $product }})' >
                                        @if ($product->image)
                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="img-thumbnail" width="100px">
                                        @else
                                            <img src="{{ asset('uploads/'.$settings['logo']) }}" alt="{{ $product->name }}"
                                                class="img-thumbnail" width="100px">
                                        @endif
                                        <div>
                                            <span>{{ $product->sku }} </span>
                                            <span>{{ $product->name }}</span>
{{--                                            <span class="badge badge-{{ $product->productdetails?->quantity_available < 1 ? 'danger': 'success' }}">--}}
{{--                                                {{ $product->store?->quantity_available < 1 ? __('out_of_stock'): __('available') }}--}}
{{--                                            </span>--}}
                                        </div>
                                    </div>
                                @empty
                                <span>عفوا لايوجد منتجات فى هذا القسم</span>
                                @endforelse
                            @else
                                 <p>جميع المنتجات</p>
                                @foreach ($allproducts as $product)
                                    <div class="order-btn" wire:click='add_product({{ $product }})' >
                                        @if ($product->image)
                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="img-thumbnail" width="100px">
                                        @else
                                            <img src="{{ asset('uploads/'.$settings['logo']) }}" alt="{{ $product->name }}"
                                                class="img-thumbnail" width="100px">
                                        @endif
                                        <div>
                                            <span>{{ $product->sku }} </span>
                                            <span>{{ $product->name }}</span>
                                            {{--                                            <span class="badge badge-{{ $product->productdetails?->quantity_available < 1 ? 'danger': 'success' }}">--}}
{{--                                                {{ $product->productdetails?->quantity_available < 1 ? __('out_of_stock'): __('available') }}--}}
{{--                                            </span>--}}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
                                            <th style="width: 12%">@lang('lang.discount')</th>
                                            <th style="width: 12%">@lang('lang.discount_category')</th>
                                            <th style="width: 12%">@lang('lang.sub_total')</th>
                                            <th style="width: 12%">@lang('lang.current_stock')</th>
                                            <th style="width: 12%">@lang('lang.exchange_rate')</th>
                                            <th style="width: 12%">@lang('lang.action')</th>
                                        </tr>
                                        @php
                                          $total = 0;
                                        @endphp
                                        @foreach ($items as $key => $item)
                                            <tr>
                                                <td style="width: 12%">{{ $item['name'] }}</td>
                                                <td style="width: 15%; text-align: center">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <div class=" add-num control-num"
                                                            wire:click="increment({{ $key }})">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </div>
                                                        <input class="form-control p-1 text-center" style="width: 60%" type="text" min="1"
                                                            wire:model="items.{{ $key }}.quantity">
                                                        <div class="decrease-num control-num"
                                                            wire:click="decrement({{ $key }})">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 12%">{{ $item['price'] }}</td>
                                                <td style="width: 12%">
                                                    <input class="form-control p-1 text-center" style="width: 75%" type="text" min="1" readonly
                                                                              wire:model="items.{{ $key }}.discount">
                                                </td>
                                                <td style="width: 12%">
                                                    <select class="select2 discount_category " style="height:30% !important" wire:model="items.{{ $key }}.discount" wire:change="subtotal({{$key}})">
                                                        <option selected value="0.00">select</option>
                                                        @if(!empty($discounts))
                                                            @if(!empty($client_id))
                                                                @foreach($discounts as $discount)
                                                                    @if(in_array($client_id, $discount->price_customer_types))
                                                                    <option value="{{$discount->price}}">{{$discount->price_category}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                @foreach($discounts as $discount)
                                                                        <option value="{{$discount->price}}">{{$discount->price_category}}</option>
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </select>
                                                </td>
{{--                                                @php--}}
{{--                                                $items[$key]['sub_total'] = ( $items[$key]['price'] * $items[$key]['quantity'] ) -( $items[$key]['quantity'] * $items[$key]['discount'])--}}
{{--                                                @endphp--}}
{{--                                                {{dd($items[$key]['sub_total'])}}--}}
                                                <td style="width: 12%">{{ $item['sub_total'] }} </td>
                                                <td style="width: 12%">
                                                    <span class="current_stock"> {{$item['current_stock']}} </span>
                                                </td>
                                                <td>
                                                    <input class="form-control p-1 text-center" style="width: 75%" type="text" value="{{$item['exchange_rate']}}" readonly>
                                                </td>
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
            <div class="col-xl-3">
                <div class="card-app">
                    <div class="d-flex  align-items-center   mt-1 body-card-app pt-2">
                        <input type="text" wire:model.defer="client_phone" id=""
                            class="form-control w-60" placeholder="{{ __('بحث برقم العميل') }}">
                        <input readonly type="text" class="{{ $client ? '' : 'd-none' }} form-control w-25"
                            value="{{ $client?->name }}">
                        <button wire:click='getClient'
                            class="btn btn-sm btn-primary">{{ __('Search') }}</button>
                    </div>
                    <div class="mb-1 body-card-app pt-2" wire:ignore>
                        <label for="" class="text-primary">العملاء</label>
                        <select class="form-control client" wire:model="client_id">
                            <option  value="0 " readonly selected >اختر </option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        @error('client_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="title-card-app text-start mt-3">
                        الاجماليات
                    </div>
                    <div class="body-card-app pt-2">
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-primary">
                                مبلغ الفاتورة:
                            </label>
                            <input readonly type="number" id="" class="form-control  w-50"
                                value="{{ $price }}">
                        </div>
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-primary">
                                الخصم:
                            </label>
                            <input type="number" name="" id="" value="0.00"
                                class="form-control w-50">
                        </div>
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-primary">
                                الاجمالي بعد الخصم:
                            </label>
                            <input type="number" name="" id="" value="0.00"
                                class="form-control w-50">
                        </div>
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-primary">
                                الضريبة:
                            </label>
                            <input type="number" name="" id="" value="0.00"
                                class="form-control w-50">
                        </div>
                        <div class="d-flex align-items-center mb-2 gap-2 justify-content-end">
                            <label for="" class="text-danger">
                                الاجمالي النهائي:
                            </label>
                            <input type="number" id="" readonly class="form-control text-danger w-50" wire:model="total">
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2 justify-content-end">
                            <label for="" class="text-primary">{{ __('كاش') }}:</label>
                            <input type="number" class="form-control w-50" wire:model="cash" max="{{ $total }}">
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2 justify-content-end">
                            <label for="" class="text-primary">
                                {{ __('المتبقى') }}
                            </label>
                            <input type="number" readonly class="form-control w-50" wire:model="rest">
                        </div>
                        <div class="row hide-print">
                           <div class="col-xl-4 me-auto">
                               <div class=" btns-control row my-3 row-gap-24">
                                   {{-- <div class="col-sm-4">
                                       <button wire:click='submit("cash")' onclick="/*ourprint();*/"
                                           class="btn-sm   btn-success btn fs-12px">
                                           {{ __('دفع') }}
                                       </button>
                                   </div> --}}
                                   <div class="col-sm-4">
                                       <button wire:click='submit("cash")'
                                           class="btn-sm   btn-success btn fs-12px">
                                           {{ __('دفع') }}
                                       </button>
                                   </div>
                               </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            $('.depart').select2().on('change', function (e) {
                @this.set('department_id', $(this).val());
            });
        });
    </script>
    <script>
        document.addEventListener('livewire:load', function () {
            $('.client').select2().on('change', function (e) {
                @this.set('client_id', $(this).val());
            });
        });
    </script>
@endpush
