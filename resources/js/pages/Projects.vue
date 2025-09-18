<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Project, Skill } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue'; // `computed` importieren
import { useI18n } from 'vue-i18n'; // `useI18n` importieren
import { usePage } from '@inertiajs/vue3';

// Importiere die neuen Komponenten
import ProjectCard from '@/components/ProjectCard.vue';
import InteractiveCard from '@/components/InteractiveCard.vue';
import SkillHexagon from '@/components/SkillHexagon.vue';

const page = usePage();
const currentUser = computed(() => page.props.auth?.user ?? null);

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

// --- Breadcrumbs ---
// Wir machen die Breadcrumbs "computed", damit sie sich bei Sprachwechsel aktualisieren
const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    { title: t('projects.breadcrumb'), href: '/projects' },
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

            <section id="projekte" class="p-4 rounded-xl border">
                 <div class="text-center mb-12">
                      <h2 class="text-3xl font-bold text-white">{{ $t('projects.headline') }}</h2>
                      <p class="text-slate-400 max-w-2xl mx-auto mt-2">{{ $t('projects.description') }}</p>
                 </div>
                 <!--
                 <div v-if="currentUser" class="grid auto-rows-min gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <ProjectCard
                      title="Einzelprojekt"
                      description="Ohne Array, direkt als Props."
                      image="https://picsum.photos/400/100"
                      :technologies="['Vue.js', 'Laravel']"
                      live-url="#"
                      repo-url="#"
                    />
                 </div> -->
            
                 <div class="grid auto-rows-min gap-8 md:grid-cols-2 lg:grid-cols-3 mt-6">
                 <!--
                  <ProjectCard
                      title="Einzelprojekt"
                      description="Ohne Array, direkt als Props."
                      image="https://picsum.photos/400/200"
                      :technologies="['Vue.js', 'Laravel']"
                      live-url="#"
                      repo-url="#"
                    />
                    <ProjectCard
                      title="Einzelprojekt"
                      description="Ohne Array, direkt als Props."
                      image="https://picsum.photos/400/200"
                      :technologies="['Wordpress']"
                      live-url="#"
                      repo-url="#"
                    />

                    -->

                    <ProjectCard
                      title="Fräulein Strauss 2.0"
                      description="Eine meiner Ersten Wordpress seiten"
                      image="../images/cards/fraeulein-strauss2.0.png"
                      :technologies="['Wordpress']"
                      live-url="https://www.xn--frulein-strauss-1kb.de/"
                      repo-url="https://github.com/GrubenGeist/fraeulein-strauss.git"
                    />
                 </div>
            </section>

            <div class="md:items-center" id="Game Card">
                <section id="game-cards" class="p-4 rounded-xl border">
                    <div class="text-center mb-12">
                         <h2 class="text-3xl font-bold text-white">{{ $t('projects.interactive_cards.headline') }}</h2>
                         <p class="text-slate-400 max-w-2xl mx-auto mt-2">{{ $t('projects.interactive_cards.description') }}</p>
                    </div>  

                    <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-4">
                    <div class="flex justify-center">
                      <InteractiveCard class="mt-2 mb-2 size-sm md:max-w-[210px]"
                        front-image-url="https://m.media-amazon.com/images/I/91nMuNBshYL.jpg"
                        back-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4"
                        character-image-url="/images/cards/Blackmagican.png"
                        audio-url="/sounds/animals/summon.mp3"
                      />
                    </div>
                    <div class="flex justify-center">
                      <InteractiveCard class="mt-2 mb-2 md:max-w-[210px]"
                        front-image-url="https://m.media-amazon.com/images/I/91nMuNBshYL.jpg"
                        back-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4"
                        character-image-url="/images/cards/Blackmagican.png"
                        audio-url="/sounds/animals/summon.mp3"
                      />
                    </div>
                    <div class="flex justify-center">
                      <InteractiveCard class="mt-2 mb-2 md:max-w-[210px]"
                        front-image-url="https://m.media-amazon.com/images/I/91nMuNBshYL.jpg"
                        back-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4"
                        character-image-url="/images/cards/Blackmagican.png"
                        audio-url="/sounds/animals/summon.mp3"
                      />
                    </div>
                      <div class="flex justify-center hidden md:block ">
                      <InteractiveCard class="mt-2 mb-2 md:max-w-[210px]"
                        front-image-url="https://m.media-amazon.com/images/I/91nMuNBshYL.jpg"
                        back-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4"
                        character-image-url="/images/cards/Blackmagican.png"
                        audio-url="/sounds/animals/summon.mp3"
                      />
                    </div>
                    <div class="flex justify-center hidden md:block ">
                      <InteractiveCard class="mt-2 mb-2 md:max-w-[210px]"
                        front-image-url="https://m.media-amazon.com/images/I/91nMuNBshYL.jpg"
                        back-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4"
                        character-image-url="/images/cards/Blackmagican.png"
                        audio-url="/sounds/animals/summon.mp3"
                      />
                    </div>
                    <div class="flex justify-center hidden md:block ">
                      <InteractiveCard class="mt-2 mb-2 md:max-w-[210px]"
                        front-image-url="https://m.media-amazon.com/images/I/91nMuNBshYL.jpg"
                        back-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4"
                        character-image-url="/images/cards/Blackmagican.png"
                        audio-url="/sounds/animals/summon.mp3"
                      />
                    </div>
                    <div class="flex justify-center hidden md:block ">
                      <InteractiveCard class="mt-2 mb-2 md:max-w-[210px]"
                        front-image-url="https://m.media-amazon.com/images/I/91nMuNBshYL.jpg"
                        back-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4"
                        character-image-url="/images/cards/Blackmagican.png"
                        audio-url="/sounds/animals/summon.mp3"
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

