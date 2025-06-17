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
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('image_uri',255)->nullable();
            $table->string('title');
            $table->text('description')->max(800);
            $table->unsignedBigInteger('strength_required')->default(20)->nullable();
            $table->unsignedBigInteger('defense_required')->default(20)->nullable();
            $table->unsignedBigInteger('ki_required')->default(20)->nullable();
            $table->unsignedBigInteger('reguard')->default(200);
            $table->enum('difficulty', ['easy','medium','hard'])->default('medium');
            $table->enum('status', ['open','in progress','completed'])->default('open');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quests');
    }
};
