<?php

namespace App\Http\Controllers;


use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function PHPUnit\Framework\returnArgument;

class AddStockController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $add_stock = StockTransaction::find($id);
        $payment_type_array = $this->getPaymentTypeArray();
//        $taxes = Tax::pluck('name', 'id');
        $users = User::Notview()->pluck('name', 'id');

        return view('add-stock.show')->with(compact(
            'add_stock',
            'payment_type_array',
            'users',
//            'taxes'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
    public function getPaymentTypeArray()
    {
        return [
            'cash' => __('lang.cash'),
        ];
    }
}
