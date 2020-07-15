<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddContractorToOrderRequwestTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('order_requests', function (Blueprint $table) {
                //
                $table->addColumn('biginteger', 'contractor_id')->after('status_id')->nullable()->default(null);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('order_requests', function (Blueprint $table) {
                //
                $table->dropColumn('contractor_id');
            });
        }
    }
