<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountToAllProfitableTables extends Migration
{
    private $tables = [
        'experiments',
        'prescriptions',
        'diverse_incomes',
        'emergency',
        'surgery_prescriptions',
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach($this->tables as $table)
            Schema::table($table, function (Blueprint $table) {
                $table->tinyInteger('discount')->after('registrar_id')->nullable();
                $table->string('membership_id', 191)->index()->after('discount')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach($this->tables as $table)
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('discount');
                $table->dropColumn('membership_id');
            });
    }
}
