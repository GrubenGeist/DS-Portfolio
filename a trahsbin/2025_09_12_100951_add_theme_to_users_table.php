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
        Schema::table('users', function (Blueprint $table) {
            // Wir fügen eine Spalte 'theme' hinzu, die 'light', 'dark' oder 'system' speichern kann.
            // Sie kann null sein und hat 'system' als Standardwert.
            $table->string('theme')->nullable()->default('system')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dies macht die Änderung wieder rückgängig, falls nötig.
            $table->dropColumn('theme');
        });
    }
};