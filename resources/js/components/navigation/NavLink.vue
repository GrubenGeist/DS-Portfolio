<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import type { NavItem } from "@/types";
import { navigationMenuTriggerStyle } from "@/components/ui/navigation-menu";
import { computed } from "vue";

interface Props { item: NavItem }
const props = defineProps<Props>();

const page = usePage();

const isActive = computed(() =>
  props.item.href &&
  (page.url === props.item.href || page.url.startsWith(props.item.href + "/"))
);
</script>

<template>
  <Link :href="item.href ?? '#'" class="focus:outline-none">
    <span
      :class="[
        navigationMenuTriggerStyle(),
        'h-9 px-3 text-sm',
        isActive ? 'text-neutral-900 dark:text-neutral-50 bg-muted dark:bg-neutral-800' : ''
      ]"
    >
      <component v-if="item.icon" :is="item.icon" class="mr-1.5 h-4 w-4 opacity-80" />
      {{ item.title }}
    </span>
  </Link>
</template>
