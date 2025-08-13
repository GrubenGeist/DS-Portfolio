<!-- /resources/js/Pages/Imprint.vue -->

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

defineOptions({ layout: AppLayout });

// Die "Schablone" (Interface) für unsere Abschnitte.
interface ImprintSection {
    title: string;
    content: string[];
    titleClass?: string; // z.B. 'font-bold', 'italic'
    contentClass?: string; // z.B. 'text-sm'
}

// Hier definieren wir den gesamten Inhalt der Seite in einer strukturierten Form.
const imprintSections: ImprintSection[] = [
    {
        title: 'Diensteanbieter',
        titleClass: 'font-semibold',
        content: [
            'Dennis Strauß',
            'Roonstraße 8',
            '12203 Berlin',
            'Deutschland',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Kontaktmöglichkeiten',
        titleClass: 'font-semibold',
        content: [
            'E-Mail-Adresse: <a href="mailto:Kommtnoch@web.de" class="text-blue-500 dark:text-blue-400 hover:underline">Kommtnoch@web.de</a>',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Audiovisuelle Mediendienste',
        titleClass: 'font-semibold',
        content: [
            'Sitzland: Deutschland.',
            'Zuständige Regulierungs-, bzw. Aufsichtsbehörde: Medienanstalt Berlin-Brandenburg (mabb), <a href="https://www.mabb.de" target="_blank" rel="noopener noreferrer" class="text-blue-500 dark:text-blue-400 hover:underline">www.mabb.de</a>.',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Social Media und andere Onlinepräsenzen',
        titleClass: 'font-semibold',
        content: [
            'Dieses Impressum gilt auch für die folgenden Social-Media-Präsenzen und Onlineprofile:',
            '// Hier Socialmedia Links eintragen',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Vorbehalt der Nutzung für Text und Data Mining',
        titleClass: 'font-semibold',
        content: [
            'Vorbehalt der Nutzung für Text und Data Mining: Der Inhaber dieser Website gestattet die Nutzung oder das Herunterladen von Inhalten dieser Website durch Dritte für die Entwicklung, das Training oder den Betrieb von künstlicher Intelligenz oder anderen maschinellen Lernsystemen ("Text und Data Mining") ausschließlich mit ausdrücklicher schriftlicher Zustimmung des Inhabers. Ohne eine solche Zustimmung ist es untersagt, die Inhalte für Text und Data Mining zu verwenden. Dies gilt auch, wenn auf der Website keine Meta-Angaben vorhanden sind, die entsprechende Verfahren aussperren, und selbst dann, wenn Bots, die den Zweck haben, die Website zu Zwecken des Text und Data Mining auszulesen, nicht ausgesperrt werden.',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Haftungs- und Schutzrechtshinweise',
        titleClass: 'font-semibold',
        content: [
            '<ul><li class="mb-4"><strong>Links auf fremde Webseiten:<br></strong> Die Inhalte fremder Webseiten, auf die wir direkt oder indirekt verweisen, liegen außerhalb unseres Verantwortungsbereiches und wir machen sie uns nicht zu Eigen. Für alle Inhalte und Nachteile, die aus der Nutzung der in den verlinkten Webseiten aufrufbaren Informationen entstehen, übernehmen wir keine Verantwortung.</li><li class="mb-4"><strong>Urheberrechte und Markenrechte:<br></strong> Alle auf dieser Website dargestellten Inhalte, wie Texte, Fotografien, Grafiken, Marken und Warenzeichen sind durch die jeweiligen Schutzrechte (Urheberrechte, Markenrechte) geschützt. Die Verwendung, Vervielfältigung usw. unterliegen unseren Rechten oder den Rechten der jeweiligen Urheber bzw. Rechteinhaber.</li><li><strong>Hinweise auf Rechtsverstöße:<br></strong> Sollten Sie innerhalb unseres Internetauftritts Rechtsverstöße bemerken, bitten wir Sie uns auf diese hinzuweisen. Wir werden rechtswidrige Inhalte und Links nach Kenntnisnahme unverzüglich entfernen.</li></ul>',
        ],
        contentClass:'text-sm',
    },
    {
        title: 'Bildnachweise',
        titleClass: 'font-semibold',
        content: [
            'Bildquellen und Urheberrechtshinweise:',
            'Alle Bildquellen sind vom Seiteninhaber erstellt und oder bearbeitet worden.',
        ],
        contentClass:'text-sm',
    },
];
</script>

<template>
    <Head title="Impressum" />
    
    <!-- Der Hauptcontainer für die Seite -->
    <div class="container mx-auto md:py-20">
        <!-- Die Inhalts-Karte -->
        <div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 rounded-lg shadow-2xl overflow-hidden">
            
            <!-- KORREKTUR: Der Header hat jetzt einen Farbverlauf und ein Hintergrund-Icon -->
            <div class="relative bg-gradient-to-br from-blue-700 to-blue-800 p-8 md:p-12 overflow-hidden">
                <!-- Das Icon liegt im Hintergrund -->
                <div class="absolute -bottom-12 -right-12 text-white opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-2"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                </div>

                <!-- Der Text liegt mit z-10 im Vordergrund -->
                <div class="relative z-10">
                    <h1 class="text-3xl md:text-4xl font-bold text-white">
                        Impressum
                    </h1>
                    <p class="mt-2 text-blue-200">Angaben gemäß § 5 TMG</p>
                </div>
            </div>

            <!-- Der eigentliche Textinhalt auf weißem/dunklem Hintergrund -->
            <div class="p-8 md:p-12 prose dark:prose-invert max-w-none">
                <!-- Das Template rendert den Inhalt jetzt dynamisch aus der Datenstruktur -->
                <div v-for="(section, index) in imprintSections" :key="index" class="mb-8 last:mb-0">
                    <h2 :class="section.titleClass">{{ section.title }}</h2>
                    <div 
                        v-for="(paragraph, pIndex) in section.content" 
                        :key="pIndex" 
                        v-html="paragraph" 
                        class="text-gray-700 dark:text-gray-300"
                        :class="section.contentClass"
                    ></div>
                </div>
                <!-- Quelle des Generators -->
                <p class="mt-12 text-sm text-gray-500">
                    <a 
                        href="https://datenschutz-generator.de/" 
                        title="Rechtstext von Dr. Schwenke - für weitere Informationen bitte anklicken." 
                        target="_blank" 
                        rel="noopener noreferrer nofollow"
                        class="text-blue-500 dark:text-blue-400 hover:underline"
                    >
                        Erstellt mit kostenlosem Datenschutz-Generator.de von Dr. Thomas Schwenke
                    </a>
                </p>
            </div>
        </div>
    </div>
</template>
