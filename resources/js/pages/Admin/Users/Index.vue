<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'; // Dein Hauptlayout
import { type BreadcrumbItem } from '@/types'; // Stelle sicher, dass dieser Typ existiert und korrekt ist
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { route } from 'ziggy-js'; // Ziggy für Routennamen

// Props-Definition bleibt gleich
const props = defineProps({
    users: {
        type: Array as () => any[], // Typisiere dies genauer, wenn du ein User-Interface/Typ hast
        required: true,
    },
});

// --- BREADCRUMBS ANPASSEN ---
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Einstellungen', href: route('settings.profile.edit') }, // Link zur Profil-Einstellungsseite (oder einer anderen Haupt-Settings-Seite, z.B. settings.index, falls definiert)
    { title: 'Benutzerverwaltung' }, // Aktuelle Seite, daher kein href
];

const destroy = (userId: number) => {
    // userId ist eine number, wenn es user.id ist
    if (confirm('Möchten Sie diesen Benutzer wirklich löschen?')) {
        const form = useForm({});
        // --- ROUTENNAME FÜR destroy ANPASSEN ---
        form.delete(route('settings.users.destroy', userId), {
            preserveScroll: true,
            // onSuccess: () => alert('Benutzer gelöscht!'), // Optional
        });
    }
};
</script>

<template>
    <Head title="Benutzerverwaltung" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <h1 class="mb-4 text-2xl font-semibold">Benutzerverwaltung</h1>
            <div class="overflow-x-auto rounded-lg bg-white shadow-md">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Name</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                E-Mail
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Rolle</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                Aktionen
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-if="users.length === 0">
                            <td colspan="4" class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">Keine Benutzer gefunden.</td>
                        </tr>
                        <tr v-for="user in users" :key="user.id">
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ user.name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">{{ user.email }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">
                                <span v-if="user.roles && user.roles.length > 0">
                                    {{ user.roles[0].name }}
                                </span>
                                <span v-else> Keine Rolle </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    <Link
                                        :href="route('settings.users.editRole', user.id)"
                                        class="rounded-md bg-blue-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    >
                                        Rolle bearbeiten
                                    </Link>
                                    <button
                                        @click="destroy(user.id)"
                                        class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                    >
                                        Löschen
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Deine optionalen Styles. Ich habe Tailwind-Klassen für ein Basis-Styling hinzugefügt. */
/* table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
th { background-color: #f2f2f2; text-align: center;} */
</style>
