
<div class="modal fade add-store"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['url' => route('sell-car.store'), 'method' => 'post','id' => 'create-sell-car' ]) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleLargeModalLabel">@lang('lang.add_sell_car')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('driver_id', __('lang.driver_name')) .'*' !!}
                                {!! Form::select('driver_id',$deliveries,null, ['class' => 'form-control select2' , 'placeholder' => __('lang.please_select') , 'required']);  !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('car_name', __('lang.car_name')).'*' !!}
                                {!! Form::text('car_name',null, ['class' => 'form-control' , 'placeholder' => __('lang.car_name'), 'required']);  !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('car_no', __('lang.car_number')) !!}
                                {!! Form::text('car_no',null, ['class' => 'form-control' , 'placeholder' => __('lang.car_number'),'required']);  !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('car_type', __('lang.car_type')) !!}
                                {!! Form::text('car_type',null, ['class' => 'form-control' , 'placeholder' => __('lang.car_type')]);  !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('car_size', __('lang.car_size')) !!}
                                {!! Form::text('car_size',null, ['class' => 'form-control' , 'placeholder' => __('lang.car_size')]);  !!}
                            </div>
                        </div>
                        {{-- ++++++ car_license ++++++ --}}
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('car_license', __('lang.car_license')) !!}
                                {!! Form::text('car_license',null, ['class' => 'form-control' , 'placeholder' => __('lang.car_license')]);  !!}
                            </div>
                        </div> --}}
                        {{-- ++++++ car_model ++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('car_model', __('lang.car_model')) !!}
                                {!! Form::text('car_model',null, ['class' => 'form-control' , 'placeholder' => __('lang.car_model')]);  !!}
                            </div>
                        </div>
                        {{-- ++++++ car_license_end_date ++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('car_license_end_date', __('lang.car_license_end_date')) !!}
                                {!! Form::date('car_license_end_date',null, ['class' => 'form-control' , 'placeholder' => __('lang.car_license_end_date')]);  !!}
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="form-group hidden" id="sell_representative">
                                <div class="form-group">
                                    {!! Form::label('sell_representative', __('lang.sell_representative')) !!}
                                    {!! Form::select('representative_id', $representatives, null, [
                                        'class' => ' form-control select2 representative_id',
                                        'placeholder' => __('lang.please_select'),
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 pt-3">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="has_store_pos" name="has_store_pos">
                                    <label class="custom-control-label" for="has_store_pos">@lang('lang.has_store_pos')</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                    </div>
                    <div class="row">
                        {{-- ++++++ التنبيه قبل موعد انتهاء ترخيص العربة ++++++ --}}
                        <div class="col-md-4 pt-3">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="notify_by_end_car_license" name="notify_by_end_car_license">
                                    <label class="custom-control-label" for="notify_by_end_car_license">@lang('lang.notify_by_end_car_license')</label>
                                </div>
                            </div>
                        </div>
                         {{-- ++++++ days_number_notify ++++++ --}}
                         <div class="col-md-4 mt-2">
                            <div class="form-group hidden" id="days_number_notify">
                                {!! Form::number('days_number_notify', null, ['class' => 'form-control', 'placeholder' =>  __('lang.days_number_notify') , 'min' => '0']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ++++++++ save button ++++++++ --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                    <button  type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
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
            if($(this).is(':checked')) {
                $('#days_number_notify').show(); // Show the input field
            } else {
                $('#days_number_notify').hide(); // Hide the input field
            }
        });
        $('#has_store_pos').change(function() {
            if($(this).is(':checked')) {
                $('#sell_representative').show();
            } else {
                $('#sell_representative').hide();
            }
        });
    });
</script>
