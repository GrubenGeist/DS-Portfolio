<script setup lang="ts">
import { SidebarInset } from '@/components/ui/sidebar';
import { computed } from 'vue';

interface Props {
    variant?: 'header' | 'sidebar';
    class?: string;
}

const props = defineProps<Props>();
const className = computed(() => props.class);
</script>

<template>
    <SidebarInset v-if="props.variant === 'sidebar'" :class="className">
        <slot />
    </SidebarInset>
    <section class="flex flex-col items-center py-10 md:flex-row">
        <div class="mb-6 md:mb-0 md:w-1/2 md:pr-8">
            <h1 class="mb-4 text-4xl font-bold text-gray-800">Hallo, ich bin Dennis Strauß</h1>
            <p class="text-lg text-gray-600">
                Ich bin ein erfahrener Webentwickler mit einer Leidenschaft für die Erstellung von benutzerfreundlichen und responsiven Websites.
            </p>
        </div>
        <div class="flex justify-center md:w-1/2">
            <img src="../images/bannertest.png" alt="Dein Bild" class="h-64 w-64 rounded-full" />
        </div>
    </section>
</template>
