// resources/js/directives/trackClick.ts
import type { Directive } from 'vue';
import axios from 'axios';
import { useConsent } from '@/composables/useConsent';

type TrackPayload = {
  category?: string;
  action?: string; // default 'click'
  label?: string;
  value?: number;
  path?: string;
  ts?: number;
};

type TrackBinding = TrackPayload & {
  url?: string;            // überschreibt Ziel-URL
  requireConsent?: boolean;
  debug?: boolean;
};

// globale Ziggy-Funktion
declare const route: any;
const $route: typeof route = route;

function hasDNT(): boolean {
  const anyNav = navigator as any;
  return (
    anyNav?.globalPrivacyControl === true ||
    navigator.doNotTrack === '1' ||
    (window as any).doNotTrack === '1' ||
    anyNav?.msDoNotTrack === '1'
  );
}

// Sende-Strategie: 1) axios 2) sendBeacon 3) fetch keepalive
async function send(url: string, payload: TrackPayload, debug?: boolean) {
  // 1) axios (nutzt globale Defaults inkl. CSRF + SameSite-Cookies)
  try {
    const res = await axios.post(url, payload, { headers: { Accept: 'application/json' } });
    if (debug) console.debug('[track-click] axios', res.status, url, payload);
    if (res.status >= 200 && res.status < 300) return true;
  } catch (e) {
    if (debug) console.warn('[track-click] axios failed', e);
  }

  // 2) sendBeacon
  try {
    const json = JSON.stringify(payload);
    if ('sendBeacon' in navigator) {
      const ok = navigator.sendBeacon(url, new Blob([json], { type: 'application/json' }));
      if (debug) console.debug('[track-click] beacon', ok, url, payload);
      if (ok) return true;
    }
  } catch (e) {
    if (debug) console.warn('[track-click] beacon failed', e);
  }

  // 3) fetch keepalive
  try {
    const res = await fetch(url, {
      method: 'POST',
      keepalive: true,
      credentials: 'same-origin',
      headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
      body: JSON.stringify(payload),
    });
    if (debug) console.debug('[track-click] fetch', res.status, url, payload);
    return res.ok;
  } catch (e) {
    if (debug) console.warn('[track-click] fetch failed', e);
    return false;
  }
}

const CAPTURE = true;
const handlerMap = new WeakMap<HTMLElement, EventListener>();

export const trackClick: Directive<HTMLElement, TrackBinding | undefined> = {
  mounted(el, binding) {
    const { consentState } = useConsent();

    const handler: EventListener = () => {
      const cfg = binding.value ?? {};

      if (cfg.requireConsent && !consentState.analytics) {
        if (cfg.debug) console.info('[track-click] blocked by consent');
        return;
      }
      if (hasDNT()) {
        if (cfg.debug) console.info('[track-click] blocked by DNT/GPC');
        return;
      }

      const payload: TrackPayload = {
        category: cfg.category ?? el.getAttribute('data-track-category') ?? 'UI',
        action: cfg.action ?? 'click',
        label: cfg.label ?? el.getAttribute('data-track-label') ?? (el.textContent || '').trim().slice(0, 120),
        value: typeof cfg.value === 'number' ? cfg.value : undefined,
        path: location.pathname,
        ts: Date.now(),
      };

      let url = cfg.url || '';
      if (!url) {
        try { url = $route('api.analytics-events.store'); } catch { url = '/api/analytics-events'; }
      }

      void send(url, payload, cfg.debug);
    };

    el.addEventListener('click', handler, { capture: CAPTURE });
    handlerMap.set(el, handler);
  },

  beforeUnmount(el) {
    const h = handlerMap.get(el);
    if (h) el.removeEventListener('click', h, CAPTURE);
    handlerMap.delete(el);
  },
};

export default trackClick;

/*

<!-- 1) Deine bisherige Nutzung bleibt gültig -->
<a :href="route('impressum')" v-track-click="{ category: 'Footer', label: 'Impressum' }">Impressum</a>

<!-- 2) DSGVO-streng (nur mit Analytics-Consent) -->
<a href="/kontakt" v-track-click="{ category: 'Footer', label: 'Kontakt', requireConsent: true }">Kontakt</a>

<!-- 3) Expliziter Endpoint oder Debug -->
<a href="/foo" v-track-click="{ category: 'CTA', label: 'Foo', url: '/api/analytics-events', debug: true }">Foo</a>

*/
