// resources/js/ssr.ts
import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { renderToString } from '@vue/server-renderer';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createSSRApp, h, type DefineComponent } from 'vue';
import ziggyRoute, { type Config as ZiggyConfig } from 'ziggy-js';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createServer((page) =>
  createInertiaApp({
    page,
    render: renderToString,
    title: (title) => `${title} - ${appName}`,

    resolve: (name) => {
      const pages = import.meta.glob('./pages/**/*.vue');
      // Cast, damit die Signatur passt
      return resolvePageComponent(`./pages/${name}.vue`, pages) as Promise<DefineComponent>;
    },

    setup({ App, props, plugin }) {
      const app = createSSRApp({ render: () => h(App, props) });

      // Ziggy-Config aus den Page-Props holen (falls vorhanden)
      const ziggyFromPage = (page.props as any)?.ziggy as Partial<ZiggyConfig> | undefined;

      // Sichere Location bauen (URL benötigt absolutes Base)
      const locCandidate =
        (ziggyFromPage?.location as string | undefined) ??
        (typeof (page as any).url === 'string' ? (page as any).url : '/') ??
        '/';

      // Vollständige ZiggyConfig aufbauen (fehlende Felder fallbacken)
      const ziggyConfig: ZiggyConfig = {
        url: (ziggyFromPage?.url as string | undefined) ?? '',
        port: (ziggyFromPage?.port as number | undefined) ?? null,
        defaults: (ziggyFromPage?.defaults as Record<string, any> | undefined) ?? {},
        routes: (ziggyFromPage?.routes as Record<string, any> | undefined) ?? {},
        location: new URL(locCandidate, 'http://localhost'),
      };

      // Route-Wrapper, der die Page-Config defaultet
      const route: (...args: any[]) => any = (
        name?: any,
        params?: any,
        absolute?: any,
        config?: ZiggyConfig,
      ) => (ziggyRoute as any)(name, params, absolute, config ?? ziggyConfig);

      // global in Vue
      (app.config.globalProperties as any).route = route;

      // SSR: auch globalThis (für Server-Kontext)
      if (typeof window === 'undefined') {
        (globalThis as any).route = route;
      }

      app.use(plugin);
      return app;
    },
  }),
);
