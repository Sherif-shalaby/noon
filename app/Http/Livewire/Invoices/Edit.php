<?php

namespace App\Http\Livewire\Invoices;

use App\Models\ProductPrice;
use App\Models\RequiredProduct;
use App\Models\VariationPrice;
use App\Models\VariationStockline;
use App\Utils\Util;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Store;
use App\Models\System;
use App\Models\JobType;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\SellLine;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\MoneySafe;
use App\Models\Variation;
use App\Models\GeneralTax;
use App\Models\AddStockLine;
use App\Models\CashRegister;
use App\Models\ProductStore;
use Livewire\WithPagination;
use App\Models\StockTransaction;
use App\Models\CustomerOfferPrice;
use App\Models\CustomerPriceOffer;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionSellLine;
use Illuminate\Contracts\View\View;
use App\Models\MoneySafeTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Models\CashRegisterTransaction;
use App\Models\CustomerType;
use App\Models\StockTransactionPayment;
use App\Models\PaymentTransactionSellLine;
use App\Models\TransactionCustomerOfferPrice;
use Illuminate\Contracts\Foundation\Application;

class Edit extends Component
{
    use WithPagination;

    // public $transaction_sell_line, $client_id, $department_id1 = null, $department_id2 = null, $department_id3 = null, $department_id4 = null, $store_pos, $store_pos_id, $brands, $brand_id, $divide_costs, $other_expenses = 0, $other_payments = 0, $block_for_days, $tax_method, $validity_days, $store_id, $block_qty, $customer_id, $customers, $stores, $status, $order_date, $purchase_type,
    //     $invoice_no, $discount_amount,$payment_types,$invoice_lang, $source_type, $payment_status, $source_id, $supplier, $exchange_rate, $amount, $method,
    //     $paid_on, $paying_currency, $transaction_date, $notes, $notify_before_days, $due_date, $showColumn = false, $payments = [],
    //     $transaction_currency, $current_stock, $clear_all_input_stock_form, $searchProduct, $items = [], $department_id, $dollar_amount,
    //     $files, $upload_documents, $discount_type, $discount_value, $total_cost,
    //     $selling_price, $dollar_selling_price, $deleted_ids = [], $alphabetical_order_id, $price_order_id, $dollar_price_order_id,
    //     $expiry_order_id, $dollar_highest_price, $dollar_lowest_price, $dollar_final_total, $total_dollar, $final_total, $dollar_remaining, $dinar_remaining,
    //     $search_by_product_symbol,$draft_transactions,$created_by, $countryId, $countryName, $country, $net_dollar_remaining = 0, $reprsenative_sell_car, $discount = 0.00, $discount_dollar,$total,$rest;
    public $products = [], $variations = [], $transaction_sell_line,$total_cost,  $department_id1 = null, $department_id2 = null, $department_id3 = null, $department_id4 = null, $items = [],$deleted_items_key=[], $price, $total, $client_phone,
        $client_id, $client, $cash = 0, $rest, $invoice, $invoice_id, $date, $payment_status, $data = [], $payments = [],
        $invoice_lang, $transaction_currency, $store_id, $store_pos_id, $showColumn = false, $anotherPayment = false, $sale_note,
        $payment_note, $staff_note, $payment_types, $discount = 0.00, $total_dollar, $add_customer = [], $customers = [], $discount_dollar,
        $store_pos, $allproducts = [], $brand_id = 0, $brands = [], $deliveryman_id = null, $delivery_cost, $dollar_remaining = 0,
        $dinar_remaining = 0, $customer_data, $searchProduct, $stores, $reprsenative_sell_car = false, $final_total, $dollar_final_total,
        $dollar_amount = 0, $amount = 0, $redirectToHome = false, $status = 'final', $draft_transactions, $show_modal = false,

        $search_by_product_symbol, $highest_price, $lowest_price, $from_a_to_z, $from_z_to_a, $nearest_expiry_filter, $longest_expiry_filter,
        $alphabetical_order_id, $price_order_id, $dollar_price_order_id, $expiry_order_id, $dollar_highest_price, $dollar_lowest_price, $due_date, $created_by,
        $customer_id, $countryId, $countryName, $country, $net_dollar_remaining = 0,$back_to_dollar, $add_to_balance = 0 ,$representative_id,
        $loading_cost, $dollar_loading_cost,$cust_phone,$cust_name, $invoice_number;

    protected $rules =
    [
        'store_id' => 'required',
        'customer_id' => 'required',
        'supplier' => 'required',
        'status' => 'required',
        'paying_currency' => 'required',
        'purchase_type' => 'required',
        'payment_status' => 'required',
        'method' => 'required',
        'amount' => 'required',
        'transaction_currency' => 'required'
    ];
    protected $listeners = ['listenerReferenceHere', 'create_purchase_order', 'changeDinarPrice', 'changeDollarPrice', 'changePrices'];

    public function listenerReferenceHere($data)
    {
        if (isset($data['var1'])) {
            if ($data['var1'] == 'client_id') {
                $this->{$data['var1']} = (int)$data['var2'];
                $this->getCustomerData($this->client_id);
            } else
                $this->{$data['var1']} = $data['var2'];
        }
        if (isset($data['var1']) && $data['var1'] == "store_id") {
            $this->changeAllProducts();
            //        $this->store_pos = StorePos::where('store_id', $this->store_id)->where('user_id', Auth::user()->id)->pluck('name','id')->toArray();
        }
        if (isset($data['var1']) && $data['var1'] == "department_id1") {
            $this->updatedDepartmentId($data['var2'], 'department_id1');
        }
        if (isset($data['var1']) && $data['var1'] == "department_id2") {
            $this->updatedDepartmentId($data['var2'], 'department_id2');
        }
        if (isset($data['var1']) && $data['var1'] == "department_id3") {
            $this->updatedDepartmentId($data['var2'], 'department_id3');
        }
        if (isset($data['var1']) && $data['var1'] == "department_id4") {
            $this->updatedDepartmentId($data['var2'], 'department_id4');
        }
        if (isset($data['var1']) && $data['var1'] == "brand_id") {
            $this->updatedDepartmentId($data['var2'], 'brand_id');
        }
    }

    // Get "customers" and "stores"
    public function mount($id, Util $commonUtil)
    {
        $this->payment_types = $commonUtil->getPaymentTypeArrayForPos();
        $this->department_id1 = null;
        $this->department_id2 = null;
        $this->department_id3 = null;
        $this->department_id4 = null;
        $this->invoice_lang = !empty(System::getProperty('invoice_lang')) ? System::getProperty('invoice_lang') : 'en';
        $this->transaction_sell_line = TransactionSellLine::with('transaction_sell_lines')->find($id);
        $this->store_id = $this->transaction_sell_line->store_id;
        $this->client_id    = $this->transaction_sell_line->customer_id;
        $this->store_pos_id = $this->transaction_sell_line->store_pos_id;
        $this->brands = Brand::orderby('created_at', 'desc')->pluck('name', 'id');
        $this->brand_id = $this->transaction_sell_line->brand_id;
//         dd($this->transaction_sell_line->transaction_sell_lines);
        foreach ($this->transaction_sell_line->transaction_sell_lines as  $line) {
            $this->addLineProduct($line);
        }
        $this->set_data();
        $this->store_pos = StorePos::where('user_id', Auth::user()->id)->pluck('name', 'id')->toArray();
        if (empty($this->store_pos)) {
            $this->dispatchBrowserEvent('NoUserPos');
        }
        $this->store_pos_id = array_key_first($this->store_pos);
        // dd(Auth::user()->id);
        $store_pos = StorePos::find($this->store_pos_id);
        if (empty($store_pos)) {
            $this->dispatchBrowserEvent('NoUserPos');
        }
        if (auth()->user()->is_superadmin == 1 || auth()->user()->is_admin == 1) {
            $this->stores = Store::latest()->pluck('name', 'id')->toArray();
            if (!empty($store_pos)) {
                $user_stores = !empty($store_pos->user) ? $store_pos->user->employee->stores()->pluck('name', 'id')->toArray() : [];
                $branch = $store_pos->user->employee->branch;
                $this->store_id = array_key_first($user_stores);
            }
        } else {
            if (!empty($store_pos)) {
                $this->stores = !empty($store_pos->user) ? $store_pos->user->employee->stores()->pluck('name', 'id')->toArray() : [];
                $branch = $store_pos->user->employee->branch;
                $this->store_id = array_key_first($this->stores);
            }
        }
        /*  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                Set "store" of "last TransactionSellLine" of "login user"
                as default value for "stores dropdown" in "sell_screen"
            ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
         */
        // dd($this->stores[1]);
        $last_sell_trans = TransactionSellLine::where('employee_id', auth()->user()->id)->latest()->first();
        if (!empty($last_sell_trans->store_id)) {
            $this->store_id = $last_sell_trans->store_id;
        } else {
            $this->store_id = array_key_first($this->stores);
        }

        if (!empty($branch)) {
            if ($branch->type == 'sell_car') {
                $this->reprsenative_sell_car = true;
            }
        }
        $this->changeAllProducts();
        $this->client_id = 1;
        $this->getCustomerData($this->client_id);
        $this->payment_status = 'paid';
        $this->dispatchBrowserEvent('initialize-select2');
    }

    // +++++++++ Get "customers" +++++++++
    public function updated($propertyName)
    {
        // $this->validateOnly($propertyName);
        if ($propertyName === 'highest_price') {
            $this->updatedDepartmentId($this->highest_price, 'highest_price');
        } else if ($propertyName === 'lowest_price') {
            $this->updatedDepartmentId($this->lowest_price, 'lowest_price');
        } else if ($propertyName === 'from_a_to_z') {
            $this->updatedDepartmentId($this->from_a_to_z, 'from_a_to_z');
        } else if ($propertyName === 'from_z_to_a') {
            $this->updatedDepartmentId($this->from_z_to_a, 'from_z_to_a');
        } else if ($propertyName === 'nearest_expiry_filter') {
            $this->updatedDepartmentId($this->nearest_expiry_filter, 'nearest_expiry_filter');
        } else if ($propertyName === 'longest_expiry_filter') {
            $this->updatedDepartmentId($this->longest_expiry_filter, 'longest_expiry_filter');
        } else if ($propertyName === 'dollar_highest_price') {
            $this->updatedDepartmentId($this->dollar_highest_price, 'dollar_highest_price');
        } else if ($propertyName === 'dollar_lowest_price') {
            $this->updatedDepartmentId($this->dollar_lowest_price, 'dollar_lowest_price');
        }
    }

