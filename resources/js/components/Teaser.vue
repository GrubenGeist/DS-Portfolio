<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const props = withDefaults(defineProps<{
  // Text
  headline?: string;
  subheadline?: string;
  showSubheadline?: boolean;
  paragraphs?: string[];

  // Bilder
  portraitImageUrl?: string;
  backgroundImageLightUrl?: string;
  backgroundImageDarkUrl?: string;
  backgroundWidth?: string;
  backgroundHeight?: string;
  backgroundPositionX?: string;
  backgroundPositionY?: string;
  portraitPositionX?: string;
  portraitPositionY?: string;

  // Layout & Farben
  imagePosition?: 'left' | 'right';
  backgroundColor?: string;
  headlineColor?: string;
  subheadlineColor?: string;
  textColor?: string;

  // Button
  buttonText?: string;
  buttonHref?: string;
  buttonVariant?: 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link';

  // Animation
  enableAnimation?: boolean;
}>(), {
  headline: 'Standard-Überschrift',
  subheadline: '',
  showSubheadline: true,
  paragraphs: () => ['Dies ist ein Standardtext. Bitte ersetzen Sie ihn.'],
  portraitImageUrl: '/images/elements/TemplateDude.png',
  backgroundImageLightUrl: '',
  backgroundImageDarkUrl: '',
  backgroundWidth: 'auto',
  backgroundHeight: '150%',
  backgroundPositionX: '50%',
  backgroundPositionY: '42%',
  portraitPositionX: '50%',
  portraitPositionY: '0',
  imagePosition: 'right',
  backgroundColor: 'bg-blue-900',
  headlineColor: 'text-white',
  subheadlineColor: 'text-white',
  textColor: 'text-blue-200',
  buttonText: '',
  buttonHref: '',
  buttonVariant: 'secondary',
  enableAnimation: false,
});

const imageFailedToLoad = ref(false);

// Layout-Klassen
const layoutClasses = computed(() =>
  props.imagePosition === 'left'
    ? 'md:grid-cols-[1fr_2fr]'
    : 'md:grid-cols-[2fr_1fr]'
);

const imageOrderClass = computed(() =>
  props.imagePosition === 'left' ? 'md:order-first' : ''
);
</script>

<template>
  <section
    class="bg-white dark:bg-transparent border rounded-2xl shadow-2xl overflow-hidden text-pretty"
    role="region"
    :aria-label="headline"
    :class="backgroundColor"
  >
    <div class="group grid grid-cols-1 gap-0" :class="layoutClasses">
      <!-- Text -->
      <div class="dark:bg-yellow-400/80 p-8 md:p-12 lg:p-16 flex flex-col justify-center">
        <h2
          class="dark:text-black text-2xl md:text-5xl font-bold mb-4 leading-tight"
          :class="headlineColor"
        >
          {{ headline }}
        </h2>

        <h4
          v-if="showSubheadline && subheadline"
          class="dark:text-black text-xl md:text-2xl font-bold mt-0 mb-6 leading-tight"
          :class="subheadlineColor"
        >
          {{ subheadline }}
        </h4>

        <p
          v-for="(paragraph, index) in paragraphs"
          :key="index"
          class="dark:text-black text-lg leading-relaxed md:mr-20"
          :class="[{ 'mt-4': index > 0 }, textColor]"
        >
          {{ paragraph }}
        </p>

        <div v-if="buttonText && buttonHref" class="mt-8">
          <Link :href="buttonHref">
            <Button :variant="buttonVariant" size="lg">
              {{ buttonText }}
            </Button>
          </Link>
        </div>
      </div>

      <!-- Bild -->
      <div class="relative min-h-[350px] md:min-h-0 overflow-hidden" :class="imageOrderClass">
        <div class="absolute inset-0 bg-white dark:bg-stone-800 overflow-hidden">
          <!-- Light Mode -->
          <img
            v-if="backgroundImageLightUrl && !imageFailedToLoad"
            :src="backgroundImageLightUrl"
            alt="Hintergrundmuster"
            @error="imageFailedToLoad = true"
            class="absolute block dark:hidden"
            :style="{
              width: backgroundWidth,
              height: backgroundHeight,
              maxWidth: 'none',
              left: backgroundPositionX,
              top: backgroundPositionY,
              transform: 'translate(-50%, -50%)',
            }"
          />
          <!-- Dark Mode -->
          <img
            v-if="backgroundImageDarkUrl && !imageFailedToLoad"
            :src="backgroundImageDarkUrl"
            alt="Hintergrundmuster dunkel"
            @error="imageFailedToLoad = true"
            class="absolute hidden dark:block"
            :style="{
              width: backgroundWidth,
              height: backgroundHeight,
              maxWidth: 'none',
              left: backgroundPositionX,
              top: backgroundPositionY,
              transform: 'translate(-50%, -50%)',
            }"
          />
        </div>

        <!-- Portrait -->
        <div class="absolute inset-0" :class="{ 'animate-float': enableAnimation }">
          <img
            :src="portraitImageUrl"
            alt="Portrait"
            class="absolute h-full w-auto object-contain drop-shadow-2xl saturate-0 group-hover:saturate-100 transition-all duration-500 ease-in-out"
            :style="{
              left: portraitPositionX,
              bottom: portraitPositionY,
              transform: 'translateX(-50%)',
            }"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<style>
