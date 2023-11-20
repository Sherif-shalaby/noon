<?php

namespace App\Http\Livewire\Invoices;
// use Pusher\Pusher;
use App\Models\AddStockLine;
use App\Models\BalanceRequestNotification;
use App\Models\Brand;
use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\JobType;
use App\Models\MoneySafeTransaction;
use App\Models\PaymentTransactionSellLine;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductStore;
use App\Models\PurchaseOrderLine;
use App\Models\PurchaseOrderTransaction;
use App\Models\RequiredProduct;
use App\Models\SellLine;
use App\Models\StockTransaction;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\System;
use App\Models\Transaction;
use App\Models\TransactionPayment;
use App\Models\TransactionSellLine;
use App\Models\Variation;
use App\Utils\pos;
use App\Utils\Util;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Create extends Component
{
    public $products = [], $variations = [], $department_id = null, $items = [], $price, $total, $client_phone,
        $client_id, $client, $cash = 0, $rest, $invoice, $invoice_id, $date, $payment_status, $data = [], $payments = [],
        $invoice_lang, $transaction_currency, $store_id, $store_pos_id, $showColumn = false, $anotherPayment = false, $sale_note,
        $payment_note, $staff_note, $payment_types, $discount = 0.00, $total_dollar, $add_customer = [], $customers = [], $discount_dollar,
        $store_pos, $allproducts = [], $brand_id = 0, $brands = [], $deliveryman_id = null, $delivery_cost, $dollar_remaining = 0,
        $dinar_remaining = 0, $customer_data, $searchProduct, $stores, $reprsenative_sell_car = false, $final_total, $dollar_final_total,
        $dollar_amount = 0, $amount = 0, $redirectToHome = false, $status = 'final', $draft_transactions, $show_modal = false,
        $search_by_product_symbol, $highest_price, $lowest_price, $from_a_to_z, $from_z_to_a, $nearest_expiry_filter, $longest_expiry_filter,
        $dollar_highest_price, $dollar_lowest_price,$due_date;

    protected $rules = [
        'items' => 'array|min:1',
        'client_id' => 'required',
        'store_id' => 'required',
        'store_pos_id' => 'required',
        'payment_status' => 'required',
        'invoice_lang' => 'required',
    ];


    protected $listeners = ['listenerReferenceHere', 'create_purchase_order', 'changeDinarPrice', 'changeDollarPrice','changePrices'];

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
        if (isset($data['var1']) && $data['var1'] == "department_id") {
            $this->updatedDepartmentId($data['var2'], 'department_id');
        }
        if (isset($data['var1']) && $data['var1'] == "brand_id") {
            $this->updatedDepartmentId($data['var2'], 'brand_id');
        }
    }
    public function mount(Util $commonUtil)
    {
        $this->payment_types = $commonUtil->getPaymentTypeArrayForPos();
        $this->department_id = null;
        $this->invoice_lang = !empty(System::getProperty('invoice_lang')) ? System::getProperty('invoice_lang') : 'en';
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
        if (!empty($store_pos)) {
            $this->stores = !empty($store_pos->user) ? $store_pos->user->employee->stores()->pluck('name', 'id')->toArray() : [];
            $branch = $store_pos->user->employee->branch;
            $this->store_id = array_key_first($this->stores);
            $this->changeAllProducts();
        }
        if (!empty($branch)) {
            if ($branch->type == 'sell_car') {
                $this->reprsenative_sell_car = true;
            }
        }
        $this->client_id = 1;
        $this->getCustomerData($this->client_id);
        $this->payment_status = 'paid';
        $this->dispatchBrowserEvent('initialize-select2');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
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

    public function render()
    {
        $departments = Category::get();
        $this->brands = Brand::orderby('created_at', 'desc')->pluck('name', 'id');
        $this->customers = Customer::orderBy('created_by', 'asc')->get();
        $languages = System::getLanguageDropdown();
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $customer_types = CustomerType::latest()->pluck('name', 'id');
        $delivery_job_type = JobType::where('title', 'Deliveryman')->first();
        $deliverymen = Employee::where('job_type_id', $delivery_job_type->id)->pluck('employee_name', 'id');
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
        return view('livewire.invoices.create', compact(
            'departments',
            'languages',
            'selected_currencies',
            'customer_types',
            'search_result',
            'deliverymen'
        ));
    }

    public function changeAllProducts()
    {
        $this->check_items_store();
        $products_store = ProductStore::where('store_id', $this->store_id)->pluck('product_id');
        $this->allproducts = Product::whereIn('id', $products_store)->get();
    }

    // ++++++++++++ submit() : save "cachier data" in "TransactionSellLine" Table ++++++++++++
    public function submit()
    {
        $this->validate();
        try {

            // Add Transaction Sell Line
            $transaction_data = [
                'store_id' => $this->store_id,
                'customer_id' => $this->client_id,
                'employee_id' => Employee::where('user_id', auth()->user()->id)->first()->id,
                'store_pos_id' => $this->store_pos_id,
                'exchange_rate' => System::getProperty('dollar_exchange') ?? 0,
                'type' => 'sell',
                //                'transaction_currency' => $this->transaction_currency,
                'final_total' => $this->num_uf(round_250($this->final_total)),
                'grand_total' => $this->num_uf(round_250($this->total)),
                // 'dollar_final_total' :  'النهائي بالدولار'
                'dollar_final_total' => $this->num_uf($this->dollar_final_total),
                'dollar_grand_total' => $this->num_uf($this->total_dollar),
                'transaction_date' => Carbon::now(),
                // "dollar_remaining" inputField : الباقي بالدولار
                'dollar_remaining' => $this->num_uf($this->dollar_remaining),
                // "dinar_remaining" inputField : الباقي بالدينار
                'dinar_remaining' => $this->num_uf($this->dinar_remaining),
                'invoice_no' => $this->generateInvoivceNumber(),
                'status' => $this->status,
                'payment_status' => $this->payment_status,
                'sale_note' => $this->sale_note,
                'staff_note' => $this->staff_note,
                'discount_value' => $this->num_uf($this->discount),
                //            'discount_amount' => $this->commonUtil->num_uf($request->discount_amount),
                //            'current_deposit_balance' => $this->commonUtil->num_uf($request->current_deposit_balance),
                //            'used_deposit_balance' => $this->commonUtil->num_uf($request->used_deposit_balance),
                //            'remaining_deposit_balance' => $this->commonUtil->num_uf($request->remaining_deposit_balance),
                //            'add_to_deposit' => $this->commonUtil->num_uf($request->add_to_deposit),
                //            'tax_id' => !empty($request->tax_id_hidden) ? $request->tax_id_hidden : null,
                //            'tax_method' => $request->tax_method ?? null,
                //            'total_tax' => $this->commonUtil->num_uf($request->total_tax),
                //            'total_item_tax' => $this->commonUtil->num_uf($request->total_item_tax),
                //            'terms_and_condition_id' => !empty($request->terms_and_condition_id) ? $request->terms_and_condition_id : null,
                'created_by' => Auth::user()->id,
            ];
            DB::beginTransaction();
            $transaction = TransactionSellLine::create($transaction_data);
            if ($this->checkRepresentativeUser()) {
                $transaction->deliveryman_id = isset($this->deliveryman_id) ? $this->deliveryman_id : null;
                $transaction->delivery_cost = isset($this->delivery_cost) ? $this->num_uf($this->delivery_cost) : 0;
                $transaction->save();
            }
            // Add Sell line
            foreach ($this->items as $key => $item) {
                if ($item['discount_type'] == 0) {
                    $item['discount_type'] = null;
                }
                if (!empty($item['unit_id'])) {
                    $this->rules = [
                        'items.' . $key . '.unit_id' => 'required',
                    ];
                    $this->validate();
                }
                $old_quantity = 0;
                $sell_line = new SellLine();
                $sell_line->transaction_id = $transaction->id;
                $sell_line->product_id = $item['product']['id'];
                $sell_line->variation_id = !empty($item['unit_id']) ? $item['unit_id'] :  null;
                $sell_line->product_discount_type = !empty($item['discount_type']) ? $item['discount_type'] : null;
                $sell_line->product_discount_amount = !empty($item['discount_price']) ? $this->num_uf($item['discount_price'], 2) : 0;
                $sell_line->product_discount_category = !empty($item['discount']) ? $item['discount'] : 0;
                $sell_line->quantity = $item['quantity'];
                $sell_line->extra_quantity = (float) $item['extra_quantity'];
                $sell_line->sell_price = !empty($item['current_stock']['sell_price']) ? $item['current_stock']['sell_price'] : null;
                $sell_line->dollar_sell_price = !empty($item['current_stock']['dollar_sell_price']) ? $item['current_stock']['dollar_sell_price'] : null;
                $sell_line->purchase_price = !empty($item['current_stock']['purchase_price']) ? $item['current_stock']['purchase_price'] : null;
                $sell_line->dollar_purchase_price = !empty($item['current_stock']['dollar_purchase_price']) ? $item['current_stock']['dollar_purchase_price'] : null;
                $sell_line->exchange_rate = $item['exchange_rate'];
                $sell_line->sub_total = $this->num_uf($item['sub_total']);
                $sell_line->dollar_sub_total = $this->num_uf($item['dollar_sub_total']);
                $sell_line->stock_line_id  = !empty($item['current_stock']['id']) ? $item['current_stock']['id'] : null;
                //                $sell_line->tax_id = !empty($item['tax_id']) ? $item['tax_id'] : null;
                //                $sell_line->tax_method = !empty($item['tax_method']) ? $item['tax_method'] : null;
                //                $sell_line->tax_rate = !empty($item['tax_rate']) ? $this->num_uf($item['tax_rate']) : 0;
                //                $sell_line->item_tax = !empty($item['item_tax']) ? $this->num_uf($item['item_tax']) : 0;
                $sell_line->save();
                $keep_sell_lines[] = $sell_line->id;

                $stock_id = $item['current_stock']['id'];

                // Update Sold Quantity in stock line
                $this->updateSoldQuantityInAddStockLine($sell_line->product_id, $transaction->store_id, (float)$item['quantity'], $stock_id, $item['unit_id']);
                if ($transaction->status == 'final') {
                    $this->decreaseProductQuantity($sell_line->product_id, $transaction->store_id, (float) $sell_line->quantity, $item['unit_id']);
                }
            }

            // Add Payment Method
            if ($transaction->status != 'draft') {

                if ($this->payment_status != 'pending') {
                    $this->updateTransactionPaymentStatus($transaction->id);
                } else {
//                    $transaction_payment = PaymentTransactionSellLine::where('transaction_id', $transaction->id)->first();

                    $total_paid = 0;
                    $dollar_total_paid = 0;

                    $transaction = TransactionSellLine::find($transaction->id);

                    //  final_amount : 'النهائي بالدينار'
                    $final_amount = $transaction->final_total;
                    //  dollar_final_amount : 'النهائي بالدولار'
                    $dollar_final_amount = $transaction->dollar_final_total;
                    // dinar_remaining : الباقي دينار
                    $transaction->dinar_remaining =  $final_amount;
                    //  dollar_remaining : 'الباقي بالدولار'
                    $transaction->dollar_remaining =  $dollar_final_amount;
//                    $transaction_payment->amount = $total_paid;
//                    $transaction_payment->dollar_amount = $dollar_total_paid;
                    $this->amount = $total_paid;
                    $this->dollar_amount = $dollar_total_paid;
//                    $transaction_payment->save();
                    $transaction->save();
                }
                if ($this->dollar_amount > 0  || $this->amount > 0) {

                    $payment_data = [
                        'transaction_id' => $transaction->id,
                        'amount' => $this->amount,
                        'dollar_amount' => $this->dollar_amount,
                        // "dollar_remaining" inputField
                        'dollar_remaining' => $this->dollar_remaining,
                        // "dinar_remaining" inputField
                        'dinar_remaining' => $this->dinar_remaining,
                        'method' => 'cash',
                        'paid_on' => Carbon::now(),
                        'payment_note' => $this->payment_note,
                        'exchange_rate' => System::getProperty('dollar_exchange'),
                        'due_date' => $this->due_date ?? null,
                    ];
                    if ($this->dollar_amount > 0 || $this->amount > 0) {
                        $transaction_payment = null;
                        if (!empty($this->dollar_amount) || !empty($this->amount)) {
                            $payment_data['created_by'] = Auth::user()->id;
                            $payment_data['payment_for'] =  $transaction->customer_id;
                            $transaction_payment = PaymentTransactionSellLine::create($payment_data);
                        }
                    }

                    $this->addPayments($transaction, $payment_data, 'credit', null, $transaction_payment->id);
                }

                // update customer balance
                $customer = Customer::find($transaction->customer_id);
                $customer->dollar_balance += $this->dollar_amount - $this->total_dollar;
                $customer->balance += $this->amount - $this->total;
                $customer->save();

                $payment_types = $this->getPaymentTypeArrayForPos();
                $html_content = $this->getInvoicePrint($transaction, $payment_types, $this->invoice_lang);

                // Emit a browser event to trigger the invoice printing
                $this->emit('printInvoice', $html_content);
            }

            DB::commit();
            // $this->items = [];
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'تم إضافة الفاتورة بنجاح']);
            return $this->redirect('/invoices/create');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'lang.something_went_wrongs',]);
            dd($e);
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

    public function updatedDepartmentId($value, $name)
    {
        $this->allproducts = Product::when($name == 'department_id', function ($query) {
            $query->where(function ($query) {
                $query->where('category_id', $this->department_id)
                    ->orWhere('subcategory_id1', $this->department_id)
                    ->orWhere('subcategory_id2', $this->department_id)
                    ->orWhere('subcategory_id3', $this->department_id);
            });
        })->when($name == 'brand_id', function ($query) use ($value) {
            $query->where('brand_id', $this->brand_id);
        })->when($name == 'highest_price' && $this->highest_price == "1", function ($query) {
            $query->withCount(['stock_lines as max_sell_price' => function ($subquery) {
                $subquery->select(DB::raw('max(sell_price)'));
            }])
                ->orderBy('max_sell_price', 'desc');
        })->when($name == 'lowest_price' && $this->lowest_price == "1", function ($query) {
            $query->withCount(['stock_lines as min_sell_price' => function ($subquery) {
                $subquery->select(DB::raw('min(sell_price)'));
            }])
                ->orderBy('min_sell_price', 'asc');
        })->when($name == 'dollar_highest_price' && $this->dollar_highest_price == "1", function ($query) {
            $query->withCount(['stock_lines as max_dollar_sell_price' => function ($subquery) {
                $subquery->select(DB::raw('max(dollar_sell_price)'));
            }])
                ->orderBy('max_dollar_sell_price', 'desc');
        })->when($name == 'dollar_lowest_price' && $this->lowest_price == "1", function ($query) {
            $query->withCount(['stock_lines as min_dollar_sell_price' => function ($subquery) {
                $subquery->select(DB::raw('min(dollar_sell_price)'));
            }])
                ->orderBy('min_dollar_sell_price', 'asc');
        })
            ->when($name == 'from_a_to_z', function ($query) {
                $query->orderBy('products.name', 'desc');
            })->when($name == 'from_z_to_a', function ($query) {
                $query->orderBy('products.name', 'desc');
            })->when($name == 'nearest_expiry_filter' && $this->nearest_expiry_filter == "1", function ($query) {
                $query->withCount(['stock_lines as expiry_date' => function ($subquery) {
                    $subquery->where(function ($q) {
                        $q->whereDate('expiry_date', '>', Carbon::now());
                    });
                }])->orderBy('expiry_date', 'asc');
            })
            ->when($name == 'longest_expiry_filter' && $this->longest_expiry_filter == "1", function ($query) {
                $query->withCount(['stock_lines as expiry_date' => function ($subquery) {
                    $subquery->where(function ($q) {
                        $q->whereDate('expiry_date', '>', Carbon::now());
                    });
                }])->orderBy('expiry_date', 'desc');
            })
            ->get();
    }


