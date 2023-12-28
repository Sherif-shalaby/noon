<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content  @if (app()->isLocale('ar')) text-end @else text-start @endif">
            {!! Form::open([
                'url' => route('store_upload_receipt'),
                'method' => 'post',
                'id' => 'upload_receipt',
                'enctype' => 'multipart/form-data',
            ]) !!}
            <div class="modal-header mb-0 d-flex justify-content-between py-0 ">
                <h5 class="modal-title" id="edit">@lang('lang.upload')</h5>
                <button type="button" class="close mx-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="transaction_id" value="{{ $id }}">
                {!! Form::file('receipts[]', ['multiple' => 'multiple']) !!}
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script> --}}
{{--    <script src="{{ asset('css/crop/crop-image-to-a4.js') }}"></script> --}}
