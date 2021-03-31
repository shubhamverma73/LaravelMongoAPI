<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Userdatamodel extends Eloquent
{
    use AuthenticableTrait;

    protected $connection 	= 'mongodb';
    protected $collection 	= 'user';    
    protected $fillable 	= ['name', 'username', 'email', 'phone', 'password', 'city', 'state', 'address', 'pincode'];
}