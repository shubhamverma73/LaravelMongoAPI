<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Product extends Eloquent implements AuthenticatableContract
{
    use AuthenticableTrait;
    use HasFactory, Notifiable;

    //protected $connection = 'mymongo';
    protected $connection = 'mongodb';
    protected $collection = 'product';
    
    protected $fillable = [
        '_id', 'name', 'status', 'date', 'category'
    ];
}
