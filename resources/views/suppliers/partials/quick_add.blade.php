<!-- ================== Modal 1 : createRegionModal ================== -->
<div class="modal fade" id="createRegionModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div
                class="modal-header d-flex justify-content-between py-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{ __('lang.add_region') }}</h5>
                <button type="button" class="close mx-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => 'customers.storeRegion',
                'method' => 'post',
                'files' => true,
                'id' => 'customer-region-form',
            ]) !!}
            <div class="modal-body">
                <div
                    class="flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                    {{-- store "state_id" in "hidden inputField" to send it to "storeRegion() method" in CustomerController --}}
                    <input type="hidden" name="state_id" id="stateId" />
                    <label for="name">@lang('lang.name')</label>
                    <div class="select_body input-wrapper" style="width: 100%">
                        <input type="text" required
                            class="form-control @if (app()->isLocale('ar')) text-end @else text-start @endif initial-balance-input width-full mx-0"
                            placeholder="@lang('lang.name')" name="name" id="cityNameId" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button type="submit" class="btn btn-primary" id="addNewRegion">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- ================== Modal 2 : createQuarterModal ================== -->
<div class="modal fade" id="createQuarterModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div
                class="modal-header  d-flex justify-content-between py-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{ __('lang.add_quarter') }}</h5>
                <button type="button" class="close mx-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => 'customers.storeQuarter',
                'method' => 'post',
                'files' => true,
                'id' => 'customer-quarter-form',
            ]) !!}
            <div class="modal-body">
                <div
                    class=" flex-column mb-2 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                    {{-- store "city_id" in "hidden inputField" to send it to "storeQuarter() method" in CustomerController --}}
                    <input type="hidden" name="city_id" id="cityId" />
                    <label for="name">@lang('lang.name')</label>
                    <div class="select_body  input-wrapper" style="width: 100%">
                        <input type="text" required
                            class="form-control @if (app()->isLocale('ar')) text-end @else text-start @endif initial-balance-input width-full mx-0"
                            placeholder="@lang('lang.name')" name="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button type="submit" class="btn btn-primary" id="addNewQuarter">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CustomerTypeRequest', '#customer-type-form') !!}

<script></script>
