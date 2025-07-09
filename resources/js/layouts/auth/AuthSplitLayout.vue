<script setup lang="ts">
// =============================================================================
// IMPORTS
// Hier laden wir alle Bausteine, die wir für dieses Layout benötigen.
// =============================================================================

// Eigene Komponenten
import AppLogo from '@/components/AppLogo.vue';
// Vue & Inertia-Helfer
import { Link, usePage } from '@inertiajs/vue3';
// UI-Komponenten (unser Button)
import { Button } from '@/components/ui/button';
// Icon-Komponente aus der lucide-Bibliothek
import { ArrowLeft } from 'lucide-vue-next';

// `usePage` gibt uns Zugriff auf Daten, die vom Backend kommen.
const page = usePage();
const name = page.props.name;
const quote = page.props.quote;

// `defineProps` legt fest, welche "Eingabewerte" dieses Layout von außen
// annehmen kann, z.B. von der Register.vue-Seite.
defineProps<{
    title?: string;       // Der Haupttitel (z.B. "Erstelle dein Account")
    description?: string; // Die Beschreibung unter dem Titel
}>();

// Diese Funktion wird aufgerufen, wenn der Zurück-Pfeil geklickt wird.
const goBack = () => {
    // Nutzt die Standard-Funktion des Browsers, um eine Seite zurückzugehen.
    window.history.back();
};
</script>

<template>
    <div class="grid min-h-dvh grid-cols-1 lg:grid-cols-2">

        <div class="relative flex h-48 flex-col items-center justify-center bg-zinc-900 p-10 text-white lg:h-full">
            
            <AppLogo class="h-24 w-24 text-white" />

        </div>


        <div class="relative flex items-center justify-center p-8">

            <Button
                @click="goBack"
                variant="ghost"
                size="icon"
                class="absolute top-4 left-4"
            >
                <ArrowLeft class="h-5 w-5" />
                <span class="sr-only">Zurück</span>
            </Button>

            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                
                <div class="flex flex-col space-y-2 text-center">
                    <h1 class="text-xl font-medium tracking-tight" v-if="title">{{ title }}</h1>
                    <p class="text-sm text-muted-foreground" v-if="description">{{ description }}</p>
                </div>
                
                <slot />
            </div>

        </div>
    </div>
</template>