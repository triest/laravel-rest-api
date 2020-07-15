<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Auth;

    class OrderRequest extends Model
    {
        //

        public function setCompleted()
        {
            $this->status_id = 3;
            $this->save();
        }

        public function setInWork()
        {
            if($this->contractor_id!=Auth::user()->id){
                return false;
            }

            $this->status_id = 2;
            $this->save();
            return true;
        }

        public static function getItem($id)
        {
            return OrderRequest::select(['*'])->where('id', $id)->first();
        }


        public function cancel()
        {
            if ($this->status_id == 3) {
                return false;
            }
            $this->status_id = 4;
            $this->save();
        }
    }
