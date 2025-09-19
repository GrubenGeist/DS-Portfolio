<script setup lang="ts">
import { computed } from 'vue'; 
import { useI18n } from 'vue-i18n'; 
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
    <Head title="DS" />
    <AppLayout>
        <div class="flex-1">
            <section
                class=" relative h-[90vh] w-full flex items-center justify-center text-center overflow-hidden text-black dark:text-white"
                >
                <div class="absolute inset-0 bg-transparent"></div>

                <Hero3D :words="techWords" />

                <div class="dark:bg-yellow-400 relative z-10 flex flex-col bg-blue-900/100  p-8 rounded-md items-center text-black dark:text-black">
                    <h1 class="text-white dark:text-black text-5xl md:text-7xl font-extrabold tracking-tight">
                        Dennis Strauß
                    </h1>
                    <p class="text-white dark:text-black mt-4 text-lg md:text-xl max-w-2xl mx-auto ">
                        {{ heroSubtitle }}
                    </p>
                    <div class="mt-8">
                        <Link
                          :href="route('projects')"
                          v-track-click="{ category: 'Startseite', label: 'Projekte entdecken', requireConsent: true }"
                          class="inline-flex items-center justify-center rounded-lg dark:bg-orange-500 dark:hover:bg-orange-400 bg-green-500 hover:bg-green-400  text-black shadow-lg px-6 py-2 text-lg font-medium"
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
                 backgroundImageLightUrl="/images/elements/BgTeaserPortraitLight.png"
                 backgroundImageDarkUrl="/images/elements/BgTeaserPortraitDark.png"
                :backgroundHeight="'170%'"
                :backgroundPositionX="'76%'"
                :portraitPositionX="'60%'"
                :portraitPositionY="'-0.5%'"
                :enableAnimation="true"

                patternLightColor="text-blue-400"
                patternDarkColor="text-yellow-300"
                patternOpacity="opacity-40"
            />

            <DividingLine
                color="bg-blue-500 dark:bg-yellow-400"
                thickness="h-0.5"
                opacity="opacity-20"
                width="w-9/12"
                margin="mb-16 mt-16"
            />
            <section class="bg-transparent  rounded-xl md:pl-32 md:pr-32 mb-8">
                <div id="card_panel-headline" class="flex-1 mt-0 mb-0 p-0 dark:bg-transparent">
                    <h2
                    class="text-2xl bg-blue-900 dark:bg-yellow-400 dark:text-black text-white md:ml-28 md:mr-28 p-4 rounded-xl md:text-4xl font-bold border-2 mb-4 text-center">
                        {{ infocardsHeadline }}
                    </h2>
                </div>
                <div id="card_panel" class="flex-1 mt-0 dark:bg-transparent">
                  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-11 gap-6 md:ml-28 md:mr-28 justify-items-center" style="perspective: 3000px;">
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
                <DividingLine
                    color="bg-blue-500 dark:bg-yellow-400"
                    thickness="h-0.5"
                    opacity="opacity-0"
                    width="w-9/12"
                    margin="mb-16 mt-16"
                />
            </section>
        </div>        
    </AppLayout>
</template>