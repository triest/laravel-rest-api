<?php

use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class OrderRequwestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_request_statuses')->insert([
                'title' => 'В поиске исполнителя',
        ]);

        //
        DB::table('order_request_statuses')->insert([
                'title' => 'В работе',
        ]);

        DB::table('order_request_statuses')->insert([
                'title' => 'Выполнен',
        ]);

        DB::table('order_request_statuses')->insert([
                'title' => 'Отменен',
        ]);
    }
}
