<script setup lang="ts">

import AuthCustomLayout from '@/layouts/auth/custom/AuthCustomLayout.vue'; // Pfad prüfen!
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue'; // Pfad prüfen!
import AppLogoIcon from '@/components/AppLogoIcon.vue'; // Pfad prüfen!
import { route } from 'ziggy-js';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        // Hinweis: Wenn du hier klickbar machen willst, stelle sicher,
        // dass die Route 'dashboard' (klein) existiert und im Frontend bekannt ist.
        // href: route('dashboard'), // Beispiel, falls 'dashboard' Route existiert und in Ziggy ist
        href: '/dashboard', // Sicherer, wenn Name unklar oder für einfachen Pfad
    },
];

// Diese Funktion bleibt erhalten, wird aber im Template unten nicht verwendet.
// Sie nutzt den korrekten Routennamen 'profile.edit'.
function goToProfile() {
    router.visit(route('profile.edit'));
}

// Diese Funktion bleibt erhalten, um die Benutzerdaten zu laden.
// Der 500-Fehler, den sie auslöst, muss im Backend behoben werden (siehe laravel.log).
async function loadUsers() {
   try {
        const response = await fetch(route('api.users.index'));
        // Prüfen, ob die Antwort erfolgreich war (Status 2xx)
        if (!response.ok) {
            // Wenn nicht OK (z.B. 500er), Fehler werfen oder loggen
            console.error(`Error fetching users: ${response.status} ${response.statusText}`);
            // Optional: Versuche, den Fehlertext zu lesen, falls es kein HTML ist
            // const errorText = await response.text();
            // console.error('Server response:', errorText);
            return; // Funktion hier beenden
        }
        // Nur parsen, wenn Antwort OK war
        const users = await response.json();
        console.log('Geladene Benutzer:', users); // Log angepasst für Klarheit
   } catch (error) {
        console.error('Fehler beim Laden der Benutzer:', error);
        // Hier könnten auch Netzwerkfehler etc. landen
   }
}

// --- GELÖSCHT --- Die folgende Funktion und der console.log wurden entfernt,
// --- da sie den 'users.profile'-Fehler verursachten.
// function getUserProfileUrl(userId) {
//  return route('users.profile', { id: userId });
// }
// console.log(getUserProfileUrl(5));
// --- ENDE GELÖSCHT ---

// Ruft loadUsers() auf, wenn die Komponente geladen wird.
loadUsers();

</script>

<template>
    <Head title="Dashboard" />

    <AuthCustomLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                    <p class="absolute inset-0 flex items-center justify-center"> <Link :href="route('profile.edit')" class="text-white z-10">Mein Profil</Link>
                    </p>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                    <p class="absolute inset-0 flex items-center justify-center"> <AppLogoIcon class="h-16 w-16 z-10"/> </p>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                    <p class="absolute inset-0 flex items-center justify-center text-white z-10"> TEST
                    </p>
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <PlaceholderPattern />
                <p class="absolute inset-0 flex items-center justify-center text-white z-10"> TEST
                </p>
            </div>
        </div>
    </AuthCustomLayout>
</template>