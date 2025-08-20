// resources/js/app.ts
import '../css/app.css';

import { createApp, h, type DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3'; // 'router' wird hier nicht mehr direkt benötigt
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import type { Config as ZiggyConfig } from 'ziggy-js';
import i18n from './i18n';


// Wichtig: bootstrap.ts konfiguriert Axios mit dem CSRF-Token.
import './bootstrap';

import { initializeTheme } from './composables/useAppearance';
import { trackClick } from '@/directives/trackClick';

// Consent + Analytics
import { useConsent, loadConsent } from '@/composables/useConsent';
import { useGoogleAnalytics } from '@/composables/useGoogleAnalytics';

// Globale Komponente
import ContactForm from './components/ContactFormInner.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

/** ---------------- Inertia App ---------------- */
createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
  setup({ el, App, props, plugin }) {

    // --- i18n-Setup ---
    const initialLocale = props.initialPage.props.locale || 'de';
    const allMessages = props.initialPage.props.translations || {};

    i18n.global.locale.value = initialLocale;

    Object.keys(allMessages).forEach(locale => {
        i18n.global.setLocaleMessage(locale, allMessages[locale]);
    });

    const vueApp = createApp({ render: () => h(App, props) });
    vueApp.use(plugin);
    vueApp.use(i18n);
    

    // Consent laden
    loadConsent();

    // GA vorbereiten
    const { consentState } = useConsent();
    const { init, updateConsent } = useGoogleAnalytics();
    if (!consentState.bannerVisible) updateConsent(consentState);

    // Ziggy
    const ziggy = ((props.initialPage.props as any)?.ziggy ?? {}) as ZiggyConfig;
    (ziggy as any).defaults ??= {} as Record<string, any>;
    vueApp.use(ZiggyVue, ziggy);

    // Direktiven/Komponenten
    vueApp.directive('track-click', trackClick);
    vueApp.component('contact-form', ContactForm);

    // WICHTIG: Die App wird nur EINMAL hier, ganz am Ende, gemountet.
    vueApp.mount(el);
  },
  progress: false,
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
