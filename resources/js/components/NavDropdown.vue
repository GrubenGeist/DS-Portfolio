<script setup lang="ts">
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem } from "@/components/ui/dropdown-menu";
import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/vue3";
import type { NavItem } from "@/types";

interface Props {
  item: NavItem;
  triggerClass?: string;
}
const props = defineProps<Props>();
</script>

<template>
  <DropdownMenu>
    <!-- Trigger -->
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" :class="triggerClass">
        <component v-if="props.item.icon" :is="props.item.icon" class="mr-1.5 h-4 w-4 opacity-80" />
        {{ props.item.title }}
        <svg class="ml-1 h-3 w-3 transition group-data-[state=open]:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path d="m6 9 6 6 6-6" />
        </svg>
      </Button>
    </DropdownMenuTrigger>

    <!-- Content -->
    <DropdownMenuContent class="w-56" align="start" :side-offset="5">
      <DropdownMenuItem v-if="props.item.href" as-child>
        <Link :href="props.item.href">
          <component v-if="props.item.icon" :is="props.item.icon" class="mr-2 h-4 w-4" />
          <span>{{ props.item.title }}</span>
        </Link>
      </DropdownMenuItem>

      <DropdownMenuItem v-for="child in props.item.children" :key="child.title" as-child>
        <Link :href="child.href ?? '#'">
          <component v-if="child.icon" :is="child.icon" class="mr-2 h-4 w-4" />
          <span>{{ child.title }}</span>
        </Link>
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
