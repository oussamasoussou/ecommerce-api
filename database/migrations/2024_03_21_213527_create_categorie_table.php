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
        Schema::create('categorie', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            // $table->foreignId('sous_categorie_id')
            //     ->nullable()
            //     ->constrained('sous_categorie')
            //     ->onUpdate('cascade');
            // $table->foreignId('sous_sous_categorie_id')
            //     ->nullable()
            //     ->constrained('sous_sous_categorie')
            //     ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorie');
    }
};
