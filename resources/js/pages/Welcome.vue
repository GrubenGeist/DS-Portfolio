<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { Button } from '@/components/ui/button';
import Hero3D from '@/components/Hero3D.vue';
import InfoCard from '@/components/InfoCard.vue'; // Pfad anpassen, falls nötig

// ----------------------------Images Imports------------------------------------------------
import projectImageUrl from '/public/images/Projects.png'; // Passe den relativen Pfad ggf. an
import contactImageUrl from '/public/images/ContactUs.png';
import certificatesImageUrl from '/public/images/Certificates.png';

// NEU: Ein Array mit den Wörtern, die im 3D-Raum fliegen sollen
const techWords = [
    'Laravel', 'PHP', 'Vue.js', 'JavaScript', 'TypeScript',
    'HTML5', 'CSS3', 'MySQL', 'Inertia.js', 'TailwindCSS',
    'API', 'Clean Code', 'Git', 'Docker',
    'Security', 'Testing', 'Agile','Bug Fixing', 'Web App', 'Structure','<div>','class=" "','42',
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
                        Anwendungsentwickler für moderne und performante Web-Lösungen.
                    </p>
                    <div class="mt-8">
                        <Link :href="route('projects')">
                            <Button size="lg" class="bg-cyan-500 hover:bg-cyan-600 text-white shadow-lg">
                                Projekte entdecken
                            </Button>
                        </Link>
                    </div>
                </div>
            </section>
            
            <section class="py-20 bg-transparent border-2 rounded-xl">
                <div class="text-center text-black dark:text-white">
                  <h2 class="text-3xl font-bold">Weitere Inhalte hier...</h2>

                  <div id="card_panel" class="flex-1 mt-8 p-10 bg-muted dark:border-r rounded-xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center" style="perspective: 2000px;">
                    
                        <InfoCard
                            :image-url="projectImageUrl"
                            title="Python"
                            description="Entdecken Sie eine Auswahl meiner bisherigen Arbeiten, von Webanwendungen bis hin zu komplexen Systemintegrationen."
                            button-text="Projekte ansehen"
                            :button-href="'/projects'"
                            :tags="['Laravel', 'Vue', 'PHP']"
                        />
                    
                        <InfoCard
                            :image-url="contactImageUrl"
                            title="Web-Development"
                            description="Haben Sie eine Frage oder eine Projektidee? Zögern Sie nicht, mich zu kontaktieren. Ich freue mich auf Ihre Nachricht."
                            button-text="Zum Kontaktformular"
                            :button-href="'/contactform'"
                            :tags="['Kommunikation', 'Beratung']"
                        />
                    
                        <InfoCard
                            :image-url="certificatesImageUrl"
                            title="C++"
                            description="Ein Überblick über meine Qualifikationen, Zertifikate und die Technologien, mit denen ich täglich arbeite."
                            button-text="Mehr erfahren"
                            :button-href="'/projects'"
                            :tags="['Qualifikation', 'Weiterbildung']"
                        />
                    
                        </div>
                    </div>
                </div>    
            </section>
        </div>
    
    </AppLayout>
</template>