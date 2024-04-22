<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tazkira_id');
            $table->string('name_dr');
            $table->string('name_en');
            $table->string('last_name_dr')->nullable();
            $table->string('last_name_en')->nullable();
            $table->string('father_name_dr');
            $table->string('father_name_en');
            $table->string('grand_father_name_dr')->nullable();
            $table->string('grand_father_name_en')->nullable();
            $table->date('dob_en')->nullable();
            $table->string('dob_dr', 12)->nullable();
            $table->string('photo')->nullable();
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('students');
    }
}
