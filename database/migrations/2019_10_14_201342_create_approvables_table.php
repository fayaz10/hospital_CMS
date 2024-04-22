<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('approvable_id');
            $table->string('approvable_type', 191)->index();
            $table->decimal('amount', 12, 2);
            $table->integer('currency_id');
            $table->boolean('is_approved')->nullable();
            $table->unsignedInteger('approved_user')->nullable();
            $table->date('approved_date')->nullable();
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
        Schema::dropIfExists('approvables');
    }
}
