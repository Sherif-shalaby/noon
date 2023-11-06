<!-- Modal -->
<div class="modal modal-add-color animate__animated" data-animate-in="animate__rollIn" data-animate-out="animate__rollOut"
    id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div
                class="modal-header mb-4 d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add') }}</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" action="{{ route('colors.store') }}" method="POST">
                @csrf
                <div class="modal-body p-0">
                    <div
                        class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <label class="modal-label-width" for="name">@lang('colors.colorname')</label>
                        <div
                            class="select_body input-wrapper d-flex justify-content-between align-items-center mb-2 form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <input type="text" required style="width: 100%"
                                class="form-control initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                                placeholder="@lang('colors.colorname')" name="name" value="{{ old('name') }}">
                            <button class="add-button d-flex justify-content-center align-items-center"
                                style="font-weight: 700;font-size: 26px" type="button" data-toggle="collapse"
                                data-target="#translation_table_color" aria-expanded="false"
                                aria-controls="collapseExample">
                                <i class="fas fa-globe"></i>
                            </button>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @include('layouts.translation_inputs', [
                            'attribute' => 'name',
                            'translations' => [],
                            'type' => 'color',
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

<script>
    $(document).ready(function() {
        var modelEl = $('.modal-add-color');

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
