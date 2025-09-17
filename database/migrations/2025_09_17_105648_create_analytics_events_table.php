<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->string('label')->nullable();
            $table->integer('value')->nullable();
            
            // Diese Verknüpfung funktioniert jetzt, weil die 'categories'-Tabelle
            // zum Zeitpunkt der Ausführung bereits existiert.
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
    }
};