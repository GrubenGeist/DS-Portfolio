<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, defineAsyncComponent, computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { type BreadcrumbItem } from '@/types';
import Teaser from '@/components/Teaser.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const currentUser = computed(() => page.props.auth?.user ?? null);

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

// Der TechRadar wird asynchron geladen, um die Ladezeit (LCP) zu verbessern.
const TechRadar = defineAsyncComponent(() => import('@/components/TechRadar.vue'));

interface Skill {
  name: string;
  ring: 'core' | 'proficient' | 'exploring';
  color: string;
  logoUrl: string;
  description: string;
}

const skills = computed<Skill[]>(() => [
  { name: 'Laravel', ring: 'core', color: '#FF2D20', logoUrl: 'https://cdn.simpleicons.org/laravel/white', description: t('aboutme.skills.laravel') },
  { name: 'Vue.js', ring: 'core', color: '#4FC08D', logoUrl: 'https://cdn.simpleicons.org/vuedotjs/white', description: t('aboutme.skills.vue') },
  { name: 'PHP', ring: 'core', color: '#777BB4', logoUrl: 'https://cdn.simpleicons.org/php/white', description: t('aboutme.skills.php') },
  { name: 'MySQL', ring: 'core', color: '#4479A1', logoUrl: 'https://cdn.simpleicons.org/mysql/white', description: t('aboutme.skills.mysql') },
  { name: 'Tailwind CSS', ring: 'proficient', color: '#06B6D4', logoUrl: 'https://cdn.simpleicons.org/tailwindcss/white', description: t('aboutme.skills.tailwind') },
  { name: 'Inertia.js', ring: 'proficient', color: '#9553E9', logoUrl: 'https://cdn.simpleicons.org/inertia/white', description: t('aboutme.skills.inertia') },
  { name: 'JavaScript', ring: 'proficient', color: '#F7DF1E', logoUrl: 'https://cdn.simpleicons.org/javascript/black', description: t('aboutme.skills.javascript') },
  { name: 'Git', ring: 'proficient', color: '#F05032', logoUrl: 'https://cdn.simpleicons.org/git/white', description: t('aboutme.skills.git') },
  { name: 'Docker', ring: 'proficient', color: '#2496ED', logoUrl: 'https://cdn.simpleicons.org/docker/white', description: t('aboutme.skills.docker') },
  { name: 'Python', ring: 'exploring', color: '#3776AB', logoUrl: 'https://cdn.simpleicons.org/python/white', description: t('aboutme.skills.python') },
  { name: 'Three.js', ring: 'exploring', color: '#000000', logoUrl: 'https://cdn.simpleicons.org/threedotjs/white', description: t('aboutme.skills.threejs') },
  { name: 'TypeScript', ring: 'exploring', color: '#3178C6', logoUrl: 'https://cdn.simpleicons.org/typescript/white', description: t('aboutme.skills.typescript') },
]);

const profileImageUrl = '/images/selfie.png';

const radarContainer = ref<HTMLElement | null>(null);
const showRadar = ref(false);
let observer: IntersectionObserver | null = null;

onMounted(() => {
  if (radarContainer.value) {
    observer = new IntersectionObserver(
      (entries) => {
        if (entries[0].isIntersecting) {
          showRadar.value = true;
          observer?.disconnect();
        }
      },
      { threshold: 0.1 }
    );
    observer.observe(radarContainer.value);
  }
});

onUnmounted(() => {
  if (observer) {
    observer.disconnect();
  }
});

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    {
        title: t('aboutme.breadcrumb'),
        href: route('aboutme'),
    },
]);

// Teaser Sektion
const teaserHeadline1 = computed(() => t('aboutme.teaser.headline'));
const teasersubHeadline1 = computed(() => t('aboutme.teaser.subheadline'));
const teaserParagraphs1 = computed(() => [
    t('aboutme.teaser.p1'),
    t('aboutme.teaser.p2'),
    t('aboutme.teaser.p3'),
    t('aboutme.teaser.p4'),
    t('aboutme.teaser.p5'),
]);

</script>

<template>
  <Head :title="t('aboutme.head_title')" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="space-y-16 py-12 px-4 sm:px-6 lg:px-32">

      <!-- Hero Intro -->
      <section class="relative grid grid-cols-1 md:grid-cols-1 gap-12 items-center">
        <!-- Bild -->
        <Teaser :imagePosition="'left'"
                :headline="teaserHeadline1"
                :subheadline="teasersubHeadline1"
                :showSubheadline="true"
                :paragraphs="teaserParagraphs1"
                 portraitImageUrl="/images/elements/TeaserBildDennis.png"
                 backgroundImageLightUrl="/images/elements/BgTeaserPortraitLight.png"
                 backgroundImageDarkUrl="/images/elements/BgTeaserPortraitDark.png"
                :backgroundHeight="'170%'"
                :backgroundPositionX="'76%'"
                :portraitPositionX="'60%'"
                :portraitPositionY="'-0.5%'"
                :enableAnimation="true"
        />
        <!-- Text -->
        <div>
          <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-6">
            {{ $t('aboutme.intro.headline') }}
          </h1>
          <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed space-y-4">
            {{ $t('aboutme.intro.p1') }}<br><br>
            {{ $t('aboutme.intro.p2') }}<br><br>
            {{ $t('aboutme.intro.p3') }}
          </p>
        </div>
      </section>

      <!-- Tech Radar -->
      <section class="bg-white dark:bg-stone-800 rounded-2xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-yellow-400">
          {{ $t('aboutme.tech_radar.headline') }}
        </h2>
        <p class="mt-4 text-lg text-center text-gray-600 dark:text-gray-300" v-html="t('aboutme.tech_radar.description')"></p>
        <div ref="radarContainer" class="mt-10 flex items-center justify-center">
          <TechRadar v-if="showRadar" :skills="skills" />
          <div v-else class="flex items-center justify-center h-[550px] sm:h-[750px]">
            <!-- Loader -->
            <svg class="animate-spin h-10 w-10 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0..."/>
            </svg>
          </div>
        </div>
      </section>

      <!-- Arbeitsphilosophie -->
      <section>
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white">
          {{ $t('aboutme.philosophy.headline') }}
        </h2>
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="p-6 rounded-xl shadow-md bg-gray-50 dark:bg-yellow-400/10 hover:scale-105 transition">
            <h3 class="text-xl font-semibold text-blue-900 dark:text-yellow-400 mb-3">
              {{ $t('aboutme.philosophy.item1_title') }}
            </h3>
            <p class="text-gray-600 dark:text-gray-300">{{ $t('aboutme.philosophy.item1_desc') }}</p>
          </div>
          <!-- item2 & item3 analog -->
        </div>
      </section>

      <!-- Call to Action -->
      <section class="text-center bg-blue-50 dark:bg-stone-800 rounded-2xl shadow-lg p-10">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
          {{ $t('aboutme.cta.headline') }}
        </h2>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-300" v-html="t('aboutme.cta.description')"></p>
        <div class="mt-8 flex justify-center gap-4">
          <a v-if="currentUser" href="#"
             class="px-6 py-3 rounded-full font-bold bg-yellow-400 text-black hover:bg-yellow-300 transition">
            {{ $t('aboutme.cta.button_cv') }}
          </a>
          <Link :href="route('contactform')"
             class="px-6 py-3 rounded-full font-bold bg-blue-900 text-white hover:bg-blue-700 transition">
            {{ $t('aboutme.cta.button_contact') }}
          </Link>
        </div>
      </section>

    </div>
  </AppLayout>
</template>

