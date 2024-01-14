<!-- Modal HTML structure -->
{{-- <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> --}}
            <!-- Add your payment modal content here -->
            {{-- <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> --}}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('payment_status', __('lang.payment_status') . ':*', []) !!}
                            {!! Form::select('payment_status', $payment_status_array, null,
                            ['class' => 'form-control select2', 'data-live-search' => 'true', 'required', 'id'=> 'payment_status', 'placeholder' => __('lang.please_select'),
                             ]) !!}
                            @error('payment_status')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 amountField d-none">
                        <div class="form-group">
                            {!! Form::label('amount', __('lang.amount'), []) !!} <br>
                            <input type="number" placeholder="{{__('lang.amount')}}" class="form-control" >
                            @error('amount')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3 methodField d-none">
                        <div class="form-group">
                            {!! Form::label('method', __('lang.payment_type'), []) !!}
                            {!! Form::select('method', $payment_type_array, null,
                            ['class' => 'form-control select2','data-live-search'=>"true", 'required', 'placeholder' => __('lang.please_select'),
                            'data-name' => 'method', 'wire:model' => 'method', 'wire:change' => 'show' ]) !!}
                            @error('method')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> --}}
        {{-- </div>
    </div>
</div> --}}
@push('javascripts')
<script>
    $('#payment_status').on('change', function () {
        console.log("00000");
        // var paymentStatusSelect = document.getElementById('payment_status');
        var amountField = document.getElementById('amountField');
        var methodField = document.getElementById('methodField');

        // paymentStatusSelect.addEventListener('change', function () {
            if (paymentStatusSelect.value === 'paid') {
                amountField.style.display = 'block';
                methodField.style.display = 'block';
            } else {
                amountField.style.display = 'none';
                methodField.style.display = 'none';
            }
        // });
    });
</script>
@endpush
