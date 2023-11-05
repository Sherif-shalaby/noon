<div class="col-md-2 p-0">
    <div class="card-app">
        <div class="  mt-1 body-card-app pt-2">
            <input type="text" wire:model.defer="client_phone" id="" class="form-control w-60 mb-1"
                placeholder="{{ __('بحث برقم العميل') }}">
            {{--            <input readonly type="text" class="{{ $client ? '' : 'd-none' }} form-control w-25" --}}
            {{--                   value="{{ $client?->name }}"> --}}
            <div class="d-flex justify-content-center align-items-center">
                <button wire:click='getClient' class="w-100 btn btn-sm btn-primary">{{ __('Search') }}</button>
            </div>
        </div>
        {{-- +++++++++++++++++ Customers Dropdown +++++++++++++++++ --}}
        {{-- <div class="mb-1 body-card-app pt-2" wire:ignore>
            <label for="" class="text-primary">العملاء</label>
            <div class="d-flex justify-content-center">
                <select class="form-control client" wire:model="client_id" id="Client_Select" wire:change="refreshSelect">
                    <option  value="0 " readonly selected >اختر </option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-sm ml-2 text-white" style="background-color: #6e81dc;" data-toggle="modal" data-target="#add_customer"><i class="fas fa-plus"></i></button>
            </div>
            @error('client_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            @include('customers.quick_add')
        </div> --}}
        {{-- +++++++++++++++++ الاجماليات +++++++++++++++++ --}}
        <div class="title-card-app text-start text-center">
            الاجماليات
        </div>
        <div class="body-card-app pt-2 d-flex flex-column justify-content-center align-items-center">
            <div style="width: 100%"
                class="row  hide-print @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                @if (!$this->checkRepresentativeUser())
                    <div class="mb-2 col-md-6 p-1">
                        <button data-method="cash" style="width: 100%;font-size: 12px;font-weight: 600" type="button"
                            class="btn btn-success payment-btn px-0" wire:click="submit" id="cash-btn"><i
                                class="fa-solid fa-money-bill"></i>
                            @lang('lang.pay')</button>
                        {{--                            @include('invoices.partials.payment') --}}
                    </div>
                @endif
                <div class="mb-2 col-md-6 p-1">
                    <button style="width: 100%;font-size: 12px;font-weight: 600" type="button"
                        class="btn btn-primary payment-btn px-0" data-toggle="modal" data-target="#draftTransaction"
                        {{--                                     wire:click="getDraftTransactions" --}} id="cash-btn"><i class="fa-solid fa-flag"></i>
                        @lang('lang.view_draft')</button>
                    @include('invoices.partials.draft_transaction')

                </div>
            </div>
            <div style="width: 100%"
                class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                {{-- +++++++++++ الاجمالي بالدولار +++++++++++ --}}
                <div class="col-sm-6 p-1 dollar-cell">
                    <div class="form-group">
                        {!! Form::label('dollar_grand_total', 'الاجمالي بالدولار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('dollar_grand_total', $total_dollar, [
                            'class' => 'form-control',
                            'data-live-search' => 'true',
                            'readonly',
                            'placeholder' => __('lang.dollar_price'),
                            'wire:model' => 'total_dollar',
                        ]) !!}
                    </div>
                </div>
                {{-- +++++++++++ الاجمالي بالدينار +++++++++++ --}}
                <div class="col-sm-6 p-1">
                    <div class="form-group">
                        {!! Form::label('grand_total', 'الاجمالي بالدينار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('grand_total', $total, [
                            'class' => 'form-control',
                            'data-live-search' => 'true',
                            'readonly',
                            'placeholder' => __('lang.price'),
                            'wire:model' => 'total',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div style="width: 100%"
                class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                {{-- +++++++++++ الخصم دولار +++++++++++ --}}
                <div class="col-sm-6 p-1 dollar-cell">
                    <div class="form-group">
                        {!! Form::label('dollar_discount', 'الخصم دولار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('dollar_discount', null, [
                            'class' => 'form-control',
                            '',
                            'wire:model' => 'discount_dollar',
                            'wire:change' => 'changeDollarTotal',
                        ]) !!}
                    </div>
                </div>
                {{-- +++++++++++ الخصم دينار +++++++++++ --}}
                <div class="col-sm-6 p-1">
                    <div class="form-group">
                        {!! Form::label('discount', 'الخصم دينار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('discount', null, [
                            'class' => 'form-control',
                            'wire:model' => 'discount',
                            'wire:change' => 'changeTotal',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div style="width: 100%"
                class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                {{-- +++++++++++ النهائي دولار +++++++++++ --}}
                <div class="col-sm-6 p-1 dollar-cell">
                    <div class="form-group">
                        {!! Form::label('dollar_final_total', 'النهائي دولار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('dollar_final_total', $dollar_final_total, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>
                {{-- +++++++++++ النهائي دينار +++++++++++ --}}
                <div class="col-sm-6 p-1">
                    <div class="form-group">
                        {!! Form::label('final_total', 'النهائي دينار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('final_total', $final_total, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>
            </div>
            <div style="width: 100%"
                class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                {{-- +++++++++++ الواصل دولار +++++++++++ --}}
                <div class="col-sm-6 p-1 dollar-cell">
                    <div class="form-group">
                        {!! Form::label('dollar_amount', 'الواصل دولار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('dollar_amount', null, [
                            'class' => 'form-control',
                            'wire:model' => 'dollar_amount',
                            'wire:change' => 'changeReceivedDollar',
                        ]) !!}
                    </div>
                </div>
                {{-- +++++++++++ الواصل دينار +++++++++++ --}}
                <div class="col-sm-6 p-1">
                    <div class="form-group">
                        {!! Form::label('amount', 'الواصل دينار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('amount', null, [
                            'class' => 'form-control',
                            'wire:model' => 'amount',
                            'wire:change' => 'changeReceivedDinar',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div style="width: 100%"
                class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                {{-- +++++++++++ الباقي دولار +++++++++++ --}}
                <div class="col-sm-6 p-1 dollar-cell">
                    <div class="form-group">
                        {!! Form::label('dollar_remaining', 'الباقي دولار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('dollar_remaining', $dollar_remaining, [
                            'class' => 'form-control',
                            'readonly',
                            'wire:model' => 'dollar_remaining',
                        ]) !!}
                    </div>
                </div>
                {{-- +++++++++++ الباقي دينار +++++++++++ --}}
                <div class="col-sm-6 p-1">
                    <div class="form-group">
                        {!! Form::label('dinar_remaining', 'الباقي دينار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('dinar_remaining', $dinar_remaining, [
                            'class' => 'form-control',
                            'readonly',
                            'wire:model' => 'dinar_remaining',
                        ]) !!}
                    </div>
                </div>
                @if ($this->checkRepresentativeUser())
                    <div class="col-sm-6 p-1">
                        <div class="form-group">
                            {!! Form::label('deliveryman_id', __('lang.deliveryman') . '*', [
                                'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                                'style' => 'width:100%;font-weight: 700;font-size: 10px',
                            ]) !!}
                            {!! Form::select('deliveryman_id', $deliverymen, null, [
                                'class' => 'select2 form-control',
                                'data-live-search' => 'true',
                                'id' => 'deliveryman_id',
                                'placeholder' => __('lang.please_select'),
                                'data-name' => 'deliveryman_id',
                                'wire:model' => 'deliveryman_id',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-sm-6 p-1">
                        <div class="form-group">
                            {!! Form::label('delivery_cost', __('lang.delivery_cost'), [
                                'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                                'style' => 'width:100%;font-weight: 700;font-size: 10px',
                            ]) !!}
                            {!! Form::number('delivery_cost', null, [
                                'class' => 'form-control',
                                'wire:model' => 'delivery_cost',
                                'placeholder' => __('lang.delivery_cost'),
                            ]) !!}
                        </div>
                    </div>
                @endif
            </div>


            {{--            <div class="d-flex align-items-center gap-2 mb-2 justify-content-end"> --}}
            {{--                <label for="" class="text-primary">{{ __('كاش') }}:</label> --}}
            {{--                <input type="number" class="form-control w-50" wire:model="cash" max="{{ $total }}"> --}}
            {{--            </div> --}}
            {{--            <div class="d-flex align-items-center gap-2 mb-2 justify-content-end"> --}}
            {{--                <label for="" class="text-primary"> --}}
            {{--                    {{ __('المتبقى') }} --}}
            {{--                </label> --}}
            {{--                <input type="number" readonly class="form-control w-50" wire:model="rest"> --}}
            {{--            </div> --}}
            {{-- <div class="row hide-print"> --}}
            {{--                <div class="me-auto"> --}}
            {{--                    <div class="btns-control row"> --}}
            {{-- ++++++++++++++++++++++ زرار الدفع ++++++++++++++++++++ --}}
            <div style="width: 100%"
                class="row  hide-print @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="mb-2 col-md-6 p-1">
                    <button data-method="cash" style="width: 100%;font-size: 12px;font-weight: 600" type="button"
                        class="btn btn-warning payment-btn " wire:click="changeStatus" id="cash-btn"><i
                            class="fa-solid fa-flag"></i>
                        @lang('lang.draft')</button>
                    {{--                            @include('invoices.partials.payment') --}}
                </div>
                @if (!$this->checkRepresentativeUser())
                    <div class="mb-2 col-md-6 p-1">
                        <button style="width: 100%;font-size: 12px;font-weight: 600; background: #5b808f" type="button"
                            class="btn btn-primary payment-btn " wire:click="pendingStatus" id="pay-later-btn"><i
                                class="fa fa-hourglass-start"></i>
                            @lang('lang.pay_later')</button>
                        @include('invoices.partials.draft_transaction')
                    </div>
                @endif
            </div>
            {{--                    </div> --}}
            {{--                </div> --}}
            {{-- </div>
            <div class="row hide-print mt-3"> --}}

            {{-- ++++++++++++++++++++++ زرار الدفع السريع++++++++++++++++++++ --}}
            {{-- <div class="col-md-5 mr-2">
                            <button data-method="cash" style="width: 100% ,background: #478299" type="button"
                                    class="btn btn-success payment-btn" wire:click="changeStatus"
                                    id="quick-pay-btn" ><i class="fa-solid fa-money-bill"></i>
                                    @lang('lang.quick_pay')</button>
                        </div> --}}
            {{-- <div class="col-md-5">
                            <button  style="width: 100%; background: #5b808f" type="button"
                                    class="btn btn-primary payment-btn"
                                         wire:click="pendingStatus"
                                        id="pay-later-btn" ><i class="fa fa-hourglass-start"></i>
                                        @lang('lang.pay_later')</button>

                        </div> --}}
            {{-- </div> --}}
        </div>
    </div>
</div>
