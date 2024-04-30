<div class="modal modal-supplier-add animate__animated add-supplier" data-animate-in="animate__rollIn" tabindex="-1"
    role="dialog" aria-hidden="true" style="display: none;z-index: 99;">
    <div class="modal-dialog rollIn  animated modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open([
                'url' => route('suppliers.store'),
                'method' => 'post',
                'id' => isset($quick_add) && $quick_add ? 'quick_add_supplier_form' : 'add_supplier',
            ]) !!}
            <div
                class="modal-header d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleLargeModalLabel">@lang('lang.add_supplier')</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {{-- {{ dd($countryId);  }} --}}
                    {{-- ++++++++++++++++++++++ name ++++++++++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">

                        <label for="name"
                            class="@if (app()->isLocale('ar')) d-block text-end mx-2 mb-0 @else mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;">@lang('lang.name')</label>
                        <div class="input-wrapper width-full">

                            {{-- <div class="select_body d-flex justify-content-between align-items-center"> --}}
                            <input type="text"
                                class="form-control width-full initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @endif"
                                placeholder="@lang('lang.name')" name="name" value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        {{-- </div> --}}

                    </div>
                    {{-- ++++++++++++++++++++++ company_name ++++++++++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">

                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-1  @else h5  mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;" for="name">@lang('lang.company_name')</label>
                        {{-- <div class="select_body d-flex justify-content-between align-items-center"> --}}
                        <div class="input-wrapper width-full">

                            <input type="text"
                                class="form-control width-full initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @endif"
                                placeholder="@lang('lang.company_name')" name="company_name" value="{{ old('company_name') }}">
                        </div>
                        @error('company_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        {{-- </div> --}}
                        {{-- </div> --}}
                    </div>
                    {{-- +++++++++++++++++++++++++++++++ email ++++++++++++++++++++++++ --}}
                    {{-- <div class="col-md-6 ">
                        <div class="form-group ">
                            <label for="email">@lang('lang.email')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="text"
                                       class="form-control"
                                       placeholder="@lang('lang.email')"
                                       name="email[]"
                                       value="{{ old('email') }}" >
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                    {{-- +++++++++++++++++++++++++++++++ exchange_rate ++++++++++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">


                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-1  @else h5  mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;" for="exchange_rate">@lang('lang.exchange_rate')</label>
                        {{-- <div class="select_body d-flex justify-content-between align-items-center"> --}}
                        <div class="input-wrapper width-full">

                            <input type="number"
                                class="form-control width-full initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @endif"
                                placeholder="@lang('lang.exchange_rate')" name="exchange_rate" style="border-color:#aaa"
                                value="{{ old('exchange_rate') }}">
                        </div>
                        @error('exchange_rate')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        {{-- </div> --}}

                    </div>
                    {{-- --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">

                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-1  @else h5  mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;" for="start_date">@lang('lang.start_date')</label>
                        {{-- <div class="select_body d-flex justify-content-between align-items-center"> --}}
                        <div class="input-wrapper width-full">

                            <input type="date"
                                class="form-control width-full initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @endif"
                                placeholder="@lang('lang.start_date')" name="start_date" value="{{ date('Y-m-d') }}">
                        </div>
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        {{-- </div> --}}

                    </div>
                    {{-- --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">

                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-1  @else h5  mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;" for="end_date">@lang('lang.end_date')</label>
                        {{-- <div class="select_body d-flex justify-content-between align-items-center"> --}}
                        <div class="input-wrapper width-full">

                            <input type="date"
                                class="form-control width-full initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @endif"
                                placeholder="@lang('lang.end_date')" name="end_date" value="{{ old('end_date') }}">
                        </div>
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        {{-- </div> --}}

                    </div>

                    {{-- +++++++++++++++++++++++++++++++ postal_code ++++++++++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-1  @else h5  mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;" for="postal_code">@lang('lang.postal_code')</label>
                        {{-- <div class="select_body d-flex justify-content-between align-items-center"> --}}
                        <div class="input-wrapper width-full">

                            <input type="text"
                                class="form-control width-full initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @endif"
                                placeholder="@lang('lang.postal_code')" name="postal_code" value="{{ old('postal_code') }}">
                        </div>
                        @error('postal_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        {{-- </div> --}}
                    </div>
                    {{-- +++++++++++++++++++++++++++++++ address ++++++++++++++++++++++++ --}}
                    {{-- <div class="col-md-3 p-0 ">
                        <div class="form-group ">
                            <label for="address">@lang('lang.address')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <textarea class="form-control" placeholder="@lang('lang.address')" name="address"value="{{ old('address') }}" ></textarea>
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                    {{-- +++++++++++++++++++++++++++++++ city ++++++++++++++++++++++++ --}}
                    {{-- <div class="col-md-3 p-0">
                        <div class="form-group ">
                            <label for="city">@lang('lang.city')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="text"
                                       class="form-control"
                                       placeholder="@lang('lang.city')"
                                       name="city"
                                       value="{{ old('city') }}" >
                                @error('city')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                    {{-- ========================== country ==================== --}}
                    {{-- <div class="col-md-3 p-0">
                        <div class="form-group ">
                            <label for="country">@lang('lang.country')</label>
                            <div class="select_body d-flex justify-content-between align-items-center" >
                                <input type="text"
                                       class="form-control"
                                       placeholder="@lang('lang.country')"
                                       name="country"
                                       value="{{ old('country') }}" >
                                @error('country')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                    {{-- +++++++++++++++++++++++ owner_debt_in_dinar +++++++++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-1  @else h5  mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;"
                            for="owner_debt_in_dinar">@lang('lang.owner_debt_in_dinar')</label>
                        <div class="input-wrapper width-full">

                            <input type="number"
                                class="form-control width-full initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @endif"
                                style="border-color:#aaa" name="owner_debt_in_dinar" id="owner_debt_in_dinar" />
                        </div>
                    </div>
                    {{-- +++++++++++++++++++++++ owner_debt_in_dollar +++++++++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-1  @else h5  mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;"
                            for="owner_debt_in_dollar">@lang('lang.owner_debt_in_dollar')</label>
                        <div class="input-wrapper width-full">

                            <input type="number"
                                class="form-control width-full initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @endif"
                                style="border-color:#aaa" name="owner_debt_in_dollar" id="owner_debt_in_dollar" />
                        </div>
                    </div>

                    {{--                    --}}{{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
                    {{--                    <div class="col-md-3 p-0"> --}}
                    {{--                        <label for="country-dd">@lang('lang.country')</label> --}}
                    {{--                        <select id="country-dd" name="country" class="form-control" disabled> --}}
                    {{--                            <option value="{{ $countryId }}"> --}}
                    {{--                                {{ $countryName }} --}}
                    {{--                            </option> --}}
                    {{--                        </select> --}}
                    {{--                    </div> --}}
                    {{--                    --}}{{-- ++++++++++++++++ state selectbox +++++++++++++++++ --}}
                    {{--                    <div class="col-md-3 p-0"> --}}
                    {{--                        <div class="form-group"> --}}
                    {{--                            <label for="state-dd">@lang('lang.state')</label> --}}
                    {{--                            <select id="state-dd" name="state_id" class="form-control"> --}}
                    {{--                                @php --}}
                    {{--                                    $states = \App\Models\State::where('country_id', $countryId)->get(['id','name']); --}}
                    {{--                                @endphp --}}
                    {{--                                @foreach ($states as $state) --}}
                    {{--                                    <option value="{{ $state->id }}"> --}}
                    {{--                                        {{ $state->name }} --}}
                    {{--                                    </option> --}}
                    {{--                                @endforeach --}}
                    {{--                            </select> --}}
                    {{--                        </div> --}}
                    {{--                    </div> --}}
                    {{--                    --}}{{-- ++++++++++++++++ city selectbox +++++++++++++++++ --}}
                    {{--                    <div class="col-md-3 p-0"> --}}
                    {{--                        <div class="form-group"> --}}
                    {{--                            <label for="city-dd">@lang('lang.city')</label> --}}
                    {{--                            <select id="city-dd" name="city_id" class="form-control"></select> --}}
                    {{--                        </div> --}}
                    {{--                    </div> --}}
                    {{-- +++++++++++++++++++++++++++++++ email array ++++++++++++++++++++++++ --}}
                    <div
                        class="col-md-6 d-flex mb-2 align-items-center
                        @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <div class="form-group ">
                            <table class="bordered">
                                <thead class="email_thead">
                                    <tr>
                                        <th class="text-left"
                                            style="font-weight: normal!important;background-color: transparent!important;color:black!important">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="email_tbody">
                                    <tr>
                                        <td
                                            class="col-md-12 d-flex mb-2 align-items-center p-0  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label
                                                class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-0  @else h5  mx-2 mb-0 @endif
                                "
                                                style="font-size: 12px">
                                                @lang('lang.email')
                                            </label>
                                            <div class="d-flex justify-content-center align-items-center select_body"
                                                style="background-color: #dedede; border: none;
                                                        border-radius: 16px;
                                                        color: #373737;
                                                        box-shadow: 0 8px 6px -5px #bbb;
                                                        width: 60%;
                                                        margin: auto;
                                                        height: 30px;
                                                        flex-wrap: nowrap;">
                                                <input type="text"
                                                    class="form-control width-full width-full initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @endif"
                                                    placeholder="@lang('lang.email')" name="email[]"
                                                    value="{{ old('email') }}" required>
                                                @error('email')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                <a href="javascript:void(0)"
                                                    class=" d-flex justify-content-center align-items-center text-center text-decoration-none text-white add-button addRow_email "
                                                    type="button">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- +++++++++++++++++++++++++++++++ mobile_number array ++++++++++++++++++++++++ --}}
                    <div class="col-md-6 d-flex mb-2 align-items-center
                         flex-row-reverse">
                        <div class="form-group">

                            <table class="bordered" style="width: 100%">
                                <thead class="phone_thead">
                                    <tr>
                                        <th class="text-left"
                                            style="font-weight: normal!important;background-color: transparent!important;color:black!important">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="phone_tbody">
                                    <tr>
                                        <td
                                            class="col-md-12 d-flex mb-2 align-items-center p-0  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                            <label style="font-size: 12px"
                                                class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-0  @else h5  mx-2 mb-0 @endif
                                ">
                                                @lang('lang.phone_number')
                                            </label>
                                            <div class="d-flex justify-content-center align-items-center select_body"
                                                style="background-color: #dedede; border: none;
                                                        border-radius: 16px;
                                                        color: #373737;
                                                        box-shadow: 0 8px 6px -5px #bbb;
                                                        width: 60%;
                                                        margin: auto;
                                                        height: 30px;
                                                        flex-wrap: nowrap;">
                                                <input type="text"
                                                    class="form-control width-full initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @endif"
                                                    style="width: 100%" placeholder="@lang('lang.phone_number')"
                                                    name="mobile_number[]" value="{{ old('mobile_number') }}"
                                                    required>
                                                @error('mobile_number')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror

                                                {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                <a href="javascript:void(0)"
                                                    class=" d-flex justify-content-center align-items-center text-center text-decoration-none text-white add-button addRow"
                                                    type="button">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ++++++++++++ images ++++++++++++ --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">

                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-1  @else h5  mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;">@lang('lang.image')</label>
                        <div class="input-wrapper width-full">
                            <input
                                class="form-control img width-full initial-balance-input my-0 @if (app()->isLocale('ar')) text-end @endif"
                                style="width: 100%" name="image" type="file" accept="image/*">
                            {{-- <div class="dropzone" id="my-dropzone">
                                    <div class="dz-message" data-dz-message><span>@lang('categories.drop_file_here_to_upload')</span></div>
                                </div> --}}
                        </div>
                        @error('cover')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    {{-- ++++++++++++++++ countries selectbox : الدولة : (countries table) +++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-1  @else h5  mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;" for="country-dd">@lang('lang.country')</label>
                        <div class="input-wrapper" style="width: 100%;!important">
                            <select id="country-dd" name="country" class="form-select  initial-balance-input m-auto"
                                style="width: 100%; border:2px solid #ccc" disabled>
                                <option value="{{ $countryId }}">
                                    {{ $countryName }}
                                </option>
                            </select>
                        </div>
                    </div>
                    {{-- ++++++++++++++++ state selectbox : المحافظة : (states table) +++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-1  @else h5  mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;" for="state-dd">@lang('lang.state')</label>
                        <div class="input-wrapper" style="width: 100%;!important">
                            <select id="state-dd" name="state_id"
                                class="form-select select2 initial-balance-input m-auto"
                                style="width: 100%; border:2px solid #ccc">
                                @php
                                    $states = \App\Models\State::where('country_id', $countryId)->get(['id', 'name']);
                                @endphp
                                <option value=""> @lang('lang.please_select')</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- ++++++++++++++++ regions selectbox : المناطق : (cities table) +++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-1  @else h5  mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;" for="city-dd">@lang('lang.regions')</label>
                        <div class="input-wrapper" style="width: 100%;!important">
                            <select id="city-dd" name="city_id"
                                class="form-select select2 initial-balance-input m-auto"
                                style="width: 100%; border:2px solid #ccc"></select>
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" id="cities_id" data-target="#createRegionModal">
                                        <i class="fas fa-plus"></i>
                                    </button> --}}
                        </div>
                    </div>
                    {{-- ++++++++++++++++ quarter selectbox : الاحياء +++++++++++++++++ --}}
                    <div
                        class="mb-2 col-md-3 p-0 d-flex animate__animated animate__bounceInLeft flex-column py-0 px-1 @if (app()->isLocale('ar')) align-items-end @else align-items-start @endif">
                        <label
                            class="@if (app()->isLocale('ar')) d-block text-end h5  mx-2 mb-1  @else h5  mx-2 mb-0 @endif
                                "
                            style ="font-size: 12px;font-weight: 500;" for="quarters_id">@lang('lang.quarters')</label>
                        <div class="input-wrapper" style="width: 100%;!important">
                            <select id="quarter-dd" class="form-select select2  initial-balance-input m-auto"
                                style="width: 100%; border:2px solid #ccc" name="quarter_id"></select>
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" id="add_quarters_btn_id" data-target="#createQuarterModal">
                                        <i class="fas fa-plus"></i>
                                    </button> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button id="create-supplier-btn" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
            {{-- ++++++++++++ Quick_Add "city","quarter" Modal ++++++++++++ --}}
            @include('suppliers.partials.quick_add')
        </div>
    </div>
</div>
@push('js')
    <script>
        // ++++++++++++++++++++++ Countries , State , Cities Selectbox ++++++++++++++++
        // ================ state selectbox ================
        $('#state-dd').change(function(event) {
            // Capture the selected state value
            var idState = this.value;
            $('#city-dd').html('');
            $.ajax({
                url: "/api/customers/fetch-cities",
                type: 'POST',
                dataType: 'json',
                data: {
                    state_id: idState,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#city-dd').html('<option value="">Select State</option>');
                    $.each(response.cities, function(index, val) {
                        $('#city-dd').append('<option value="' + val.id + '">' + val.name +
                            '</option>')
                    });
                }
            })
        });
        // ================ city selectbox ================
        // ++++++++++++ store "state_id" in hidden inputField in "cities modal" ++++++++++
        $("#cities_id").on('click', function() {
            var state_id = $("#state-dd").val();
            $("#stateId").val(state_id);
            console.log("+++++++++++++++++++++++++++ " + state_id + " +++++++++++++++++++++++++++");
        });
        // ================ quarter selectbox ================
        $('#city-dd').change(function(event) {
            // Capture the selected city value
            var idCity = this.value;
            $('#quarter-dd').html('');
            $.ajax({
                url: "/api/customers/fetch-quarters",
                type: 'POST',
                dataType: 'json',
                data: {
                    city_id: idCity,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log("Quarter = " + response.quarters);
                    $('#quarter-dd').html('<option value="">Select Quarter</option>');
                    $.each(response.quarters, function(index, val) {
                        $('#quarter-dd').append('<option value="' + val.id + '">' + val.name +
                            '</option>')
                    });
                }
            })
        });
        // ++++++++++++ store "cities_id" in hidden inputField in "quarter modal" ++++++++++
        $("#add_quarters_btn_id").on('click', function() {
            var city_id = $("#city-dd").val();
            $("#cityId").val(city_id);
            console.log("+++++++++++++++++++++++++++ " + city_id + " +++++++++++++++++++++++++++");
        });
    </script>
@endpush
