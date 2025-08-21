<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

// defineProps macht die Komponente wiederverwendbar.
// Alle Aspekte des Teasers können jetzt von außen gesteuert werden.
const props = withDefaults(defineProps<{
    // Text-Inhalte
    headline?: string;
    paragraphs?: string[];

    // Bilder & Styling
    portraitImageUrl?: string;
    backgroundImageUrl?: string;
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
    textColor?: string;
    
    // Optionaler Button
    buttonText?: string;
    buttonHref?: string;
    buttonVariant?: 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link';

    // Animation-Steuerung
    enableAnimation?: boolean;

}>(), {
    // Standardwerte für alle Props
    headline: 'Standard-Überschrift',
    paragraphs: () => ['Dies ist ein Standardtext. Bitte ersetzen Sie ihn.'],
    portraitImageUrl: '/images/elements/TemplateDude.png',
    backgroundImageUrl: '',
    backgroundWidth: 'auto',
    backgroundHeight: '150%',
    backgroundPositionX: '50%',
    backgroundPositionY: '42%',
    portraitPositionX: '50%',
    portraitPositionY: '0',
    imagePosition: 'right', // Bild ist standardmäßig rechts
    backgroundColor: 'bg-blue-900', // Blauer Hintergrund
    headlineColor: 'text-white',
    textColor: 'text-blue-200',
    buttonText: '',
    buttonHref: '',
    buttonVariant: 'secondary',
    enableAnimation: false, // Animation ist standardmäßig ausgeschaltet
});

// Ein reaktiver Zustand für das Fallback-Hintergrundbild
const imageFailedToLoad = ref(false);

// Berechnet die Klassen für das Layout basierend auf der Bildposition
const layoutClasses = computed(() => {
    return props.imagePosition === 'left' ? 'md:grid-cols-[1fr_2fr]' : 'md:grid-cols-[2fr_1fr]';
});

const imageOrderClass = computed(() => {
    return props.imagePosition === 'left' ? 'md:order-first' : '';
});

const imageRoundingClass = computed(() => {
    return props.imagePosition === 'left' ? 'md:rounded-l-2xl' : 'md:rounded-r-2xl';
});
</script>

<template>
    <section class=" bg-white dark:bg-slate-900 text-pretty break-words">
        <!-- 
            KORREKTUR: Barrierefreiheit
            - tabindex="0": Macht den gesamten Container per Tastatur fokussierbar.
            - role="region": Teilt Screenreadern mit, dass dies ein wichtiger, zusammenhängender Abschnitt ist.
            - :aria-label="headline": Liest die Überschrift als Beschreibung für den Abschnitt vor.
            - focus-visible Klassen: Fügen einen klaren, konsistenten Fokus-Ring nur für Tastatur-Nutzer hinzu.
        -->
        <div 
            role="region"
            :aria-label="headline"
            class="group grid grid-cols-1 gap-0 rounded-2xl shadow-2xl"
            :class="[backgroundColor, layoutClasses]"
        >
            <!-- Text-Spalte -->
            <div class="p-8 md:p-12 lg:p-16 flex flex-col justify-center">
                <h2 
                    class="text-2xl md:text-5xl font-bold mb-6 leading-tight break-words"
                    :class="headlineColor"
                >
                    {{ headline }}
                </h2>
                <p 
                    v-for="(paragraph, index) in paragraphs" 
                    :key="index" 
                    class="text-lg leading-relaxed text-justify md:mr-20 text-pretty break-words" 
                    :class="[{ 'mt-4': index > 0 }, textColor]"
                >
                    {{ paragraph }}
                </p>
                <!-- Optionaler Button -->
                <div v-if="buttonText && buttonHref" class="mt-8">
                    <Link :href="buttonHref">
                        <Button :variant="buttonVariant" size="lg">
                            {{ buttonText }}
                        </Button>
                    </Link>
                </div>
            </div>
            
            <!-- Bild-Spalte -->
            <div class="relative min-h-[350px] md:min-h-0 overflow-hidden" :class="imageOrderClass">
                <div class="absolute inset-0 bg-white dark:bg-slate-800 overflow-hidden rounded-br-2xl rounded-bl-2xl md:rounded-bl-none" :class="imageRoundingClass">
                    <img 
                        v-if="backgroundImageUrl && !imageFailedToLoad"
                        :src="backgroundImageUrl" 
                        alt="Hintergrundmuster abgerundete Linien vertikal verlaufend"
                        @error="imageFailedToLoad = true"
                        class="absolute"
                        :style="{ 
                            width: backgroundWidth, 
                            height: backgroundHeight,
                            maxWidth: 'none',
                            left: backgroundPositionX,
                            top: backgroundPositionY,
                            transform: 'translate(-50%, -50%)'
                        }"
                    >
                    <svg v-else width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" class="opacity-60">
                        <defs>
                            <pattern id="pattern-stripes" patternUnits="userSpaceOnUse" width="40" height="40" patternTransform="rotate(45)">
                                <line x1="0" y1="0" x2="0" y2="40" stroke="#e0f2fe" stroke-width="20" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#pattern-stripes)"/>
                    </svg>
                </div>

                <!-- Die 'animate-float' Klasse wird nur angewendet, wenn enableAnimation true ist -->
                <div class="absolute inset-0" :class="{ 'animate-float': enableAnimation }">
                    <img 
                        :src="portraitImageUrl" 
                        alt="Portrait" 
                        class="absolute h-full w-auto object-contain drop-shadow-2xl saturate-0 group-hover:saturate-100 transition-all duration-500 ease-in-out"
                        :style="{
                            left: portraitPositionX,
                            bottom: portraitPositionY,
                            transform: 'translateX(-50%)'
                        }"
                    >
                </div>
            </div>
        </div>
    </section>
</template>

<!-- Der Style-Block mit der Animation ist wieder da -->
<style>
/* Eine einfache "Float"-Animation für das Portraitbild */
@keyframes float {
    0% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(10px);
    }
    100% {
        transform: translateY(0px);
    }
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
        :imagePosition="'left'"
        backgroundColor="bg-gray-800"
        headlineColor="text-cyan-400"
        textColor="text-gray-300"
        buttonText="Mehr erfahren"
        buttonHref="/projects"
        buttonVariant="outline"
    />
</template>






-->