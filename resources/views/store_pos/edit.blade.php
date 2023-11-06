<div class="modal modal-edit-store-pos animate__animated" data-animate-in="animate__rollIn"
    data-animate-out="animate__rollOut" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content @if (app()->isLocale('ar')) text-end @else text-start @endif">

            {!! Form::open([
                'url' => route('store-pos.update', $store_pos->id),
                'method' => 'put',
                'id' => 'store_pos_edit_form',
            ]) !!}

            <div
                class="modal-header mb-2 d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                <h4 class="modal-title">@lang('lang.edit_store_pos')</h4>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body p-0">
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('store_id', __('lang.store') . '*', ['class' => 'width-quarter mr-4']) !!}
                    <div class="input-wrapper">
                        {!! Form::select('store_id', $stores, $store_pos->store_id, [
                            'class' =>
                                'select form-control initial-balance-input m-0 border p-0 app()->isLocale("ar")? text-end : texxt-start ',
                            'data-live-search' => 'true',
                            'required',
                            'style' =>
                                'width: 100%;border-radius:16px !important;font-size: 1rem;font-weight: 100;line-height: 1.5;color:gray;',
                            'placeholder' => __('lang.please_select'),
                        ]) !!}
                    </div>
                </div>
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('name', __('lang.name') . '*', ['class' => 'width-quarter mr-4']) !!}
                    {!! Form::text('name', $store_pos->name, [
                        'class' => 'form-control initial-balance-input mx-0 my-0 app()->isLocale("ar")? text-end : text-start',
                        'placeholder' => __('lang.name'),
                        'required',
                    ]) !!}
                </div>
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('user_id', __('lang.user') . '*', ['class' => 'width-quarter mr-4']) !!}
                    <div class="input-wrapper">
                        {!! Form::select('user_id', $users, $store_pos->user_id, [
                            'class' =>
                                'select form-control initial-balance-input m-0 border p-0 app()->isLocale("ar")? text-end : texxt-start ',
                            'data-live-search' => 'true',
                            'required',
                            'style' =>
                                'width: 100%;border-radius:16px !important;font-size: 1rem;font-weight: 100;line-height: 1.5;color:gray;',
                            'placeholder' => __('lang.please_select'),
                        ]) !!}
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.close')</button>
            </div>

            {!! Form::close() !!}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>
<script>
    $(document).ready(function() {
        var modelEl = $('.modal-edit-store-pos');

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
