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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('heroe_id');
            $table->unsignedBigInteger('quest_id');
            $table->enum('status',['pending','accepted','rejected'])->default('pending');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
            $table->string('description', 600);

            $table->foreign('heroe_id')->references('id')->on('heroes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('quest_id')->references('id')->on('quests')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['heroe_id','quest_id']);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