@keyframes float {
  0% { transform: translateY(0px); }
  50% { transform: translateY(10px); }
  100% { transform: translateY(0px); }
}
.animate-float {
  animation: float 6s ease-in-out infinite;
}
</style>






<!--  
Wie du die neue Teaser.vue jetzt verwendest
Du kannst diese Komponente jetzt auf jeder Seite (z.B. Welcome.vue) einfügen und sie komplett anpassen. 

Hier sind zwei Beispiele:


Bild rechts (Standard)
<Teaser />

    <Teaser 
        headline="Willkommen auf meinem Portfolio"
        :paragraphs="[
            'Hallo, ich bin Dennis Strauß, ein Anwendungsentwickler mit Fokus auf maßgeschneiderte Softwarelösungen.',
            'Mit fundierten Kenntnissen in modernen Technologien wie Laravel und einem klaren Blick für sauberen, wartbaren Code entwickle ich leistungsstarke Anwendungen, um Prozesse zu optimieren und Nutzer zu begeistern.',
            'Hier finden Sie eine Auswahl meiner bisherigen Projekte,technische Schwerpunkte und Informationen zu meinem beruflichen Werdegang.Ich freue mich, wenn Sie einen Einblick in meine Arbeit gewinnen und vielleicht schon bald den passenden Partner für Ihr nächstes Softwareprojekt gefunden haben.',
            
        ]"
        portraitImageUrl="/images/selfie.png"
        backgroundImageUrl="/images/elements/BgStartseitePortrait.png"
        :backgroundHeight="'170%'"
        :backgroundPositionX="'76%'"
        :portraitPositionX="'65%'"
    />


Bild links 
<Teaser :imagePosition="'left'" />


    <Teaser :imagePosition="'left'"
        headline="Willkommen auf meinem Portfolio"
        :paragraphs="[
            'Hallo, ich bin Dennis Strauß, ein Anwendungsentwickler mit Fokus auf maßgeschneiderte Softwarelösungen.',
            'Mit fundierten Kenntnissen in modernen Technologien wie Laravel und einem klaren Blick für sauberen, wartbaren Code entwickle ich leistungsstarke Anwendungen, um Prozesse zu optimieren und Nutzer zu begeistern.',
            'Hier finden Sie eine Auswahl meiner bisherigen Projekte,technische Schwerpunkte und Informationen zu meinem beruflichen Werdegang.Ich freue mich, wenn Sie einen Einblick in meine Arbeit gewinnen und vielleicht schon bald den passenden Partner für Ihr nächstes Softwareprojekt gefunden haben.',
            
        ]"
        portraitImageUrl="/images/selfie.png"
        backgroundImageUrl="/images/elements/BgStartseitePortrait.png"
        :backgroundHeight="'170%'"
        :backgroundPositionX="'10%'"
        :portraitPositionX="'35%'"
    />



Beispiel Allgemein:    

<script setup lang="ts">
import Teaser from '@/components/Teaser.vue';

// Beispiel-Texte für den zweiten Teaser
const secondTeaserParagraphs = [
    'Dies ist ein komplett anderer Text.',
    'Die Bildposition ist links und die Farben sind anders.'
];
</script>

<template>
    -->
    <!-- Beispiel 1: Wie dein alter "AboutMeTeaser" 
    <Teaser
        headline="Willkommen auf meinem Portfolio"
        :paragraphs="[
            'Hallo, ich bin Dennis Strauß...',
            'Mit fundierten Kenntnissen...',
            'Hier finden Sie eine Auswahl...'
        ]"
        portraitImageUrl="/images/selfie.png"
        backgroundImageUrl="/images/elements/BgStartseitePortrait.png"
        :backgroundHeight="'120%'"
        :backgroundPositionX="'70%'"
        :portraitPositionX="'65%'"
    />

    <!-- Beispiel 2: Ein komplett anderer Teaser 
    <Teaser
        headline="Ein weiteres Feature"
        :paragraphs="secondTeaserParagraphs"
        portraitImageUrl="/images/anderes-bild.png"
        backgroundImageLightUrl="/images/elements/BgStartseitePortrait.png"
        backgroundImageDarkUrl="/images/elements/BgStartseitePortrait-dark.png"
        :imagePosition="'left'"
        backgroundColor="bg-gray-800"
        headlineColor="text-cyan-400"
        textColor="text-gray-300"
        buttonText="Mehr erfahren"
        buttonHref="/projects"
        buttonVariant="outline"

        patternLightColor="text-blue-400"
        patternDarkColor="text-yellow-300"
        patternOpacity="opacity-40"
    />
</template>






-->