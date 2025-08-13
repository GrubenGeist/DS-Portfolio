<script setup lang="ts">
import { computed } from 'vue';

// defineProps macht die Komponente wiederverwendbar.
// Alle Aspekte der Trennlinie können jetzt von außen gesteuert werden.
const props = withDefaults(defineProps<{
    // Die Farbe der Linie (erwartet eine TailwindCSS 'bg-' Klasse)
    color?: string;
    // Die Dicke der Linie (erwartet eine TailwindCSS 'h-' Klasse)
    thickness?: string;
    // Die Deckkraft der Linie (erwartet eine TailwindCSS 'opacity-' Klasse)
    opacity?: string;
    // Die Breite der Linie (erwartet eine TailwindCSS 'w-' Klasse)
    width?: string;
    // Der vertikale Abstand (erwartet eine TailwindCSS 'my-' oder 'py-' Klasse)
    margin?: string;
}>(), {
    // Standardwerte für alle Props
    color: 'bg-gray-200 dark:bg-gray-700',
    thickness: 'h-px', // Standardmäßig 1 Pixel hoch
    opacity: 'opacity-100', // Standardmäßig voll sichtbar
    width: 'w-full', // Standardmäßig volle Breite
    margin: 'my-16', // Standardmäßig großer vertikaler Abstand
});

// Stellt die Klassen für den äußeren Container zusammen, der für den Abstand sorgt.
const containerClasses = computed(() => {
    return [
        'flex justify-center', // Zentriert die Linie, falls die Breite nicht 100% ist
        props.margin
    ];
});

// Stellt die Klassen für die eigentliche Linie zusammen.
const lineClasses = computed(() => {
    return [
        props.width,
        props.thickness,
        props.color,
        props.opacity,
    ];
});
</script>

<template>
    <!-- Der äußere Container ist nur für den Abstand (margin) und die Zentrierung zuständig. -->
    <div :class="containerClasses">
        <!-- Dies ist die eigentliche, sichtbare Trennlinie. -->
        <div :class="lineClasses"></div>
    </div>
</template>


<!-- Einbindung der DivingLine.vue

    <script setup lang="ts">
import DividingLine from '@/components/DividingLine.vue';
import Teaser from '@/components/Teaser.vue';
</script>

<template>
    <!-- Beispiel 1: Standard-Trennlinie 
    <Teaser />
    <DividingLine />
    <InfoCards />

    <!-- Beispiel 2: Eine dicke, blaue und halbtransparente Linie mit weniger Abstand 
    <Teaser />
    <DividingLine 
        color="bg-blue-500"
        thickness="h-1"
        opacity="opacity-50"
        width="w-1/2"
        margin="my-8"
    />
    <InfoCards />

    <!-- Beispiel 3: Eine sehr feine, fast unsichtbare Linie 
    <Teaser />
    <DividingLine 
        thickness="h-px"
        opacity="opacity-25"
    />
    <InfoCards />
</template>


-->