<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->unique();
            $table->string('label_en')->nullable();
            $table->string('label_dr')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_dr')->nullable();
            $table->decimal('price');
            $table->unsignedInteger('currency_id');
            $table->tinyInteger('duration')->nullable();

            $table->timestamps();
        });

        Schema::create('experiment_test', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('test_id');
            $table->unsignedInteger('experiment_id');
            $table->decimal('price',7 , 1);
            $table->unsignedInteger('currency_id');
            $table->text('results')->nullable();
            $table->text('description')->nullable();
            $table->string('experimentor')->nullable();
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
        Schema::dropIfExists('tests');
        Schema::dropIfExists('experment_test');
    }
}
