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
        // Wir fügen der bestehenden 'analytics_events'-Tabelle eine neue Spalte hinzu.
        Schema::table('analytics_events', function (Blueprint $table) {
            // Fügt die Spalte 'category_id' hinzu.
            // - nullable(): Die Spalte darf vorerst leer (NULL) sein. Das ist wichtig,
            //   da wir die Werte erst im nächsten Schritt aus der alten 'category'-Textspalte übertragen.
            // - after('label'): Platziert die neue Spalte direkt nach der 'label'-Spalte für bessere Lesbarkeit.
            // - constrained('categories'): Erstellt eine Fremdschlüsselbeziehung zur 'id'-Spalte der 'categories'-Tabelle.
            // - onDelete('set null'): Wenn eine Kategorie gelöscht wird, werden die zugehörigen Events nicht gelöscht,
            //   sondern ihre 'category_id' wird auf NULL gesetzt. Das verhindert Datenverlust.
            $table->foreignId('category_id')
                  ->nullable()
                  ->after('label')
                  ->constrained('categories')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analytics_events', function (Blueprint $table) {
            // Macht die Änderungen rückgängig: Zuerst die Verknüpfung löschen, dann die Spalte.
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
