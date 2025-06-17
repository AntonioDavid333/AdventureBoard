<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('faction_id')->nullable();
            $table->string('image_uri')->nullable();
            $table->string('name',200);
            $table->unsignedBigInteger('classrole_id')->default(0);
            $table->unsignedBigInteger('race_id')->default(0);
            $table->unsignedBigInteger('ph')->default(100);
            $table->unsignedBigInteger('strength')->default(30);
            $table->unsignedBigInteger('defense')->default(20);
            $table->unsignedBigInteger('ki')->default(20);
            $table->unsignedBigInteger('level')->default(0);
            $table->unsignedBigInteger('experience')->default(0);
            $table->text('background')->max(200)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('faction_id')->references('id')->on('factions')->onDelete('set null')->onUpdate('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
