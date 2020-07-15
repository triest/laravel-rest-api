<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    public static function getItem($id){
        return Order::select(['*'])->where('id',$id)->first();
    }

}
