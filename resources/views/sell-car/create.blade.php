<div class="modal modal-add-sell-car animate__animated add-store" data-animate-in="animate__rollIn"
    data-animate-out="animate__rollOut" tabindex="-1" role="dialog" aria-hidden="true">
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
                        {!! Form::label('driver_id', __('lang.driver_name') . '*', [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size: 14px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::select('driver_id', $deliveries, null, [
                                'class' => 'form-control select2 initial-balance-input m-auto text-right',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.please_select'),
                                'required',
                            ]) !!}
                        </div>
                    </div>

                    <div
                        class="col-md-4 mb-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_name', __('lang.car_name') . '*', [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size: 14px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::text('car_name', null, [
                                'class' => 'form-control initial-balance-input m-auto text-right',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_name'),
                                'required',
                            ]) !!}
                        </div>
                    </div>

                    <div
                        class="col-md-4 mb-3 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_no', __('lang.car_number') . '*', [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size: 14px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::text('car_no', null, [
                                'class' => 'form-control initial-balance-input m-auto text-right',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_number'),
                                'required',
                            ]) !!}
                        </div>
                    </div>

                    <div
                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_type', __('lang.car_type'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size: 14px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::text('car_type', null, [
                                'class' => 'form-control initial-balance-input m-auto text-right',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_type'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_size', __('lang.car_size'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size: 14px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::text('car_size', null, [
                                'class' => 'form-control initial-balance-input m-auto text-right',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_size'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_license', __('lang.car_license'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size: 14px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper">
                            {!! Form::text('car_license', null, [
                                'class' => 'form-control initial-balance-input m-auto text-right',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_license'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_model', __('lang.car_model'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size: 14px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper">

                            {!! Form::text('car_model', null, [
                                'class' => 'form-control initial-balance-input m-auto text-right',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_model'),
                            ]) !!}
                        </div>
                    </div>
                    <div
                        class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        {!! Form::label('car_license_end_date', __('lang.car_license_end_date'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                            'style' => 'font-size: 11px;font-weight: 500;',
                        ]) !!}
                        <div class="input-wrapper">
                            {!! Form::date('car_license_end_date', null, [
                                'class' => 'form-control initial-balance-input m-auto',
                                'style' => 'width:100%',
                                'placeholder' => __('lang.car_license_end_date'),
                            ]) !!}
                        </div>
                    </div>
                    {{-- ++++++ days_number_notify ++++++ --}}
                </div>
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                    <div class="col-md-6 d-flex flex-row-reverse justify-content-start align-items-center">
                        <div class="form-group hidden col-md-6 align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            id="sell_representative" style="display: none">
                            {!! Form::label('sell_representative', __('lang.sell_representative'), [
                                'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
                                'style' => 'font-size: 11px;font-weight: 500;',
                            ]) !!}
                            <div class="input-wrapper">
                                {!! Form::select('representative_id', $representatives, null, [
                                    'class' => ' form-control select2 representative_id width-full',
                                    'placeholder' => __('lang.please_select'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <div class="custom-control custom-switch" style="width: fit-content">
                                    <input type="checkbox" class="custom-control-input" id="has_store_pos"
                                        name="has_store_pos">
                                    <label style="font-size: 11px;font-weight: 500;" class="custom-control-label"
                                        for="has_store_pos">@lang('lang.has_store_pos')</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex flex-row-reverse justify-content-start align-items-center">
                        {{-- ++++++ days_number_notify ++++++ --}}
                        <div
                            class="col-md-4 mb-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <div class="form-group hidden" id="days_number_notify" style="display: none">
                                {!! Form::number('days_number_notify', null, [
                                    'class' => 'form-control initial-balance-input width-full m-0',
                                    'placeholder' => __('lang.days_number_notify'),
                                    'min' => '0',
                                ]) !!}
                            </div>
                        </div>
                        {{-- ++++++ التنبيه قبل موعد انتهاء ترخيص العربة ++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-control custom-switch" style="width: fit-content">
                                    <input type="checkbox" class="custom-control-input" id="notify_by_end_car_license"
                                        name="notify_by_end_car_license">
                                    <label style="font-size: 11px;font-weight: 500;" class="custom-control-label"
                                        for="notify_by_end_car_license">@lang('lang.notify_by_end_car_license')</label>
                                </div>
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
<script>
    // jQuery code to toggle the input field based on checkbox state
    $(document).ready(function() {
        // when check "التنبيه قبل موعد انتهاء ترخيص العربة" checkbox Then appear "days_number_notify" inputField
        $('#notify_by_end_car_license').change(function() {
            if ($(this).is(':checked')) {
                $('#days_number_notify').show(); // Show the input field
            } else {
                $('#days_number_notify').hide(); // Hide the input field
            }
        });
    });
    $('#has_store_pos').change(function() {
        if ($(this).is(':checked')) {
            $('#sell_representative').show();
        } else {
            $('#sell_representative').hide();
        }
    });
</script>

<script>
    $(document).ready(function() {
        var modelEl = $('.modal-add-sell-car');

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
