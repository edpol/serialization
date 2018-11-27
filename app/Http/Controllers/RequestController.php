<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Serial_Number_Activity;
use App\Serial_Number;
use App\Product;
use App\User;

class RequestController extends Controller
{
    public $successStatus = 200;
    private $status = "success";
    private $available;

    // add
    public function create(Request $request)
    {
        $max = $request->input('max_serial');
        $sku = $request->input('product');

        $user = \Auth::user();
        $product = Product::where('sku',$sku)->where('customer_id',$user->customer_id)->first();
        $count = (is_null($product)) ? 0 : $product->count();

        //  if the product sku does not exist, 
        //  create product and serialize up to max
        $store_product = false;
        $store_serial  = false;
        if ($count==0) {
            $store_product = true;
            $store_serial  = true;
        } else {
            $serial_number = Serial_Number::where('product_id',$product->id)->where('number',$max)->first();
            $count = (is_null($serial_number)) ? 0 : $serial_number->count();
            //  The product already exists, does the number?
            if ($count==0) {
                $store_serial  = true;
            } else {
                $response = ['status' => "error", 'message' => "this number already exists"];
                return response()->json($response, $this->successStatus);
            }
            
        }

        $temp = [ 'sku' => $sku, 'max_serial' => $max ];
        if ($store_product) {
            $product = Product::store($sku);
        }
        if ($store_serial) {
            $records_created = Serial_Number::store($product->id, $max);
//          $temp['records_created'] = $records_created;
        }

        $data = [ 'product' => $temp ];
        return response()->json(['status' => $this->status, 'data' => $data], $this->successStatus);
    }

    public function reserve(Request $request, $sku)
    {
        return $this->set_available($request, $sku, __FUNCTION__);
    }

    // release
    public function release(Request $request, $sku, $serial_number)
    {
        return $this->set_available($request, $sku, __FUNCTION__, $serial_number);
    }

    // reserve a serial number that belongs to an sku
    public function set_available(Request $request, $sku, $action, $target_number="")
    {
        //  if we dont have a serial number we need to find next available
        $user = \Auth::user();
        $product = Product::where('sku',$sku)->where('customer_id',$user->customer_id)->first();

        //  1 - does product exist
        if (is_null($product)) {
            $response = ['status' => "error", 'message' => "this product does not exist"];
            return response()->json($response, $this->successStatus);
        }

        //  2a - is the serial number in the URI
        if ($action=="release" && $target_number=="") {
            $response = ['status' => "error", 'message' => "product number missing from URI"];
            return response()->json($response, $this->successStatus);
        }

        //  2b - is the serial number in the BODY
        if ($action=="reserve") {
            $target_number = $request->input('serial_number',0);
            //  the serial number for reserve is optional, if missing get first available
            if ($target_number==0) {
                $target_number = Serial_Number::get_first_available($product->id);
                /* what if NONE are available */
                if ($target_number==0) {
                    $response = ['status' => "error", 'message' => "no numbers available"];
                    return response()->json($response, $this->successStatus);
                }
            }
        }

        $serial_number = Serial_Number::where('product_id',$product->id)->where('number',$target_number)->first();

        //  3 - does serial number exist
        if (is_null($serial_number)) {
            $response = ['status' => "error", 'message' => "serial number does not exist"];
            return response()->json($response, $this->successStatus);
        }

        //  4 - is serial number available to reserve or release
        if ($action=="reserve" && $serial_number->available==false) {
            $message = "number is already reserved";
            $response = ['status' => "error", 'message' => $message];
            return response()->json($response, $this->successStatus);
        }
        if ($action=="release" && $serial_number->available==true) {
            $message = "number is already released";
            $response = ['status' => "error", 'message' => $message];
            return response()->json($response, $this->successStatus);
        }

        //  update available set to true/false
        $serial_number->available = !$serial_number->available;
        $serial_number->save();

        //  update activities file
        $serial_number_activity = new Serial_Number_Activity();
        $serial_number_activity->user_id          = $user->id;
        $serial_number_activity->serial_number_id = $target_number;
        $serial_number_activity->action           = $action;
//      $serial_number_activity->note = "User {$user->id} {$action} serial number {$target_number}";
        $serial_number_activity->save();

        $data = [ 'serial_number' => $target_number ];
        return response()->json(['status' => $this->status, 'data' => $data], $this->successStatus);
    }

    //status
    public function status(Request $request, $sku, $number)
    {
        $user = \Auth::user();
        $product = Product::where('sku',$sku)->where('customer_id',$user->customer_id)->first();

        //  1 - does product exist
        if (is_null($product)) {
            $response = ['status' => "error", 'message' => "this product does not exist"];
            return response()->json($response, $this->successStatus);
        }

        $serial_number = Serial_Number::where('product_id',$product->id)->where('number',$number)->first();

        //  2 - does serial number exist
        if (is_null($serial_number)) {
             $response = ['status' => "error", 'message' => "serial number does not exist"];
            return response()->json($response, $this->successStatus);
        }

        $available = ($serial_number->available) ? "true" : "false";

        $data = [ 'sku'=>$sku, 'serial_number' => $number, 'available' => $available ];
        return response()->json(['status' => $this->status, 'data' => $data], $this->successStatus);
    }

}
