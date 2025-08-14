import { onMounted, ref } from 'vue';
import { router } from '@inertiajs/vue3';

type Appearance = 'light' | 'dark' | 'system';

// Diese Funktion wird jetzt nur noch vom Composable intern genutzt
function updateTheme(value: Appearance) {
    if (typeof window === 'undefined') return;

    if (value === 'system') {
        const mediaQueryList = window.matchMedia('(prefers-color-scheme: dark)');
        const systemTheme = mediaQueryList.matches ? 'dark' : 'light';
        document.documentElement.classList.toggle('dark', systemTheme === 'dark');
    } else {
        document.documentElement.classList.toggle('dark', value === 'dark');
    }
}

const getStoredAppearance = () => {
    if (typeof window === 'undefined') return null;
    return localStorage.getItem('appearance') as Appearance | null;
};

const handleSystemThemeChange = () => {
    const currentAppearance = getStoredAppearance();
    updateTheme(currentAppearance || 'system');
};

export function initializeTheme() {
    if (typeof window === 'undefined') return;
    const savedAppearance = getStoredAppearance();
    updateTheme(savedAppearance || 'system');
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', handleSystemThemeChange);
}

export function useAppearance() {
    const appearance = ref<Appearance>('system');

    onMounted(() => {
        initializeTheme();
        const savedAppearance = localStorage.getItem('appearance') as Appearance | null;
        if (savedAppearance) {
            appearance.value = savedAppearance;
        }
    });

    function updateAppearance(value: Appearance) {
        appearance.value = value;
        localStorage.setItem('appearance', value);
        updateTheme(value);

        // KORREKTUR: Wir senden die Wahl an den Server, anstatt ein Cookie zu setzen.
        // Das Backend entscheidet dann, ob es das Cookie setzen darf.
        router.post(route('appearance.update'), {
            appearance: value
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    }

    return {
        appearance,
        updateAppearance,
    };
}