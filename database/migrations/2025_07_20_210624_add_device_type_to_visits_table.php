<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Diese Methode wird ausgeführt, wenn du 'php artisan migrate' aufrufst.
     * Sie fügt die neue Spalte 'device_type' zur bestehenden 'visits'-Tabelle hinzu.
     */
    public function up(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            // Fügt eine neue Spalte vom Typ String (Text) mit dem Namen 'device_type' hinzu.
            // ->nullable(): Erlaubt, dass diese Spalte leer sein kann (wichtig für bestehende Einträge).
            // ->after('visitor_id'): Platziert die neue Spalte direkt nach 'visitor_id' für eine saubere Struktur.
            $table->string('device_type')->nullable()->after('visitor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Diese Methode wird ausgeführt, wenn du eine Migration zurückrollst.
     * Sie entfernt die 'device_type'-Spalte wieder, um die Änderung rückgängig zu machen.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            // Überprüft, ob die Spalte existiert, bevor sie gelöscht wird.
            if (Schema::hasColumn('visits', 'device_type')) {
                $table->dropColumn('device_type');
            }
        });
    }
};
