<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicinePurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_purchase', function (Blueprint $table) {
            $table->increments('id');
            $table->string('suppliers')->nullable();
            $table->date('purchase_date');
            $table->integer('registrar_id');
            $table->timestamps();
        });

        Schema::create('medicines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->index();
            $table->integer('milligram');
            $table->string('company', 191)->index();
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('unit_id');
            $table->timestamps();
        });

        Schema::create('purchased_medicines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_id');
            $table->unsignedInteger('medicine_id');
            $table->unsignedInteger('currency_id');
            $table->decimal('total_price', 12, 2);
            $table->decimal('quantity', 7, 1);
            $table->decimal('benefits', 4, 2);
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->unique();
            $table->string('label_en');
            $table->string('label_dr');
            $table->timestamps();
        });

        Schema::create('medicine_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->unique();
            $table->string('label_en');
            $table->string('label_dr');
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
        Schema::dropIfExists('medicine_purchase');
        Schema::dropIfExists('medicine');
        Schema::dropIfExists('purchased_medicines');
        Schema::dropIfExists('units');
        Schema::dropIfExists('medicine_type');
    }
}
