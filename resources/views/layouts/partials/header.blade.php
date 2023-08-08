
<div class="topbar">
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <!-- Start row -->
        <div class="row align-items-center">
            <!-- Start col -->
            <div class="col-md-12 align-self-center">
                <div class="togglebar">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <div class="logobar">
                                <a href="{{url('/')}}" class=""><img src="{{asset('/uploads/'.$settings['logo'])}}" width="45" height="45" class="img-fluid" alt="logo"></a>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="searchbar">
                                <form>
                                    <div class="input-group">
                                      <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                      <div class="input-group-append">
                                        <button class="btn" type="submit" id="button-addon2"><img src="{{asset('images/svg-icon/search.svg')}}" class="img-fluid" alt="search"></button>
                                      </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="infobar">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <div class="notifybar">
                                <a href="https://api.whatsapp.com/send?phone={{$settings['watsapp_numbers']}}">
                                    <img src="{{asset('images/topbar/whatsapp.jpg')}}" class="img-fluid" alt="notifications" width="45px" height="45px">
                                </a>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="notifybar">
                                <a href="javascript:void(0)" id="infobar-notifications-open" class="infobar-icon">
                                    <img src="{{asset('images/svg-icon/notifications.svg')}}" class="img-fluid" alt="notifications">
                                    <span class="live-icon"></span>
                                </a>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            @php
                                $flags=(object)[
                                    'en'=>'us',
                                    'ar'=>'eg'
                                    ];
                                $local_code=LaravelLocalization::getCurrentLocale();
                           @endphp
                            <div class="languagebar">
                                <div class="dropdown">
                                  <a class="dropdown-toggle text-black" href="#" role="button" id="languagelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag flag-icon-{{ $flags->$local_code }} flag-icon-squared"></i>&nbsp;{{ LaravelLocalization::getCurrentLocaleNative() }}</a>
                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languagelink">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            <i class="flag  flag-icon-{{$flags->$localeCode}} flag-icon-squared"></i>{{ $properties['native'] }}
                                        </a>
                                    @endforeach
                                  </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="profilebar">
                                <div class="dropdown">
                                  <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('images/users/profile.svg')}}" class="img-fluid" alt="profile"><span class="feather icon-chevron-down live-icon"></span></a>
                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                    <div class="dropdown-item">
                                        <div class="profilename">
                                          <h5>Shourya Kumar</h5>
                                          <p>Social Media Strategist</p>
                                        </div>
                                    </div>
                                    <div class="dropdown-item">
                                        <div class="userbox">
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item"><a href="#" class="profile-icon"><img src="{{asset('images/svg-icon/user.svg')}}" class="img-fluid" alt="user"></a></li>
                                                <li class="list-inline-item"><a href="#" class="profile-icon"><img src="{{asset('images/svg-icon/email.svg')}}" class="img-fluid" alt="email"></a></li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="profile-icon"><img src="{{asset('images/svg-icon/logout.svg')}}" class="img-fluid" alt="logout"></a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-inline-item menubar-toggle">
                            <div class="menubar">
                                <a class="menu-hamburger navbar-toggle bg-transparent" href="javascript:void();" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="true">
                                    <img src="{{asset('images/svg-icon/collapse.svg')}}" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                    <img src="{{asset('images/svg-icon/close.svg')}}" class="img-fluid menu-hamburger-close" alt="close">
                                </a>
                             </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End container-fluid -->
