<!-- resources/js/components/GhostButton.vue -->
<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue';
import axios from 'axios';
import { useConsent } from '@/composables/useConsent';

// ----- Props -----
const props = withDefaults(defineProps<{
  trackingData?: { category: string; label: string };
  /** Nur tracken, wenn Analytics-Consent erteilt wurde (DSGVO-streng). */
  requireConsent?: boolean;
  /** Optional: eigene Tracking-URL erzwingen (überschreibt Ziggy/fallback). */
  trackingUrl?: string;
  /** Debug-Ausgaben in der Konsole aktivieren. */
  debug?: boolean;
}>(), {
  requireConsent: false,
  trackingUrl: '',
  debug: false,
});

// ----- State -----
const showGhostButton = ref(false);
const isDarkMode = ref(false);
let ghostTimeoutId: number | null = null;
let observer: MutationObserver | null = null;

const GHOST_TEXTS = [
  'Here is Jhonny!',
  'It was real enough for Georgie!',
  'Hell is other people.',
  "They're here!",
  'I see dead people.',
  'It’s getting worse.',
  'there is something strage',
  'Something’s here.',
  'It burns!',
];
const ghostButtonText = ref('???');
function setRandomGhostText() {
  const idx = Math.floor(Math.random() * GHOST_TEXTS.length);
  ghostButtonText.value = GHOST_TEXTS[idx];
}

function scheduleGhostlyReappearance() {
  const randomDelay = Math.random() * 20000 + 10000; // 10–30s
  if (ghostTimeoutId) clearTimeout(ghostTimeoutId);
  ghostTimeoutId = window.setTimeout(() => {
    setRandomGhostText();
    showGhostButton.value = true;
    try { localStorage.removeItem('ghostButtonHidden'); } catch {}
  }, randomDelay);
}

// ----- Consent / Throttle -----
const { consentState } = useConsent();
const hasAnalyticsConsent = computed(() => consentState?.analytics === true);

const LAST_SENT_KEY = 'ghostButton:lastSent';
const MIN_INTERVAL_MS = 5000;
function canSendNow() {
  try {
    const last = Number(localStorage.getItem(LAST_SENT_KEY) || 0);
    return Date.now() - last > MIN_INTERVAL_MS;
  } catch {
    return true;
  }
}
function markSent() {
  try { localStorage.setItem(LAST_SENT_KEY, String(Date.now())); } catch {}
}

// ----- Tracking -----
async function sendTrack(url: string, payload: Record<string, unknown>) {
  // 1) axios
  try {
    await axios.post(url, payload, { headers: { 'Content-Type': 'application/json' } });
    return true;
  } catch (err) {
    if (props.debug) console.warn('[GhostButton] axios failed, trying sendBeacon...', err);
  }
  // 2) sendBeacon
  try {
    const json = JSON.stringify(payload);
    if (typeof navigator !== 'undefined' && 'sendBeacon' in navigator) {
      const ok = navigator.sendBeacon(url, new Blob([json], { type: 'application/json' }));
      return ok;
    }
  } catch (err) {
    if (props.debug) console.warn('[GhostButton] sendBeacon failed:', err);
  }
  return false;
}

async function handleGhostClick() {
  // Consent-Check (konfigurierbar)
  if (props.requireConsent && !hasAnalyticsConsent.value) {
    if (props.debug) console.info('[GhostButton] blocked by consent (analytics=false).');
    showGhostButton.value = false;
    try { localStorage.setItem('ghostButtonHidden', 'true'); } catch {}
    scheduleGhostlyReappearance();
    return;
  }

  // Anti-Spam
  if (!canSendNow()) {
    if (props.debug) console.info('[GhostButton] throttled (too soon).');
    showGhostButton.value = false;
    try { localStorage.setItem('ghostButtonHidden', 'true'); } catch {}
    scheduleGhostlyReappearance();
    return;
  }

  if (props.trackingData) {
    // API-URL (Prop > Ziggy > Fallback)
    let url = props.trackingUrl || '';
    if (!url) {
      try { url = route('api.analytics-events.store'); } catch {}
    }
    if (!url) {
      try { url = route('api.track-event'); } catch {}
    }
    if (!url) url = '/api/analytics-events';

    const payload = {
      ...props.trackingData,
      path: typeof location !== 'undefined' ? location.pathname : '/',
      ts: Date.now(),
      source: 'ghost-button',
    };

    const ok = await sendTrack(url, payload);
    if (props.debug) console.info('[GhostButton] track sent:', ok, url, payload);
    if (ok) markSent();
  }

  showGhostButton.value = false;
  try { localStorage.setItem('ghostButtonHidden', 'true'); } catch {}
  scheduleGhostlyReappearance();
}

// ----- Lifecyle -----
onMounted(() => {
  isDarkMode.value = document.documentElement.classList.contains('dark');
  let wasHidden = false;
  try { wasHidden = localStorage.getItem('ghostButtonHidden') === 'true'; } catch {}

  if (!wasHidden) {
    if (Math.random() > 0.01) {
      setRandomGhostText();
      showGhostButton.value = true;
    }
  } else {
    scheduleGhostlyReappearance();
  }

  observer = new MutationObserver(() => {
    isDarkMode.value = document.documentElement.classList.contains('dark');
  });
  observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
});

onUnmounted(() => {
  if (observer) observer.disconnect();
  if (ghostTimeoutId) clearTimeout(ghostTimeoutId);
});
</script>

<template>
  <Transition name="ghost">
    <button
      v-if="isDarkMode && showGhostButton"
      @click="handleGhostClick"
      class="glitch-button flex items-center gap-3 rounded-md border border-cyan-300/20 px-3 py-2"
      :data-text="ghostButtonText"
    >
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
           stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
           class="h-4 w-4 text-cyan-300/50">
        <path d="M6 4h8a4 4 0 0 1 4 4v8a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4Z"></path>
        <path d="M12 18a6 6 0 0 0-6-6 6 6 0 0 1 6-6"></path>
      </svg>
      <span class="text-cyan-300/50">{{ ghostButtonText }}</span>
    </button>
  </Transition>
</template>

<style>
.ghost-leave-active { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
.ghost-leave-to { opacity: 0; transform: translateY(-20px) scale(0.8); }

/* einfacher Glitch-Effekt */
.glitch-button {
  animation: glitch-jiggle 4s infinite alternate;
  will-change: transform;
}
@keyframes glitch-jiggle {
  0%, 10%, 12%, 80%, 82%, 100% { transform: translate(0, 0); text-shadow: none; }
  11% { transform: translate(-1px, 1px); text-shadow: 1px 0 0 rgba(255,0,255,.7), -6px 0 0 rgba(0,255,255,.7); }
  81% { transform: translate(1px, -1px); text-shadow: 6px 0 0 rgba(255,0,255,.7), -1px 0 0 rgba(0,255,255,.7); }
  7%  { transform: translate(-1px, 1px); text-shadow: 1px 0 0 rgba(255,0,255,.7), -8px 0 4px rgba(0,255,255,.7); }
}
</style>
