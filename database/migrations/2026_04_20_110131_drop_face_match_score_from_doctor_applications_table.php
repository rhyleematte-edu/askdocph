<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropFaceMatchScoreFromDoctorApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_applications', function (Blueprint $table) {
            $table->dropColumn('face_match_score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_applications', function (Blueprint $table) {
            $table->decimal('face_match_score', 5, 2)->nullable()->after('liveness_verified');
        });
    }
}
