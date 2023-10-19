<div class="modal fade add-job" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['url' => route('jobs.store'), 'method' => 'post', 'id' => 'add_job' ]) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="exampleLargeModalLabel">@lang('lang.add')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('title', __('lang.job_title')) .'*' !!}
                    {!! Form::text('title',null, ['class' => 'form-control' , 'placeholder' => __('lang.job_title') , 'required']);  !!}
                </div>
                <div class="row">
                    <div class="col-md-12 pt-2">
                        <h5>@lang('lang.permissions')</h5>
                    </div>
                </div>
                <div class="row">
                    @foreach ($modulePermissionArray as $key_module => $moudle)
                    <div class="col-md-3">
                        {{$moudle}}
                        {!! Form::checkbox('permissions[' . $key_module . ']', 1, false, ['class' => 'check_box check_box_view', 'title' => __('lang.view')]) !!}
                        
                    </div>
                    @endforeach
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
