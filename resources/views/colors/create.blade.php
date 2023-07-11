<!-- Modal -->
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" action="{{ route('colors.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group ">
                        <label for="name">@lang('colors.colorname')</label>
                        <div class="select_body d-flex justify-content-between align-items-center">
                            <input type="text" required class="form-control"
                                placeholder="@lang('colors.colorname')" name="name" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <button class="btn btn-primary btn-sm ml-2" type="button"
                                data-toggle="collapse" data-target="#translation_table_category"
                                aria-expanded="false" aria-controls="collapseExample">
                                {{ __('categories.addtranslations') }}
                            </button>
                        </div>
                        @include('layouts.translation_inputs', [
                            'attribute' => 'name',
                            'translations' => [],
                            'type' => 'category',
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
