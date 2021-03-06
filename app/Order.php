<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Order extends Model
    {
        //

        public static function getItem($id)
        {
            return Order::select(['*'])->where('id', $id)->first();
        }

        public function requwest()
        {
            return $this->hasOne("App\OrderRequest",'order_id','id');
        }

        public function markCompleted()
        {
            $this->status_id = 3;

            $this->save();
            $orderRequwest = $this->requwest()->first();


            if ($orderRequwest != null) {
                $orderRequwest->setCompleted();
            }


        }

    }
