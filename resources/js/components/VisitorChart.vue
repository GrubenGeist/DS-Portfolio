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
import { useI18n } from 'vue-i18n';

ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, CategoryScale, LinearScale);

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

// ---------- Typen (unverändert) ----------
type DeviceType = 'all' | 'desktop' | 'mobile';
type HistoryPoint = { date: string | number | Date; desktop: number; mobile: number; };
type VisitorFilters = { year?: number | string; month?: number | string; device_type?: DeviceType; };
type VisitorData = { history: HistoryPoint[]; filters?: VisitorFilters; availableYears?: number[]; activeNow?: number; };

// ---------- Props & Emits (unverändert) ----------
const props = defineProps<{ data: VisitorData; }>();
const emit = defineEmits<{ (e: 'update:filters', payload: { year: string; month: string; device_type: DeviceType }): void; }>();

// ---------- UI-Daten (jetzt übersetzbar) ----------
const months = computed(() => [
  { value: 'all', label: t('months.all') },
  { value: '1', label: t('months.january') }, { value: '2', label: t('months.february') }, { value: '3', label: t('months.march') },
  { value: '4', label: t('months.april') }, { value: '5', label: t('months.may') }, { value: '6', label: t('months.june') },
  { value: '7', label: t('months.july') }, { value: '8', label: t('months.august') }, { value: '9', label: t('months.september') },
  { value: '10', label: t('months.october') }, { value: '11', label: t('months.november') }, { value: '12', label: t('months.december') },
]);

// ---------- Lokale Filter & Watcher (unverändert) ----------
const localFilters = reactive({
  year: (props.data?.filters?.year ?? new Date().getFullYear()).toString(),
  month: (props.data?.filters?.month ?? 'all').toString(),
  device_type: (props.data?.filters?.device_type ?? 'all') as DeviceType,
});

watch(localFilters, (newValues) => {
  emit('update:filters', {
    year: newValues.year,
    month: newValues.month,
    device_type: newValues.device_type,
  });
});

watch(() => props.data?.filters, (newFilters) => {
    localFilters.year = (newFilters?.year ?? new Date().getFullYear()).toString();
    localFilters.month = (newFilters?.month ?? 'all').toString();
    localFilters.device_type = (newFilters?.device_type ?? 'all') as DeviceType;
  }, { deep: true });

// ---------- Prozentanzeige (unverändert) ----------
const devicePercentages = computed(() => {
  const history: HistoryPoint[] = props.data?.history ?? [];
  if (history.length === 0) return { desktop: 0, mobile: 0 };
  const totalDesktop = history.reduce((sum: number, item: HistoryPoint) => sum + item.desktop, 0);
  const totalMobile  = history.reduce((sum: number, item: HistoryPoint) => sum + item.mobile, 0);
  const totalVisitors = totalDesktop + totalMobile;
  if (totalVisitors === 0) return { desktop: 0, mobile: 0 };
  const desktopPercentage = Math.round((totalDesktop / totalVisitors) * 100);
  const mobilePercentage  = Math.round((totalMobile / totalVisitors) * 100);
  return { desktop: desktopPercentage, mobile: mobilePercentage };
});

// ---------- Chart-Daten (jetzt übersetzbar) ----------
const chartData = computed(() => {
  const history: HistoryPoint[] = props.data?.history ?? [];
  const labels = history.map((item) =>
    new Date(item.date).toLocaleDateString('de-DE', { day: '2-digit', month: '2-digit' }),
  );
  const desktopData = history.map((item) => item.desktop);
  const mobileData  = history.map((item) => item.mobile);
  return {
    labels,
    datasets: [
      {
        label: t('visitor_chart.chart.label_desktop'),
        data: desktopData,
        borderColor: '#3b82f6',
        backgroundColor: '#3b82f6',
        tension: 0.1,
        fill: false,
      },
      {
        label: t('visitor_chart.chart.label_mobile'),
        data: mobileData,
        borderColor: '#10b981',
        backgroundColor: '#10b981',
        tension: 0.1,
        fill: false,
      },
    ],
  };
});

// ---------- Chart-Optionen (jetzt übersetzbar) ----------
const chartOptions = computed<ChartOptions<'line'>>(() => {
  const isDarkMode = document.documentElement.classList.contains('dark');
  const textColor  = isDarkMode ? 'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)';
  const gridColor  = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
  return {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: true, position: 'top', labels: { color: textColor } },
      tooltip: { enabled: true },
    },
    scales: {
      x: {
        grid: { display: false },
        ticks: { color: textColor, font: { size: 12 } },
        title: { display: true, text: t('visitor_chart.chart.axis_x'), color: textColor },
      },
      y: {
        beginAtZero: true,
        grid: { color: gridColor },
        ticks: { color: textColor, font: { size: 12 }, precision: 0 },
        title: { display: true, text: t('visitor_chart.chart.axis_y'), color: textColor },
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
          <CardTitle>{{ $t('visitor_chart.title') }}</CardTitle>
          <CardDescription>{{ $t('visitor_chart.description') }}</CardDescription>

          <p class="mt-2 text-lg font-bold flex items-center gap-2">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
            </span>
            {{ $t('visitor_chart.active_now', { count: data?.activeNow ?? 0 }) }}
          </p>

          <div class="mt-4 flex gap-6 text-sm text-foreground/80">
            <div class="flex items-center gap-2">
              <span class="h-2 w-2 rounded-full bg-blue-500"></span>
              <span>{{ $t('visitor_chart.desktop_percentage', { percent: devicePercentages.desktop }) }}</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
              <span>{{ $t('visitor_chart.mobile_percentage', { percent: devicePercentages.mobile }) }}</span>
            </div>
          </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <Select v-model="localFilters.device_type">
            <SelectTrigger class="w-[140px]"><SelectValue :placeholder="t('visitor_chart.filters.device_type')" /></SelectTrigger>
            <SelectContent>
              <SelectItem value="all">{{ $t('visitor_chart.filters.all_devices') }}</SelectItem>
              <SelectItem value="desktop">{{ $t('visitor_chart.filters.desktop') }}</SelectItem>
              <SelectItem value="mobile">{{ $t('visitor_chart.filters.mobile') }}</SelectItem>
            </SelectContent>
          </Select>

          <Select v-model="localFilters.month">
            <SelectTrigger class="w-[140px]"><SelectValue :placeholder="t('visitor_chart.filters.month')" /></SelectTrigger>
            <SelectContent>
              <SelectItem v-for="m in months" :key="m.value" :value="m.value">{{ m.label }}</SelectItem>
            </SelectContent>
          </Select>

          <Select v-model="localFilters.year">
            <SelectTrigger class="w-[100px]"><SelectValue :placeholder="t('visitor_chart.filters.year')" /></SelectTrigger>
            <SelectContent>
              <SelectItem v-for="y in data?.availableYears ?? []" :key="y" :value="y.toString()">{{ y }}</SelectItem>
            </SelectContent>
          </Select>
        </div>
      </div>
    </CardHeader>

    <CardContent>
      <div class="h-[250px]">
        <Line v-if="data?.history && data.history.length > 0" :data="chartData" :options="chartOptions" />
        <p v-else class="flex items-center justify-center h-full text-sm text-muted-foreground">
          {{ $t('visitor_chart.no_data') }}
        </p>
      </div>
    </CardContent>
  </Card>
</template>
