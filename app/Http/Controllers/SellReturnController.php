<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\SellLine;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\TransactionSellLine;
use App\Utils\CashRegisterUtil;
use App\Utils\MoneySafeUtil;
use App\Utils\NotificationUtil;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellReturnController extends Controller
{/**
 * All Utils instance.
 *
 */
    protected $commonUtil;
    protected $productUtil;
    protected $moneySafeUtil;

    /**
     * Constructor
     *
     * @param Util $commonUtil
     * @param ProductUtil $productUtil
     * @param MoneySafeUtil $moneySafeUtil
     */
    public function __construct(Util $commonUtil, ProductUtil $productUtil, MoneySafeUtil $moneySafeUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
        $this->moneySafeUtil = $moneySafeUtil;
    }


    public function index(){
        $sell_returns = TransactionSellLine::where('type' , 'sell_return')->get();
//        dd($sell_returns);
        return view('returns.sell.index',compact('sell_returns'));
    }
}
