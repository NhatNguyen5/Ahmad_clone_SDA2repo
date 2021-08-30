<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FuelQuoteHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $timestamps = false;
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('quote_histories', function($t) {
            $t -> increments('id');
            $t -> integer('user_id');
            $t -> foreign('user_id')->references('id')->on('users');
            $t -> float('Gallons', 200)->nullable();
            $t -> string('Address', 500)->nullable();
            $t -> timestamp('start')->nullable();
            $t -> double('Suggested_Price')->nullable();
            $t -> double('Due')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::drop('quote_histories');
    }
}
