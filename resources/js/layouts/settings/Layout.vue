<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import type { NavItem } from '@/types';
import { Link, usePage, router } from '@inertiajs/vue3'; // 'router' importieren, falls noch nicht geschehen
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

// NEU: Importiere hier alle benötigten Select-Komponenten
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';

const { t } = useI18n();
const page = usePage();

// ... der Rest deines <script setup> Blocks bleibt unverändert ...

const userRoles = computed<string[]>(() => (page.props as any)?.auth?.user?.roles ?? []);
const isAdmin = computed(() => userRoles.value.includes('Admin'));

const sidebarNavItems = computed<NavItem[]>(() => {
  const items: NavItem[] = [
    { title: t('settings.layout.nav.profile'), href: route('settings.profile.edit') },
  ];

  if (isAdmin.value) {
    items.push({
      title: t('settings.layout.nav.user_management'),
      href: route('admin.users.index'),
    });
    items.push({
      title: t('settings.layout.nav.create_user'),
      href: route('admin.register.form'),
    });
  }
  return items;
});

const currentPath = computed<string>(() => (page.props as any)?.ziggy?.location ?? '');
</script>

<template>
  <div class="space-y-6 p-4 sm:p-6 md:p-10 pb-16">
    <Heading :title="t('settings.layout.title')" :description="t('settings.layout.description')" />

    <div class="grid grid-cols-1 gap-x-12 gap-y-8 lg:grid-cols-[240px,1fr]">
      <!-- Desktop Sidebar -->
      <aside class="hidden lg:block">
        <nav class="flex flex-col space-y-1">
          <Button
            v-for="item in sidebarNavItems"
            :key="item.href ?? item.title"
            variant="ghost"
            :class="['w-full justify-start', { 'bg-muted': currentPath.startsWith(item.href ?? '#_') }]"
            as-child
          >
            <Link :href="item.href ?? '#'">
              {{ item.title }}
            </Link>
          </Button>
        </nav>
      </aside>

      <!-- Mobile Dropdown -->
      <div class="lg:hidden">
        <Select :model-value="currentPath ?? ''" @update:model-value="val => router.visit(val as string)">
          <SelectTrigger class="w-full mb-4">
            <SelectValue :placeholder="t('settings.layout.nav.profile')" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem
              v-for="item in sidebarNavItems"
              :key="item.href ?? item.title"
              :value="item.href ?? ''"
            >
              {{ item.title }}
            </SelectItem>
          </SelectContent>
        </Select>
      </div>

      <div>
        <slot />
      </div>
    </div>
  </div>
</template>
