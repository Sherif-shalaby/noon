<style>
    .form-select {
        height: 100%;
        padding-bottom: 0;
        padding-top: 0;
        background-color: #dedede !important;
        border-radius: 16px;
        border: 2px solid #cececf;
        font-size: 14px;
        font-weight: 500
    }

    .form-select:focus {
        border-color: #cececf !important;
        outline: 0;
        box-shadow: 0 0 0 0 !important;
        background-color: white !important;
    }
</style>
<div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog modal-dialog-scrollable  rollIn  animated" role="document">
        <div class="modal-content">
            {!! Form::open([
                'route' => 'customers.store',
                'method' => 'post',
                'id' => 'quick_add_customer_form',
                'enctype' => 'multipart/form-data',
            ]) !!}
            <div
                class="modal-header mb-0 d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
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
