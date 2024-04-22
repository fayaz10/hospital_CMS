<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToAllTables extends Migration
{

    private $tables = [
        'users', 
        'visits',
        'modules',
        'incomes',
        'attachments',
        'patients',
        'doctors',
        'expenses',
        'medicine_purchase',
        'medicines',
        'purchased_medicines',
        'units',
        'medicine_type',
        'stock',
        'tests',
        'experiment_test',
        'experiments',
        'prescriptions',
        'medicine_stockout',
        'diverse_incomes',
        'diverse_category',
        'diverse_expenses',
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
        foreach($this->tables as $table)
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
    }
}
