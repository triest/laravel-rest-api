<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    //

    public static function getItem($id){
        return OrderStatus::select(['*'])->where('id',$id)->first();
    }
}
