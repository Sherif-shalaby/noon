<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            {!! Form::open([
                'route' => 'customers.store',
                'method' => 'post',
                'id' => 'quick_add_customer_form',
                'enctype' => 'multipart/form-data',
            ]) !!}
            <div
                class="modal-header mb-4 d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h4 class="modal-title">@lang('lang.add_customer')</h4>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="quick_add" value="1">
                @include('customers.partials.create_customer_form')
            </div>
            <div class="modal-footer">
                <button type="button" id="create-customer-btn" class="btn btn-primary"
                    data-dismiss="modal">@lang('lang.save')</button>
            </div>

            {!! Form::close() !!}
        </div>
    </div><!-- /.modal-dialog -->
</div>
@push('javascripts')
@endpush
