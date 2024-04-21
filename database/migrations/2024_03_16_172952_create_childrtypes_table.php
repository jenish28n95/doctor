<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildrtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('childrtypes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rtypes_id')->unsigned()->index();
            $table->string('name')->nullable();
            $table->string('amount')->nullable();
            $table->timestamps();

            $table->foreign('rtypes_id')->references('id')->on('rtypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('childrtypes');
    }
}
