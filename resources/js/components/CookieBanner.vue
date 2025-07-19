<script setup lang="ts">
import { ref, onMounted, reactive } from 'vue';
import { Button } from '@/components/ui/button';
import { Cookie } from 'lucide-vue-next';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { route } from 'ziggy-js'; // Wichtig: Ziggy für die Route importieren

// Zustand, ob der Banner oder das Modal sichtbar ist
const showBanner = ref(false);
const showSettingsModal = ref(false);

// Das reaktive Objekt für die Zustimmungen
const consent = reactive({
  necessary: true,
  analytics: false,
  marketing: false,
});

// =============================================================================
// NEUE FUNKTION: Sendet die Zustimmung an dein Backend
// =============================================================================
async function logConsent(data: { analytics: boolean, marketing: boolean }) {
    try {
        // Wir lesen den CSRF-Token aus dem <meta>-Tag, den Laravel bereitstellt.
        const csrfToken = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content;

        await fetch(route('api.consent.store'), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken || '', // Token wird hier mitgeschickt
            },
            body: JSON.stringify(data),
        });
    } catch (error) {
        console.error('Konnte die Zustimmung nicht protokollieren:', error);
    }
}

// Funktion, um alle Cookies zu akzeptieren
const acceptAll = () => {
  consent.analytics = true;
  consent.marketing = true;
  saveConsent();
};

// Funktion, um die aktuelle Auswahl zu speichern
const saveConsent = () => {
  // 1. Im Browser speichern
  localStorage.setItem('cookie_consent', JSON.stringify(consent));
  
  // 2. An das Backend senden
  logConsent({ analytics: consent.analytics, marketing: consent.marketing });
  
  // 3. Banner ausblenden
  showBanner.value = false;
  showSettingsModal.value = false;
};

// Beim Laden der Komponente prüfen, ob schon eine Zustimmung vorliegt
onMounted(() => {
  const savedConsent = localStorage.getItem('cookie_consent');
  if (savedConsent) {
    Object.assign(consent, JSON.parse(savedConsent));
  } else {
    showBanner.value = true;
  }
});
</script>

<template>
  <Transition
    enter-active-class="transition ease-out duration-300"
    enter-from-class="transform translate-y-full opacity-0"
    enter-to-class="transform translate-y-0 opacity-100"
    leave-active-class="transition ease-in duration-200"
    leave-from-class="transform translate-y-0 opacity-100"
    leave-to-class="transform translate-y-full opacity-0"
  >
    <div v-if="showBanner" class="fixed bottom-0 inset-x-0 z-50 p-4">
      <div class="max-w-7xl mx-auto p-6 bg-background/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-lg shadow-2xl border border-border">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
          <div class="flex items-start gap-4">
            <Cookie class="h-8 w-8 text-primary flex-shrink-0 mt-1" />
            <div>
              <h3 class="font-semibold">Cookie-Einstellungen</h3>
              <p class="text-sm text-foreground/80 mt-1">
                Wir verwenden Cookies, um die Benutzerfreundlichkeit zu verbessern. Du kannst deine Auswahl jederzeit anpassen.
              </p>
            </div>
          </div>
          <div class="flex gap-2 flex-shrink-0">
            <Button variant="outline" @click="showSettingsModal = true">Anpassen</Button>
            <Button @click="acceptAll">Alle akzeptieren</Button>
          </div>
        </div>
      </div>
    </div>
  </Transition>

  <Dialog :open="showSettingsModal" @update:open="showSettingsModal = $event">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>Cookie-Einstellungen anpassen</DialogTitle>
        <DialogDescription>
          Wähle aus, welche Arten von Cookies wir verwenden dürfen. Notwendige Cookies können nicht deaktiviert werden.
        </DialogDescription>
      </DialogHeader>
      <div class="space-y-4 py-4">
        <div class="flex items-center justify-between">
          <Label for="necessary-cookies" class="font-semibold">Notwendige Cookies</Label>
          <Switch id="necessary-cookies" :checked="true" disabled />
        </div>
        <div class="flex items-center justify-between">
          <Label for="analytics-cookies" class="cursor-pointer">Analyse-Cookies</Label>
          <Switch id="analytics-cookies" v-model:checked="consent.analytics" />
        </div>
        <div class="flex items-center justify-between">
          <Label for="marketing-cookies" class="cursor-pointer">Marketing-Cookies</Label>
          <Switch id="marketing-cookies" v-model:checked="consent.marketing" />
        </div>
      </div>
      <DialogFooter>
        <Button @click="saveConsent">Auswahl speichern</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>