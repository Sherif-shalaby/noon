
  <!-- Start Topbar -->
{{--<div class="topbar no-print">--}}
{{--    <!-- Start container-fluid -->--}}
{{--    <div class="container-fluid">--}}
{{--        <!-- Start row -->--}}
{{--        <div class="row align-items-center">--}}
{{--            <!-- Start col -->--}}
{{--            <div class="col-md-12 align-self-center">--}}
{{--                <div class="togglebar">--}}
{{--                    <ul class="list-inline mb-0">--}}
{{--                        <li class="list-inline-item">--}}
{{--                            <div class="logobar">--}}
{{--                                <a href="{{url('/')}}" class=""><img src="{{asset('/uploads/'.$settings['logo'])}}" width="45" height="45" class="img-fluid" alt="logo"></a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="list-inline-item">--}}
{{--                            <div class="searchbar">--}}
{{--                                <form>--}}
{{--                                    <div class="input-group">--}}
{{--                                      <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">--}}
{{--                                      <div class="input-group-append">--}}
{{--                                        <button class="btn" type="submit" id="button-addon2"><img src="{{asset('images/svg-icon/search.svg')}}" class="img-fluid" alt="search"></button>--}}
{{--                                      </div>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="infobar">--}}
{{--                    <ul class="list-inline mb-0">--}}
{{--                        <li class="list-inline-item">--}}
{{--                            <div class="notifybar">--}}
{{--                                <a href="https://api.whatsapp.com/send?phone={{$settings['watsapp_numbers']}}">--}}
{{--                                    <img src="{{asset('images/topbar/whatsapp.jpg')}}" class="img-fluid" alt="notifications" width="45px" height="45px">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="list-inline-item">--}}
{{--                            <div class="notifybar">--}}
{{--                                <a href="{{ route('invoices.create') }}">--}}
{{--                                    <img src="{{asset('images/topbar/cash-machine.png')}}" class="img-fluid" alt="notifications" width="45px" height="45px">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="list-inline-item">--}}
{{--                            <div class="notifybar">--}}
{{--                                <a href="javascript:void(0)" id="infobar-notifications-open" class="infobar-icon">--}}
{{--                                    <img src="{{asset('images/svg-icon/notifications.svg')}}" class="img-fluid" alt="notifications">--}}
{{--                                    <span class="live-icon"></span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="list-inline-item">--}}
{{--                            @php--}}
{{--                                $flags=(object)[--}}
{{--                                    'en'=>'us',--}}
{{--                                    'ar'=>'eg'--}}
{{--                                    ];--}}
{{--                                $local_code=LaravelLocalization::getCurrentLocale();--}}
{{--                           @endphp--}}
{{--                            <div class="languagebar">--}}
{{--                                <div class="dropdown">--}}
{{--                                  <a class="dropdown-toggle text-black" href="#" role="button" id="languagelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag flag-icon-{{ $flags->$local_code }} flag-icon-squared"></i>&nbsp;{{ LaravelLocalization::getCurrentLocaleNative() }}</a>--}}
{{--                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languagelink">--}}
{{--                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)--}}
{{--                                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">--}}
{{--                                            <i class="flag  flag-icon-{{$flags->$localeCode}} flag-icon-squared"></i>{{ $properties['native'] }}--}}
{{--                                        </a>--}}
{{--                                    @endforeach--}}
{{--                                  </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="list-inline-item">--}}
{{--                            <div class="profilebar">--}}
{{--                                <div class="dropdown">--}}
{{--                                  <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('images/users/profile.svg')}}" class="img-fluid" alt="profile"><span class="feather icon-chevron-down live-icon"></span></a>--}}
{{--                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">--}}
{{--                                    <div class="dropdown-item">--}}
{{--                                        <div class="profilename">--}}
{{--                                          <h5>Shourya Kumar</h5>--}}
{{--                                          <p>Social Media Strategist</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="dropdown-item">--}}
{{--                                        <div class="userbox">--}}
{{--                                            <ul class="list-inline mb-0">--}}
{{--                                                <li class="list-inline-item"><a href="#" class="profile-icon"><img src="{{asset('images/svg-icon/user.svg')}}" class="img-fluid" alt="user"></a></li>--}}
{{--                                                <li class="list-inline-item"><a href="#" class="profile-icon"><img src="{{asset('images/svg-icon/email.svg')}}" class="img-fluid" alt="email"></a></li>--}}
{{--                                                <li class="list-inline-item">--}}
{{--                                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="profile-icon"><img src="{{asset('images/svg-icon/logout.svg')}}" class="img-fluid" alt="logout"></a>--}}
{{--                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"--}}
{{--                                                        style="display: none;">--}}
{{--                                                        @csrf--}}
{{--                                                    </form>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                      </div>--}}
{{--                                  </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="list-inline-item menubar-toggle" @if(request()->segment(2) == 'invoices') style="display: inline-block;!important;"@endif>--}}
{{--                            <div class="menubar">--}}
{{--                                <a class="menu-hamburger navbar-toggle bg-transparent" href="javascript:void();" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="true">--}}
{{--                                    <img src="{{asset('images/svg-icon/collapse.svg')}}" class="img-fluid menu-hamburger-collapse" alt="collapse">--}}
{{--                                    <img src="{{asset('images/svg-icon/close.svg')}}" class="img-fluid menu-hamburger-close" alt="close">--}}
{{--                                </a>--}}
{{--                             </div>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- End col -->--}}
{{--        </div>--}}
{{--        <!-- End row -->--}}
{{--    </div>--}}
{{--    <!-- End container-fluid -->--}}
{{--</div>--}}
<!-- End Topbar -->
<!-- Start Navigationbar -->
<div class="navigationbar">
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <!-- Start Horizontal Nav -->
        <nav class="horizontal-nav mobile-navbar fixed-navbar">
            <div class="collapse navbar-collapse" id="navbar-menu">
              <ul class="horizontal-menu">
                {{-- ###################### Dashboard : نظرة عامة ###################### --}}
                {{-- @can('dashboard')  --}}
                    @if(!empty($module_settings['dashboard']) )
                        <li class="scroll">
                            <a href="{{url('/')}}"><img src="{{asset('images/topbar/dashboard.png')}}" class="img-fluid" alt="dashboard">
                            <span>{{__('lang.dashboard')}}</span>
                            </a>
                        </li>
                    @endif
                {{-- @endcan --}}
                {{-- ###################### Products : المنتجات ###################### --}}
                {{-- @can('product_module')  --}}
                    @if(!empty($module_settings['product_module']) )
                        <li class="scroll"><a href="{{route('products.index')}}"><img src="{{asset('images/topbar/dairy-products.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.products')}}</span></a></li>
                    @endif
                {{-- @endcan --}}
                {{-- ###################### Cashier : المبيعات ###################### --}}
                {{-- @can('cashier_module') --}}
                    @if(!empty($module_settings['cashier_module']))
                        <li class="scroll">
                            <a href="{{route('pos.index')}}" ><img src="{{asset('images/topbar/cashier-machine.png')}}" class="img-fluid" alt="apps"><span>{{__('lang.sells')}}</span></a>
                        </li>
                    @endif
                {{-- @endcan --}}
                {{-- ###################### Purchases : المشتريات ###################### --}}
                {{-- @can('stock_module') --}}
                    @if(!empty($module_settings['stock_module']))
                            <li>
                                <a href="{{route('stocks.create')}}" ><img src="{{asset('images/topbar/warehouse.png')}}" class="img-fluid" alt="components"><span>{{__('lang.stock')}}</span></a>
                            </li>
                    @endif
                  @if(!empty($module_settings['stock_module']))
                            <li>
                                <a href="{{route('initial-balance.create')}}" ><img src="{{asset('images/topbar/warehouse.png')}}" class="img-fluid" alt="components"><span>{{__('lang.initial_balance')}}</span></a>
                            </li>
                    @endif
                {{-- @endcan --}}
                {{-- ###################### Purchase_Order : امر شراء ###################### --}}
                <li>
                    <a href="{{route('purchase_order.index')}}">
                        <img src="{{asset('images/topbar/warehouse.png')}}" class="img-fluid" alt="components">
                        <span>{{__('lang.purchase_order')}}</span>
                    </a>
                    {{-- <ul class="dropdown-menu"> --}}
                        {{-- +++++++++++ purchase_order : index +++++++++++ --}}
                        {{-- <li>
                            <a href="{{route('purchase_order.index')}}">
                                <i class="mdi mdi-circle"></i>{{__('lang.show_purchase_order')}}
                            </a>
                        </li> --}}
                        {{-- +++++++++++ purchase_order : create +++++++++++ --}}
                        {{-- <li>
                            <a href="{{route('purchase_order.create')}}">
                                <i class="mdi mdi-circle"></i>{{__('lang.create_purchase_order')}}
                            </a>
                        </li> --}}
                    {{-- </ul> --}}
                </li>
                {{-- ###################### Returns : المرتجعات ###################### --}}
                {{-- @can('return_module')  --}}
                    @if(!empty($module_settings['return_module']))
                        <li class="dropdown">
                            <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/return.png')}}" class="img-fluid" alt="pages"><span>{{__('lang.returns')}}</span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{route('sell_return.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.sells_return')</a></li>
                            </ul>
                        </li>
                    @endif
                {{-- @endcan  --}}
                {{-- ###################### Employees : الموظفين ###################### --}}
                {{-- @can('employee_module')  --}}
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
                {{-- @endcan --}}
                {{-- ###################### Customers : العملاء ###################### --}}
                {{-- @can('customer_module')  --}}
                    @if(!empty($module_settings['customer_module']))
                    <li class="dropdown">
                            <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/customer-feedback.png')}}" class="img-fluid" alt="layouts"><span>{{__('lang.customers')}}</span></a>
                            <ul class="dropdown-menu">
                            <li><a href="{{route('customers.index')}}"><i class="mdi mdi-circle"></i>{{__('lang.customers')}}</a></li>
                            <li><a href="{{route('customertypes.index')}}"><i class="mdi mdi-circle"></i>{{__('lang.customer_types')}}</a></li>
                        </ul>
                    </li>
                    @endif
                {{-- @endcan --}}
                {{-- ###################### suppliers : الموردين ###################### --}}
                {{-- @can('supplier_module')  --}}
                    @if(!empty($module_settings['supplier_module']))
                        <li class="scroll"><a href="{{route('suppliers.index')}}"><img src="{{asset('images/topbar/inventory.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.suppliers')}}</span></a></li>
                    @endif
                {{-- @endcan --}}
                {{-- ###################### settings : الاعدادات ###################### --}}
                {{-- @can('settings_module') --}}
                    @if(!empty($module_settings['settings_module']))
                        <li class="dropdown menu-item-has-mega-menu">
                            <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/settings.png')}}" class="img-fluid" alt="basic"><span>{{__('lang.settings')}}</span></a>
                            <div class="mega-menu dropdown-menu">
                                <ul class="mega-menu-row" role="menu">
                                {{-- ================= Column 1 ============== --}}
                                <li class="mega-menu-col col-md-3">
                                    <ul class="sub-menu">
                                    {{-- ////// اخفاء واظهار اقسام البرنامج ////// --}}
                                    <li>
                                        <a href="{{route('getModules')}}">
                                            <i class="mdi mdi-circle"></i>@lang('lang.modules')
                                        </a>
                                    </li>
                                    {{-- ////// الاعدادات العامة ////// --}}
                                    <li>
                                        <a href="{{route('settings.index')}}">
                                            <i class="mdi mdi-circle"></i>@lang('lang.general_settings')
                                        </a>
                                    </li>
                                    {{-- ////// الخزائن ////// --}}
                                    <li>
                                        <a href="{{route('moneysafe.index')}}">
                                            <i class="mdi mdi-circle"></i>@lang('lang.moneysafes')
                                        </a>
                                    </li>
                                    </ul>
                                </li>
                                {{-- ================= Column 2 ============== --}}
                                <li class="mega-menu-col col-md-3">
                                    <ul class="sub-menu">
                                        {{-- ////// المخازن ////// --}}
                                        <li>
                                            <a href="{{route('store.index')}}">
                                                <i class="mdi mdi-circle"></i>@lang('lang.stores')
                                            </a>
                                        </li>
                                        {{-- ////// العلامة التجاية ////// --}}
                                        <li>
                                            <a href="{{route('brands.index')}}">
                                                <i class="mdi mdi-circle"></i>@lang('lang.brands')
                                            </a>
                                        </li>
                                        {{-- ////// الاقسام ////// --}}
                                        <li>
                                            <a href="{{route('sub-categories', 'category')}}">
                                                <i class="mdi mdi-circle"></i>@lang('categories.categories')
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                {{-- ================= Column 3 ============== --}}
                                <li class="mega-menu-col col-md-3">
                                    <ul class="sub-menu">
                                        {{-- ////// الالوان ////// --}}
                                        <li>
                                            <a href="{{route('colors.index')}}">
                                                <i class="mdi mdi-circle"></i>@lang('colors.colors')
                                            </a>
                                        </li>
                                        {{-- ////// المقاسات ////// --}}
                                        <li>
                                            <a href="{{route('sizes.index')}}">
                                                <i class="mdi mdi-circle"></i>@lang('sizes.sizes')
                                            </a>
                                        </li>
                                        {{-- ////// الوحدات ////// --}}
                                        <li>
                                            <a href="{{route('units.index')}}">
                                                <i class="mdi mdi-circle"></i>@lang('units.units')
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                    <li class="mega-menu-col col-md-3">
                                    <ul class="sub-menu">
                                        {{-- ////////// نقاط البيع للصرافين ////////// --}}
                                        <li>
                                            <a href="{{route('store-pos.index')}}">
                                                <i class="mdi mdi-circle"></i>@lang('lang.store_pos')
                                            </a>
                                        </li>
                                        {{-- ////////// الضرائب العامة ////////// --}}
                                        <li>
                                            <a href="{{route('general-tax.index')}}">
                                                <i class="mdi mdi-circle"></i>@lang('lang.general_tax')
                                            </a>
                                        </li>
                                        {{-- ////////// ضرائب المنتجات ////////// --}}
                                        <li>
                                            <a href="{{route('product-tax.index')}}">
                                                <i class="mdi mdi-circle"></i>@lang('lang.product_tax')
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                {{-- @endcan  --}}
                {{-- ###################### reports : التقرير ###################### --}}
                {{-- @can('reports_module') --}}
                    @if(!empty($module_settings['reports_module']))

                        <li class="dropdown">
                            <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('images/topbar/report.png')}}" class="img-fluid" alt="advanced">
                                <span>{{__('lang.reports')}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                {{-- +++++++++++ purchases report +++++++++++ --}}
                                <li>
                                    <a href="{{route('purchases-report.index')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.purchases_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ sales report +++++++++++ --}}
                                <li>
                                    <a href="{{route('sales-report.index')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.sales_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ receivable report +++++++++++ --}}
                                <li>
                                    <a href="{{route('receivable-report.index')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.receivable_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ receivable report +++++++++++ --}}
                                <li>
                                    <a href="{{route('payable-report.index')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.payable_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ customers report +++++++++++ --}}
                                <li>
                                    <a href="{{route('customers-report.index')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.customers_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ Daily Report Summary +++++++++++ --}}
                                <li>
                                    <a href="{{route('daily-report-summary.index')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.daily_report_summary')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ Get Due Report +++++++++++ --}}
                                <li>
                                    <a href="{{route('get-due-report.index')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.get_due_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ Supplier Report +++++++++++ --}}
                                <li>
                                    <a href="{{route('get-supplier-report.index')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.supplier_report')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ Representative Salary Report +++++++++++ --}}
                                <li>
                                    <a href="{{route('representative_salary_report.index')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.representative_salary_report')}}
                                    </a>
                                </li>
                            </ul>
                        </li>

                    @endif
                {{-- @endcan --}}



              </ul>
            </div>
        </nav>
        <!-- End Horizontal Nav -->
    </div>
    <!-- End container-fluid -->
</div>
<!-- End Navigationbar -->
