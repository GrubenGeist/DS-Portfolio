<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Project, Skill } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue'; // `computed` importieren
import { useI18n } from 'vue-i18n'; // `useI18n` importieren

// Importiere die neuen Komponenten
import ProjectCard from '@/components/ProjectCard.vue';
import InteractiveCard from '@/components/InteractiveCard.vue';
import SkillHexagon from '@/components/SkillHexagon.vue';

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

// --- Breadcrumbs ---
// Wir machen die Breadcrumbs "computed", damit sie sich bei Sprachwechsel aktualisieren
const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    { title: t('projects.breadcrumb'), href: '/projects' },
]);

const gameCards = ref([
    {
        front: 'https://i.pinimg.com/474x/58/91/e8/5891e81a2390301da2c9a516d771f99d.jpg',
        back: 'https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4',
        character: '/images/cards/WhiteDragon.png',
        sound: '/sounds/animals/dragonroar.mp3'
    },
    {
        front: 'https://i.pinimg.com/474x/58/91/e8/5891e81a2390301da2c9a516d771f99d.jpg',
        back: 'https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4',
        character: '/images/cards/WhiteDragon.png',
        sound: '/sounds/animals/dragonroar.mp3'
    },
    {
        front: 'https://i.pinimg.com/474x/58/91/e8/5891e81a2390301da2c9a516d771f99d.jpg',
        back: 'https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4',
        character: '/images/cards/WhiteDragon.png',
        sound: '/sounds/animals/dragonroar.mp3'
    },
    {
        front: 'https://m.media-amazon.com/images/I/91nMuNBshYL.jpg', // Beispiel für eine zweite Karte
        back: 'https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4',
        character: '/images/cards/Blackmagican.png',
        sound: '/sounds/animals/summon.mp3'
    },
    {
        front: 'https://m.media-amazon.com/images/I/91nMuNBshYL.jpg', // Beispiel für eine zweite Karte
        back: 'https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4',
        character: '/images/cards/Blackmagican.png',
        sound: '/sounds/animals/summon.mp3'
    },

    // Füge hier so viele Karten hinzu, wie du möchtest
]);


// --- Projekte ---
// Die Projektdaten werden "computed", damit sich die Texte reaktiv ändern
const projects = computed<Project[]>(() => [
    {
        title: t('projects.project_alpha.title'),
        description: t('projects.project_alpha.description'),
        image: 'https://img.freepik.com/vektoren-kostenlos/nachtmeerlandschaft-vollmond-und-sterne-leuchten_107791-7397.jpg?semt=ais_hybrid&w=740',
        technologies: ['Laravel', 'Vue.js', 'Inertia.js', 'MySQL', 'Redis'],
        liveUrl: '#',
        repoUrl: '#',
    },
    {
        title: t('projects.project_beta.title'),
        description: t('projects.project_beta.description'),
        image: 'https://img.freepik.com/fotos-kostenlos/neon-tropisches-monstera-blattbanner_53876-138943.jpg?semt=ais_hybrid&w=740',
        technologies: ['Vue.js', 'Chart.js', 'Tailwind CSS', 'Laravel API'],
        liveUrl: '#',
        repoUrl: '#',
    },
    {
        title: t('projects.project_gamma.title'),
        description: t('projects.project_gamma.description'),
        image: 'https://ultrawidewallpapers.net/wallpapers/329/highres/aishot-1341.jpg',
        technologies: ['Laravel', 'Reverb', 'Vue.js', 'PostgreSQL'],
        liveUrl: '#',
        repoUrl: '#',
    },
]);

const skills = ref<Skill[]>([
    { name: 'Laravel', color: '#FF2D20', logoUrl: '../images/logos/laravel.png' },
    { name: 'Vue.js', color: '#4FC08D', logoUrl: '../images/logos/vue.png' },
    { name: 'JavaScript', color: '#F7DF1E', logoUrl: '../images/logos/js.png' },
    { name: 'PHP', color: '#777BB4', logoUrl: '../images/logos/php.png' },
    { name: 'Tailwind', color: '#38BDF8', logoUrl: '../images/logos/tailwind.png' },
    { name: 'MySQL', color: '#4479A1', logoUrl: '../images/logos/mysql.png' },
]);
</script>

