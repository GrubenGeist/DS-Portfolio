// resources/js/app.ts

import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue'; // createApp und h sind schon da
import { ZiggyVue } from 'ziggy-js';
import './bootstrap';
import { initializeTheme } from './composables/useAppearance';

// NEU: Importiere deine Kontaktformular-Komponente
import ContactForm from './components/ContactForm.vue'; // Stelle sicher, dass der Pfad korrekt ist

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) }); // Erstelle die App-Instanz

        vueApp.use(plugin);
        vueApp.use(ZiggyVue, props.initialPage.props.ziggy);

        // NEU: Registriere hier deine globale Komponente
        vueApp.component('contact-form', ContactForm);

        vueApp.mount(el); // Mounte die App erst nach der Registrierung
    },
    progress: {
        color: '#4B5563',
    },


});

// This will set light / dark mode on page load...
initializeTheme();


    // --- EASTER EGG ---
    const styles = [
        'font-size: 16px',
        'font-family: monospace',
        'background: #000000ff',
        'color: #48ff00ff',
        'padding: 3px 20px',
        'border-radius: 5px',
        'line-height: 1.0', // Fügt etwas Zeilenabstand hinzu
    ].join(';');

    // Wir benutzen Backticks (` `), um einen mehrzeiligen Text zu erstellen.
    // Jeder Zeilenumbruch hier wird auch in der Konsole als Umbruch angezeigt.
    const message = `Neugierig? 😉 
    -------------------------------------------------------------------
    | Du schaust dir den Code eines leidenschaftlichen Entwicklers an.|
    | Wenn du auf der Suche nach jemandem mit Liebe zum Detail bist,  |
    | melde dich über das Kontak Formular!                            |
    |                                                                 |
    | Möge die Macht mit dir sein                                     |
    -------------------------------------------------------------------`;                                                                   

    // Gib die gestylte, mehrzeilige Nachricht aus
    console.log(`%c${message}`, styles);
    console.log('Mein GitHub-Profil: https://github.com/grubengeist');