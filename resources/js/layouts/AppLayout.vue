<script setup lang="ts">
import AppHeaderLayout from '@/layouts/app/AppHeaderLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import Footer from '@/components/Footer.vue';
import CookieBanner from '@/components/CookieBanner.vue';
import FlashMessage from '@/components/FlashMessage.vue';
import { Link } from '@inertiajs/vue3';

interface Props { breadcrumbs?: BreadcrumbItemType[] }
withDefaults(defineProps<Props>(), { breadcrumbs: () => [] });
</script>

<template>
    <!-- Skip-Link ganz oben -->
    <div class="sr-only-focusable-div">
    <a href="#main" class="sr-only-focusable">
      {{ $t('layout.skip_to_content') }}
    </a>
    </div>
  <!-- Header-Layout inkl. Breadcrumbs -->
  <AppHeaderLayout :breadcrumbs="breadcrumbs">
    <!-- Hauptinhalt mit eindeutiger ID & Fokusziel -->
    <main id="main" tabindex="-1" role="main" class="focus:outline-none">
      <div><FlashMessage /></div>
      <slot />
    </main>
  </AppHeaderLayout>

  <!-- Footer -->
  <Footer>
    <div class="grid grid-cols-1 px-2 md:place-items-center md:grid-cols-3 lg:grid-cols-4 gap-10">
      <div class="space-y-3">
        <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $t('layout.footer.motto_headline') }}</h3>
        <p class="text-sm">{{ $t('layout.footer.motto_text') }}</p>
      </div>

      <div class="space-y-3">
        <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $t('layout.footer.legal_headline') }}</h3>
        <ul class="space-y-2 text-sm">
          <li>
            <Link
              :href="route('imprint')"
              v-track-click="{ category: 'Footer', label: 'Impressum', requireConsent: true }"
              class="hover:text-blue-500"
            >{{ $t('layout.footer.legal_imprint') }}</Link>
          </li>
          <li>
            <Link
              :href="route('privacy')"
              v-track-click="{ category: 'Footer', label: 'Datenschutzerklärung', requireConsent: true }"
              class="hover:text-blue-500"
            >{{ $t('layout.footer.legal_privacy') }}</Link>
          </li>
        </ul>
      </div>

      <div class="space-y-3">
        <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $t('layout.footer.social_headline') }}</h3>
        <ul class="space-y-2 text-sm">
          <li>
            <a
              href="https://www.linkedin.com/in/dennis-strauß-902a69220/"
              v-track-click="{ category: 'Footer', label: 'LinkedIn', requireConsent: true }"
              target="_blank" rel="noopener noreferrer"
            >{{ $t('layout.footer.social_linkedin') }}</a>
          </li>
          <li>
            <a
              href="https://www.linkedin.com/in/dennis-strauß-902a69220/"
              v-track-click="{ category: 'Footer', label: 'Instagram', requireConsent: true }"
              target="_blank" rel="noopener noreferrer"
            >{{ $t('layout.footer.social_instagram') }}</a>
          </li>
        </ul>
      </div>

      <div class="space-y-3">
        <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $t('layout.footer.contact_headline') }}</h3>
        <p class="text-sm">
          <ul>
            <li>
              <Link
                :href="route('contactform')"
                v-track-click="{ category: 'Footer', label: 'Kontaktformular', requireConsent: true }"
                class="hover:text-blue-500"
              >{{ $t('layout.footer.contact_link') }}</Link>
            </li>
          </ul>
          <br />
          {{ $t('layout.footer.contact_text') }} <br />
          <a
            href="mailto:dennis-strauss@web.de"
            v-track-click="{ category: 'Footer', label: 'E-Mail Link', requireConsent: true }"
            class="text-blue-600 dark:text-blue-400 hover:underline"
          >dennis-strauss@web.de</a>
        </p>
      </div>
    </div>

    <div class="mt-10 pt-8 border-t border-gray-300 dark:border-gray-700 text-center text-sm">
      <p>&copy; {{ new Date().getFullYear() }} {{ $t('layout.footer.copyright') }}</p>
    </div>
  </Footer>

  <CookieBanner />
</template>