    // ++++++++++++++++++++++++++++++++++ render() == index() method ++++++++++++++++++++++++++++++++++
    public function render(): Factory|View|Application
    {
        $departments = Category::where('parent_id', '!=', null)->get();
        $this->brands = Brand::orderby('created_at', 'desc')->pluck('name', 'id');
        $this->customers = Customer::orderBy('created_by', 'asc')->get();
        $languages = System::getLanguageDropdown();
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $customer_types = CustomerType::latest()->pluck('name', 'id');
        $delivery_job_type = JobType::where('title', 'Deliveryman')->first();
        $deliverymen = Employee::where('job_type_id', $delivery_job_type->id)->pluck('employee_name', 'id');
        $rep_job_type = JobType::where('title', 'Representative')->first();
        $representatives = Employee::where('job_type_id', $rep_job_type->id)->pluck('employee_name', 'id');
        $search_result = '';
        if (!empty($this->search_by_product_symbol)) {
            $search_result = Product::when($this->search_by_product_symbol, function ($query) {
                return $query->where('product_symbol', 'like', '%' . $this->search_by_product_symbol . '%');
            });
            $search_result = $search_result->paginate();
            if (count($search_result) === 1) {
                $this->add_product($search_result->first()->id);
                $search_result = '';
                $this->search_by_product_symbol = '';
            }
        }
        if (!empty($this->searchProduct)) {
            $search_result = Product::when($this->searchProduct, function ($query) {
                return $query->where('name', 'like', '%' . $this->searchProduct . '%')
                    ->orWhere('sku', 'like', '%' . $this->searchProduct . '%');
            });
            $search_result = $search_result->get();
            if (count($search_result) == 0) {
                $variation = Variation::when($this->searchProduct, function ($query) {
                    return $query->where('sku', 'like', '%' . $this->searchProduct . '%');
                })->pluck('product_id');
                $search_result = Product::whereIn('id', $variation);
                $search_result = $search_result->get();
            }

            if (count($search_result) === 1) {
                $this->add_product($search_result->first()->id);
                $search_result = '';
                $this->searchProduct = '';
            }
        }
        $this->draft_transactions = TransactionSellLine::where('status', 'draft')->orderBy('created_at', 'desc')->get();
        $this->dispatchBrowserEvent('initialize-select2');
        // $customers_rt = Customer::orderBy('created_at', 'desc')->pluck('name','id');
        $sell_lines = TransactionSellLine::query();

        // Check if the user is a superadmin or admin
        if (auth()->user()->is_superadmin == 1 || auth()->user()->is_admin == 1) {
            // If the user is a superadmin or admin, get all sell lines
            $sell_lines = $sell_lines->orderBy('created_at', 'desc');
        } else {
            // If the user is not a superadmin or admin, get sell lines created by the current user
            $sell_lines = $sell_lines->where('created_by', auth()->user()->id)->orderBy('created_at', 'desc');
        }

        // // Filter by the selected created_by value if it is set
        // if ($this->customer_id) {
        //     $sell_lines = $sell_lines->where('customer_id', $this->customer_id);
        // }
        //        dd($this->final_total);
        $sell_lines = $sell_lines->paginate(10);
       $toggle_dollar=System::getProperty('toggle_dollar');
        return view('livewire.invoices.edit', compact(
            'departments',
            'languages',
            'selected_currencies',
            'customer_types',
            'search_result',
            'deliverymen',
            // 'customers_rt',
            'sell_lines',
            'representatives',
            'toggle_dollar'
        ));
    }
    public function set_data()
    {
        $this->final_total = number_format($this->transaction_sell_line->final_total, num_of_digital_numbers());
        $this->total = number_format($this->transaction_sell_line->grand_total, num_of_digital_numbers());
        $this->dollar_final_total = number_format($this->transaction_sell_line->dollar_final_total, num_of_digital_numbers());
        $this->total_dollar = number_format($this->transaction_sell_line->dollar_grand_total, num_of_digital_numbers());
        $this->dollar_remaining = number_format($this->transaction_sell_line->dollar_remainin, num_of_digital_numbers());
        $this->dinar_remaining = number_format($this->transaction_sell_line->dinar_remaining, num_of_digital_numbers());
        if (!empty($this->transaction_sell_line->transaction_payments)) {
            $this->dollar_amount = number_format($this->transaction_sell_line->transaction_payments->sum('dollar_amount'), num_of_digital_numbers());
            $this->amount =  number_format($this->transaction_sell_line->transaction_payments->sum('amount'), num_of_digital_numbers());
        }
    }
    // +++++++++++++++ sum_total_cost() : sum all "dinar_sell_price" values ++++++++++++++++
    public function sum_total_cost()
    {
        $totalCost = 0;
        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                $totalCost += (float)$item['sub_total'];
            }
        }
        return number_format($this->num_uf($totalCost), num_of_digital_numbers());
    }
    // +++++++++++++++ sum_dollar_total_cost() : sum all "dollar_sell_price" values ++++++++++++++++
    public function sum_dollar_total_cost()
    {
        $totalDollarCost = 0;
        if(!empty($this->items))
        {
            foreach ($this->items as $item)
            {
                $totalDollarCost += $item['dollar_sub_total'];
            }
        }
        return number_format($totalDollarCost,num_of_digital_numbers());
    }
    public function submit(): Redirector|Application|RedirectResponse
    {
        // $this->validate([
        //     'store_id' => 'required',
        //     'customer_id' => 'required',
        //     // 'block_for_days' => 'required',
        //     // 'validity_days' => 'required',
        // ]);
        try {
            DB::beginTransaction();

            // ++++++++++++++++++++++ update "Transaction Customer Offer Price" table ++++++++++++++++++++++
            $transaction_data =
                [
                    // store_id
                    'store_id' => $this->store_id,
                    // customer_id
                    'customer_id' => $this->customer_id,
                    // is_quotation
                    'is_quotation' => 1,
                    // transaction_date
                    'transaction_date' => !empty($this->transaction_date) ? $this->transaction_date : Carbon::now(),
                    'status' => $this->status,
                    // dinar_sell_price
                    'grand_total' => $this->num_uf($this->sum_total_cost()),
                    'final_total' => isset($this->discount_value) ? ($this->num_uf($this->sum_total_cost()) - $this->discount_value) :  $this->num_uf($this->sum_total_cost()),
                    // dollar_sell_price
                    'dollar_grand_total' => $this->num_uf($this->sum_dollar_total_cost()),
                    'dollar_final_total' => isset($this->discount_value) ? ($this->num_uf($this->sum_dollar_total_cost()) - $this->discount_value) : $this->num_uf($this->sum_dollar_total_cost()),
                    // status
                    'status' => "draft",
                    // block_qty , block_for_days , validity_days , tax_method
                    'block_qty' => !empty($this->block_qty) ? 1 : 0,
                    'block_for_days' => !empty($this->block_for_days) ? $this->block_for_days : 0, //reverse the block qty handle by command using cron job
                    'validity_days' => !empty($this->validity_days) ? $this->validity_days : 0,
                    'tax_method' => !empty($this->tax_method) ? $this->tax_method : null,
                    // discount_type , discount_value
                    'discount_type' => !empty($this->discount_type) ? $this->discount_type : null,
                    'discount_value' => !empty($this->discount_value) ? $this->discount_value :0,
                    // created_by
                    'created_by' => $this->transaction_sell_line->created_by,
                    // 'updated_by' => Auth::user()->id,
                    'deleted_by' => null,
                    'created_at' => $this->transaction_sell_line->created_at,
                    'updated_at' => now(),
                    'representative_id' => $this->representative_id ?? null,
                    'loading_cost' => $this->loading_cost ?? null,
                    'dollar_loading_cost' => $this->dollar_loading_cost ?? null,
                    // 'deleted_at' => null,
                ];
            $transaction_sell_line = $this->transaction_sell_line;
            // dd($customer_offer_price);
            $transaction_sell_line->update($transaction_data);
            foreach ($this->items as $index => $item) {
                if(isset($item['id'])){
                    $sell_line=SellLine::find($item['id']);
                }else{
                    $sell_line=new SellLine();
                }
                $sell_line->transaction_id = $transaction_sell_line->id;
                $sell_line->product_id = $item['product']['id'];
                $sell_line->variation_id = !empty($item['unit_id']) ? $item['unit_id'] :  null;
                $sell_line->product_discount_type = !empty($item['discount_type']) ? $item['discount_type'] : null;
                $sell_line->product_discount_amount = !empty($item['discount_price']) ? $this->num_uf($item['discount_price'], 2) : 0;
                $sell_line->product_discount_category = !empty($item['discount']) ? $item['discount'] : 0;
                $sell_line->quantity = $item['quantity'];
                $sell_line->extra_quantity = (float) $item['extra_quantity'];
                $sell_line->stock_sell_price = !empty($item['current_stock']['sell_price']) ? $item['current_stock']['sell_price'] : null;
                $sell_line->stock_dollar_sell_price = !empty($item['current_stock']['dollar_sell_price']) ? $item['current_stock']['dollar_sell_price'] : null;
                $sell_line->sell_price = !empty($item['price']) ? $item['price'] : null;
                $sell_line->dollar_sell_price = !empty($item['dollar_price']) ? $item['dollar_price'] : null;
                $sell_line->purchase_price = !empty($item['current_stock']['purchase_price']) ? $item['current_stock']['purchase_price'] : null;
                $sell_line->dollar_purchase_price = !empty($item['current_stock']['dollar_purchase_price']) ? $item['current_stock']['dollar_purchase_price'] : null;
                $sell_line->exchange_rate = $item['exchange_rate'];
                $sell_line->sub_total = $this->num_uf($item['sub_total']);
                $sell_line->dollar_sub_total = $this->num_uf($item['dollar_sub_total']);
                $sell_line->stock_line_id  = !empty($item['current_stock']['id']) ? $item['current_stock']['id'] : null;
                $sell_line->save();
            }
            SellLine::whereIn('id',$this->deleted_items_key)->delete();
            // ++++++++++++++++++++++ "Customer Offer Price" table : "Update" And "Insert" ++++++++++++++++++++++
            $keep_line_ids = [];
            // dd($this->deleted_ids);
            foreach ($this->items as $index => $item) {
                // +++++++++++++++++ update Exsiting Products +++++++++++++++++++++
                if (!empty($item['customer_offer_id'])) {
                    $prdouct_customer_offer = CustomerOfferPrice::find($item['customer_offer_id']);
                    // Set values for the new array
                    // dd($prdouct_customer_offer);
                    if(!empty($prdouct_customer_offer)){
                        $prdouct_customer_offer->product_id = $item['product']['id'];
                        $prdouct_customer_offer->quantity = $item['quantity'];
                        $prdouct_customer_offer->sell_price = $item['price']??0;
                        $prdouct_customer_offer->dollar_sell_price = $item['dollar_price']??0;
                        // created_by
                        $prdouct_customer_offer->created_by = null;
                        // updated_by
                        $prdouct_customer_offer->updated_by = Auth::user()->id;
                        // deleted_by
                        $prdouct_customer_offer->deleted_by = null;
                        // created_at
                        $prdouct_customer_offer->created_at = null;
                        // updated_at
                        $prdouct_customer_offer->updated_at = now();
                        // deleted_at
                        $prdouct_customer_offer->deleted_at = null;
                        // +++ save "customer_offer_price id" +++++++++++++++
                        // $keep_line_ids[] = $prdouct_customer_offer->id;
                        // update the customer offer price for this item to the array
                        $prdouct_customer_offer->save();
                    }
                }
                // +++++++++++++++++ Insert New Products +++++++++++++++++++++
                else {
                    // if (!empty($item['product']['id']) && !empty($item['quantity'])) {
                    //     // Create a new array for each item
                    //     $customer_offer_price_array = [];
                    //     // Set values for the new array
                    //     $customer_offer_price_array['transaction_customer_offer_id'] = $transaction_sell_line->id;
                    //     $customer_offer_price_array['product_id'] = $item['product']['id'];
                    //     $customer_offer_price_array['quantity'] = $item['quantity'];
                    //     $customer_offer_price_array['sell_price'] = $item['price'];
                    //     $customer_offer_price_array['dollar_sell_price'] = $item['dollar_price'];
                    //     $customer_offer_price_array['created_at'] = now();
                    //     // created_by
                    //     $customer_offer_price_array['created_by'] = Auth::user()->id;
                    //     // updated_by
                    //     $customer_offer_price_array['updated_by'] = null;
                    //     // deleted_by
                    //     $customer_offer_price_array['deleted_by'] = null;
                    //     // created_at
                    //     $customer_offer_price_array['created_at'] = now();
                    //     // updated_at
                    //     $customer_offer_price_array['updated_at'] = null;
                    //     // deleted_at
                    //     $customer_offer_price_array['deleted_at'] = null;
                    //     // Add the customer offer price for this item to the array
                    //     $customer_offer_prices[] = $customer_offer_price_array;
                    // }
                    // $customer_offer_price_ids_var = CustomerOfferPrice::insert($customer_offer_prices);

                    // Create multiple CustomerOfferPrice records in the database
                    // dd($customer_offer_price_ids_var);
                    // +++++++++++++++ save "all customer_offer_price_ids" +++++++++++++++
                    // $keep_line_ids[] = $customer_offer_prices->id ;
                    // dd($keep_line_ids);
                }
            }
            // Delete "all customer_offer_lines" which are deleted in "Edit" Page
            if (!empty($this->deleted_ids)) {
                for ($i = 0; $i < count($this->deleted_ids); $i++) {
                    $prdouct_customer_offer = CustomerOfferPrice::find($this->deleted_ids[$i]);
                    $prdouct_customer_offer->delete();
                }
            }
            DB::commit();
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'lang.success']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'lang.something_went_wrongs']);
            dd($e);
        }
        return redirect()->route('invoices.edit',$this->transaction_sell_line->id);
    }

    // +++++++++++++++++++++++++ addLineProduct($line) : Add line product information +++++++++++++++++++++++++
    public function addLineProduct($line)
    {
        $product = Product::find($line->product_id);
        $quantity_available = $this->quantityAvailable($product);
        $product_stores = $this->getProductStores($product);
        $get_Variation_price = VariationPrice::where('variation_id', $product->variations()->first()->id ?? 0);
        $customer_types_variations = $get_Variation_price->pluck('customer_type_id')->toArray();
        $customerTypes = CustomerType::whereIn('id', $customer_types_variations)->get();
        $current_stock = AddStockLine::find($line->stock_line_id);
        $new_item = [
            'id'=>$line->id,
            'variation' => $product->variations,
            'product' => $product,
            'customer_types' => $customerTypes,
            'customer_type_id' => $get_Variation_price->first()->customer_type_id ?? 0,
            'quantity' => number_format($line->quantity, num_of_digital_numbers()),
            'extra_quantity' => number_format($line->extra_quantity),
            'price' => number_format($this->num_uf($line->sell_price), num_of_digital_numbers()),
            'dollar_price' => number_format($this->num_uf($line->dollar_sell_price), num_of_digital_numbers()),
            'category_id' => $product->category?->id,
            'department_name' => $product->category?->name,
            'client_id' => $product->customer?->id,
            'exchange_rate' => $line->exchange_rate,
            'quantity_available' => $quantity_available,
            'sub_total' =>  number_format($this->num_uf($line->sub_total), num_of_digital_numbers()),
            'dollar_sub_total' =>  number_format($this->num_uf($line->dollar_sub_total), num_of_digital_numbers()),
            'current_stock' => $current_stock,
            'discount_categories' => !empty($current_stock) ? $current_stock->prices()->get() : null,
            'discount' => number_format($line->product_discount_category, num_of_digital_numbers()),
            'discount_price' => number_format($line->product_discount_amount, num_of_digital_numbers()),
            'discount_type' =>  $line->product_discount_type,
            'discount_category' =>  null,
            'unit_name' => !empty($product->unit) ? $product->unit->name : '',
            'base_unit_multiplier' => !empty($product->unit) ? $product->unit->base_unit_multiplier : 1,
            'total_quantity' => !empty($product->unit) ?  1 * $product->unit->base_unit_multiplier : 1,
            'stores' => $product_stores,
            'unit_id' => $line->variation_id,
            'customer_offer_id' => $line->id,
            'sell_line_id' => $line->id,
        ];
        $this->items[] = $new_item;
//        dd($this->items);
    }
    public function changeAllProducts()
    {
        $products_store = ProductStore::where('store_id', $this->store_id)->pluck('product_id');
        $this->allproducts = Product::whereIn('id', $products_store)->get();
        foreach ($this->items as $key => $item) {
            if (!(ProductStore::where('product_id', $this->items[$key]['product']['id'])->where('store_id', $this->store_id)->exists())) {
                $this->delete_item($key);
            }
        }
    }

    public function changeStatus()
    {
        $this->status = 'draft';
        $this->submit();
    }
    public function pendingStatus()
    {
        $this->payment_status = 'pending';
        $this->submit();
    }
    public function getClient()
    {
        if ($this->client_phone) {
            $this->client = Customer::where('phone', $this->client_phone)->first();
            if ($this->client) {
                $this->client_id = $this->client->id;
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'تم إيجاد العميل بنجاح',]);
            } else {
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'عذرا, لم يتم إيجاد العميل']);
            }
        } else {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'يرجى إدخال رقم العميل']);
        }
    }

    public function getCustomerData($id)
    {
        $this->customer_data = Customer::find($id);
        //        dd($this->customer_data);
    }
    // ++++++++++++++++++++++++ updatedDepartmentId() ++++++++++++++++++++++++
    public function updatedDepartmentId($value, $name)
    {
        $this->allproducts = Product::when($name == 'department_id1', function ($query) {
            $query->where('category_id', $this->department_id1);
            // $query->where(function ($query) {
            //     $query->where('category_id', $this->department_id1)
            //         ->Where('subcategory_id1', $this->department_id2)
            //         ->Where('subcategory_id2', $this->department_id3)
            //         ->Where('subcategory_id3', $this->department_id4);
            // });
        })->when($name == 'department_id2', function ($query) {
            $query->where('subcategory_id1', $this->department_id2);
        })

            ->when($name == 'department_id3', function ($query) {
                $query->where('subcategory_id2', $this->department_id3);
            })
            ->when($name == 'department_id4', function ($query) {
                $query->where('subcategory_id3', $this->department_id4);
                // ++++++++++++++++ brand_id filter ++++++++++++++++
            })->when($name == 'brand_id', function ($query) use ($value) {
                $query->where('brand_id', $this->brand_id);
                // ========================== price_order filter ==========================
                // ++++++++++++++++ if price_order == lowest_price ++++++++++++++++
            })->when($this->price_order_id == 0, function ($query) {
                $query->withCount(['stock_lines as min_sell_price' => function ($subquery) {
                    $subquery->select(DB::raw('min(sell_price)'));
                }])->orderBy('min_sell_price', 'asc');
            })
            // ++++++++++++++++ if price_order == highest_price ++++++++++++++++
            ->when($this->price_order_id == 1, function ($query) {
                $query->withCount(['stock_lines as max_sell_price' => function ($subquery) {
                    $subquery->select(DB::raw('max(sell_price)'));
                }])->orderBy('max_sell_price', 'desc');
            })
            // ========================== alphabetical_order filter ==========================
            // ++++++++++++++++ if alphabetical_order == from_a_to_z ++++++++++++++++
            ->when($this->alphabetical_order_id == 0, function ($query) {
                $query->orderBy('name', 'asc');
            })
            // ++++++++++++++++ if alphabetical_order == from_z_to_a ++++++++++++++++
            ->when($this->alphabetical_order_id == 1, function ($query) {
                $query->orderBy('name', 'desc');
            })
            // ========================== dollar_price_order filter ==========================
            // ++++++++++++++++ if dollar_price_order_id == dollar_lowest_price ++++++++++++++++
            ->when($this->dollar_price_order_id == 0, function ($query) {
                $query->withCount(['stock_lines as min_dollar_sell_price' => function ($subquery) {
                    $subquery->select(DB::raw('min(dollar_sell_price)'));
                }])->orderBy('min_dollar_sell_price', 'asc');
            })
            // ++++++++++++++++ if dollar_price_order_id == dollar_highest_price ++++++++++++++++
            ->when($this->dollar_price_order_id == 1, function ($query) {
                $query->withCount(['stock_lines as max_dollar_sell_price' => function ($subquery) {
                    $subquery->select(DB::raw('max(dollar_sell_price)'));
                }])->orderBy('max_dollar_sell_price', 'desc');
            })
            // ========================== nearest_expiry , longest_expiry filter ==========================
            // ++++++++++++++++ if nearest_expiry_filter == nearest_expiry_filter ++++++++++++++++
            ->when($this->expiry_order_id  == 1, function ($query) {
                $query->withCount(['stock_lines as expiry_date' => function ($subquery) {
                    $subquery->where(function ($q) {
                        $q->whereDate('expiry_date', '>', Carbon::now());
                    });
                }])->orderBy('expiry_date', 'asc');
            })
            // ++++++++++++++++ if nearest_expiry_filter == longest_expiry_filter ++++++++++++++++
            ->when($this->expiry_order_id == 0, function ($query) {

                $query->withCount(['stock_lines as expiry_date' => function ($subquery) {
                    $subquery->where(function ($q) {
                        $q->whereDate('expiry_date', '>', Carbon::now());
                    });
                }])->orderBy('expiry_date', 'desc');
            })
            ->get();
    }

    public function redirectToCustomerDetails($clientId)
    {
        return redirect()->route('customers.show', $clientId);
    }

    public function addCustomer()
    {
        $this->add_customer['created_by'] = Auth::user()->id;
        $customer = Customer::create($this->add_customer);
        $this->customers = Customer::all();
        $this->client_id = $customer->id;
        $this->add_customer = [];
        $this->emit('hideModal', $customer);
        $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'تم اضافه العميل بنجاح',]);
        $this->emit('customerAdded');
    }

    public function refreshSelect()
    {
        $this->customers = Customer::get();
        //        dump($this->customers);
    }

    public function add_product($id)
    {
        //        dd($id);

        if (!empty($this->searchProduct)) {
            $this->searchProduct = '';
        }
        if (!empty($this->search_by_product_symbol)) {
            $this->search_by_product_symbol = '';
        }
        $product = Product::where('id', $id)->first();
        $quantity_available = $this->quantityAvailable($product);
        if ($quantity_available < 1) {
            $this->dispatchBrowserEvent('quantity_not_enough', ['id' => $id]);
        } else {
            $current_stock = $this->getCurrentStock($product);
            $exchange_rate =  !empty($current_stock->exchange_rate) ? $current_stock->exchange_rate : System::getProperty('dollar_exchange');
            $product_stores = $this->getProductStores($product);
            if (isset($discount)) {
                $discounts = $discount;
            } else
                $discounts = 0;

            $newArr = array_filter($this->items, function ($item) use ($product) {
                return $item['product']['id'] == $product->id;
            });
            if (count($newArr) > 0) {
                $key = array_keys($newArr)[0];
                ++$this->items[$key]['quantity'];

                if ($quantity_available  < $this->items[$key]['quantity']) {
                    --$this->items[$key]['quantity'];
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'الكمية غير كافية',]);
                } else {
                    $this->items[$key]['sub_total'] = ($this->num_uf($this->items[$key]['price']) * (float)$this->items[$key]['quantity']) - ((float)$this->items[$key]['quantity'] * $this->num_uf($this->items[$key]['discount']));
                }
            } else {
                $get_Variation_price = VariationPrice::where('variation_id', $product->variations()->first()->id);
                $customer_types_variations = $get_Variation_price->pluck('customer_type_id')->toArray();
                $customerTypes = CustomerType::whereIn('id', $customer_types_variations)->get();
                $price = !empty($current_stock) ? number_format((VariationStockline::where('stock_line_id', $current_stock->id)->where('variation_price_id', $get_Variation_price->first()->id)->first()->sell_price ?? 0), num_of_digital_numbers()) : 0;
                $dollar_price =  !empty($current_stock->id) ? number_format((VariationStockline::where('stock_line_id', $current_stock->id)->where('variation_price_id', $get_Variation_price->first()->id)->first()->dollar_sell_price ?? 0), num_of_digital_numbers()) : 0;
                $dollar_exchange = System::getProperty('dollar_exchange');
                if ($this->num_uf($dollar_exchange) > $this->num_uf($exchange_rate)) {
                    if ($price == 0) {
                        $price = $this->num_uf($dollar_price) * $this->num_uf($exchange_rate);
                        $dollar_price = 0;
                    }
                }
                $new_item = [
                    'variation' => $product->variations,
                    'product' => $product,
                    'customer_types' => $customerTypes,
                    'customer_type_id' => $get_Variation_price->first()->customer_type_id ?? 0,
                    'quantity' => 1,
                    'extra_quantity' => 0,
                    'price' => $this->num_uf($price),
                    'category_id' => $product->category?->id,
                    'department_name' => $product->category?->name,
                    'client_id' => $product->customer?->id,
                    'exchange_rate' => $exchange_rate,
                    'quantity_available' => $quantity_available,
                    // 'stock_units' => $stock_units,
                    'sub_total' =>  (float) 1 * $this->num_uf($price),
                    'dollar_sub_total' => (float) 1 * $this->num_uf($dollar_price),
                    'current_stock' => $current_stock,
                    //                    'discount_categories' =>  $discounts,
                    'discount_categories' => !empty($current_stock) ? $current_stock->prices()->get() : null,
                    'discount' => null,
                    'discount_price' => 0,
                    'discount_type' =>  null,
                    'discount_category' =>  null,
                    'dollar_price' => $this->num_uf($dollar_price),
                    'unit_name' => !empty($product->unit) ? $product->unit->name : '',
                    'base_unit_multiplier' => !empty($product->unit) ? $product->unit->base_unit_multiplier : 1,
                    'total_quantity' => !empty($product->unit) ?  1 * $product->unit->base_unit_multiplier : 1,
                    'stores' => $product_stores,
                    'unit_id' => ProductStore::where('product_id', $product->id)->where('store_id', $this->store_id)->first()->variation_id ?? '',
                ];
                $this->items[] = $new_item;
            }
        }
        $this->computeForAll();
        //        $this->sumSubTotal();
    }
    public function cancel()
    {
        foreach ($this->items as $index => $item) {
            $this->delete_item($index);
        }
    }

    public function getUnits($product, $store)
    {
        $total = [];
        $remaning_quantity = 0;
        $product_store = ProductStore::where('product_id', $product->id)
            ->where('store_id', $store)->first();
        $product_variations = $product->variations;
        $variation = $product_store->variations;
        $quantity_available = $product_store->quantity_available;
        if (!empty($product_variations) && !empty($variation)) {
            foreach ($product_variations as $product_variation) {
                if ($product_variation->unit_id == $variation->unit_id) {
                    $name1 =
                        $total[] = [
                            floor($quantity_available) => $product_variation->unit->name
                        ];
                    //                    $total[$product_variation->unit->name] = floor($quantity_available);
                    if ($quantity_available - floor($quantity_available) > 0) {
                        $remaning_quantity = (float)explode('.', $quantity_available)[1];
                    }
                    if (!empty($remaning_quantity) && $product_variation->basic_unit_id == $variation->basic_unit_id) {
                        $basic_unit_name = $product_variation->basic_unit->name;
                        array_push($total, [$remaning_quantity => $basic_unit_name]);

                        //                        $total[$product_variation->basic_unit->name] = $remaning_quantity;
                        break;
                    }
                }
            }
        } else {
            $total[] = [$quantity_available => ''];
        }
        //        dd($total);
        return $total;
    }

    public function computeForAll()
    {
        $this->total = 0;
        $this->total_dollar = 0;
        $this->loading_cost = 0;
        $this->dollar_loading_cost = 0;
        foreach ($this->items as $item) {
            // dinar_sub_total
            $this->total += round_250($this->num_uf($item['sub_total']));
            // dollar_sub_total
            $this->total_dollar += $this->num_uf($item['dollar_sub_total']);
            $this->discount += $this->num_uf($item['discount_price']);
            $this->discount_dollar += $this->num_uf($item['discount_price']) * $this->num_uf($item['exchange_rate']);
            //  calculate loading cost
            if(!empty($item['unit_id'])){
                $item_variation = Variation::find($item['unit_id']);
                if(System::getProperty('loading_cost_currency') == 2){
                    $this->dollar_loading_cost = $item_variation->unit->loading_cost * $item['quantity'];
                }
                elseif (System::getProperty('loading_cost_currency') != 2 && !empty(System::getProperty('loading_cost_currency'))){
                    $this->loading_cost = $item_variation->unit->loading_cost * $item['quantity'];
                }
            }
        }
        // dd($this->total);

        //        $this->dollar_amount = $this->total_dollar;
        //        $this->amount = round_250($this->total);
        $this->payments[0]['method'] = 'cash';
        $this->rest  = 0;
        // النهائي دينار
        $this->final_total = round_250($this->num_uf($this->total));
        // النهائي دولار
        $this->dollar_final_total = $this->num_uf($this->total_dollar);
        // dd($this->dollar_final_total,round($this->dollar_final_total / 10) * 10);
        $this->net_dollar_remaining = ($this->dollar_final_total - round($this->dollar_final_total, -1));
        // task : الباقي دينار
        $this->dinar_remaining = round_250($this->num_uf($this->amount) - $this->num_uf($this->final_total));
        // task : الباقي دولار
        $this->dollar_remaining = ($this->num_uf($this->dollar_amount) - $this->num_uf($this->dollar_final_total));
    }
    public function changeRemaining()
    {
        $exchange_rate = System::getProperty('dollar_exchange') ?? 1;
        // النهائي دينار
        $this->final_total = round_250($this->num_uf($this->dollar_remaining) * $exchange_rate);
        $this->dollar_final_total -= $this->num_uf($this->dollar_remaining);

        $this->dollar_remaining = 0;
        // task : الباقي دينار
    }
    public function ChangeBillToDinar(){
        $exchange_rate = System::getProperty('dollar_exchange') ?? 1;
        if($this->back_to_dollar==0){
            $final_total= round_250($this->dollar_final_total * $exchange_rate);
            $this->final_total+= ($final_total>0?$final_total:0);
            $this->dollar_final_total=0;
            $total=round_250($this->total_dollar * $exchange_rate);
            $this->total+= ($total>0?$total:0);
            $this->total_dollar=0;

            $discount=round_250($this->discount_dollar * $exchange_rate);
            $this->discount+= ($discount>0?$discount:0);
            $this->discount_dollar=0;

            $amount=round_250($this->dollar_amount * $exchange_rate);
            $this->amount+= ($amount>0?$amount:0);
            $this->dollar_amount=0;

            $dinar_remaining=round_250($this->dollar_remaining * $exchange_rate);
            $this->dinar_remaining+= ($dinar_remaining>0?$dinar_remaining:0);
            $this->dollar_remaining=0;
            $this->back_to_dollar=2;
        }else{
            $this->dollar_final_total+= $this->final_total / $exchange_rate;
            $this->final_total=0;

            $this->total_dollar+= $this->total / $exchange_rate;
            $this->total=0;

            $this->discount_dollar+= $this->discount / $exchange_rate;
            $this->discount=0;

            $this->dollar_amount+= $this->amount / $exchange_rate;
            $this->amount=0;

            $this->dollar_remaining+= $this->dinar_remaining * $exchange_rate;
            $this->dinar_remaining=0;
            $this->back_to_dollar=0;
        }
    }
    public function increment($key)
    {

        if ($this->items[$key]['quantity'] < $this->items[$key]['quantity_available']) {
            $this->items[$key]['quantity']++;

            $this->items[$key]['total_quantity'] = $this->items[$key]['base_unit_multiplier'] *  $this->items[$key]['quantity'];
            $this->subtotal($key);
        } else {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'الكمية غير كافية',]);
        }
        $this->computeForAll();
    }

    public function decrement($key)
    {
        if ($this->items[$key]['quantity'] > 1) {
            $this->items[$key]['quantity']--;
            $this->subtotal($key);
        }
        $this->computeForAll();
    }

    public function delete_item($key)
    {
        if(isset($this->items[$key]['id'])){
            $this->deleted_items_key[]=$this->items[$key]['id'];
        }
        unset($this->items[$key]);
        $this->computeForAll();
    }

    public function changePrice($key)
    {
        if (!empty($this->items[$key]['price'])) {
            $this->items[$key]['dollar_price'] = number_format($this->num_uf($this->items[$key]['price']) / $this->num_uf($this->items[$key]['exchange_rate']), num_of_digital_numbers());
            $this->items[$key]['dollar_sub_total'] = number_format($this->num_uf($this->items[$key]['dollar_price']) * $this->num_uf($this->items[$key]['quantity']), num_of_digital_numbers());
            $this->items[$key]['sub_total'] = 0;
            $this->items[$key]['price'] = 0;
        } else {
            $this->items[$key]['price'] = number_format($this->num_uf($this->items[$key]['dollar_price']) * $this->num_uf($this->items[$key]['exchange_rate']), num_of_digital_numbers());
            $this->items[$key]['sub_total'] = number_format($this->num_uf($this->items[$key]['price']) * $this->num_uf($this->items[$key]['quantity']), num_of_digital_numbers());
            $this->items[$key]['dollar_sub_total'] = 0;
            $this->items[$key]['dollar_price'] = 0;
        }
        $this->computeForAll();
    }
    public function changeCustomerType($key)
    {
        // dd($this->items[$key]['variation']);
        $variation_price = VariationPrice::where('variation_id', $this->items[$key]['unit_id'])->where('customer_type_id', $this->items[$key]['customer_type_id'])->first();
        if (isset($variation_price->id)) {
            $variation_stock_line = VariationStockline::where('stock_line_id', $this->items[$key]['current_stock']['id'])->where('variation_price_id', $variation_price->id)->first();
            $dollar_exchange = System::getProperty('dollar_exchange');
            if ($this->num_uf($dollar_exchange) > $this->num_uf($this->items[$key]['current_stock']['exchange_rate'])) {
                if ($variation_stock_line->dinar_sell_price == 0) {
                    $this->items[$key]['price'] = $this->num_uf($variation_stock_line->dollar_sell_price) * $this->num_uf($this->items[$key]['current_stock']['exchange_rate']);
                    $this->items[$key]['dollar_price'] = 0;
                }
            } else {
                $this->items[$key]['dollar_price'] = number_format($variation_stock_line->dollar_sell_price, num_of_digital_numbers());
                $this->items[$key]['price'] = number_format($variation_stock_line->dinar_sell_price, num_of_digital_numbers());
            }
        }
        $this->subtotal($key);
        $this->computeForAll();
    }
    public function resetAll()
    {
        $this->client_id = '';
        $this->reset();
    }

    public function ValidationAttributes()
    {
        return [
            'client_id' => __('اسم العميل'),
            'cash' => __('الدفع نقدا'),
        ];
    }

    public function subtotal($key, $via = 'quantity')
    {
        if ($via == 'quantity') {
            $this->changeDiscount($key);
        }
        if ($this->items[$key]['discount'] != 0) {
            $discount = ProductPrice::where('id', $this->items[$key]['discount'])->get()->last();
            $this->items[$key]['discount_type'] = $discount->price_type;
            $this->items[$key]['discount_category'] = $discount->price_category;
            //            $amount = max(1, round($this->items[$key]['quantity'] / $discount->quantity));
            $amount = (int)($this->items[$key]['quantity'] / $discount->quantity);
            $this->items[$key]['extra_quantity'] = ($this->items[$key]['quantity'] >= $discount->quantity) ? (($discount->bonus_quantity ?? 0) * $amount) : 0;
            $price = ($this->items[$key]['quantity'] >= $discount->quantity) ? $discount->price : 0;
        } else
            $price = 0;

        $this->items[$key]['discount_price'] = $price;
        $this->items[$key]['sub_total'] = ((float)$this->num_uf($this->items[$key]['price']) * $this->items[$key]['quantity']) -
            ($this->items[$key]['quantity'] * (float)$this->num_uf($this->items[$key]['discount_price']));
        $this->items[$key]['dollar_sub_total']  =  ((float)$this->num_uf($this->items[$key]['dollar_price']) * $this->items[$key]['quantity']) -
            ($this->items[$key]['quantity'] * (float)$this->num_uf($this->items[$key]['discount_price']));
        $this->computeForAll();
    }

    public function changeDiscount($key)
    {
        $discounts = collect($this->items[$key]['discount_categories'])->sortByDesc('quantity')->toArray();
        foreach ($discounts as $discount) {
            $currentQuantity = $this->items[$key]['quantity'];
            // Check if the quantity meets the current discount condition
            if (!empty($discount['quantity'])) {
                if ($currentQuantity >= $discount['quantity']) {
                    $this->items[$key]['discount'] = $discount['id'];
                    break;
                }
            }
        }
    }

    // calculate dollar_final_total : "النهائي دولار"
    public function changeDollarTotal()
    {
        //  "النهائي دولار"
        $this->dollar_final_total = $this->total_dollar - $this->discount_dollar;
        // Task : dollar_remaining : الباقي دولار
        $this->dollar_remaining = ($this->dollar_amount - $this->dollar_final_total);
    }

    public function changeReceivedDollar()
    {
        if ($this->dollar_amount !== null && $this->dollar_amount !== 0) {
            if ($this->final_total == 0 && $this->dollar_final_total !== 0 && $this->dollar_amount !== 0 && $this->amount != 0) {
                // $diff_dollar = $this->dollar_amount -  $this->dollar_final_total;
                // $this->dinar_remaining = round_250($this->dinar_remaining - ( $diff_dollar * System::getProperty('dollar_exchange')));
                $this->dollar_remaining = $this->num_uf($this->dollar_final_total) - ($this->num_uf($this->dollar_amount) + ($this->num_uf($this->amount) / System::getProperty('dollar_exchange')));
            } elseif ($this->dollar_final_total == 0 && $this->final_total !== 0 && $this->dollar_amount !== 0 && $this->amount != 0) {
                // $diff_dollar = $this->dollar_amount -  $this->dollar_final_total;
                // $this->dinar_remaining = round_250($this->dinar_remaining - ( $diff_dollar * System::getProperty('dollar_exchange')));
                $this->dinar_remaining = $this->num_uf($this->final_total) - ($this->num_uf($this->amount) + ($this->num_uf($this->dollar_amount) * System::getProperty('dollar_exchange')));
            } elseif ($this->dinar_remaining > 0 && $this->dollar_final_total !== null && $this->dollar_final_total !== 0 && $this->dollar_amount > $this->dollar_final_total) {
                $diff_dollar = $this->num_uf($this->dollar_amount) -  $this->num_uf($this->dollar_final_total);
                $this->dinar_remaining = round_250($this->num_uf($this->dinar_remaining) - ($this->num_uf($diff_dollar) * System::getProperty('dollar_exchange')));
                $this->dollar_remaining = 0;
            } else {
                // Check if total is in dinar and both dollar and dinar amounts are 0
                if ($this->final_total != 0 && $this->dollar_final_total == 0 && $this->num_uf($this->amount) == 0) {
                    // Round to the nearest 250 value
                    $rounded_final_total = round_250($this->num_uf($this->final_total));
                    // Convert remaining dollar to dinar
                    $this->dinar_remaining = round_250($this->num_uf($rounded_final_total) - ($this->num_uf($this->dollar_amount) * System::getProperty('dollar_exchange')));
                }
                // Handle the case where total is in dollar and both dollar and dinar amounts are 0
                elseif ($this->dollar_final_total != 0) {
                    // Calculate remaining dollar amount directly
                    $this->dollar_remaining = $this->num_uf($this->dollar_final_total) - $this->num_uf($this->dollar_amount);
                    if ($this->final_total != 0) {
                        $this->dinar_remaining = round_250($this->num_uf($this->final_total) - $this->num_uf($this->amount));
                        if ($this->dinar_remaining < 0 &&  $this->dollar_remaining > 0) {
                            $diff_dinar = $this->num_uf($this->amount) -  $this->num_uf($this->final_total);
                            $this->dollar_remaining = $this->num_uf($this->dollar_remaining) - ($this->num_uf($diff_dinar) / System::getProperty('dollar_exchange'));
                            $this->dinar_remaining = 0;
                        }
                    }
                }
            }
            if ($this->add_to_balance == "0") {
                $this->new_added_dollar_balance = $this->num_uf($this->dollar_amount) - $this->num_uf($this->dollar_final_total);
                if ($this->new_added_dollar_balance > 0) {
                    $this->add_to_balance = "1";
                }
            }
        }
    }

    public function changeReceivedDinar()
    {
        if ($this->amount !== null && $this->amount !== 0) {
            if ($this->final_total == 0 && $this->dollar_final_total !== 0 && $this->dollar_amount !== 0 && $this->amount != 0) {
                $this->dollar_remaining = $this->num_uf($this->dollar_final_total) - ($this->num_uf($this->dollar_amount) + ($this->num_uf($this->amount) / System::getProperty('dollar_exchange')));
            } elseif ($this->dollar_final_total == 0 && $this->final_total !== 0 && $this->dollar_amount !== 0 && $this->amount != 0) {

                $this->dinar_remaining = $this->num_uf($this->final_total) - ($this->num_uf($this->amount) + ($this->num_uf($this->dollar_amount) * System::getProperty('dollar_exchange')));
            } elseif ($this->dollar_remaining > 0 && $this->final_total !== null && $this->final_total !== 0 && $this->amount > $this->final_total) {
                $diff_dinar = $this->num_uf($this->amount) -  $this->num_uf($this->final_total);
                $this->dollar_remaining = $this->num_uf($this->dollar_remaining) - ($this->num_uf($diff_dinar) / System::getProperty('dollar_exchange'));
                $this->dinar_remaining = 0;
            } else {
                // Check if total is in dollars and both dollar and dinar amounts are 0
                if ($this->dollar_final_total != 0 && $this->final_total == 0 && $this->dollar_amount == 0) {
                    // Calculate remaining dollar amount directly
                    $this->dollar_remaining = $this->num_uf($this->dollar_final_total) - ($this->num_uf($this->amount) / System::getProperty('dollar_exchange'));
                }
                // Check if total is in dinars and both dollar and dinar amounts are 0
                elseif ($this->final_total != 0) {
                    // Calculate remaining dinar amount
                    $this->dinar_remaining = round_250($this->num_uf($this->final_total)) - $this->num_uf($this->amount);

                    if ($this->dollar_final_total != 0) {
                        $this->dollar_remaining = $this->num_uf($this->dollar_final_total) - $this->num_uf($this->dollar_amount);
                        if ($this->dollar_remaining < 0 &&  $this->dinar_remaining > 0) {
                            $diff_dollar = $this->num_uf($this->dollar_amount) -  $this->num_uf($this->dollar_final_total);
                            $this->dinar_remaining = round_250($this->num_uf($this->dinar_remaining) - ($this->num_uf($diff_dollar) * System::getProperty('dollar_exchange')));
                            $this->dollar_remaining = 0;
                        }
                    }
                    // else{
                    //     $this->dollar_remaining = $this->dollar_final_total - ($this->dollar_amount + ($this->amount / System::getProperty('dollar_exchange')));
                    //     $this->dinar_remaining = $this->final_total - ($this->amount + ($this->dollar_amount * System::getProperty('dollar_exchange')));
                    // }
                    // Convert remaining dinar to dollars using the exchange rate
                    // $this->dollar_remaining = $this->dinar_remaining * System::getProperty('dollar_exchange');
                }
            }
            if ($this->add_to_balance == "0") {
                $this->new_added_dinar_balance = $this->num_uf($this->amount) - $this->num_uf($this->final_total);
                if ($this->new_added_dinar_balance > 0) {
                    $this->add_to_balance = "1";
                }
            }
        }
    }

    // calculate final_total : "النهائي دينار"
    public function changeTotal()
    {
        // "النهائي دينار"
        $this->final_total = round_250($this->total - $this->discount);
        // Task : dollar_remaining : الباقي دينار
        $this->dinar_remaining = round_250($this->amount - $this->final_total);
    }

    public function ShowDollarCol()
    {
        $this->showColumn = !$this->showColumn;
    }

    public function quantityAvailable($product)
    {
        $quantity_available = ProductStore::where('product_id', $product->id)->where('store_id', $this->store_id)
            ->first()->quantity_available ?? 0;

        return $quantity_available;
    }

    public function getProductDiscount($sid)
    {
        $product  = ProductPrice::where('product_id', $sid);
        if (isset($product)) {
            $product->where(function ($query) {
                $query->where('price_start_date', '<=', date('Y-m-d'));
                $query->where('price_end_date', '>=', date('Y-m-d'));
                $query->orWhere('is_price_permenant', "1");
            })->get();
        }
        return $product->get();
    }

    public function getCurrentStock($product)
    {
        $product_stocklines = $product->stock_lines;
        foreach ($product_stocklines as $stockline) {
            $quantity_available =  $stockline->quantity - $stockline->quantity_sold  + $stockline->quantity_returned;
            if ($quantity_available > 0) {
                return $stockline;
            }
        }
        return null;
    }

    public function getProductStores($product)
    {
        $stores = ProductStore::where('product_id', $product->id)->get();
        return $stores;
    }

    public  function changeQuantity($key)
    {
        if (!empty($this->items[$key]['store'])) {
            $store = ProductStore::where('store_id', $this->items[$key]['store'])
                ->where('product_id', $this->items[$key]['product']['id'])->get()->first();
            $this->items[$key]['quantity_available'] = $store->quantity_available;
        }
    }

    public function generateInvoivceNumber($i = 1)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $inv_count = TransactionSellLine::all()->count() + $i;

        $invoice_no = 'Inv' . $year . $month . $inv_count;


        return $invoice_no;
    }

    public function updateSoldQuantityInAddStockLine($product_id, $store_id, $new_quantity, $stock_id = null, $variation_id)
    {
        $stock = AddStockLine::where('product_id', $product_id)->first();
        $product_variations = Variation::where('product_id', $product_id)->get();
        $unit = Variation::where('id', $variation_id)->first();
        $qty_difference = 0;
        $qtyByUnit = 1;
        if (!empty($stock) && !empty($stock->variation_id && !empty($unit))) {
            $stock_variation = Variation::find($stock->variation_id);
            if ($stock_variation->unit_id == $unit->unit_id) {
                $qty_difference = $new_quantity;
            } elseif ($stock_variation->basic_unit_id == $unit->unit_id) {
                $qtyByUnit = 1 / $stock_variation->equal;
                $qty_difference = $qtyByUnit * $new_quantity;
            } else {
                foreach ($product_variations as $key => $product_variation) {
                    if (!empty($product_variations[$key + 1])) {
                        if ($stock_variation->basic_unit_id == $product_variations[$key + 1]->unit_id) {
                            if ($product_variations[$key + 1]->basic_unit_id == $unit->unit_id) {
                                $qtyByUnit = $stock_variation->equal * $product_variations[$key + 1]->equal;
                                $qty_difference = $new_quantity / $qtyByUnit;
                                break;
                            } else {
                                $qtyByUnit = $product_variation->equal;
                            }
                        } else {
                            if ($product_variation->basic_unit_id == $product_variations[$key + 1]->unit_id) {
                                $qtyByUnit *= $product_variation->equal;
                            }
                            if ($product_variation->basic_unit_id == $variation_id || $product_variation->unit_id == $variation_id) {
                                $qty_difference = $new_quantity / $qtyByUnit;
                                break;
                            }
                        }
                    } else {
                        if ($product_variation->basic_unit_id == $variation_id) {
                            $qtyByUnit *= $product_variation->equal;
                            $qty_difference = $new_quantity / $qtyByUnit;
                            break;
                        }
                    }
                }
            }
        } else {
            $qty_difference = $new_quantity;
        }

        $product = Product::find($product_id);
        if ($qty_difference != 0) {
            $add_stock_lines = AddStockLine::leftjoin('stock_transactions', 'add_stock_lines.stock_transaction_id', 'stock_transactions.id')
                ->where('stock_transactions.store_id', $store_id)
                ->where('product_id', $product_id)
                ->select('add_stock_lines.id', DB::raw('SUM(quantity - quantity_sold) as remaining_qty'))
                ->having('remaining_qty', '>', 0)
                ->groupBy('add_stock_lines.id')
                ->get();
            foreach ($add_stock_lines as $line) {
                if ($qty_difference == 0) {
                    return true;
                }

                if ($line->remaining_qty >= $qty_difference) {
                    $line->increment('quantity_sold', $qty_difference);
                    $qty_difference = 0;
                }
                if ($line->remaining_qty < $qty_difference) {
                    $line->increment('quantity_sold', $line->remaining_qty);
                    $qty_difference = $qty_difference - $line->remaining_qty;
                }
            }
        }
        //        dd($add_stock_lines);

        return true;
    }

    public function updateTransactionPaymentStatus($transaction_id)
    {
        $transaction_payments = PaymentTransactionSellLine::where('transaction_id', $transaction_id)->get();

        $total_paid = $transaction_payments->sum('amount');
        $dollar_total_paid = $transaction_payments->sum('dollar_amount');

        $transaction = TransactionSellLine::find($transaction_id);
        //        $returned_transaction = TransactionSellLine::where('return_parent_id',$transaction_id)->sum('final_total');
        //        if($returned_transaction){
        //            $final_amount = $transaction->final_total - $transaction->used_deposit_balance -  $returned_transaction;
        //        }else{
        //  final_amount : 'النهائي بالدينار'
        $final_amount = $transaction->final_total;
        //  dollar_final_amount : 'النهائي بالدولار'
        $dollar_final_amount = $transaction->dollar_final_total;
        // dinar_remaining : الباقي دينار
        $dinar_remaining = ($total_paid - $final_amount);
        //  dollar_remaining : 'الباقي بالدولار'
        $dollar_remaining = ($dollar_total_paid - $dollar_final_amount);
        //        }

        $payment_status = 'pending';
        if ($final_amount <= $total_paid && $dollar_final_amount <= $dollar_total_paid) {
            $payment_status = 'paid';
        } elseif (($total_paid > 0 && $final_amount > $total_paid) || ($dollar_total_paid > 0 && $dollar_final_amount > $dollar_total_paid)) {
            $payment_status = 'partial';
        }
        $transaction->payment_status = $payment_status;
        $transaction->save();

        return $transaction;
    }

    public function addPayments($transaction, $payment, $type = 'credit', $user_id = null, $transaction_payment_id = null)
    {
        if (empty($user_id)) {
            $user_id = auth()->user()->id;
        }
        $register =  $this->getCurrentCashRegisterOrCreate($user_id);

        if ($transaction->type == 'returns') {
            $cr_transaction = CashRegisterTransaction::where('transaction_id', $transaction->id)->first();
            if (!empty($cr_transaction)) {
                $cr_transaction->update([
                    'amount' => $this->num_uf($payment['amount']),
                    'pay_method' => $payment['method'],
                    'type' => $type,
                    'transaction_type' => $transaction->type,
                    'transaction_id' => $transaction->id,
                    'transaction_payment_id' => $transaction_payment_id
                ]);

                return true;
            } else {
                CashRegisterTransaction::create([
                    'cash_register_id' => $register->id,
                    'amount' => $this->num_uf($payment['amount']),
                    'pay_method' =>  $payment['method'],
                    'type' => $type,
                    'transaction_type' => $transaction->type,
                    'transaction_id' => $transaction->id,
                    'transaction_payment_id' => $transaction_payment_id
                ]);
                return true;
            }
        } else {
            $payments_formatted[] = new CashRegisterTransaction([
                'amount' => $this->num_uf($payment['amount']),
                'pay_method' => $payment['method'],
                'type' => $type,
                'transaction_type' => $transaction->type,
                'transaction_id' => $transaction->id,
                'transaction_payment_id' => $transaction_payment_id
            ]);
        }
        //add to cash register pos return amount as sell amount
        if (!empty($pos_return_transactions)) {
            $payments_formatted[0]['amount'] = $payments_formatted[0]['amount'] + !empty($pos_return_transactions) ? number_format($pos_return_transactions->final_total, num_of_digital_numbers()) : 0;
        }

        if (!empty($payments_formatted) && !empty($register)) {
            $register->cash_register_transactions()->saveMany($payments_formatted);
        }

        return true;
    }

    public function getCurrentCashRegisterOrCreate($user_id)
    {
        $register =  CashRegister::where('user_id', $user_id)
            ->where('status', 'open')
            ->first();

        if (empty($register)) {
            $store_pos = StorePos::where('user_id', $user_id)->first();
            $register = CashRegister::create([
                'user_id' => $user_id,
                'status' => 'open',
                'store_id' => !empty($store_pos) ? $store_pos->store_id : null,
                'store_pos_id' => !empty($store_pos) ? $store_pos->id : null
            ]);
        }

        return $register;
    }

    public function decreaseProductQuantity($product_id, $store_id, $new_quantity, $variation_id = null)
    {
        $product_store = ProductStore::where('product_id', $product_id)
            ->where('store_id', $store_id)
            ->first();
        $product_variations = Variation::where('product_id', $product_id)->get();
        $unit = Variation::where('id', $variation_id)->first();
        $qty_difference = 0;
        $qtyByUnit = 1;
        if (!empty($product_store) && !empty($product_store->variation_id)) {
            $store_variation = Variation::find($product_store->variation_id);
            if ($store_variation->unit_id == $unit->unit_id) {
                $qty_difference = $new_quantity;
            } elseif ($store_variation->basic_unit_id == $unit->unit_id) {
                $qtyByUnit = 1 / $store_variation->equal;
                $qty_difference = $qtyByUnit * $new_quantity;
            } else {
                foreach ($product_variations as $key => $product_variation) {
                    if (!empty($product_variations[$key + 1])) {
                        if ($store_variation->basic_unit_id == $product_variations[$key + 1]->unit_id) {
                            if ($product_variations[$key + 1]->basic_unit_id == $unit->unit_id) {
                                $qtyByUnit = $store_variation->equal * $product_variations[$key + 1]->equal;
                                $qty_difference = $new_quantity / $qtyByUnit;
                                break;
                            } else {
                                $qtyByUnit = $product_variation->equal;
                            }
                        } else {
                            if ($product_variation->basic_unit_id == $product_variations[$key + 1]->unit_id) {
                                $qtyByUnit *= $product_variation->equal;
                            }
                            if ($product_variation->basic_unit_id == $variation_id || $product_variation->unit_id == $variation_id) {
                                $qty_difference = $new_quantity / $qtyByUnit;
                                break;
                            }
                        }
                    } else {
                        if ($product_variation->basic_unit_id == $variation_id) {
                            $qtyByUnit *= $product_variation->equal;
                            $qty_difference = $new_quantity / $qtyByUnit;
                            break;
                        }
                    }
                }
            }
        } else {
            $qty_difference = $new_quantity;
        }
        //        dd($qty_difference);
        if ($qty_difference != 0) {
            if (empty($product_store)) {
                $product_store = new ProductStore();
                $product_store->product_id = $product_id;
                $product_store->store_id = $store_id;
                $product_store->quantity_available = 0;
            }
            if (empty($product_store->variation_id) && !empty($variation_id)) {
                $product_store->variation_id = $variation_id;
            }
            $product_store->decrement('quantity_available', $qty_difference);
        }

        //send notification if balance_return_request is reached
        // if($details->quantity_available <= $product->balance_return_request){
        //     $options = array(
        //         'cluster' =>  env('PUSHER_APP_CLUSTER'),
        //         'useTLS' => true
        //     );


        //     $pusher = new Pusher(
        //         env('PUSHER_APP_KEY'),
        //         env('PUSHER_APP_SECRET'),
        //         env('PUSHER_APP_ID'),
        //         $options
        //     );

        //     $data=BalanceRequestNotification::create([
        //         'product_id'=>$product_id,
        //         'variation_id'=>$variation_id,
        //         'isread'=>0,
        //         'type'=>'purchase_order',
        //         'alert_quantity'=>$product->balance_return_request,
        //         'qty_available'=>$details->quantity_available
        //     ]);
        //     $pusher->trigger('order-channel', 'new-order', $data);
        // }
        return true;
    }

    public function getInvoicePrint($transaction, $payment_types, $transaction_invoice_lang = null)
    {
        $print_gift_invoice = request()->print_gift_invoice;

        if (!empty($transaction_invoice_lang)) {
            $invoice_lang = $transaction_invoice_lang;
        } else {
            $invoice_lang = System::getProperty('invoice_lang');
            if (empty($invoice_lang)) {
                $invoice_lang = request()->session()->get('language');
            }
        }
        //        $total_due= $this->getCustomerBalance($transaction->customer_id)['balance'];

        if ($invoice_lang == 'ar_and_en') {
            $html_content = view('sale_pos.partials.invoice_ar_and_end')->with(compact(
                'transaction',
                'payment_types',
                'print_gift_invoice',
                //                'total_due',
            ))->render();
        } else {
            $html_content = view('invoices.partials.invoice')->with(compact(
                'transaction',
                'payment_types',
                'invoice_lang',
                //                'total_due',
                'print_gift_invoice'
            ))->render();
        }

        if ($transaction->is_direct_sale == 1) {
            $sale = $transaction;
            $payment_type_array = $payment_types;
            $html_content = view('sale_pos.partials.commercial_invoice')->with(compact(
                'sale',
                'payment_type_array',
                'invoice_lang',
                //                'total_due',
                'print_gift_invoice',
            ))->render();
        }

        if ($transaction->is_quotation == 1 && $transaction->status == 'draft') {
            $sale = $transaction;
            $payment_type_array = $payment_types;
            $html_content = view('sale_pos.partials.commercial_invoice')->with(compact(
                'sale',
                'payment_type_array',
                'invoice_lang'
            ))->render();
        }

        return $html_content;
    }

    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = ',';
        $decimal_separator  = '.';

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }

    public function getPaymentTypeArrayForPos()
    {
        return [
            'cash' => __('lang.cash'),
            //            'cheque' => __('lang.cheque'),
            //            'deposit' => __('lang.use_the_balance'),
            //            'paypal' => __('lang.paypal'),
        ];
    }
    public function changeUnit($key)
    {
        //        dd($this->items[$key]['unit_id']);
        if (!empty($this->items[$key]['unit_id'])) {
            $variation_id = $this->items[$key]['unit_id'];
            // $product=Product::find($this->items[$key]['product']['id']);
            $stock_line = AddStockLine::where('variation_id', $variation_id)->first();
            if (!empty($this->items[$key]['customer_type_id'])) {
                $variation_price = VariationPrice::where('variation_id', $variation_id)->where('customer_type_id', $this->items[$key]['customer_type_id'])->first();
            } else {
                $variation_price = VariationPrice::where('variation_id', $variation_id)->first();
            }
            $stock_variation = VariationStockline::where('stock_line_id', $stock_line->id)->where('variation_price_id', $variation_price->id)->first();
            if (empty($stock_variation->sell_price) && empty($stock_variation->dollar_sell_price)) {
                //            $stock_line = AddStockLine::find($this->items[$key]['current_stock']['id']);
                $stock_variation1 = Variation::find($this->items[$key]['current_stock']['variation_id']);
                $product_variations = Variation::where('product_id', $this->items[$key]['product']['id'])->get();
                $unit = Variation::where('id', $variation_id)->first();
                $qtyByUnit = $this->getNewSellPrice($stock_variation1, $product_variations, $unit, $variation_id);
                $this->items[$key]['price'] = number_format($this->items[$key]['current_stock']['sell_price'] * $qtyByUnit ?? 0, num_of_digital_numbers());
                $this->items[$key]['dollar_price'] = number_format($this->items[$key]['current_stock']['dollar_sell_price'] * $qtyByUnit ?? 0, num_of_digital_numbers());
            } else {
                $this->items[$key]['price'] = number_format($stock_variation->sell_price ?? 0, num_of_digital_numbers());
                $this->items[$key]['dollar_price'] = number_format($stock_variation->dollar_sell_price ?? 0, num_of_digital_numbers());
                $this->items[$key]['current_stock'] = $stock_line;
                $this->items[$key]['discount_categories'] = $stock_line->prices()->get();
            }
            $this->items[$key]['sub_total'] = number_format($this->num_uf($this->items[$key]['price']) * $this->items[$key]['quantity'], num_of_digital_numbers());
            $this->items[$key]['dollar_sub_total'] = number_format($this->num_uf($this->items[$key]['dollar_price']) * $this->num_uf($this->items[$key]['quantity']), num_of_digital_numbers());
            $this->items[$key]['discount'] = 0;
            $this->items[$key]['extra_quantity'] = 0;
            $qty = $this->items[$key]['quantity_available'];
            $variations = Variation::where('product_id', $this->items[$key]['product']['id'])->get();
            $product_store = ProductStore::where('product_id', $this->items[$key]['product']['id'])->where('store_id', $this->store_id)->first();
            $amount = 1;
            $var_id = Variation::find($variation_id)->unit_id;
            if (!empty($product_store->variations)) {
                if ($var_id == $product_store->variations->unit_id) {
                    $this->items[$key]['quantity_available'] = $product_store->quantity_available;
                } else if ($var_id == $product_store->variations->basic_unit_id) {
                    $this->items[$key]['quantity_available'] = $product_store->quantity_available * $product_store->variations->equal;
                } else {
                    $amount = 1;
                    foreach ($variations as $var) {
                        if ($var->id !== $product_store->variation_id) {
                            if (isset($var->equal)) {
                                $amount *= $var->equal;
                            }
                            if ($var->unit_id == $var_id) {
                                break;
                            }
                        }
                    }
                    $this->items[$key]['quantity_available'] = number_format($product_store->quantity_available / $amount, num_of_digital_numbers());
                }
                // else{
                //     foreach($variations as $variation){
                //         if($variation->unit_id == $var_id){
                //             $amount *=$variation->equal;
                //             $basic_unit=$variation->basic_unit_id;
                //             foreach($variations as $var){
                //                 if($basic_unit == $var->unit_id){
                //                     $amount *=$var->equal;
                //                     $basic_unit=$var->basic_unit_id;
                //                     if($product_store->variations->unit_id != $var->basic_unit_id){
                //                         break;
                //                     }
                //                 }
                //             }
                //             $this->items[$key]['quantity_available']= $product_store->quantity_available / $amount;
                //             break;
                //         }
                //     }
                // }
            } else {
                $this->items[$key]['quantity_available'] = $qty;
            }
        }
    }

    public function getNewSellPrice($stock_variation, $product_variations, $unit, $variation_id)
    {
        $qtyByUnit = 1;
        if ($stock_variation->basic_unit_id == $unit->unit_id) {
            $qtyByUnit = 1 / $stock_variation->equal;
        } elseif ($stock_variation->basic_unit_id == $unit->basic_unit_id) {
            $qtyByUnit = $unit->equal / ($stock_variation->equal == 0 ? 1 : $stock_variation->equal);
        } else {
            foreach ($product_variations as $key => $product_variation) {
                if (!empty($product_variations[$key + 1])) {
                    if ($stock_variation->basic_unit_id == $product_variations[$key + 1]->unit_id) {
                        if ($product_variations[$key + 1]->basic_unit_id == $unit->unit_id) {
                            $qtyByUnit = $stock_variation->equal * $product_variations[$key + 1]->equal;
                            break;
                        } else {
                            $qtyByUnit = $product_variation->equal;
                        }
                    } else {
                        if ($product_variation->basic_unit_id == $product_variations[$key + 1]->unit_id) {
                            $qtyByUnit *= $product_variation->equal;
                        }
                    }
                } else {
                    if ($product_variation->basic_unit_id == $variation_id) {
                        $qtyByUnit *= $product_variation->equal;
                        break;
                    }
                }
            }
        }
        return $qtyByUnit;
    }

    // +++++++++++++++ create_purchase_order() method : When click on "امر شراء" button +++++++++++++++
    public function create_purchase_order($id)
    {
        try {
            $stock = AddStockLine::where('product_id', $id)->latest()->first();
            $branch_id = Employee::select('branch_id')->where('id', auth()->user()->id)->latest()->first();
            if (!$stock) {
                $transaction_data =
                    [
                        'employee_id' => auth()->user()->id,
                        'product_id' => $id,
                        'store_id' => null,
                        'supplier_id' => null,
                        'branch_id' => $branch_id->branch_id,
                        'status' => 'pending',
                        'order_date' => now(),
                        'purchase_price' => null,
                        'dollar_purchase_price' => null,
                        'required_quantity' => null,
                        'created_by' => Auth::user()->id
                    ];
            } else {
                $stockTransactionId = $stock->stock_transaction_id;
                $supplier_id = StockTransaction::select('supplier_id')->where('id', $stockTransactionId)->latest()->first();
                $dinar_purchase_price = $stock->purchase_price;
                $dollar_purchase_price = $stock->dollar_purchase_price;
                $transaction_data =
                    [
                        'employee_id' => auth()->user()->id,
                        'product_id' => $id,
                        'store_id' => $this->store_id,
                        'supplier_id' => $supplier_id->supplier_id,
                        'branch_id' => $branch_id->branch_id,
                        'status' => 'pending',
                        'order_date' => now(),
                        'purchase_price' => $dinar_purchase_price,
                        'dollar_purchase_price' => $dollar_purchase_price,
                        'required_quantity' => null,
                        'created_by' => Auth::user()->id
                    ];
            }

            DB::beginTransaction();
            $required_product = RequiredProduct::create($transaction_data);
            DB::commit();

            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
            dd($e);
        }
        return $output;
    }
    public function checkRepresentativeUser()
    {
        $user_id = Auth::user()->id;
        $job_type = JobType::where('title', 'Representative')->first();
        $employee = Employee::where('user_id', $user_id)->where('job_type_id', $job_type->id)->first();
        if (!empty($employee)) {
            return true;
        } else {
            return false;
        }
    }
    public function submitPendingOrders($transaction_id)
    {
        try {
            $transaction = TransactionSellLine::find($transaction_id);
            $transaction->status = "final";
            $transaction->save();

            if (!empty($transaction->dollar_amount) || !empty($transaction->amount)) {
                $payment_data = [
                    'transaction_id' => $transaction_id,
                    'amount' => $transaction->amount,
                    'dollar_amount' => $transaction->dollar_amount,
                    // "dollar_remaining" inputField
                    'dollar_remaining' => $transaction->dollar_remaining,
                    // "dinar_remaining" inputField
                    'dinar_remaining' => $transaction->dinar_remaining,
                    'method' => 'cash',
                    'paid_on' => Carbon::now(),
                    'payment_note' => $transaction->payment_note,
                    'exchange_rate' => System::getProperty('dollar_exchange'),
                ];
                if ($transaction->dollar_amount > 0 || $transaction->amount > 0) {
                    $transaction_payment = null;
                    if (!empty($transaction->dollar_amount) || !empty($transaction->amount)) {
                        $payment_data['created_by'] = Auth::user()->id;
                        $payment_data['payment_for'] =  $transaction->customer_id;
                        $transaction_payment = PaymentTransactionSellLine::create($payment_data);
                    }
                }
            }
            $this->items = [];
            $this->computeForAll();
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'تم إضافة الفاتورة بنجاح']);
            // return $this->redirect('/invoices/create');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'lang.something_went_wrongs',]);
            dd($e);
        }
    }
    public function changeDinarPrice($key)
    {
        try {
            $stock_line = AddStockLine::find($this->items[$key]['current_stock']['id']);
            if (!empty($stock_line)) {
                $variation_price = VariationPrice::where('variation_id', $this->items[$key]['unit_id'])->where('customer_type_id', $this->items[$key]['customer_type_id'])->first();
                $variation_stock = VariationStockline::where('stock_line_id', $this->items[$key]['current_stock']['id'])->where('variation_price_id', $variation_price->id)->first();
                if ($variation_stock->dollar_sell_price > 0 && ($variation_stock->sell_price == 0 || $variation_stock->sell_price == null)) {
                    $variation_stock->dollar_sell_price = $this->num_uf($this->items[$key]['price']) / $this->num_uf($this->items[$key]['exchange_rate']);
                } else {
                    $variation_stock->sell_price = $this->num_uf($this->items[$key]['price']);
                }
                // if (isset($variation_stock->dollar_sell_price) && $variation_stock->dollar_sell_price !== 0) {
                //     $variation_stock->dollar_sell_price = $this->num_uf($this->items[$key]['price']) / $this->num_uf($this->items[$key]['exchange_rate']);
                //     $this->items[$key]['dollar_price'] = number_format($this->num_uf($this->items[$key]['price']) / $this->num_uf($this->items[$key]['exchange_rate']), num_of_digital_numbers());
                // }
                $variation_stock->save();
                $this->subtotal($key);
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'تم بنجاح']);
            } else {
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'warning', 'message' => 'lang.choose_unit_please',]);
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => __('lang.something_went_wrongs'),]);
            dd($e);
        }
    }
    public function changeDollarPrice($key)
    {
        try {
            $stock_line = AddStockLine::find($this->items[$key]['current_stock']['id']);
            if (!empty($stock_line)) {
                $variation_price = VariationPrice::where('variation_id', $this->items[$key]['unit_id'])->where('customer_type_id', $this->items[$key]['customer_type_id'])->first();
                dd($this->items[$key]['current_stock']['id']);
                $variation_stock = VariationStockline::where('stock_line_id', $stock_line->id)->where('variation_price_id', $variation_price->id)->first();
                if (isset($variation_stock->dollar_sell_price) && $variation_stock->dollar_sell_price == 0 && $variation_stock->sell_price > 0) {
                    $variation_stock->sell_price = $this->num_uf($this->items[$key]['dollar_price']) * $this->num_uf($this->items[$key]['exchange_rate']);
                } else {
                    $variation_stock->dollar_sell_price = !empty($this->items[$key]['dollar_price']) ? $this->num_uf($this->items[$key]['dollar_price']) : null;
                }
                $variation_stock->save();
                $this->subtotal($key);
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'تم بنجاح']);
            } else {
                $this->dispatchBrowserEvent('swal:modal', ['type' => 'warning', 'message' => __('lang.choose_unit_please'),]);
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'lang.something_went_wrongs',]);
            dd($e);
        }
    }
    public function changePrices($key)
    {
        try {
            $this->subtotal($key);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'lang.something_went_wrongs',]);
            dd($e);
        }
    }
    public function getPreviousTransaction(){
        $latest_transaction = TransactionSellLine::where('id', '<', $this->transaction_sell_line->id)
        ->latest()
        ->first();
            if(!empty($latest_transaction)){
            return redirect('/invoices/edit/'.$latest_transaction?->id);
        }
    }
    public function getNextTransaction(){
        $latest_transaction = TransactionSellLine::where('id', '>', $this->transaction_sell_line->id)
        ->latest()
        ->first();
        if(!empty($latest_transaction)){
        return redirect('/invoices/edit/'.$latest_transaction?->id);
        }else{
            return redirect('/invoices/create');
        }
    }
}
