<div class="bn-group">
    <button type="button" class="btn btn-primary btn-sm text-white mx-1" data-toggle="modal"
        data-target="#edit{{ $unit->id }}" title="{{ __('Edit') }}">
        <i class="fa fa-edit"></i>
    </button>
    <a data-href="{{ route('units.destroy', $unit->id) }}" title="{{ __('Delete') }}"
        class="btn btn-danger text-white btn-sm delete_item"><i class="fa fa-trash"></i>
    </a>
</div>

{{-- modal edit --}}
<div class="modal fade" id="edit{{ $unit->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content @if (app()->isLocale('ar')) text-end @else text-start @endif">
            <div class="modal-header mb-4 d-flex justify-content-between py-0 ">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('units.editunit') }}</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('units.update', $unit->id) }}" method="POST" id="unit-edit-form">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div
                        class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) mr-3 @else ml-3 @endif">
                        <label class="col-md-3" for="name">@lang('units.unitname')</label>
                        <div class="col-md-9 d-flex justify-content-between p-0 align-items-center select_body position-relative @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                            style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                            <input type="text"
                                class='form-control category-name form-control initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif'
                                style="width: 100%; margin-right: 0" placeholder="@lang('units.unitname')" name="name"
                                value="{{ old('name', $unit->name) }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <button class="add-button d-flex justify-content-center align-items-center" type="button"
                                data-toggle="collapse" data-target="#translation_table_unit" aria-expanded="false"
                                aria-controls="collapseExample">
                                <i class="fas fa-globe"></i>
                            </button>
                        </div>
                        @include('layouts.translation_inputs', [
                            'attribute' => 'name',
                            'translations' => [],
                            'type' => 'unit',
                            'data' => $unit,
                        ])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end modal edit --}}
@push('js')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\UnitupdateRequest', '#unit-edit-form') !!}
@endpush
