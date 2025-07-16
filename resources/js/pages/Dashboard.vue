<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { route } from 'ziggy-js';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import UserActivityTable from '@/components/UserActivityTable.vue';
import AnalyticsChart from '@/components/AnalyticsChart.vue';

// Typ-Definitionen
interface User {
    id: number;
    name: string;
    email: string;
    roles: { name: string }[];
    last_login_at: string | null;
    is_online: boolean;
}

// === KORREKTUR HIER ===
// Wir definieren den Typ für ein einzelnes Event-Objekt
interface TopEvent {
    category: string;
    action: string;
    label: string | null;
    total: number;
}

// Prop-Definitionen
const props = defineProps<{
    initialUsers: User[];
    filters: { show_all: boolean; };
    stats: {
        totalConsents: number;
        analyticsAcceptanceRate: number;
    };
    // Wir definieren topEvents als Array von TopEvent-Objekten
    analyticsData: {
        today: { label: string | null; total: number }[];
        month: { label: string | null; total: number }[];
        year: { label: string | null; total: number }[];
    };
}>();

defineOptions({
    layout: AppLayout,
    inheritAttrs: false,
});

// Filter-Logik bleibt unverändert
const showAll = ref(props.filters.show_all || false);

watch(showAll, (newValue) => {
    router.get(route('dashboard'), { show_all: newValue }, {
        preserveState: false,
        preserveScroll: true,
    });
});
</script>

<template>
    <Head title="Dashboard" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
             <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <AnalyticsChart :data="analyticsData" />                    
             </div>
             <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                 <PlaceholderPattern />
                 <p class="absolute inset-0 flex items-center justify-center">
                     <AppLogoIcon class="z-10 h-16 w-16" />
                 </p>
             </div>
             <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                 <PlaceholderPattern />
                 <p class="absolute inset-0 z-10 flex items-center justify-center text-white">
                     Angezeigte Benutzer: {{ initialUsers.length }}
                 </p>
             </div>
        </div>

        <div class="relative flex-1 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
            
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold dark:text-white">Benutzer-Aktivität</h2>
                <div class="flex items-center space-x-2">
                    <Checkbox id="show-all" v-model:checked="showAll" />
                    <Label for="show-all" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                        Alle Benutzer anzeigen
                    </Label>
                </div>
            </div>
            
            <UserActivityTable :users="initialUsers" />

        </div>
    </div>
</template>