<script setup lang="ts">
import AppHeaderLayout from '@/layouts/app/AppHeaderLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import Footer from '@/components/Footer.vue';
import CookieBanner from '@/components/CookieBanner.vue';
import FlashMessage from '@/components/FlashMessage.vue';

// --- KORREKTUR 1: Fehlende Imports hinzufügen ---
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppHeaderLayout :breadcrumbs="breadcrumbs">
        <slot />
        <br>
    </AppHeaderLayout>

    <div><FlashMessage /></div>

    <Footer>
        <div class="grid grid-cols-1 px-2 md:place-items-center md:grid-cols-3 lg:grid-cols-4  gap-10">

          <div class="space-y-3">
            <h3 class="font-bold text-lg text-gray-900 dark:text-white">Motto</h3>
            <p class="text-sm ">
              Wachse immer ein Stück über dich Hinaus!
            </p>
          </div>

          <div class="space-y-3">
            <h3 class="font-bold text-lg text-gray-900 dark:text-white">Rechtliches</h3>
            <ul class="space-y-2 text-sm">
              <li><Link :href="route('welcome')" v-track-click="{ category: 'Footer', label: 'Impressum' }" class="hover:text-blue-500">Impressum</Link></li>
              <li><Link :href="route('welcome')" v-track-click="{ category: 'Footer', label: 'Datenschutzerklärung' }" class="hover:text-blue-500">Datenschutzerklärung</Link></li>
            </ul>
          </div>

          <div class="space-y-3">
            <h3 class="font-bold text-lg text-gray-900 dark:text-white">Socialmedia</h3>
            <ul class="space-y-2 text-sm">
              <li><a href="https://www.linkedin.com/in/dennis-strauß-902a69220/" v-track-click="{ category: 'Footer', label: 'LinkedIn' }" target="_blank" rel="noopener noreferrer">LinkedIn</a></li>
              <li><a href="https://www.linkedin.com/in/dennis-strauß-902a69220/" v-track-click="{ category: 'Footer', label: 'Instagram' }" target="_blank" rel="noopener noreferrer">Instagram</a></li>
            </ul>
          </div>

          <div class="space-y-3">
            <h3 class="font-bold text-lg text-gray-900 dark:text-white">Kontakt</h3>
             <p class="text-sm">
              <ul><li><Link :href="route('contactform')" v-track-click="{ category: 'Footer', label: 'Kontaktformular' }" class="hover:text-blue-500">Kontakt</Link></li></ul><br>
                Fragen oder Projektideen? <br>
                <a href="mailto:dennis-strauss@web.de" v-track-click="{ category: 'Footer', label: 'Kontaktformular' }" class="text-blue-600 dark:text-blue-400 hover:underline">
                  dennis-strauss@web.de
                </a>
             </p>
          </div>

        </div>

        <div class="mt-10 pt-8 border-t border-gray-300 dark:border-gray-700 text-center text-sm">
          <p>&copy; {{ new Date().getFullYear() }} Dennis Strauß. Alle Rechte vorbehalten.</p>
        </div>
      </Footer>
      <CookieBanner />
</template>
