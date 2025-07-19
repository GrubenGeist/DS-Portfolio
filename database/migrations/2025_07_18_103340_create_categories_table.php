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
        // Erstellt die neue Tabelle 'categories'
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primärschlüssel 
            $table->string('name')->unique(); // Der Name der Kategorie (z.B. "Hero Button"), muss einzigartig sein
            $table->timestamps(); // Erstellt die Spalten created_at und updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
