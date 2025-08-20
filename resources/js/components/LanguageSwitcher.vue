<script setup lang="ts">
import { useI18n } from 'vue-i18n';
import { Button } from '@/components/ui/button';
import { usePage } from '@inertiajs/vue3';

const { locale } = useI18n();

// Holt das CSRF-Token, das von Laravel über die 'share' Methode in HandleInertiaRequests.php geteilt wird.
// Dieses Token ist für sichere POST-Anfragen notwendig.
const csrfToken = (usePage().props as any).csrf_token;

async function switchLanguage(newLocale: 'en' | 'de') {
  // 1. Sprache im Frontend SOFORT ändern
  locale.value = newLocale;

  // 2. Server im Hintergrund mit einer stabilen 'fetch'-Anfrage informieren
  try {
    await fetch('/api/locale/switch', { // Wir rufen unsere neue API-Route auf
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json',
      },
      body: JSON.stringify({ locale: newLocale }),
    });
  } catch (error) {
    console.error('Fehler beim Speichern der Sprache:', error);
  }
}
</script>

<template>
  <div class="flex items-center space-x-1">
    <Button 
      @click="switchLanguage('de')" 
      variant="ghost" 
      size="sm"
      class="p-2 dark:bg-yellow-400 dark:text-black"
      :class="{ 'font-bold underline': locale === 'de' }"
      aria-label="Sprache auf Deutsch umstellen"
    >
      DE
    </Button>
    <Button 
      @click="switchLanguage('en')" 
      variant="ghost" 
      size="sm"
      class="p-2 dark:bg-yellow-400 dark:text-black"
      :class="{ 'font-bold underline': locale === 'en' }"
      aria-label="Switch language to English"
    >
      EN
    </Button>
  </div>
</template>