<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit">@lang('lang.edit')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['url' => route('jobs.update', $job->id), 'method' => 'put']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="job_title">@lang('lang.job_title')</label>
                            <input type="text" class="form-control" value="{{$job->title}}" name="title" id="title" required>
                        </div>
                    </div>
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
                        {!! Form::checkbox('permissions[' . $key_module . ']', 1,in_array($key_module,$uniqueModuleNames)?true:false, ['class' => 'check_box check_box_view', 'title' => __('lang.view')]) !!}
                        
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
