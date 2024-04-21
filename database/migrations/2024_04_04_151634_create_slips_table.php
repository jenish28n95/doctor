<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patients_id')->unsigned()->index();
            $table->string('sr_no')->nullable();
            $table->string('date')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('slips');
    }
}
