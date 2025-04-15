<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { getInitials } from '@/composables/useInitials';
import type { BreadcrumbItem, NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
// +++ ZIGGY IMPORT HINZUGEFÜGT (für Login/Register Links) +++
import { route } from 'ziggy-js';
// Icons importieren
import { BookOpen, Folder, LayoutGrid, Menu, Search, LogIn, UserPlus } from 'lucide-vue-next'; // LogIn, UserPlus hinzugefügt
import { computed } from 'vue';

// Computed Property für den User (ist null, wenn nicht eingeloggt)
const user = computed(() => usePage().props.auth.user as { id: number; name: string; email: string; avatar?: string|null } | null); // Typ etwas spezifischer gemacht

// Pfad zum Standard-Avatar (bleibt)
const defaultAvatar = '/images/default-avatar.png';

interface Props {
    breadcrumbs?: BreadcrumbItem[];
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();
// computed 'auth' ist nicht unbedingt nötig, da wir 'user' haben
// const auth = computed(() => page.props.auth);

const isCurrentRoute = computed(() => (url: string) => page.url === url);

const activeItemStyles = computed(
    () => (url: string) => (isCurrentRoute.value(url) ? 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100' : ''),
);

// HINWEIS: Diese hardcodierten hrefs könnten auch route() verwenden, falls die Routen benannt sind
const mainNavItems: NavItem[] = [
    { title: 'Dashboard', href: route('dashboard'), icon: LayoutGrid }, // Beispiel mit route()
    { title: 'Testseite', href: route('test'), icon: LayoutGrid }, // Beispiel mit route()
    { title: 'Über Mich', href: route('aboutme'), icon: LayoutGrid }, // Beispiel mit route()
    { title: 'Projekte', href: route('projects'), icon: LayoutGrid }, // Beispiel mit route()
    { title: 'Dienstleistungen', href: route('services'), icon: LayoutGrid }, // Beispiel mit route()
    { title: 'Kontaktformular', href: route('Kontaktformular'), icon: LayoutGrid }, // Beispiel mit route()
];

const rightNavItems: NavItem[] = [
    { title: 'Repository', href: 'https://github.com/laravel/vue-starter-kit', icon: Folder },
    { title: 'Documentation', href: 'https://laravel.com/docs/starter-kits', icon: BookOpen },
];
</script>

<template>
    <div>
        <div class="border-b border-sidebar-border/80">
            <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button variant="ghost" size="icon" class="mr-2 h-9 w-9">
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-[300px] p-6">
                             <SheetTitle class="sr-only">Navigation Menu</SheetTitle>
                             <SheetHeader class="flex justify-start text-left">
                                 <AppLogoIcon class="size-6 fill-current text-black dark:text-white" />
                             </SheetHeader>
                             <div class="flex h-full flex-1 flex-col justify-between space-y-4 py-6">
                                 <nav class="-mx-3 space-y-1">
                                     <Link
                                         v-for="item in mainNavItems"
                                         :key="item.title"
                                         :href="item.href"
                                         class="flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium hover:bg-accent"
                                         :class="activeItemStyles(item.href)"
                                     >
                                         <component v-if="item.icon" :is="item.icon" class="h-5 w-5" />
                                         {{ item.title }}
                                     </Link>
                                 </nav>
                                 <div class="flex flex-col space-y-4">
                                     <a
                                         v-for="item in rightNavItems"
                                         :key="item.title"
                                         :href="item.href"
                                         target="_blank"
                                         rel="noopener noreferrer"
                                         class="flex items-center space-x-2 text-sm font-medium"
                                     >
                                         <component v-if="item.icon" :is="item.icon" class="h-5 w-5" />
                                         <span>{{ item.title }}</span>
                                     </a>
                                 </div>
                             </div>
                         </SheetContent>
                    </Sheet>
                </div>

                <div class="hidden h-full lg:flex lg:flex-1">
                    <NavigationMenu class="ml-10 flex h-full items-stretch">
                         <NavigationMenuList class="flex h-full items-stretch space-x-2">
                             <NavigationMenuItem v-for="(item, index) in mainNavItems" :key="index" class="relative flex h-full items-center">
                                 <Link :href="item.href">
                                     <NavigationMenuLink
                                         :class="[navigationMenuTriggerStyle(), activeItemStyles(item.href), 'h-9 cursor-pointer px-3']"
                                     >
                                         <component v-if="item.icon" :is="item.icon" class="mr-2 h-4 w-4" />
                                         {{ item.title }}
                                     </NavigationMenuLink>
                                 </Link>
                                 <div
                                     v-if="isCurrentRoute(item.href)"
                                     class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white"
                                 ></div>
                             </NavigationMenuItem>
                         </NavigationMenuList>
                     </NavigationMenu>
                </div>

                <div class="ml-auto flex items-center space-x-2">
                    <div class="relative flex items-center space-x-1">
                        <Button variant="ghost" size="icon" class="group h-9 w-9 cursor-pointer">
                            <Search class="size-5 opacity-80 group-hover:opacity-100" />
                        </Button>

                        <div class="hidden space-x-1 lg:flex">
                            <template v-for="item in rightNavItems" :key="item.title">
                                <TooltipProvider :delay-duration="0">
                                    <Tooltip>
                                        <TooltipTrigger>
                                            <Button variant="ghost" size="icon" as-child class="group h-9 w-9 cursor-pointer">
                                                <a :href="item.href" target="_blank" rel="noopener noreferrer">
                                                    <span class="sr-only">{{ item.title }}</span>
                                                    <component :is="item.icon" class="size-5 opacity-80 group-hover:opacity-100" />
                                                </a>
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent>
                                            <p>{{ item.title }}</p>
                                        </TooltipContent>
                                    </Tooltip>
                                </TooltipProvider>
                            </template>
                        </div>
                    </div>

                    <div v-if="!user" class="flex items-center space-x-1">
                        <Link :href="route('login')"> <Button variant="ghost" class="h-9 px-3">
                                <LogIn class="mr-2 h-4 w-4" /> Login
                            </Button>
                        </Link>
                        <Link :href="route('register')"> <Button variant="ghost" class="h-9 px-3">
                                 <UserPlus class="mr-2 h-4 w-4" /> Register
                             </Button>
                        </Link>
                    </div>

                    <DropdownMenu v-else>
                        <DropdownMenuTrigger :as-child="true">
                            <Button
                                variant="ghost"
                                size="icon"
                                class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
                            >
                                <Avatar class="size-8 overflow-hidden rounded-full">
                                    <AvatarImage
                                        :src="user.avatar || defaultAvatar"
                                        :alt="user.name ?? 'User Avatar'" /> <AvatarFallback class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white">
                                        {{ getInitials(user.name) }}
                                    </AvatarFallback>
                                </Avatar>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-56">
                            <UserMenuContent :user="user" />
                        </DropdownMenuContent>
                    </DropdownMenu>
                     </div>
            </div>
        </div>

        <div v-if="props.breadcrumbs.length > 1" class="flex w-full border-b border-sidebar-border/70">
            <div class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>
        </div>
    </div>
</template>