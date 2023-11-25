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
            <div class="d-flex justify-content-between align-items-center">
                @if ($this->checkRepresentativeUser() && $reprsenative_sell_car)
                    <div class="col-md-4">
                        <button data-method="cash" style="width: 100%" type="button" class="btn btn-success payment-btn"
                            wire:click="submit" id="cash-btn"><i class="fa-solid fa-money-bill"></i>
                            @lang('lang.pay')</button>
                        {{--                            @include('invoices.partials.payment') --}}
                    </div>
                @endif
                @if (!$this->checkRepresentativeUser())
                    <div class=" col-md-4 ">
                        <button data-method="cash" style="width: 100%;font-size: 12px;font-weight: 600" type="button"
                            class="btn btn-success payment-btn px-0" wire:click="submit" id="cash-btn"><i
                                class="fa-solid fa-money-bill"></i>
                            @lang('lang.pay')</button>
                        {{--                            @include('invoices.partials.payment') --}}
                    </div>
                @endif

                <div class=" col-md-4 ">
                    <button style="width: 100%;font-size: 12px;font-weight: 600" type="button"
                        class="btn btn-primary payment-btn px-0" data-toggle="modal" data-target="#draftTransaction"
                        {{--                                     wire:click="getDraftTransactions" --}} id="cash-btn"><i class="fa-solid fa-flag"></i>
                        @lang('lang.view_draft')</button>
                    {{-- @include('invoices.partials.draft_transaction') --}}

                </div>
                <div class=" col-md-4">
                    <button data-method="cash" style="width: 100%;font-size: 12px;font-weight: 600" type="button"
                        class="btn btn-warning payment-btn " wire:click="changeStatus" id="cash-btn"><i
                            class="fa-solid fa-flag"></i>
                        @lang('lang.draft')</button>
                </div>

                @if (!$this->checkRepresentativeUser())
                    <div class=" col-md-4">
                        <button style="width: 100%;font-size: 12px;font-weight: 600; background: #5b808f" type="button"
                            class="btn btn-primary payment-btn " wire:click="pendingStatus" id="pay-later-btn"><i
                                class="fa fa-hourglass-start"></i>
                            @lang('lang.pay_later')</button>
                    </div>
                @endif

                <div class="col-md-4">
                    <button style="background-color: #ffc107;" type="button" class="btn btn-custom"
                        id="recent-transaction-btn"><i class="dripicons-clock"></i>
                        @lang('lang.recent_transactions')</button>
                </div>
            </div>
        </div>




        <div class="body-card-app pt-2 d-flex flex-wrap justify-content-end align-items-center">

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
                {{-- @if ($this->checkRepresentativeUser() && !$reprsenative_sell_car) --}}
                <div class="col-sm-2">
                    <div class="form-group">
                        {!! Form::label('delivery_cost', __('lang.delivery_cost'), [
                            'class' => app()->isLocale('ar') ? 'text-end text-primary' : 'text-start text-primary',
                            'style' => 'width:100%;font-weight: 700;font-size: 10px',
                        ]) !!}
                        {!! Form::number('delivery_cost', null, [
                            'class' => 'form-control py-1',
                            'style' => 'height:30px',
                            'wire:model' => 'delivery_cost',
                            'placeholder' => __('lang.delivery_cost'),
                        ]) !!}
                    </div>
                </div>
                {{-- @endif --}}
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
<!-- recent transaction modal -->
<div id="recentTransaction" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal text-left">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 65%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('lang.recent_transactions')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    id="closeRecentTransactionModal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 modal-filter">
                    <div class="row">
                        {{-- <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('start_date', __('lang.start_date'), []) !!}
                            {!! Form::text('start_date', null, ['class' => 'form-control filter_transactions', 'id' => 'rt_start_date']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('end_date', __('lang.end_date'), []) !!}
                            {!! Form::text('end_date', null, ['class' => 'form-control filter_transactions', 'id' => 'rt_end_date']) !!}
                        </div>
                    </div> --}}
                        {{-- <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('rt_customer_id', __('lang.customer'), []) !!}
                            {!! Form::select('customer_id', $customers_rt, false, ['class' => 'form-control filter_transactions selectpicker', 'id' => 'rt_customer_id', 'data-live-search' => 'true', 'placeholder' => __('lang.all'),'wire:model' => 'customer_id','wire:change' => 'refreshComponent',]) !!}
                        </div>
                    </div> --}}
                        {{-- <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('rt_method', __('lang.payment_type'), []) !!}
                            {!! Form::select('rt_method', $payment_types, request()->method, ['class' => 'form-control filter_transactions', 'placeholder' => __('lang.all'), 'data-live-search' => 'true', 'id' => 'rt_method']) !!}
                        </div>
                    </div> --}}
                        {{-- <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('rt_created_by', __('lang.cashier'), []) !!}
                            {!! Form::select('rt_created_by', $cashiers, false, ['class' => 'form-control selectpicker filter_transactions', 'id' => 'rt_created_by', 'data-live-search' => 'true', 'placeholder' => __('lang.all'),'wire:model' => 'created_by','wire:change' => 'refreshComponent',]) !!}
                        </div>
                    </div> --}}
                        {{-- <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('rt_deliveryman_id', __('lang.deliveryman'), []) !!}
                            {!! Form::select('rt_deliveryman_id', $delivery_men, null, ['class' => 'form-control sale_filter filter_transactions', 'placeholder' => __('lang.all'), 'data-live-search' => 'true', 'id' => 'rt_deliveryman_id']) !!}
                        </div>
                    </div> --}}
                    </div>
                </div>

                <div class="col-md-12">
                    @include('invoices.partials.recent_transactions')
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="closeRecentTransactionModal"
                    data-dismiss="modal">@lang('lang.close')</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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
    $(document).on("click", "#recent-transaction-btn", function() {
        $("#recentTransaction").modal("show");
    });
    $(document).on("click", "#closeRecentTransactionModal", function() {
        $("#recentTransaction").modal("hide");
    });
    // });
</script>
