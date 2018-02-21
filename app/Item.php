<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';

    protected $fillable = ['name', 'description', 'type', 'buy_price', 'sell_price', 'market_value', 'circulation', 'image'];


}
