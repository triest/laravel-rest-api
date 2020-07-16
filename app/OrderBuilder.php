<?php

    namespace App;

    use DateTime;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Auth;

    class OrderBuilder extends Model
    {
        //
        private $satus = null;

        private $title = null;

        private $description = null;

        private $complited = null;

        private $intermediary_percentage=null;

        /**
         * @param null $intermediary_percentage
         */
        public function setIntermediaryPercentage($intermediary_percentage): void
        {
            $this->intermediary_percentage = $intermediary_percentage;
        }


        /**
         * @param mixed $satus
         */
        public function setSatus($satus): void
        {
            $this->satus = $satus;
        }

        /**
         * @param mixed $title
         */
        public function setTitle($title): void
        {
            $this->title = $title;
        }

        /**
         * @param mixed $description
         */
        public function setDescription($description): void
        {
            $this->description = $description;
        }

        /**
         * @param mixed $complited
         */
        public function setComplited($complited): void
        {
            $this->complited = $complited;
        }


        public function createItem()
        {

            if ($this->title == null) {
                return null;
            }

            $order = new Order();
            $user = Auth::user();
            if ($user == null) {
                return "not auth";
            }
            $order->customer_id = $user->id;

            $order->title = $this->title;
            $order->description = $this->description;
            $order->status_id = 1;

            $order->intermediary_percentage=$this->intermediary_percentage;

            if ($this->complited != null && DateTime::createFromFormat('Y-m-d', $this->complited) === false) {
                return "wrong date format";
            }


            $order->completed = $this->complited;
            $order->save();
            return $order;
        }

    }
