<script setup lang="ts">
import { ref, watch } from 'vue'; // watch importieren
import { Head, useForm, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps<{
  categories: {
    id: number;
    name: string;
    events_count: number;
  }[];
}>();

defineOptions({ layout: AppLayout });

const createForm = useForm({
  name: '',
});

const editForms = ref<{ [key: number]: any }>({});

// Funktion, um die Bearbeitungsformulare zu initialisieren oder zu aktualisieren
const initializeEditForms = (categories: any[]) => {
  categories.forEach(cat => {
    // Füge nur dann ein neues Formular hinzu, wenn es noch nicht existiert
    if (!editForms.value[cat.id]) {
      editForms.value[cat.id] = useForm({ name: cat.name });
    }
  });
};

// Initialisiere die Formulare beim ersten Laden
initializeEditForms(props.categories);

// KORREKTUR: Beobachte die 'categories'-Prop. Wenn sie sich ändert (z.B. nach dem Erstellen),
// stelle sicher, dass auch für die neuen Kategorien ein Bearbeitungsformular existiert.
watch(() => props.categories, (newCategories) => {
  initializeEditForms(newCategories);
}, { deep: true });


const submitCreate = () => {
  createForm.post(route('admin.categories.store'), {
    onSuccess: () => createForm.reset(),
    preserveScroll: true,
  });
};

const submitUpdate = (id: number) => {
  editForms.value[id].put(route('admin.categories.update', id), {
    preserveScroll: true,
  });
};

const submitDelete = (id: number) => {
    if (confirm('Sind Sie sicher, dass Sie diese Kategorie löschen möchten? Alle zugehörigen Events werden entkategorisiert.')) {
        useForm({}).delete(route('admin.categories.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
  <Head title="Kategorien verwalten" />
  <div class="p-4 sm:p-6 lg:p-8">
    <div class="mb-6">
      <Link :href="route('dashboard')" class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Zurück zum Dashboard
      </Link>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Linke Spalte: Neue Kategorie erstellen -->
      <div class="md:col-span-1">
        <div class="bg-white dark:bg-slate-800 shadow-sm rounded-lg">
          <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Neue Kategorie erstellen</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Fügen Sie eine neue Kategorie für die Klick-Analyse hinzu.</p>
          </div>
          <div class="px-6 pb-6">
            <form @submit.prevent="submitCreate">
              <div class="space-y-4">
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                  <input id="name" v-model="createForm.name" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                  <p v-if="createForm.errors.name" class="text-sm text-red-600 mt-1">{{ createForm.errors.name }}</p>
                </div>
                <button type="submit" :disabled="createForm.processing" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 disabled:opacity-25">
                  Erstellen
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Rechte Spalte: Bestehende Kategorien verwalten -->
      <div class="md:col-span-2">
        <div class="bg-white dark:bg-slate-800 shadow-sm rounded-lg">
           <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Bestehende Kategorien</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Bearbeiten oder löschen Sie hier Ihre Tracking-Kategorien.</p>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                  <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Anzahl Events</th>
                  <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aktionen</span></th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="category in categories" :key="category.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <!-- Dieser Check verhindert den Fehler, falls das Formular noch nicht initialisiert ist -->
                    <input v-if="editForms[category.id]" v-model="editForms[category.id].name" type="text" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">{{ category.events_count }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                    <button @click="submitUpdate(category.id)" :disabled="!editForms[category.id] || editForms[category.id].processing" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">Speichern</button>
                    <button @click="submitDelete(category.id)" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">Löschen</button>
                  </td>
                </tr>
                <tr v-if="categories.length === 0">
                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Keine Kategorien gefunden.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
