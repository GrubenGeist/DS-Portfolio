<script setup lang="ts">
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { NavigationMenuItem, NavigationMenuLink, navigationMenuTriggerStyle } from '@/components/ui/navigation-menu';
import { Button } from '@/components/ui/button';
import { Link, usePage } from '@inertiajs/vue3';
import type { NavItem } from '@/types';
import { computed } from 'vue';

interface Props { items: NavItem[] }
defineProps<Props>();

const page = usePage();

const isNavItemActive = (item: NavItem) => {
  const currentUrl = page.url;
  if (item.href) {
    if (currentUrl === item.href) return true;
    if (item.href !== '/' && currentUrl.startsWith(item.href + '/')) return true;
  }
  if (item.children) {
    return item.children.some(
      child => child.href && (currentUrl === child.href || (child.href !== '/' && currentUrl.startsWith(child.href + '/')))
    );
  }
  return false;
};

const activeItemStyles = (item: NavItem) =>
  isNavItemActive(item) ? 'text-neutral-900 dark:text-neutral-50 bg-muted dark:bg-neutral-800' : '';
</script>

<template>
  <template v-for="item in items" :key="item.title">
    <NavigationMenuItem>
      <!-- Dropdown -->
      <template v-if="item.children && item.children.length > 0">
        <DropdownMenu>
          <DropdownMenuTrigger as-child>
            <Button
              variant="ghost"
              :class="[navigationMenuTriggerStyle(), 'h-9 px-3 text-sm', activeItemStyles(item)]"
            >
              <component v-if="item.icon" :is="item.icon" class="mr-1.5 h-4 w-4 opacity-80" />
              {{ item.title }}
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                   fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                   stroke-linejoin="round" class="ml-1 h-3 w-3 transition group-data-[state=open]:rotate-180">
                <path d="m6 9 6 6 6-6" />
              </svg>
            </Button>
          </DropdownMenuTrigger>

          <DropdownMenuContent class="w-56" align="start" :side-offset="5">
            <DropdownMenuItem v-if="item.href" as-child>
              <Link :href="item.href" :class="activeItemStyles(item)">
                <component v-if="item.icon" :is="item.icon" class="mr-2 h-4 w-4" />
                <span>{{ item.title }}</span>
              </Link>
            </DropdownMenuItem>

            <DropdownMenuItem v-for="child in item.children" :key="child.title" as-child>
              <Link :href="child.href ?? '#'" :class="activeItemStyles(child)">
                <component v-if="child.icon" :is="child.icon" class="mr-2 h-4 w-4" />
                <span>{{ child.title }}</span>
              </Link>
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </template>

      <!-- Einfacher Link -->
      <template v-else-if="item.href">
        <Link :href="item.href" legacy-behavior passHref>
          <NavigationMenuLink
            :active="isNavItemActive(item)"
            :class="[navigationMenuTriggerStyle(), activeItemStyles(item), 'h-9 px-3 text-sm']"
          >
            <component v-if="item.icon" :is="item.icon" class="mr-1.5 h-4 w-4 opacity-80" />
            {{ item.title }}
          </NavigationMenuLink>
        </Link>
      </template>
    </NavigationMenuItem>
  </template>
</template>
