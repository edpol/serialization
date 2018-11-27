<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function users() {
        return $this->hasMany(User::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function name($id) {
        return self::find($id)->value('name');
    }

    public function index() {
        return self::all();
    }
}
