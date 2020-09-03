<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('division_id')->unsigned();
            $table->integer('religion_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->string('nip')->index();
            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address');
            $table->date('date_birth')->nullable();
            $table->date('date_join')->nullable();
            $table->string('photo_profile');
            $table->integer('status');
            $table->integer('level');
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