</div>
<!-- End Topbar -->
<!-- Start Navigationbar -->
<div class="navigationbar">
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <!-- Start Horizontal Nav -->
        <nav class="horizontal-nav mobile-navbar fixed-navbar">
            <div class="collapse navbar-collapse" id="navbar-menu">
              <ul class="horizontal-menu">

                  @if(!empty($module_settings['dashboard']) )
                      <li class="scroll">
                          <a href="{{url('/')}}"><img src="{{asset('images/topbar/dashboard.png')}}" class="img-fluid" alt="dashboard">
                            <span>{{__('lang.dashboard')}}</span>
                          </a>
                      </li>
                  @endif
                  {{-- @if(!empty($module_settings['dashboard']) ) --}}

                  @if(!empty($module_settings['product_module']) )
                  <li class="scroll"><a href="{{route('products.index')}}"><img src="{{asset('images/topbar/dairy-products.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.products')}}</span></a></li>
                 @endif

                  @if(!empty($module_settings['stock_module']))
                      <li>
                          <a href="{{route('stocks.index')}}" ><img src="{{asset('images/topbar/warehouse.png')}}" class="img-fluid" alt="components"><span>{{__('lang.stock')}}</span></a>
                      </li>

                  @endif
{{--                      @if(!empty($module_settings['cashier_module']))--}}
{{--                          <li class="dropdown">--}}
{{--                              <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/cashier-machine.png')}}" class="img-fluid" alt="apps"><span>{{__('')}}</span></a>--}}
{{--                              <ul class="dropdown-menu">--}}
{{--                                  <li><a href=""><i class="mdi mdi-circle"></i>@lang('lang.add-stock')</a></li>--}}
{{--                              </ul>--}}
{{--                          </li>--}}
{{--                      @endif--}}
                  @if(!empty($module_settings['return_module']))
                      <li class="dropdown">
                          <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/return.png')}}" class="img-fluid" alt="pages"><span>{{__('lang.returns')}}</span></a>
                      </li>
                  @endif
                  @if(!empty($module_settings['employee_module']))
                         <li class="dropdown">
                             <a href=""><img src="{{asset('images/topbar/employee.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.employees')}}</span></a>
                              <ul class="dropdown-menu">
                                  <li><a href="{{route('jobs.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.jobs')</a></li>
                                  <li><a href="{{route('employees.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.employees')</a></li>
                                  <li><a href="{{route('wages.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.wages')</a></li>
                              </ul>
                          </li>
                  @endif
                  @if(!empty($module_settings['customer_module']))
                   <li class="dropdown">
                        <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/customer-feedback.png')}}" class="img-fluid" alt="layouts"><span>{{__('lang.customers')}}</span></a>
                        <ul class="dropdown-menu">
                        <li><a href="{{route('customers.index')}}"><i class="mdi mdi-circle"></i>{{__('lang.customers')}}</a></li>
                        <li><a href="{{route('customertypes.index')}}"><i class="mdi mdi-circle"></i>{{__('lang.customer_types')}}</a></li>
                    </ul>
                  </li>
                  @endif
                  @if(!empty($module_settings['supplier_module']))
                      <li class="scroll"><a href="{{route('suppliers.index')}}"><img src="{{asset('images/topbar/inventory.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.suppliers')}}</span></a></li>
                  @endif
                  @if(!empty($module_settings['settings_module']))
                      <li class="dropdown menu-item-has-mega-menu">
                          <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/settings.png')}}" class="img-fluid" alt="basic"><span>{{__('lang.settings')}}</span></a>
                          <div class="mega-menu dropdown-menu">
                              <ul class="mega-menu-row" role="menu">
                                  <li class="mega-menu-col col-md-3">
                                      <ul class="sub-menu">
                                          <li><a href="{{route('getModules')}}"><i class="mdi mdi-circle"></i>@lang('lang.modules')</a></li>
                                          <li><a href="{{route('settings.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.general_settings')</a></li>
                                          <li><a href="{{route('moneysafe.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.moneysafes')</a></li>
                                      </ul>
                                  </li>
                                  <li class="mega-menu-col col-md-3">
                                    <ul class="sub-menu">
                                        <li><a href="{{route('store.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.stores')</a></li>
                                        <li><a href="{{route('brands.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.brands')</a></li>
                                        <li><a href="{{route('sub-categories', 'category')}}"><i class="mdi mdi-circle"></i>@lang('categories.categories')</a></li>
                                    </ul>
                                </li>
                                <li class="mega-menu-col col-md-3">
                                    <ul class="sub-menu">
                                        <li><a href="{{route('colors.index')}}"><i class="mdi mdi-circle"></i>@lang('colors.colors')</a></li>
                                        <li><a href="{{route('sizes.index')}}"><i class="mdi mdi-circle"></i>@lang('sizes.sizes')</a></li>
                                        <li><a href="{{route('units.index')}}"><i class="mdi mdi-circle"></i>@lang('units.units')</a></li>
                                    </ul>
                                </li>
                                  <li class="mega-menu-col col-md-3">
                                    <ul class="sub-menu">
                                        <li><a href="{{route('store-pos.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.store_pos')</a></li>
                                    </ul>
                                </li>


                              </ul>
                          </div>
                      </li>
                  @endif
                  @if(!empty($module_settings['reports_module']))
                      <li class="dropdown">
                          <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/report.png')}}" class="img-fluid" alt="advanced"><span>{{__('lang.reports')}}</span></a>
                      </li>
                  @endif


                <li class="scroll">
                    <a href="{{ route('invoices.create') }}">
                        <img src="{{asset('images/topbar/inventory.png')}}" class="img-fluid" alt="widgets">
                        <span>{{ __('site.Sale_Screen') }}</span>
                    </a>
                </li>
                <li class="scroll">
                    <a href="{{ route('invoices.index') }}">
                        <img src="{{asset('images/topbar/inventory.png')}}" class="img-fluid" alt="widgets">
                        <span>{{ __('site.Invoices') }}</span>
                    </a>
                </li>
              </ul>
            </div>
        </nav>
        <!-- End Horizontal Nav -->
    </div>
    <!-- End container-fluid -->
</div>
