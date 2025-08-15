// resources/js/app.ts

import '../css/app.css';

import { createApp, h, type DefineComponent } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import type { Config as ZiggyConfig } from 'ziggy-js'; // Typ für Ziggy-Options
import './bootstrap';
import { initializeTheme } from './composables/useAppearance';
import { trackClick } from '@/directives/trackClick';


// Consent + Analytics
import { useConsent, loadConsent } from '@/composables/useConsent';
import { useGoogleAnalytics } from '@/composables/useGoogleAnalytics';

// Globale Komponente
import ContactForm from './components/ContactForm.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    // 1) Consent laden
    loadConsent();

    // 2) GA-Funktionen holen (inkl. pageview)
    const { consentState } = useConsent();
    const { init, updateConsent, pageview } = useGoogleAnalytics();

    // 3) GA initialisieren (send_page_view:false in der Composable)
    init();

    // 4) Falls bereits Einwilligung vorliegt, sofort aktualisieren
    if (!consentState.bannerVisible) {
      updateConsent(consentState);
    }

    const vueApp = createApp({ render: () => h(App, props) });

    vueApp.use(plugin);

    // Ziggy-Options typsicher + Defaults absichern
    const ziggy = (props.initialPage.props as any).ziggy as ZiggyConfig;
    (ziggy as any).defaults ??= {} as Record<string, any>;
    vueApp.use(ZiggyVue, ziggy);

    vueApp.directive('track-click', trackClick);
    vueApp.component('contact-form', ContactForm);

    vueApp.mount(el);

    // Erster Pageview nach dem initialen Mount
    pageview(window.location.pathname + window.location.search);

    // SPA-Pageviews bei Inertia-Navigation
    router.on('navigate', () => {
      pageview(window.location.pathname + window.location.search);
    });
  },
  progress: { color: '#4B5563' },
});

// HINWEIS: Der separate 'router.on('navigate')'-Block ist nicht mehr nötig.
// Das 'gtag('config', ...)' in der init-Funktion kümmert sich automatisch
// um das Tracking von Seitenaufrufen in einer Single-Page-Application (SPA).

// Theme wird initialisiert
initializeTheme();

// EASTER EGG
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
// 
// console.log(`%c${message}`, styles); 
// console.log('Mein GitHub-Profil: https://github.com/grubengeist');
