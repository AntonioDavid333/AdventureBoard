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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('heroe_id');
            $table->unsignedBigInteger('purchase_id');
            $table->timestamps();

            $table->foreign('heroe_id')->references('id')->on('heroes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipments', function (Blueprint $table) {
        $table->dropForeign(['heroe_id']);
        $table->dropForeign(['purchase_id']);
    });

        Schema::dropIfExists('equipments');
    }
};
