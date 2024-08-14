<div class="animate-in-page">

    <section class="forms">
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-1 mb-1">
                        <div class="card-header d-flex align-items-center  @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif  animate__animated animate__fadeInUp"
                            style="animation-delay: 1.1s">
                            <h6>@lang('lang.add_transfer')</h6>
                        </div>
                        {{-- <div class="row ">
                            <div class="col-md-7">
                                <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info')</small></p>
                            </div>
                        </div> --}}
                        {!! Form::open(['id' => 'add_stock_form', 'wire:submit.prevent' => 'validateItems']) !!}
                        <div class="card-body pt-0">
                            <div class="col-md-12">
                                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                    <div class="col-6 col-md-1 mb-1 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                        style="animation-delay: 1.15s">
                                        {!! Form::label('sender_store_id', __('lang.sender_store') . '*', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 ' : ' mx-2
                                        mb-0 h5 ',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                        ]) !!}
                                        <div class="input-wrapper width-full">

                                            {!! Form::select('sender_store_id', $stores, $sender_store_id, [
                                            'class' => ' form-control select2',
                                            'data-live-search' => 'true',
                                            'required',
                                            'placeholder' => __('lang.please_select'),
                                            'data-name' => 'sender_store_id',
                                            'wire:model' => 'sender_store_id',
                                            'wire:change' => 'check_items_store',
                                            ]) !!}
                                        </div>
                                        @error('store_id')
                                        <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-6 col-md-1 mb-1 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif"
                                        style="animation-delay: 1.15s">
                                        {!! Form::label('receiver_store_id', __('lang.receiver_store') . '*', [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-0 ' : ' mx-2
                                        mb-0 h5 ',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                        ]) !!}
                                        <div class="input-wrapper width-full">

                                            {!! Form::select('receiver_store_id', $stores, null, [
                                            'class' => 'form-control select2',
                                            'data-live-search' => 'true',
                                            'wire:model' => 'receiver_store_id',
                                            'id' => 'receiver_store_id',
                                            'placeholder' => __('lang.please_select'),
                                            'data-name' => 'receiver_store_id',
                                            ]) !!}
                                        </div>
                                        @error('supplier')
                                        <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 m-t-15">
                                        <div class="search-box input-group">
                                            <input type="search" name="search_by_product_symbol"
                                                id="search_by_product_symbol"
                                                wire:model.debounce.200ms="search_by_product_symbol"
                                                placeholder="@lang('lang.enter_product_symbol')" class="form-control"
                                                autocomplete="off">

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
                                                        {{ $product->product_symbol ?? '' }} -
                                                        {{ $product->name }}
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
                                                wire:model.debounce.200ms="searchProduct"
                                                placeholder="@lang('lang.enter_product_name_to_print_labels')"
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
                            </div>
                            <div class="row">
                                <div class="col-md-2 border border-1 p-0 animate__animated animate__lightSpeedInLeft"
                                    style="height: 90vh;overflow: scroll;animation-delay: 1.35s">
                                    <div class="p-3 text-center font-weight-bold " style="background-color: #eee;">
                                        الأقسام الرئيسيه
                                        <div for="" class="d-flex align-items-center text-nowrap gap-1" wire:ignore>
                                            {{-- الاقسام --}}
                                            <select class="form-control select2" data-name="department_id"
                                                wire:model="department_id">
                                                <option value="" readonly selected>اختر </option>
                                                @foreach ($departments as $depart)
                                                @if ($depart->parent_id === null)
                                                <option value="{{ $depart->id }}">{{ $depart->name }}
                                                </option>
                                                {{-- @if ($depart->subCategories->count() > 0)
                                                @include('categories.category-select', ['categories' =>
                                                $depart->subCategories, 'prefix' => '-'])
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
                                <div class="table-responsive col-md-10 border m-0 p-0 border-1 animate__animated animate__lightSpeedInRight  @if (app()->isLocale('ar')) dir-rtl @endif"
                                    style="height: 90vh;overflow: scroll;animation-delay: 1.35s">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="width: 10%" class="col-sm-8">@lang('lang.products')</th>
                                                <th style="width: 10%">@lang('lang.sku')</th>
                                                <th style="width: 10%">@lang('lang.quantity')</th>
                                                <th style="width: 10%">@lang('lang.unit')</th>
                                                <th style="width: 10%" class="dollar-cell showHideDollarCells">
                                                    @lang('lang.purchase_price')$</th>
                                                {{-- <th style="width: 10%">@lang('lang.selling_price')$</th> --}}
                                                <th style="width: 10%" class="dollar-cell showHideDollarCells">
                                                    @lang('lang.sub_total')$</th>
                                                <th style="width: 10%">@lang('lang.purchase_price') </th>
                                                {{-- <th style="width: 10%">@lang('lang.selling_price') </th> --}}
                                                <th style="width: 10%">@lang('lang.sub_total')</th>
                                                <th style="width: 10%">@lang('lang.new_stock')</th>
                                                <th style="width: 10%">@lang('lang.current_stock')</th>
                                                <th style="width: 10%">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($items))
                                            @foreach ($items as $index => $product)
                                            @include('store_transfer.partials.product_row')
                                            @endforeach
                                            <tr>
                                                <td colspan="7" style="text-align: right"> @lang('lang.total')
                                                </td>
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
                            <div class="col-md-12 d-flex justify-content-between text-center mt-1 animate__animated animate__lightSpeedInLeft"
                                style="animation-delay: 1.4s">
                                <h4>@lang('lang.items_count'):
                                    <span class="items_count_span" style="margin-right: 15px;">{{ count($items)
                                        }}</span>
                                </h4>
                                <h4>

                                    @lang('lang.items_quantity'):
                                    <span class="items_quantity_span" style="margin-right: 15px;">{{
                                        $this->total_quantity() }}</span>
                                </h4>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between text-center mt-1 animate__animated animate__lightSpeedInLeft"
                                style="animation-delay: 1.45s">
                                <h3> @lang('lang.total') $:
                                    {{ $this->sum_dollar_sub_total() ?? 0.0 }}
                                </h3>
                                <h3>
                                    @lang('lang.total') :
                                    {{ $this->sum_sub_total() ?? 0.0 }}
                                    <span class="final_total_span"></span>
                                </h3>
                            </div>
                            <div class="row justify-content-between animate__animated animate__bounceInLeft @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                                style="animation-delay: 1.5s;">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {!! Form::label('files', __('lang.files'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end h5 mb-0 ' : ' mb-0 h5 ',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                        ]) !!}
                                        <input type="file" name="files[]" id="files" wire:model="files">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::label('notes', __('lang.notes'), [
                                        'class' => app()->isLocale('ar') ? 'd-block text-end h5 mb-0 ' : ' mb-0 h5 ',
                                        'style' => 'font-size: 12px;font-weight: 500;',
                                        ]) !!}
                                        {{-- {!! Form::textarea(
                                        'notes',
                                        !empty($recent_stock) && !empty($recent_stock->notes) ? $recent_stock->notes :
                                        null,
                                        ['class' => 'form-control', 'rows' => 3, 'wire:model' => 'notes'],
                                        ) !!} --}}
                                        <textarea name="notes" class="form-control initial-balance-input width-full"
                                            rows="3" wire:model="notes">
                                            {{ !empty($recent_stock) && !empty($recent_stock->notes) ? $recent_stock->notes : '' }}
                                                </textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12 animate__animated animate__lightSpeedInLeft px-4"
                            style="animation-delay: 1.55s">
                            <button type="submit" name="submit" id="submit-save" value="save"
                                class="btn btn-primary pull-right btn-flat submit mb-2"
                                wire:click.prevent="store()">@lang('lang.save')</button>

                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
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
