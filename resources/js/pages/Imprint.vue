<!-- /resources/js/Pages/Imprint.vue -->

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

defineOptions({ layout: AppLayout });

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

// Die "Schablone" (Interface) für unsere Abschnitte.
interface ImprintSection {
    titleKey: string;
    contentKey: string;
    titleClass?: string;
    contentClass?: string;
}

// Die STRUKTUR der Seite wird hier definiert.
// Der INHALT wird reaktiv aus den JSON-Dateien geladen.
const imprintSections = computed<ImprintSection[]>(() => [
    {
        titleKey: 'imprint.s1.title',
        contentKey: 'imprint.s1.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'imprint.s2.title',
        contentKey: 'imprint.s2.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'imprint.s3.title',
        contentKey: 'imprint.s3.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'imprint.s4.title',
        contentKey: 'imprint.s4.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'imprint.s5.title',
        contentKey: 'imprint.s5.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'imprint.s6.title',
        contentKey: 'imprint.s6.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
    {
        titleKey: 'imprint.s7.title',
        contentKey: 'imprint.s7.content',
        titleClass: 'font-semibold',
        contentClass:'text-sm',
    },
]);
</script>

<template>
    <Head :title="t('imprint.head_title')" />
    
    <!-- Der Hauptcontainer für die Seite -->
    <div class="container mx-auto md:py-20">
        <!-- Die Inhalts-Karte -->
        <div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 rounded-lg shadow-2xl overflow-hidden">
            
            <!-- Der Header mit Farbverlauf und Hintergrund-Icon -->
            <div class="relative bg-gradient-to-br from-blue-700 to-blue-800 p-8 md:p-12 overflow-hidden">
                <!-- Das Icon liegt im Hintergrund -->
                <div class="absolute -bottom-12 -right-12 text-white opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-2"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                </div>

                <!-- Der Text liegt mit z-10 im Vordergrund -->
                <div class="relative z-10">
                    <h1 class="text-3xl md:text-4xl font-bold text-white">
                        {{ $t('imprint.main_headline') }}
                    </h1>
                    <p class="mt-2 text-blue-200">{{ $t('imprint.sub_headline') }}</p>
                </div>
            </div>

            <!-- Der eigentliche Textinhalt auf weißem/dunklem Hintergrund -->
            <div class="p-8 md:p-12 prose dark:prose-invert max-w-none">
                <!-- Das Template rendert den Inhalt jetzt dynamisch aus der Datenstruktur -->
                <div v-for="(section, index) in imprintSections" :key="index" class="mb-8 last:mb-0">
                    <h2 :class="section.titleClass">{{ t(section.titleKey) }}</h2>
                    <div 
                        v-for="(paragraph, pIndex) in t(section.contentKey).split('<br>')" 
                        :key="pIndex" 
                        v-html="paragraph" 
                        class="text-gray-700 dark:text-gray-300"
                        :class="section.contentClass"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>
