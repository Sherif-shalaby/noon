<!-- Modal -->
<div class="modal fade createSubCategoryModal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" style="display: none;"
     aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{__('lang.add_category')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => 'categories.store', 'method' => 'post', 'files' => true,'id' =>'create-category-form' ]) !!}
            <div class="modal-body">
                <div class="form-group ">
                    <input type="hidden" name="quick_add" value="{{ isset($quick_add)&&$quick_add?$quick_add:'' }}">
                    <label for="name">@lang('categories.categorie_name')</label>
                    <div class="select_body d-flex justify-content-between align-items-center" >
                        <input type="text" required
                               class="form-control category-name"
                               placeholder="@lang('categories.categorie_name')"
                               name="name"
                               value="{{ old('name') }}" >
                       
                        <button  class="btn btn-primary btn-sm ml-2" type="button"
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
                {{-- <div class="form-group">
                    <input type="hidden"
                    class="form-control parent_id"
                    placeholder="@lang('categories.categorie_name')"
                    name="parent_id"
                    value="{{ old('parent_id') }}" >
                </div> --}}
                <div class="form-group">
                    <label for="status">@lang('categories.status')</label>
                    <select name="status" class="form-control" required>
                        <option value="1" selected>{{ __('Active') }}</option>
                        <option value="0">{{ __('Inactive') }}</option>
                    </select>
                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button id="create-category-btn" class="btn btn-primary">{{__('lang.save')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CategoryRequest','#create-category-form'); !!}
<script>
    {{--$(document).ready(function () {--}}
    {{--    // Attach a click event handler to the button--}}
    {{--    $('.select_sub_category').click(function () {--}}
    {{--        // Get the data-select_category attribute value--}}
    {{--         {{ $selectCategoryValue }} = $(this).data('select_category');--}}
    {{--        // Set the value in the modal--}}
    {{--        $('#selectedCategoryValue').text(selectCategoryValue);--}}
    {{--    });--}}
    {{--});--}}
</script>
