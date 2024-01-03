<!-- Modal -->
<style>
    .form-select {
        height: 100%;
        padding-bottom: 0;
        padding-top: 0;
        background-color: #dedede !important;
        border-radius: 16px;
        border: 2px solid #cececf;
        font-size: 14px;
        font-weight: 500
    }

    .form-select:focus {
        border-color: #cececf !important;
        outline: 0;
        box-shadow: 0 0 0 0 !important;
        background-color: white !important;
    }
</style>
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
            {!! Form::open(['url' => route('branches.update', $branch->id), 'method' => 'put']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-end mr-1">

                        <label class= "mb-0 @if (app()->isLocale('ar')) d-block text-end  mx-2 @else mx-2 @endif"
                            for="job_title">@lang('lang.branch_name')</label>
                        <input type="text" class="form-control initial-balance-input width-full m-0"
                            value="{{ $branch->name }}" name="name" id="name" required>

                    </div>
                    <div class="  animate__animated  animate__bounceInLeft d-flex flex-column align-items-end mr-1">

                        {!! Form::label('store', __('lang.stores'), [
                            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0' : 'mx-2 mb-0',
                        ]) !!}
                        {!! Form::select('stores[]', $stores, $branch->stores, [
                            'class' => 'form-select',
                            'multiple' => 'multiple',
                            //                                    'placeholder' => __('lang.please_select'),
                            'id' => 'store_id',
                        ]) !!}

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
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script> --}}
@endpush
