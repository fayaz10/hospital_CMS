<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStateToApprovablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('approvables', function (Blueprint $table) {
            $table->string('record_no')->after('approvable_type')->nullable();
            $table->text('state')->after('approved_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approvables', function (Blueprint $table) {
            $table->dropColumn('record_no');
            $table->dropColumn('state');
        });
    }
}
