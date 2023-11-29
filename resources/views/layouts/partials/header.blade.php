<!-- Start Navigationbar -->
<div class="navigationbar no-print">
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
                        <li class="scroll"><a href="{{route('products.create')}}"><img src="{{asset('images/topbar/dairy-products.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.products')}}</span></a></li>
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

                    <li class="dropdown">
                        <a href="#">
                            <img src="{{asset('images/topbar/warehouse.png')}}" class="img-fluid" alt="components">
                            <span>{{__('lang.purchase_order')}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            {{-- ########### purchase_order : اوامر الشراء########### --}}
                            <li><a href="{{route('purchase_order.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.show_purchase_order')</a></li>
                            {{-- ########### required_products : المواد المطلوبة ########### --}}
                            <li><a href="{{ route('required-products.index') }}"><i class="mdi mdi-circle"></i>@lang('lang.required_products')</a></li>
                        </ul>
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
                  {{-- ###################### Supplier Returns :  المرتجعات للموردين ###################### --}}
                  @if(!empty($module_settings['return_module']))
                      <li class="dropdown">
                          <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/return.png')}}" class="img-fluid" alt="pages"><span>{{__('lang.supplier_returns')}}</span></a>
                          <ul class="dropdown-menu">
                              <li><a href="{{route('suppliers.returns.products')}}"><i class="mdi mdi-circle"></i>@lang('lang.products')</a></li>
                              <li><a href="{{route('suppliers.returns.invoices')}}"><i class="mdi mdi-circle"></i>@lang('lang.invoices')</a></li>
                          </ul>
                      </li>
                  @endif

                {{-- ###################### Employees : الموظفين ###################### --}}
                {{-- @can('employee_module')  --}}
                    @if(!empty($module_settings['employee_module']))
                            <li class="dropdown">
                                <a href=""><img src="{{asset('images/topbar/employee.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.employees')}}</span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{route('jobs.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.jobs')</a></li>
                                    <li><a href="{{route('employees.create')}}"><i class="mdi mdi-circle"></i>@lang('lang.employees')</a></li>
                                    <li><a href="{{route('wages.create')}}"><i class="mdi mdi-circle"></i>@lang('lang.wages')</a></li>
                                    {{-- ########### Attendance : الحضور و الانصراف ########### --}}
                                    <li><a href="{{route('attendance.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.attend_and_leave')</a></li>
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
                            <li><a href="{{route('customers.create')}}"><i class="mdi mdi-circle"></i>{{__('lang.customers')}}</a></li>
                            <li><a href="{{route('customertypes.index')}}"><i class="mdi mdi-circle"></i>{{__('lang.customer_types')}}</a></li>
                        </ul>
                    </li>
                    @endif
                {{-- @endcan --}}
                {{-- ###################### customer_price_offer : عرض سعر للعملاء ###################### --}}
                {{-- @can('customer_module')  --}}
                    @if(!empty($module_settings['customer_module']))
                        <li>
                            <a href="{{route('customer_price_offer.create')}}">
                                <img src="{{asset('images/topbar/customer-feedback.png')}}" class="img-fluid" alt="layouts">
                                <span>{{__('lang.customer_price_offer')}}</span>
                            </a>
                        </li>
                    @endif
                {{-- @endcan --}}
                {{-- ###################### suppliers : الموردين ###################### --}}
                {{-- @can('supplier_module')  --}}
                    @if(!empty($module_settings['supplier_module']))
                        <li class="scroll"><a href="{{route('suppliers.create')}}"><img src="{{asset('images/topbar/inventory.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.suppliers')}}</span></a></li>
                    @endif

                    <li class="dropdown">
                        <a href="javaScript:void();" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('images/topbar/customer-feedback.png')}}" class="img-fluid" alt="layouts"><span>{{__('lang.delivery')}}</span></a>
                        <ul class="dropdown-menu">
                        <li><a href="{{route('delivery.index')}}"><i class="mdi mdi-circle"></i>{{__('lang.index')}}</a></li>
                        <li><a href="{{route('delivery_plan.plansList')}}"><i class="mdi mdi-circle"></i>{{__('lang.plans')}}</a></li>
                        {{-- <li><a href="{{route('delivery.create')}}"><i class="mdi mdi-circle"></i>{{__('lang.create')}}</a></li> --}}
                        {{-- <a href="{{route('delivery.maps')}}"><img src="{{asset('images/topbar/inventory.png')}}" class="img-fluid" alt="widgets"><span>{{__('lang.delivery')}}</span></a> --}}
                        </ul>
                    </li>

                {{-- @endcan --}}
                {{-- ###################### sell car : عربة بيع ###################### --}}
                {{-- @can('sell_car_module')  --}}`
                  <li class="dropdown">
                      <a href="#">
                          <img src="{{asset('images/topbar/warehouse.png')}}" class="img-fluid" alt="components">
                          <span>{{__('lang.sell_car')}}</span>
                      </a>
                      <ul class="dropdown-menu">
                          {{-- ########### purchase_order : اوامر الشراء########### --}}
                          <li><a href="{{route('sell-car.index')}}"><i class="mdi mdi-circle"></i>@lang('lang.sell_car')</a></li>
                          {{-- ########### required_products : المواد المطلوبة ########### --}}
                          <li><a href="{{ route('delivery.index') }}"><i class="mdi mdi-circle"></i>@lang('lang.plans')</a></li>
                      </ul>
                  </li>

                <li class="dropdown">
                    <a href="#">
                        <img src="{{asset('images/topbar/warehouse.png')}}" class="img-fluid" alt="components">
                        <span>{{__('lang.representatives_requests')}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('representatives.index')}}"><i class="mdi mdi-circle"></i>{{__('lang.representatives_requests')}}</a></li>
                        <li><a href="{{route('rep_plan.index')}}"><i class="mdi mdi-circle"></i>{{__('lang.plans')}}</a></li>

                    </ul>
                </li>
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
                                <li class="mega-menu-col col-md-2">
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
                                <li class="mega-menu-col col-md-2">
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
                                <li class="mega-menu-col col-md-2">
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{route('branches.index')}}">
                                                <i class="mdi mdi-circle"></i>@lang('lang.branches')
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
                                <li>
                                    <a href="{{route('reports.products')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.product_report')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('reports.initial_balance')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.initial_balance')}}
                                    </a>
                                </li>
                                {{-- +++++++++++ purchases report +++++++++++ --}}
                                <li>
                                    <a href="{{route('reports.add_stock')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.purchases_report')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('reports.best_seller')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.best_seller_report')}}
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
                                {{-- +++++++++++ employees sales report +++++++++++ --}}
                                   <li>
                                    <a href="{{route('sales-per-employee.index')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.sales_per_employee')}}
                                    </a>
                                </li>
                                   {{-- +++++++++++ monthly sales & purchase report +++++++++++ --}}
                                   <li>
                                    <a href="{{route('report.monthly_sale_report')}}">
                                        <i class="mdi mdi-circle"></i>{{__('lang.monthly_sale_and_purchase_report')}}
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
                <li>
                    <a href="{{route('dues')}}">
                        <img src="{{asset('images/topbar/warehouse.png')}}" class="img-fluid" alt="components">
                        <span>{{__('lang.dues')}}</span>
                    </a>
                </li>


              </ul>
            </div>
        </nav>
        <!-- End Horizontal Nav -->
    </div>
    <!-- End container-fluid -->
</div>
<!-- End Navigationbar -->
