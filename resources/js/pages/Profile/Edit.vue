<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'; // Passe dies an dein Layout an
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue'; // Import für defineProps

// Definiere die Props, die vom Controller kommen
const props = defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
    user: { // Typisiere dies genauer mit einem Interface, wenn möglich
        id: number;
        name: string;
        email: string;
        // Füge weitere benötigte User-Felder hinzu
    };
}>();

// Hier könntest du Logik für Formulare hinzufügen (siehe Breeze/Jetstream für Beispiele)
// z.B. mit useForm von Inertia für das Update

</script>

<template>
    <Head title="Profil" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Profil Einstellungen</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <h3 class="text-lg font-medium">Profil Informationen</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Hier kannst du deine Account-Daten ansehen/aktualisieren.
                        </p>

                        <div class="mt-4">
                            <p><strong>Name:</strong> {{ props.user.name }}</p>
                            <p><strong>Email:</strong> {{ props.user.email }}</p>
                            </div>

                         <div v-if="props.status === 'profile-updated-placeholder'" class="mt-4 text-sm font-medium text-green-600">
                            Profil provisorisch aktualisiert (Platzhalter).
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>