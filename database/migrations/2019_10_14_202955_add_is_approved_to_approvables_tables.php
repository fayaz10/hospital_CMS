<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsApprovedToApprovablesTables extends Migration
{

    private $tables = [
        'incomes' => 'registrar_id',
        'experiments' => 'status',
        'prescriptions' => 'diagnosis',
        'diverse_incomes' => 'description',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach($this->tables as $table => $column)
            Schema::table($table, function (Blueprint $table) use ($column) {
                $table->boolean('is_approved')->after($column)->default(true);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach($this->tables as $table => $column)
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('is_approved');
            });
    }
}
