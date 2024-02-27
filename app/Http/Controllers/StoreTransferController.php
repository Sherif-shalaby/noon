<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\TransferTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreTransferController extends Controller
{
    public function index()
    {
        $stores = Store::getDropdown();
        $query = TransferTransaction::where('type', 'store_transfer');
        if (!empty(request()->sender_store_id)) {
            $query->where('sender_store_id', request()->sender_store_id);
        }
        if (!empty(request()->receiver_store_id)) {
            $query->where('receiver_store_id', request()->receiver_store_id);
        }
        if (!empty(request()->invoice_no)) {
            $query->where('invoice_no', request()->invoice_no);
        }
        if (!empty(request()->start_date)) {
            $query->whereDate('transaction_date', '>=', request()->start_date);
        }
        if (!empty(request()->end_date)) {
            $query->whereDate('transaction_date', '<=', request()->end_date);
        }
        if (!empty(request()->start_time)) {
            $query->where('transaction_date', '>=', request()->start_date . ' ' . Carbon::parse(request()->start_time)->format('H:i:s'));
        }
        if (!empty(request()->end_time)) {
            $query->where('transaction_date', '<=', request()->end_date . ' ' . Carbon::parse(request()->end_time)->format('H:i:s'));
        }
        $permitted_stores = array_keys($stores);
        if (!session('is_superadmin')) {
            $query->where(function ($q) use ($permitted_stores) {
                $q->whereIn('receiver_store_id', $permitted_stores)->orWhereIn('sender_store_id', $permitted_stores);
            });
        }

        $transfers = $query->orderBy('invoice_no', 'desc')->get();


        return view('store_transfer.index')->with(compact(
            'transfers',
            'stores'
        ));
    }
}
