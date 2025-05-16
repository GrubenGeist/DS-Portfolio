<script setup lang="ts">
import { defineProps } from 'vue';
import { useForm, Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue'; // Dein Hauptlayout
import { type BreadcrumbItem } from '@/types'; // Stelle sicher, dass dieser Typ existiert
import { route } from 'ziggy-js';

const props = defineProps({
    user: {
        type: Object as () => any, // Genauer typisieren
        required: true,
    },
    roles: {
        type: Array as () => { id: number; name: string }[],
        required: true,
    },
});

const form = useForm({
    // Initialisiert das Formular mit dem Namen der ersten Rolle des Benutzers, falls vorhanden
    role: props.user.roles && props.user.roles.length > 0 ? props.user.roles[0].name : null,
});

const updateRole = () => {
    // --- ROUTENNAME FÜR updateRole ANPASSEN ---
    form.put(route('settings.users.updateRole', props.user.id), {
        // preserveScroll: true, // Optional
        // onSuccess: () => alert('Rolle aktualisiert!'), // Optional
    });
};

// --- BREADCRUMBS ANPASSEN ---
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Einstellungen', href: route('settings.profile.edit') }, // Oder settings.index
    { title: 'Benutzerverwaltung', href: route('settings.users.index') }, // Korrekter Link zurück
    { title: `Rolle für ${props.user.name} bearbeiten` },
];
</script>

<template>
    <Head :title="`Rolle für ${user.name} bearbeiten`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <h1 class="mb-6 text-2xl font-semibold">Rolle bearbeiten für <span class="font-bold">{{ user.name }}</span></h1>
            <form @submit.prevent="updateRole" class="p-6 bg-white shadow-md rounded-lg space-y-6">
                <div>
                    <label for="role-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rolle auswählen:</label>
                    <select
                        id="role-select"
                        v-model="form.role"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                    >
                        <option :value="null">-- Keine Rolle --</option>
                        <option v-for="roleOption in roles" :key="roleOption.id" :value="roleOption.name">
                            {{ roleOption.name }}
                        </option>
                    </select>
                    <div v-if="form.errors.role" class="text-red-500 text-sm mt-1">
                        {{ form.errors.role }}
                    </div>
                </div>

                <div class="flex items-center justify-start space-x-4 pt-2">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                    >
                        Speichern
                    </button>
                    
                    <Link
                        :href="route('settings.users.index')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-600 rounded-md hover:bg-gray-200 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                    >
                        Abbrechen
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>