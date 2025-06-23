<script setup lang="ts">
import { ref, computed } from 'vue';

// =============================================================================
// PROPS (Eigenschaften)
// Die Komponente akzeptiert eine Liste (Array) von Bild-Objekten.
// Jedes Objekt muss eine 'src' (Bildquelle) und einen 'alt' (Alternativtext) haben.
// =============================================================================
const props = defineProps<{
  images: {
    src: string;
    alt: string;
  }[];
}>();

// =============================================================================
// STATE (Zustand)
// Wir brauchen eine reaktive Variable, um uns zu merken, welches Bild gerade angezeigt wird.
// Wir starten mit dem ersten Bild (Index 0).
// =============================================================================
const currentIndex = ref(0);

// =============================================================================
// COMPUTED (Berechnete Werte)
// Eine computed property, die uns immer das gerade aktive Bild-Objekt zurückgibt.
// Das macht den Template-Code sauberer.
// =============================================================================
const currentImage = computed(() => {
  return props.images[currentIndex.value];
});

// =============================================================================
// METHODS (Funktionen)
// =============================================================================

// Funktion, um zum nächsten Bild zu wechseln.
const nextSlide = () => {
  // Erhöhe den Index um 1. Der Modulo-Operator (%) sorgt dafür, dass wir
  // nach dem letzten Bild wieder beim ersten (Index 0) anfangen.
  currentIndex.value = (currentIndex.value + 1) % props.images.length;
};

// Funktion, um zum vorherigen Bild zu wechseln.
const prevSlide = () => {
  // Verringere den Index um 1.
  // Wenn wir beim ersten Bild sind, springen wir zum letzten.
  if (currentIndex.value > 0) {
    currentIndex.value = currentIndex.value - 1;
  } else {
    currentIndex.value = props.images.length - 1;
  }
};

// Funktion, um direkt zu einem bestimmten Bild zu springen (für die Navigations-Punkte).
const goToSlide = (index: number) => {
  currentIndex.value = index;
};
</script>

<template>
  <div v-if="images.length > 0" class="relative w-full mx-auto shadow-lg rounded-lg overflow-hidden">
    <div class="relative w-full h-96 bg-gray-200 dark:bg-gray-800">
        <transition
            enter-active-class="transition-opacity duration-500 ease-in-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-500 ease-in-out absolute top-0 left-0 w-full h-full"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <img :key="currentIndex" :src="currentImage.src" :alt="currentImage.alt" class="w-full h-full object-cover" />
        </transition>
    </div>

    <button @click="prevSlide" class="absolute top-1/2 left-4 -translate-y-1/2 bg-black bg-opacity-40 text-white p-2 rounded-full hover:bg-opacity-60 focus:outline-none focus:ring-2 focus:ring-white">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
    </button>

    <button @click="nextSlide" class="absolute top-1/2 right-4 -translate-y-1/2 bg-black bg-opacity-40 text-white p-2 rounded-full hover:bg-opacity-60 focus:outline-none focus:ring-2 focus:ring-white">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
    </button>

    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
      <button
        v-for="(image, index) in images"
        :key="`dot-${index}`"
        @click="goToSlide(index)"
        class="w-3 h-3 rounded-full transition-colors"
        :class="{
          'bg-white': currentIndex === index,
          'bg-white bg-opacity-50 hover:bg-opacity-75': currentIndex !== index
        }"
        :aria-label="`Gehe zu Bild ${index + 1}`"
      ></button>
    </div>
  </div>
</template>