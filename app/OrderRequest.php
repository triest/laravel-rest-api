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
    }
