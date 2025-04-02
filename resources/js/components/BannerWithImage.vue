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
        <section class="flex flex-col md:flex-row items-center py-10">
          <div class="md:w-1/2 md:pr-8 mb-6 md:mb-0">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Hallo, ich bin Dennis Strauß</h1>
            <p class="text-lg text-gray-600">Ich bin ein erfahrener Webentwickler mit einer Leidenschaft für die Erstellung von benutzerfreundlichen und responsiven Websites.</p>
          </div>
          <div class="md:w-1/2 flex justify-center">
            <img src="https://placehold.co/300x300" alt="Dein Bild" class="rounded-full w-64 h-64">
          </div>
        </section>
</template>