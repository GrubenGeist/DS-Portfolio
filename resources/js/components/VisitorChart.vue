<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import { Line } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, PointElement, CategoryScale, LinearScale, Filler } from 'chart.js';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, CategoryScale, LinearScale, Filler);

interface VisitHistory { date: string; unique_visitors: number; }
interface VisitorData {
  history: VisitHistory[];
  availableYears: number[];
  filters: { year: number; month: number; };
}

const props = defineProps<{
  data: any;
  activeNow: number;
}>();

const emit = defineEmits(['update:filters']);

const localFilters = reactive({
  year: props.data.filters.year.toString(),
  month: props.data.filters.month.toString(),
});

watch(localFilters, (newValues) => {
  emit('update:filters', newValues);
});

const chartData = computed(() => {
    const labels = props.data.history.map((item: any) => new Date(item.date).toLocaleDateString('de-DE', { day: '2-digit', month: '2-digit' }));
    const dataPoints = props.data.history.map((item: any) => item.unique_visitors);
    return {
        labels,
        datasets: [{
            label: 'Einzigartige Besucher',
            borderColor: '#06b6d4',
            backgroundColor: 'rgba(6, 182, 212, 0.1)',
            data: dataPoints,
            fill: true, // Funktioniert jetzt, da der Filler registriert ist
            tension: 0.4,
        }],
    };
});
const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: { 
      y: { 
        beginAtZero: true,
        ticks: { stepSize: 1 }
      } 
    },
};
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
          <CardTitle>Besucher-Analyse</CardTitle>
          <CardDescription>Besucher pro Tag.</CardDescription>
          <div class="mt-2 flex items-center gap-2 text-sm font-medium">
            <span class="flex h-2 w-2 rounded-full bg-green-500" />
            <span>{{ activeNow }} Benutzer gerade aktiv</span>
          </div>
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
        <Line v-if="data.history.length > 0" :data="chartData" :options="chartOptions" />
        <p v-else class="flex items-center justify-center h-full text-sm text-muted-foreground">Keine Besucherdaten für diesen Zeitraum.</p>
      </div>
    </CardContent>
  </Card>
</template>