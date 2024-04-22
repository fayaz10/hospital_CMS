<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesAndAdmissionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payable_id');
            $table->string('payable_type', 191);
            $table->string('term', 191);
            $table->integer('amount');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('currency_id');
            $table->string('considerations')->nullable();
            $table->timestamps();

            $table->unique(['payable_id', 'payable_type', 'term']);
        });

        Schema::create('admissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('course_id');
            $table->tinyInteger('discount')->nullable();
            $table->unsignedInteger('registrar_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees');
        Schema::dropIfExists('admissions');
    }
}
