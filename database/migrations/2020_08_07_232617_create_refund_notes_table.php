<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('source_id');
            $table->string('source_type', 191)->index();
            $table->enum('type', ['minus', 'plus'])->index();
            $table->timestamp('ttl')->index();
            $table->decimal('amount', 12, 2);
            $table->unsignedInteger('approved_user')->nullable();
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
        Schema::dropIfExists('refund_notes');
    }
}
