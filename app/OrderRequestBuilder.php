<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

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

            $this->status_id = 2;

            if ($order == null) {
                return "order status  is not correct";
            }


            $contracter = User::getItem($this->contractor_id);
            if ($contracter == null) {
                return "contracter  is not correct";
            }

            $order->status_id = 2;
            $order->save();

            $orderRequwest = new OrderRequest();
            $orderRequwest->order_id = $this->order_id;
            $orderRequwest->contractor_id = $this->contractor_id;
            $orderRequwest->status_id = $this->status_id;
            $orderRequwest->save();
            return $orderRequwest;

        }

    }