<template>
    <Head :title="t('projects.head_title')" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-8 p-4 text-slate-300">

            <section id="projekte">
                 <div class="text-center mb-12">
                      <h2 class="text-3xl font-bold text-white">{{ $t('projects.headline') }}</h2>
                      <p class="text-slate-400 max-w-2xl mx-auto mt-2">{{ $t('projects.description') }}</p>
                 </div>
                 <div class="grid auto-rows-min gap-8 md:grid-cols-2 lg:grid-cols-3">
                      <div v-for="project in projects" :key="project.title">
                           <ProjectCard :project="project" />
                      </div>
                 </div>
            </section>

            <div class="p-0" id="Game Card">
                <section id="game-cards">
                    <div class="text-center mb-12">
                         <h2 class="text-3xl font-bold text-white">{{ $t('projects.interactive_cards.headline') }}</h2>
                         <p class="text-slate-400 max-w-2xl mx-auto mt-2">{{ $t('projects.interactive_cards.description') }}</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                         <div v-for="(card, index) in gameCards" :key="index">
                             <InteractiveCard
                                 :front-image-url="card.front"
                                 :back-image-url="card.back"
                                 :character-image-url="card.character"
                                 :audio-url="card.sound"
                             />
                         </div>
                    </div>
                </section>
            </div>
            
            <section id="skills" class="lg:col-span-2 py-10 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-grid-slate-800">
                <div class="container mx-auto px-6 h-full flex flex-col justify-center">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-white">{{ $t('projects.skills.headline') }}</h2>
                        <p class="text-slate-400 max-w-2xl mx-auto mt-2">{{ $t('projects.skills.description') }}</p>
                    </div>
                    <div class="flex flex-wrap justify-center items-center gap-4">
                        <SkillHexagon v-for="skill in skills" :key="skill.name" :skill="skill" />
                    </div>
                </div>
            </section>

        </div>
    </AppLayout>
</template>
            <!-- Eine Einzelne Karte <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <InteractiveCard 
                    front-image-url="https://i.pinimg.com/474x/58/91/e8/5891e81a2390301da2c9a516d771f99d.jpg" 
                    back-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4" 
                    character-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/5a6af839-076e-448b-b7e8-47dcfb1f1af3/dez92nc-4b2f4def-4fed-4b69-af8c-aacc5103ccec.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzVhNmFmODM5LTA3NmUtNDQ4Yi1iN2U4LTQ3ZGNmYjFmMWFmM1wvZGV6OTJuYy00YjJmNGRlZi00ZmVkLTRiNjktYWY4Yy1hYWNjNTEwM2NjZWMucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.oSVtS4ODlksTU3jAL6PY8A-SCDnJhLMGlX9g1GWaj0g" 
                    :audio-url="'/sounds/animals/dragonroar.mp3'"

                    > <template #back-content>                            
                            <div class="flex flex-col items-center justify-center h-full gap-4">
                                <h3 class="text-2xl font-bold text-white">Karten-Rückseite</h3>
                                <p class="text-center">Hier kann beliebiger Text oder anderer Inhalt stehen.</p>
                                <a href="#" class="mt-4 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 px-4 rounded-lg">
                                    Ein Button
                                </a>
                            </div>
                        </template>                
                </InteractiveCard> </div>
                

                <section id="skills" class="lg:col-span-2 py-10 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-grid-slate-800">
                    <div class="container mx-auto px-6 h-full flex flex-col justify-center">
                        <div class="text-center mb-12">
                            <h2 class="text-3xl font-bold text-white">Technologien & Skills</h2>
                            <p class="text-slate-400 max-w-2xl mx-auto mt-2">Werkzeuge, mit denen ich täglich arbeite.</p>
                        </div>
                        <div class="flex flex-wrap justify-center items-center gap-4">
                            <SkillHexagon v-for="skill in skills" :key="skill.name" :skill="skill" />
                        </div>
                    </div>
                </section>

            </div>
        
    </AppLayout>
</template> -->

<style>
/* Diese globalen Stile bleiben hier, da sie die Sektionen layouten */
.bg-grid-slate-800 {
  background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
  background-size: 30px 30px;
  background-position: center;
}
</style>