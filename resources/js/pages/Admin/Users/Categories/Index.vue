<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { useI18n } from 'vue-i18n';

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

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

const initializeEditForms = (categories: any[]) => {
  categories.forEach(cat => {
    if (!editForms.value[cat.id]) {
      editForms.value[cat.id] = useForm({ name: cat.name });
    }
  });
};

initializeEditForms(props.categories);

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
    // Verwenden Sie die `t`-Funktion für die Bestätigungsnachricht
    if (confirm(t('categories.confirm_delete'))) {
        useForm({}).delete(route('admin.categories.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
  <Head :title="t('categories.head_title')" />
  <div class="p-4 sm:p-6 lg:p-8">
    <div class="mb-6">
      <Link :href="route('dashboard')" class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        {{ $t('categories.back_to_dashboard') }}
      </Link>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Linke Spalte: Neue Kategorie erstellen -->
      <div class="md:col-span-1">
        <div class="bg-white dark:bg-slate-800 shadow-sm rounded-lg">
          <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $t('categories.create.title') }}</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $t('categories.create.description') }}</p>
          </div>
          <div class="px-6 pb-6">
            <form @submit.prevent="submitCreate">
              <div class="space-y-4">
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('categories.create.label_name') }}</label>
                  <input id="name" v-model="createForm.name" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" />
                  <p v-if="createForm.errors.name" class="text-sm text-red-600 mt-1">{{ createForm.errors.name }}</p>
                </div>
                <button type="submit" :disabled="createForm.processing" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150 disabled:opacity-25">
                  {{ $t('categories.create.button_create') }}
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
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $t('categories.manage.title') }}</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $t('categories.manage.description') }}</p>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('categories.table.header_name') }}</th>
                  <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('categories.table.header_events_count') }}</th>
                  <th scope="col" class="relative px-6 py-3"><span class="sr-only">{{ $t('categories.table.header_actions') }}</span></th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="category in categories" :key="category.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <input v-if="editForms[category.id]" v-model="editForms[category.id].name" type="text" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" />
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">{{ category.events_count }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                    <button @click="submitUpdate(category.id)" :disabled="!editForms[category.id] || editForms[category.id].processing" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">{{ $t('categories.table.button_save') }}</button>
                    <button @click="submitDelete(category.id)" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">{{ $t('categories.table.button_delete') }}</button>
                  </td>
                </tr>
                <tr v-if="categories.length === 0">
                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">{{ $t('categories.table.no_categories') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
