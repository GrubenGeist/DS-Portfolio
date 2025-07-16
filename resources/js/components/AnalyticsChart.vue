<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';

// Registriere alle notwendigen Chart.js-Komponenten und das neue Plugin
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ChartDataLabels);

// Definiert die Struktur der ankommenden Daten
interface AnalyticsData {
  today: { label: string | null; total: number }[];
  month: { label: string | null; total: number }[];
  year: { label: string | null; total: number }[];
}

const props = defineProps<{
  data?: AnalyticsData;
}>();

type Timeframe = 'today' | 'month' | 'year';
const activeTimeframe = ref<Timeframe>('month');

const isDarkMode = ref(false);
onMounted(() => {
    isDarkMode.value = document.documentElement.classList.contains('dark');
    const observer = new MutationObserver(() => {
        isDarkMode.value = document.documentElement.classList.contains('dark');
    });
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
    onUnmounted(() => observer.disconnect());
});

const chartData = computed(() => {
  if (!props.data || !props.data[activeTimeframe.value]) {
    return { labels: [], datasets: [] };
  }
  const selectedData = props.data[activeTimeframe.value];
  return {
    labels: selectedData.map(item => item.label || 'Unbekannt'),
    datasets: [
      {
        backgroundColor: '#06b6d4',
        borderRadius: 4,
        data: selectedData.map(item => item.total),
      },
    ],
  };
});

// KORRIGIERTE CHART-OPTIONEN
const chartOptions = computed(() => {
  const textColor = isDarkMode.value ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 0, 0, 0.8)';
  return {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: { enabled: true }, // Tooltip beim Hovern beibehalten
      // Konfiguration für das Datalabels-Plugin (Zahlen auf den Balken)
      datalabels: {
        anchor: 'end' as const,
        align: 'top' as const,
        color: textColor,
        font: {
          weight: 'bold' as const,
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
        display: false, // Y-Achse und Skala komplett ausblenden
        beginAtZero: true,
      },
    },
  };
});
</script>

<template>
  <Card>
    <CardHeader>
      <CardTitle>Klick-Analyse</CardTitle>
      <CardDescription>Anzahl der Klicks pro Event im ausgewählten Zeitraum.</CardDescription>
    </CardHeader>
    <CardContent>
      <div class="flex gap-2 mb-4">
        <Button :variant="activeTimeframe === 'today' ? 'default' : 'outline'" @click="activeTimeframe = 'today'">Heute</Button>
        <Button :variant="activeTimeframe === 'month' ? 'default' : 'outline'" @click="activeTimeframe = 'month'">Dieser Monat</Button>
        <Button :variant="activeTimeframe === 'year' ? 'default' : 'outline'" @click="activeTimeframe = 'year'">Dieses Jahr</Button>
      </div>
      <div class="h-[250px]">
          <Bar v-if="data && chartData.labels.length > 0" :data="chartData" :options="chartOptions" />
          <p v-else class="flex items-center justify-center h-full text-sm text-muted-foreground">Keine Daten für diesen Zeitraum vorhanden.</p>
      </div>
    </CardContent>
  </Card>
</template>
