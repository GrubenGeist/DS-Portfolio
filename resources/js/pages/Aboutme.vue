<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import BannerWithImage from '../components/BannerWithImage.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Über Mich',
        href: '/aboutme',
    },
];
</script>

<template>
    <Head title="Abou Me" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3"></div>
            <div class="container">
                <BannerWithImage>
                    <p>TEST</p>
                </BannerWithImage>

                <section class="about-me">
                    <h2>Über mich</h2>
                    <p>
                        Ich bin seit über 10 Jahren als Webentwickler tätig und habe an einer Vielzahl von Projekten gearbeitet, von kleinen Websites
                        bis hin zu großen Webanwendungen. Ich besitze umfassende Kenntnisse in HTML, CSS, JavaScript, PHP und Laravel und bin stets
                        bestrebt, meine Fähigkeiten auf dem neuesten Stand zu halten.
                    </p>
                    <p>
                        Ich bin ein Teamplayer und arbeite gerne in einem dynamischen Umfeld. Ich bin zuverlässig, organisiert und habe ein Auge für
                        Details. Ich bin außerdem ein ausgezeichneter Kommunikator und kann meine Ideen klar und präzise vermitteln.
                    </p>
                    <p>In meiner Freizeit interessiere ich mich für Fotografie, Reisen und Lesen.</p>
                </section>
                <section class="skills">
                    <h2>Meine Fähigkeiten</h2>
                    <div class="card-container">
                        <div class="card">
                            <h3>Webentwicklung</h3>
                            <p>HTML, CSS, JavaScript, PHP, Laravel</p>
                        </div>
                        <div class="card">
                            <h3>Design</h3>
                            <p>Responsive Design, User Experience (UX), Grafikdesign</p>
                        </div>
                        <div class="card">
                            <h3>SEO</h3>
                            <p>Suchmaschinenoptimierung (SEO), Content-Marketing</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </AppLayout>
</template>

<style>
/* Allgemeine Stile */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Über mich */

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

/* Fähigkeiten */

.skills {
    margin: 40px;
}

.skills h2 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

.card-container {
    display: flex;
    justify-content: space-between;
}

.card {
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 20px;
    width: 300px;
    height: 200px;
    text-align: center;
}

.card h3 {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.card p {
    font-size: 14px;
    color: #666;
}
</style>
