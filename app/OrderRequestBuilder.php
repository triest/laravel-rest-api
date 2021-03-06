<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Auth;

    class OrderRequestBuilder extends Model
    {
        //
        public $order_id = null;
        public $status_id = null;
        public $contractor_id = null;

        /**
         * @param null $order_id
         */
        public function setOrderId($order_id): void
        {
            $this->order_id = $order_id;
        }

        /**
         * @param null $status_id
         */
        public function setStatusId($status_id): void
        {
            $this->status_id = $status_id;
        }

        /**
         * @param null $contractor_id
         */
        public function setContractorId($contractor_id): void
        {
            $this->contractor_id = $contractor_id;
        }

        public function createItem()
        {
            if ($this->order_id == null) {
                return "order is null";
            }


            if ($this->contractor_id == null) {
                return null;
            }

            $order = Order::getItem($this->order_id);

            if ($order == null) {
                return "order is not correct";
            }

            $user=Auth::user();
            if($user==null){
                return "not auth";
            }

            if($user->id==$order->customer_id){
                return "false";
            }

            $this->status_id = 1;


            $contracter = User::getItem($this->contractor_id);
            if ($contracter == null) {
                return "contractor  is not correct";
            }

            $order->status_id = $this->status_id;
            $order->save();

            $orderRequwest = new OrderRequest();
            $orderRequwest->order_id = $this->order_id;
            $orderRequwest->contractor_id = $this->contractor_id;
            $orderRequwest->status_id = $this->status_id;
            $orderRequwest->save();
            return $orderRequwest;

        }

    }
