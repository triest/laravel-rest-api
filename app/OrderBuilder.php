<?php

    namespace App;

    use DateTime;
    use Illuminate\Database\Eloquent\Model;

    class OrderBuilder extends Model
    {
        //
        private $satus;

        private $title;

        private $description;

        private $complited;


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

            if ($this->title == null || $this->description == null) {
                return null;
            }

            $order = new Order();
            $order->title = $this->title;
            $order->description = $this->description;
            $order->status_id = 1;
            if (DateTime::createFromFormat('Y-m-d', $this->complited) === FALSE) {
                return "wrong date format";
            }

            $order->completed=$this->complited;
            $order->save();
            return $order;
        }

    }
