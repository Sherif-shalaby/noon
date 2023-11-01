<div class="modal modal-jobs animate__animated   add-job" data-animate-in="animate__rollIn"
    data-animate-out="animate__rollOut" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['url' => route('jobs.store'), 'method' => 'post', 'id' => 'add_job']) !!}
            <div
                class="modal-header d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleLargeModalLabel">@lang('lang.add')</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('title', __('lang.job_title') . '*', ['class' => 'width-140']) !!}
                    {!! Form::text('title', null, [
                        'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                        'placeholder' => __('lang.job_title'),
                        'required',
                    ]) !!}
                </div>
                <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
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
                            {!! Form::checkbox('permissions[' . $key_module . ']', 1, false, [
                                'class' => 'check_box check_box_view mx-2',
                                'title' => __('lang.view'),
                            ]) !!}

                        </div>
                    @endforeach
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                {!! Form::submit(__('lang.save'), ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var modelEl = $('.modal-jobs');

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
