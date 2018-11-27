<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serial_Number extends Model
{
    protected $table = 'serial_numbers';

    public function products() {
        return $this->belongsTo(Product::class);
    }

    public function activity() {
        return $this->hasMany(Serial_Number_Activity::class);
    }

   /*
    *   we already checked that the product exists, so
    *   1 - none are available, return a 0
    */
    public static function get_first_available($id)
    {
        $serial_number = self::where('product_id',$id)
                             ->where('available',1)
                             ->orderBy('number','asc')
                             ->first();

        $count = (is_null($serial_number)) ? 0 : $serial_number->count();
        $first_available = ($count==0)     ? 0 : $first_available = $serial_number->number;
        return $first_available;
    }

   /*
    *   find last serialization number for the given product->id
    *   create entries in the seraial_numbers table until you reach max
    */
    public static function store($id,$max)
    {
        $serial_number = self::where('product_id',$id)->orderBy('number','desc')->first();

        if(is_null($serial_number)) {
            $start = 1;
        } else {
            $start = $serial_number->number + 1;
        }

        $record_count = 0;
        for($i=$start; $i<=$max; $i++){
            $serial_number = new Serial_Number();
            $serial_number->number = $i;
            $serial_number->product_id = $id;
            $serial_number->save();
            $record_count++;
        }
        return $record_count;
    }


}
