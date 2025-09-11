<script setup lang="ts">
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';


// 1. Zentrale Design-Konfiguration
const designConfig = {
  triggerFlagClasses: 'w-6 h-auto rounded-sm',
  dropdownFlagClasses: 'w-5 h-auto rounded-sm',
  dropdownContentClasses: 'max-h-[220px] overflow-y-auto',
};


// 2. Basis-Konfiguration der Sprachen (ohne Text)
// Diese Liste enthält nur noch die technischen Informationen.
// Die sichtbaren Namen (labels) kommen aus den JSON-Dateien.
const languageConfig = [
  { code: 'de', flagUrl: '/images/flags/de.svg' },
  { code: 'en', flagUrl: '/images/flags/gb.svg' },
  { code: 'us', flagUrl: '/images/flags/us.svg' },
  { code: 'es', flagUrl: '/images/flags/es.svg' },
  { code: 'fr', flagUrl: '/images/flags/fr.svg' },
  { code: 'it', flagUrl: '/images/flags/it.svg' },
  { code: 'at', flagUrl: '/images/flags/at.svg' },
  { code: 'ch', flagUrl: '/images/flags/ch.svg' },
  { code: 'no', flagUrl: '/images/flags/bv.svg' },
  { code: 'sw', flagUrl: '/images/flags/se.svg' },
  { code: 'th', flagUrl: '/images/flags/th.svg' },
  { code: 'jp', flagUrl: '/images/flags/jp.svg' },
  { code: 'ps', flagUrl: '/images/flags/ps.svg' },
  { code: 'cn', flagUrl: '/images/flags/cn.svg' },
  { code: 'vn', flagUrl: '/images/flags/vn.svg' },
  { code: 'tr', flagUrl: '/images/flags/tr.svg' },
  { code: 'kr', flagUrl: '/images/flags/kr.svg' },
  { code: 'ph', flagUrl: '/images/flags/ph.svg' },
  { code: 'ae', flagUrl: '/images/flags/ae.svg' },
];


// 3. Logik
const { t, locale } = useI18n();
const csrfToken = (usePage().props as any).csrf_token;

// `supportedLanguages` ist eine `computed`-Eigenschaft.
// Sie nimmt die Basis-Konfiguration und fügt die übersetzten Labels hinzu.
const supportedLanguages = computed(() => {
    return languageConfig.map(lang => ({
        ...lang,
        label: t(`languages.${lang.code}`) // Holt z.B. den Text für "languages.de"
    }));
});

async function switchLanguage(newLocale: string) {
  locale.value = newLocale;
  try {
    await fetch('/api/locale/switch', {
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

const currentLanguage = computed(() => {
  return supportedLanguages.value.find(lang => lang.code === locale.value) || supportedLanguages.value[0];
});

const triggerAriaLabel = computed(() => {
    return t('nav.language_switcher.aria_label', { language: currentLanguage.value.label });
});
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" size="icon" class="h-10 w-10" :aria-label="triggerAriaLabel">
        <img
          :src="currentLanguage.flagUrl"
          :alt="currentLanguage.label"
          :class="designConfig.triggerFlagClasses"
          aria-hidden="true"
        />
      </Button>
    </DropdownMenuTrigger>

    <DropdownMenuContent
      align="end"
      :side-offset="8"
      :class="designConfig.dropdownContentClasses"
    >
      <DropdownMenuLabel class="sr-only">{{ $t('nav.language_switcher.menu_label') }}</DropdownMenuLabel>
      
      <DropdownMenuItem
        v-for="lang in supportedLanguages"
        :key="lang.code"
        @click="switchLanguage(lang.code)"
        class="flex items-center gap-3 cursor-pointer p-2 focus:bg-accent focus:text-accent-foreground"
        :class="{ 'bg-accent': locale === lang.code }"
      >
        <img
          :src="lang.flagUrl"
          :alt="lang.label"
          :class="designConfig.dropdownFlagClasses"
          aria-hidden="true"
        />
        <span>{{ lang.label }}</span>
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
