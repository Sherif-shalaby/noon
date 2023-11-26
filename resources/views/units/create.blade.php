<!-- Modal -->
<div class="modal add-unit modal-unit animate__animated add-supplier" data-animate-in="animate__rollIn"
    data-animate-out="animate__rollOut" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content @if (app()->isLocale('ar')) text-end @else text-start @endif">
            <div
                class="modal-header mb-4 d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif justify-content-between py-0 ">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add') }}</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" action="{{ route('units.store') }}" method="POST"
                id={{ isset($quick_add) && $quick_add ? 'quick_add_unit_form' : 'unit-form' }}>
                @csrf
                <div class="modal-body p-0">
                    <div
                        class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <input type="hidden" name="quick_add"
                            value="{{ isset($quick_add) && $quick_add ? $quick_add : '' }}">
                        <label style="font-size: 12px;font-weight: 500;" class="col-md-3"
                            for="name">@lang('units.unitname')</label>
                        <div class="col-md-9 d-flex justify-content-between p-0 align-items-center select_body position-relative @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                            <input type="text" required
                                class='form-control category-name form-control initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif'
                                style="width: 100%; margin-right: 0" placeholder="@lang('units.unitname')" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <button class="add-button d-flex justify-content-center align-items-center" type="button"
                                data-toggle="collapse" data-target="#translation_table_customer_types"
                                aria-expanded="false" aria-controls="collapseExample">
                                <i class="fas fa-globe"></i>
                            </button>
                        </div>
                        @include('layouts.translation_inputs', [
                            'attribute' => 'name',
                            'translations' => [],
                            'type' => 'customer_types',
                        ])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('cancel') }}</button>
                    <button id="create-unit-btn" class="btn btn-primary">{{ __('lang.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\UnitRequest', '#unit-form') !!}
    {!! JsValidator::formRequest('App\Http\Requests\UnitRequest', '#quick_add_unit_form') !!}
    <script>
        $(document).ready(function() {
            var modelEl = $('.modal-unit');

            modelEl.addClass(modelEl.attr('data-animate-in'));

            modelEl.on('hide.bs.modal', function(event) {
                    if (!$(this).attr('is-from-animation-end')) {
                        event.preventDefault();
                        $(this).addClass($(this).attr('data-animate-out'))
                        $(this).removeClass($(this).attr('data-animate-in'))
                    }
                    $(this).removeAttr('is-from-animation-end')
                })
                .on('animationend', function() {
                    if ($(this).hasClass($(this).attr('data-animate-out'))) {
                        $(this).attr('is-from-animation-end', true);
                        $(this).modal('hide')
                        $(this).removeClass($(this).attr('data-animate-out'))
                        $(this).addClass($(this).attr('data-animate-in'))
                    }
                })
        })
    </script>
@endpush
