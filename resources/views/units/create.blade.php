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
            <form class="form" action="{{ route('units.store') }}" method="POST" id={{isset($quick_add)&&$quick_add ?'quick_add_unit_form' : 'unit-form'}}>
                @csrf
                <div class="modal-body">
                    <div class="form-group ">
                        <input type="hidden" name="quick_add" value="{{ isset($quick_add)&&$quick_add?$quick_add:'' }}">
                        <label for="name">@lang('units.unitname')</label>
                        <div class="select_body d-flex justify-content-between align-items-center">
                            <input type="text" required class="form-control"
                                placeholder="@lang('units.unitname')" name="name" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <button class="btn btn-primary btn-sm ml-2" type="button"
                                data-toggle="collapse" data-target="#translation_table_customer_types"
                                aria-expanded="false" aria-controls="collapseExample">
                                {{ __('categories.addtranslations') }}
                            </button>
                        </div>
                        @include('layouts.translation_inputs', [
                            'attribute' => 'name',
                            'translations' => [],
                            'type' => 'customer_types',
                        ])
                    </div>
                    <div class="form-group">
                        <label for="base_unit_multiplier">@lang('units.base_unit_multiplier')</label>
                        <input type="number"  class="form-control" step="0.01" min="0"
                                placeholder="@lang('units.base_unit_multiplier') 0.00" name="base_unit_multiplier"
                                value="{{ old('base_unit_multiplier') }}">
                        @error('base_unit_multiplier')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('cancel') }}</button>
                    <button  id="create-unit-btn" class="btn btn-primary">{{__('lang.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\UnitRequest','#unit-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\UnitRequest','#quick_add_unit_form'); !!}
@endpush
