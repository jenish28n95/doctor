<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctors_id')->unsigned()->index();
            $table->unsignedBigInteger('patients_id')->unsigned()->index();
            $table->string('comm_amount')->nullable();
            $table->string('comm_date')->nullable();
            $table->string('f_year')->nullable();
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
        Schema::dropIfExists('wallets');
    }
}
