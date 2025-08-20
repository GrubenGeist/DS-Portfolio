<script setup lang="ts">
import { computed } from 'vue'; // WICHTIG: computed importieren
import { useI18n } from 'vue-i18n'; // WICHTIG: useI18n importieren
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Hero3D from '@/components/Hero3D.vue';
import InfoCard from '@/components/InfoCard.vue';
import DividingLine from '@/components/DividingLine.vue';
import Teaser from '@/components/Teaser.vue';

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

// --- Übersetzte Texte als computed Properties definieren ---

// Hero Sektion
const heroSubtitle = computed(() => t('hero.subtitle'));
const heroButton = computed(() => t('hero.button'));

// Teaser Sektion
const teaserHeadline = computed(() => t('teaser.headline'));
const teaserParagraphs = computed(() => [
    t('teaser.p1'),
    t('teaser.p2'),
    t('teaser.p3'),
]);

// InfoCards Sektion
const infocardsHeadline = computed(() => t('infocards.headline'));

// ----------------------------Images Imports------------------------------------------------
const projectImageUrl = '/images/Projects.png';
const contactImageUrl = '/images/ContactUs.png';
const certificatesImageUrl = '/images/Certificates.png';

//Ein Array mit den Wörtern, die im 3D-Raum fliegen sollen
const techWords = [
    'Laravel', 'PHP', 'Vue.js', 'JavaScript (JS)', 'TypeScript',
    'HTML5', 'CSS3', 'MySQL', 'Inertia.js', 'TailwindCSS',
    'API', 'Clean Code', 'Git', 'Variable',
    'Security', 'Testing', 'Agile','Bug Fixing', 'Web Applications', 'Structure',
    'Backend','Backup','Authentifizierung','Debugging','Docker',
    'Framework','Frontend','HTTPS','Webserver','VPN (Virtual Private Network)','Development',
    'Domain', 'Mobile First','Cookie Consent','N8N','Kubernetes','Relaunch','Automatism','Workflows',
    'Teamplayer','creative coding',
];
</script>

<template>
    <Head title="Portfolio von Dennis Strauß" />
    <AppLayout>
        <div class="flex-1">
            <section
                class=" relative h-[90vh] w-full flex items-center justify-center text-center overflow-hidden text-black dark:text-white"
                >
                <div class="absolute inset-0 bg-transparent"></div>

                <Hero3D :words="techWords" />

                <div class="relative z-10 flex flex-col bg-blue-900/100 dark:bg-gray-600/100 p-8 rounded-md items-center text-black dark:text-white">
                    <h1 class="text-white dark:text-white text-5xl md:text-7xl font-extrabold tracking-tight" style=" text-shadow: 0 0 20px rgba(0,0,0,0.7);">
                        Dennis Strauß
                    </h1>
                    <p class="text-white dark:text-white mt-4 text-lg md:text-xl max-w-2xl mx-auto " style="text-shadow: 0 0 10px rgba(0,0,0,0.7);">
                        {{ heroSubtitle }}
                    </p>
                    <div class="mt-8">
                        <Link
                          :href="route('projects')"
                          v-track-click="{ category: 'Startseite', label: 'Projekte entdecken', requireConsent: true }"
                          class="inline-flex items-center justify-center rounded-lg bg-green-400 hover:bg-green-200 text-black shadow-lg px-6 py-2 text-lg font-medium"
                        >
                          {{ heroButton }}
                        </Link>
                    </div>
                </div>
            </section>

            <Teaser
                :headline="teaserHeadline"
                :paragraphs="teaserParagraphs"
                portraitImageUrl="/images/elements/TeaserBildDennis.png"
                backgroundImageUrl="/images/elements/BgStartseitePortrait.png"
                :backgroundHeight="'170%'"
                :backgroundPositionX="'76%'"
                :portraitPositionX="'60%'"
                :portraitPositionY="'-0.5%'"
                :enableAnimation="true"
            />

            <DividingLine
                color="bg-blue-500"
                thickness="h-0.5"
                opacity="opacity-20"
                width="w-3/6"
                margin="my-12 mt-20"
            />

            <div class="py-6 flex-1">
                <div class="flex-1">
                    <section class="bg-transparent  rounded-xl md:pl-32 md:pr-32">
                        <div id="card_panel-headline" class="flex-1 mt-0 mb-0 p-0 dark:bg-transparent">
                            <h2
                            class="text-2xl bg-blue-900 dark:bg-blue-900  md:ml-32 md:mr-32 p-4 rounded-xl md:text-4xl font-bold border-2 dark:text-white text-white mb-4 text-center">
                                {{ infocardsHeadline }}
                            </h2>
                        </div>
                        <div id="card_panel" class="flex-1 mt-0 dar:bg-transparent p-0">
                          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-11 gap-6 md:ml-24 md:mr-24 justify-items-center" style="perspective: 2000px;">
                                <InfoCard
                                    :image-url="projectImageUrl"
                                    :title="t('infocards.projects.title')"
                                    :description="t('infocards.projects.description')"
                                    :button-text="t('infocards.projects.button')"
                                    :button-href="route('projects')"
                                    :tags="['Laravel', 'Vue', 'PHP']"
                                />
                                <InfoCard
                                    :image-url="contactImageUrl"
                                    :title="t('infocards.contact.title')"
                                    :description="t('infocards.contact.description')"
                                    :button-text="t('infocards.contact.button')"
                                    :button-href="route('contactform')"
                                    :tags="['Kommunikation', 'Beratung']"
                                />
                                <InfoCard
                                    :image-url="certificatesImageUrl"
                                    :title="t('infocards.certificates.title')"
                                    :description="t('infocards.certificates.description')"
                                    :button-text="t('infocards.certificates.button')"
                                    :button-href="route('projects')"
                                    :tags="['Qualifikation', 'Weiterbildung']"
                                />
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>