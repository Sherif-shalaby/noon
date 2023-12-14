<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\System;
use App\Models\TransactionSellLine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Util;
class SalesPerEmployeeReportController extends Controller
{
      /**
     * All Utils instance.
     *
     */
    protected $commonUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment_types = $this->commonUtil->getPaymentTypeArrayForPos();
        // if (request()->ajax()) {
            $default_currency_id = System::getProperty('currency');
            $query = TransactionSellLine::whereNotNull('store_pos_id')
                ->where('status', 'final') ->orderBy('employee_id','asc');

            if (!empty(request()->employee_id)) {
                $query->where('transaction_sell_lines.employee_id', request()->employee_id);
            }
            // if (!empty(request()->method)) {
            //     $query->where('transaction_payments.method', request()->method);
            // }
            if (!empty(request()->start_date)) {
                $query->whereDate('transaction_date', '>=', request()->start_date);
            }
            if (!empty(request()->end_date)) {
                $query->whereDate('transaction_date', '<=', request()->end_date);
            }
            if (!empty(request()->start_time)) {
                $query->where('transaction_date', '>=', request()->start_time . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
            }
            if (!empty(request()->end_time)) {
                $query->where('transaction_date', '<=', request()->end_time . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
            }
            if (!empty(request()->employee_id)) {
                $query->where('employee_id', '>=', request()->employee_id . ' ' . Carbon::parse(request()->employee_id)->format('H:i:s'));
            }
            // if (!auth()->user()->can('reports.sales_per_employee.view')) {
            //     $employee = Employee::where('user_id', Auth::id())->first();
            //     if (!empty($employee)) {
            //         $query->where('transaction_sell_lines.employee_id', $employee->id);
            //     }
            // }

            $sales = $query->orderBy('transaction_date', 'desc')->get();
            $employees = Employee::pluck('employee_name', 'id');

        return view('reports.employee-sales.index')->with(compact('default_currency_id',
            'sales',
            'payment_types',
            'employees',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
