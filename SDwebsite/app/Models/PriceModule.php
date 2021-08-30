<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceModule extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gallons',
      
    ];

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $hidden = [
        'name',
        'email',
        'password',
        'address1',
        'address2',
        'city',
        'state',
        'zipcode',
      
    ];
}
