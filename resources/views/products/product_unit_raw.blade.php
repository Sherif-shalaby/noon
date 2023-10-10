<div class="d-flex align-items-center unit-row justify-content-between py-2 mb-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
    style="background-color: #ededed; border-radius: 7px">
    <div
        class="col-md-11 d-flex justify-content-between py-2  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
        <div
            class="col-md-3 px-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {!! Form::label('sku', __('lang.product_code'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end mb-0 width-half' : ' mb-0 width-half',
            ]) !!}
            {!! Form::text('sku[' . $index . ']', isset($variation->sku) ? $variation->sku : null, [
                'class' => 'form-control mater-name-input m-0',
            ]) !!}
        </div>

        <div
            class="col-md-3 px-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {!! Form::label('unit', __('lang.new_unit'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end  mb-0 width-half' : 'mb-0 width-half',
            ]) !!}
            <div class="d-flex justify-content-center align-items-center"
                style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                {!! Form::select(
                    'new_unit_id[' . $index . ']',
                    $units,
                    isset($variation->unit_id) ? $variation->unit_id : null,
                    ['class' => 'form-control select2 new_unit', 'placeholder' => __('lang.please_select'), 'id' => 'unit_id'],
                ) !!}
                <button type="button" class="add-button d-flex justify-content-center align-items-center"
                    data-toggle="modal" data-target=".add-unit" href="{{ route('units.create') }}"><i
                        class="fas fa-plus"></i></button>
            </div>
        </div>
        <div
            class="col-md-3 px-2 d-flex align-items-center justify-content-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {!! Form::label('equal', __('lang.equal'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end mb-0 width-fit ml-2' : ' mb-0 width-fit mr-2',
            ]) !!}
            {!! Form::text('equal[' . $index . ']', isset($variation->equal) ? $variation->equal : null, [
                'class' => 'form-control mater-name-input m-0 width-30',
            ]) !!}
        </div>
        <div
            class="col-md-3 px-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
            {!! Form::label('basic_unit', __('lang.basic_unit'), [
                'class' => app()->isLocale('ar') ? 'd-block text-end mb-0 width-65' : ' mb-0 width-65',
            ]) !!}
            {!! Form::select(
                'basic_unit_id[' . $index . ']',
                $units,
                isset($variation->basic_unit_id) ? $variation->basic_unit_id : null,
                ['class' => 'form-control select2 basic_unit_id  mater-name-input m-0', 'placeholder' => __('lang.please_select')],
            ) !!}
        </div>
    </div>

    <div class="col-md-1 p-0 d-flex justify-content-center align-items-center">
        <div>
            <button class="btn btn btn-danger remove_row" type="button">
                <i class="fa fa-close"></i>
            </button>
        </div>
    </div>

</div>
