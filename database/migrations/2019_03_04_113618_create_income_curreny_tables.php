<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeCurrenyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profitable_id');
            $table->string('profitable_type');
            $table->date('payment_date');
            $table->decimal('amount', 12, 2);
            $table->integer('currency_id');
            $table->string('recipient');
            // $table->string('tax');
            $table->tinyInteger('tax')->nullable();
            // $table->integer('payment_method_id');
            $table->integer('registrar_id');
            $table->timestamps();
        });

        Schema::create('currency', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('symbol');
            $table->string('label_en');
            $table->string('label_dr');
            $table->timestamps();
        });

        // Schema::create('payment_methods', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('type');
        //     $table->string('label_en');
        //     $table->string('label_dr');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incomes');
        Schema::dropIfExists('currency');
        // Schema::dropIfExists('payment_methods');
    }
}
