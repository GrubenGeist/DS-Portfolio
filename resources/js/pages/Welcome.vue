<script setup lang="ts">
// Importieren der notwendigen Komponenten und Funktionen
import { route } from 'ziggy-js'; // Ziggy für das Routing in Laravel
import AppLayout from '@/layouts/AppLayout.vue'; // Das Haupt-Layout der Seite
import { Head, Link } from '@inertiajs/vue3'; // Inertia-Komponenten für SEO und Navigation
import WebsiteLogoIcon from '@/components/WebsiteLogoIcon.vue'; // Dein Logo als Komponente
import { BreadcrumbItem } from '@/types'; // Typ-Definition für die Breadcrumbs

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

        <div class="w-full grid place-items-center mx-auto bg-muted p-10 dark:border-r">
            <WebsiteLogoIcon />
        </div>

        <div class="flex-1 container mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-8 bg-muted p-10 dark:border-r md:text-center">
                <h1 class="md:col-span-2 p-4 pr-6 dark:text-white text-justify border-1-8 border-transparent rounded-md shadow-md space-y-2 text-4xl font-bold bg-muted">Willkommen auf meinem Portfolio</h1>
                <p class="md:col-span-2 p-4 pr-6 dark:text-white text-justify border-1-8 border-transparent rounded-md shadow-md space-y-2 text-2xl">
                    Sie suchen einen IT-Anwendungsentwickler, der Ihre Visionen in strukturierten Code verwandelt? <br><br>
                    Hallo, ich bin Dennis Strauß. Als kreativer und lösungsorientierter Anwendungsentwickler helfe ich Unternehmen und Organisationen dabei, ihre digitalen Ziele zu erreichen.<br><br>
                    Mein Schwerpunkt liegt auf der Webentwicklung in den Programmiersprachen PHP, JavaScript, HTML, CSS, Typescript und den Frameworks Laravel, Drupal, TypO3, WordPress.<br><br>
                    Ich glaube an sauberen und gut strukturierten Code, durchdachte Architekturen und eine transparente Kommunikation und planung von Prozessen.<br><br> Lassen Sie uns gemeinsam herausfinden, wie ich Ihr nächstes Projekt zum Erfolg führen kann.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-8 bg-muted p-10 dark:border-r">
                <h1 class="md:col-span-2 p-4 pr-6 dark:text-white border-1-8 border-transparent rounded-md shadow-md space-y-2 text-4xl font-bold bg-muted">Subtext 1 H1</h1>
                <p class="md:col-span-2 p-4 pr-6 dark:text-white border-1-8 border-transparent rounded-md shadow-md space-y-2 text-3xl">
                    Text Abschnitt
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-8 bg-muted p-10 dark:border-r">
                <h1 class="md:col-span-2 p-4 pr-6 border-1-8 border-transparent rounded-md shadow-md space-y-2 text-4xl dark:text-white font-bold bg-muted">Subtext 2 H1</h1>
                <p class="md:col-span-2 p-4 pr-6 border-1-8 border-transparent rounded-md shadow-md space-y-2 text-2xl dark:text-white">
                    Text Abschnitt
                </p>
            </div>

<!----------------------------------------------------------------------------------------------------------------------------------------------->

            <div id="card_panel" class="flex-1 mt-8 p-10 bg-muted font-bold dark:border-r rounded">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                  <ul class="list-firstcard">
                              <li>
                                    <div class="max-w-sm sm:col-span-2 lg:col-span-3 dark:text-white border-1-8 border-transparent rounded-md shadow-md space-y-2">
                                      <img class="rounded-md p-0 w-full" src="../images/Projects.png" alt="projects-icon">
                                      <div class="px-6 py-4 rounded-md">
                                        <div class="text-lg font-bold dark:text-blue text-blue text-xl mb-4">Erfahren Sie mehr über meine Fähigkeiten und Projekte:</div>
                                        <p class="text-lg text-black dark:text-white text-wrap text-gray-700 text-base">
                                        Melden Sie sich jetzt an und Erfahren sie mit welchen Projekten ich mich bereits beschäftigt habe, oder sich noch in der Pipeline befinden. 
                                        </p>
                                      </div>
                                      <div class="grid pt-5 pb-5 pl-20 pr-20">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-0 rounded-full" onclick="document.location='/projects'">Hier Klicken!</button>
                                      </div>

                                      <div class="px-6 pt-4 pb-2">
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
                                      </div>
                                    </div>
                                </li>
                            </ul>

                    <ul class="list-secondcard">
                              <li>
                                    <div class="max-w-sm sm:col-span-2 lg:col-span-3 dark:text-white border-1-8 border-transparent rounded-md shadow-md space-y-2">
                                      <img class="rounded-md p-0 w-full" src="../images/ContactUs.png" alt="ContactUs.png">
                                      <div class="px-6 py-4 rounded-md">
                                        <div class="text-lg font-bold dark:text-blue text-blue text-xl mb-4">Gerne können sie mich auch Kontaktieren:</div>
                                        <p class="text-lg text-black dark:text-white text-wrap text-gray-700 text-base">
                                        Melden Sie sich jetzt an und Erfahren sie mit welchen Projekten ich mich bereits beschäftigt habe, oder sich noch in der Pipeline befinden. 
                                        </p>
                                      </div>
                                      <div class="grid pt-5 pb-5 pl-20 pr-20">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-0 rounded-full" onclick="document.location='/contactform'">Hier Klicken!</button>
                                      </div>

                                      <div class="px-6 pt-4 pb-2">
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
                                      </div>
                                    </div>
                                </li>
                            </ul>

                                      
                            <ul class="list-thirdcard">
                              <li>
                                    <div class="max-w-sm sm:col-span-2 lg:col-span-3 dark:text-white border-1-8 border-transparent rounded-md shadow-md space-y-2">
                                      <img class="rounded-md p-0 w-full" src="../images/Certificates.png" alt="Certificates.png">
                                      <div class="px-6 py-4 rounded-md">
                                        <div class="text-lg font-bold dark:text-blue text-blue text-xl mb-4">Erfahren Sie mehr über meine Fähigkeiten und Projekte:</div>
                                        <p class="text-lg text-black dark:text-white text-wrap text-gray-700 text-base">
                                        Melden Sie sich jetzt an und Erfahren sie mit welchen Projekten ich mich bereits beschäftigt habe, oder sich noch in der Pipeline befinden. 
                                        </p>
                                      </div>
                                      <div class="grid pt-5 pb-5 pl-20 pr-20">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-0 rounded-full" onclick="document.location='/projects'">Hier Klicken!</button>
                                      </div>

                                      <div class="px-6 pt-4 pb-2">
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
                                      </div>
                                    </div>
                                </li>
                            </ul>
                                        
                </div>
            </div>
        </div>


        <template #footer>
            <div id="site-footer" class="w-full text-3xl dark:text-blue font-bold bg-muted p-10 dark:border-r">
                <p class="text-sm">Kontaktiere mich bei Fragen unter: <a href="mailto: dennis-strauss@web.de" class="-500">dennis-strauss@web.de</a></p>
            </div>



        </template>

    </AppLayout>
</template>