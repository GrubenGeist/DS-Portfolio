<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dienstleistungen',
        href: '/services',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex-1 container mx-auto dark:border-r md:text-center">
            <section class="my-10" aria-labelledby="slider-heading">
                <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-8 bg-muted dark:border-r md:text-center rounded-xl">
                        <div class="col-span-2 md:col-span-2 dark:text-white pl-1 md:place-items-center pr-1 md:text-justify border-1-8 border-transparent rounded-md shadow-md space-y-1 text-2xl font-bold bg-muted">
                            <section class="services panel">
                                <h2>Meine Dienstleistungen</h2>
                                <p>
                                    Irgendwann bin Ich auch Selbstständig und biete Vereinzelt Dienstleistungen an, 
                                    in den Bereichen 3D-Druck, Websitegestaltung, Website Programmierung und Außerdem Handle ich mit verschiedenster Technik Hardware vielleicht wer weis :P. 
                                </p>
                                <p>
                                </p>
                                <p>
                                
                                </p>
                            </section>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>


<style>

/* Über mich */

.services {
    margin: 40px;
}

.services h2 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

.services p {
    font-size: 16px;
    color: #666;
    line-height: 1.5;
    margin-bottom: 20px;
}

</style>