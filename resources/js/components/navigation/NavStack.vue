<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import type { NavItem } from '@/types';

interface Props { items: NavItem[] }
defineProps<Props>();

const page = usePage();

const isNavItemActive = (item: NavItem) => {
  const currentUrl = page.url;
  if (item.href) {
    if (currentUrl === item.href) return true;
    if (item.href !== '/' && currentUrl.startsWith(item.href + '/')) return true;
  }
  return false;
};
</script>

<template>
  <nav class="grid items-start gap-2 px-2 text-sm font-medium">
    <template v-for="item in items" :key="item.title">
      <div v-if="item.children && item.children.length > 0" class="space-y-1">
        <h4 class="px-3 py-2 font-semibold text-muted-foreground">{{ item.title }}</h4>

        <Link
          v-for="child in item.children"
          :key="child.title"
          :href="child.href ?? '#'"
          class="flex items-center gap-3 rounded-lg border border-border px-3 py-2 text-foreground transition-colors hover:bg-accent"
          :class="{ 'bg-primary text-primary-foreground hover:bg-primary/90': isNavItemActive(child) }"
        >
          <component v-if="child.icon" :is="child.icon" class="h-4 w-4" />
          {{ child.title }}
        </Link>
      </div>

      <Link
        v-else
        :href="item.href ?? '#'"
        class="flex items-center gap-3 rounded-lg border border-border px-3 py-2 text-foreground transition-colors hover:bg-accent"
        :class="{ 'bg-primary text-primary-foreground hover:bg-primary/90': isNavItemActive(item) }"
      >
        <component v-if="item.icon" :is="item.icon" class="h-4 w-4" />
        {{ item.title }}
      </Link>
    </template>
  </nav>
</template>
