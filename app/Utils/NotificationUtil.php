<?php

namespace App\Utils;

use Carbon\Carbon;
use App\Utils\Util;
use App\Models\User;
use App\Models\System;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\AddStockLine;
use App\Models\ProductStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\InternalStockRequestJob;
use App\Models\Notification as ModelsNotification;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\AddSaleNotification;
use App\Notifications\ContactUsNotification;
// use Illuminate\Support\Facades\Notification;
use App\Notifications\CheckExipryNotification;
use App\Notifications\CheckQuantityExpiryNotification;
use App\Notifications\UserContactUsNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\QuotationToCustomerNotification;
use App\Notifications\RemoveStockToSupplierNotification;
use App\Notifications\PurchaseOrderToSupplierNotification;

class NotificationUtil extends Util
{
    // ++++++++++++++++++++++ createNotification() : checkExpiary ++++++++++++++++++++++
    public function createNotification($data)
    {
        // +++++++++++++++ Start : Notification ++++++++++++++++++++++
        // Fetch the user
        $users = User::get();
        // dd($users);
        $product_id = !empty($data['product_id']) ? $data['product_id'] : null;
        $qty_available = !empty($data['qty_available']) ? $data['qty_available'] : 0 ;
        $alert_quantity = !empty($data['alert_quantity']) ? $data['alert_quantity'] : 0 ;
        $days = !empty($data['days']) ? $data['days'] : 0 ;
        $status = $data['status'];
        $created_by = $data['created_by'];
        $type = $data['type'];
        // Send notification to users
        foreach ($users as $user)
        {
            $user_id = $user->id;
            Notification::send($user ,new CheckExipryNotification($user_id,$product_id,$qty_available,$alert_quantity,$days,$status,$created_by,$type));
        }
        // return true;
    }
    // ++++++++++++++++++++++ createNotification2() : quantityAlert ++++++++++++++++++++++
    // public function createNotification2($data)
    // {
    //     // ============ Start : Notification ++++++++++++++++++++++
    //     // Fetch the user
    //     $users = User::get();
    //     // dd($users);
    //     $product_id = !empty($data['product_id']) ? $data['product_id'] : null;
    //     $qty_available = !empty($data['qty_available']) ? $data['qty_available'] : 0 ;
    //     $alert_quantity = !empty($data['alert_quantity']) ? $data['alert_quantity'] : 0 ;
    //     $status = $data['status'];
    //     $created_by = $data['created_by'];
    //     $type = "quantity_alert";
    //     // Send notification to users
    //     foreach ($users as $user)
    //     {
    //         $user_id = $user['id'];
    //         Notification::send($user ,new CheckQuantityExpiryNotification($user_id,$product_id,$qty_available,$alert_quantity,$status,$created_by,$type));
    //     }
    //     // return true;
    // }
    // ++++++++++++++++++++++ checkExpiary() ++++++++++++++++++++++
    public function checkExpiary()
    {
        // Get "All Users"
        $users = User::get();
        // Get "today" date
        $today = now()->toDateString();
        // dd($today);
        // Get "All StockLines" info
        $add_stock_lines = AddStockLine::leftjoin('stock_transactions', 'add_stock_lines.stock_transaction_id', 'stock_transactions.id')
            ->select(
                'add_stock_lines.id',
                'stock_transactions.id as stock_transactions_id',
                'stock_transactions.store_id',
                'product_id',
                'variation_id',
                'expiry_date',
                'expiry_warning',
                'convert_status_expire',
                DB::raw('SUM(quantity - quantity_sold) as remaining_qty')
            )
            ->having('remaining_qty', '>', 0)
            ->where(function ($query) use ($today)
            {
                $query->whereDate('expiry_date', $today) // Where expiry_date is today
                    // return the result of substraction of "expiry_date" from "number of days of expiry_warning"
                    ->orWhereDate(DB::raw('DATE_SUB(expiry_date, INTERVAL expiry_warning DAY)'), $today);
            })
            // ->groupBy('add_stock_lines.id')
            ->groupBy('add_stock_lines.id', 'stock_transactions.id', 'stock_transactions.store_id', 'product_id', 'variation_id', 'expiry_date', 'expiry_warning', 'convert_status_expire')
            ->get();
        // dd($add_stock_lines);
        // foreach ($add_stock_lines as $item)
        // {
        //     if (!empty($item->expiry_date) && !empty($item->expiry_warning))
        //     {
        //         $warning_date = Carbon::parse($item->expiry_date)->subDays($item->expiry_warning);
        //         if (Carbon::now()->gt($warning_date) && Carbon::now()->lt(Carbon::parse($item->expiry_date)))
        //         {
        //             $days = Carbon::now()->diffInDays(Carbon::parse($item->expiry_date), true);
        //             foreach ($users as $user)
        //             {
        //                 $notification_data = [
        //                     'product_id' => $item->product_id,
        //                     'qty_available' => $item->remaining_qty,
        //                     'days' => $days,
        //                     'type' => 'expiry_alert',
        //                     'status' => 'unread',
        //                     'created_by' => 1,
        //                 ];
        //                 // call createNotification() method to create notification
        //                 // $this->createNotification($notification_data);
        //                 $notification_exist = ModelsNotification::whereJsonContains('data->type', 'expiry_alert')->whereJsonContains('data->product_id',$item->product_id )->whereJsonContains('data->status', 'unread')->first();
        //                 if(empty($notification_exist))
        //                 {
        //                     // dd("True if");
        //                     // call createNotification() method to create notification
        //                     $this->createNotification($notification_data);
        //                 }
        //             }
        //         }
        //         else if (Carbon::now()->gt(Carbon::parse($item->expiry_date)))
        //         {
        //             // dd("True True Else if");
        //             $days = Carbon::parse($item->expiry_date)->diffInDays(Carbon::now(), true);
        //             foreach ($users as $user)
        //             {
        //                 $notification_data = [
        //                     // 'user_id' => $user->id,
        //                     'product_id' => $item->product_id,
        //                     'qty_available' => $item->remaining_qty,
        //                     'days' => $days,
        //                     'type' => 'expired',
        //                     'status' => 'unread',
        //                     'created_by' => 1,
        //                 ];
        //             }
        //             // call createNotification() method to create notification
        //             // $this->createNotification($notification_data);
        //             $notification_exist = ModelsNotification::whereJsonContains('data->type', 'expired')->whereJsonContains('data->product_id',$item->product_id )->whereJsonContains('data->status', 'unread')->first();
        //             if(empty($notification_exist))
        //             {
        //                 // dd("True Else if");
        //                 // call createNotification() method to create notification
        //                 $this->createNotification($notification_data);
        //             }
        //         }
        //     }
        //     //change status to expired qunatity
        //     if (!empty($item->expiry_date) && isset($item->convert_status_expire)) {
        //         $expired_date = Carbon::parse($item->expiry_date)->subDays($item->convert_status_expire)->format('Y-m-d');
        //         if (Carbon::now()->format('Y-m-d') == $expired_date) {
        //             $ps = ProductStore::where('product_stores.product_id', $item->product_id)
        //                 ->where('product_stores.variation_id', $item->variation_id)
        //                 ->where('product_stores.store_id', $item->store_id)
        //                 ->first();
        //             $ps->expired_qauntity = $ps->expired_qauntity + $item->remaining_qty;
        //             $ps->save();
        //             $item->update(['expired_qauntity' => $item->remaining_qty]);
        //         }
        //     }
        // }
        foreach ($add_stock_lines as $item)
        {
            if (!empty($item->expiry_date) && !empty($item->expiry_warning))
            {
                $warning_date = Carbon::parse($item->expiry_date)->subDays($item->expiry_warning);
                if (Carbon::now()->gt($warning_date) && Carbon::now()->lt(Carbon::parse($item->expiry_date))) {
                    $days = Carbon::now()->diffInDays(Carbon::parse($item->expiry_date), true);
                    foreach ($users as $user)
                    {
                        // dd('expiry_alert');
                        $notification_data = [
                            'user_id' => $user->id,
                            'product_id' => $item->product_id,
                            'qty_available' => $item->remaining_qty,
                            'days' => $days,
                            'type' => 'expiry_alert',
                            'status' => 'unread',
                            'created_by' => 1,
                        ];
                        // $this->createNotification($notification_data);
                        $notification_exist = ModelsNotification::whereJsonContains('data->user_id', $user->id)->whereJsonContains('data->type', 'expiry_alert')->whereJsonContains('data->product_id',$item->product_id )->whereJsonContains('data->status', 'unread')->first();
                        if(empty($notification_exist))
                        {
                            // dd("True if");
                            // call createNotification() method to create notification
                            $this->createNotification($notification_data);
                        }
                    }
                }
                else if (Carbon::now()->gt(Carbon::parse($item->expiry_date)))
                {
                    $days = Carbon::parse($item->expiry_date)->diffInDays(Carbon::now(), true);
                    foreach ($users as $user) {
                        // dd("Inside expired For Each ");
                        // dd('expired');
                        $notification_data = [
                            'user_id' => $user->id,
                            'product_id' => $item->product_id,
                            'qty_available' => $item->remaining_qty,
                            'days' => $days,
                            'type' => 'expired',
                            'status' => 'unread',
                            'created_by' => 1,
                        ];
                        // $this->createNotification($notification_data);
                        $notification_exist = ModelsNotification::whereJsonContains('data->user_id', $user->id)->whereJsonContains('data->type', 'expired')->whereJsonContains('data->product_id',$item->product_id )->whereJsonContains('data->status', 'unread')->first();
                        if(empty($notification_exist))
                        {
                            // dd("True if");
                            // call createNotification() method to create notification
                            $this->createNotification($notification_data);
                        }
                    }
                }
            }
            //change status to expired qunatity
            if (!empty($item->expiry_date) && isset($item->convert_status_expire)) {
                $expired_date = Carbon::parse($item->expiry_date)->subDays($item->convert_status_expire)->format('Y-m-d');
                if (Carbon::now()->format('Y-m-d') == $expired_date) {
                    $ps = ProductStore::where('product_stores.product_id', $item->product_id)
                        ->where('product_stores.variation_id', $item->variation_id)
                        ->where('product_stores.store_id', $item->store_id)
                        ->first();
                    $ps->expired_qauntity = $ps->expired_qauntity + $item->remaining_qty;
                    $ps->save();
                    $item->update(['expired_qauntity' => $item->remaining_qty]);
                }
            }
        }
    }
    // ++++++++++++++++++++++ quantityAlert() ++++++++++++++++++++++
    // public function quantityAlert()
    // {
    //     $query = Product::leftJoin('product_stores', 'products.id', '=', 'product_stores.product_id')
    //            ->select(DB::raw('SUM(product_stores.quantity_available) as qty'), 'products.id', 'products.name')
    //            ->whereNull('products.deleted_at')
    //            ->groupBy('products.id', 'products.name');

    //     // dd($query);
    //     $items = $query->groupBy('products.id')->get();
    //     // dd($items);
    //     $users = User::where(function($q)
    //     {
    //         $q->where('is_superadmin', 1);
    //         $q->orWhere('is_admin', 1);
    //     })->get();

    //     foreach($items as $item)
    //     {
    //         foreach ($users as $user)
    //         {
    //                 $notification_data =
    //                 [
    //                     'user_id' => $user->id,
    //                     'product_id' => $item->id,
    //                     'qty_available' => $item->qty,
    //                     'alert_quantity' => $item->alert_quantity,
    //                     'type' => 'quantity_alert',
    //                     'status' => 'unread',
    //                     'created_by' => 1,
    //                 ];
    //         }
    //         $notification_exist = ModelsNotification::whereJsonContains('data->user_id', $user->id)->whereJsonContains('data->type', 'quantity_alert')->whereJsonContains('data->product_id',$item->id )->whereJsonContains('data->status', 'unread')->first();
    //         if(empty($notification_exist))
    //         {
    //             // call createNotification() method to create notification
    //             $this->createNotification2($notification_data);
    //         }
    //         // $this->createNotification2($notification_data);
    //     }
    // }
}
