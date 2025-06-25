<script setup lang="ts">
import { defineProps } from 'vue';

// Die Props bleiben genau gleich
interface User {
    id: number;
    name: string;
    email: string;
    roles: { name: string }[];
    last_login_at: string | null;
    is_online: boolean;
}

const props = defineProps<{
    users: User[];
}>();

// Die Helfer-Funktion bleibt auch gleich
function formatLastLogin(user: User): string {
    if (!user.last_login_at) {
        return 'Nie';
    }
    return new Date(user.last_login_at).toLocaleString('de-DE', { dateStyle: 'short', timeStyle: 'short'});
}
</script>

<template>
    <div class="overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-800">
        <div class="max-h-[30rem] overflow-y-auto">
            <table class="min-w-full text-sm">

                <thead class="sticky top-0 bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Name</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">E-Mail</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Rolle</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Letzter Login</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                    <tr v-if="users.length === 0">
                        <td colspan="5" class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">Für die aktuelle Auswahl wurden keine Benutzer gefunden.</td>
                    </tr>
                    <tr v-for="user in users" :key="user.id">
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                            <div class="flex items-center justify-center">
                                <span class="h-2.5 w-2.5 rounded-full" :class="user.is_online ? 'bg-green-500' : 'bg-gray-400'"></span>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100">{{ user.name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">{{ user.email }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">{{ user.roles.map((r) => r.name).join(', ') || 'Keine' }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">{{ formatLastLogin(user) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>