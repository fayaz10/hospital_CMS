<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiverseIncomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diverse_incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->string('subject', 191)->index();
            $table->enum('type', ['variant', 'fixed'])->index();
            $table->unsignedInteger('registrar_id');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('diverse_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->index();
            $table->string('label_en', 191)->index();
            $table->string('label_dr', 191)->index();
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
        Schema::dropIfExists('diverse_incomes');
        Schema::dropIfExists('diverse_category');
    }
}
