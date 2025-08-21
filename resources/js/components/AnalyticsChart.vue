<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  type ChartOptions,
} from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useI18n } from 'vue-i18n';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ChartDataLabels);

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

// ----- Typen -----
type Filters = { year?: number | string; month?: number | string; category_id?: number | string; };
type HistoryItem = { label: string; total: number };
type Category = { id: number; name: string };
type AnalyticsData = { history: HistoryItem[]; filters?: Filters; availableYears?: number[]; availableCategories?: Category[]; totalToday?: number; };

// ----- UI-Daten (jetzt übersetzbar) -----
const months = computed(() => [
  { value: 'all', label: t('months.all') },
  { value: '1', label: t('months.january') }, { value: '2', label: t('months.february') }, { value: '3', label: t('months.march') },
  { value: '4', label: t('months.april') }, { value: '5', label: t('months.may') }, { value: '6', label: t('months.june') },
  { value: '7', label: t('months.july') }, { value: '8', label: t('months.august') }, { value: '9', label: t('months.september') },
  { value: '10', label: t('months.october') }, { value: '11', label: t('months.november') }, { value: '12', label: t('months.december') },
]);

// ----- Props & Emits -----
const props = defineProps<{ data: AnalyticsData }>();
const emit = defineEmits<{ (e: 'update:filters', payload: { year: string; month: string; category_id: string }): void; }>();

// ----- Lokale Filter -----
const localFilters = reactive({
  year: (props.data?.filters?.year ?? new Date().getFullYear()).toString(),
  month: (props.data?.filters?.month ?? 'all').toString(),
  category_id: (props.data?.filters?.category_id ?? 'all').toString(),
});

watch(localFilters, (v) => {
  emit('update:filters', { year: v.year, month: v.month, category_id: v.category_id });
});

watch(() => props.data?.filters, (nf) => {
    localFilters.year = (nf?.year ?? new Date().getFullYear()).toString();
    localFilters.month = (nf?.month ?? 'all').toString();
    localFilters.category_id = (nf?.category_id ?? 'all').toString();
  }, { deep: true });

// ----- Chart-Daten -----
const chartData = computed(() => {
  const history: HistoryItem[] = props.data?.history ?? [];
  const labels = history.map((i) => i.label || t('analytics_chart.chart.label_unknown'));
  const data = history.map((i) => i.total);

  if (labels.length === 1) {
    const padCount = 5;
    labels.push(...Array(padCount).fill(''));
    data.push(...Array(padCount).fill(0));
  }

  return {
    labels,
    datasets: [{
      backgroundColor: '#06b6d4',
      borderRadius: 4,
      barPercentage: 0.6,
      maxBarThickness: 80,
      data,
    }],
  };
});

// ----- Optionen -----
const chartOptions = computed<ChartOptions<'bar'>>(() => {
  const isDark = document.documentElement.classList.contains('dark');
  const textColor = isDark ? 'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)';
  const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

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
        formatter: (value: number) => (value > 0 ? value : null),
        offset: -4,
      },
    },
    scales: {
      x: {
        grid: { display: false },
        ticks: { color: textColor, font: { size: 12 } },
      },
      y: {
        display: true,
        beginAtZero: true,
        grid: { color: gridColor },
        ticks: { color: textColor, font: { size: 12 }, precision: 0 },
        title: { display: true, text: t('analytics_chart.chart.axis_y'), color: textColor, font: { size: 14 } },
        grace: '10%',
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
          <CardTitle>{{ $t('analytics_chart.title') }}</CardTitle>
          <CardDescription>{{ $t('analytics_chart.description') }}</CardDescription>
          <p class="mt-2 text-2xl font-bold">
            {{ props.data?.totalToday ?? 0 }}
            <span class="text-sm font-normal text-muted-foreground">{{ $t('analytics_chart.clicks_today') }}</span>
          </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <Select v-model="localFilters.category_id">
            <SelectTrigger class="w-[180px]"><SelectValue :placeholder="t('analytics_chart.filters.category_placeholder')" /></SelectTrigger>
            <SelectContent>
              <SelectItem value="all">{{ $t('analytics_chart.filters.all_categories') }}</SelectItem>
              <SelectItem
                v-for="cat in props.data?.availableCategories ?? []"
                :key="cat.id"
                :value="cat.id.toString()"
              >
                {{ cat.name }}
              </SelectItem>
            </SelectContent>
          </Select>

          <Select v-model="localFilters.month">
            <SelectTrigger class="w-[140px]"><SelectValue :placeholder="t('analytics_chart.filters.month_placeholder')" /></SelectTrigger>
            <SelectContent>
              <SelectItem v-for="m in months" :key="m.value" :value="m.value">{{ m.label }}</SelectItem>
            </SelectContent>
          </Select>

          <Select v-model="localFilters.year">
            <SelectTrigger class="w-[100px]"><SelectValue :placeholder="t('analytics_chart.filters.year_placeholder')" /></SelectTrigger>
            <SelectContent>
              <SelectItem
                v-for="y in props.data?.availableYears ?? []"
                :key="y"
                :value="y.toString()"
              >
                {{ y }}
              </SelectItem>
            </SelectContent>
          </Select>

          <Link
            :href="route('admin.categories.index')"
            class="p-2 text-gray-500 dark:text-gray-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
            :title="t('analytics_chart.manage_categories_title')"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="sr-only">{{ $t('analytics_chart.manage_categories_title') }}</span>
          </Link>
        </div>
      </div>
    </CardHeader>

    <CardContent>
      <div class="h-[250px]">
        <Bar v-if="props.data?.history && props.data.history.length > 0" :data="chartData" :options="chartOptions" />
        <p v-else class="flex items-center justify-center h-full text-sm text-muted-foreground">
          {{ $t('analytics_chart.no_data') }}
        </p>
      </div>
    </CardContent>
  </Card>
</template>
