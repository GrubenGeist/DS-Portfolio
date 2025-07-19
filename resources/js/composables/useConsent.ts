import { reactive, readonly } from 'vue';

// Standard-Zustand: Alles ist deaktiviert
const defaultConsent = {
  necessary: true,
  analytics: false,
  marketing: false,
};

// Ein reaktives Objekt, das den aktuellen Zustand hält
const consentState = reactive({ ...defaultConsent });

// Funktion zum Laden des gespeicherten Zustands
const loadConsent = () => {
  const savedConsent = localStorage.getItem('cookie_consent');
  if (savedConsent) {
    // Überschreibe den Standard mit den gespeicherten Werten
    Object.assign(consentState, JSON.parse(savedConsent));
  }
};

// Zustand "readonly" für Komponenten, damit sie ihn nicht
// direkt ändern können, sondern nur über unsere Funktionen.
export function useConsent() {
  return {
    consentState: readonly(consentState),
    loadConsent,
  };
}