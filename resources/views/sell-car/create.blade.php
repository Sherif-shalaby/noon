<div class="modal fade add-store" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['url' => route('sell-car.store'), 'method' => 'post', 'id' => 'create-sell-car']) !!}
            <div
                class="modal-header mb-4 d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleLargeModalLabel">@lang('lang.add_sell_car')</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-0">
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div
                        class="col-md-4 mb-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('driver_name', __('lang.driver_name') . '*', [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size:14px',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::text('driver_name', null, [
                                'class' => 'form-control initial-balance-input m-auto',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.driver_name'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="col-md-4 mb-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_name', __('lang.car_name') . '*', [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size:14px',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::text('car_name', null, [
                                'class' => 'form-control initial-balance-input m-auto',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_name'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="col-md-4 mb-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_no', __('lang.car_number'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size:14px',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::text('car_no', null, [
                                'class' => 'form-control initial-balance-input m-auto',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_number'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('sell_representative', __('lang.sell_representative'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size:14px',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::select('representative_id', $representatives, null, [
                                'class' => 'select p-0 initial-balance-input m-auto',
                                'style' => 'width:100%;border: 2px solid #ccc;',
                                'placeholder' => __('lang.please_select'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_type', __('lang.car_type'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size:14px',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::text('car_type', null, [
                                'class' => 'form-control initial-balance-input m-auto',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_type'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_size', __('lang.car_size'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size:14px',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::text('car_size', null, [
                                'class' => 'form-control initial-balance-input m-auto',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_size'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_license', __('lang.car_license'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size:14px',
                        ]) !!}
                        <div class="input-wrapper">
                            {!! Form::text('car_license', null, [
                                'class' => 'form-control initial-balance-input m-auto',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_license'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_model', __('lang.car_model'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size:14px',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::text('car_model', null, [
                                'class' => 'form-control initial-balance-input m-auto',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_model'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_license_end_date', __('lang.car_license_end_date'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size:14px',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::date('car_license_end_date', null, [
                                'class' => 'form-control initial-balance-input m-auto',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_license_end_date'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-4 pt-3">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1"
                                    name="notify_by_end_car_license">
                                <label class="custom-control-label" for="customSwitch1">@lang('lang.notify_by_end_car_license')</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
