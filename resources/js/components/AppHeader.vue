<script setup lang="ts">
import { ref } from 'vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { Sun, Moon, LogIn, Menu } from 'lucide-vue-next';
import { useAppearance } from '@/composables/useAppearance';
import GhostButton from '@/components/GhostButton.vue';

import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import {
  NavigationMenu,
  NavigationMenuList,
} from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger, SheetDescription } from '@/components/ui/sheet';

import { getInitials } from '@/composables/useInitials';
import { useNavigation } from '@/composables/useNavigation';
import type { BreadcrumbItem as BreadcrumbItemType } from '@/types';
import { Link } from '@inertiajs/vue3';

import NavDesktop from '@/components/navigation/NavDesktop.vue';
import NavStack from '@/components/navigation/NavStack.vue';
import LanguageSwitcher from '@/components/LanguageSwitcher.vue';

const { appearance, updateAppearance } = useAppearance();
const toggleTheme = () => { updateAppearance(appearance.value === 'dark' ? 'light' : 'dark'); };

const {
  filteredMainNavItems,
  isGuest,
  user,
} = useNavigation();

interface Props { breadcrumbs?: BreadcrumbItemType[] }
const props = withDefaults(defineProps<Props>(), { breadcrumbs: () => [] });

// State für User-Menü offen/geschlossen
const userMenuOpen = ref(false);

// State für das mobile Menü (Sheet) offen/geschlossen
const mobileMenuOpen = ref(false);
</script>

<template>
  <div>
    <div class="border-b border-sidebar-border/80 dark:bg-stone-900">
      <div class="flex h-16 w-full items-center px-2 md:px-2">

        <div class="lg:hidden">
          <Sheet v-model:open="mobileMenuOpen">
            <SheetTrigger as-child>
              <Button variant="secondary" size="lg" class="mr-2 h-9 w-9" aria-label="Menü öffnen">
                <Menu class="h-5 w-5" />
              </Button>
            </SheetTrigger>

            <SheetContent v-if="mobileMenuOpen" side="left" class="w-[300px] p-6" aria-label="Mobile Navigation">
              <SheetTitle class="sr-only">Navigation</SheetTitle>
              <SheetDescription class="sr-only">
                Hauptnavigationsmenü für die mobile Ansicht
              </SheetDescription>
              <SheetHeader class="mb-4 flex justify-start text-left">
                <Link :href="route('welcome')">
                  <AppLogoIcon class="size-7 fill-current text-black dark:text-white" />
                </Link>
              </SheetHeader>

              <div class="flex h-full flex-1 flex-col space-y-2">
                <NavStack :items="filteredMainNavItems" />

                <GhostButton
                  :tracking-data="{ category: 'Easter Egg', label: 'MobileNavbar Ghostbutton' }"
                  class="ghost-nav-item"
                />
              </div>
            </SheetContent>
          </Sheet>
        </div>

        <div class="hidden h-full items-center lg:flex">
          <Link :href="route('welcome')" class="mr-4 pl-2">
            <AppLogoIcon class="size-7 fill-current text-black dark:text-white" />
          </Link>

          <NavigationMenu class="relative" aria-label="Hauptnavigation">
            <NavigationMenuList class="flex space-x-1">
              <NavDesktop :items="filteredMainNavItems" />
            </NavigationMenuList>
          </NavigationMenu>
        </div>

        <div class="ml-auto flex items-center space-x-4">
          <button
            @click="toggleTheme"
            type="button"
            class="relative inline-flex h-7 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-slate-200 dark:bg-slate-700 transition-colors duration-200 ease-in-out"
            role="switch"
            :aria-checked="appearance === 'dark'"
            aria-label="Theme umschalten"
          >
            <span class="sr-only">Theme umschalten</span>
            <span
              aria-hidden="true"
              :class="appearance === 'dark' ? 'translate-x-7' : 'translate-x-0'"
              class="pointer-events-none relative inline-block h-6 w-6 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"
            >
              <Sun v-if="appearance !== 'dark'" class="absolute inset-0 h-full w-full p-1 text-yellow-500" />
              <Moon v-else class="absolute inset-0 h-full w-full p-1 text-slate-800" />
            </span>
          </button>

              <div class="ml-auto flex items-center">
                  <LanguageSwitcher />
              </div>

          <template v-if="isGuest">
            <Button variant="ghost" class="h-9 px-3 text-sm" as-child>
              <Link :href="route('login')">
                <LogIn class="mr-2 h-4 w-4" /> Login
              </Link>
            </Button>
          </template>

          <template v-else-if="user">
            <div class="flex items-center pr-4">
              <DropdownMenu v-model:open="userMenuOpen">
                <DropdownMenuTrigger as-child>
                  <Button
                    variant="ghost"
                    class="relative h-10 w-10 rounded-full"
                    aria-haspopup="menu"
                    :aria-expanded="userMenuOpen ? 'true' : 'false'"
                    aria-label="Benutzermenü"
                  >
                    <Avatar class="size-11">
                      <AvatarImage :src="user.avatar || ''" :alt="user.name ?? 'User Avatar'" />
                      <AvatarFallback class="bg-muted">
                        {{ getInitials(user.name ?? '') }}
                      </AvatarFallback>
                    </Avatar>
                  </Button>
                </DropdownMenuTrigger>

                <DropdownMenuContent class="w-59" align="end" :side-offset="5">
                  <UserMenuContent :user="user" />
                </DropdownMenuContent>
              </DropdownMenu>
            </div>
          </template>
        </div>
      </div>
    </div>
<!--
    <div v-if="props.breadcrumbs && props.breadcrumbs.length > 0" class="flex w-full border-b border-sidebar-border/70">
      <div class="flex h-12 w-full items-center justify-start px-2 md:px-44 text-sm text-muted-foreground">
        <Breadcrumbs :breadcrumbs="props.breadcrumbs" />
      </div>
    </div> -->
  </div>
</template>