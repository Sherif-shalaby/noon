<div class="p-0">
    <div class="card-app">
        <div class=" d-flex flex-row-reverse justify-content-between body-card-app pt-2" style="background-color: #eee">
            <div class="col-md-2"
                style="display: flex;
                        justify-content: center;
                        align-items: center;
                        font-size: 16px;
                        font-weight: 500;">
                الاجماليات
            </div>
            <div class="d-flex justify-content-between align-items-center flex-wrap col-md-10">
                @if ($this->checkRepresentativeUser() && $reprsenative_sell_car)
                    <div class="col-md-1 p-0">
                        <button data-method="cash" style="width: 100%" type="button" class="btn btn-success payment-btn"
                            wire:click="submit" id="cash-btn"><i class="fa-solid fa-money-bill"></i>
                            @lang('lang.pay')</button>
                        {{--                            @include('invoices.partials.payment') --}}
                    </div>
                @endif
                @if (!$this->checkRepresentativeUser())
                    <div class=" col-md-1 p-0 ">
                        <button data-method="cash" style="width: 100%;font-size: 12px;font-weight: 600" type="button"
                            class="btn btn-success payment-btn px-0" wire:click="submit" id="cash-btn"><i
                                class="fa-solid fa-money-bill"></i>
                            @lang('lang.pay')</button>
                        {{--                            @include('invoices.partials.payment') --}}
                    </div>
                @endif

                <div class=" col-md-1 p-0 ">
                    <button style="width: 100%;font-size: 12px;font-weight: 600" type="button"
                        class="btn btn-primary payment-btn px-0" data-toggle="modal" data-target="#draftTransaction"
                        {{--                                     wire:click="getDraftTransactions" --}} id="cash-btn"><i class="fa-solid fa-flag"></i>
                        @lang('lang.view_draft')</button>
                    {{-- @include('invoices.partials.draft_transaction') --}}

                </div>
                <div class=" col-md-1 p-0">
                    <button data-method="cash" style="width: 100%;font-size: 12px;font-weight: 600" type="button"
                        class="btn btn-warning payment-btn " wire:click="changeStatus" id="cash-btn"><i
                            class="fa-solid fa-flag"></i>
                        @lang('lang.draft')</button>
                </div>

                @if (!$this->checkRepresentativeUser())
                    <div class=" col-md-1 p-0">
                        <button style="width: 100%;font-size: 12px;font-weight: 600; background: #5b808f" type="button"
                            class="btn btn-primary payment-btn " onclick="openDueDateModal()" id="pay-later-btn"><i
                                class="fa fa-hourglass-start"></i>
                            @lang('lang.pay_later')</button>
                    </div>
                @endif

                <div class="col-md-2 p-0">
                    <a href="{{ route('recent_transactions') }}"
                        target="_blank"style="width: 100%;font-size: 12px;font-weight: 600;background-color: #ffc107;"
                        type="button" class="btn btn-custom" id="recent-transactionbtn"><i class="dripicons-clock"></i>
                        @lang('lang.recent_transactions')</a>
                </div>

                <div
                    class="col-md-1 p-0 {{ ($dollar_final_total != 0 && $total_dollar != 0 && $back_to_dollar == 0) || $back_to_dollar == 2
                        ? ''
                        : 'd-none' }}">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label mb-0" for="customSwitch1" wire:click="ChangeBillToDinar()"
                            {{ $back_to_dollar == 1 ? 'checked' : '' }}>{{ __('lang.change_bill_to') }}
                            {{ $back_to_dollar == 0 ? __('lang.dinar_c') : __('lang.dollar_c') }}</label>
                    </div>
                    {{-- <button type="button" class="btn btn-success"
                        wire:click="ChangeBillToDinar()">{{ __('lang.change_bill_to_dinar') }}</button> --}}
                </div>

                <div class="col-md-2 ">
                    <button class="btn btn-danger {{ $add_to_balance == '0' ? 'd-none' : '' }}"
                        style="width: 100%;font-size: 12px;font-weight: 600;"
                        wire:click="addToBalance()">{{ __('lang.add_to_balance') }}</button>
                </div>
            </div>
        </div>




        <div class="body-card-app pt-2 pb-0 d-flex flex-wrap justify-content-end align-items-center position-relative">

            <div class="col-md-8 p-0 d-flex justify-content-end">
                @if (!$reprsenative_sell_car)
                    <div class="col-sm-2">
                        {!! Form::label('s', __('lang.deliveryman') . '*', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            {!! Form::select('deliveryman_id', $deliverymen, null, [
                                'class' => 'select2 form-control width-full',
                                'data-live-search' => 'true',
                                'id' => 'deliveryman_id',
                                'placeholder' => __('lang.please_select'),
                                'data-name' => 'deliveryman_id',
                                'wire:model' => 'deliveryman_id',
                            ]) !!}
                        </div>
                    </div>
                @endif
                {{-- +++++++++++ الاجمالي بالدولار +++++++++++ --}}
                <div class="col-sm-2 dollar-cell">
                    <div class="form-group">
                        {!! Form::label('dollar_grand_total', 'الاجمالي بالدولار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('dollar_grand_total', $total_dollar, [
                            'class' => 'form-control p-1',
                            'style' => 'height:30px',
                            'data-live-search' => 'true',
                            'readonly',
                            'placeholder' => __('lang.dollar_price'),
                            'wire:model' => 'total_dollar',
                        ]) !!}
                    </div>
                </div>

                {{-- +++++++++++ الخصم دولار +++++++++++ --}}
                <div class="col-sm-2 dollar-cell">
                    <div class="form-group">
                        {!! Form::label('dollar_discount', 'الخصم دولار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('dollar_discount', null, [
                            'class' => 'form-control p-1',
                            'style' => 'height:30px',
                            'wire:model' => 'discount_dollar',
                            'wire:change' => 'changeDollarTotal',
                        ]) !!}
                    </div>
                </div>

                {{-- +++++++++++ النهائي دولار +++++++++++ --}}
                <div class="col-sm-2 dollar-cell">
                    <div class="form-group">
                        {!! Form::label('dollar_final_total', 'النهائي دولار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('dollar_final_total', $dollar_final_total, [
                            'class' => 'form-control p-1',
                            'style' => 'height:30px',
                            'readonly',
                        ]) !!}
                    </div>
                </div>

                {{-- +++++++++++ الواصل دولار +++++++++++ --}}
                <div class="col-sm-2  dollar-cell">
                    <div class="form-group">
                        {!! Form::label('dollar_amount', 'الواصل دولار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('dollar_amount', null, [
                            'class' => 'form-control p-1',
                            'style' => 'height:30px',
                            'wire:model' => 'dollar_amount',
                            'wire:change' => 'changeReceivedDollar',
                        ]) !!}
                    </div>
                </div>

                {{-- +++++++++++ الباقي دولار +++++++++++ --}}
                <div class="col-sm-2 dollar-cell">
                    <div class="form-group">
                        {!! Form::label('dollar_remaining', 'الباقي دولار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('dollar_remaining', $dollar_remaining, [
                            'class' => 'form-control p-1',
                            'style' => 'height:30px',
                            'readonly',
                            'wire:model' => 'dollar_remaining',
                        ]) !!}
                    </div>
                    <div class="{{ $dollar_remaining > 0 ? '' : 'd-none' }}"
                        title="{{ __('lang.change_remaining_to_dinar') }}">
                        <button class="btn btn-sm btn-danger text-white" type="button"
                            wire:click="changeRemaining()">></button>
                    </div>
                </div>
                @if ($dinar_remaining != 0 || $dollar_remaining != 0)
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('due_date', ' تاريخ الاستحقاق', [
                                'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                                'style' => 'width:100%;font-weight: 700;font-size: 10px',
                            ]) !!}
                            {!! Form::date('due_date', null, [
                                'class' => 'form-control p-1',
                                'style' => 'height:30px',
                                'wire:model' => 'due_date',
                            ]) !!}
                        </div>
                    </div>
                @endif

            </div>

            <div class="col-md-8 p-0 d-flex justify-content-end">
                @if (!$reprsenative_sell_car)
                    <div class="col-sm-2">
                        {!! Form::label('delivery_cost', __('lang.delivery_cost'), [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            {!! Form::number('delivery_cost', null, [
                                'class' => 'form-control initial-balance-input width-full py-1',
                                'style' => 'height:30px',
                                'wire:model' => 'delivery_cost',
                                'placeholder' => __('lang.delivery_cost'),
                            ]) !!}
                        </div>
                    </div>
                @endif
                <div class="col-sm-2">
                    {!! Form::label('representative_id', __('lang.representative') . '*', [
                        'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                        'style' => 'width:100%;font-weight: 700;font-size: 10px',
                    ]) !!}
                    <div class="input-wrapper width-full">
                        {!! Form::select('representative_id', $representatives, null, [
                            'class' => 'select2 form-control',
                            'data-live-search' => 'true',
                            'id' => 'representative_id',
                            'placeholder' => __('lang.please_select'),
                            'data-name' => 'representative_id',
                            'wire:model' => 'representative_id',
                        ]) !!}
                    </div>
                </div>
                {{-- +++++++++++ الاجمالي بالدينار +++++++++++ --}}
                <div class="col-sm-2">
                    <div class="form-group">
                        {!! Form::label('grand_total', 'الاجمالي بالدينار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('grand_total', $total, [
                            'class' => 'form-control p-1',
                            'style' => 'height:30px',
                            'data-live-search' => 'true',
                            'readonly',
                            'placeholder' => __('lang.price'),
                            'wire:model' => 'total',
                        ]) !!}
                    </div>
                </div>

                {{-- +++++++++++ الخصم دينار +++++++++++ --}}
                <div class="col-sm-2">
                    <div class="form-group">
                        {!! Form::label('discount', 'الخصم دينار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('discount', null, [
                            'class' => 'form-control p-1',
                            'style' => 'height:30px',
                        
                            'wire:model' => 'discount',
                            'wire:change' => 'changeTotal',
                        ]) !!}
                    </div>
                </div>

                {{-- +++++++++++ النهائي دينار +++++++++++ --}}
                <div class="col-sm-2">
                    <div class="form-group">
                        {!! Form::label('final_total', 'النهائي دينار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}

                        {!! Form::number('final_total', $final_total, [
                            'class' => 'form-control p-1',
                            'style' => 'height:30px',
                            'readonly',
                        ]) !!}
                    </div>
                </div>

                {{-- +++++++++++ الواصل دينار +++++++++++ --}}
                <div class="col-sm-2">
                    <div class="form-group">
                        {!! Form::label('amount', 'الواصل دينار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('amount', null, [
                            'class' => 'form-control p-1',
                            'style' => 'height:30px',
                            'wire:model' => 'amount',
                            'wire:change' => 'changeReceivedDinar',
                        ]) !!}
                    </div>
                </div>

                {{-- +++++++++++ الباقي دينار +++++++++++ --}}
                <div class="col-sm-2">
                    <div class="form-group">
                        {!! Form::label('dinar_remaining', 'الباقي دينار', [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('dinar_remaining', $dinar_remaining, [
                            'class' => 'form-control p-1',
                            'style' => 'height:30px',
                            'readonly',
                            'wire:model' => 'dinar_remaining',
                        ]) !!}
                    </div>
                </div>
                {{--  --}}

            </div>

            <button class="btn btn-danger position-absolute" style="left: 10px;bottom:10px" wire:click="cancel">
                @lang('lang.close')</button>
        </div>
    </div>
</div>

<script>
    //Function to open the due date modal
    function openDueDateModal() {
        $('#dueDateModal').css('display', 'block');
    }

    // Wait for the document to be ready
    // $(document).ready(function() {
    // Handle the "Submit" button click event
    $('#dueDateModal').on('click', '#submitDueDateBtn', function() {
        // Get the selected due date from the input

        // Close the modal after handling the due date
        $('#dueDateModal').css('display', 'none');
    });
    // Handle the "Close" button click event
    $('#dueDateModal').on('click', '#closeDueDateBtn', function() {
        // Close the modal without performing any action
        $('#dueDateModal').css('display', 'none');
    });

    // });
</script>
