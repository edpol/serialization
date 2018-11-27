<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'customer_id', 'username', 'password', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function customers() {
        return $this->belongsTo(Customer::class);
    }

    public function activity() {
        return $this->hasMany(Serial_Number_Activity::class);
    }

    public function isAdmin() {
        return $this->admin; // this looks for an admin column in your users table
    }

/*
//   I don't think we need this
    public function findForPassport($username) {
        return $this->where('id', $username)->first();
    }
*/
}