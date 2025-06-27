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
        Schema::create('factions', function (Blueprint $table) {
            $table->id();
            $table->string('image_uri')->nullable();
            $table->string('name',100);
            $table->text('description')->max(400);
            $table->unsignedInteger('bonus_at')->default(0);   // Ataque
            $table->unsignedInteger('bonus_def')->default(0);  // Defensa
            $table->unsignedInteger('bonus_ki')->default(0);  // Ki
            $table->unsignedInteger('bonus_hp')->default(0);  // HP
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factions');
    }
};
