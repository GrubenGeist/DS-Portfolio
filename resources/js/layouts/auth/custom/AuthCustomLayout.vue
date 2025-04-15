<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
//import AppHeader from '@/components/AppHeader.vue'; // Direkter Import, wenn du AppHeaderLayout nicht brauchst
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppLogo from '@/components/AppLogo.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import WebsiteLogoIcon from '@/components/WebsiteLogoIcon.vue';
// Importiere ggf. eine Sidebar-Komponente, wenn du eine hast
// import Sidebar from '@/components/Sidebar.vue';

// Zugriff auf Shared Data (Benutzer, Rollen etc.)
const page = usePage();
const user = page.props.auth.user; // User-Objekt mit id, name, email, roles[]

// Beispiel: Zustand für mobile Sidebar (falls nötig)
const showingSidebar = ref(false);

// Hilfsfunktion (optional, aber sauberer)
const hasRole = (roleName: string): boolean => {
  return user?.roles?.includes(roleName) ?? false;
};

// Breadcrumbs könnten hier definiert oder von der Seite übergeben werden
// Für dieses Beispiel lassen wir sie weg, dein AppHeader braucht sie aber ggf.
// const breadcrumbs = computed(() => ... );
</script>

<template>
    <Head title="Anwendung" /> <AppShell class="flex flex-col h-screen"> <AppHeader :breadcrumbs="page.props.breadcrumbs || []" /> <div class="flex flex-1 overflow-hidden">
            <nav class="w-64 bg-gray-100 p-4 overflow-y-auto"> 
                <SheetHeader class="flex justify-center text-left">
                    <AppLogoIcon class="text-black dark:text-white"/>
                </SheetHeader>
                <h2 class="font-bold mb-4">Navigation</h2>
                <ul>
                    <li><Link :href="route('dashboard')" :class="{ 'font-bold': route().current('Dashboard') }">Dashboard</Link></li>
                    <li><Link :href="route('projects')" :class="{ 'font-bold': route().current('Projekte') }">Projekte</Link></li>
                    <li><Link :href="route('services')" :class="{ 'font-bold': route().current('Dienstleistungen') }">Dienstleistungen</Link></li>
                    <li><Link :href="route('aboutme')" :class="{ 'font-bold': route().current('Über Mich') }">Über Mich</Link></li>
                    <li><Link :href="route('test')" :class="{ 'font-bold': route().current('testseite') }">Testseite</Link></li>


                    <li v-if="hasRole('Admin')">
                        <Link :href="route('admin.users.index')" :class="{ 'font-bold': route().current('admin.users.index') }">Benutzer (Admin)</Link>
                    </li>

                    <li class="mt-auto pt-4">
                         <Link :href="route('logout')" method="post" as="button" class="text-red-600">Logout</Link>
                    </li>
                </ul>
                 <div v-if="user" class="mt-4 p-2 bg-gray-200 rounded">
                    Eingeloggt als: {{ user.name }} ({{ user.roles.join(', ') }})
                </div>
            </nav>

            <AppContent class="flex-1 overflow-y-auto p-6">
                <slot />
            </AppContent>
        </div>
    </AppShell>
</template>

<style scoped>
/* Füge hier ggf. spezifische Styles hinzu */
li {
    margin-bottom: 0.5rem;
}
</style>