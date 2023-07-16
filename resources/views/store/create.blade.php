
<div class="modal fade add-store" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['url' => route('store.store'), 'method' => 'post', 'id' => 'add_store' ]) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleLargeModalLabel">@lang('lang.add_store')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name', __('lang.name')) .'*' !!}
                        {!! Form::text('name',null, ['class' => 'form-control' , 'placeholder' => __('lang.name') , 'required']);  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('phone_number', __('lang.phone_number'))  !!}
                        {!! Form::text('phone_number',null, ['class' => 'form-control' , 'placeholder' => __('lang.phone_number') ]);  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', __('lang.name'))  !!}
                        {!! Form::text('email',null, ['class' => 'form-control' , 'placeholder' => __('lang.email') ]);  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('manager_name', __('lang.manager_name'))  !!}
                        {!! Form::text('manager_name',null, ['class' => 'form-control' , 'placeholder' => __('lang.manager_name') ]);  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('manager_mobile_number', __('lang.manager_mobile_number'))  !!}
                        {!! Form::text('manager_mobile_number',null, ['class' => 'form-control' , 'placeholder' => __('lang.manager_mobile_number') ]);  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('details', __('lang.details'))  !!}
                        {!! Form::textarea('email',null, ['class' => 'form-control' , 'placeholder' => __('lang.details') , 'rows' => '2']);  !!}
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                    {!! Form::submit(__('lang.save'),['class' => 'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>