<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->index();
            $table->smallInteger('age');
            $table->bigInteger('record_no')->unique();
            $table->string('phone_no',14)->nullable();
            $table->string('tazkira',20)->nullable();
            $table->text('photo')->nullable();
            $table->unsignedInteger('registrar_id');
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
        Schema::dropIfExists('patients');
    }
}
