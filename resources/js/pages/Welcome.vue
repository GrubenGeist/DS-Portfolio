<script setup lang="ts">
// Importieren der notwendigen Komponenten und Funktionen
import { route } from 'ziggy-js'; // Ziggy für das Routing in Laravel
import AppLayout from '@/layouts/AppLayout.vue'; // Das Haupt-Layout der Seite
import { Head, Link } from '@inertiajs/vue3'; // Inertia-Komponenten für SEO und Navigation
import WebsiteLogoIcon from '@/components/WebsiteLogoIcon.vue'; // Dein Logo als Komponente
import { BreadcrumbItem } from '@/types'; // Typ-Definition für die Breadcrumbs
import InfoCard from '@/components/InfoCard.vue'; // Pfad anpassen, falls nötig

// ----------------------------Images Imports------------------------------------------------
import projectImageUrl from '../images/Projects.png'; // Passe den relativen Pfad ggf. an
import contactImageUrl from '../images/ContactUs.png';
import certificatesImageUrl from '../images/Certificates.png';

import Slider from '@/components/Slider.vue'; // <-- NEU: Slider importieren
// --- NEU: Bilder für den Slider importieren und Liste erstellen ---
import slideImage1 from '../images/slider/slider.png'; // Erstelle einen Ordner /resources/images/slider
import slideImage2 from '../images/slider/slider1.png';
import slideImage3 from '../images/slider/slider2.png';

const sliderImages = [
  { src: slideImage1, alt: 'Beschreibung für Bild 1, wichtig für Barrierefreiheit' },
  { src: slideImage2, alt: 'Beschreibung für Bild 2' },
  { src: slideImage3, alt: 'Beschreibung für Bild 3' },
];


// Definiert die Breadcrumb-Navigation für diese Seite
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Startseite',
        href: '/',
    },
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex-1 container mx-auto dark:border-r md:text-center">
            <section class="my-10" aria-labelledby="slider-heading">

                <Slider :images="sliderImages" />
            </section>
        </div>
        
        <div class="flex-1 container mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-8 bg-muted p-2 md:pr-96 md:pl-96 dark:border-r md:text-center">
                <h1 class="col-span-2 md:col-span-2 dark:text-white pl-1 pr-1 md:text-justify border-1-8 border-transparent rounded-md shadow-md space-y-1 text-2xl font-bold bg-muted">Willkommen auf meinem Portfolio</h1>
                <p class="col-span-2 md:col-span-2 p-2 dark:text-white md:text-justify  border-1-8 border-transparent rounded-md shadow-md space-y-2 text-m">
                    Sie suchen einen IT-Anwendungsentwickler, der Ihre Visionen in strukturierten Code verwandelt? <br><br>
                    Hallo, ich bin Dennis Strauß. Als kreativer und lösungsorientierter Anwendungsentwickler helfe ich Unternehmen und Organisationen dabei, ihre digitalen Ziele zu erreichen.<br><br>
                    Mein Schwerpunkt liegt auf der Webentwicklung in den Programmiersprachen PHP, JavaScript, HTML, CSS, Typescript und den Frameworks Laravel, Drupal, TypO3, WordPress.<br><br>
                    Ich glaube an sauberen und gut strukturierten Code, durchdachte Architekturen und eine transparente Kommunikation und planung von Prozessen.<br><br> Lassen Sie uns gemeinsam herausfinden, wie ich Ihr nächstes Projekt zum Erfolg führen kann.
                </p>
            </div>


<!----------------------------------------------------------------------------------------------------------------------------------------------->

<div id="card_panel" class="flex-1 mt-8 p-10 bg-muted dark:border-r rounded ">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center" style="perspective: 2000px;">
                
                    <InfoCard
                        :image-url="projectImageUrl"
                        title="Meine Projekte"
                        description="Entdecken Sie eine Auswahl meiner bisherigen Arbeiten, von Webanwendungen bis hin zu komplexen Systemintegrationen."
                        button-text="Projekte ansehen"
                        :button-href="'/projects'"
                        :tags="['Laravel', 'Vue', 'PHP']"
                    />
                
                    <InfoCard
                        :image-url="contactImageUrl"
                        title="Kontakt aufnehmen"
                        description="Haben Sie eine Frage oder eine Projektidee? Zögern Sie nicht, mich zu kontaktieren. Ich freue mich auf Ihre Nachricht."
                        button-text="Zum Kontaktformular"
                        :button-href="'/contactform'"
                        :tags="['Kommunikation', 'Beratung']"
                    />
                
                    <InfoCard
                        :image-url="certificatesImageUrl"
                        title="Zertifikate & Skills"
                        description="Ein Überblick über meine Qualifikationen, Zertifikate und die Technologien, mit denen ich täglich arbeite."
                        button-text="Mehr erfahren"
                        :button-href="'/projects'"
                        :tags="['Qualifikation', 'Weiterbildung']"
                    />
                
                </div>
            </div>
        </div>

        

    </AppLayout>
</template>