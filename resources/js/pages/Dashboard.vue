<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch, onMounted, onUnmounted, reactive } from 'vue';
import { route } from 'ziggy-js';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import UserActivityTable from '@/components/UserActivityTable.vue';
import AnalyticsChart from '@/components/AnalyticsChart.vue';
import VisitorChart from '@/components/VisitorChart.vue';

// Props-Definitionen
interface User {
    id: number;
    name: string;
    email: string;
    roles: { name: string }[];
    last_login_at: string | null;
    is_online: boolean;
}

const props = defineProps<{
    initialUsers: any[];
    filters: any;
    stats: any;
    analyticsData: any;
    visitorData: any;
}>();

defineOptions({ layout: AppLayout, inheritAttrs: false });

// ZENTRALER STATE: Alle dynamischen Daten leben hier
const dashboardData = reactive({
    stats: props.stats,
    analyticsData: props.analyticsData,
    visitorData: props.visitorData,
});

// ZENTRALES FILTER-OBJEKT
const filters = reactive({
    show_all: props.filters.show_all,
    analytics_year: props.analyticsData.filters.year,
    analytics_month: props.analyticsData.filters.month,
    visitor_year: props.visitorData.filters.year,
    visitor_month: props.visitorData.filters.month,
});

// ZENTRALE DATEN-ABRUF-FUNKTION
async function fetchData() {
    try {
        const csrf = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content;
        const url = new URL(route('dashboard.data'), window.location.origin);
        Object.entries(filters).forEach(([key, value]) => {
            url.searchParams.set(key, String(value));
        });

        const response = await fetch(url.toString(), {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf || '' }
        });
        const data = await response.json();
        
        dashboardData.stats = data.stats;
        dashboardData.analyticsData = data.analyticsData;
        dashboardData.visitorData = data.visitorData;
    } catch (error) {
        console.error('Fehler beim Abrufen der Dashboard-Daten:', error);
    }
}

// Handler-Funktionen für die Filter-Events der Kinder
function updateAnalyticsFilters(newFilters: { year: string, month: string }) {
    filters.analytics_year = parseInt(newFilters.year);
    filters.analytics_month = parseInt(newFilters.month);
    fetchData();
}
function updateVisitorFilters(newFilters: { year: string, month: string }) {
    filters.visitor_year = parseInt(newFilters.year);
    filters.visitor_month = parseInt(newFilters.month);
    fetchData();
}

// Watcher für die "Alle Benutzer anzeigen"-Checkbox
watch(() => filters.show_all, () => {
    // Hier nutzen wir Inertia, da sich die `initialUsers`-Prop ändert
    router.get(route('dashboard'), filters, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
});


// ZENTRALES POLLING für Live-Daten
let pollingIntervalId: number | null = null;
onMounted(() => {
    pollingIntervalId = window.setInterval(fetchData, 5000);
});
onUnmounted(() => {
    if (pollingIntervalId) clearInterval(pollingIntervalId);
});
</script>


<template>
    <Head title="Dashboard" />
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <div class="p-6 bg-white dark:bg-slate-800 rounded-xl border border-border">
                <h3 class="text-sm font-medium text-muted-foreground">Gesamte Zustimmungen</h3>
                <p class="text-3xl font-bold">{{ dashboardData.stats.totalConsents }}</p>
            </div>
            <div class="p-6 bg-white dark:bg-slate-800 rounded-xl border border-border">
                <h3 class="text-sm font-medium text-muted-foreground">Analyse-Zustimmungsrate</h3>
                <p class="text-3xl font-bold">{{ dashboardData.stats.analyticsAcceptanceRate }}%</p>
            </div>
             <div class="p-6 bg-white dark:bg-slate-800 rounded-xl border border-border">
                <h3 class="text-sm font-medium text-muted-foreground">Aktive Besucher (5 Min.)</h3>
                <!-- KORREKTUR: Greift auf den zentralen State zu -->
                <p class="text-3xl font-bold">{{ dashboardData.visitorData.activeNow }}</p>
            </div>
            <div class="p-6 bg-white dark:bg-slate-800 rounded-xl border border-border"></div>
        </div>
        
        <AnalyticsChart :data="dashboardData.analyticsData" @update:filters="updateAnalyticsFilters" />
        <!-- KORREKTUR: Übergibt den korrekten Wert aus dem zentralen State -->
        <VisitorChart :data="dashboardData.visitorData" :active-now="dashboardData.visitorData.activeNow" @update:filters="updateVisitorFilters" />
        
        <div class="relative flex-1 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
             <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold dark:text-white">Benutzer-Aktivität</h2>
                <div class="flex items-center space-x-2">
                    <!-- KORREKTUR: v-model ist an den zentralen Filter-State gebunden -->
                    <Checkbox id="show-all" v-model:checked="filters.show_all" />
                    <Label for="show-all" class="text-sm font-medium">Alle Benutzer anzeigen</Label>
                </div>
            </div>
            <UserActivityTable :users="initialUsers" />
        </div>
    </div>
</template>