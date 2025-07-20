<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, type ChartOptions } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

// Chart.js und das Datalabels-Plugin registrieren
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ChartDataLabels);

const months = [
    { value: 'all', label: 'Alle Monate' },
    { value: '1', label: 'Januar' }, { value: '2', label: 'Februar' }, { value: '3', 'label': 'März' },
    { value: '4', label: 'April' }, { value: '5', label: 'Mai' }, { value: '6', 'label': 'Juni' },
    { value: '7', label: 'Juli' }, { value: '8', label: 'August' }, { value: '9', 'label': 'September' },
    { value: '10', label: 'Oktober' }, { value: '11', label: 'November' }, { value: '12', 'label': 'Dezember' },
];

const props = defineProps<{ data: any }>();
const emit = defineEmits(['update:filters']);

const localFilters = reactive({
  year: props.data?.filters?.year?.toString() || new Date().getFullYear().toString(),
  month: props.data?.filters?.month?.toString() || 'all', 
  category_id: props.data?.filters?.category_id?.toString() || 'all',
});

watch(localFilters, (newValues) => {
  emit('update:filters', newValues);
});

watch(() => props.data?.filters, (newFilters) => {
  localFilters.year = newFilters?.year?.toString() || new Date().getFullYear().toString();
  localFilters.month = newFilters?.month?.toString() || 'all';
  localFilters.category_id = newFilters?.category_id?.toString() || 'all';
}, { deep: true });


const chartData = computed(() => {
  const originalLabels = props.data?.history?.map((item: any) => item.label || 'Unbekannt') || [];
  const originalData = props.data?.history?.map((item: any) => item.total) || [];
  let labels = [...originalLabels];
  if (originalLabels.length === 1) {
    labels.push('', '', '', '', '');
  }
  return {
    labels: labels,
    datasets: [{
      backgroundColor: '#06b6d4',
      borderRadius: 4,
      barPercentage: 0.6,
      maxBarThickness: 80,
      data: originalData,
    }],
  };
});

// Konfiguriert das Aussehen des Charts.
const chartOptions = computed(() => {
    const isDarkMode = document.documentElement.classList.contains('dark');
    const textColor = isDarkMode ? 'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)';
    const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

    return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { enabled: true },
            datalabels: {
                anchor: 'end',
                align: 'end',
                color: textColor,
                font: { weight: 'bold' },
                formatter: (value: number) => value > 0 ? value : null,
                offset: -4,
            },
        },
        scales: {
            x: { 
                grid: { display: false }, 
                ticks: { color: textColor, font: { size: 12 } } 
            },
            y: { 
                display: true, 
                beginAtZero: true,
                grid: { color: gridColor },
                ticks: { 
                    color: textColor, 
                    font: { size: 12 },
                    precision: 0,
                },
                title: {
                    display: true,
                    text: 'Anzahl der Klicks',
                    color: textColor,
                    font: { size: 14 }
                },
                // KORREKTUR: Fügt oben auf der Y-Achse etwas zusätzlichen Platz hinzu (z.B. 10%),
                // damit die Beschriftung des höchsten Balkens nicht abgeschnitten wird.
                grace: '10%'
            },
        },
    } as ChartOptions<'bar'>;
});
</script>

<template>
  <Card>
    <CardHeader>
      <div class="flex flex-wrap justify-between items-start gap-4">
        <div>
          <CardTitle>Klick-Analyse</CardTitle>
          <CardDescription>Anzahl der Klicks pro Event.</CardDescription>
          <p class="mt-2 text-2xl font-bold">{{ props.data?.totalToday || 0 }} <span class="text-sm font-normal text-muted-foreground">Klicks heute</span></p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <Select v-model="localFilters.category_id">
            <SelectTrigger class="w-[180px]"><SelectValue placeholder="Kategorie filtern" /></SelectTrigger>
            <SelectContent>
              <SelectItem value="all">Alle Kategorien</SelectItem>
              <SelectItem v-for="cat in props.data?.availableCategories || []" :key="cat.id" :value="cat.id.toString()">{{ cat.name }}</SelectItem>
            </SelectContent>
          </Select>
          <Select v-model="localFilters.month">
            <SelectTrigger class="w-[140px]"><SelectValue placeholder="Monat" /></SelectTrigger>
            <SelectContent>
              <SelectItem v-for="m in months" :key="m.value" :value="m.value">{{ m.label }}</SelectItem>
            </SelectContent>
          </Select>
          <Select v-model="localFilters.year">
            <SelectTrigger class="w-[100px]"><SelectValue placeholder="Jahr" /></SelectTrigger>
            <SelectContent>
              <SelectItem v-for="y in props.data?.availableYears || []" :key="y" :value="y.toString()">{{ y }}</SelectItem>
            </SelectContent>
          </Select>
          <Link :href="route('admin.categories.index')" class="p-2 text-gray-500 dark:text-gray-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Kategorien verwalten">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="sr-only">Kategorien verwalten</span>
          </Link>
        </div>
      </div>
    </CardHeader>
    <CardContent>
      <div class="h-[250px]">
        <Bar v-if="props.data?.history && props.data.history.length > 0" :data="chartData" :options="chartOptions" />
        <p v-else class="flex items-center justify-center h-full text-sm text-muted-foreground">Keine Klicks für diesen Zeitraum.</p>
      </div>
    </CardContent>
  </Card>
</template>
