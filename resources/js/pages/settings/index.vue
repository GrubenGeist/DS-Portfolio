// resources/js/Pages/Settings/Index.vue

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'; // Dein Hauptlayout
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Palette, ShieldCheck, UserCircle, Users } from 'lucide-vue-next'; // Beispiel-Icons
import { computed } from 'vue';

defineOptions({ layout: AppLayout });

// Props, die vom SettingsController kommen (hier nur breadcrumbs als Beispiel)
const props = defineProps<{
    breadcrumbs: BreadcrumbItem[];
}>();

const page = usePage();
const currentUserRoles = computed(() => page.props.auth.user?.roles || []);
const isAdmin = computed(() => currentUserRoles.value.includes('Admin'));

interface SettingLink {
    href: string;
    title: string;
    description: string;
    icon: any; // Typ für Lucide Icon Komponenten
    show: boolean;
}

const settingLinks = computed<SettingLink[]>(() => [
    {
        href: route('settings.profile.edit'),
        title: 'Profil bearbeiten',
        description: 'Persönliche Informationen und E-Mail-Adresse aktualisieren.',
        icon: UserCircle,
        show: true,
    },
    {
        href: route('settings.password.edit'),
        title: 'Passwort ändern',
        description: 'Sicherheit durch ein neues Passwort erhöhen.',
        icon: ShieldCheck,
        show: true,
    },
    {
        href: route('settings.appearance'),
        title: 'Erscheinungsbild',
        description: 'Anpassen, wie die Anwendung für dich aussieht.',
        icon: Palette,
        show: true, // Du kannst hier auch eine Feature-Flag oder ähnliches prüfen
    },
    {
        href: route('admin.users.index'),
        title: 'Benutzerverwaltung',
        description: 'Benutzerkonten und deren Rollen verwalten.',
        icon: Users,
        show: isAdmin.value, // Nur für Admins anzeigen
    },
]);
</script>

<template>
    <Head title="Einstellungen" />
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Einstellungen</h1>
                <p class="mt-1 text-lg text-gray-600 dark:text-gray-400">Verwalte hier deine Account-Einstellungen und Präferenzen.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div
                    v-for="link in settingLinks.filter((l) => l.show)"
                    :key="link.href"
                    class="overflow-hidden bg-white p-6 shadow-sm transition-colors hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 sm:rounded-lg"
                >
                    <Link :href="link.href" class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <component :is="link.icon" class="h-8 w-8 text-indigo-600 dark:text-indigo-400" aria-hidden="true" />
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ link.title }}</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ link.description }}</p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
