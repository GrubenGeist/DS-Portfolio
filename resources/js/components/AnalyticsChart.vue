<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ChartOptions } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ChartDataLabels);

const props = defineProps<{ data: any }>();
const emit = defineEmits(['filters-changed']);

const localFilters = reactive({
  year: props.data.filters.year.toString(),
  month: props.data.filters.month.toString(),
});

watch(localFilters, (newValues) => {
  emit('filters-changed', newValues);
});

const chartData = computed(() => {
  return {
    labels: props.data.history.map((item: any) => item.label || 'Unbekannt'),
    datasets: [{
      backgroundColor: '#06b6d4',
      borderRadius: 4,
      data: props.data.history.map((item: any) => item.total),
    }],
  };
});

const chartOptions = computed(() => {
  const isDarkMode = document.documentElement.classList.contains('dark');
  const textColor = isDarkMode ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 0, 0, 0.8)';
  
  return {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: { enabled: true },
      // Konfiguration für das Datalabels-Plugin (Zahlen auf den Balken)
      datalabels: {
        anchor: 'end',
        align: 'bottom',
        color: textColor,
        font: {
          weight: 'bold',
        },
        formatter: (value: number) => value > 0 ? value : null, // Zeigt die Zahl an, außer sie ist 0
      },
    },
    scales: {
      x: {
        grid: { display: false },
        ticks: { 
          color: textColor,
          font: { size: 12 }
        },
      },
      y: {
        display: false, // Y-Achse und Skala ausblenden
        beginAtZero: true,
      },
    },
  } as ChartOptions<'bar'>; // Wichtiger Typ-Hinweis für TypeScript
});

const months = [
    { value: '1', label: 'Januar' }, { value: '2', label: 'Februar' }, { value: '3', label: 'März' },
    { value: '4', label: 'April' }, { value: '5', label: 'Mai' }, { value: '6', label: 'Juni' },
    { value: '7', label: 'Juli' }, { value: '8', label: 'August' }, { value: '9', label: 'September' },
    { value: '10', label: 'Oktober' }, { value: '11', label: 'November' }, { value: '12', label: 'Dezember' },
];
</script>

<template>
  <Card>
    <CardHeader>
      <div class="flex justify-between items-start">
        <div>
          <CardTitle>Klick-Analyse</CardTitle>
          <CardDescription>Anzahl der Klicks pro Element.</CardDescription>
          <p class="mt-2 text-2xl font-bold">{{ data.totalToday }} <span class="text-sm font-normal text-muted-foreground">Klicks heute</span></p>
        </div>
        <div class="flex gap-2">
          <Select v-model="localFilters.month">
            <SelectTrigger class="w-[140px]"><SelectValue placeholder="Monat" /></SelectTrigger>
            <SelectContent>
              <SelectItem v-for="m in months" :key="m.value" :value="m.value">{{ m.label }}</SelectItem>
            </SelectContent>
          </Select>
          <Select v-model="localFilters.year">
            <SelectTrigger class="w-[100px]"><SelectValue placeholder="Jahr" /></SelectTrigger>
            <SelectContent>
              <SelectItem v-for="y in data.availableYears" :key="y" :value="y.toString()">{{ y }}</SelectItem>
            </SelectContent>
          </Select>
        </div>
      </div>
    </CardHeader>
    <CardContent>
      <div class="h-[250px]">
        <Bar v-if="data.history.length > 0" :data="chartData" :options="chartOptions" />
        <p v-else class="flex items-center justify-center h-full text-sm text-muted-foreground">Keine Klicks für diesen Zeitraum.</p>
      </div>
    </CardContent>
  </Card>
</template>
