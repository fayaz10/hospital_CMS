<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('class_id');
            $table->date('valid_date');
            $table->date('expire_date');
//            $table->integer('discount')->nullable();
            $table->integer('punishment')->nullable();
            $table->string('considerations')->nullable();
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
        Schema::dropIfExists('fees_payment');
    }
}
