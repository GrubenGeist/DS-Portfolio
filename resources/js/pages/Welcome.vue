<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { Button } from '@/components/ui/button';
import Hero3D from '@/components/Hero3D.vue';
import InfoCard from '@/components/InfoCard.vue'; // Pfad anpassen, falls nötig

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
                        Anwendungsentwickler für moderne und performante <br/> Web-Anwendungen.
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
            
            <section class="py-20 bg-transparent md:border-2 rounded-xl md:p-16 ">
                <div class="text-center text-black dark:text-white md:p-16 md:pl-8 md:pr-8 ">
                    <div class=" dark:text-white text-black md:pr-16 md:pl-16 md:pt-16 md:pb-8 md:text-center col-span-1 md:col-span-1 pl-1 border-1-8 border-transparent rounded-md shadow-md space-y-1 text-2xl font-bold bg-muted">
                     <!-- <h2 class="md:text-3xl text-2xl bg-gray-600 font-bold md:p-8 p-4 border-2 rounded-md ">Weitere Inhalte gibt es hier</h2> -->
                    </div>    
                        <div class="col-span-1 md:col-span-1 pt-4 dark:text-white md:pr-16 md:pl-16 md:pt-8 md:pb-8 pl-1 md:place-items-center  md:text-justify border-1-8 border-transparent rounded-md shadow-md space-y-1 text-2xl font-bold bg-muted">
                              <section class=" " id="welcometext">
                                  <h2 class="md:text-3xl text-xl bg-cyan-900 text-white font-bold p-8 border-2 rounded-md ">Willkommen auf meinem Portfolio</h2>
                                  <p class="md:text-1xl text-xl bg-gray-100 text-black  font-bold p-8 border-2 rounded-md  ">
                                    Ich bin Dennis Strauß,<br/><br/> Anwendungsentwickler mit Fokus auf maßgeschneiderte Softwarelösungen.<br/><br/>
                                    Mit fundierten Kenntnissen in modernen Technologien und einem klaren Blick für sauberen, wartbaren Code entwickle ich leistungsstarke Anwendungen, die Prozesse optimieren und Nutzer begeistern.<br/><br/>
                                    
                                    Hier finden Sie eine Auswahl meiner bisherigen Projekte, technische Schwerpunkte und Informationen zu meinem beruflichen Werdegang.<br/>
                                    Ich freue mich, wenn Sie einen Einblick in meine Arbeit gewinnen – und vielleicht schon bald den passenden Partner für Ihr nächstes Softwareprojekt gefunden haben.
                                  </p>
                              </section>
                          
                        

                  <div id="card_panel" class="flex-1 mt-0 p-0 bg-gray-100 dark:border-r rounded-md">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-44 gap-4 md:p-8 pt-4 pb-4 justify-items-center" style="perspective: 2000px;">
                    
                         <!-- Wir tracken den Klick auf die "Projekte"-Karte -->
                            <InfoCard
                                :image-url="projectImageUrl"
                                title="Meine Projekte"
                                description="Entdecken Sie eine Auswahl meiner bisherigen Arbeiten..."
                                button-text="Projekte ansehen"
                                :button-href="route('projects')"
                                :tags="['Laravel', 'Vue', 'PHP']"
                                v-track-click="{ category: 'Startseite', label: 'InfoCard Projekte' }" 
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
                                description="Haben Sie eine Frage oder eine Projektidee?..."
                                button-text="Zum Kontaktformular"
                                :button-href="route('contactform')"
                                :tags="['Kommunikation', 'Beratung']"
                                v-track-click="{ category: 'Startseite', label: 'InfoCard Kontakt' }"
                            />

                            <!-- Wir tracken den Klick auf die "Zertifikate"-Karte -->
                            <InfoCard
                                :image-url="certificatesImageUrl"
                                title="C++"
                                description="Ein Überblick über meine Qualifikationen..."
                                button-text="Mehr erfahren"
                                :button-href="route('projects')"
                                :tags="['Qualifikation', 'Weiterbildung']"
                                v-track-click="{ category: 'Startseite', label: 'InfoCard Zertifikate' }"
                            />
                    
                            </div>
                        </div>
                    </div>    
                </div>
            </section>
        </div>
    
    </AppLayout>
</template>