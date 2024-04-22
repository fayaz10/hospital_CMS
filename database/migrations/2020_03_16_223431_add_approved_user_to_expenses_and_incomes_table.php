<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovedUserToExpensesAndIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->unsignedInteger('approved_user')->after('registrar_id')->nullable();
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->unsignedInteger('approved_user')->after('registrar_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('approved_user');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('approved_user');
        });
    }
}
