@extends('layouts.app')
@section('title', __('lang.add_plan'))
@push('css')
    <style>
        /* Set the size of the div element that contains the map */
        #map {
            height: 400px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }
    </style>
@endpush

@section('breadcrumbbar')
    <div class="animate-in-page">
        <div class="breadcrumbbar">
            <div class="row align-items-center">
                <div class="col-md-8 col-lg-8">
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.add_plan')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ url('/') }}">/
                                    @lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif "><a
                                    style="text-decoration: none;color: #596fd7" href="{{ route('delivery.index') }}">/
                                    @lang('lang.delivery')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active"
                                aria-current="page">@lang('lang.add_plan')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div
                        class="widgetbar  d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a href="{{ route('delivery.index') }}" class="btn btn-primary">
                            @lang('lang.delivery')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">
        <!-- Start row -->
        <div class="row d-flex justify-content-center">
            {{-- {{ dd($countryName) }}  --}}
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30 p-2">
                    {!! Form::open([
                        'route' => 'delivery.store',
                        'method' => 'post',
                        'enctype' => 'multipart/form-data',
                        'id' => 'customer-form',
                    ]) !!}
                    <div class="container-fluid">
                        <div class="row pt-5">
                            <div class="col-sm-12">
                                <label for="date">@lang('lang.date')</label>
                                <input type="date" class="form-control" name="date" id="date"
                                    placeholder="@lang('lang.date')">
                            </div>

                            <input type="hidden" class="form-control" name="delivery_id" value="{{ $delivery->id }}">
                            {{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
                            <div class="col-md-4">
                                <label for="country-dd">@lang('lang.country')</label>
                                <select id="country-dd" name="country" class="form-control" disabled>
                                    <option value="{{ $countryId }}">
                                        {{ $countryName }}
                                    </option>
                                </select>
                            </div>
                            {{-- ++++++++++++++++ state selectbox +++++++++++++++++ --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state-dd">@lang('lang.state')</label>
                                    <select id="state-dd" name="state_id" class="form-control">
                                        @php
                                            $states = \App\Models\State::where('country_id', $countryId)->get(['id', 'name']);
                                        @endphp
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- ++++++++++++++++ city selectbox +++++++++++++++++ --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city-dd">@lang('lang.city')</label>
                                    <select id="city-dd" name="city_id" class="form-control"></select>
                                </div>
                            </div>

                            <div id='customers-checkboxes' class="col-md-6" style="margin-bottom: 20px">

                            </div>


                        </div>
                        <div id="map"></div>

                        <div class="row pb-5">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKqlJypSBrs_U2e1RfhpyM4CQ87hiVzCM&callback=initMap"></script>

    <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
                d[l](f, ...n))
        })
        ({
            key: "AIzaSyBKqlJypSBrs_U2e1RfhpyM4CQ87hiVzCM",
            v: "beta"
        });
    </script>

    <script>
        // ================ state selectbox ================
        $('#state-dd').change(function(event) {
            var idState = this.value;
            $('#city-dd').html('');
            $.ajax({
                url: "/api/fetch-cities",
                type: 'POST',
                dataType: 'json',
                data: {
                    state_id: idState,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#city-dd').html('<option value="">Select State</option>');
                    console.log(response);
                    $.each(response.cities, function(index, val) {
                        $('#city-dd').append('<option value="' + val.id + '">' + val.name +
                            '</option>')
                    });
                }
            })
        });
        var map; // Declare map variable in an outer scope
        var bounds;
        // Function to initialize the map and add markers
        function initMap() {
            const position = {
                lat: 33.312805,
                lng: 44.361488
            };
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: position
            });
            // Initialize bounds object
            bounds = new google.maps.LatLngBounds();

        }
        $('#city-dd').change(function(event) {
            var cityId = this.value;
            $('#customers-checkboxes').html(''); // Clear existing checkboxes

            $.ajax({
                url: "/api/fetch-customers-by-city",
                type: 'POST',
                dataType: 'json',
                data: {
                    city_id: cityId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Add customers as checkboxes
                    $.each(response.customers, function(index, customer) {
                        var checkbox = '<div class="form-check">';
                        checkbox +=
                            '<input class="form-check-input" type="checkbox" name="customers[]" value="' +
                            customer.id + '">';
                        checkbox += '<label class="form-check-label">' + customer.name +
                            '</label>';
                        checkbox += '</div>';
                        $('#customers-checkboxes').append(checkbox);
                    });

                    // Add markers for customer locations
                    response.customers.forEach(function(customer) {
                        var marker = new google.maps.Marker({
                            position: {
                                lat: parseFloat(customer.latitude),
                                lng: parseFloat(customer.longitude)
                            },
                            map: map,
                            title: customer
                                .name // Display customer name as marker title
                        });
                        console.log(marker);
                        // Extend bounds with marker position
                        bounds.extend(marker.getPosition());
                    });
                    // Set map center and zoom to fit all markers
                    //  map.fitBounds(bounds);


                }
            });
        });
    </script>
@endpush
