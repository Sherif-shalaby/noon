<div class="modal fade" id="imageModal{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('lang.add_image')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="croppie-image-modal{{ $key }}" style="display:none">
                    <div id="croppie-image-container{{ $key }}"></div>
                    <button data-dismiss="modal" id="croppie-image-cancel-btn{{ $key }}" type="button"
                            class="btn btn-secondary"><i class="fas fa-times"></i></button>
                    <button id="croppie-image-submit-btn{{ $key }}" type="button" class="btn btn-primary"><i
                            class="fas fa-crop"></i></button>
                </div>
            </div>

        </div>
    </div>
</div>
