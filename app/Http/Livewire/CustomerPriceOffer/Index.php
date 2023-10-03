<?php

namespace App\Http\Livewire\CustomerPriceOffer;

use App\Models\Customer;
use App\Models\CustomerOfferPrice;
use App\Models\Invoice;
use App\Models\Store;
use App\Models\TransactionCustomerOfferPrice;
use Livewire\Component;

class Index extends Component
{
    public $filter_status, $from, $to, $store_id, $customer_id ;
    // +++++++++++++++ Date filter +++++++++++++++
    public function between($query)
    {
        // Between Two Dates "from" And "to"
        if ($this->from && $this->to)
        {
            $query->whereBetween('created_at', [$this->from, $this->to]);
            // $query->where('created_at', '>=', $this->from);
            // $query->where('created_at', '<=', $this->to);
        }
        // "from" date only
        elseif ($this->from)
        {
            $query->where('created_at', 'like', '%' . $this->from . '%');
        }
        // "to" date only
        elseif ($this->to)
        {
            $query->where('created_at', 'like', '%' . $this->to . '%');
        }
        else
        {
            $query;
        }
    }
    public function render()
    {
        $customer_offer_prices = TransactionCustomerOfferPrice::with(['customer','store','transaction_customer_offer_price'])
                                    ->where(function ($q)
                                    {
                                        $this->between($q);
                                        if ($this->customer_id)
                                        {
                                            $q->where('customer_id', $this->customer_id);
                                        }
                                        if ($this->store_id)
                                        {
                                            $q->where('store_id', 'like', '%' . $this->store_id . '%');
                                        }
                                    })->paginate(10);
        $stores = Store::getDropdown();
        $customers = Customer::get();

        return view('livewire.customer-price-offer.index',
                compact('customer_offer_prices','stores','customers'));
    }
}
