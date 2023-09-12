<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable,HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function job()
    {
        return $this->hasMany(JobType::class);
    }
    public function employee()
    {
        return $this->hasOne(Employee::class,'user_id');
    }
    public function employees()
    {
        return $this->hasMany(Employee::class,'user_id');
    }

    public function scopeNotview($query)
    {
        return $query->where('email', '!=', env( 'SYSTEM_SUPERADMIN','superadmin@sherifshalaby.tech'));
    }

    public static function modulePermissionArray()
    {
        return [
            'dashboard' => __('lang.dashboard'),
            'product_module' => __('lang.product_module'),
            'stock_module' => __('lang.stock_module'),
            'cashier_module' => __('lang.cashier_module'),
            'return_module' => __('lang.return_module'),
            'employee_module' => __('lang.employee_module'),
            'customer_module' => __('lang.customer_module'),
            'supplier_module' => __('lang.supplier_module'),
            'reports_module' => __('lang.reports_module'),
            'settings_module' => __('lang.settings_module'),
        ];
    }
    public static function subModulePermissionArray()
    {
        return [
            'dashboard' ,
            'product_module' => [
                'product' => __('lang.products'),
                'product_classification_tree' => __('lang.product_classification_tree'),
                'purchase_price' => __('lang.purchase_price'),
                'sell_price' => __('lang.sell_price'),
                'discount' => __('lang.discount'),
            ],
            'stock_module' => [
                'add_stock' => __('lang.add_stock'),
                'pay' => __('lang.pay'),
                'remove_stock' => __('lang.remove_stock'),
                'internal_stock_request' => __('lang.internal_stock_request'),
                'internal_stock_return' => __('lang.internal_stock_return'),
                'transfer' => __('lang.transfer'),
                'import' => __('lang.import'),
            ],
            'cashier_module' => [
                'pos' => __('lang.pos'),
                'pay' => __('lang.payment'),
                'sale' => __('lang.sale'),
                'delivery_list' => __('lang.delivery_list'),
                'import' => __('lang.import'),
            ],
            'return_module' => [
                'sell_return_pay' => __('lang.sell_return_pay'),
                'purchase_return' => __('lang.purchase_return'),
                'purchase_return_pay' => __('lang.purchase_return_pay'),
            ],
            'employee_module' => [
                'employee' => __('lang.employees'),
                'employee_commission' => __('lang.employee_commission'),
                'jobs' => __('lang.jobs'),
                'leave_types' => __('lang.leave_types'),
                'leaves' => __('lang.leaves'),
                'attendance' => __('lang.attendance'),
                'wages' => __('lang.wages'),
            ],
            'customer_module' => [
                'customer' => __('lang.customer'),
                'customer_type' => __('lang.customer_type'),
                'add_payment' => __('lang.add_payment'),
            ],
            'supplier_module' => [
                'supplier' => __('lang.suppliers'),
            ],
            'reports_module' => [
                'profit_loss' => __('lang.profit_loss'),
                'daily_sales_summary' => __('lang.daily_sales_summary'),
                'receivable_report' => __('lang.receivable_report'),
                'payable_report' => __('lang.payable_report'),
                'expected_receivable_report' => __('lang.expected_receivable_report'),
                'expected_payable_report' => __('lang.expected_payable_report'),
                'summary_report' => __('lang.summary_report'),
                'sales_per_employee' => __('lang.sales_per_employee'),
                'best_seller_report' => __('lang.best_seller_report'),
                'product_report' => __('lang.product_report'),
                'daily_sale_report' => __('lang.daily_sale_report'),
                'monthly_sale_report' => __('lang.monthly_sale_report'),
                'daily_purchase_report' => __('lang.daily_purchase_report'),
                'monthly_purchase_report' => __('lang.monthly_purchase_report'),
                'sale_report' => __('lang.sale_report'),
                'purchase_report' => __('lang.purchase_report'),
                'store_report' => __('lang.store_report'),
                'store_stock_chart' => __('lang.store_stock_chart'),
                'product_quantity_alert_report' => __('lang.product_quantity_alert_report'),
                'user_report' => __('lang.user_report'),
                'customer_report' => __('lang.customer_report'),
                'supplier_report' => __('lang.supplier_report'),
                'due_report' => __('lang.due_report'),
            ],
            'settings_module' => [
                'store' => __('lang.stores'),
                'modules' => __('lang.modules'),
                'general_settings' => __('lang.general_settings'),
                'category' => __('lang.category'),
                'brand' => __('lang.brand'),
                'unit' => __('lang.unit'),
                'color' => __('lang.color'),
                'size' => __('lang.size'),
                //
                'money_safe' => __('lang.money_safe'),
                'add_money_to_safe' => __('lang.add_moneysafe'),
                'take_money_from_safe' => __('lang.take_money_safe'),
                'statement' => __('lang.statement'),
                //
                'add_cash_in' => __('lang.add_cash_in'),
                'add_closing_cash' => __('lang.add_closing_cash'),
                'add_cash_out' => __('lang.add_cash_out'),
                'view_details' => __('lang.view_details'),
                //
                'sales_promotion' => __('lang.sales_promotion'),
            ],
        ];
    }
}
