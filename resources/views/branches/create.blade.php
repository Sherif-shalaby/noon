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
            {!! Form::open(['url' => route('branches.store'), 'method' => 'post', 'id' => 'branch-form']) !!}
            <div class="modal-body">
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-end mr-1">

                        <label class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                            for="job_title">@lang('lang.branch_name')</label>
                        <input type="text" class="form-control initial-balance-input width-full" value=""
                            name="name" id="name" required>

                    </div>
                    {{-- <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('store', __('lang.stores'), ['class' => 'pt-3', 'style' => 'font-size: 12px;font-weight: 500;']) !!}
                            {!! Form::select('stores[]', $stores, null, [
                                'class' => 'form-control select',
                                'multiple' => 'multiple',
                                //                                    'placeholder' => __('lang.please_select'),
                                'id' => 'store_id',
                            ]) !!}
                        </div>
                    </div> --}}
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
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\BranchRequest', '#branch-form') !!}
{!! JsValidator::formRequest('App\Http\Requests\BranchRequest', '#quick_add_branch_form') !!}
@push('javascripts')
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script> --}}
@endpush
