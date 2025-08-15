import { onMounted, ref } from 'vue';
import { router } from '@inertiajs/vue3';

type Appearance = 'light' | 'dark' | 'system';

// nur intern genutzt
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
  return (localStorage.getItem('appearance') as Appearance | null) ?? null;
};

const handleSystemThemeChange = () => {
  const currentAppearance = getStoredAppearance();
  updateTheme(currentAppearance || 'system');
};

// 🔒 verhindert doppelte Listener-Registrierung
let themeInitialized = false;

export function initializeTheme() {
  if (typeof window === 'undefined') return;
  if (themeInitialized) return;

  const savedAppearance = getStoredAppearance();
  updateTheme(savedAppearance || 'system');

  window
    .matchMedia('(prefers-color-scheme: dark)')
    .addEventListener('change', handleSystemThemeChange);

  themeInitialized = true;
}

export function useAppearance() {
  const appearance = ref<Appearance>('system');

  onMounted(() => {
    // idempotent – sicher, falls auch in app.ts aufgerufen
    initializeTheme();

    const savedAppearance = getStoredAppearance();
    if (savedAppearance) {
      appearance.value = savedAppearance;
    }
  });

  function updateAppearance(value: Appearance) {
    appearance.value = value;
    if (typeof window !== 'undefined') {
      localStorage.setItem('appearance', value);
    }
    updateTheme(value);

    // an Server melden (Inertia)
    router.post(
      route('appearance.update'),
      { appearance: value },
      { preserveState: true, preserveScroll: true },
    );
  }

  return { appearance, updateAppearance };
}
