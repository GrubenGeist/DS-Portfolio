<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Erstellt die 'visits'-Tabelle mit optimierter Struktur.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            
            // Anonymisierter Fingerabdruck des Besuchers
            $table->string('ip_address_hash');
            $table->string('user_agent_hash');
            
            // Erkannter Gerätetyp ('desktop' oder 'mobile')
            $table->string('device_type')->nullable();

            // Letzte Aktivität des Besuchers
            $table->timestamp('last_seen')->nullable();

            // Standard Laravel Zeitstempel (created_at und updated_at)
            $table->timestamps();

            // ---- Indizes ----
            // Für schnelle Identifikation eines Besuchers
            $table->index(['ip_address_hash', 'user_agent_hash']);
            
            // Für schnelle Abfragen der aktiven Besucher
            $table->index('last_seen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Macht die Erstellung der Tabelle rückgängig.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
