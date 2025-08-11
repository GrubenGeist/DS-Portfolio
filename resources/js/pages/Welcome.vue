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
            
            <div class="py-0 flex-1">
                <section class="bg-slate-100 dark:bg-slate-900 bg-transparent md:border-2 rounded-xl p-6 md:p-16">
                    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 items-center">
                        <!-- Bild-Spalte -->
                        <div class="md:col-span-1 flex justify-center">
                            <div class="relative w-48 h-48 md:w-64 md:h-64">
                                <div class="absolute inset-0 bg-cyan-500 rounded-full transform rotate-6"></div>
                                <img :src="profileImageUrl" alt="Dennis Strauß" class="relative w-full h-full rounded-full object-cover border-4 border-white dark:border-slate-800 shadow-lg">
                            </div>
                        </div>

                        <!-- Text-Spalte -->
                        <div class="md:col-span-2 text-center md:text-left">
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                                Willkommen auf meinem Portfolio
                            </h2>
                            <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                                Hallo, Ich bin Dennis Strauß, Anwendungsentwickler mit Fokus auf maßgeschneiderte Softwarelösungen.<br/><br/>
                                Mit fundierten Kenntnissen in modernen Technologien und einem klaren Blick für sauberen, wartbaren Code entwickle ich leistungsstarke Anwendungen, die Prozesse optimieren und Nutzer begeistern.<br/><br/>

                                Hier finden Sie eine Auswahl meiner bisherigen Projekte, technische Schwerpunkte und Informationen zu meinem beruflichen Werdegang.<br/>
                                Ich freue mich, wenn Sie einen Einblick in meine Arbeit gewinnen – und vielleicht schon bald den passenden Partner für Ihr nächstes Softwareprojekt gefunden haben.
                            </p>
                        </div>
                    </div>
                </section>
            </div>
        
            <div class="py-6 flex-1">
                <div class="flex-1">
                    <section class="bg-transparent  rounded-xl md:p-6 ">
                        <div id="card_panel" class="flex-1 mt-0 p-0 dar:bg-transparent dark:border-r rounded-md">
                                <h2 class="text-2xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4 text-center">
                                    Weitere Inhalte finden Sie hier:
                                </h2>
                          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-4 gap-4 md:ml-36 md:mr-36 md:p-4 pt-4 pb-4 justify-items-center" style="perspective: 2000px;">
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