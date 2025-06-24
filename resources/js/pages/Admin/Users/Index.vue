<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { defineProps, reactive, watch } from 'vue'; // reactive und watch importieren
import { route } from 'ziggy-js';
import throttle from 'lodash/throttle'; // throttle für die Such-Verzögerung
import { Input } from '@/components/ui/input'; // UI-Komponente für das Suchfeld
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'; // UI-Komponenten für das Dropdown

// Props empfangen die Daten vom Controller, inklusive der Filter
const props = defineProps({
    users: {
        type: Array as () => any[],
        required: true,
    },
    filters: {
        type: Object as () => { search: string, role: string },
        required: true,
    },
});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Einstellungen', href: route('settings.profile.edit') },
    { title: 'Benutzerverwaltung' },
];

// Ein reaktives Objekt, das den Zustand unserer Filterfelder speichert
const filterForm = reactive({
    search: props.filters.search || '',
    role: props.filters.role || 'all', // Standardwert ist jetzt 'all'
});

// Beobachtet das filterForm-Objekt auf Änderungen und sendet eine neue Anfrage an Laravel
watch(filterForm, throttle(() => {
    router.get(route('admin.users.index'), filterForm, {
        preserveState: true,
        replace: true,
    });
}, 300));

// Die Löschen-Funktion bleibt unverändert
const destroy = (userId: number) => {
    if (confirm('Möchten Sie diesen Benutzer wirklich löschen?')) {
        router.delete(route('admin.users.destroy', userId), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Benutzerverwaltung" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <h1 class="mb-4 text-2xl font-semibold">Benutzerverwaltung</h1>

            <div class="mb-4 flex items-center space-x-4 rounded-lg bg-white p-4 shadow-md dark:bg-gray-800">
                <div class="flex-1">
                    <Input
                        v-model="filterForm.search"
                        type="text"
                        placeholder="Suche nach Name, Firma, E-Mail..."
                        class="w-full"
                    />
                </div>
                <div>
                    <Select v-model="filterForm.role">
                        <SelectTrigger class="w-[180px]">
                            <SelectValue placeholder="Rolle filtern" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">Alle Rollen</SelectItem>
                            <SelectItem value="Admin">Nur Admins</SelectItem>
                            <SelectItem value="Company">Nur Firmen</SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg bg-white shadow-md">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Vorname</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Nachname</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">E-Mail</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Rolle</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Aktionen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-if="users.length === 0">
                            <td colspan="5" class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">Keine Benutzer für die aktuellen Filter gefunden.</td>
                        </tr>
                        <tr v-for="user in users" :key="user.id">
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ user.first_name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ user.last_name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">{{ user.email }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">
                                <span v-if="user.roles && user.roles.length > 0">{{ user.roles[0].name }}</span>
                                <span v-else>Keine Rolle</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    <Link :href="route('admin.users.editRole', user.id)" class="rounded-md bg-blue-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-700">Rolle bearbeiten</Link>
                                    <button @click="destroy(user.id)" class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">Löschen</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>