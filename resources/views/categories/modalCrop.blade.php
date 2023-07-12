<div class="modal fade" id="product_cropper_modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('categories.crop_image_before_upload')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="" id="product_sample_image" />
                        </div>
                        <div class="col-md-4">
                            <div class="product_preview_div"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="product_crop" class="btn btn-primary">@lang('crop')</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('cancel')</button>
            </div>
        </div>
    </div>
</div>
