<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, defineAsyncComponent } from 'vue';

// Der TechRadar wird asynchron geladen, um die Ladezeit (LCP) zu verbessern.
const TechRadar = defineAsyncComponent(() => import('@/components/TechRadar.vue'));

// Diese Option behebt die Konsolen-Warnung bezüglich der "extraneous non-props attributes".
defineOptions({
  layout: AppLayout,
  inheritAttrs: false,
});

// KORREKTUR: Wir definieren hier die exakte Struktur (Interface), die der TechRadar erwartet.
interface Skill {
  name: string;
  ring: 'core' | 'proficient' | 'exploring';
  color: string;
  logoUrl: string;
  description: string;
}

// KORREKTUR: Wir weisen TypeScript an, die 'skills'-Konstante anhand der 'Skill'-Struktur zu überprüfen.
const skills: Skill[] = [
  { name: 'Laravel', ring: 'core', color: '#FF2D20', logoUrl: 'https://cdn.simpleicons.org/laravel/white', description: 'Mein bevorzugtes PHP-Framework für robuste und skalierbare Backend-Anwendungen.' },
  { name: 'Vue.js', ring: 'core', color: '#4FC08D', logoUrl: 'https://cdn.simpleicons.org/vuedotjs/white', description: 'Für reaktive und moderne Benutzeroberflächen setze ich auf die Flexibilität von Vue.' },
  { name: 'PHP', ring: 'core', color: '#777BB4', logoUrl: 'https://cdn.simpleicons.org/php/white', description: 'Die Sprache, in der ich die meiste Erfahrung habe und mich am wohlsten fühle.' },
  { name: 'MySQL', ring: 'core', color: '#4479A1', logoUrl: 'https://cdn.simpleicons.org/mysql/white', description: 'Meine erste Wahl für relationale Datenbanken und komplexe Datenstrukturen.' },
  { name: 'Tailwind CSS', ring: 'proficient', color: '#06B6D4', logoUrl: 'https://cdn.simpleicons.org/tailwindcss/white', description: 'Ein Utility-First-Framework, das schnelles und konsistentes UI-Design ermöglicht.' },
  { name: 'Inertia.js', ring: 'proficient', color: '#9553E9', logoUrl: 'https://cdn.simpleicons.org/inertia/white', description: 'Die perfekte Brücke, um moderne Single-Page-Apps mit einem klassischen Laravel-Backend zu bauen.' },
  { name: 'JavaScript', ring: 'proficient', color: '#F7DF1E', logoUrl: 'https://cdn.simpleicons.org/javascript/black', description: 'Umfassende Kenntnisse in modernem JavaScript (ES6+) für dynamische Frontend-Logik.' },
  { name: 'Git', ring: 'proficient', color: '#F05032', logoUrl: 'https://cdn.simpleicons.org/git/white', description: 'Versionskontrolle ist für mich ein unverzichtbarer Teil des Entwicklungsprozesses.' },
  { name: 'Docker', ring: 'proficient', color: '#2496ED', logoUrl: 'https://cdn.simpleicons.org/docker/white', description: 'Ich nutze Docker für konsistente und isolierte Entwicklungsumgebungen.' },
  { name: 'Python', ring: 'exploring', color: '#3776AB', logoUrl: 'https://cdn.simpleicons.org/python/white', description: 'Ich erkunde Python für Datenanalyse und kleine Automatisierungs-Skripte.' },
  { name: 'Three.js', ring: 'exploring', color: '#000000', logoUrl: 'https://cdn.simpleicons.org/threedotjs/white', description: 'Mein Einstieg in die Welt der 3D-Grafik im Browser für visuell beeindruckende Erlebnisse.' },
  { name: 'TypeScript', ring: 'exploring', color: '#3178C6', logoUrl: 'https://cdn.simpleicons.org/typescript/white', description: 'Für größere Projekte schätze ich die Typsicherheit und verbesserte Code-Qualität von TypeScript.' },
];

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

</script>

