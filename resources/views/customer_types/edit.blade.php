<!-- Modal -->
<div class="modal modal-edit-customer-type animate__animated" data-animate-in="animate__rollIn"
    data-animate-out="animate__rollOut" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header mb-4 d-flex justify-content-between py-0 flex-row">
                <h5 class="modal-title" id="editBrandModalLabel">{{ __('lang.edit_customer_type') }}</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => ['customertypes.update', $customertype->id],
                'method' => 'put',
                'id' => 'customer-type-update-form',
            ]) !!}
            @csrf
            @method('PUT')
            <div class="modal-body p-0">
                <div class=" d-flex mb-2 align-items-center form-group  flex-row ">
                    <label class="modal-label-width mx-2 mb-0" for="name">@lang('lang.name')</label>
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <input type="hidden" name="id" value="{{ $customertype->id }}" />
                        <input type="text" required
                            class="initial-balance-input my-0 @if (app()->isLocale('ar')) text-end  @else text-start @endif"
                            style="width: 100%" placeholder="@lang('lang.name')" name="name"
                            value="{{ $customertype->name }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <button class="add-button d-flex justify-content-center align-items-center" type="button"
                            data-toggle="collapse" data-target="#translation_table_customertype" aria-expanded="false"
                            aria-controls="collapseExample">
                            <i class="fas fa-globe"></i>
                        </button>
                    </div>
                    @include('layouts.translation_inputs', [
                        'attribute' => 'name',
                        'translations' => $customertype->translations,
                        'type' => 'customertype',
                        'open_input' => true,
                    ])
                </div>

                {{-- <div class="form-group">
                            <label for="store_id">@lang('lang.store')</label>
                            {!! Form::select(
                                'store_id',
                                $stores,$customertype->store_id,
                                ['class' => 'form-control select2','placeholder'=>__('lang.please_select')]
                            ) !!}
                            @error('store_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('lang.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var modelEl = $('.modal-edit-customer-type');

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
{!! JsValidator::formRequest('App\Http\Requests\CustomerTypeUpdateRequest', '#customer-type-update-form') !!}
