<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->index();
            $table->text('range')->nullable();
            $table->timestamps();
        });

        Schema::create('tests_sub_tests', function (Blueprint $table) {
            $table->unsignedInteger('test_id');
            $table->unsignedInteger('sub_test_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_tests');
        Schema::dropIfExists('tests_sub_tests');
    }
}
