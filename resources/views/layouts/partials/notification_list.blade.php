<style>
    .unread {
        color: black !important;
        font-weight: bold !important;
        cursor: pointer;
    }

    .read {
        opacity: 0.8 !important;
        cursor: pointer;
    }
    ul.dropdown-menu
    {
        height: 205px;
        overflow-y: auto;
        min-width: 360px;
        overflow-x: hidden;
        padding: 0 !important;
        text-align: left !important;
    }
    ul.dropdown-menu li
    {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }
    .no_new_notification_div
    {
        padding-top: 27px !important;
        padding-bottom: 27px !important;
    }
    .notification-box
    {
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        padding: 10px;
        margin: 10px 5px;
        border-radius: 5px;
    }

</style>
@php
    // $new_notifications = App\Models\Notification::where('id', Auth::user()->id)->whereDate('created_at',
    // date('Y-m-d'))->orderBy('created_at', 'desc')->with(['created_by_user', 'product', 'transaction'])->limit(2)->get();
    // $new_count = $new_notifications->where('is_seen', 0)->count();
    // $earlier_notifications = App\Models\Notification::where('id', Auth::user()->id)->whereDate('created_at', '<', date('Y-m-d'))->orderBy('created_at', 'desc')->with(['created_by_user', 'product', 'transaction'])->limit(2)->get();
@endphp
{{-- +++++++++++++++++ New (Unread) Notification +++++++++++++++++ --}}
<ul>
    <li class="nav-item dropdown">
        <a class="nav-link text-light  notification-list" href="#" id="navbarDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bell" style="color:rgb(101,110,249)"></i>
            {{-- ///////// Unread Notification Count ///////// --}}
            @if( auth()->user()->unreadNotifications->count() > 0 )
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-number">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </a>
        {{-- ///////// Unread Notifications ///////// --}}
        <ul class="dropdown-menu">
            <li class="head text-light bg-dark">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-12">
                        {{-- "unreadNotifications_count" button --}}
                        <span>Notifications ({{ auth()->user()->unreadNotifications->count() }})</span>
                        {{-- "mark_all_as_read" button --}}
                        <a href="{{route('Notification.Read')}}" class="float-right text-light">Mark all as read</a>
                    </div>
            </li>
            {{-- +++++++++++++++ All "unread Notifications" +++++++++++++++ --}}
            @forelse ( auth()->user()->unreadNotifications as $notificationVar )
                {{-- +++++++++++ create_employee ++++++++++++ --}}
                @if($notificationVar->data['type'] == "create_employee")
                    <li class="notification-box">
                        <div class="row">
                                <div class="col-lg-8 col-sm-8 col-8">
                                    <p style="font-weight: bold">{{ __('lang.create_new_employee') }}</p>
                                    created_by : <strong class="text-info">{{ $notificationVar->data['created_by'] }}</strong>
                                    <br/> employee_name : <strong class="text-info">{{ $notificationVar->data['employee_name'] }} </strong>
                                    <div>
                                        <a href="{{ route('Notification.delete',$notificationVar->id) }}" style="color:#00f">حذف المنشور</a>
                                    </div>
                                    <small class="text-warning">
                                        created_at : {{ $notificationVar->created_at }}
                                    </small>
                                </div>
                            {{-- </a> --}}
                        </div>
                    </li>
                @endif
                {{-- +++++++++++ create_product ++++++++++++ --}}
                @if($notificationVar->data['type'] == "create_product")
                    <li class="notification-box">
                        <div class="row">
                                <div class="col-lg-8 col-sm-8 col-8">
                                    <p style="font-weight: bold">{{ __('lang.create_new_product') }}</p>
                                    created_by : <strong class="text-info">{{ $notificationVar->data['created_by'] }}</strong>
                                    <br/> product_name : <strong class="text-info">{{ $notificationVar->data['product_name'] }} </strong>
                                    <div>
                                        <a href="{{ route('Notification.delete',$notificationVar->id) }}" style="color:#00f">حذف المنشور</a>
                                    </div>
                                    <small class="text-warning">
                                        created_at : {{ $notificationVar->created_at }}
                                    </small>
                                </div>
                            {{-- </a> --}}
                        </div>
                    </li>
                @endif
                {{-- ++++++++++++++++++++ expiry_alert Notification ++++++++++++++++++++ --}}
                @if($notificationVar->data['type'] == 'expiry_alert')
                    <li>
                        <p style="margin:0px;margin-top:10px;margin-bottom:5px;">
                            <i class="fa fa-exclamation-triangle" style="color: rgb(255, 187, 60)"></i>
                            @lang('lang.expiry_alert')
                        </p>

                        <span class="text-muted">@lang('lang.product'):
                            @php
                                $product_var = \App\Models\Product::select('name','sku')->where('id', $notificationVar->data['product_id'])->first();
                            @endphp
                            {{ $product_var['name'] }} ({{ $product_var['sku'] }}) <br/> @lang('lang.will_be_exired_in')
                            {{$notificationVar->data['days']}} @lang('lang.days')</span> <br />
                        <span class="text-muted">@lang('lang.in_stock') :
                            {{@num_format($notificationVar->data['qty_available'])}}</span>
                    </li>
                @endif
                {{-- ++++++++++++++++++++ expiry_alert Notification ++++++++++++++++++++ --}}
                @if($notificationVar->data['type'] == 'expired')
                    <li>
                        <p style="margin:0px;margin-top:10px;margin-bottom:5px;">
                            <i class="fa fa-exclamation-triangle" style="color: rgb(255, 19, 19)"></i>
                            @lang('lang.expired')
                        </p>

                        <span class="text-muted">@lang('lang.product'):
                            @php
                                $product_var = \App\Models\Product::select('name','sku')->where('id', $notificationVar->data['product_id'])->first();
                            @endphp
                            {{ $product_var['name'] }} ({{ $product_var['sku'] }}) <br/> @lang('lang.expired')
                            {{$notificationVar->data['days']}} @lang('lang.days')</span> <br />
                        <span class="text-muted">@lang('lang.in_stock') :
                            {{@num_format($notificationVar->data['qty_available'])}}</span>
                    </li>
                @endif
                {{-- ++++++++++++++++++++ quantity_alert Notification ++++++++++++++++++++ --}}
                {{-- @if($notificationVar->data['type'] == 'quantity_alert')
                    <li>
                        <p style="margin:0px;margin-top:10px;margin-bottom:0px;font-weight:bold;">
                            <i class="fa fa-exclamation-triangle" style="color: rgb(255, 187, 60)"></i>
                            @lang('lang.alert_quantity')

                            @php
                                $product_var = \App\Models\Product::select('name','sku')->where('id', $notificationVar->data['product_id'])->first();
                            @endphp
                            {{ $product_var['name'] }} ({{ $product_var['sku'] }}) <br/>
                        </p>
                        <span class="text-muted">@lang('lang.alert_quantity'):
                            {{@num_format($notificationVar->data['alert_quantity'])}}</span> <br/>
                        <span class="text-muted">@lang('lang.in_stock'):
                            {{@num_format($notificationVar->data['qty_available'])}}</span>
                    </li>
                @endif --}}
                {{-- <hr /> --}}

            @empty
                <div class="text-center no_new_notification_div">
                    <span class="text-muted" style="font-size: 12px;margin:50px !important;">@lang('lang.no_new_notification')</span>
                </div>
            @endforelse
        </ul>
    </li>
</ul>
