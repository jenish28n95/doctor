<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctors_id')->unsigned()->index();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('investigation')->nullable();
            $table->string('age')->nullable();
            $table->string('sex')->nullable();
            $table->string('arrival_time')->nullable();
            $table->string('inv_time')->nullable();
            $table->string('session')->nullable();
            $table->string('mediclaim')->nullable();
            $table->string('basic_amount')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('f_year')->nullable();
            $table->string('net_amount')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('balance')->nullable();
            $table->string('cash_amount')->nullable();
            $table->string('paytm_amount')->nullable();
            $table->string('is_slip')->default(0)->nullable();
            $table->string('payment')->nullable();
            $table->timestamps();

            $table->foreign('doctors_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
