<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function customers() {
        return $this->belongsTo(Customer::class);
    }

    public function serial_numbers() {
        return $this->hasMany(Serial_Number::class);
    }

    public static function store($sku)
    {
        $user = \Auth::user();
        $product = new Product();
        $product->customer_id = $user->customer_id;
        $product->sku = $sku;
        $product->save();
        return $product;
    }

}
