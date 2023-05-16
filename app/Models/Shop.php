<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{

  protected $fillable = [
    'name',
    'phone',
    'email',
    'address',
    'delivery_pickup_latitude',
    'delivery_pickup_longitude',
    'status',
  ];

  protected $with = ['user'];

  public function user()
  {
    return $this->belongsToMany(User::class);
  }
}
