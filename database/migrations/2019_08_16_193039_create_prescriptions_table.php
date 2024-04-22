<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('doctor_id');
            $table->unsignedInteger('patient_id');
            $table->date('date');
            $table->unsignedInteger('registrar_id');
            $table->text('diagnosis')->nullable();
            $table->timestamps();
        });

        Schema::create('medicine_stockout', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('prescription_id');
            $table->unsignedInteger('medicine_id');
            $table->decimal('quantity', 7, 1);
            $table->decimal('unit_price',7 , 1);
            $table->unsignedInteger('currency_id');
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
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('medicine_stockout');
    }
}
