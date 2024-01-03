<!-- ================== Modal 1 : createRegionModal ================== -->
<div class="modal fade" id="createRegionModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{__('lang.add_region')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => 'customers.storeRegion', 'method' => 'post', 'files' => true,'id' =>'customer-region-form' ]) !!}
            <div class="modal-body">
                <div class="form-group ">
                    {{-- store "state_id" in "hidden inputField" to send it to "storeRegion() method" in CustomerController --}}
                    <input type="hidden" name="state_id" id="stateId" />
                    <label for="name">@lang('lang.name')</label>
                    <div class="select_body d-flex justify-content-between align-items-center" >
                        <input type="text" required
                            class="form-control"
                            placeholder="@lang('lang.name')"
                            name="name"
                            id="cityNameId"
                            value="{{ old('name') }}" >
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button  type="submit" class="btn btn-primary" id="addNewRegion">{{__('lang.save')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- ================== Modal 2 : createQuarterModal ================== -->
<div class="modal fade" id="createQuarterModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{__('lang.add_quarter')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => 'customers.storeQuarter', 'method' => 'post', 'files' => true,'id' =>'customer-quarter-form' ]) !!}
            <div class="modal-body">
                <div class="form-group ">
                    {{-- store "city_id" in "hidden inputField" to send it to "storeQuarter() method" in CustomerController --}}
                    <input type="hidden" name="city_id" id="cityId" />
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
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button  type="submit" class="btn btn-primary" id="addNewQuarter">{{__('lang.save')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CustomerTypeRequest','#customer-type-form'); !!}

<script>

</script>
