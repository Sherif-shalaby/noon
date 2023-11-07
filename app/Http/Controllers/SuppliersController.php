<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\MoneySafe;
use App\Models\Product;
use App\Models\State;
use App\Models\StockTransaction;
use App\Models\StockTransactionPayment;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\System;
use App\Models\User;
use App\Utils\TransactionUtil;
use App\Utils\MoneySafeUtil;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
{

    protected $Util;
    protected $commonUtil;
    protected $transactionUtil;
    protected $cashRegisterUtil;
    protected $moneysafeUtil;
    /**
     * Constructor
     *
     * @param Utils $product
     * @return void
     */
    public function __construct(Util $commonUtil, TransactionUtil $transactionUtil, MoneySafeUtil $moneysafeUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moneysafeUtil = $moneysafeUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('id','desc')->get();
        $countryId = System::getProperty('country_id');
        $countryName = Country::where('id', $countryId)->pluck('name')->first();
        // return $settings;

        return view('suppliers.index')->with(compact(
            'suppliers','countryId' , 'countryName'
        ));
    }
    /* ++++++++++++++++++++++++++ create() ++++++++++++++++++++ */
    public function create()
    {
        $supplier_categories = Category::where('parent_id',null)->pluck('name', 'id');
        // ++++++++++++++++++++ Country , State , Cities Selectbox ++++++++++++++++
        $countryId = System::getProperty('country_id');
        $countryName = Country::where('id', $countryId)->pluck('name')->first();
        return view('suppliers.create')->with(compact(
            'supplier_categories','countryId','countryName'
        ));
    }
    // ++++++++++++++ fetchState(): to get "states" of "selected country" selectbox ++++++++++++++
    public function fetchState(Request $request)
    {
        $data['states'] = State::where('country_id', $request->country_id)->get(['id','name']);
        return response()->json($data);
    }
    // ++++++++++++++ fetchCity(): to get "cities" of "selected city" selectbox ++++++++++++++
    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where('state_id', $request->state_id)->get(['id','name']);
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['nullable', 'max:30'],
                'notes' => ['nullable', 'max:255'],
                'company_name' => ['nullable', 'max:30'],
                'vat_number' => ['nullable', 'max:30'],
                'email' => ['nullable', 'max:50'],
                'mobile_number' => ['required', 'max:30'],
                'address' => ['nullable', 'max:60'],
                'city' => ['nullable', 'max:30'],
                'state' => ['nullable', 'max:30'],
                'country' => ['nullable', 'max:30'],
                'postal_code' => ['nullable', 'max:30']
            ]
        );
        if ($validator->fails()) {
            $output = [
                'success' => false,
                'msg' => $validator->getMessageBag()->first()
            ];
            if ($request->ajax()) {
                return $output;
            }

            return redirect()->back()->withInput()->with('status', $output);
        }
        $data = $request->except('_token','mobile_number','email');
        // ++++++++++++++ store mobile_number in array ++++++++++++++++++
        $data['mobile_number'] = json_encode($request->mobile_number);
        // ++++++++++++++ store email in array ++++++++++++++++++
        $data['email'] = json_encode($request->email);

        $data['created_by'] = Auth::user()->id;
