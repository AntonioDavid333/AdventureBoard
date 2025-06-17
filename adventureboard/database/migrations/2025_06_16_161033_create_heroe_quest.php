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
        Schema::create('heroe_quest', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hero_id');
            $table->unsignedBigInteger('quest_id');
            $table->enum('status',['pending','accepted','rejected'])->default('pending');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();

            $table->foreign('hero_id')->references('id')->on('heroes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('quest_id')->references('id')->on('quests')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['hero_id','quest_id']);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroe_quest');
    }
};
