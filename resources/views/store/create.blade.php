<div class="modal modal-store animate__animated  add-store" data-animate-in="animate__rollIn"
    data-animate-out="animate__rollOut" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content  @if (app()->isLocale('ar')) text-end @else text-start @endif">
            {!! Form::open([
                'url' => route('store.store'),
                'method' => 'post',
                'id' => isset($quick_add) && $quick_add ? 'quick_add_store_form' : 'add_store',
            ]) !!}
            <div
                class="modal-header d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleLargeModalLabel">@lang('lang.add_store')</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <input type="hidden" name="quick_add"
                        value="{{ isset($quick_add) && $quick_add ? $quick_add : '' }}">
                    {!! Form::label('name', __('lang.name') . '*', [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    {!! Form::text('name', null, [
                        'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                        'placeholder' => __('lang.name'),
                        'required',
                    ]) !!}
                </div>
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('phone_number', __('lang.phone_number'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    {!! Form::text('phone_number', null, [
                        'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                        'placeholder' => __('lang.phone_number'),
                    ]) !!}
                </div>
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('email', __('lang.name'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    {!! Form::text('email', null, [
                        'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                        'placeholder' => __('lang.email'),
                    ]) !!}
                </div>
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('manager_name', __('lang.manager_name'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    {!! Form::text('manager_name', null, [
                        'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                        'placeholder' => __('lang.manager_name'),
                    ]) !!}
                </div>
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('manager_mobile_number', __('lang.manager_mobile_number'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    {!! Form::text('manager_mobile_number', null, [
                        'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                        'placeholder' => __('lang.manager_mobile_number'),
                    ]) !!}
                </div>

                {{--  --}}

                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('branch_id', __('lang.branch'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    <div class="input-wrapper" style="width: 60%;margin: auto;">
                        {!! Form::select('branch_id', $branches, null, [
                            'class' => 'form-control select width-full m-auto',
                            'placeholder' => __('lang.branch'),
                        ]) !!}
                    </div>
                </div>

                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('details', __('lang.details'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    {!! Form::textarea('email', null, [
                        'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                        'placeholder' => __('lang.details'),
                        'rows' => '2',
                    ]) !!}
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button id="create-store-btn" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var modelEl = $('.modal-store');

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
