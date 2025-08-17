// resources/js/app.ts
import '../css/app.css';

import { createApp, h, type DefineComponent } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import type { Config as ZiggyConfig } from 'ziggy-js';

// Wichtig: bootstrap.ts konfiguriert Axios mit dem CSRF-Token.
// Wir verlassen uns vollständig auf diesen Mechanismus.
import './bootstrap'; 

import { initializeTheme } from './composables/useAppearance';
import { trackClick } from '@/directives/trackClick';

// Consent + Analytics
import { useConsent, loadConsent } from '@/composables/useConsent';
import { useGoogleAnalytics } from '@/composables/useGoogleAnalytics';

// Globale Komponente
import ContactForm from './components/ContactForm.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// KORREKTUR: Der gesamte manuelle CSRF-Block (readCookie, syncMetaCsrfWithCookie, router.on('before'), router.on('navigate'))
// wurde entfernt. Inertia und bootstrap.ts kümmern sich automatisch und korrekt darum.

/** ---------------- Inertia App ---------------- */
createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    // Consent laden
    loadConsent();

    // GA vorbereiten
    const { consentState } = useConsent();
    const { init, updateConsent, pageview } = useGoogleAnalytics();
    // init(); // Auskommentiert, bis du eine GA ID hast
    if (!consentState.bannerVisible) updateConsent(consentState);

    const vueApp = createApp({ render: () => h(App, props) });
    vueApp.use(plugin);

    // Ziggy
    const ziggy = (props.initialPage.props as any).ziggy as ZiggyConfig;
    (ziggy as any).defaults ??= {} as Record<string, any>;
    vueApp.use(ZiggyVue, ziggy);

    // Direktiven/Komponenten
    vueApp.directive('track-click', trackClick);
    vueApp.component('contact-form', ContactForm);

    vueApp.mount(el);

    // Pageviews für GA (optional)
    router.on('navigate', () => {
      // pageview(window.location.pathname + window.location.search); // Auskommentiert
    });
  },
  progress: { color: '#4B5563' },
});

// Theme init
initializeTheme();


/* ====== Easter Egg (so lassen) ====== */
const styles = [
  'font-size: 16px',
  'font-family: monospace',
  'background: #000000ff',
  'color: #48ff00ff',
  'padding: 3px 20px',
  'border-radius: 5px',
  'line-height: 1.0',
].join(';');


// const message = `Neugierig? 😉
//-
// | Du schaust dir den Code eines leidenschaftlichen Entwicklers an.|
// | Wenn du auf der Suche nach jemandem mit Liebe zum Detail bist,  |
// | melde dich über das Kontaktformular!                            |
// |                                                                 |
// | Möge die Macht mit dir sein                                     |
//-`;
// console.log(`%c${message}`, styles);
// console.log('Mein GitHub-Profil: https://github.com/grubengeist');
