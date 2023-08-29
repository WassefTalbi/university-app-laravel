<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('degres', function (Blueprint $table) {
            $table->id();
            $table->integer('niveau');
            $table->integer('semestre');
            $table->unsignedBigInteger('specialite_id');
            $table->foreign('specialite_id')->references('id')->on('specialites')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('degres');
    }
};