// Livewire method to redirect to customer details
    public function redirectToCustomerDetails($clientId)
    {
        $route = route('customers.show', $clientId);
        $this->emit( 'openNewTab', ['route' => $route]);
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
            //            $exchange_rate = $this->getProductExchangeRate($current_stock);
            $exchange_rate =  !empty($current_stock->exchange_rate) ? $current_stock->exchange_rate : System::getProperty('dollar_exchange');
            $product_stores = $this->getProductStores($product);
            // $stock_units = $this->getUnits($product,$this->store_id);
            //            $discount = $this->getProductDiscount($current_stock);
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
                $price = !empty($current_stock->sell_price) ? number_format($current_stock->sell_price, 2) : 0;
                $dollar_price = !empty($current_stock->dollar_sell_price) ? number_format($current_stock->dollar_sell_price, 2) : 0;
                $new_item = [
                    'variation' => $product->variations,
                    'product' => $product,
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
                    'discount_categories' => $current_stock->prices()->get(),
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
                    'store_id' => $this->store_id,
                ];
                array_unshift($this->items, $new_item);
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
        foreach ($this->items as $item) {
            // dinar_sub_total
            $this->total += $item['sub_total'];
            // dollar_sub_total
            $this->total_dollar += $item['dollar_sub_total'];
            $this->discount += $item['discount_price'];
            $this->discount_dollar += $item['discount_price'] * $item['exchange_rate'];
        }
        $this->dollar_amount = $this->total_dollar;
        $this->amount = round_250($this->total);
        $this->payments[0]['method'] = 'cash';
        $this->rest  = 0;
        // النهائي دينار
        $this->final_total = round_250($this->total);
        // النهائي دولار
        $this->dollar_final_total = $this->total_dollar;
        // task : الباقي دينار
        $this->dinar_remaining = round_250($this->amount - $this->final_total);
        // task : الباقي دولار
        $this->dollar_remaining = ($this->dollar_amount - $this->dollar_final_total);
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
        unset($this->items[$key]);
        $this->computeForAll();
    }

    public function changePrice($key)
    {
        if (!empty($this->items[$key]['price'])) {
            $this->items[$key]['dollar_price'] = number_format($this->num_uf($this->items[$key]['price']) / $this->num_uf($this->items[$key]['exchange_rate']), 2);
            $this->items[$key]['dollar_sub_total'] = number_format($this->num_uf($this->items[$key]['sub_total']) / $this->items[$key]['exchange_rate'], 2);
            $this->items[$key]['sub_total'] = 0;
            $this->items[$key]['price'] = 0;
        } else {
            $this->items[$key]['price'] = number_format($this->num_uf($this->items[$key]['dollar_price']) * $this->items[$key]['exchange_rate'], 2);
            $this->items[$key]['sub_total'] = $this->num_uf($this->items[$key]['dollar_sub_total'] * $this->items[$key]['exchange_rate']);
            $this->items[$key]['dollar_sub_total'] = 0;
            $this->items[$key]['dollar_price'] = 0;
        }
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
                $this->dollar_remaining = $this->dollar_final_total - ($this->dollar_amount + ($this->amount / System::getProperty('dollar_exchange')));
            } elseif ($this->dollar_final_total == 0 && $this->final_total !== 0 && $this->dollar_amount !== 0 && $this->amount != 0) {
                // $diff_dollar = $this->dollar_amount -  $this->dollar_final_total;
                // $this->dinar_remaining = round_250($this->dinar_remaining - ( $diff_dollar * System::getProperty('dollar_exchange')));
                $this->dinar_remaining = $this->final_total - ($this->amount + ($this->dollar_amount * System::getProperty('dollar_exchange')));
            } elseif ($this->dinar_remaining > 0 && $this->dollar_final_total !== null && $this->dollar_final_total !== 0 && $this->dollar_amount > $this->dollar_final_total) {
                $diff_dollar = $this->dollar_amount -  $this->dollar_final_total;
                $this->dinar_remaining = round_250($this->dinar_remaining - ($diff_dollar * System::getProperty('dollar_exchange')));
                $this->dollar_remaining = 0;
            } else {
                // Check if total is in dinar and both dollar and dinar amounts are 0
                if ($this->final_total != 0 && $this->dollar_final_total == 0 && $this->amount == 0) {
                    // Round to the nearest 250 value
                    $rounded_final_total = round_250($this->final_total);
                    // Convert remaining dollar to dinar
                    $this->dinar_remaining = round_250($rounded_final_total - ($this->dollar_amount * System::getProperty('dollar_exchange')));
                }
                // Handle the case where total is in dollar and both dollar and dinar amounts are 0
                elseif ($this->dollar_final_total != 0) {
                    // Calculate remaining dollar amount directly
                    $this->dollar_remaining = $this->dollar_final_total - $this->dollar_amount;
                    if ($this->final_total != 0) {
                        $this->dinar_remaining = round_250($this->final_total - $this->amount);
                        if ($this->dinar_remaining < 0 &&  $this->dollar_remaining > 0) {
                            $diff_dinar = $this->amount -  $this->final_total;
                            $this->dollar_remaining = $this->dollar_remaining - ($diff_dinar / System::getProperty('dollar_exchange'));
                            $this->dinar_remaining = 0;
                        }
                    }
                }
            }
        }
    }

    public function changeReceivedDinar()
    {
        if ($this->amount !== null && $this->amount !== 0) {
            if ($this->final_total == 0 && $this->dollar_final_total !== 0 && $this->dollar_amount !== 0 && $this->amount != 0) {
                $this->dollar_remaining = $this->dollar_final_total - ($this->dollar_amount + ($this->amount / System::getProperty('dollar_exchange')));
            } elseif ($this->dollar_final_total == 0 && $this->final_total !== 0 && $this->dollar_amount !== 0 && $this->amount != 0) {

                $this->dinar_remaining = $this->final_total - ($this->amount + ($this->dollar_amount * System::getProperty('dollar_exchange')));
            } elseif ($this->dollar_remaining > 0 && $this->final_total !== null && $this->final_total !== 0 && $this->amount > $this->final_total) {
                $diff_dinar = $this->amount -  $this->final_total;
                $this->dollar_remaining = $this->dollar_remaining - ($diff_dinar / System::getProperty('dollar_exchange'));
                $this->dinar_remaining = 0;
            } else {
                // Check if total is in dollars and both dollar and dinar amounts are 0
                if ($this->dollar_final_total != 0 && $this->final_total == 0 && $this->dollar_amount == 0) {
                    // Calculate remaining dollar amount directly
                    $this->dollar_remaining = $this->dollar_final_total - ($this->amount / System::getProperty('dollar_exchange'));
                }
                // Check if total is in dinars and both dollar and dinar amounts are 0
                elseif ($this->final_total != 0) {
                    // Calculate remaining dinar amount
                    $this->dinar_remaining = round_250($this->final_total) - $this->amount;

                    if ($this->dollar_final_total != 0) {
                        $this->dollar_remaining = $this->dollar_final_total - $this->dollar_amount;
                        if ($this->dollar_remaining < 0 &&  $this->dinar_remaining > 0) {
                            $diff_dollar = $this->dollar_amount -  $this->dollar_final_total;
                            $this->dinar_remaining = round_250($this->dinar_remaining - ($diff_dollar * System::getProperty('dollar_exchange')));
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
        }
        elseif (($total_paid > 0 && $final_amount > $total_paid) ||( $dollar_total_paid> 0 && $dollar_final_amount > $dollar_total_paid) ) {
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
            $payments_formatted[0]['amount'] = $payments_formatted[0]['amount'] + !empty($pos_return_transactions) ? number_format($pos_return_transactions->final_total, 2) : 0;
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
            $stock_line = AddStockLine::where('variation_id', $variation_id)->first();
            if (empty($stock_line->sell_price) && empty($stock_line->dollar_sell_price)) {
                //            $stock_line = AddStockLine::find($this->items[$key]['current_stock']['id']);
                $stock_variation = Variation::find($this->items[$key]['current_stock']['variation_id']);
                $product_variations = Variation::where('product_id', $this->items[$key]['product']['id'])->get();
                $unit = Variation::where('id', $variation_id)->first();
                $qtyByUnit = $this->getNewSellPrice($stock_variation, $product_variations, $unit, $variation_id);
                $this->items[$key]['price'] = number_format($this->items[$key]['current_stock']['sell_price'] * $qtyByUnit ?? 0, 2);
                $this->items[$key]['dollar_price'] = number_format($this->items[$key]['current_stock']['dollar_sell_price'] * $qtyByUnit ?? 0, 2);
            } else {
                $this->items[$key]['price'] = number_format($stock_line->sell_price ?? 0, 2);
                $this->items[$key]['dollar_price'] = number_format($stock_line->dollar_sell_price ?? 0, 2);
                $this->items[$key]['current_stock'] = $stock_line;
                $this->items[$key]['discount_categories'] = $stock_line->prices()->get();
            }
            $this->items[$key]['sub_total'] = number_format($this->num_uf($this->items[$key]['price']) * $this->items[$key]['quantity'], 2);
            $this->items[$key]['dollar_sub_total'] = number_format($this->items[$key]['dollar_price'] * $this->items[$key]['quantity'], 2);
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
                    $this->items[$key]['quantity_available'] = number_format($product_store->quantity_available / $amount, 3);
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
            $qtyByUnit = $unit->equal / $stock_variation->equal;
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
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'تم إضافة الفاتورة بنجاح']);
            return $this->redirect('/invoices/create');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'lang.something_went_wrongs',]);
            dd($e);
        }
    }
    public function changeDinarPrice($key)
    {
        try {
            $stock_line = AddStockLine::where('product_id', $this->items[$key]['product']['id'])->where('variation_id', $this->items[$key]['unit_id'])->first();
            if (!empty($stock_line)) {
                $stock_line->sell_price = $this->num_uf($this->items[$key]['price']);
                if (isset($stock_line->dollar_sell_price) && $stock_line->dollar_sell_price !== 0) {
                    $stock_line->dollar_sell_price = $this->num_uf($this->items[$key]['price']) / $this->num_uf($this->items[$key]['exchange_rate']);
                    $this->items[$key]['dollar_price'] = number_format($this->num_uf($this->items[$key]['price']) / $this->num_uf($this->items[$key]['exchange_rate']), 3);
                }
                $stock_line->save();
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
            $stock_line = AddStockLine::where('product_id', $this->items[$key]['product']['id'])->where('variation_id', $this->items[$key]['unit_id'])->first();
            if (!empty($stock_line)) {
                $stock_line->dollar_sell_price = $this->num_uf($this->items[$key]['dollar_price']);
                if (isset($stock_line->sell_price) && $stock_line->sell_price !== 0) {
                    $stock_line->sell_price = $this->num_uf($this->items[$key]['dollar_price']) * $this->num_uf($this->items[$key]['exchange_rate']);
                    $this->items[$key]['price'] = number_format($this->num_uf($this->items[$key]['dollar_price']) * $this->num_uf($this->items[$key]['exchange_rate']), 3);
                }
                $stock_line->save();
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
    public function check_items_store()
    {
        if(!empty($this->items)){
            foreach ($this->items  as $key => $item){
                if($item['store_id'] != $this->store_id){
                    unset($this->items[$key]);
                }
            }
        }
    }
}
