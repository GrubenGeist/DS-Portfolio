<script setup lang="ts">
// Bestehende Imports
import AppLogo from '@/components/AppLogo.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

// =======================================================
// HIER IST DER FEHLENDE IMPORT FÜR DAS PFEIL-ICON
import { ArrowLeft } from 'lucide-vue-next';
// =======================================================

const page = usePage();
const name = page.props.name;
const quote = page.props.quote;

defineProps<{
    title?: string;
    description?: string;
}>();

const goBack = () => {
    window.history.back();
};
</script>

<template>
    <div class="grid min-h-dvh grid-cols-1 lg:grid-cols-2">

        <div class="flex flex-col items-center justify-center bg-zinc-900 p-10 text-white lg:h-full">
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