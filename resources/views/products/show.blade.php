<div class="modal modal-store animate__animated  show-product" data-animate-in="animate__rollIn"
    data-animate-out="animate__rollOut" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 65%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $product->name }}</h4>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <label style="font-weight: bold;" for="">@lang('lang.sku'): </label>
                                {{ $product->sku }} <br>
                                <label style="font-weight: bold;" for="">@lang('lang.category'): </label>
                                {{ $product->category->name ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.subcategories_name'): </label>
                                {{ $product->subCategory1->name ?? '' }} <br>
                                {{ $product->subCategory2->name ?? '' }} <br>
                                {{ $product->subCategory3->name ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.brand'): </label>
                                {{ $product->brand->name ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.unit'): </label>
                                @if (!empty($product->variations))
                                    @foreach ($product->variations as $variant)
                                        @if (!empty($variant->unit_id->name))
                                            {{ $variant->unit_id->name }} = {{ $variant->equal }}
                                            {{ $variant->basic_unit_id->name }}<br>
                                        @endif
                                    @endforeach
                                @endif
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.tax'): </label>
                                @if (!empty($product->tax->name))
                                    {{ $product->tax->name }}
                                @endif
                                <br>
                            </div>
                            <div class="col-md-6">
                                <label style="font-weight: bold;" for="">@lang('lang.height'): </label>
                                {{ $product->height ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.length'): </label>
                                {{ $product->length ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.width'): </label>
                                {{ $product->width ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.size'): </label>
                                {{ $product->size ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.weight'): </label>
                                {{ $product->weight ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.created_by'): </label>
                                {{ $product->createBy?->name ?? '' }}
                                <br>
                                <label style="font-weight: bold;" for="">@lang('lang.updated_by'): </label>
                                {{ $product->updatedBy?->name ?? '' }}
                                <br>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="col-sm-12 col-md-12 invoice-col">
                            <div class="thumbnail">
                                <img src="{{ !empty($product->image) ? '/uploads/products/' . $product->image : '/uploads/' . $settings['logo'] }}"
                                    class="img-fluid" alt="{{ $product->name }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lang.close')</button>
            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function() {
        var modelEl = $('.show-product');

        modelEl.addClass(modelEl.attr('data-animate-in'));

        modelEl.on('hide.bs.modal', function(event) {
                if (!$(this).attr('is-from-animation-end')) {
                    event.preventDefault();
                    $(this).addClass($(this).attr('data-animate-out'))
                    $(this).removeClass($(this).attr('data-animate-in'))
                }
                $(this).removeAttr('is-from-animation-end')
            })
            .on('animationend', function() {
                if ($(this).hasClass($(this).attr('data-animate-out'))) {
                    $(this).attr('is-from-animation-end', true);
                    $(this).modal('hide')
                    $(this).removeClass($(this).attr('data-animate-out'))
                    $(this).addClass($(this).attr('data-animate-in'))
                }
            })
    })
</script>
