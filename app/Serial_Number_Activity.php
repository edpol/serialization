<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serial_Number_Activity extends Model
{

 protected $table = 'Serial_Number_Activities';

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function serial_numbers() {
        return $this->belongsTo(Serial_Number::class);
    }
}
