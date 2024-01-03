<!-- Modal -->
<div class="modal modal-salary animate__animated " data-animate-in="animate__rollIn" data-animate-out="animate__rollOut"
    id="salary_details" tabindex="-1" role="dialog" aria-labelledby="salary_detailsLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content  @if (app()->isLocale('ar')) text-end @else text-start @endif">
            <div
                class="modal-header d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="salary_details">@lang('lang.salary_details')</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div
                        class="col-md-6 d-flex flex-column justify-content-start @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">

                        <div class="i-checks">
                            <div
                                class="d-flex mb-2 @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">

                                <input id="fixed_wage" name="fixed_wage" type="checkbox" value="1"
                                    @if (!empty($employee->fixed_wage)) checked @endif class=" salary_checkbox">
                                <label class="mx-2 mb-0 @if (app()->isLocale('ar')) d-block text-end @endif"
                                    for="fixed_wage"><strong>@lang('lang.enter_the_fixed_wage')</strong></label>
                            </div>
                            <div class="input-wrapper mb-2 width-full">
                                {!! Form::text('fixed_wage_value', !empty($employee->fixed_wage_value) ? $employee->fixed_wage_value : null, [
                                    'class' => 'form-control salary_fields initial-balance-input width-full text-end',
                                    'placeholder' => __('lang.enter_the_fixed_wage'),
                                ]) !!}
                            </div>
                            {!! Form::label('', __('lang.select_payment_cycle'), [
                                'class' =>
                                    'app()->isLocale("ar") ? d-block text-end text-muted mx-2 mb-0 width-full pr-3  : text-muted mx-2 mb-0 width-full pr-3 ',
                                'style' => 'font-size: 12px;font-weight: 500',
                            ]) !!}
                            <div class="input-wrapper width-full">
                                {!! Form::select(
                                    'payment_cycle',
                                    $payment_cycle,
                                    !empty($employee->payment_cycle) ? $employee->payment_cycle : null,
                                    [
                                        'class' => 'form-control salary_select selectpicker initial-balance-input width-full',
                                        'placeholder' => __('lang.select_payment_cycle'),
                                    ],
                                ) !!}
                            </div>
                        </div>

                    </div>
                    <div
                        class="col-md-6 d-flex flex-column justify-content-start @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <div
                            class="d-flex mb-2 @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                            <div class="i-checks">
                                <div
                                    class="d-flex mb-2 @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                                    <input id="commission" name="commission" type="checkbox" value="1"
                                        @if (!empty($employee->commission)) checked @endif class="salary_checkbox">
                                    <label class="mx-2 mb-0 @if (app()->isLocale('ar')) d-block text-end @endif"
                                        for="commission"><strong>@lang('lang.enter_the_commission_%')</strong></label>
                                </div>
                                <div class="input-wrapper mb-2 width-full">
                                    {!! Form::text('commission_value', !empty($employee->commission_value) ? $employee->commission_value : null, [
                                        'class' => 'form-control salary_fields initial-balance-input width-full',
                                        'placeholder' => __('lang.enter_the_commission_%'),
                                    ]) !!}
                                </div>
                                <div class="row">
                                    <div class="col-md-6">

                                        {!! Form::label('', __('lang.select_commission_type'), [
                                            'class' =>
                                                'app()->isLocale("ar") ? d-block text-end text-muted mx-2 mb-0 width-full pr-3  : text-muted mx-2 mb-0 width-full pr-3 ',
                                            'style' => 'font-size: 12px;font-weight: 500',
                                        ]) !!}
                                        <div class="input-wrapper mb-2 width-full">

                                            {!! Form::select(
                                                'commission_type',
                                                $commission_type,
                                                !empty($employee->commission_type) ? $employee->commission_type : null,
                                                [
                                                    'class' => 'form-control salary_select selectpicker initial-balance-input width-full',
                                                    'placeholder' => __('lang.select_commission_type'),
                                                ],
                                            ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        {!! Form::label('', __('lang.select_commission_calculation_period'), [
                                            'class' =>
                                                'app()->isLocale("ar") ? d-block text-end text-muted mx-2 mb-0 width-full pr-3  : text-muted mx-2 mb-0 width-full pr-3 ',
                                            'style' => 'font-size: 12px;font-weight: 500',
                                        ]) !!}
                                        <div class="input-wrapper mb-2 width-full">
                                            {!! Form::select(
                                                'commission_calculation_period',
                                                $commission_calculation_period,
                                                !empty($employee->commission_calculation_period) ? $employee->commission_calculation_period : null,
                                                [
                                                    'class' => 'form-control salary_select selectpicker',
                                                    'placeholder' => __('lang.select_commission_calculation_period'),
                                                ],
                                            ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        {!! Form::label('commissioned_products', __('lang.products'), [
                                            'class' =>
                                                'app()->isLocale("ar") ? d-block text-end text-muted mx-2 mb-0 width-full pr-3  : text-muted mx-2 mb-0 width-full pr-3 ',
                                            'style' => 'font-size: 12px;font-weight: 500',
                                        ]) !!}
                                        <div class="input-wrapper mb-2 width-full">

                                            {!! Form::select(
                                                'commissioned_products[]',
                                                $products,
                                                !empty($employee->commissioned_products) ? $employee->commissioned_products : null,
                                                [
                                                    'class' => 'form-control salary_select selectpicker',
                                                    'multiple',
                                                    'placehoder' => __('lang.please_select'),
                                                    'data-actions-box' => 'true',
                                                ],
                                            ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        {!! Form::label('commission_customer_types', __('lang.customer_types'), [
                                            'class' =>
                                                'app()->isLocale("ar") ? d-block text-end text-muted mx-2 mb-0 width-full pr-3  : text-muted mx-2 mb-0 width-full pr-3 ',
                                            'style' => 'font-size: 12px;font-weight: 500',
                                        ]) !!}
                                        <div class="input-wrapper mb-2 width-full">

                                            {!! Form::select(
                                                'commission_customer_types[]',
                                                $customer_types,
                                                !empty($employee->commission_customer_types) ? $employee->commission_customer_types : null,
                                                [
                                                    'class' => 'form-control salary_select selectpicker',
                                                    'multiple',
                                                    'placehoder' => __('lang.please_select'),
                                                    'data-actions-box' => 'true',
                                                ],
                                            ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        {!! Form::label('commission_stores', __('lang.stores'), [
                                            'class' =>
                                                'app()->isLocale("ar") ? d-block text-end text-muted mx-2 mb-0 width-full pr-3  : text-muted mx-2 mb-0 width-full pr-3 ',
                                            'style' => 'font-size: 12px;font-weight: 500',
                                        ]) !!}
                                        <div class="input-wrapper  mb-2 width-full">

                                            {!! Form::select(
                                                'commission_stores[]',
                                                $stores,
                                                !empty($employee->commission_stores) ? $employee->commission_stores : null,
                                                [
                                                    'class' => 'form-control salary_select selectpicker',
                                                    'multiple',
                                                    'placehoder' => __('lang.please_select'),
                                                    'data-actions-box' => 'true',
                                                ],
                                            ) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        {!! Form::label('commission_cashiers', __('lang.cashiers'), [
                                            'class' =>
                                                'app()->isLocale("ar") ? d-block text-end text-muted mx-2 mb-0 width-full pr-3  : text-muted mx-2 mb-0 width-full pr-3 ',
                                            'style' => 'font-size: 12px;font-weight: 500',
                                        ]) !!}
                                        <div class="input-wrapper mb-2 width-full">
                                            {!! Form::select(
                                                'commission_cashiers[]',
                                                $cashiers,
                                                !empty($employee->commission_cashiers) ? $employee->commission_cashiers : null,
                                                [
                                                    'class' => 'form-control salary_select selectpicker',
                                                    'multiple',
                                                    'placehoder' => __('lang.please_select'),
                                                    'data-actions-box' => 'true',
                                                ],
                                            ) !!}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('lang.save')</button>
                <button type="button" class="btn btn-secondary salary_cancel"
                    data-dismiss="modal">@lang('lang.close')</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var modelEl = $('.modal-salary');

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
