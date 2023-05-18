<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopUsers extends Model
{
    use HasFactory;
    protected $fillable = [
        'shop_id',
        'user_id',
      ];
}
