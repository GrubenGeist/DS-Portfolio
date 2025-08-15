<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive, watch, onMounted, onUnmounted } from 'vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import UserActivityTable from '@/components/UserActivityTable.vue';
import AnalyticsChart from '@/components/AnalyticsChart.vue';
import VisitorChart from '@/components/VisitorChart.vue';

const props = defineProps<{
    initialUsers: any[];
    filters: any;
    stats: any;
    analyticsData: any;
    visitorData: any;
}>();

defineOptions({ layout: AppLayout, inheritAttrs: false });

const dashboardData = reactive({
    stats: props.stats,
    analyticsData: props.analyticsData,
    visitorData: props.visitorData,
});

const filters = reactive({
    show_all: props.filters.show_all || false,
    analytics_year: props.analyticsData.filters.year,
    analytics_month: props.analyticsData.filters.month,
    analytics_category_id: props.analyticsData.filters.category_id || 'all',
    visitor_year: props.visitorData.filters.year,
    visitor_month: props.visitorData.filters.month,
    // NEU: Geräte-Filter im zentralen State
    visitor_device_type: props.visitorData.filters.device_type || 'all',
});

async function fetchData() {
    try {
        const url = new URL(route('dashboard.data'), window.location.origin);
        Object.entries(filters).forEach(([key, value]) => {
            if (value !== null && value !== undefined) {
                url.searchParams.set(key, String(value));
            }
        });

        const response = await fetch(url.toString(), {
            headers: { 'Accept': 'application/json' }
        });
        if (!response.ok) throw new Error('Netzwerk-Antwort war nicht ok.');
        
        const data = await response.json();
        
        if (data && data.stats) dashboardData.stats = data.stats;
        if (data && data.analyticsData) dashboardData.analyticsData = data.analyticsData;
        if (data && data.visitorData) dashboardData.visitorData = data.visitorData;

    } catch (error) {
        console.error('Fehler beim Abrufen der Dashboard-Daten:', error);
    }
}

function updateAnalyticsFilters(newFilters: { year: string, month: string, category_id: string | number }) {
    filters.analytics_year = parseInt(newFilters.year, 10);
    filters.analytics_month = newFilters.month === 'all' ? 'all' : parseInt(newFilters.month, 10);
    filters.analytics_category_id = newFilters.category_id;
    fetchData();
}

// NEU: Handler für Besucher-Filter wurde erweitert
function updateVisitorFilters(newFilters: { year: string, month: string, device_type: string }) {
    filters.visitor_year = parseInt(newFilters.year, 10);
    filters.visitor_month = newFilters.month === 'all' ? 'all' : parseInt(newFilters.month, 10);
    filters.visitor_device_type = newFilters.device_type;
    fetchData();
}

watch(() => filters.show_all, (newValue) => {
    router.get(route('dashboard'), { show_all: newValue }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
});

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
        <!-- Stat-Karten -->
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
                <p class="text-3xl font-bold">{{ dashboardData.visitorData.activeNow }}</p>
            </div>
             <div class="p-6 bg-white dark:bg-slate-800 rounded-xl border border-border">
                 <h3 class="text-sm font-medium text-muted-foreground">Klicks heute</h3>
                 <p class="text-3xl font-bold">{{ dashboardData.analyticsData.totalToday }}</p>
            </div>
        </div>
        
        <!-- Chart-Komponenten -->
        <AnalyticsChart :data="dashboardData.analyticsData" @update:filters="updateAnalyticsFilters" />
        <VisitorChart :data="dashboardData.visitorData" @update:filters="updateVisitorFilters" />
        
        <!-- Benutzer-Aktivitätstabelle -->
        <div class="relative flex-1 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold dark:text-white">Benutzer-Aktivität</h2>
                <div class="flex items-center space-x-2">
                    <Checkbox id="show-all" v-model:checked="filters.show_all" />
                    <Label for="show-all" class="text-sm font-medium">Alle Benutzer anzeigen</Label>
                </div>
            </div>
            <UserActivityTable :users="initialUsers" />
        </div>
    </div>
</template>
