<section class="app mb-0 mt-0 no-print">

    {!! Form::open(['route' => 'pos.store', 'method' => 'post' , 'id' => 'invoice-form-id']) !!}

    <div class="row justify-content-start @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        <div class="col-md-6 row   @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
            {{-- ++++++++++++++++++++++ مخزن ++++++++++++++++++++++ --}}
            <div class="col-md-2 d-flex mb-2 @if (app()->isLocale('ar')) align-items-end  @else  align-items-start @endif  flex-column animate__animated animate__bounceInLeft"
                style="animation-delay: 1.1s">
                {!! Form::label('store_id', __('lang.store') . '*', [
                'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-1 width-fit' : 'mx-2 mb-1 h5 width-fit',
                'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper mx-2" style="width: 100%">
                    {!! Form::select('store_id', $stores ?? [], $store_id, [
                    'class' => 'select2 form-control',
                    'data-live-search' => 'true',
                    'id' => 'store_id',
                    'required',
                    'placeholder' => __('lang.please_select'),
                    'data-name' => 'store_id',
                    'wire:model' => 'store_id',
                    'wire:change' => 'changeAllProducts',
                    ]) !!}
                </div>
                @error('store_id')
                <span style="font-size: 12px;font-weight: 500;" class="error validation-error text-danger">{{ $message
                    }}</span>
                @enderror
            </div>
            {{-- ++++++++++++++++++++++ نقاط البيع +++++++++++++++++++++ --}}
            <div class="col-md-2 d-flex mb-2 @if (app()->isLocale('ar')) align-items-end  @else  align-items-start @endif   flex-column animate__animated animate__bounceInLeft"
                style="animation-delay: 1.15s">
                {!! Form::label('store_pos_id', __('lang.pos') . '*', [
                'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-1 width-fit' : 'mx-2 mb-1 h5 width-fit',
                'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper mx-2" style="width: 100%">
                    {!! Form::select('store_pos_id', $store_pos, $store_pos_id, [
                    'class' => 'select2 form-control',
                    'data-name' => 'store_pos_id',
                    'data-live-search' => 'true',
                    'required',
                    'placeholder' => __('lang.please_select'),
                    'wire:model' => 'store_pos_id',
                    ]) !!}
                </div>
                @error('store_pos_id')
                <span style="font-size: 12px;font-weight: 500;" class="error validation-error text-danger">{{ $message
                    }}</span>
                @enderror
            </div>
            {{-- +++++++++++++++++ Customers Dropdown +++++++++++++++++ --}}
            @if (empty($toggle_suppliers))
            <div class="col-md-3 d-flex flex-column align-items-end mb-2 customer_drop_down animate__animated animate__bounceInLeft"
                style="animation-delay: 1.2s">
                <label for="" class=" @if (app()->isLocale('ar')) d-block text-end @endif mx-2 h5 mb-1">العملاء</label>
                <div class="input-wrapper mx-2" style="width: 100%">
                    <select class="form-control client select2" style="width: 80%" wire:model="client_id" required
                        id="client_id" data-name="client_id">
                        <option value="0 " readonly>اختر </option>
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $client_id==$customer->id ? 'selected' : '' }}>
                            {{ $customer->name }} - {{ $customer->phone != '[null]' ? $customer->phone : '' }}
                        </option>
                        @endforeach
                    </select>
                    <button type="button" class="add-button d-flex justify-content-center align-items-center"
                        data-toggle="modal" data-target="#add_customer"><i class="fas fa-plus"></i></button>
                </div>

                @error('client_id')
                <span style="font-size: 12px;font-weight: 500;" class="text-danger validation-error">{{ $message
                    }}</span>
                @enderror
            </div>
            @endif
            <div class="col-md-1 justify-content-center d-flex flex-column align-items-end mx-1 mt-2 p-0">
{{--                <button style="width: 100%; background: #5b808f;font-size: 13px;font-weight: 600"--}}
{{--                    wire:click="redirectToCustomerDetails({{ $client_id }})"--}}
{{--                    class="btn btn-primary d-flex justify-content-center align-items-center payment-btn">--}}
{{--                    <i class="fa-solid fa-eye"></i>--}}
{{--                </button>--}}
                <a style="width: 100%; background: #5b808f;font-size: 13px;font-weight: 600"
                   href="{{ route('customers.show',$client_id) }}" class="btn btn-primary d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-eye"></i>
                </a>

            </div>
            <div
                class="col-md-2 d-flex mb-2 @if (app()->isLocale('ar')) align-items-end  @else  align-items-start @endif   flex-column">
                {!! Form::label('invoice_status', __('lang.invoice') . '*', [
                'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-1 width-fit' : 'mx-2 mb-1 h5 width-fit',
                'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper width-full">
                    {!! Form::select(
                    'invoice_status',
                    ['monetary' => __('lang.monetary'), 'deferred_time' => __('lang.deferred_time')],
                    $invoice_status,
                    [
                    'class' => ' form-control',
                    'data-name' => 'invoice_status',
                    'data-live-search' => 'true',
                    'required',
                    'placeholder' => __('lang.please_select'),
                    'wire:model' => 'invoice_status',

                    'wire:change' => 'computeForAll()',
                    ],
                    ) !!}
                    @error('store_pos_id')
                    <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- ++++++++++++++++ Toggle Supplier Dropdown ++++++++++++++ --}}
            <div class="col-md-1  d-flex align-items-center justify-content-center flex-row-reverse p-0">
                <label class=" d-flex align-items-center justify-content-center flex-column p-0">
                    {!! Form::checkbox('toggle_suppliers_dropdown', 1, false, [
                    'wire:model' => 'toggle_suppliers',
                    'wire:change' => 'toggle_suppliers_dropdown',
                    ]) !!}
                    <span class="mx-1 text-center ">

                        @lang('lang.toggle_suppliers_dropdown')
                    </span>
                </label>
            </div>
            {{-- +++++++++++++++++ suppliers Dropdown +++++++++++++++++ --}}
            @if (!empty($toggle_suppliers))
            <div class="col-md-2 d-flex flex-column align-items-end mb-2  p-0 animate__animated animate__bounceInLeft">
                {!! Form::label('supplier_id', __('lang.supplier') . '*', [
                'class' => app()->isLocale('ar') ? 'd-block text-end h5 mx-2 mb-1 width-fit' : 'mx-2 mb-1 h5 width-fit',
                'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper mx-2" style="width: 100%">
                    {!! Form::select('supplier_id', $suppliers, $supplier_id, [
                    'class' => 'form-control select2',
                    'data-live-search' => 'true',
                    'id' => 'supplier_id',
                    'required' => 'required',
                    'placeholder' => __('lang.please_select'),
                    'data-name' => 'supplier',
                    'wire:model' => 'supplier_id',
                    ]) !!}
                    {{-- <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                        data-target=".add-supplier"><i class="fas fa-plus"></i></button> --}}
                </div>
                @error('supplier')
                <span class="error validation-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            @endif
        </div>
        {{-- <div
            class="row col-md-5 justify-content-between mb-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            --}}
            <div class="d-flex col-md-6 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
                style="animation-delay: 1.45s">

                <div class="col-md-2 p-0 d-flex flex-column justify-content-center align-items-center dollar-cell showHideDollarCells "
                    style="border-left: 1px solid #ccc;width: 120px">
                    <span class="d-flex justify-content-center align-items-center"
                        style='width:100%;font-weight: 700;font-size: 12px'>@lang('lang.min_amount_in_dollar')</span>
                    <span
                        class="d-flex justify-content-center align-items-center {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }}"
                        style='width:100%;font-weight: 700;font-size: 12px'>{{ $customer_data->min_amount_in_dollar ?? 0
                        }}</span>
                </div>

                <div class="col-md-2 dollar-cell showHideDollarCells p-0 d-flex flex-column justify-content-center align-items-center "
                    style="border-left: 1px solid #ccc;width: 120px">
                    <span class="d-flex justify-content-center align-items-center"
                        style='width:100%;font-weight: 700;font-size: 12px'> @lang('lang.max_amount_in_dollar')</span>
                    <span
                        class="d-flex justify-content-center align-items-center {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }}s"
                        style='width:100%;font-weight: 700;font-size: 12px'>{{ $customer_data->max_amount_in_dollar ?? 0
                        }}</span>
                </div>

                <div class="col-md-2 p-0 d-flex flex-column justify-content-center align-items-center "
                    style="border-left: 1px solid #ccc;width: 120px">
                    <span class="d-flex justify-content-center align-items-center"
                        style='width:100%;font-weight: 700;font-size: 12px'> @lang('lang.min_amount_in_dinar')</span>
                    <span class="d-flex justify-content-center align-items-center"
                        style='width:100%;font-weight: 700;font-size: 12px'>{{ $customer_data->min_amount_in_dinar ?? 0
                        }}</span>
                </div>

                <div class="col-md-2 p-0 d-flex flex-column justify-content-center align-items-center "
                    style="border-left: 1px solid #ccc;width: 120px">
                    <span class="d-flex justify-content-center align-items-center"
                        style='width:100%;font-weight: 700;font-size: 12px'> @lang('lang.max_amount_in_dinar')</span>
                    <span class="d-flex justify-content-center align-items-center"
                        style='width:100%;font-weight: 700;font-size: 12px'>{{ $customer_data->max_amount_in_dinar ?? 0
                        }}</span>
                </div>

                <div class="col-md-2 p-0 d-flex flex-column justify-content-center align-items-center "
                    style="border-left: 1px solid #ccc;width: 120px">
                    <span class="d-flex justify-content-center align-items-center"
                        style='width:100%;font-weight: 700;font-size: 12px'> @lang('lang.balance_in_dinar')</span>
                    <span class="d-flex justify-content-center align-items-center"
                        style='width:100%;font-weight: 700;font-size: 12px'>{{ $customer_data->balance ?? 0 }}</span>
                </div>

                <div
                    class="col-md-2 p-0 dollar-cell showHideDollarCells d-flex flex-column justify-content-center align-items-center ">
                    <span class="d-flex justify-content-center align-items-center"
                        style='width:100%;font-weight: 700;font-size: 12px'> @lang('lang.balance_in_dollar')</span>
                    <span
                        class="d-flex justify-content-center align-items-center {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }}"
                        style='width:100%;font-weight: 700;font-size: 12px'>{{ $customer_data->dollar_balance ?? 0
                        }}</span>
                </div>
            </div>
            <button></button>
            {{--
        </div> --}}
    </div>


    <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif animate__animated animate__bounceInLeft"
        style="animation-delay: 1.1s">
        <div class="col-md-8 d-flex flex-column">
            <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="col-md-2 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <span class="mx-1" style="font-weight: 500;font-size:12px;"> @lang('lang.customer_type')</span> :
                    <span class="mx-1" style="font-weight: 500;font-size:12px;">{{ $customer_data->customer_type->name
                        ?? '' }}</span>
                </div>
                @php
                if (!empty($customer_data->state_id)) {
                $state = \App\Models\State::find($customer_data->state_id);
                }
                @endphp
                <div class="col-md-2 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <span class="mx-1" style="font-weight: 500;font-size:12px;"> @lang('lang.city') </span> :
                    <span class="mx-1" style="font-weight: 500;font-size:12px;">{{ !empty($city) ? $city->name : ''
                        }}</span>
                </div>
                @php
                if (!empty($customer_data->city_id)) {
                $city = \App\Models\City::find($customer_data->city_id);
                }
                @endphp
                <div class="col-md-3 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <span class="mx-1" style="font-weight: 500;font-size:12px;"> @lang('lang.phone_number') </span> :
                    <span class="mx-1" style="font-weight: 500;font-size:12px;">{{ !empty($customer_data->phone) ?
                        $customer_data->phone : '' }}</span>

                </div>
                <div class="col-md-5 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <span class="mx-1" style="font-weight: 500;font-size:12px;"> @lang('lang.notes') </span> :
                    <span class="mx-1" style="font-weight: 500;font-size:12px;">{{ !empty($customer_data->notes) ?
                        $customer_data->notes : '' }}</span>

                </div>
            </div>

            <div class="d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="col-md-2 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <span class="mx-1" style="font-weight: 500;font-size:12px;"> @lang('lang.state') </span> :
                    <span class="mx-1" style="font-weight: 500;font-size:12px;">
                        {{ !empty($state) ? $state->name : '' }}</span>
                </div>
                @php
                if (!empty($customer_data->quarter_id)) {
                $quarter = \App\Models\Quarter::find($customer_data->quarter_id);
                }
                @endphp
                <div class="col-md-2 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <span class="mx-1" style="font-weight: 500;font-size:12px;"> @lang('lang.quarter')</span> :
                    <span class="mx-1" style="font-weight: 500;font-size:12px;">
                        {{ !empty($quarter) ? $quarter->name : '' }}</span>

                </div>
                <div class="col-md-3 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <span class="mx-1" style="font-size:12px;font-weight: 500;"> @lang('lang.email') </span> :
                    <span class="mx-1" style="font-size:12px;font-weight: 500;">{{ !empty($customer_data->email) ?
                        $customer_data->email : '' }}</span>

                </div>
            </div>

        </div>

        <div class="col-md-4 d-flex">
            {{-- +++++++++++ from_a_to_z , from_z_to_a filter +++++++++++ --}}
            <div class="px-1 col-md-3 mb-2 d-flex align-items-center flex-column">
                {!! Form::label('alphabetical_order_id', __('lang.alphabetical_order') . '*', [
                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : 'mx-2 mb-0 ',
                'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper" style="width: 100%">
                    {!! Form::select(
                    'alphabetical_order_id',
                    [__('lang.from_a_to_z'), __('lang.from_z_to_a')],
                    $alphabetical_order_id,
                    [
                    'class' => 'select2 form-control',
                    'data-live-search' => 'true',
                    'id' => 'alphabetical_order_id',
                    'required',
                    'placeholder' => __('lang.please_select'),
                    'data-name' => 'alphabetical_order_id',
                    'wire:model' => 'alphabetical_order_id',
                    ],
                    ) !!}
                </div>
                @error('alphabetical_order_id')
                <span class="error  text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- +++++++++++ lowest_price , highest_price filter +++++++++++ --}}
            <div class="px-1 col-md-3 mb-2 d-flex align-items-center flex-column">

                {!! Form::label('price_order_id', __('lang.price') . '*', [
                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : 'mx-2 mb-0 ',
                'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper" style="width: 100%">
                    {!! Form::select('price_order_id', [__('lang.lowest_price'), __('lang.highest_price')],
                    $price_order_id, [
                    'class' => 'select2 form-control',
                    'data-live-search' => 'true',
                    'id' => 'price_order_id',
                    'required',
                    'placeholder' => __('lang.please_select'),
                    'data-name' => 'price_order_id',
                    'wire:model' => 'price_order_id',
                    ]) !!}
                </div>
                @error('price_order_id')
                <span class="error validation-error text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- +++++++++++ dollar_lowest_price , dollar_highest_price filter +++++++++++ --}}
            <div class="px-1 col-md-3 mb-2 d-flex align-items-center flex-column dollar-cell showHideDollarCells">

                {!! Form::label('dollar_price_order_id', __('lang.dollar_price') . '*', [
                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : 'mx-2 mb-0 ',
                'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper" style="width: 100%">
                    {!! Form::select(
                    'dollar_price_order_id',
                    [__('lang.dollar_lowest_price'), __('lang.dollar_highest_price')],
                    $dollar_price_order_id,
                    [
                    'class' => 'select2 form-control',
                    'data-live-search' => 'true',
                    'id' => 'dollar_price_order_id',
                    'required',
                    'placeholder' => __('lang.please_select'),
                    'data-name' => 'dollar_price_order_id',
                    'wire:model' => 'dollar_price_order_id',
                    ],
                    ) !!}
                </div>
                @error('dollar_price_order_id')
                <span class="error validation-error text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- +++++++++++ nearest_expiry , longest_expiry filter +++++++++++ --}}
            <div class="px-1 col-md-3 mb-2 d-flex align-items-center flex-column">
                {!! Form::label('expiry_order_id', __('lang.expiry_order') . '*', [
                'class' => app()->isLocale('ar') ? 'd-block text-end mx-2 mb-0 ' : 'mx-2 mb-0 ',
                'style' => 'font-size: 12px;font-weight: 500;',
                ]) !!}
                <div class="input-wrapper" style="width: 100%">

                    {!! Form::select(
                    'expiry_order_id',
                    [__('lang.nearest_expiry_filter'), __('lang.longest_expiry_filter')],
                    $expiry_order_id,
                    [
                    'class' => 'select2 form-control',
                    'data-live-search' => 'true',
                    'id' => 'expiry_order_id',
                    'required',
                    'placeholder' => __('lang.please_select'),
                    'data-name' => 'expiry_order_id',
                    'wire:model' => 'expiry_order_id',
                    ],
                    ) !!}
                </div>

                @error('expiry_order_id')
                <span class="error validation-error text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>


    <!-- Add a modal to your HTML with an input field for due date -->
    <div class="modal" tabindex="-1" role="dialog" id="dueDateModal" wire:ignore>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <label for="dueDate">Due Date:</label>
                    <input type="date" wire:model="due_date" class="form-control" id="dueDate">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitDueDateBtn"
                        wire:click="pendingStatus">Submit</button>
                    <button type="button" class="btn btn-secondary" id="closeDueDateBtn" wire:click="pendingStatus"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>





    <div class="row cards hide-print @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

        @include('invoices.partials.products')

        <div class="col-xl-10 special-medal-col animate__animated animate__bounceInLeft" style="animation-delay: 1.6s">
            <div class="card-app ">
                <div class="body-card-app content py-2 ">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="body-card-app">
                            <div class="table-responsive box-table @if (app()->isLocale('ar')) dir-rtl @endif"
                                style="height: 400px;overflow: scroll">
                                {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes
                                ++++++++++++++++++ --}}
                                <div class="col-md-3 col-lg-12">
                                    <div class="multiselect col-md-12">
                                        <!-- Checkbox for each column -->
                                        <div id="checkboxes">
                                            @foreach ($columnVisibility as $columnName => $visible)
                                            <label for="{{ $columnName }}_id">
                                                <input type="checkbox" id="{{ $columnName }}_id"
                                                    wire:click="toggleColumnVisibility('{{ $columnName }}')"
                                                    class="checkbox_class" {{ $visible ? 'checked' : '' }}>
                                                @if ($columnName == 'dollar_price')
                                                <span>@lang('lang.price') $</span> &nbsp;
                                                @elseif($columnName == 'dollar_sub_total')
                                                <span>@lang('lang.sub_total') $</span> &nbsp;
                                                @else
                                                <span>@lang('lang.' . $columnName)</span> &nbsp;
                                                @endif
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <table class="table">
                                    <tr>
                                        <th @if (!$columnVisibility['sku'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;width: 5%"
                                            @endif
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 5%">
                                            @lang('lang.sku')</th>

                                        <th @if (!$columnVisibility['product'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;width: 5%"
                                            @endif
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 5%">
                                            @lang('lang.product')</th>

                                        <th @if (!$columnVisibility['notes'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;width: 5%"
                                            @endif
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 5%">
                                            @lang('lang.notes')</th>

                                        <th @if (!$columnVisibility['quantity'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;width: 10%"
                                            @endif
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 10%;">
                                            @lang('lang.quantity')</th>

                                        <th @if (!$columnVisibility['extra'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;width: 4%"
                                            @endif
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 4%">
                                            @lang('lang.extra')</th>

                                        <th @if (!$columnVisibility['unit'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;width: 5%"
                                            @endif
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 5%;">
                                            @lang('lang.unit')</th>

                                        <th @if (!$columnVisibility['c_type'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;width: 5%"
                                            @endif
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 5%;">
                                            @lang('lang.c_type')</th>

                                        <th @if (!$columnVisibility['price'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;width: 8%"
                                            @endif
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 8%">
                                            @lang('lang.price')</th>

                                        <th @if (!$columnVisibility['dollar_price'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;width: 8%"
                                            @endif
                                            class="dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }}"
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 8%">
                                            @lang('lang.price') $ </th>

                                        <th @if (!$columnVisibility['exchange_rate'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;width: 8%"
                                            @endif
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 8%">
                                            @lang('lang.exchange_rate')</th>

                                        <th @if (!$columnVisibility['discount'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;width: 9%"
                                            @endif
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 9%">
                                            @lang('lang.discount')</th>

                                        <th @if (!$columnVisibility['discount_category'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;width: 5%"
                                            @endif
                                            style="font-weight: 700;font-size: 10px;text-align: center;width: 5%;">
                                            @lang('lang.discount_category')</th>

                                        <th @if (!$columnVisibility['sub_total'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center"
                                            @endif style="font-weight: 700;font-size: 10px;text-align: center">
                                            @lang('lang.sub_total')</th>

                                        <th @if (!$columnVisibility['dollar_sub_total'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center"
                                            @endif
                                            class="dollar-cell {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }}"
                                            style="font-weight: 700;font-size: 10px;text-align: center">
                                            @lang('lang.sub_total') $</th>

                                        <th @if (!$columnVisibility['current_stock'])
                                            style="display: none;font-weight: 700;font-size: 10px;text-align: center;"
                                            @endif style="font-weight: 700;font-size: 10px;text-align: center">
                                            @lang('lang.current_stock')</th>

                                        <th style="font-weight: 700;font-size: 10px;text-align: center">
                                            @lang('lang.action')</th>
                                    </tr>
                                    @php
                                    $total = 0;
                                    @endphp
                                    @foreach ($items as $key => $item)
                                    <tr style="height: 50px">

                                        <td @if (!$columnVisibility['sku'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right ">
                                            @if (empty($item['variation']))
                                            {{ !empty($item['product']['product_symbol']) ?
                                            $item['product']['product_symbol'] : $item['product']['sku'] }}
                                            @else
                                            {{ $item['unit_sku'] }}
                                            @endif
                                        </td>



                                        <td @if (!$columnVisibility['product'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right ">
                                            <div style="height: 100%;width: 100px;line-break: anywhere"
                                                class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                {{ $item['product']['name'] }}
                                            </div>
                                        </td>
                                        <td @if (!$columnVisibility['notes'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right ">
                                            <div style="height: 100%;min-width: 180px;width: auto;"
                                                class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                <textarea class="form-control  initial-balance-input m-0 p-1"
                                                    style="font-weight: 700;font-size: 10px;min-width: 180px;width: auto;box-sizing: border-box;border: 2px solid #cecece"
                                                    wire:model="items.{{ $key }}.notes"></textarea>
                                            </div>
                                        </td>

                                        <td @if (!$columnVisibility['quantity'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right ">
                                            <div class="d-flex flex-wrap justify-content-center align-items-center text-center"
                                                style="height: 100%;max-width: 100%;">
                                                <div class="d-flex align-items-center gap-1 " style="width: 100px">
                                                    <div class="btn-success add-num control-num d-flex justify-content-center align-items-center"
                                                        style="width: 15px;height: 15px;border-radius: 50%;color: white;cursor:pointer;"
                                                        wire:click="increment({{ $key }})">
                                                        <i style="font-size: 10px;width: 50px;font-weight: 600"
                                                            class="fa-solid fa-plus"></i>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <input
                                                            class="form-control p-1 text-center initial-balance-input mb-0"
                                                            style="width: 60px;font-size: 12px;font-weight: 700;border:2px solid #cecece"
                                                            type="text" min="1" wire:model="items.{{ $key }}.quantity"
                                                            Wire:change="subtotal({{ $key }})">

                                                        @error("items.$key.quantity")
                                                        <span class="text-danger validation-error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="btn-danger decrease-num control-num d-flex justify-content-center align-items-center"
                                                        style="width: 15px;height: 15px;border-radius: 50%;color: white;cursor:pointer;"
                                                        wire:click="decrement({{ $key }})">
                                                        <i style="font-size: 10px;width: 50px;font-weight: 600"
                                                            class="fa-solid fa-minus"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td @if (!$columnVisibility['extra'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right ">
                                            <div style="height: 100%;max-width: 100%;"
                                                class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                {{ $item['extra_quantity'] }}
                                            </div>
                                        </td>

                                        <td @if (!$columnVisibility['unit'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right ">
                                            <div class="d-flex flex-wrap justify-content-center align-items-center text-center"
                                                style="height: 100%;max-width: 100%;">
                                                <div class="input-wrapper width-full">
                                                    <select class="form-control select2"
                                                        style="width:50px;font-size: 10px!important"
                                                        wire:model="items.{{ $key }}.unit_id" data-name="unit_id"
                                                        data-index="{{ $key }}" wire:change="changeUnit({{ $key }})">
                                                        <option value="0.00">@lang('lang.select')</option>
                                                        @if (!empty($item['variation']))
                                                        @foreach ($item['variation'] as $i => $var)
                                                        @if (!empty($var['unit_id']))
                                                        <option value="{{ $var['id'] }}" {{ $i==0 ? 'selected' : '' }}>
                                                            {{ $var['unit']['name'] ?? '' }}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </td>

                                        <td @if (!$columnVisibility['c_type'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right ">
                                            <div class="d-flex flex-wrap justify-content-center align-items-center text-center"
                                                style="height: 100%;max-width: 100%;">
                                                <div class="input-wrapper width-full">

                                                    <select class="form-control select2"
                                                        style="height:30% !important;width:100px;font-size: 10px!important"
                                                        wire:model="items.{{ $key }}.customer_type_id"
                                                        data-name="customer_type_id" data-index="{{ $key }}"
                                                        wire:change="changeCustomerType({{ $key }})">
                                                        <option value="0">@lang('lang.select')</option>
                                                        @if (!empty($item['customer_types']))
                                                        @foreach ($item['customer_types'] as $x => $var)
                                                        @if (!empty($var) && !empty($var['id']))
                                                        <option value="{{ $var['id'] }}" {{ $x==0 ? 'selected' : '' }}>
                                                            {{ $var['name'] ?? '' }}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </td>

                                        <td @if (!$columnVisibility['price'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right ">
                                            <div style="height: 100%;max-width: 100%;"
                                                class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                <input class="form-control initial-balance-input dinarPrice m-0"
                                                    data-key="{{ $key }}" type="text"
                                                    wire:model="items.{{ $key }}.price"
                                                    style="font-weight: 700;font-size: 12px;width: 120px;border: 2px solid #cecece" />
                                                {{-- {{ $item['price'] ?? '' }} --}}
                                            </div>
                                        </td>

                                        <td @if (!$columnVisibility['dollar_price'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right dollar-cell showHideDollarCells {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }}">
                                            <div style="height: 100%;max-width: 100%;"
                                                class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                <input class="form-control initial-balance-input dollarPrice m-0"
                                                    data-key="{{ $key }}" type="text"
                                                    wire:model="items.{{ $key }}.dollar_price"
                                                    style="font-weight: 700;font-size: 10px;width: 65px;border: 2px solid #cecece" />
                                                {{-- {{ number_format($item['dollar_price'] ?? 0, 2) }} --}}
                                            </div>
                                        </td>

                                        <td @if (!$columnVisibility['exchange_rate'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right ">
                                            <div style="height: 100%;max-width: 100%;"
                                                class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                <input
                                                    style="font-weight: 700;font-size: 10px;width: 65px;border: 2px solid #cecece"
                                                    class="form-control m-0 p-1 initial-balance-input text-center ex-rate-cell"
                                                    type="text" min="1" wire:model="items.{{ $key }}.exchange_rate">
                                                @php
                                                $dollar_exchange = App\Models\System::where(
                                                'key',
                                                '=',
                                                'dollar_exchange',
                                                )->get('value');
                                                @endphp
                                                <input
                                                    style="font-weight: 700;font-size: 10px;width: 65px;border: 2px solid #cecece"
                                                    class="form-control initial-balance-input p-1 text-center my-ex-rate-cell"
                                                    type="text" min="1" value="{{ $dollar_exchange[0]['value'] }}">
                                            </div>
                                        </td>

                                        <td @if (!$columnVisibility['discount'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right">
                                            <div style="height: 100%;max-width: 100%;"
                                                class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                <input class="form-control initial-balance-input m-0 p-1 text-center"
                                                       style="font-weight: 700;font-size: 10px;width: 65px;border: 2px solid #cecece" type="text" min="1"
                                                    readonly wire:model="items.{{ $key }}.discount_price">
                                            </div>
                                        </td>

                                        <td @if (!$columnVisibility['discount_category'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right ">
                                            <div class="d-flex flex-wrap justify-content-center align-items-center text-center"
                                                style="height: 100%;max-width: 100%;">

                                                <div class="input-wrapper" style="width: 100%">
                                                    <select class="form-control select2 discount_category "
                                                        style="width:100%;font-size:14px;"
                                                        wire:model="items.{{ $key }}.discount" data-name="discount"
                                                        data-index="{{ $key }}"
                                                        wire:change="subtotal({{ $key }},'discount')">
                                                        <option selected value="0">@lang('lang.select')</option>
                                                        @if (!empty($item['discount_categories']))
                                                        @if (!empty($client_id))
                                                        @foreach ($item['discount_categories'] as $discount)
                                                        @if ($discount['price_category'] !== null)
                                                        {{-- @if (in_array($client_id,
                                                        $discount['price_customer_types'])) --}}
                                                        <option value="{{ $discount['id'] }}">
                                                            {{ $discount['price_category'] }}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                        @else
                                                        @foreach ($item['discount_categories'] as $discount)
                                                        {{-- @if ($discount['price_category'] !== null) --}}
                                                        <option value="{{ $discount['id'] }}">
                                                            {{ $discount['price_category'] ?? '' }}
                                                        </option>
                                                        {{-- @endif --}}
                                                        @endforeach
                                                        @endif
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                        </td>

                                        <td @if (!$columnVisibility['sub_total'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right ">
                                            <div style="height: 100%;max-width: 100%;"
                                                class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                {{ $item['sub_total'] ?? 0 }}
                                            </div>
                                        </td>

                                        <td @if (!$columnVisibility['dollar_sub_total'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right dollar-cell showHideDollarCells {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }}">
                                            <div style="height: 100%;max-width: 100%;"
                                                class="d-flex flex-wrap justify-content-center align-items-center text-center">
                                                {{ $item['dollar_sub_total'] ?? 0 }}
                                            </div>
                                        </td>

                                        <td @if (!$columnVisibility['current_stock'])
                                            style="display: none;font-weight: 700;font-size: 10px;height: 50px;" @endif
                                            style="font-weight: 700;font-size: 10px;height: 50px;"
                                            class="px-1 border-right ">
                                            <span
                                                class="current_stock d-flex flex-wrap justify-content-center align-items-center text-center"
                                                style="font-weight: 700;font-size: 10px;height: 100%;max-width: 100%;">
                                                {{ $item['quantity_available'] }}
                                            </span>
                                        </td>

                                        <td class="text-center px-1 border-right">
                                            <div class="btn btn-sm btn-success py-0 px-1 my-1 {{ $settings['toggle_dollar'] == '1' ? 'd-none' : '' }}"
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
                                    <tr>
                                        @include('invoices.partials.search')
                                    </tr>
                                </table>
                            </div>

                            @include('invoices.partials.rightSidebar')

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('invoices.partials.draft_transaction')

    <div>
        <button class="btn btn-sm btn-danger mx-1" wire:click="getPreviousTransaction">
            < </button>
                <button class="btn btn-sm btn-danger mx-1" disabled wire:click="getNextTransaction">
                    ></button>
    </div>

    {!! Form::close() !!}

</section>
@include('customers.quick_add', ['quick_add' => 1])


{{--
<!-- This will be printed --> --}}
<section class="invoice print_section print-only" id="receipt_section_print"> </section>


@push('javascripts')
@if (empty($store_pos) || empty($stores))
<script>
    document.addEventListener('DOMContentLoaded', function() {
                const noUserPosEvent = new Event('NoUserPos');
                window.dispatchEvent(noUserPosEvent);
            });
</script>
@endif

@if (empty($store_pos))
<script>
    window.addEventListener('NoUserPos', function(event) {
                Swal.fire({
                    title: "{{ __('lang.kindly_assign_pos_for_that_user_to_able_to_use_it') }}" + "<br>",
                    icon: 'error',
                }).then((result) => {
                    window.location.href = "{{ route('home') }}";
                });
            });
</script>
@endif
<script>
    document.addEventListener('livewire:load', function() {
            $('.depart1').select().on('change', function(e) {
                @this.set('department_id1', $(this).val());
            });
        });
        document.addEventListener('livewire:load', function() {
            $('#store_id').select();
            // Trigger Livewire updates when the select2 value changes
            $('#store_id').on('change', function(e) {
                @this.set('store_id', $(this).val());
            });
        });
        document.addEventListener('livewire:load', function() {
            Livewire.on('printInvoice', function(htmlContent) {
                // Set the generated HTML content
                $("#receipt_section_print").html(htmlContent);
                // Trigger the print action
                window.print("#receipt_section_print");
            });
        });
        $(document).on("click", ".print-invoice", function() {
            // $(".modal").modal("hide");
            $.ajax({
                method: "get",
                url: $(this).data("href"),
                data: {},
                success: function(result) {
                    if (result.success) {
                        Livewire.emit('printInvoice', result.html_content);
                        window.location.reload(true)

                    }
                },
            });
        });
        window.addEventListener('quantity_not_enough', function(event) {
            var id = event.detail.id;
            Swal.fire({
                title: "{{ __('lang.out_of_stock') }}" + "<br>",
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: LANG.cancel,
                cancelButtonText: LANG.po,
            }).then((result) => {
                if (result.isConfirmed) {} else {
                    Livewire.emit('create_purchase_order', id);
                }
            });
        });

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

        $(document).on('change', '.dinarPrice', function(e) {
            var key = $(this).data('key');
            Swal.fire({
                'type': 'info',
                'title': 'تأكيد',
                'text': 'هل نريد تغيير السعر بصورة دائمة ؟',
                'showCancelButton': true,
                'confirmButtonText': 'نعم',
                'cancelButtonText': 'إلغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('changeDinarPrice', key);
                } else {
                    Livewire.emit('changePrices', key);
                }
            });

        });




        $(document).on('change', '.dollarPrice', function(e) {
            var key = $(this).data('key');
            Swal.fire({
                'type': 'info',
                'title': 'تأكيد',
                'text': 'هل نريد تغيير السعر بصورة دائمة ؟',
                'showCancelButton': true,
                'confirmButtonText': 'نعم',
                'cancelButtonText': 'إلغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('changeDollarPrice', key);
                } else {
                    Livewire.emit('changePrices', key);
                }
            });

        });
        $(document).on('change', 'select', function(e) {
            var name = $(this).data('name');
            console.log(name)
            if (name != undefined) {
                var index = $(this).data('index');
                var key = $(this).data('key');
                var select2 = $(this);
                Livewire.emit('listenerReferenceHere', {
                    var1: name,
                    var2: select2.select2("val"),
                    var3: index,
                    var4: key
                });
            }
        });
</script>
{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', function() {--}}
{{--        // Select all input elements within the form--}}
{{--        var inputs = document.querySelectorAll('#invoice-form-id input');--}}

{{--        // Add an event listener to each input element--}}
{{--        inputs.forEach(function(input) {--}}
{{--            input.addEventListener('keydown', function(event) {--}}
{{--                if (event.key === 'Enter') {--}}
{{--                    event.preventDefault(); // Prevent default form submission--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

@endpush
