<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import BannerWithImage from '../components/BannerWithImage.vue';
import AppLogoIcon from '../components/AppLogoIcon.vue';
import InfoCard from '@/components/InfoCard.vue'; // Pfad anpassen, falls nötig

// ----------------------------Images Imports------------------------------------------------
import projectImageUrl from '/public/images/Projects.png'; // Passe den relativen Pfad ggf. an
import contactImageUrl from '/public/images/ContactUs.png';
import certificatesImageUrl from '/public/images/Certificates.png';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Über Mich',
        href: '/aboutme',
    },
];
</script>

<template>
    <Head title="About Me" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex-1 container mx-auto dark:border-r md:text-center">
            <section class="my-10" aria-labelledby="slider-heading">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-8 bg-muted dark:border-r md:text-center rounded-xl">
                        <div class="col-span-2 md:col-span-2 dark:text-white md:place-items-center md:text-justify border-1-8 border-transparent rounded-md shadow-md space-y-1 text-2xl font-bold bg-muted">
                            <BannerWithImage/>
                        </div>
                </div>
                    
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-8 dark:border-r md:text-center rounded-xl">
                <div class="col-span-1 md:col-span-1 dark:text-white pl-1 md:place-items-center pr-1 md:text-justify border-1-8 border-transparent rounded-md shadow-md space-y-1 text-2xl font-bold bg-muted">
                        <section class="about-me">
                            <h2>TEXT</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,
                            </p>
                        </section>
                    </div>
                    <div class="col-span-1 md:col-span-1 dark:text-white pl-1 md:place-items-center pr-1 md:text-justify border-1-8 border-transparent rounded-md shadow-md space-y-1 text-2xl font-bold bg-muted">
                        <section class="about-me">
                            <h2>TEXT</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,
                            </p>
                        </section>
                    </div>
                    <div class="col-span-1 md:col-span-1 dark:text-white pl-1 md:place-items-center pr-1 md:text-justify border-1-8 border-transparent rounded-md shadow-md space-y-1 text-2xl font-bold bg-muted">
                        <section class="about-me">
                            <h2>TEXT</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,
                            </p>
                        </section>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-8 bg-muted dark:border-r md:text-center rounded-xl">
                    <div class="col-span-2 md:col-span-2 dark:text-white pl-1 md:place-items-center pr-1 md:text-justify border-1-8 border-transparent rounded-md shadow-md space-y-1 text-2xl font-bold bg-muted">
                        <section class="about-me">
                            <h2>TEXT</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a,
                            </p>
                            <p>
                                Ich bin ein Teamplayer und arbeite gerne in einem dynamischen Umfeld. Ich bin zuverlässig, organisiert und habe ein Auge für
                                Details. Ich bin außerdem ein ausgezeichneter Kommunikator und kann meine Ideen klar und präzise vermitteln.
                            </p>
                            <p>
                            
                            </p>
                        </section>
                    </div>



                
                </div>
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
            </section>
        </div>
    </AppLayout>
</template>

<style>
/* TEXT */

.about-me {
    margin: 40px;
}

.about-me h2 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

.about-me p {
    font-size: 16px;
    color: #666;
    line-height: 1.5;
    margin-bottom: 20px;
}


</style>