//        dd($data);
        if ($request->file('image')) {
            $data['image'] = store_file($request->file('image'), 'suppliers');
        }

        $supplier = Supplier::create($data);
        $output = [
            'success' => true,
            'id' => $supplier->id,
            'msg' => __('lang.success')
        ];
        // return "test";
        // return response()->json(['status' => __('lang.success')]);
        if ($request->ajax()) {
            return $output;
        }
        return redirect()->back()->with('status', __('lang.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier_id = $id;
        $supplier = Supplier::find($id);

        $add_stock_query = StockTransaction::whereIn('stock_transactions.type', ['add_stock', 'purchase_return'])
            ->whereIn('stock_transactions.status', ['received', 'final']);

        if (!empty(request()->start_date)) {
            $add_stock_query->where('transaction_date', '>=', request()->start_date);
        }
        if (!empty(request()->end_date)) {
            $add_stock_query->where('transaction_date', '<=', request()->end_date);
        }
        if (!empty($supplier_id)) {
            $add_stock_query->where('stock_transactions.supplier_id', $supplier_id);
        }
        $add_stocks = $add_stock_query->select(
            'stock_transactions.*'
        )->get();


        $purchase_order_query = StockTransaction::whereIn('stock_transactions.type', ['purchase_order'])
            ->where('status', 'sent_supplier');

        if (!empty(request()->start_date)) {
            $purchase_order_query->where('transaction_date', '>=', request()->start_date);
        }
        if (!empty(request()->end_date)) {
            $purchase_order_query->where('transaction_date', '<=', request()->end_date);
        }
        if (!empty($supplier_id)) {
            $purchase_order_query->where('stock_transactions.supplier_id', $supplier_id);
        }
        $purchase_orders = $purchase_order_query->select(
            'stock_transactions.*'
        )->get();


        $service_provided_query = StockTransaction::whereIn('stock_transactions.type', ['supplier_service'])
            ->where('status', 'final');

        if (!empty(request()->start_date)) {
            $service_provided_query->where('transaction_date', '>=', request()->start_date);
        }
        if (!empty(request()->end_date)) {
            $service_provided_query->where('transaction_date', '<=', request()->end_date);
        }
        if (!empty($supplier_id)) {
            $service_provided_query->where('stock_transactions.supplier_id', $supplier_id);
        }
        $service_provided = $service_provided_query->select(
            'stock_transactions.*'
        )->get();

        // $payment_types = $this->commonUtil->getPaymentTypeArrayForPos();
        // $status_array = $this->commonUtil->getPurchaseOrderStatusArray();

        return view('suppliers.show')->with(compact(
            'add_stocks',
            'purchase_orders',
            'service_provided',
            // 'status_array',
            'supplier'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);
        $supplier_categories = Category::where('parent_id',null)->pluck('name', 'id');
        return view('suppliers.edit')->with(compact(
            'supplier',
            'supplier_categories'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
//        dd($request);
        try {
            $data['name'] = $request->name;
            $data['company_name'] = $request->company_name;
            $data['supplier_category_id'] = $request->supplier_category_id;
            $data['vat_number'] = $request->vat_number;
            $data['email'] = $request->email;
            $data['mobile_number'] = $request->mobile_number;
            $data['address'] = $request->address;
            $data['city'] = $request->city;
            $data['country'] = $request->country;
            $data['postal_code'] = $request->postal_code;
            $data['exchange_rate'] = $request->exchange_rate;
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $data['updated_by'] = Auth::user()->id;
            Supplier::find($id)->update($data);

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
        }
//        return response()->json(['status' => $output]);
         return redirect()->route('suppliers.index')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $brand=Supplier::find($id);
            $brand->deleted_by=Auth::user()->id;
            $brand->save();
            $brand->delete();
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
          }
          return $output;
    }
    public function getDropdown()
    {
        $suppliers =Supplier::orderBy('name', 'asc')->pluck('name', 'id');
        $suppliers_dp = $this->Util->createDropdownHtml($suppliers, __('lang.please_select'));
        return $suppliers_dp;
    }
    public function getPayContactDue($supplier_id)
    {
        if (request()->ajax()) {

            $due_payment_type = request()->input('type');
            $supplier = Supplier::where('suppliers.id', $supplier_id)->first();
            $totalDollarAmount = StockTransaction::where('supplier_id',$supplier_id)->selectRaw('SUM(IF(dollar_final_total IS NOT NULL, dollar_final_total,0)) as total_dollar_amount')
                ->first();
            $dollar_supplier_details = $totalDollarAmount->total_dollar_amount;

            $totalDinarAmount = StockTransaction::where('supplier_id',$supplier_id)->selectRaw('SUM(IF(final_total IS NOT NULL,final_total,0)) as total_amount')
                ->first();
            $supplier_details = $totalDinarAmount->total_amount;
            $dollar_total_paid = StockTransaction::where('supplier_id', $supplier_id)
                    ->with('transaction_payments')
                    ->get()
                    ->flatMap(function ($stockTransaction) {
                        return $stockTransaction->transaction_payments->map(function ($payment) {
                            if ($payment->paying_currency == 119) {
                                return $payment->amount / $payment->exchange_rate;
                            } else {
                                return $payment->amount;
                            }
                        });
                    })
                    ->sum();
            $dinar_total_paid = StockTransaction::where('supplier_id', $supplier_id)
                    ->with('transaction_payments')
                    ->get()
                    ->flatMap(function ($stockTransaction) {
                        return $stockTransaction->transaction_payments->map(function ($payment) {
                            if ($payment->paying_currency == 2) {
                                return $payment->amount * $payment->exchange_rate;
                            } else {
                                return $payment->amount;
                            }
                        });
                    })
                    ->sum();
            $payment_type_array = $this->getPaymentTypeArray();
            $users = User::Notview()->pluck('name', 'id');

            return view('suppliers.partial.pay_supplier_due')->with(compact(
                'supplier_details','dollar_supplier_details','supplier',
                'payment_type_array','users','dollar_total_paid','dinar_total_paid'
            ));
        }
        
    }
    public function getPaymentTypeArray()
    {
        return [
            'cash' => __('lang.cash'),
            'card' => __('lang.credit_card'),
            'bank_transfer' => __('lang.bank_transfer'),
            'cheque' => __('lang.cheque'),
            'money_transfer' => 'Money Transfer',
        ];
    }
    public function postPayContactDue(Request  $request)
    {
        try {
            DB::beginTransaction();
            $supplier_id = $request->input('supplier_id');
            $inputs = $request->only([
                'amount', 'method', 'note', 'card_number', 'card_month', 'card_year',
                'cheque_number', 'bank_name', 'bank_deposit_date', 'ref_number', 'paid_on'
            ]);

            $inputs['paid_on'] = $this->commonUtil->uf_date($inputs['paid_on']) . ' ' . date('H:i:s');
            $inputs['amount'] = $this->commonUtil->num_uf($inputs['amount']);

            $inputs['payment_for'] = $supplier_id;
            $inputs['created_by'] = auth()->user()->id;
  
            $due_transactions = StockTransaction::where('supplier_id', $supplier_id)
                ->whereIn('type', ['add_stock'])
                ->whereIn('status', ['received', 'final'])
                ->where('payment_status', '!=', 'paid')
                ->orderBy('transaction_date', 'asc')
                ->get();

            $total_amount = $inputs['amount'];
            $tranaction_payments = [];
            if ($due_transactions->count()) {
                foreach ($due_transactions as $transaction) {
                    //If add stock check status is received
                    if ($transaction->type == 'add_stock' && $transaction->status != 'received') {
                        continue;
                    }

                    if ($total_amount > 0) {
                        $total_paid = $this->transactionUtil->getStockTotalPaid($transaction->id);
                        $due = (isset($request->paying_currency)?$transaction->dollar_final_total:$transaction->final_total) - $total_paid;
                        $now = Carbon::now()->toDateTimeString();
                        $array =  [
                            'stock_transaction_id' =>  $transaction->id,
                            'amount' => $this->commonUtil->num_uf($inputs['amount']),
                            'paying_currency'=>isset($request->paying_currency)?2:119,
                            'payment_for' => $transaction->supplier_id,
                            'method' => $inputs['method'],
                            'paid_on' => $inputs['paid_on'],
                            'ref_number' => $inputs['ref_number'],
                            'bank_deposit_date' => !empty($data['bank_deposit_date']) ? $this->commonUtil->uf_date($data['bank_deposit_date']) : null,
                            'bank_name' => $inputs['bank_name'],
                            'card_number' => $inputs['card_number'],
                            'card_month' => $inputs['card_month'],
                            'card_year' => $inputs['card_year'],
                            'exchange_rate' =>isset($transaction->transaction_payments->first()->exchange_rate)?$transaction->transaction_payments->first()->exchange_rate:System::getProperty('dollar_exchange'),
                            'created_by' => Auth::user()->id,
                            'created_at' => $now,
                            'updated_at' => $now
                        ];
                        if ($due <= $total_amount && $due!==0) {
                            $array['amount'] = $due;
                            $tranaction_payments[] = $array;
                            //Update transaction status to paid
                            $transaction->payment_status = 'paid';
                            $transaction->save();

                            $total_amount = $total_amount - $due;
                        } else {
                            $array['amount'] = $total_amount;
                            $tranaction_payments[] = $array;

                            $transaction->payment_status = 'partial';
                            $transaction->save();
                            $total_amount = 0;
                        }
                        $transaction_payment = StockTransactionPayment::create($array);

                        $user_id = null;

                        if (!empty($request->source_id)) {
                            if ($request->source_type == 'pos') {
                                $user_id = StorePos::where('id', $request->source_id)->first()->user_id??null;
                            }
                            if ($request->source_type == 'user') {
                                $user_id = $request->source_id;
                            }
                            if (!empty($user_id)) {
                                $this->moneysafeUtil->addPayments($transaction, $array, 'debit', $user_id);
                            }
                            if ($request->source_type == 'safe') {
                                $money_safe = MoneySafe::find($request->source_id);
                                $array['currency_id'] = $transaction->paying_currency_id;
                                $this->moneysafeUtil->addPayment($transaction, $array, 'debit', $transaction_payment->id, $money_safe);
                            }
                        }
                        if ($total_amount == 0) {
                            break;
                        }
                    }
                }
            }


            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => "File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage()
            ];
        }

        return redirect()->back()->with(['status' => $output]);
    }

}
