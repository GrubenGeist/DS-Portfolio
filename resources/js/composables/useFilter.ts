// resources/js/composables/useFilter.ts
import { reactive, watch, onBeforeUnmount } from 'vue';
import { router } from '@inertiajs/vue3';
import type { FormDataConvertible } from '@inertiajs/core';
import throttle from 'lodash/throttle';

export type UseFilterOptions = {
  preserveState?: boolean;
  preserveScroll?: boolean;
  replace?: boolean;
  throttleMs?: number;
  routeParams?: Record<string, FormDataConvertible>; // optional: enger typisiert
};

export function useFilter<T extends Record<string, FormDataConvertible>>(
  routeName: string,
  initialFilters: T,
  options: UseFilterOptions = {},
) {
  const filters = reactive({ ...initialFilters }) as T;

  const {
    preserveState = true,
    preserveScroll = true,
    replace = true,
    throttleMs = 300,
    routeParams = {},
  } = options;

  const send = () => {
    // `filters` erfüllt jetzt das benötigte RequestPayload-Contract
    router.get(
      route(routeName, routeParams),
      filters,
      { preserveState, preserveScroll, replace },
    );
  };

  // gedrosselte Variante + Cleanup
  const throttledSend = throttle(send, throttleMs);
  onBeforeUnmount(() => throttledSend.cancel());

  // jede Filteränderung → Request
  watch(filters, () => throttledSend(), { deep: true });

  // kleine Helfer
  const setFilter = <K extends keyof T>(key: K, value: T[K]) => {
    filters[key] = value;
  };

  const resetFilters = (next?: Partial<T>) => {
    Object.assign(filters, next ?? initialFilters);
    throttledSend();
  };

  // optional: manuell sofort senden
  const apply = () => send();

  // optional: manuelles Aufräumen, falls außerhalb von Komponenten genutzt
  const dispose = () => throttledSend.cancel();

  return { filters, setFilter, resetFilters, apply, dispose };
}


/*
Beispielnutzung

const { filters, setFilter, resetFilters } = useFilter('dashboard', {
  show_all: false,
  month: 'all',
});

// später:
setFilter('show_all', true);

*/