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
    <section class="flex flex-col place-items-center md:flex-row">
        <div class="mb-6 md:mb-0 md:w-1/2 p-3 md:pl-10">
            <h1 class="mb-4 text-4xl font-bold text-gray-800">Hallo, ich bin Dennis Strauß</h1>
            <p class="text-lg text-gray-600">
                Ich bin ein erfahrener Webentwickler mit einer Leidenschaft für die Erstellung von benutzerfreundlichen und responsiven Websites.
            </p>
        </div>
        <div class="flex justify-end md:w-1/2">
            <img src="/public/images/bannertest.png" alt="Business Image" class="h-150 w-auto md:rounded-r-[0.5vw] mb:rounded-br-[2vw] mb:rounded-bl-[2vw]" />
        </div>
    </section>
</template>
