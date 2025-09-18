<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

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

const props = defineProps<{
  project?: Project;
  title?: string;
  description?: string;
  image?: string;
  technologies?: string[];
  liveUrl?: string;
  repoUrl?: string;
}>();

// Fallback: wenn ein Projekt-Objekt übergeben wurde, nimm es.
// Ansonsten baue ein Projekt-Objekt aus den Props.
const project = computed<Project>(() => {
  if (props.project) return props.project;

  return {
    title: props.title ?? 'Untitled Project',
    description: props.description ?? 'No description available.',
    image: props.image ?? 'https://via.placeholder.com/400x200.png?text=No+Image',
    technologies: props.technologies ?? [],
    liveUrl: props.liveUrl ?? '#',
    repoUrl: props.repoUrl ?? '#',
  };
});
</script>

<template>
  <div
    class="bg-slate-800 rounded-lg overflow-hidden group transform hover:-translate-y-2 transition-transform duration-300 shadow-lg hover:shadow-cyan-500/20 border border-sidebar-border/70 dark:border-sidebar-border flex flex-col h-full"
  >
    <img :src="project.image" :alt="project.title" class="w-full h-48 object-cover" />

    <div class="p-6 flex flex-col flex-grow">
      <h3 class="text-xl font-bold text-white mb-2">{{ project.title }}</h3>
      <p class="text-slate-400 mb-4 text-sm flex-grow">{{ project.description }}</p>

      <div class="flex flex-wrap gap-2 mb-4" v-if="project.technologies.length">
        <span
          v-for="tech in project.technologies"
          :key="tech"
          class="bg-slate-700 text-cyan-400 text-xs font-semibold px-2.5 py-1 rounded-full"
        >
          {{ tech }}
        </span>
      </div>

      <div class="mt-auto pt-4 flex gap-4">
        <a
          :href="project.liveUrl"
          target="_blank"
          class="w-full text-center bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors"
        >
          Live
        </a>
        <a
          v-if="currentUser"
          :href="project.repoUrl"
          target="_blank"
          class="w-full text-center bg-slate-700 hover:bg-slate-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors"
        >
          Code
        </a>
      </div>
    </div>
  </div>
</template>


<!--

Hier wieder Vergangenheits dennis zur Erinnerung
so fügst du die Cards auf einer Seite ein.

<ProjectCard
  title="Einzelprojekt"
  description="Ohne Array, direkt als Props."
  image="https://picsum.photos/400/200"
  :technologies="['Vue.js', 'Laravel']"
  live-url="#"
  repo-url="#"
/>


oder als array wie vorher

<ProjectCard :project="myProject" />

/ --- Projekte ---
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



            <section id="projekte">
                 <div class="text-center mb-12">
                      <h2 class="text-3xl font-bold text-white">{{ $t('projects.headline') }}</h2>
                      <p class="text-slate-400 max-w-2xl mx-auto mt-2">{{ $t('projects.description') }}</p>
                 </div>
                 <div v-if="currentUser" class="grid auto-rows-min gap-8 md:grid-cols-2 lg:grid-cols-3">
                      <div v-for="project in projects" :key="project.title">
                           <ProjectCard :project="project" />
                      </div>
                 </div>
                 <div class="grid auto-rows-min gap-8 md:grid-cols-2 lg:grid-cols-3 mt-6">
                      <div v-for="project in projects" :key="project.title">
                           <ProjectCard :project="project" />
                      </div>
                 </div>
            </section>




-->