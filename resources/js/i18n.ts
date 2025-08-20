// Schritt 2: Die i18n-Konfiguration bereinigen
// ===========================================
// Ersetze den Inhalt deiner Datei unter: /resources/js/i18n.ts

import { createI18n } from 'vue-i18n';

/**
 * Erstellt eine leere i18n-Instanz.
 * Die eigentlichen Übersetzungen werden dynamisch in app.ts geladen,
 * basierend auf den Daten, die vom Laravel-Backend kommen.
 */
export default createI18n({
    legacy: false,
    locale: 'de', // Standard-Sprache, wird sofort überschrieben
    fallbackLocale: 'en',
    messages: {}, // Startet mit einem leeren Nachrichten-Objekt
});