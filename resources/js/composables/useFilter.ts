// /resources/js/composables/useFilter.ts

import { reactive, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import throttle from 'lodash/throttle';
import { ref, watch } from 'vue';
import { router, Head, Link } from '@inertiajs/vue3'; // 'router' muss hier sein

// Die Funktion wird generisch mit <T extends object> gemacht.
// Das bedeutet, T kann jeder Objekttyp sein.
export function useFilter<T extends object>(routeName: string, initialFilters: T) {
    
    // TypeScript weiß jetzt, dass 'initialFilters' den genauen Typ T hat
    // (z.B. { show_all: boolean }) und leitet diesen Typ für 'form' ab.
    const usersList = ref<User[]>(props.initialUsers);
    const showAll = ref(props.filters.show_all || false);

    // WIR FÜGEN DEN ALERT HIER WIEDER EIN
    watch(showAll, (newValue) => {
        alert(`WATCHER HAT AUSGELÖST! Neuer Wert ist: ${newValue}`);

        router.get(route('dashboard'), { show_all: newValue }, {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        });
    });

    // Die Funktion gibt das reaktive Formular-Objekt zurück, und TypeScript
    // kennt immer noch den genauen Typ T.
    return form;
}