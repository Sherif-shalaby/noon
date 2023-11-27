<div class="col-xl-2">
    <div class="card-app">
        <div class="d-flex  align-items-center   mt-1 body-card-app pt-2">
            <input type="text" wire:model.defer="client_phone" id="" class="form-control w-60"
                placeholder="{{ __('بحث برقم العميل') }}">
            {{--            <input readonly type="text" class="{{ $client ? '' : 'd-none' }} form-control w-25" --}}
            {{--                   value="{{ $client?->name }}"> --}}
            <button wire:click='getClient' class="btn btn-sm btn-primary">{{ __('Search') }}</button>
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
        <div class="title-card-app text-start mt-3">
            الاجماليات
        </div>
        <div class="body-card-app pt-2">
            <div class="row ">
                {{-- +++++++++++ الاجمالي بالدولار +++++++++++ --}}
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('dollar_grand_total', 'الاجمالي بالدولار', ['class' => 'text-primary']) !!}
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
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('grand_total', 'الاجمالي بالدينار', ['class' => 'text-primary']) !!}
                        {!! Form::number('grand_total', $total, [
                            'class' => 'form-control',
                            'data-live-search' => 'true',
                            'readonly',
                            'placeholder' => __('lang.price'),
                            'wire:model' => 'total',
                        ]) !!}
                    </div>
                </div>
                {{-- +++++++++++ الخصم دولار +++++++++++ --}}
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('dollar_discount', 'الخصم دولار', ['class' => 'text-primary']) !!}
                        {!! Form::number('dollar_discount', null, [
                            'class' => 'form-control',
                            '',
                            'wire:model' => 'discount_dollar',
                            'wire:change' => 'changeDollarTotal',
                        ]) !!}
                    </div>
                </div>
                {{-- +++++++++++ الخصم دينار +++++++++++ --}}
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('discount', 'الخصم دينار', ['class' => 'text-primary']) !!}
                        {!! Form::number('discount', null, [
                            'class' => 'form-control',
                            'wire:model' => 'discount',
                            'wire:change' => 'changeTotal',
                        ]) !!}
                    </div>
                </div>
                {{-- +++++++++++ النهائي دولار +++++++++++ --}}
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('dollar_final_total', 'النهائي دولار', ['class' => 'text-primary']) !!}
                        {!! Form::number('dollar_final_total', $dollar_final_total, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>
                {{-- +++++++++++ النهائي دينار +++++++++++ --}}
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('final_total', 'النهائي دينار', ['class' => 'text-primary']) !!}
                        {!! Form::number('final_total', $final_total, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>
                {{-- +++++++++++ الواصل دولار +++++++++++ --}}
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('dollar_amount', 'الواصل دولار', ['class' => 'text-primary']) !!}
                        {!! Form::number('dollar_amount', null, [
                            'class' => 'form-control',
                            'wire:model' => 'dollar_amount',
                            'wire:change' => 'changeReceivedDollar',
                        ]) !!}
                    </div>
                </div>
                {{-- +++++++++++ الواصل دينار +++++++++++ --}}
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('amount', 'الواصل دينار', ['class' => 'text-primary']) !!}
                        {!! Form::number('amount', null, [
                            'class' => 'form-control',
                            'wire:model' => 'amount',
                            'wire:change' => 'changeReceivedDinar',
                        ]) !!}
                    </div>
                </div>
                {{-- +++++++++++ الباقي دولار +++++++++++ --}}
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('dollar_remaining', 'الباقي دولار', ['class' => 'text-primary']) !!}
                        {!! Form::number('dollar_remaining', $dollar_remaining, [
                            'class' => 'form-control',
                            'readonly',
                            'wire:model' => 'dollar_remaining',
                        ]) !!}
                    </div>
                </div>
                {{-- +++++++++++ الباقي دينار +++++++++++ --}}
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('dinar_remaining', 'الباقي دينار', ['class' => 'text-primary']) !!}
                        {!! Form::number('dinar_remaining', $dinar_remaining, [
                            'class' => 'form-control',
                            'readonly',
                            'wire:model' => 'dinar_remaining',
                        ]) !!}
                    </div>
                </div>
                @if($dinar_remaining != 0 || $dollar_remaining  != 0) 
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('due_date', ' تاريخ الاستحقاق', ['class' => 'text-primary']) !!}
                            {!! Form::date('due_date', null ,['class'=>'form-control' ,'wire:model' => 'due_date']) !!}
                        </div>
                    </div>
                @endif

                @if (!$reprsenative_sell_car)
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('deliveryman_id', __('lang.deliveryman') . ':*', []) !!}
                        {!! Form::select('deliveryman_id', $deliverymen, null,
                        ['class' => 'select2 form-control', 'data-live-search' => 'true','id'=>'deliveryman_id', 'placeholder' => __('lang.please_select'),
                         'data-name' => 'deliveryman_id','wire:model' => 'deliveryman_id']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('delivery_cost', __('lang.delivery_cost'),['class' => 'text-primary']) !!}
                        {!! Form::number('delivery_cost', null, [
                            'class' => 'form-control',
                            'wire:model' => 'delivery_cost',
                            'placeholder'=> __('lang.delivery_cost'),
                        ]) !!}
                    </div>
                </div>
                @endif
            </div>

            <div class="row hide-print">
                @if($this->checkRepresentativeUser() && $reprsenative_sell_car)
                    <div class="col-md-3">
                        <button data-method="cash" style="width: 100%" type="button"
                                class="btn btn-success payment-btn" wire:click="submit" id="cash-btn"><i
                                class="fa-solid fa-money-bill"></i>
                            @lang('lang.pay')</button>
                        {{--                            @include('invoices.partials.payment') --}}
                    </div>
                @endif
                {{--                <div class="me-auto"> --}}
                {{--                    <div class="btns-control row"> --}}
                {{-- ++++++++++++++++++++++ زرار الدفع ++++++++++++++++++++ --}}

                @if (!$this->checkRepresentativeUser())
                    <div class="col-md-3">
                        <button data-method="cash" style="width: 100%" type="button"
                            class="btn btn-success payment-btn" wire:click="submit" id="cash-btn"><i
                                class="fa-solid fa-money-bill"></i>
                            @lang('lang.pay')</button>
                        {{--                            @include('invoices.partials.payment') --}}
                    </div>
                @endif
                <div class="col-md-4">
                    <button data-method="cash" style="width: 100%" type="button" class="btn btn-warning payment-btn"
                        wire:click="changeStatus" id="cash-btn"><i class="fa-solid fa-flag"></i>
                        @lang('lang.draft')</button>
                </div>
                <div class="col-md-5">
                    <button style="width: 100%" type="button" class="btn btn-primary payment-btn" data-toggle="modal"
                        data-target="#draftTransaction"  id="cash-btn"><i
                            class="fa-solid fa-flag"></i>
                        @lang('lang.view_draft')</button>
                    @include('invoices.partials.draft_transaction')
                </div>
                {{--                    </div> --}}
                {{--                </div> --}}
            </div>
            <div class="row hide-print mt-3">
   
                        {{-- ++++++++++++++++++++++ زرار الدفع لاحقا++++++++++++++++++++ --}}
                        {{-- <div class="col-md-5">
                            <button style="width: 100%; background: #5b808f" type="button" class="btn btn-primary payment-btn"
                                    data-toggle="modal" onclick="openDueDateModal()">
                                <i class="fa fa-hourglass-start"></i> @lang('lang.pay_later')
                            </button> --}}
                @if (!$this->checkRepresentativeUser())
                    <div class="row hide-print mt-3">
                        <div class="col-md-5">
                            <button style="width: 100%; background: #5b808f" type="button"
                                class="btn btn-primary payment-btn" onclick="openDueDateModal()" id="pay-later-btn"><i
                                    class="fa fa-hourglass-start"></i>
                                @lang('lang.pay_later')</button>
                        </div>
                    </div>
                @endif
                <div class="row hide-print mt-3">
                    <div class="column-5">
                        {{-- <a data-href="{{route('customers.pay_due_view', ['id' => $due->id])}}"   data-container=".view_modal" class="btn btn-modal"  style="background-color: #ffc107;" type="button" class="btn btn-custom"
                            id="recent-transaction-btn"><i class="dripicons-clock"></i>
                            @lang('lang.recent_transactions')</a> --}}

                        <button style="background-color: #ffc107;" type="button" class="btn btn-custom"
                            id="recent-transaction-btn"><i class="dripicons-clock"></i>
                            @lang('lang.recent_transactions')</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Add a modal to your HTML with an input field for due date -->
<div class="modal" tabindex="-1" role="dialog" id="dueDateModal" wire:ignore >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <label for="dueDate">Due Date:</label>
                <input type="date" wire:model="due_date" class="form-control" id="dueDate">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submitDueDateBtn" wire:click="pendingStatus">Submit</button>
                <button type="button" class="btn btn-secondary" id="closeDueDateBtn" wire:click="pendingStatus" data-dismiss="modal">Close</button>
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
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeRecentTransactionModal"><span
                    aria-hidden="true">&times;</span></button>
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
        $(document).on("click", "#recent-transaction-btn", function () {
            $("#recentTransaction").modal("show");
        }); 
        $(document).on("click", "#closeRecentTransactionModal", function () {
            $("#recentTransaction").modal("hide");
        }); 
    // });
  </script>