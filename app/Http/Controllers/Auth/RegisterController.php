<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'        => 'required|string|max:255',
            'username'    => 'required|string|max:20|unique:users',
            'customer_id' => 'required|integer',
            'email'       => 'required|string|email|max:255',
            'password'    => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:3'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'        => $data['name'],
            'username'    => $data['username'],
            'customer_id' => $data['customer_id'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required',
            'username'    => 'required|string|max:20|unique:users',
            'email'       => 'required|string|email|max:255',
            'customer_id' => 'required|integer',
            'password'              => 'required|string|min:3|confirmed',
            'password_confirmation' => 'required|string|min:3'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
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
//      $success['token']  =  $user->createToken('MyApp')->accessToken;

        $customers = Customer::all();
        return view('auth.register',compact('customers','success'));

    }

    public function showRegistrationForm()
    {
        $customers = Customer::all();
        return view('auth.register',compact('customers'));
    }

}
