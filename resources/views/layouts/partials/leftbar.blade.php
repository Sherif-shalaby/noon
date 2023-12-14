<!-- Start Leftbar -->
<div class="leftbar" style="z-index: 9999">
    {{--    <div class="col-md-12 align-self-center"> --}}
    {{--        <div class="infobar"> --}}
    {{--            <ul class="list-inline mb-0"> --}}
    {{--                <li class="list-inline-item menubar-toggle" @if (request()->segment(2) == 'invoices') style="display: inline-block;!important;"@endif> --}}
    {{--                    <div class="menubar"> --}}
    {{--                        <a class="menu-hamburger navbar-toggle bg-transparent" href="javascript:void();" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="true"> --}}
    {{--                            <img src="{{asset('images/svg-icon/collapse.svg')}}" class="img-fluid menu-hamburger-collapse" alt="collapse"> --}}
    {{--                            <img src="{{asset('images/svg-icon/close.svg')}}" class="img-fluid menu-hamburger-close" alt="close"> --}}
    {{--                        </a> --}}
    {{--                    </div> --}}
    {{--                </li> --}}
    {{--            </ul> --}}
    {{--        </div> --}}
    {{--    </div> --}}
    <!-- Start Profilebar -->
    <div class="profilebar text-center">
        {{--                    <img src="{{asset('images/users/profile.svg')}}" class="img-fluid" alt="profile"> --}}
        <div class="profilename">
            {{--            <h5>{{\Illuminate\Support\Facades\Auth::user()->name}}</h5> --}}
            {{--                        <p>Social Media Strategist</p> --}}
        </div>
        <div class="userbox">
            <a href="{{ route('logout') }}" class="profile-icon"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <img src="{{ asset('images/svg-icon/logout.svg') }}" class="img-fluid" alt="logout">
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <div class="profilename" style="padding-top: 20px">
            <a href="https://api.whatsapp.com/send?phone={{ $settings['watsapp_numbers'] }}">
                <img src="{{ asset('images/topbar/whatsapp.jpg') }}" class="img-fluid" alt="notifications"
                    width="45px" height="45px">
            </a>
        </div>
        <div class="profilename">
            <a href="{{ route('invoices.create') }}">
                <img src="{{ asset('images/topbar/cash-machine.png') }}" class="img-fluid" alt="notifications"
                    width="45px" height="45px">
            </a>
        </div>
        <div class="profilename ">
            <a>
                <button class="btn-danger btn-sm" id="power_off_btn"><i class="fa fa-power-off"></i></button>
            </a>
        </div>


        {{-- +++++++++++++++++ Notification +++++++++++++++++ --}}
        @include('layouts.partials.notification_list')
        @php
            $flags = (object) [
                'en' => 'us',
                'ar' => 'eg',
            ];
            $local_code = LaravelLocalization::getCurrentLocale();
        @endphp
        <div class="languagebar">
            <div class="dropdown">
                <a class="dropdown-toggle text-black text-decoration-none" href="#" role="button"
                    id="languagelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                        class="dripicons-web"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languagelink">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="languagebar">

        </div>
    </div>


    <div id="toggleDollar" style="width: 50px;height: 120px;background-color: red;cursor: pointer;">

    </div>
    <!-- End Profilebar -->

</div>
<!-- End Leftbar -->

<script>
    var toggleDollarButton = document.getElementById('toggleDollar');

    toggleDollarButton.addEventListener('click', function() {

        const value = localStorage.getItem("showHideDollar");
        if (value === null) {
            localStorage.setItem("showHideDollar", "hide");
        } else {
            if (localStorage.getItem("showHideDollar") == "show") {
                localStorage.setItem("showHideDollar", "hide");
            } else {
                localStorage.setItem("showHideDollar", "show");
            }
        }

        var dollarCells = document.getElementsByClassName('dollar-cell');

        for (var i = 0; i < dollarCells.length; i++) {
            dollarCells[i].classList.toggle('showHideDollarCells')
        }

        var exRateCells = document.getElementsByClassName('ex-rate-cell');

        for (var i = 0; i < dollarCells.length; i++) {
            exRateCells[i].classList.toggle('showHideExRateCells')
        }
    })

    toggleDollarButton.addEventListener('click', function() {

        var myExRateCells = document.getElementsByClassName('my-ex-rate-cell');

        for (var i = 0; i < dollarCells.length; i++) {
            myExRateCells[i].classList.toggle('showHideMyExRateCell')
        }

    })
</script>
