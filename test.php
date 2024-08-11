<?php
function applyOnAllCustomers($key){
    $fill_id = $this->prices[$key]['fill_id'];
    if ($this->prices[$key]['apply_on_all_customers'] == 1) {
        $row_index = $this->getKey($fill_id) ?? null;
        if ($row_index >= 0) {
            $customer_type = $this->prices[$key]['price_customer_types'];
            $price_key = $this->getCustomerType($row_index, $customer_type);
            $percent = ($this->num_uf($this->prices[$key]['dinar_price'] ?? 1) / $this->num_uf($this->rows[$row_index]['prices'][$price_key]['dinar_sell_price'] ?? 1));
            $dollar_percent = ($this->num_uf($this->prices[$key]['price'] ?? 1) / $this->num_uf($this->rows[$row_index]['prices'][$price_key]['dollar_sell_price'] ?? 1));
            if ($price_key >= 0) {
                foreach ($this->rows[$row_index]['prices'] as $index => $price) {
                    if ($price['customer_type_id'] != $this->prices[$key]['price_customer_types']) {
                        $dinar_price_value = $this->num_uf($this->rows[$row_index]['prices'][$index]['dinar_sell_price']) * ($percent);
                        $price_value = $this->num_uf($this->rows[$row_index]['prices'][$index]['dollar_sell_price']) * ($dollar_percent);
                        $new_price = [
                            'fill_id' => $this->prices[$key]['fill_id'],
                            'price_type' => $this->prices[$key]['price_type'],
                            'price_category' => $this->prices[$key]['price_category'],
                            'price_currency' => $this->prices[$key]['price_currency'],
                            'price' => $this->prices[$key]['price_type'] == 'percentage' ? $this->prices[$key]['price'] : ($price_value ?? 0),
                            'dinar_price' => $this->prices[$key]['price_type'] == 'percentage' ? $this->prices[$key]['dinar_price'] : ($dinar_price_value ?? 0),
                            'discount_quantity' => $this->prices[$key]['discount_quantity'],
                            'bonus_quantity' => $this->prices[$key]['bonus_quantity'],
                            'price_customer_types' => $this->rows[$row_index]['prices'][$index]['customer_type_id'],
                            'price_after_desc' => $this->prices[$key]['price_type'] == $this->prices[$key]['price_after_desc'],
                            'dinar_price_after_desc' => $this->prices[$key]['dinar_price_after_desc'],
                            'total_price' => $this->prices[$key]['total_price'],
                            'dinar_total_price' => $this->prices[$key]['dinar_total_price'],
                            'piece_price' => $this->prices[$key]['piece_price'],
                            'dinar_piece_price' => $this->prices[$key]['dinar_piece_price'],
                            'apply_on_all_customers' => 0,
                            'parent_price' => 1,
                            'discount_from_original_price' => 0,
                        ];
                        $this->prices[] = $new_price;
                        $this->changePrice(count($this->prices) - 1);
                    }
                }
                // dd($this->prices[$key]['price']);

                // dd($this->prices);
            }
        }
    } else {
        foreach ($this->prices as $i => $price) {
            if ($i != $key) {
                if ($fill_id == $price['fill_id']) {
                    unset($this->prices[$i]);
                }
            }
        }
    }
}