<template>
    <Head title="Über mich" />

    <div class="space-y-8 py-12 px-4 sm:px-6 lg:px-32">
        <!-- Sektion 1: Persönliche Vorstellung mit Bild -->
        <section class="p-4 sm:p-10 bg-gray-100 dark:bg-slate-800/50 rounded-xl shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                <div class="md:col-span-1">
                    <img 
                        :src="profileImageUrl" 
                        alt="Profilbild von Dennis" 
                        class="rounded-full mx-auto w-48 h-48 lg:w-64 lg:h-64 object-cover border-4 border-white dark:border-slate-700 shadow-md"
                        onerror="this.onerror=null;this.src='https://placehold.co/256x256/E2E8F0/475569?text=Bild';"
                        width="256" height="256"
                        decoding="async"
                        loading="lazy"
                        fetchpriority="low"
                    >
                </div>
                <div class="md:col-span-2 md:text-left mb:break-normal ">
                    <h1 class="text-3xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white md:break-pretty">
                        Code mit Charakter - durchdacht, klar und mit Liebe zum Detail
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 dark:text-gray-400 text-pretty break-normal">
                        Hallo, ich bin Dennis Strauß.<br><br>
                        Schon während meiner Ausbildung, die ich 2025 erfolgreich abgeschlossen habe, war mir klar: Ich will nicht nur Software entwickeln – ich will Probleme lösen, die das Leben einfacher, smarter und schöner machen.
                        <br>
                        Technologie begeistert mich, weil sie so viel mehr kann als nur „funktionieren“: Sie kann Menschen verbinden, Prozesse vereinfachen und neue Ideen zum Leben erwecken.
                        <br><br>
                        Mein Weg hat mich von den Grundlagen der Informatik bis hin zur Entwicklung moderner Webanwendungen geführt – mit Frameworks wie Laravel und Vue.js, die mir helfen, durchdachte und nutzerfreundliche Lösungen zu bauen.
                        <br><br>
                        Neugierig? Scroll gerne weiter – ich freu mich, wenn du mehr über mich und meine Arbeit erfahren möchtest.


                    </p>
                </div>
            </div>
        </section>

        <!-- Sektion 2: Tech Radar -->
        <section class="p-4 sm:p-10 bg-gray-100 dark:bg-slate-800/50 rounded-xl shadow-lg">
            <h2 class="md:text-center text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Meine technologischen Schwerpunkte</h2>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 md:text-center">
                Ein interaktiver Überblick über die Werkzeuge und Technologien,<br> mit denen ich arbeite und experimentiere.
            </p>
            <div ref="radarContainer" class=" flex items-center justify-center">
                <TechRadar v-if="showRadar" :skills="skills" />
                <div v-else class="flex items-center justify-center h-full min-h-[550px] sm:min-h-[750px]">
                    <svg class="animate-spin h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </section>

        <!-- Sektion 3: Meine Arbeitsphilosophie -->
        <section class="p-4 sm:p-10 bg-gray-100 dark:bg-slate-800/50 rounded-xl shadow-lg">
            <h2 class="text-2xl sm:text-3xl font-bold text-center text-gray-900 dark:text-white">Meine Arbeitsphilosophie</h2>
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6 bg-gray-50 dark:bg-slate-800 rounded-xl">
                    <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-indigo-500 text-white mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                    </div>
                    <h3 class="mt-5 text-lg font-medium text-gray-900 dark:text-white">Kreative Problemlösung</h3>
                    <p class="mt-2 text-base text-gray-600 dark:text-gray-400">Ich liebe es, komplexe Herausforderungen in elegante und effiziente Lösungen zu verwandeln.</p>
                </div>
                <div class="p-6 bg-gray-50 dark:bg-slate-800 rounded-xl">
                    <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-indigo-500 text-white mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                    </div>
                    <h3 class="mt-5 text-lg font-medium text-gray-900 dark:text-white">Sauberer & modularer Code</h3>
                    <p class="mt-2 text-base text-gray-600 dark:text-gray-400">Wartbarkeit und Skalierbarkeit sind für mich das Fundament jedes guten Projekts.</p>
                </div>
                <div class="p-6 bg-gray-50 dark:bg-slate-800 rounded-xl">
                     <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-indigo-500 text-white mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                     </div>
                    <h3 class="mt-5 text-lg font-medium text-gray-900 dark:text-white">Teamarbeit & Kommunikation</h3>
                    <p class="mt-2 text-base text-gray-600 dark:text-gray-400">Offener Austausch und klares Feedback sind der Schlüssel für erfolgreiche Projekte.</p>
                </div>
            </div>
        </section>

        <!-- Sektion 4: Call to Action -->
        <section class="md:text-center max-w-3xl mx-auto p-4 bg-gray-100 dark:bg-slate-800/50 rounded-2xl shadow-lg">
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                Klingt interessant?
            </h2>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                Ich bin immer offen für neue Herausforderungen und spannende Projekte. <br> Lassen Sie uns reden!
            </p>
            <div class="mt-8 flex justify-center gap-4">
                <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Lebenslauf ansehen
                </a>
                <Link :href="route('contactform')" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:text-white dark:bg-indigo-500 dark:hover:bg-indigo-600">
                    Kontakt aufnehmen
                </Link>
            </div>
        </section>
    </div>
</template>
