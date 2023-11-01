<!-- Modal -->
<div class="modal modal-jobs-edit animate__animated" data-animate-in="animate__rollIn" data-animate-out="animate__rollOut"
    id="editModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div
                class="modal-header d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="edit">@lang('lang.edit')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['url' => route('jobs.update', $job->id), 'method' => 'put']) !!}
            <div class="modal-body">
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

                    <label class="width-140" for="job_title">@lang('lang.job_title')</label>
                    <input type="text"
                        class="form-control initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif"
                        value="{{ $job->title }}" name="title" id="title" required>

                </div>
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <div class="col-md-12 pt-2">
                        <h5 class="@if (app()->isLocale('ar')) text-end @else text-start @endif">@lang('lang.permissions')
                        </h5>
                    </div>
                </div>
                <div class="row @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    @foreach ($modulePermissionArray as $key_module => $moudle)
                        <div
                            class="col-md-3 d-flex @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                            {{ $moudle }}
                            {!! Form::checkbox(
                                'permissions[' . $key_module . ']',
                                1,
                                in_array($key_module, $uniqueModuleNames) ? true : false,
                                ['class' => 'check_box check_box_view mx-2', 'title' => __('lang.view')],
                            ) !!}

                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var modelEl = $('.modal-jobs-edit');

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
