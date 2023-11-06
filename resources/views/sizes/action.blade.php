<div class="bn-group">
    <button type="button" class="btn btn-primary btn-sm text-white mx-1" data-toggle="modal"
        data-target="#edit{{ $size->id }}" title="{{ __('Edit') }}">
        <i class="fa fa-edit"></i>
    </button>
    <a data-href="{{ route('sizes.destroy', $size->id) }}" title="{{ __('Delete') }}"
        class="btn btn-danger text-white btn-sm delete_item"><i class="fa fa-trash"></i>
    </a>
</div>

{{-- modal edit --}}
<div class="modal fade" id="edit{{ $size->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content @if (app()->isLocale('ar')) text-end @else text-start @endif">
            <div class="modal-header mb-4 d-flex justify-content-between py-0 flex-row">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('sizes.editsize') }}</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('sizes.update', $size->id) }}" method="POST">
                <div class="modal-body p-0">
                    @csrf
                    @method('PUT')
                    <div
                        class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row mr-3 @else ml-3 @endif">
                        <label class="modal-label-width" for="name">@lang('sizes.sizename')</label>
                        <div
                            class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <input type="text" style="width: 100%"
                                class="form-control initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                                placeholder="@lang('sizes.sizename')" name="name" value="{{ old('name', $size->name) }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <button class="add-button d-flex justify-content-center align-items-center" type="button"
                                data-toggle="collapse" data-target="#translation_table_size" aria-expanded="false"
                                aria-controls="collapseExample">
                                <i class="fas fa-globe"></i>
                            </button>
                        </div>
                        @include('layouts.translation_inputs', [
                            'attribute' => 'name',
                            'translations' => [],
                            'type' => 'size',
                            'data' => $size,
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
