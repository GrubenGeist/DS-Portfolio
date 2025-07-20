<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import { Line } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
  type ChartOptions,
} from 'chart.js';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, CategoryScale, LinearScale);

const props = defineProps<{
  data: any;
}>();

const emit = defineEmits(['update:filters']);

const months = [
    { value: 'all', label: 'Alle Monate' },
    { value: '1', label: 'Januar' }, { value: '2', label: 'Februar' }, { value: '3', 'label': 'März' },
    { value: '4', label: 'April' }, { value: '5', label: 'Mai' }, { value: '6', 'label': 'Juni' },
    { value: '7', label: 'Juli' }, { value: '8', label: 'August' }, { value: '9', 'label': 'September' },
    { value: '10', label: 'Oktober' }, { value: '11', label: 'November' }, { value: '12', 'label': 'Dezember' },
];

const localFilters = reactive({
  year: props.data?.filters?.year?.toString() || new Date().getFullYear().toString(),
  month: props.data?.filters?.month?.toString() || 'all',
  device_type: props.data?.filters?.device_type || 'all',
});

watch(localFilters, (newValues) => {
  emit('update:filters', newValues);
});

watch(() => props.data?.filters, (newFilters) => {
  localFilters.year = newFilters?.year?.toString() || new Date().getFullYear().toString();
  localFilters.month = newFilters?.month?.toString() || 'all';
  localFilters.device_type = newFilters?.device_type || 'all';
}, { deep: true });

// NEU: Berechnet die prozentuale Verteilung von Desktop vs. Mobil
const devicePercentages = computed(() => {
  const history = props.data?.history || [];
  if (history.length === 0) {
    return { desktop: 0, mobile: 0 };
  }

  const totalDesktop = history.reduce((sum, item) => sum + item.desktop, 0);
  const totalMobile = history.reduce((sum, item) => sum + item.mobile, 0);
  const totalVisitors = totalDesktop + totalMobile;

  if (totalVisitors === 0) {
    return { desktop: 0, mobile: 0 };
  }

  const desktopPercentage = Math.round((totalDesktop / totalVisitors) * 100);
  const mobilePercentage = Math.round((totalMobile / totalVisitors) * 100);

  return { desktop: desktopPercentage, mobile: mobilePercentage };
});

const chartData = computed(() => {
  const history = props.data?.history || [];
  
  const labels = history.map((item: any) => 
    new Date(item.date).toLocaleDateString('de-DE', { day: '2-digit', month: '2-digit' })
  );
  
  const desktopData = history.map((item: any) => item.desktop);
  const mobileData = history.map((item: any) => item.mobile);

  return {
    labels: labels,
    datasets: [
      {
        label: 'Desktop',
        data: desktopData,
        borderColor: '#3b82f6', // Blau
        backgroundColor: '#3b82f6',
        tension: 0.1,
        fill: false,
      },
      {
        label: 'Mobil',
        data: mobileData,
        borderColor: '#10b981', // Grün
        backgroundColor: '#10b981',
        tension: 0.1,
        fill: false,
      },
    ],
  };
});

const chartOptions = computed<ChartOptions<'line'>>(() => {
  const isDarkMode = document.documentElement.classList.contains('dark');
  const textColor = isDarkMode ? 'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)';
  const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

  return {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: true,
        position: 'top',
        labels: {
            color: textColor
        }
      },
      tooltip: {
        enabled: true,
      },
    },
    scales: {
      x: {
        grid: { display: false },
        ticks: { color: textColor, font: { size: 12 } },
        title: { display: true, text: 'Datum', color: textColor }
      },
      y: {
        beginAtZero: true,
        grid: { color: gridColor },
        ticks: { color: textColor, font: { size: 12 }, precision: 0 },
        title: { display: true, text: 'Anzahl eindeutiger Besucher', color: textColor }
      },
    },
  };
});
</script>

<template>
  <Card>
    <CardHeader>
      <div class="flex flex-wrap justify-between items-start gap-4">
        <div>
          <CardTitle>Besucher-Analyse</CardTitle>
          <CardDescription>Eindeutige Besucher pro Tag nach Gerätetyp.</CardDescription>
          <p class="mt-2 text-lg font-bold flex items-center gap-2">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
            </span>
            {{ data?.activeNow || 0 }} Benutzer gerade aktiv
          </p>
          <!-- NEU: Prozentuale Anzeige -->
          <div class="mt-4 flex gap-6 text-sm text-foreground/80">
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                <span>Desktop: {{ devicePercentages.desktop }}%</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                <span>Mobil: {{ devicePercentages.mobile }}%</span>
            </div>
          </div>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <Select v-model="localFilters.device_type">
            <SelectTrigger class="w-[140px]"><SelectValue placeholder="Gerätetyp" /></SelectTrigger>
            <SelectContent>
              <SelectItem value="all">Alle Geräte</SelectItem>
              <SelectItem value="desktop">Desktop</SelectItem>
              <SelectItem value="mobile">Mobil</SelectItem>
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
              <SelectItem v-for="y in data?.availableYears || []" :key="y" :value="y.toString()">{{ y }}</SelectItem>
            </SelectContent>
          </Select>
        </div>
      </div>
    </CardHeader>
    <CardContent>
      <div class="h-[250px]">
        <Line v-if="data?.history && data.history.length > 0" :data="chartData" :options="chartOptions" />
        <p v-else class="flex items-center justify-center h-full text-sm text-muted-foreground">Keine Besucherdaten für diesen Zeitraum.</p>
      </div>
    </CardContent>
  </Card>
</template>
