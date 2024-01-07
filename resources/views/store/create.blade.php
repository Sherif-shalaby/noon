<div class="modal add-store " wire:ignore tabindex="-1" role="dialog" aria-hidden="true" style="display: none">
    <div class="modal-dialog  rollIn  animated modal-lg">
        <div class="modal-content">
            {!! Form::open([
                'url' => route('store.store'),
                'method' => 'post',
                'id' => isset($quick_add) && $quick_add ? 'quick_add_store_form' : 'add_store',
            ]) !!}
            <div
                class="modal-header d-flex justify-content-between py-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleLargeModalLabel">@lang('lang.add_store')</h5>
                <button type="button" class="close mx-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('branch_id', __('lang.branch'), [
                            'style' => 'font-size: 12px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            {!! Form::select('branch_id', $branches, null, [
                                'class' => 'form-select',
                                'style' => 'padding:0 10px !important',
                                'placeholder' => __('lang.branch'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <input type="hidden" name="quick_add"
                            value="{{ isset($quick_add) && $quick_add ? $quick_add : '' }}">
                        {!! Form::label('name', __('lang.name') . '*', [
                            'style' => 'font-size: 12px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            {!! Form::text('name', null, [
                                'class' => 'form-control width-full initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                                'placeholder' => __('lang.name'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('phone_number', __('lang.phone_number'), [
                            'style' => 'font-size: 12px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            {!! Form::text('phone_number', null, [
                                'class' => 'form-control width-full initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                                'placeholder' => __('lang.phone_number'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('email', __('lang.name'), [
                            'style' => 'font-size: 12px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            {!! Form::text('email', null, [
                                'class' => 'form-control width-full initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                                'placeholder' => __('lang.email'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('manager_name', __('lang.manager_name'), [
                            'style' => 'font-size: 12px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            {!! Form::text('manager_name', null, [
                                'class' => 'form-control width-full initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                                'placeholder' => __('lang.manager_name'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('manager_mobile_number', __('lang.manager_mobile_number'), [
                            'style' => 'font-size: 12px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            {!! Form::text('manager_mobile_number', null, [
                                'class' => 'form-control width-full initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                                'placeholder' => __('lang.manager_mobile_number'),
                            ]) !!}
                        </div>
                    </div>

                    <div
                        class="mb-2 col-md-12 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('details', __('lang.details'), [
                            'style' => 'font-size: 12px;font-weight: 500;',
                        ]) !!}
                        {!! Form::textarea('email', null, [
                            'class' => 'form-control width-full initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                            'placeholder' => __('lang.details'),
                            'rows' => '2',
                        ]) !!}
                    </div>
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
