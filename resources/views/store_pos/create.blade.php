<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content  @if (app()->isLocale('ar')) text-end @else text-start @endif">
            {!! Form::open(['url' => route('store-pos.store'), 'method' => 'post']) !!}

            <div
                class="modal-header mb-2 d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h4 class="modal-title">@lang('lang.add_store_pos')</h4>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body p-0">
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('store_id', __('lang.store') . '*', ['class' => 'modal-label-width']) !!}
                    <div class="input-wrapper">
                        {!! Form::select('store_id', $stores, null, [
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
                    {!! Form::label('name', __('lang.name') . '*', ['class' => 'modal-label-width']) !!}
                    {!! Form::text('name', null, [
                        'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                        'placeholder' => __('lang.name'),
                        'required',
                    ]) !!}
                </div>
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('user_id', __('lang.user') . '*', ['class' => 'modal-label-width']) !!}
                    <div class="input-wrapper">
                        {!! Form::select('user_id', $users, null, [
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
        </div>
    </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\MoneySafeUpdateRequest', '#money-safe-update-form') !!}