<style>
/* Diese globalen Stile bleiben hier, da sie die Sektionen layouten */
.bg-grid-slate-800 {
  background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
  background-size: 30px 30px;
  background-position: center;
}


/* Hier ist Vergangenheits Dennis 
 * Wenn du die Gamecards als Array nutzen willst musst du Folgendes Einfügen:


import InteractiveCard from '@/components/InteractiveCard.vue';


    Im Script abschnitt:
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


        // Füge hier so viele Karten hinzu, wie du möchtest
    ]);





    Im Template:
                        <div class="mb-4 mt-4 grid grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-4">
                         <div v-for="(card, index) in gameCards" :key="index">
                             <InteractiveCard
                                   :front-image-url="card.front"
                                    :back-image-url="card.back"
                                    :character-image-url="card.character"
                                    :audio-url="card.sound"
                                    size="sm"
                                    aspect="aspect-[3/4]"
                                    :hover-effect="true"
                             />

                         </div>
                    </div>
*/

/**

    Eine Einzelne GameCard 

           <div class="" id="Game Card">
                <section id="game-cards">
                    <div class="text-center mb-12">
                         <h2 class="text-3xl font-bold text-white">{{ $t('projects.interactive_cards.headline') }}</h2>
                         <p class="text-slate-400 max-w-2xl mx-auto mt-2">{{ $t('projects.interactive_cards.description') }}</p>
                    </div>                
                    <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-4">
                    <div class="flex justify-center">
                      <InteractiveCard class="mt-2 mb-2 size-sm md:max-w-[210px]"
                        front-image-url="https://m.media-amazon.com/images/I/91nMuNBshYL.jpg"
                        back-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4"
                        character-image-url="/images/cards/Blackmagican.png"
                        audio-url="/sounds/animals/summon.mp3"
                      />
                    </div>
                    <div class="flex justify-center">
                      <InteractiveCard class="mt-2 mb-2 md:max-w-[210px]"
                        front-image-url="https://m.media-amazon.com/images/I/91nMuNBshYL.jpg"
                        back-image-url="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/c741eead-0f8a-46df-b16d-18b58dbbe1ed/df36n3p-418a5ce3-258f-44ca-bd96-386409a64bdf.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2M3NDFlZWFkLTBmOGEtNDZkZi1iMTZkLTE4YjU4ZGJiZTFlZFwvZGYzNm4zcC00MThhNWNlMy0yNThmLTQ0Y2EtYmQ5Ni0zODY0MDlhNjRiZGYucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.XZfhJ9t5l1-7hPl2FMq5JyH_WOmhtZtw50VWe1IpdO4"
                        character-image-url="/images/cards/Blackmagican.png"
                        audio-url="/sounds/animals/summon.mp3"
                      />
                    </div>
                    </div>
                </section>
            </div>





*/
</style>