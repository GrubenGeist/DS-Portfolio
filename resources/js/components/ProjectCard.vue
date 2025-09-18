<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue'; // `computed` importieren

const page = usePage();
const currentUser = computed(() => page.props.auth?.user ?? null);



interface Project {
  title: string;
  description: string;
  image: string;
  technologies: string[];
  liveUrl: string;
  repoUrl: string;
}

defineProps<{
  project: Project;
}>();
</script>

<template>
  <div class="bg-slate-800 rounded-lg overflow-hidden group transform hover:-translate-y-2 transition-transform duration-300 shadow-lg hover:shadow-cyan-500/20 border border-sidebar-border/70 dark:border-sidebar-border flex flex-col h-full">
    <img :src="project.image" :alt="project.title" class="w-full h-48 object-cover">

    <div class="p-6 flex flex-col flex-grow">
      <h3 class="text-xl font-bold text-white mb-2">{{ project.title }}</h3>
      <p class="text-slate-400 mb-4 text-sm flex-grow">{{ project.description }}</p>

      <div class="flex flex-wrap gap-2 mb-4">
        <span v-for="tech in project.technologies" :key="tech" class="bg-slate-700 text-cyan-400 text-xs font-semibold px-2.5 py-1 rounded-full">
          {{ tech }}
        </span>
      </div>

      <div class="mt-auto pt-4 flex gap-4">
        <a :href="project.liveUrl" target="_blank" class="w-full text-center bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors">Live</a>
        <a :href="project.repoUrl" target="_blank" v-if="currentUser" class="w-full text-center bg-slate-700 hover:bg-slate-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors">Code</a>
      </div>
    </div>
  </div>
</template>