<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3'; // usePage ist schon da
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { route } from 'ziggy-js';
import { computed, ref } from 'vue'; // ref für usersList, computed für abgeleitete Zustände

// Definiere den Typ für einen Benutzer, wie er vom Controller kommt
interface User {
    id: number;
    name: string;
    email: string;
    roles: { name: string }[];
    // Füge hier weitere Felder hinzu, die vom Controller kommen
}

// Props, die vom Controller (PageController@dashboard) übergeben werden
const props = defineProps<{
    // breadcrumbs?: BreadcrumbItem[]; // Kommt jetzt über page.props ins Layout
    initialUsers: User[];
    userFetchError?: string | null; // Fehlermeldung vom Controller
}>();

defineOptions({ layout: AppLayout }); // Weise das Hauptlayout zu

// Die Breadcrumbs kommen jetzt über page.props (vom Controller an Inertia::render übergeben)
// und werden vom AppLayout konsumiert. Wir definieren sie hier nicht mehr lokal.
// const breadcrumbs: BreadcrumbItem[] = [
//     {
//         title: 'Dashboard',
//         href: route('dashboard'),
//     },
// ];

// Verwende die initialen Benutzerdaten aus den Props
const usersList = ref<User[]>(props.initialUsers);
const isLoadingUsers = ref(false); // Nicht mehr initial am Laden, da Daten schon da sind
const localUserFetchError = ref<string | null>(props.userFetchError || null);


// Die loadUsers-Funktion wird nicht mehr in onMounted aufgerufen,
// könnte aber für ein manuelles Neuladen (z.B. per Button) beibehalten werden.
// Fürs Erste kommentieren wir den automatischen Aufruf aus.
/*
async function loadUsers() {
    isLoadingUsers.value = true;
    localUserFetchError.value = null;
    try {
        const response = await fetch(route('api.users.index'), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'include',
        });

        if (!response.ok) {
            let errorResponseMessage = `HTTP error! Status: ${response.status} ${response.statusText}`;
            // ... (deine detailliertere Fehlerbehandlung von vorher) ...
            console.error('Error fetching users (details):', errorResponseMessage);
            localUserFetchError.value = errorResponseMessage;
            return;
        }
        const data = await response.json();
        usersList.value = data;
    } catch (error: any) {
        console.error('Fehler beim Laden der Benutzer:', error);
        localUserFetchError.value = error.message || 'Ein unbekannter Fehler ist aufgetreten.';
    } finally {
        isLoadingUsers.value = false;
    }
}

onMounted(() => {
    // loadUsers(); // Nicht mehr automatisch beim Mounten aufrufen
});
*/

function goToProfile() {
    router.visit(route('settings.profile.edit'));
}

</script>

<template>
    <Head title="Dashboard" />

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                    <p class="absolute inset-0 flex items-center justify-center">
                        <Link :href="route('settings.profile.edit')" class="text-white z-10">Mein Profil</Link>
                    </p>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                    <p class="absolute inset-0 flex items-center justify-center">
                        <AppLogoIcon class="h-16 w-16 z-10"/>
                    </p>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                    <p class="absolute inset-0 flex items-center justify-center text-white z-10">
                        {{ isLoadingUsers ? 'Lade Benutzer...' : `Anzahl Benutzer: ${usersList.length}` }}
                    </p>
                </div>
            </div>
            <div class="relative min-h-[calc(100vh-20rem)] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 md:min-h-min">
                <PlaceholderPattern v-if="isLoadingUsers && !localUserFetchError" />

                <div v-if="localUserFetchError" class="text-red-500 p-4 bg-red-100 border border-red-400 rounded">
                    <h3 class="font-bold">Fehler beim Laden der Benutzerdaten:</h3>
                    <p>{{ localUserFetchError }}</p>
                </div>

                <div v-if="!isLoadingUsers && !localUserFetchError && usersList.length > 0">
                    <h2 class="text-xl font-semibold mb-3 dark:text-white">Benutzerliste (Initial geladen)</h2>
                    <ul class="list-disc pl-5 dark:text-gray-300">
                        <li v-for="user in usersList" :key="user.id">
                            {{ user.name }} ({{ user.email }}) - Rollen: {{ user.roles.map(r => r.name).join(', ') || 'Keine' }}
                        </li>
                    </ul>
                </div>
                <div v-if="!isLoadingUsers && !localUserFetchError && usersList.length === 0" class="dark:text-gray-400">
                    Keine Benutzerdaten initial geladen.
                </div>
                <!--{/* Button zum manuellen Nachladen, falls gewünscht*/}-->
                <button @click="loadUsers" :disabled="isLoadingUsers" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50">
                    Benutzer neu laden
                </button>
                
            </div>
        </div>

</template>