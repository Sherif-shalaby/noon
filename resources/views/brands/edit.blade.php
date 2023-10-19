<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div
                class="modal-header d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="editBrandModalLabel">{{ __('lang.edit_brand') }}</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => ['brands.update', $brand->id], 'method' => 'put', 'id' => 'brand-update-form']) !!}
            @csrf
            @method('PUT')
            <div class="modal-body">

                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) mr-3 @else ml-3 @endif">
                    <input type="hidden" name="id" value="{{ $brand->id }}" />
                    {!! Form::label('name', __('lang.brand_name') . '*', ['class' => 'col-md-4 m-0 p-0']) !!}
                    {!! Form::text('name', $brand->name, [
                        'class' => 'initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                        'placeholder' => __('lang.brand_name'),
                        'required',
                    ]) !!}
                    @error('name')
                        <label class="text-danger error-msg">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('lang.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\BrandUpdateRequest', '#brand-update-form') !!}

{{-- <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script> --}}
