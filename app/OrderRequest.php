<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class OrderRequest extends Model
    {
        //

        public function setCompleted()
        {
            $this->status_id = 3;
            $this->save();
        }

        public static function getItem($id)
        {
            return OrderRequest::select(['*'])->where('id', $id)->first();
        }

        public function cancel()
        {
            $this->status_id = 4;
            $this->save();
        }
    }
