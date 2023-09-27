<!-- Modal -->
<div class="modal fade" id="createCustomerTypesModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{__('lang.add_customer_type')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => 'customertypes.store', 'method' => 'post', 'files' => true,'id' =>'customer-type-form' ]) !!}
            <div class="modal-body">
                <div class="form-group ">
                    <label for="name">@lang('lang.name')</label>
                    <div class="select_body d-flex justify-content-between align-items-center" >
                        <input type="text" required
                               class="form-control"
                               placeholder="@lang('lang.name')"
                               name="name"
                               value="{{ old('name') }}" >
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <button  class="btn btn-primary btn-sm ml-2" type="button"
                            data-toggle="collapse" data-target="#translation_table_customertype"
                            aria-expanded="false" aria-controls="collapseExample">
                            <i class="fas fa-globe"></i>
                        </button>
                    </div>
                    @include('layouts.translation_inputs', [
                        'attribute' => 'name',
                        'translations' => [],
                        'type' => 'customertype',
                    ])
                </div>

                {{-- <div class="form-group">
                    <label for="store_id">@lang('lang.store')</label>
                    {!! Form::select(
                        'store_id',
                        $stores,null,
                        ['class' => 'form-control select2 category','placeholder'=>__('lang.please_select')]
                    ) !!}
                    @error('store_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button  type="submit" class="btn btn-primary">{{__('lang.save')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CustomerTypeRequest','#customer-type-form'); !!}
