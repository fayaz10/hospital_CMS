<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPatientDetailsAtDiverseIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diverse_incomes', function (Blueprint $table) {
            $table->unsignedInteger('patient_id')->after('description')->nullable();
            $table->string('dossier_no')->after('is_approved')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diverse_incomes', function (Blueprint $table) {
            $table->dropColumn('patient_id');
            $table->dropColumn('dossier_no');
        });
    }
}
