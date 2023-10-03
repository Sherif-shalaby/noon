
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
                                {!! Form::label('driver_name', __('lang.driver_name')) .'*' !!}
                                {!! Form::text('driver_name',null, ['class' => 'form-control' , 'placeholder' => __('lang.driver_name') , 'required']);  !!}
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
                                {!! Form::text('car_no',null, ['class' => 'form-control' , 'placeholder' => __('lang.car_no')]);  !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('sell_representative', __('lang.sell_representative')) !!}
                                {!! Form::select('representative_id', $representatives, null, [
                                    'class' => ' form-control select2 representative_id',
                                    'placeholder' => __('lang.please_select'),
                                ]) !!}
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
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('car_license', __('lang.car_license')) !!}
                                {!! Form::text('car_license',null, ['class' => 'form-control' , 'placeholder' => __('lang.car_license')]);  !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('car_model', __('lang.car_model')) !!}
                                {!! Form::text('car_model',null, ['class' => 'form-control' , 'placeholder' => __('lang.car_model')]);  !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('car_license_end_date', __('lang.car_license_end_date')) !!}
                                {!! Form::date('car_license_end_date',null, ['class' => 'form-control' , 'placeholder' => __('lang.car_license_end_date')]);  !!}
                            </div>
                        </div>
                        <div class="col-md-4 pt-3">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" name="notify_by_end_car_license">
                                    <label class="custom-control-label" for="customSwitch1">@lang('lang.notify_by_end_car_license')</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                    <button  type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>