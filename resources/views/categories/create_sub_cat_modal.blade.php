<!-- Modal -->
<div class="modal modal-cat animate__animated createSubCategoryModal" data-animate-in="animate__rollIn"
    data-animate-out="animate__rollOut" id="editModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleStandardModalLabel" style="display: none;opacity: 0;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">

            <div
                class="modal-header d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{ __('lang.add_category') }}</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => 'categories.store',
                'method' => 'post',
                'files' => true,
                'id' => 'create-category-form',
            ]) !!}
            <div class="modal-body">
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <input type="hidden" name="quick_add"
                        value="{{ isset($quick_add) && $quick_add ? $quick_add : '' }}">
                    <label class="col-md-3" for="name">@lang('categories.categorie_name')</label>
                    <div class="col-md-9 d-flex justify-content-between p-0 align-items-center select_body position-relative @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
                        style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                        <input type="text" required
                            class='form-control category-name initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @else text-start @endif'
                            style="width: 100%; margin-right: 0" placeholder="@lang('categories.categorie_name')" name="name"
                            value="{{ old('name') }}">
                        <button class="add-button d-flex justify-content-center align-items-center" type="button"
                            data-toggle="collapse" data-target="#translation_table_category" aria-expanded="false"
                            aria-controls="collapseExample">
                            <i class="fas fa-globe"></i>
                        </button>
                        @include('layouts.translation_inputs', [
                            'attribute' => 'name',
                            'translations' => [],
                            'type' => 'category',
                        ])
                    </div>
                </div>
                {{-- <div class="form-group">
                    <input type="hidden"
                    class="form-control parent_id"
                    placeholder="@lang('categories.categorie_name')"
                    name="parent_id"
                    value="{{ old('parent_id') }}" >
                </div> --}}
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <label class="col-md-3" for="status">@lang('categories.status')</label>
                    <div class="col-md-9 d-flex justify-content-center align-items-center"
                        style="background-color: #dedede; border: none;
                                        border-radius: 16px;
                                        color: #373737;
                                        box-shadow: 0 8px 6px -5px #bbb;
                                        width: 60%;
                                        margin: auto;
                                        height: 30px;
                                        flex-wrap: nowrap;">
                        <select name="status" style="background-color: transparent;width: 100%;border: none" required>
                            <option value="1" selected>{{ __('Active') }}</option>
                            <option value="0">{{ __('Inactive') }}</option>
                        </select>
                    </div>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button id="create-category-btn" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CategoryRequest', '#create-category-form') !!}
<script>
    {{-- $(document).ready(function () { --}}
    {{--    // Attach a click event handler to the button --}}
    {{--    $('.select_sub_category').click(function () { --}}
    {{--        // Get the data-select_category attribute value --}}
    {{--         {{ $selectCategoryValue }} = $(this).data('select_category'); --}}
    {{--        // Set the value in the modal --}}
    {{--        $('#selectedCategoryValue').text(selectCategoryValue); --}}
    {{--    }); --}}
    {{-- }); --}}
</script>

<script>
    $(document).ready(function() {
        var modelEl = $('.modal-cat');

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
