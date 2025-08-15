// resources/js/types/global-route.d.ts

// ⚠️ Diese Datei sollte die *einzige* globale Definition für `route` sein.
// Keine weiteren .d.ts-Dateien anlegen, die `route` noch einmal deklarieren.
// Und in Komponenten KEIN `import { route } from 'ziggy-js'` mehr verwenden.

declare global {
  // Globale Ziggy-Funktion – bewusst locker typisiert
  function route(...args: any[]): any;

  interface Window {
    route: (...args: any[]) => any;
  }
}

// Vue-Instanz: `this.route` / `route` im Template verfügbar
declare module 'vue' {
  interface ComponentCustomProperties {
    route: (...args: any[]) => any;
  }
}

export {};
