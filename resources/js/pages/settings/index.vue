// resources/js/Pages/Settings/Index.vue

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Palette, ShieldCheck, UserCircle, Users } from 'lucide-vue-next';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import SettingsLayout from '@/layouts/settings/Layout.vue';

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

defineOptions({ layout: AppLayout });

const props = defineProps<{
    breadcrumbs: BreadcrumbItem[];
}>();

const page = usePage();
const currentUserRoles = computed(() => (page.props as any).auth.user?.roles || []);
const isAdmin = computed(() => currentUserRoles.value.includes('Admin'));

interface SettingLink {
    href: string;
    title: string;
    description: string;
    icon: any;
    show: boolean;
}

// Die Links sind jetzt eine "computed" Eigenschaft, um auf Sprachwechsel zu reagieren
const settingLinks = computed<SettingLink[]>(() => [
    {
        href: route('settings.profile.edit'),
        title: t('settings.index.profile.title'),
        description: t('settings.index.profile.description'),
        icon: UserCircle,
        show: true,
    },
    {
        href: route('settings.password.edit'),
        title: t('settings.index.password.title'),
        description: t('settings.index.password.description'),
        icon: ShieldCheck,
        show: true,
    },
    {
        // HIER IST DIE KORREKTUR: 'settings.appearance' zu 'settings.appearance.edit' geändert
        href: route('settings.appearance.edit'),
        title: t('settings.index.appearance.title'),
        description: t('settings.index.appearance.description'),
        icon: Palette,
        show: true,
    },
    {
        href: route('admin.users.index'),
        title: t('settings.index.user_management.title'),
        description: t('settings.index.user_management.description'),
        icon: Users,
        show: isAdmin.value,
    },
]);
</script>

<template>
    <Head :title="t('settings.index.head_title')" />
    <SettingsLayout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $t('settings.index.headline') }}</h1>
                <p class="mt-1 text-lg text-gray-600 dark:text-gray-400">{{ $t('settings.index.description') }}</p>
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
    </SettingsLayout>
</template>
