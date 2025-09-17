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
        // Überprüft, ob die Spalte existiert, bevor sie entfernt wird.
        if (Schema::hasColumn('analytics_events', 'category')) {
            Schema::table('analytics_events', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }

    /**
     * Reverse the migrations.
     * Macht die Änderung rückgängig, falls nötig.
     */
    public function down(): void
    {
        Schema::table('analytics_events', function (Blueprint $table) {
            // Fügt die Spalte wieder hinzu, falls wir die Migration zurückrollen müssen.
            $table->string('category')->nullable()->after('label');
        });
    }
};
