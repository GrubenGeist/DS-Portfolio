<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'; // Dein Hauptlayout
import { type BreadcrumbItem } from '@/types'; // Stelle sicher, dass dieser Typ existiert
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';


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
    { title: `Rolle für ${props.user.first_name} ${props.user.last_name} bearbeiten` },
];
</script>

<template>
    <Head :title="`Rolle für ${user.first_name} ${user.last_name} bearbeiten`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
            <h1 class="mb-6 text-2xl font-semibold">
                Rolle bearbeiten für <span class="font-bold">{{ user.first_name }} {{ user.last_name }}</span>
            </h1>
            <form @submit.prevent="updateRole" class="space-y-6 rounded-lg bg-white p-6 shadow-md">
                <div>
                    <label for="role-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rolle auswählen:</label>
                    <select
                        id="role-select"
                        v-model="form.role"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 sm:text-sm"
                    >
                        <option :value="null">-- Keine Rolle --</option>
                        <option v-for="roleOption in roles" :key="roleOption.id" :value="roleOption.name">
                            {{ roleOption.name }}
                        </option>
                    </select>
                    <div v-if="form.errors.role" class="mt-1 text-sm text-red-500">
                        {{ form.errors.role }}
                    </div>
                </div>

                <div class="flex items-center justify-start space-x-4 pt-2">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                    >
                        Speichern
                    </button>

                    <Link
                        :href="route('settings.users.index')"
                        class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500"
                    >
                        Abbrechen
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
