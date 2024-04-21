<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientreportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patientreports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patients_id')->unsigned()->index();
            $table->string('report_id')->nullable();
            $table->string('childreport_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('file')->nullable();
            $table->text('report_content')->nullable();
            $table->timestamps();

            $table->foreign('patients_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patientreports');
    }
}
