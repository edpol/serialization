<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Customer;
use Illuminate\Support\Facades\Auth;
use Validator;

class PassportController extends Controller
{

    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::user();
            $data = ["token" => $user->createToken('MyApp')->accessToken];
            return response()->json(['status'=>'success', 'data'=> $data], $this->successStatus);
        } else {
            return response()->json(['status'=>'error', 'data'=>'Unauthorised'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required',
            'username'    => 'required',
            'email'       => 'required|email',
            'customer_id' => 'required',
            'password'    => 'required',
            'c_password'  => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $custId = (int)$input['customer_id'];
        $input['customer_id'] = $custId;
        $input['password'] = bcrypt($input['password']);
        if (!isset($input['username']) || trim($input['username']) == "") {
            $success['username'] = $input['username'] = $input['email'];
        }

        $customer_id = new Customer();
        $success['customer_id'] = $customer_id->name($custId);

        $user = User::create($input);
        $success['name']   =  $user->name;
        $success['token']  =  $user->createToken('MyApp')->accessToken;

        return response()->json(['success'=>$success], $this->successStatus);

    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetails()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
