<!-- Start Leftbar -->
<div class="leftbar">
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
        @php
            $cash_register = App\Models\CashRegister::where('user_id', Auth::user()->id)
                ->where('status', 'open')
                ->first();
        @endphp
        <div class="profilename {{ empty($cash_register) ? 'd-none' : '' }}">
            <a>
                <button class="btn-danger btn-sm" id="power_off_btn"><i class="fa fa-power-off"></i></button>
            </a>
        </div>
        {{--                    <div class="notifybar"> --}}
        {{--                        <a href="javascript:void(0)" id="infobar-notifications-open" class="infobar-icon"> --}}
        {{--                            <img src="{{asset('images/svg-icon/notifications.svg')}}" class="img-fluid" alt="notifications"> --}}
        {{--                            <span class="live-icon"></span> --}}
        {{--                        </a> --}}
        {{--                    </div> --}}

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
                <a class="dropdown-toggle text-black" href="#" role="button" id="languagelink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="dripicons-web"
                        style="width: 26px;height: 26px;"></i>&nbsp;</a>
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
        {{-- <div class="languagebar">
            <div class="dropdown">
                <a class="dropdown-toggle text-black" href="#" role="button" id="languagelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="dripicons-web" style="width: 26px;height: 26px;"></i>&nbsp; <span class="online-balance-badge badge bg-danger {{$notification_count>0?'show':'hide'}}">{{$notification_count}}</span></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languagelink">
                    @foreach ($notifications as $index => $notification)
                    <a class="notification_item"
                        data-mark-read-action="{{action('NotificationController@markAsRead', $notification->id)}}"
                        data-href="{{action('ProductController@index')}}?product_id={{$notification->product->id}}"
                        >
                        <p style="margin:0px"><i class="fa fa-exclamation-triangle " style="color: rgb(255, 187, 60)"></i>
                            @lang('lang.alert_quantity')
                            {{$notification->product->name??''}} ({{$notification->variation->sku??''}})</p>
                        <br>
                        <span class="text-muted">@lang('lang.alert_quantity'):
                            {{@num_format($notification->alert_quantity??0)}}</span> <br>
                        <span class="text-muted">@lang('lang.in_stock'):
                            {{@num_format($notification->qty_available??0)}}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div> --}}
    </div>

    <!-- End Profilebar -->

</div>
<!-- End Leftbar -->
