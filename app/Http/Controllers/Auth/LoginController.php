<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Utils\NotificationUtil;
use App\Http\Controllers\Controller;
use App\Models\ProductStore;
use Illuminate\Support\Facades\Cache;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $notificationUtil;
    // ++++++++++++++++++++ construct() ++++++++++++++++++++
    public function __construct(NotificationUtil $notificationUtil)
    {
        $this->middleware('guest')->except('logout');
        $this->notificationUtil = $notificationUtil;
    }
    // +++++++++++++++++++++++ validateLogin() +++++++++++++++++++++++
    protected function validateLogin(Request $request)
    {
        // Get the user details from database and check if user is exist and active.
        $user = User::where('email', $request->email)->first();
        if ($user && !$user->is_active)
        {
            throw ValidationException::withMessages([$this->username() => __('User has been desactivated.')]);
        }
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
        // Get the "current date"
        $currentDate = Carbon::today();
        // Retrieve the "last execution date" from the "cache" or "database"
        $lastExecutionDate = Cache::get('last_execution_date');
        // Check if the last execution date is not today
        if ( !$lastExecutionDate || $lastExecutionDate <= $currentDate )
        {
            // dd("LoginController.last_execution_date");
            // ++++++++++++++++++ Call checkExpiary() method ++++++++++++++++++
            $this->notificationUtil->checkExpiary();
            // ++++++++++++++++++ Call quantityAlert() method ++++++++++++++++++
            // $this->notificationUtil->quantityAlert();
            // Store the current date as the last execution date
            Cache::put('last_execution_date', $currentDate, 1440); // 1440 minutes = 1 day
        }
        // +++++++++++++ Customer_Offer_Price : Block_For_Days ++++++++++++++
        // Find products where blocking has expired
        $expiredProducts = ProductStore::where('blocked_until', '<=', now())->where('block_quantity', '>', 0)->get();
        // dd($expiredProducts);
        // Restore blocked quantity to regular stock
        if($expiredProducts)
        {
            foreach ($expiredProducts as $product)
            {
                // add "blocke_quantity" to "product quantity_available" in "product_store" table
                $product->quantity_available += $product->block_quantity;
                // set "blocke_quantity" to "0"
                $product->block_quantity = 0;
                // set "blocked_until" to "null"
                $product->blocked_until = null;
                $product->save();
            }
        }
    }

}

