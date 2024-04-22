<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 191)->unique();
            $table->string('label_en')->default('Some Module');
            $table->string('label_dr')->default('مادیول فرضی');
            $table->string('label_pa')->default('د فرضی مادیول');
            $table->string('path', 50);
        });

        Schema::create('module_user', function (Blueprint $table) {
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('user_id');

            $table->primary(['user_id','module_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
        Schema::dropIfExists('module_user');
    }
}
