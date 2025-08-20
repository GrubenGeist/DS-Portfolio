<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { useI18n } from 'vue-i18n';

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

// Definiere die Props, die vom Controller kommen
const props = defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
    user: {
        id: number;
        name: string;
        email: string;
    };
}>();

// WICHTIG: Die folgende Zeile MUSS entfernt oder auskommentiert sein,
// da wir das Layout manuell im <template> verwenden.
// defineOptions({ layout: AppLayout });

</script>

<template>
    <Head :title="t('profile.head_title')" />

    <!-- Das Layout wird hier manuell um den Inhalt gelegt. -->
    <!-- Dies ist die KORREKTE Methode für Seiten mit benannten Slots wie #header. -->
    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ $t('profile.header') }}</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">{{ $t('profile.section_title') }}</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $t('profile.section_description') }}</p>

                        <div class="mt-4">
                            <p><strong>{{ $t('profile.label_name') }}</strong> {{ props.user.name }}</p>
                            <p><strong>{{ $t('profile.label_email') }}</strong> {{ props.user.email }}</p>
                        </div>

                        <div v-if="props.status === 'profile-updated-placeholder'" class="mt-4 text-sm font-medium text-green-600">
                            {{ $t('profile.status_updated') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
