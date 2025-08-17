<script setup lang="ts">
import {
  DropdownMenu,
  DropdownMenuTrigger,
  DropdownMenuContent,
  DropdownMenuItem,
} from "@/components/ui/dropdown-menu";
import { Button } from "@/components/ui/button";
import { Link, usePage } from "@inertiajs/vue3";
import type { NavItem } from "@/types";
import { navigationMenuTriggerStyle } from "@/components/ui/navigation-menu";

interface Props { item: NavItem }
const props = defineProps<Props>();

const page = usePage();

const isActive = (href?: string) =>
  href &&
  (page.url === href || page.url.startsWith(href + "/"));
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" :class="[navigationMenuTriggerStyle(), 'h-9 px-3 text-sm']">
        <component v-if="item.icon" :is="item.icon" class="mr-1.5 h-4 w-4 opacity-80" />
        {{ item.title }}
        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-3 w-3 transition group-data-[state=open]:rotate-180"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m6 9 6 6 6-6" />
        </svg>
      </Button>
    </DropdownMenuTrigger>

    <DropdownMenuContent class="w-56" align="start" :side-offset="5">
      <DropdownMenuItem v-if="item.href" as-child>
        <Link :href="item.href" :class="isActive(item.href) ? 'bg-muted dark:bg-neutral-800' : ''">
          <component v-if="item.icon" :is="item.icon" class="mr-2 h-4 w-4" />
          <span>{{ item.title }}</span>
        </Link>
      </DropdownMenuItem>

      <DropdownMenuItem v-for="child in item.children" :key="child.title" as-child>
        <Link :href="child.href ?? '#'" :class="isActive(child.href) ? 'bg-muted dark:bg-neutral-800' : ''">
          <component v-if="child.icon" :is="child.icon" class="mr-2 h-4 w-4" />
          <span>{{ child.title }}</span>
        </Link>
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
