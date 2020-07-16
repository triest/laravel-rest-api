<?php

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class OrderStatusSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //
            DB::table('order_statuses')->insert([
                    'id' => 1,
                    'title' => 'В поиске исполнителя',
            ]);

            DB::table('order_statuses')->insert([
                    'id' => 2,
                    'title' => 'В работе',
            ]);

            DB::table('order_statuses')->insert([
                    'id' => 3,
                    'title' => 'Выполнен',
            ]);

            DB::table('order_statuses')->insert([
                    'id' => 4,
                    'title' => 'Отменен',
            ]);
        }
    }
