<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-1">
                    <div class="card-header d-flex align-items-center">
                        <h6>@lang('lang.add_transfer') {{ $receiver_store_name }}</h6>
                    </div>
                    <div class="row ">
                        {{-- <div class="col-md-7">
                            <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info')</small></p>
                        </div> --}}
                        {{--                        <div class="col-md-3"> --}}
                        {{--                            <div class="i-checks"> --}}
                        {{--                                <input id="clear_all_input_form" name="clear_all_input_form" --}}
                        {{--                                       type="checkbox" @if (isset($clear_all_input_stock_form) && $clear_all_input_stock_form == '1') checked @endif --}}
                        {{--                                       class=""> --}}
                        {{--                                <label for="clear_all_input_form" style="font-size: 0.75rem"> --}}
                        {{--                                    <strong> --}}
                        {{--                                        @lang('lang.clear_all_input_form') --}}
                        {{--                                    </strong> --}}
                        {{--                                </label> --}}
                        {{--                            </div> --}}
                        {{--                        </div> --}}
                    </div>
                    {!! Form::open(['id' => 'add_stock_form', 'wire:submit.prevent' => 'validateItems']) !!}
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    {!! Form::label('sender_store_id', __('lang.sender_store') . ':*', []) !!}
                                    {!! Form::select('sender_store_id', $stores, $sender_store_id, [
                                        'class' => ' form-control select2',
                                        'data-live-search' => 'true',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'data-name' => 'sender_store_id',
                                        'wire:model' => 'sender_store_id',
                                        'wire:change' => 'check_items_store',
                                    ]) !!}
                                    @error('store_id')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('receiver_store_id', __('lang.receiver_store') . ':*', []) !!}
                                    {!! Form::text('receiver_store_id', $receiver_store_name, [
                                        'class' => 'form-control',
                                        'readonly',
                                        'data-live-search' => 'true',
                                        'id' => 'receiver_store_id',
                                        'placeholder' => __('lang.please_select'),
                                    ]) !!}
                                    @error('supplier')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3 m-t-15">
                                <div class="search-box input-group">
                                    <input type="search" name="search_by_product_symbol" id="search_by_product_symbol"
                                        wire:model.debounce.200ms="search_by_product_symbol"
                                        placeholder="@lang('lang.enter_product_symbol')" class="form-control" autocomplete="off">

                                    @if (!empty($search_result) && !empty($search_by_product_symbol))
                                        <ul id="ui-id-1" tabindex="0"
                                            class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2"
                                            style="top: 37.423px; left: 39.645px; width: 90.2%;">
                                            @foreach ($search_result as $product)
                                                <li class="ui-menu-item" wire:click="add_product({{ $product->id }})">
                                                    <div id="ui-id-73" tabindex="-1" class="ui-menu-item-wrapper">
                                                        @if ($product->image)
                                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                                alt="{{ $product->name }}" class="img-thumbnail"
                                                                width="100px">
                                                        @else
                                                            <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                                                alt="{{ $product->name }}" class="img-thumbnail"
                                                                width="100px">
                                                        @endif
                                                        {{ $product->product_symbol ?? '' }} - {{ $product->name }}
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-7 m-t-15">
                                <div class="search-box input-group">
                                    <button type="button" class="btn btn-secondary" id="search_button"><i
                                            class="fa fa-search"></i>
                                    </button>
                                    <input type="search" name="search_product" id="search_product"
                                        wire:model.debounce.200ms="searchProduct" placeholder="@lang('lang.enter_product_name_to_print_labels')"
                                        class="form-control" autocomplete="off">
                                    @if (!empty($search_result) && !empty($searchProduct))
                                        <ul id="ui-id-1" tabindex="0"
                                            class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2"
                                            style="top: 37.423px; left: 39.645px; width: 90.2%;">
                                            @foreach ($search_result as $product)
                                                <li class="ui-menu-item" wire:click="add_product({{ $product->id }})">
                                                    <div id="ui-id-73" tabindex="-1" class="ui-menu-item-wrapper">
                                                        @if ($product->image)
                                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                                alt="{{ $product->name }}" class="img-thumbnail"
                                                                width="100px">
                                                        @else
                                                            <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                                                alt="{{ $product->name }}" class="img-thumbnail"
                                                                width="100px">
                                                        @endif
                                                        {{ $product->sku ?? '' }} - {{ $product->name }}
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
                                <div class="p-3 text-center font-weight-bold " style="background-color: #eee;">
                                    الأقسام الرئيسيه
                                    <div for="" class="d-flex align-items-center text-nowrap gap-1" wire:ignore>
                                        {{-- الاقسام --}}
                                        <select class="form-control select2" data-name="department_id"
                                            wire:model="department_id">
                                            <option value="" readonly selected>اختر </option>
                                            @foreach ($departments as $depart)
                                                @if ($depart->parent_id === null)
                                                    <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                                    {{-- @if ($depart->subCategories->count() > 0)
                                                        @include('categories.category-select', ['categories' => $depart->subCategories, 'prefix' => '-'])
                                                    @endif --}}
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="p-2">
                                    @foreach ($products as $product)
                                        <div class="order-btn" wire:click='add_product({{ $product->id }})'
                                            style="cursor: pointer">
                                            <span>{{ $product->name }}</span>
                                            <span>{{ $product->sku }} </span>
                                        </div>
                                        <hr />
                                    @endforeach
                                </div>
                            </div>
                            <div class="table-responsive col-md-9 border border-1">
                                <table class="table" style="width: auto">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="width: 10%" class="col-sm-8">@lang('lang.products')</th>
                                            <th style="width: 10%">@lang('lang.sku')</th>
                                            <th style="width: 10%">@lang('lang.quantity')</th>
                                            <th style="width: 10%">@lang('lang.unit')</th>
                                            <th style="width: 10%">@lang('lang.purchase_price')$</th>
                                            <th style="width: 10%">@lang('lang.selling_price')$</th>
                                            <th style="width: 10%">@lang('lang.sub_total')$</th>
                                            <th style="width: 10%">@lang('lang.purchase_price') </th>
                                            <th style="width: 10%">@lang('lang.selling_price') </th>
                                            <th style="width: 10%">@lang('lang.sub_total')</th>
                                            <th style="width: 10%">@lang('lang.new_stock')</th>
                                            <th style="width: 10%">@lang('lang.current_stock')</th>
                                            <th style="width: 10%">@lang('lang.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($items))
                                            @foreach ($items as $index => $product)
                                                @include('transfer.partials.product_row')
                                            @endforeach
                                            <tr>
                                                <td colspan="7" style="text-align: right"> @lang('lang.total')</td>
                                                <td> {{ $this->sum_dollar_sub_total() }} </td>
                                                <td></td>
                                                <td></td>
                                                <td> {{ $this->sum_sub_total() }} </td>
                                                <td></td>
                                                <td></td>

                                                <td></td>

                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 text-center mt-1 ">
                            <h4>@lang('lang.items_count'):
                                <span class="items_count_span"
                                    style="margin-right: 15px;">{{ count($items) }}</span><br>
                                @lang('lang.items_quantity'):
                                <span class="items_quantity_span"
                                    style="margin-right: 15px;">{{ $this->total_quantity() }}</span>
                            </h4>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="col-md-3 offset-md-8 text-right">
                                <h3> @lang('lang.total') $:
                                    {{ $this->sum_dollar_sub_total() ?? 0.0 }} <br>
                                    @lang('lang.total') :
                                    {{ $this->sum_sub_total() ?? 0.0 }}
                                    <span class="final_total_span"></span>
                                </h3>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('files', __('lang.files'), []) !!} <br>
                                    <input type="file" name="files[]" id="files" wire:model="files">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('notes', __('lang.notes') . ':', []) !!} <br>
                                    {!! Form::textarea(
                                        'notes',
                                        !empty($recent_stock) && !empty($recent_stock->notes) ? $recent_stock->notes : null,
                                        ['class' => 'form-control', 'rows' => 3, 'wire:model' => 'notes'],
                                    ) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" name="submit" id="submit-save" style="margin: 10px" value="save"
                            class="btn btn-primary pull-right btn-flat submit"
                            wire:click.prevent = "store()">@lang('lang.save')</button>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@push('javascripts')
    <script>
        $(document).ready(function() {
            $('.select2').on('change', function(e) {
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
