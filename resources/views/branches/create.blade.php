<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit">@lang('lang.add_branch')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['url' => route('branches.store'), 'method' => 'post']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="job_title">@lang('lang.branch_name')</label>
                            <input type="text" class="form-control" value="" name="name" id="name" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('store', __('lang.stores'), ['class' => 'pt-3']) !!}
                            {!! Form::select(
                                'stores[]',
                                $stores,null,
                                [
                                    'class' => 'form-control select2',
                                    'multiple' => 'multiple',
//                                    'placeholder' => __('lang.please_select'),
                                    'id' => 'store_id',
                                ],
                            ) !!}
                        </div>
                    </div>
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
@push('javascripts')
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>--}}
@endpush
