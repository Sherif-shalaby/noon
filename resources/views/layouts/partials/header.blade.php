
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
                                <a href="https://api.whatsapp.com/send?phone={{$watsapp_number}}">
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
                                  <a class="dropdown-toggle" href="#" role="button" id="languagelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag flag-icon-{{ $flags->$local_code }} flag-icon-squared"></i>&nbsp;{{ LaravelLocalization::getCurrentLocaleNative() }}</a>
                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languagelink">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            <i class="flag flag-icon-{{$flags->$localeCode}} flag-icon-squared"></i>{{ $properties['native'] }}
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
                      <li class="dropdown">
                          <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/dairy-products.png')}}" class="img-fluid" alt="layouts"><span>{{__('lang.products')}}</span></a>
                          <ul class="dropdown-menu">
                            <li><a href="{{route('products.index')}}"><i class="mdi mdi-circle"></i>{{__('lang.products')}}</a></li>
                            <li><a href="#"><i class="mdi mdi-circle"></i>Light - Horizontal</a></li>
                            <li><a href="https://themesbox.in/admin-templates/theta/html/dark-vertical/index.html"><i class="mdi mdi-circle"></i>Dark - Vertical</a></li>
                            <li><a href="https://themesbox.in/admin-templates/theta/html/dark-horizontal/index.html"><i class="mdi mdi-circle"></i>Dark - Horizontal</a></li>
                        </ul>
                      </li>
                 @endif
                  @if(!empty($module_settings['stock_module']))
                      <li class="dropdown">
                          <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/warehouse.png')}}" class="img-fluid" alt="apps"><span>{{__('lang.stock')}}</span></a>
                          <ul class="dropdown-menu">
                              <li><a href="apps-calender.html"><i class="mdi mdi-circle"></i>Calender</a></li>
                              <li><a href="apps-chat.html"><i class="mdi mdi-circle"></i>Chat</a></li>
                              <li class="dropdown">
                                  <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown" ><i class="mdi mdi-circle"></i>Email</a>
                                  <ul class="dropdown-menu">
                                      <li><a href="apps-email-inbox.html"><i class="mdi mdi-circle"></i>Email Inbox</a></li>
                                      <li><a href="apps-email-open.html"><i class="mdi mdi-circle"></i>Email Open</a></li>
                                      <li><a href="apps-email-compose.html"><i class="mdi mdi-circle"></i>Email Compose</a></li>
                                  </ul>
                              </li>
                              <li><a href="apps-kanban-board.html"><i class="mdi mdi-circle"></i>Kanban Board</a></li>
                              <li><a href="apps-onboarding-screens.html"><i class="mdi mdi-circle"></i>Onboarding Screens</a></li>
                          </ul>
                      </li>
                  @endif
                  @if(!empty($module_settings['cashier_module']))
                      <li class="dropdown">
                          <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/cashier-machine.png')}}" class="img-fluid" alt="components"><span>{{__('lang.cashier')}}</span></a>
                          <ul class="dropdown-menu">
                              <li class="dropdown">
                                  <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><i class="mdi mdi-circle"></i><span>Forms</span></a>
                                  <ul class="dropdown-menu">
                                      <li><a href="form-inputs.html"><i class="mdi mdi-circle"></i>Form Inputs</a></li>
                                      <li><a href="form-groups.html"><i class="mdi mdi-circle"></i>Form Groups</a></li>
                                      <li><a href="form-layouts.html"><i class="mdi mdi-circle"></i>Form Layouts</a></li>
                                      <li><a href="form-colorpickers.html"><i class="mdi mdi-circle"></i>Form Color Pickers</a></li>
                                      <li><a href="form-datepickers.html"><i class="mdi mdi-circle"></i>Form Date Pickers</a></li>
                                      <li><a href="form-editors.html"><i class="mdi mdi-circle"></i>Form Editors</a></li>
                                      <li><a href="form-file-uploads.html"><i class="mdi mdi-circle"></i>Form File Uploads</a></li>
                                      <li><a href="form-input-mask.html"><i class="mdi mdi-circle"></i>Form Input Mask</a></li>
                                      <li><a href="form-maxlength.html"><i class="mdi mdi-circle"></i>Form MaxLength</a></li>
                                      <li><a href="form-selects.html"><i class="mdi mdi-circle"></i>Form Selects</a></li>
                                      <li><a href="form-touchspin.html"><i class="mdi mdi-circle"></i>Form Touchspin</a></li>
                                      <li><a href="form-validations.html"><i class="mdi mdi-circle"></i>Form Validations</a></li>
                                      <li><a href="form-wizards.html"><i class="mdi mdi-circle"></i>Form Wizards</a></li>
                                      <li><a href="form-xeditable.html"><i class="mdi mdi-circle"></i>Form X-editable</a></li>
                                  </ul>
                              </li>
                              <li class="dropdown">
                                  <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown" ><i class="mdi mdi-circle"></i>Icons</a>
                                  <ul class="dropdown-menu">
                                      <li><a href="icon-theta.html"><i class="mdi mdi-circle"></i>Theta Icons</a></li>
                                      <li><a href="icon-dripicons.html"><i class="mdi mdi-circle"></i>Dripicons</a></li>
                                      <li><a href="icon-feather.html"><i class="mdi mdi-circle"></i>Feather</a></li>
                                      <li><a href="icon-flag.html"><i class="mdi mdi-circle"></i>Flag</a></li>
                                      <li><a href="icon-font-awesome.html"><i class="mdi mdi-circle"></i>Font Awesome</a></li>
                                      <li><a href="icon-ionicons.html"><i class="mdi mdi-circle"></i>Ion Icons</a></li>
                                      <li><a href="icon-line-awesome.html"><i class="mdi mdi-circle"></i>Line Awesome</a></li>
                                      <li><a href="icon-material-design.html"><i class="mdi mdi-circle"></i>Material Design</a></li>
                                      <li><a href="icon-simple-line.html"><i class="mdi mdi-circle"></i>Simple Line Icons</a></li>
                                      <li><a href="icon-socicon.html"><i class="mdi mdi-circle"></i>Socicon</a></li>
                                      <li><a href="icon-themify.html"><i class="mdi mdi-circle"></i>Themify</a></li>
                                      <li><a href="icon-typicons.html"><i class="mdi mdi-circle"></i>Typicons</a></li>
                                  </ul>
                              </li>
                              <li class="dropdown">
                                  <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><i class="mdi mdi-circle"></i>Charts</a>
                                  <ul class="dropdown-menu">
                                      <li><a href="chart-c3.html"><i class="mdi mdi-circle"></i>C3 Chart</a></li>
                                      <li><a href="chart-chartistjs.html"><i class="mdi mdi-circle"></i>Chartist Chart</a></li>
                                      <li><a href="chart-chartjs.html"><i class="mdi mdi-circle"></i>Chartjs Chart</a></li>
                                      <li><a href="chart-flot.html"><i class="mdi mdi-circle"></i>Flot Chart</a></li>
                                      <li><a href="chart-knob.html"><i class="mdi mdi-circle"></i>Knob Chart</a></li>
                                      <li><a href="chart-morris.html"><i class="mdi mdi-circle"></i>Morris Chart</a></li>
                                      <li><a href="chart-piety.html"><i class="mdi mdi-circle"></i>Piety Chart</a></li>
                                      <li><a href="chart-sparkline.html"><i class="mdi mdi-circle"></i>Sparkline Chart</a></li>
                                  </ul>
                              </li>
                              <li class="dropdown">
                                  <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><i class="mdi mdi-circle"></i>Tables</a>
                                  <ul class="dropdown-menu">
                                      <li><a href="table-bootstrap.html"><i class="mdi mdi-circle"></i>Bootstrap Table</a></li>
                                      <li><a href="table-datatable.html"><i class="mdi mdi-circle"></i>Data Table</a></li>
                                      <li><a href="table-editable.html"><i class="mdi mdi-circle"></i>Editable Table</a></li>
                                      <li><a href="table-footable.html"><i class="mdi mdi-circle"></i>Foo Table</a></li>
                                      <li><a href="table-rwdtable.html"><i class="mdi mdi-circle"></i>RWD Table</a></li>
                                  </ul>
                              </li>
                              <li class="dropdown">
                                  <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><i class="mdi mdi-circle"></i>Maps</a>
                                  <ul class="dropdown-menu">
                                      <li><a href="map-google.html"><i class="mdi mdi-circle"></i>Google Map</a></li>
                                      <li><a href="map-vector.html"><i class="mdi mdi-circle"></i>Vector Map</a></li>
                                  </ul>
                              </li>
                          </ul>
                      </li>
                  @endif
                  @if(!empty($module_settings['return_module']))
                      <li class="dropdown">
                          <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/return.png')}}" class="img-fluid" alt="pages"><span>{{__('lang.returns')}}</span></a>
                          <ul class="dropdown-menu">
                              <li class="dropdown">
                                  <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown" ><i class="mdi mdi-circle"></i>eCommerce</a>
                                  <ul class="dropdown-menu">
                                      <li><a href="ecommerce-product-list.html"><i class="mdi mdi-circle"></i>Product List</a></li>
                                      <li><a href="ecommerce-product-detail.html"><i class="mdi mdi-circle"></i>Product Detail</a></li>
                                      <li><a href="ecommerce-order-list.html"><i class="mdi mdi-circle"></i>Order List</a></li>
                                      <li><a href="ecommerce-order-detail.html"><i class="mdi mdi-circle"></i>Order Detail</a></li>
                                      <li><a href="ecommerce-shop.html"><i class="mdi mdi-circle"></i>Shop</a></li>
                                      <li><a href="ecommerce-single-product.html"><i class="mdi mdi-circle"></i>Single Product</a></li>
                                      <li><a href="ecommerce-cart.html"><i class="mdi mdi-circle"></i>Cart</a></li>
                                      <li><a href="ecommerce-checkout.html"><i class="mdi mdi-circle"></i>Checkout</a></li>
                                      <li><a href="ecommerce-thankyou.html"><i class="mdi mdi-circle"></i>Thank You</a></li>
                                      <li><a href="ecommerce-myaccount.html"><i class="mdi mdi-circle"></i>My Account</a></li>
                                  </ul>
                              </li>
                              <li class="dropdown">
                                  <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><i class="mdi mdi-circle"></i>Basic Pages</a>
                                  <ul class="dropdown-menu">
                                      <li><a href="page-starter.html"><i class="mdi mdi-circle"></i>Starter Page</a></li>
                                      <li><a href="page-blog.html"><i class="mdi mdi-circle"></i>Blog</a></li>
                                      <li><a href="page-faq.html"><i class="mdi mdi-circle"></i>FAQ</a></li>
                                      <li><a href="page-gallery.html"><i class="mdi mdi-circle"></i>Gallery</a></li>
                                      <li><a href="page-invoice.html"><i class="mdi mdi-circle"></i>Invoice</a></li>
                                      <li><a href="page-pricing.html"><i class="mdi mdi-circle"></i>Pricing</a></li>
                                      <li><a href="page-timeline.html"><i class="mdi mdi-circle"></i>Timeline</a></li>
                                  </ul>
                              </li>
                              <li class="dropdown">
                                  <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><i class="mdi mdi-circle"></i>User Pages</a>
                                  <ul class="dropdown-menu">
                                      <li><a href="user-login.html"><i class="mdi mdi-circle"></i>Login</a></li>
                                      <li><a href="user-register.html"><i class="mdi mdi-circle"></i>Register</a></li>
                                      <li><a href="user-forgotpsw.html"><i class="mdi mdi-circle"></i>Forgot Password</a></li>
                                      <li><a href="user-lock-screen.html"><i class="mdi mdi-circle"></i>Lock Screen</a></li>
                                  </ul>
                              </li>
                              <li class="dropdown">
                                  <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><i class="mdi mdi-circle"></i>Error Pages</a>
                                  <ul class="dropdown-menu">
                                      <li><a href="error-comingsoon.html"><i class="mdi mdi-circle"></i>Coming Soon</a></li>
                                      <li><a href="error-maintenance.html"><i class="mdi mdi-circle"></i>Maintenance</a></li>
                                      <li><a href="error-404.html"><i class="mdi mdi-circle"></i>Error 404</a></li>
                                      <li><a href="error-500.html"><i class="mdi mdi-circle"></i>Error 500</a></li>
                                  </ul>
                              </li>
                          </ul>
                      </li>
                  @endif
                  @if(!empty($module_settings['employee_module']))
                         <li class="dropdown">
                             <a href=""><img src="{{asset('images/topbar/employee.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.employees')}}</span></a>
                              <ul class="dropdown-menu">
                                  <li><a href="{{route('jobs.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.jobs')</a></li>
                                  <li><a href="{{route('employees.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.employees')</a></li>
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
                      <li class="scroll"><a href="widgets.html"><img src="{{asset('images/topbar/inventory.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.suppliers')}}</span></a></li>
                  @endif
                  @if(!empty($module_settings['settings_module']))
                      <li class="dropdown menu-item-has-mega-menu">
                          <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/settings.png')}}" class="img-fluid" alt="basic"><span>{{__('lang.settings')}}</span></a>
                          <div class="mega-menu dropdown-menu">
                              <ul class="mega-menu-row" role="menu">
                                  <li class="mega-menu-col col-md-3">
                                      <ul class="sub-menu">
                                          <li><a href="{{route('getModules')}}"><i class="mdi mdi-circle"></i>@lang('lang.modules')</a></li>
                                          <li><a href="{{route('store.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.stores')</a></li>
                                          <li><a href="{{route('brands.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.brands')</a></li>
                                          <li><a href="{{route('sub-categories', 'category')}}"><i class="mdi mdi-circle"></i>@lang('categories.categories')</a></li>
                                          <li><a href="{{route('settings.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.general_settings')</a></li>
                                          <li><a href="{{route('colors.index')}}"><i class="mdi mdi-circle"></i>@lang('colors.colors')</a></li>
                                          <li><a href="{{route('sizes.index')}}"><i class="mdi mdi-circle"></i>@lang('sizes.sizes')</a></li>
                                          <li><a href="{{route('units.index')}}"><i class="mdi mdi-circle"></i>@lang('units.units')</a></li>


                                      </ul>
                                  </li>
                                  {{--                            <li class="mega-menu-col col-md-3">--}}
                                  {{--                                <ul class="sub-menu">--}}
                                  {{--                                    <li><a href="basic-ui-kits-collapse.html"><i class="mdi mdi-circle"></i>Collapse</a></li>--}}
                                  {{--                                    <li><a href="basic-ui-kits-dropdowns.html"><i class="mdi mdi-circle"></i>Dropdowns</a></li>--}}
                                  {{--                                    <li><a href="basic-ui-kits-embeds.html"><i class="mdi mdi-circle"></i>Embeds</a></li>--}}
                                  {{--                                    <li><a href="basic-ui-kits-grids.html"><i class="mdi mdi-circle"></i>Grids</a></li>--}}
                                  {{--                                    <li><a href="basic-ui-kits-images.html"><i class="mdi mdi-circle"></i>Images</a></li>--}}
                                  {{--                                </ul>--}}
                                  {{--                            </li>--}}


                              </ul>
                          </div>
                      </li>
                  @endif
                  @if(!empty($module_settings['reports_module']))
                      <li class="dropdown">
                          <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/report.png')}}" class="img-fluid" alt="advanced"><span>{{__('lang.reports')}}</span></a>
                          <ul class="dropdown-menu">
                              <li><a href="advanced-ui-kits-image-crop.html"><i class="mdi mdi-circle"></i>Image Crop</a></li>
                              <li><a href="advanced-ui-kits-jquery-confirm.html"><i class="mdi mdi-circle"></i>jQuery Confirm</a></li>
                              <li><a href="advanced-ui-kits-nestable.html"><i class="mdi mdi-circle"></i>Nestable</a></li>
                              <li><a href="advanced-ui-kits-pnotify.html"><i class="mdi mdi-circle"></i>Pnotify</a></li>
                              <li><a href="advanced-ui-kits-range-slider.html"><i class="mdi mdi-circle"></i>Range Slider</a></li>
                              <li><a href="advanced-ui-kits-ratings.html"><i class="mdi mdi-circle"></i>Ratings</a></li>
                              <li><a href="advanced-ui-kits-session-timeout.html"><i class="mdi mdi-circle"></i>Session Timeout</a></li>
                              <li><a href="advanced-ui-kits-sweet-alerts.html"><i class="mdi mdi-circle"></i>Sweet Alerts</a></li>
                              <li><a href="advanced-ui-kits-switchery.html"><i class="mdi mdi-circle"></i>Switchery</a></li>
                              <li><a href="advanced-ui-kits-toolbar.html"><i class="mdi mdi-circle"></i>Toolbar</a></li>
                              <li><a href="advanced-ui-kits-tour.html"><i class="mdi mdi-circle"></i>Tour</a></li>
                              <li><a href="advanced-ui-kits-treeview.html"><i class="mdi mdi-circle"></i>Tree View</a></li>
                          </ul>
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
