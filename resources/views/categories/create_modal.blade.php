<!-- Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{__('lang.add_category')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => 'categories.store', 'method' => 'post', 'files' => true,'id' =>'category-form' ]) !!}
            <div class="modal-body">
                <div class="form-group ">
                    <input type="hidden" name="quick_add" value="{{ isset($quick_add)&&$quick_add?$quick_add:'' }}">
                    <label for="name">@lang('categories.categorie_name')</label>
                    <div class="select_body d-flex justify-content-between align-items-center" >
                        <input type="text" required
                               class="form-control"
                               placeholder="@lang('categories.categorie_name')"
                               name="name"
                               value="{{ old('name') }}" >
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
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

                <div class="form-group">
                    <label for="parent_id">@lang('categories.parent')</label>
                    {!! Form::select(
                        'parent_id',
                        $categories,null,
                        ['class' => 'form-control select2 category','placeholder'=>__('lang.please_select')]
                    ) !!}

                    {{-- <select name="parent_id" class="form-control select2"  id="my-select">
                        <option value="" selected disabled readonly>---{{ __('select') }}---</option>
                        @forelse($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('parent_id', request()->parent_id ) ==$cat->id?'selected':null }} >
                                {{ $cat->name }}
                            </option>
                        @empty
                        @endforelse
                    </select> --}}
                    @error('parent_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="status">@lang('categories.status')</label>
                    <select name="status" class="form-control" required>
                        <option value="1" {{ old('status') == 1 ? 'selected' : null }}>{{ __('Active') }}</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : null }}>{{ __('Inactive') }}</option>
                    </select>
                    @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button  id="create-category-btn" class="btn btn-primary">{{__('lang.save')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CategoryRequest','#category-form'); !!}