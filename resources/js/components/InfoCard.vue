<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue'; // <-- 1. ref importieren
import { useTilt } from '@/composables/useTilt'; // <-- 2. Unseren neuen Tilt-Composable importieren

// defineProps definiert die "Eigenschaften" (Props), die diese Komponente von außen annehmen kann.
// So machen wir sie wiederverwendbar.
defineProps<{
    imageUrl: string;      // Der Pfad zum Bild
    title: string;         // Der Titel der Karte
    description: string;   // Der Beschreibungstext
    buttonText: string;    // Der Text für den Button
    buttonHref: string;    // Die URL, zu der der Button führt
    tags?: string[];       // Eine optionale Liste von Tags
}>();

// 3. Eine Template-Referenz erstellen, um auf das DOM-Element zugreifen zu können
const cardElement = ref(null);

// 4. Unseren Composable aufrufen und ihm die Referenz übergeben
useTilt(cardElement);
</script>

<template>
    <div ref="cardElement" class="max-w-sm w-full dark:text-white border-1-8 border-transparent rounded-md shadow-md space-y-2 overflow-hidden bg-white dark:bg-gray-800">
        <img class="rounded-t-md p-0 w-full h-48 object-cover" :src="imageUrl" alt="Card Image">

        <div class="px-6 py-4">
            <div class="font-bold text-blue-600 dark:text-blue-400 text-xl mb-4">{{ title }}</div>

            <p class="text-gray-700 dark:text-gray-300 text-base">
                {{ description }}
            </p>
        </div>

        <div class="px-6 pb-5">
            <Link :href="buttonHref" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-full transition duration-300">
                {{ buttonText }}
            </Link>
        </div>

        <div v-if="tags && tags.length" class="px-6 pb-4">
            <span v-for="tag in tags" :key="tag" class="inline-block bg-gray-200 dark:bg-gray-700 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 dark:text-gray-200 mr-2 mb-2">
                #{{ tag }}
            </span>
        </div>
    </div>
</template>