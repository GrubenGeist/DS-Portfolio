// resources/js/directives/trackClick.ts
import type { Directive } from 'vue';
import axios from 'axios';
import { useConsent } from '@/composables/useConsent';

type TrackPayload = {
  category?: string;
  action?: string;
  label?: string;
  value?: number;
  path?: string;
  ts?: number;
};

type TrackBinding = TrackPayload & {
  url?: string;
  requireConsent?: boolean;
  debug?: boolean;
};

declare const route: any;

function hasDNT(): boolean {
  const anyNav = navigator as any;
  return (
    anyNav?.globalPrivacyControl === true ||
    navigator.doNotTrack === '1' ||
    (window as any).doNotTrack === '1' ||
    anyNav?.msDoNotTrack === '1'
  );
}

async function send(url: string, payload: TrackPayload, debug?: boolean) {
  try {
    const res = await axios.post(url, payload, { headers: { Accept: 'application/json' } });
    if (debug) console.debug('[track-click] sent via axios', res.status, url, payload);
    return res.status >= 200 && res.status < 300;
  } catch (e) {
    if (debug) console.warn('[track-click] axios failed, trying fallback', e);
    // Fallback zu sendBeacon oder fetch, falls axios fehlschlägt
    try {
      const json = JSON.stringify(payload);
      if ('sendBeacon' in navigator) {
        const ok = navigator.sendBeacon(url, new Blob([json], { type: 'application/json' }));
        if (debug) console.debug('[track-click] sent via beacon', ok, url, payload);
        if (ok) return true;
      }
    } catch (beaconError) {
      if (debug) console.warn('[track-click] beacon failed', beaconError);
    }
  }
  return false;
}

const CAPTURE = true;
const handlerMap = new WeakMap<HTMLElement, EventListener>();

export const trackClick: Directive<HTMLElement, TrackBinding | undefined> = {
  mounted(el, binding) {
    const handler: EventListener = () => {
      // =============================================================================
      // KORREKTUR: Wir holen den Consent-Status bei JEDEM Klick neu.
      // =============================================================================
      // Das stellt sicher, dass wir immer den aktuellsten Zustand haben,
      // auch nach einem "Inertia-Reload".
      const { consentState } = useConsent();
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
        label: cfg.label ?? (el.textContent || '').trim().slice(0, 120),
        value: typeof cfg.value === 'number' ? cfg.value : undefined,
        path: location.pathname,
        ts: Date.now(),
      };

      let url = cfg.url || '';
      try {
        if (!url) url = route('api.analytics-events.store');
      } catch {
        url = '/api/analytics-events';
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
