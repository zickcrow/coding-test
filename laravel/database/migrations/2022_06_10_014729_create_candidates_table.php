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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->foreignId('education_institution_id')->nullable()->constrained();
            $table->date('birthday')->nullable();
            $table->integer('experience')->nullable();
            $table->unsignedBigInteger('last_position_id')->nullable();
            $table->unsignedBigInteger('applied_position_id')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->longText('resume')->nullable();
            $table->timestamps();

            $table->foreign('last_position_id')->references('id')->on('positions');
            $table->foreign('applied_position_id')->references('id')->on('positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
};
