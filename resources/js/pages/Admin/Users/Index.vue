<script setup lang="ts">
import { defineProps } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue'; // Dein Hauptlayout
import { type BreadcrumbItem } from '@/types'; // Stelle sicher, dass dieser Typ existiert und korrekt ist
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

const destroy = (userId: number) => { // userId ist eine number, wenn es user.id ist
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
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full"> 
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">E-Mail</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rolle</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aktionen</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <tr v-if="users.length === 0">
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Keine Benutzer gefunden.</td>
                        </tr>
                        <tr v-for="user in users" :key="user.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100 text-center">{{ user.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">{{ user.email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">
                                <span v-if="user.roles && user.roles.length > 0">
                                    {{ user.roles[0].name }}
                                    </span>
                                <span v-else>
                                    Keine Rolle
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    
                                    <Link
                                        :href="route('settings.users.editRole', user.id)"
                                        class="px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        Rolle bearbeiten
                                    </Link>
                                    <button
                                        @click="destroy(user.id)"
                                        class="px-3 py-1.5 text-xs font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
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