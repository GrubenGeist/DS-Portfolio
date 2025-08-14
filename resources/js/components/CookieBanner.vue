<script setup lang="ts">
import { ref } from 'vue';
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
// KORREKTUR: Wir importieren die zentrale Logik
import { useConsent } from '@/composables/useConsent';

// Holt die globalen Consent-Funktionen und den Zustand aus unserem Composable
const { consentState, saveConsent } = useConsent();

// Zustand, ob das Einstellungs-Modal sichtbar ist
const showSettingsModal = ref(false);

// Lokaler Zustand nur für die Schalter im Modal
const localSwitches = ref({
  analytics: consentState.analytics,
  marketing: consentState.marketing,
});

// Funktion, um alle Cookies zu akzeptieren
const acceptAll = () => {
  // Ruft die zentrale Speicherfunktion auf
  saveConsent({
    analytics: true,
    marketing: true,
  });
};

// Funktion, um die aktuelle Auswahl aus dem Modal zu speichern
const saveSelection = () => {
  // Ruft die zentrale Speicherfunktion mit den Werten aus den Schaltern auf
  saveConsent({
    analytics: localSwitches.value.analytics,
    marketing: localSwitches.value.marketing,
  });
  showSettingsModal.value = false; // Modal schließen
};
</script>

<template>
  <!-- Der Banner wird nur angezeigt, wenn 'bannerVisible' aus dem globalen Zustand true ist -->
  <Transition
    enter-active-class="transition ease-out duration-300"
    enter-from-class="transform translate-y-full opacity-0"
    enter-to-class="transform translate-y-0 opacity-100"
    leave-active-class="transition ease-in duration-200"
    leave-from-class="transform translate-y-0 opacity-100"
    leave-to-class="transform translate-y-full opacity-0"
  >
    <div v-if="consentState.bannerVisible" class="fixed bottom-0 inset-x-0 z-50 p-4">
      <div class="max-w-7xl mx-auto p-6 bg-background/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-lg shadow-2xl border border-border">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
          <div class="flex items-start gap-4">
            <Cookie class="h-8 w-8 text-primary flex-shrink-0 mt-1" />
            <div>
              <h3 class="font-semibold">Cookie-Einstellungen</h3>
              <p class="text-sm text-foreground/80 mt-1">
                Diese Seite verwendet Cookies, um die Benutzerfreundlichkeit zu verbessern. Du kannst deine Auswahl jederzeit anpassen.
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

  <!-- Das Einstellungs-Modal -->
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
          <Switch id="analytics-cookies" v-model:checked="localSwitches.analytics" />
        </div>
        <div class="flex items-center justify-between">
          <Label for="marketing-cookies" class="cursor-pointer">Marketing-Cookies</Label>
          <Switch id="marketing-cookies" v-model:checked="localSwitches.marketing" />
        </div>
      </div>
      <DialogFooter>
        <!-- Der Button ruft jetzt die korrigierte Speicherfunktion auf -->
        <Button @click="saveSelection">Auswahl speichern</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
