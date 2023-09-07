<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">

{{--            {!! Form::open(['url' => action('CustomerController@store'), 'method' => 'post', 'id' => $quick_add ?--}}
{{--            'quick_add_customer_form' : 'customer_add_form', 'enctype' => 'multipart/form-data' ]) !!}--}}

            <div class="modal-header">

                <h4 class="modal-title">@lang( 'lang.add_customer' )</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                @include('customers.partials.create_customer_form')
            </div>

            <div class="modal-footer">
                <button type="button" wire:click="addCustomer" class="btn btn-primary">@lang( 'lang.save' )</button>
            </div>

{{--            {!! Form::close() !!}--}}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@push('javascripts')
@endpush
