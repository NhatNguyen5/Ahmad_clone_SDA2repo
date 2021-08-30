<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->enum('state', ["AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "DC", "FL", 
            "GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", 
            "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", 
            "NJ", "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", 
            "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", 
            "WY"])->nullable();
            $table->string('zipcode')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
