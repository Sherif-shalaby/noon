<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated modal-lg">
        <div class="modal-content">
            {!! Form::open([
                'url' => route('store.update', $store->id),
                'method' => 'put',
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
                            'class' => 'mb-0',
                        ]) !!}
                        <div class="input-wrapper width-full">
                            {!! Form::select('branch_id', $branches, $store->branch_id, [
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
                        {!! Form::label('name', __('lang.name') . '*', ['class' => 'mb-0']) !!}
                        {!! Form::text('name', $store->name, [
                            'class' => 'form-control width-full initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                            'placeholder' => __('lang.name'),
                            'required',
                        ]) !!}
                    </div>
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('phone_number', __('lang.phone_number'), ['class' => 'mb-0']) !!}
                        {!! Form::text('phone_number', $store->phone_number, [
                            'class' => 'form-control width-full initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                            'placeholder' => __('lang.phone_number'),
                        ]) !!}
                    </div>
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('email', __('lang.name'), ['class' => 'mb-0']) !!}
                        {!! Form::text('email', $store->email, [
                            'class' => 'form-control width-full initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                            'placeholder' => __('lang.email'),
                        ]) !!}
                    </div>
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('manager_name', __('lang.manager_name'), ['class' => 'mb-0']) !!}
                        {!! Form::text('manager_name', $store->manager_name, [
                            'class' => 'form-control width-full initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                            'placeholder' => __('lang.manager_name'),
                        ]) !!}
                    </div>
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('manager_mobile_number', __('lang.manager_mobile_number'), ['class' => 'mb-0']) !!}
                        {!! Form::text('manager_mobile_number', $store->manager_mobile_number, [
                            'class' => 'form-control width-full initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                            'placeholder' => __('lang.manager_mobile_number'),
                        ]) !!}
                    </div>
                    <div
                        class="mb-2 col-md-12 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        {!! Form::label('details', __('lang.details'), ['class' => 'mb-0']) !!}
                        {!! Form::textarea('details', $store->details, [
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
