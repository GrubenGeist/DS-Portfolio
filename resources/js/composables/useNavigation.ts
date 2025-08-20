// resources/js/composables/useNavigation.ts

import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import type { NavItem, User } from '@/types';
import { useI18n } from 'vue-i18n';

export function useNavigation() {
  // Holen Sie sich die Übersetzungsfunktion `t`
  const { t } = useI18n();
  const page = usePage();

  const user = computed<User | null>(() => (page.props as any)?.auth?.user ?? null);
  const isGuest = computed(() => !user.value);
  const isAdmin = computed(() => user.value?.roles?.includes('Admin'));
  const isCompany = computed(() => user.value?.roles?.includes('Company'));

  // Die Navigations-Items sind jetzt eine "computed" Eigenschaft,
  // damit sich die Titel bei einem Sprachwechsel reaktiv ändern.
  const mainNavItems = computed<NavItem[]>(() => [
    { title: t('nav.home'), href: route('welcome'), show: true },
    {
      title: t('nav.more_information'),
      show: true,
      children: [
        { title: t('nav.projects'), href: route('projects'), show: !isGuest.value },
        { title: t('nav.services'), href: route('services'), show: !isGuest.value },
        { title: t('nav.about_me'), href: route('aboutme'), show: !isGuest.value },
      ],
    },
    {
      title: t('nav.application_documents'),
      show: true,
      children: [
        { title: t('nav.cv'), href: route('lebenslauf'), show: !isGuest.value },
      ],
    },
  ]);

  // Filtert die Items basierend auf der 'show'-Eigenschaft
  const filteredMainNavItems = computed(() => 
    mainNavItems.value.map(item => ({
      ...item,
      children: item.children?.filter(child => child.show)
    })).filter(item => item.show)
  );

  return {
    user,
    isGuest,
    isAdmin,
    isCompany,
    filteredMainNavItems,
  };
}
