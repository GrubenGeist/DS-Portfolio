<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { Button } from '@/components/ui/button';
import Hero3D from '@/components/Hero3D.vue';
import InfoCard from '@/components/InfoCard.vue'; 
import DividingLine from '@/components/DividingLine.vue';

import Teaser from '@/components/Teaser.vue';

// ----------------------------Images Imports------------------------------------------------
const projectImageUrl = '/images/Projects.png';
const contactImageUrl = '/images/ContactUs.png';
const certificatesImageUrl = '/images/Certificates.png';
// Lade hier ein professionelles, quadratisches Bild von dir in den `/public/images/`-Ordner
const profileImageUrl = '/images/selfie.png'; 

//Ein Array mit den Wörtern, die im 3D-Raum fliegen sollen
const techWords = [
    'Laravel', 'PHP', 'Vue.js', 'JavaScript (JS)', 'TypeScript',
    'HTML5', 'CSS3', 'MySQL', 'Inertia.js', 'TailwindCSS',
    'API', 'Clean Code', 'Git', 'Variable',
    'Security', 'Testing', 'Agile','Bug Fixing', 'Web Applications', 'Structure',
    'Backend','Backup','Authentifizierung','Debugging','Docker',
    'Framework','Frontend','HTTPS','Webserver','VPN (Virtual Private Network)','Development',
    'Domain', 'Mobile First','Cookie Consent',
];


</script>

<template>
    <Head title="Portfolio von Dennis Strauß" />
    <AppLayout>
        <div class="flex-1">
            <section
                class=" relative h-screen w-full flex items-center justify-center text-center overflow-hidden text-black dark:text-white"
                :style=" 'bg-transparent' "
                style="background-size: cover; background-position: center;"
                >
                <div class="absolute inset-0 bg-transparent"></div>
                
                <Hero3D :words="techWords" />

                <div class="relative z-10 flex flex-col bg-gray-900/40 dark:bg-gray-600/100 p-8 rounded-md items-center text-black dark:text-white">
                    <h1 class="text-yellow-300 dark:text-white text-5xl md:text-7xl font-extrabold tracking-tight" style=" text-shadow: 0 0 20px rgba(0,0,0,0.7);">
                        Dennis Strauß
                    </h1>
                    <p class="text-yellow-300 dark:text-white mt-4 text-lg md:text-xl max-w-2xl mx-auto " style="text-shadow: 0 0 10px rgba(0,0,0,0.7);">
                        Digitale Erlebnisse, die begeistern.
                    </p>
                    <div class="mt-8"> <!--@click="handleProjectsClick" ist für die Google Analytics -->
                        <Link 
                            :href="route('projects')" 
                            v-track-click="{ category: 'Startseite', label: 'Projekte entdecken' }">
                            <Button size="lg" class="bg-cyan-500 hover:bg-cyan-600 text-white shadow-lg">
                                Projekte entdecken
                            </Button>
                        </Link>
                    </div>
                </div>
            </section>

            <Teaser 
                headline="Kreativer Anwendungsentwickler mit Fokus auf sauberen Code"
                :paragraphs="[
                    'Hallo, ich bin Dennis Strauß, ein Anwendungsentwickler mit Fokus auf maßgeschneiderte Softwarelösungen.',
                    'Mit fundierten Kenntnissen in modernen Technologien wie Laravel, Drupal, Python, JavaScript und mehr sowie einem klaren Blick für sauberen, wartbaren Code entwickle ich leistungsstarke Anwendungen, die Prozesse optimieren und Nutzer begeistern.',
                    'Hier finden Sie eine Auswahl meiner bisherigen Projekte, technischer Schwerpunkte und Informationen zu meinem beruflichen Werdegang. Ich freue mich, wenn Sie einen Einblick in meine Arbeit gewinnen und vielleicht schon bald den passenden Partner für Ihr nächstes Softwareprojekt gefunden haben.',
                    
                ]"
                portraitImageUrl="/images/elements/TemplateDude.png"
                backgroundImageUrl="/images/elements/BgStartseitePortrait.png"
                :backgroundHeight="'170%'"
                :backgroundPositionX="'76%'"
                :portraitPositionX="'65%'"
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
                            <h2 class="text-2xl bg-blue-900 dark:bg-blue-900  md:ml-32 md:mr-32 p-4 rounded-xl md:text-4xl font-bold border-2 dark:text-white text-white mb-4 text-center ">
                                Ein Blick auf meine Arbeit & mehr
                            </h2>
                        </div>
                        <div id="card_panel" class="flex-1 mt-0 dar:bg-transparent p-0">

                          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-11 gap-6 md:ml-24 md:mr-24 justify-items-center" style="perspective: 2000px;">
                               <!-- Wir tracken den Klick auf die "Projekte"-Karte -->
                                  <InfoCard
                                      :image-url="projectImageUrl"
                                      title="Meine Projekte"
                                      description= "Entdescken Sie eine Auswahl meiner bisherigen Projekte"
                                      button-text="Projekte ansehen"
                                      :button-href="route('projects')"
                                      :tags="['Laravel', 'Vue', 'PHP']" 
                                  /> 
                                  <!--
                                      Dient zum Tracken von Elementen wenn du ein neues Element Tracken möchtest ändere das Label
                                      ein Import ist nicht nötig da die trackClick.ts Direktive das übernimmt
                                      v-track-click="{ category: 'Info Cards', label: 'Projekte' }" 
                                  --> 
                                  <!-- Wir tracken den Klick auf die "Kontakt"-Karte -->
                                  <InfoCard
                                      :image-url="contactImageUrl"
                                      title="Web-Development"
                                      description="Haben Sie eine Frage oder eine Projektidee?"
                                      button-text="Zum Kontaktformular"
                                      :button-href="route('contactform')"
                                      :tags="['Kommunikation', 'Beratung']"

                                  />
                                  <!-- Wir tracken den Klick auf die "Zertifikate"-Karte -->
                                  <InfoCard
                                      :image-url="certificatesImageUrl"
                                      title="Zertifikate"
                                      description="Ein Überblick über meine Qualifikationen"
                                      button-text="Zertifikate ansehen"
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