<?php

    use Illuminate\Database\Seeder;

    class UserSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //
            $user = new \App\User();

            $user->email = "test@example.com";
            $user->name = "test";
            $user->password = "$2y$10$yg3qlZ2xV/afrQwobmZUSucvQpnXmjRdLBOJ9.flK/6mxd2jsPlUS";
            $user->save();
        }
    }
