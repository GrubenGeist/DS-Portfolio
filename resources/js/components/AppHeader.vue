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
    NavigationMenuTrigger,
    NavigationMenuContent,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { getInitials } from '@/composables/useInitials';
import type { BreadcrumbItem as BreadcrumbItemType, AppNavItem } from '@/types'; // AppNavItem importieren, falls global definiert
import { Link, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { Menu, Search, LogIn, UserPlus } from 'lucide-vue-next'; // ChevronDown wird von NavigationMenuTrigger intern verwendet
import { computed } from 'vue';
import { useNavigation } from '@/composables/useNavigation';

const {
    filteredMainNavItems,
    filteredRightNavItems,
    isGuest,
    user,
    canRegister,
    // isDropdownOpen, toggleDropdown etc. sind für shadcn/vue NavigationMenu nicht direkt hier nötig
} = useNavigation();

const page = usePage();
const defaultAvatar = '/images/default-avatar.png'; // Sicherstellen, dass dieses Bild existiert!

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}
const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

// Prüft, ob das Item selbst oder eines seiner Kinder aktiv ist
const isNavItemActive = computed(() => (item: AppNavItem) => {
    if (!item) return false;
    const currentUrl = page.url;
    // Das Parent-Item "Über Mich" hat in useNavigation.ts keinen eigenen href mehr, wenn es nur Trigger ist.
    // Wenn es doch einen href hat (für den ersten Link im Dropdown), wird dieser hier geprüft.
    if (item.href) {
        if (currentUrl === item.href) return true;
        if (item.href !== '/' && currentUrl.startsWith(item.href + '/')) return true;
    }
    // Prüft, ob eines der Kinder aktiv ist (wichtig für den aktiven Zustand des Triggers)
    if (item.children) {
        return item.children.some(child => child.href && (currentUrl === child.href || (child.href !== '/' && currentUrl.startsWith(child.href + '/'))));
    }
    return false;
});

const activeItemStyles = computed(
    () => (item: AppNavItem) => // Akzeptiert jetzt ein AppNavItem-Objekt
        (isNavItemActive.value(item) ? 'text-neutral-900 dark:text-neutral-50 bg-muted dark:bg-neutral-800' : ''),
);
</script>

<template>
    <div>
        <div class="border-b border-sidebar-border/80">
            <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                <div class="lg:hidden"> {/* Mobile Navigation */}
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button variant="ghost" size="icon" class="mr-2 h-9 w-9">
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-[300px] p-6">
                            <SheetTitle class="sr-only">Navigation</SheetTitle>
                            <SheetHeader class="flex justify-start text-left mb-4">
                                <Link :href="route('welcome')">
                                <AppLogoIcon class="size-7 fill-current text-black dark:text-white" />
                                </Link>
                            </SheetHeader>
                            <div class="flex h-full flex-1 flex-col justify-between space-y-4">
                                <nav class="-mx-3 space-y-1">
                                    <template v-for="item in filteredMainNavItems" :key="item.title">
                                        <div class="space-y-1">
                                            {/* Parent-Item im mobilen Menü */}
                                            <div 
                                                class="flex items-center justify-between gap-x-3 rounded-lg px-3 py-2.5 text-sm font-medium"
                                                :class="[item.href ? 'hover:bg-accent' : 'text-gray-700 dark:text-gray-300', activeItemStyles(item)]"
                                            >
                                                <Link v-if="item.href" :href="item.href" class="flex items-center gap-x-3 grow">
                                                    <component :is="item.icon" class="h-5 w-5 opacity-80" />
                                                    {{ item.title }}
                                                </Link>
                                                <span v-else class="flex items-center gap-x-3">
                                                     <component :is="item.icon" class="h-5 w-5 opacity-80" />
                                                    {{ item.title }}
                                                </span>
                                                {/* Optional: Chevron für mobile Dropdowns, wenn man sie einklappbar machen will */}
                                            </div>
                                            {/* Kinder-Links mit Einrückung */}
                                            <div v-if="item.children && item.children.length > 0" class="ml-5 space-y-1 border-l border-gray-200 dark:border-gray-700 pl-3 py-1">
                                                <Link
                                                    v-for="child in item.children"
                                                    :key="child.title"
                                                    :href="child.href!"
                                                    class="flex items-center gap-x-3 rounded-lg px-3 py-1.5 text-sm font-normal hover:bg-accent text-muted-foreground"
                                                    :class="activeItemStyles(child)"
                                                >
                                                    <component v-if="child.icon" :is="child.icon" class="h-4 w-4 opacity-70" />
                                                    <span class="ml-0">{{ child.title }}</span>
                                                </Link>
                                            </div>
                                        </div>
                                    </template>
                                </nav>
                                <div class="flex flex-col space-y-4 border-t pt-4">
                                    <a
                                        v-for="extItem in filteredRightNavItems"
                                        :key="extItem.title"
                                        :href="extItem.href!"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="flex items-center space-x-2 text-sm font-medium hover:text-primary"
                                    >
                                        <component :is="extItem.icon" class="h-5 w-5 opacity-80" />
                                        <span>{{ extItem.title }}</span>
                                    </a>
                                </div>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <div class="hidden h-full lg:flex lg:flex-1 items-center"> 
                    <Link :href="route('welcome')" class="mr-6">
                    <AppLogoIcon class="size-7 fill-current text-black dark:text-white" />
                    </Link>
                    <NavigationMenu class="flex h-full items-stretch">
                        <NavigationMenuList class="flex h-full items-stretch space-x-1">
                            <template v-for="item in filteredMainNavItems" :key="item.title">
                                <NavigationMenuItem>
                                    <template v-if="item.children && item.children.length > 0">
                                        <NavigationMenuTrigger :class="[navigationMenuTriggerStyle(), 'h-9 px-3 text-sm', activeItemStyles(item)]">
                                            <component :is="item.icon" class="mr-1.5 h-4 w-4 opacity-80" />
                                            {{ item.title }}
                                            
                                        </NavigationMenuTrigger>
                                        <NavigationMenuContent>
                                            <ul class="grid w-[200px] gap-1 p-3 md:w-[250px] lg:w-[300px] bg-popover  border text-popover-foreground rounded-md shadow-lg">
                                                
                                                <li v-if="item.href">
                                                    <NavigationMenuLink as-child>
                                                        <Link
                                                            :href="item.href"
                                                            class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground"
                                                            :class="activeItemStyles(item)"
                                                        >
                                                            <div class="text-sm font-medium leading-none flex items-center">
                                                                <component v-if="item.icon" :is="item.icon" class="mr-2 h-4 w-4 opacity-70" />
                                                                {{ item.title }} </div>
                                                        </Link>
                                                    </NavigationMenuLink>
                                                </li>
                                                
                                                <li v-for="child in item.children" :key="child.title">
                                                    <NavigationMenuLink as-child>
                                                        <Link
                                                            :href="child.href!"
                                                            class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground"
                                                            :class="activeItemStyles(child)"
                                                        >
                                                            <div class="text-sm font-medium leading-none flex items-center">
                                                                <component v-if="child.icon" :is="child.icon" class="mr-2 h-4 w-4 opacity-70" />
                                                                {{ child.title }}
                                                            </div>
                                                        </Link>
                                                    </NavigationMenuLink>
                                                </li>
                                            </ul>
                                        </NavigationMenuContent>
                                    </template>
                                    <template v-else-if="item.href">
                                        <Link :href="item.href" legacy-behavior passHref>
                                            <NavigationMenuLink :active="isNavItemActive(item)" :class="[navigationMenuTriggerStyle(), activeItemStyles(item), 'h-9 px-3 text-sm']">
                                                <component :is="item.icon" class="mr-1.5 h-4 w-4 opacity-80" />
                                                {{ item.title }}
                                            </NavigationMenuLink>
                                        </Link>
                                    </template>
                                </NavigationMenuItem>
                            </template>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>

                <div class="ml-auto flex items-center space-x-2"> 
                    <div class="relative flex items-center space-x-1">
                        <Button variant="ghost" size="icon" class="group h-9 w-9 cursor-pointer">
                            <Search class="size-5 opacity-80 group-hover:opacity-100" />
                        </Button>
                        <div class="hidden space-x-1 lg:flex">
                            <template v-for="extItem in filteredRightNavItems" :key="extItem.title">
                                <TooltipProvider :delay-duration="0">
                                    <Tooltip>
                                        <TooltipTrigger>
                                            <Button variant="ghost" size="icon" as-child class="group h-9 w-9 cursor-pointer">
                                                <a :href="extItem.href!" target="_blank" rel="noopener noreferrer">
                                                    <span class="sr-only">{{ extItem.title }}</span>
                                                    <component :is="extItem.icon" class="size-5 opacity-80 group-hover:opacity-100" />
                                                </a>
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent side="bottom">
                                            <p>{{ extItem.title }}</p>
                                        </TooltipContent>
                                    </Tooltip>
                                </TooltipProvider>
                            </template>
                        </div>
                    </div>
                    <template v-if="isGuest">
                        <div class="flex items-center space-x-1">
                            <Link :href="route('login')">
                            <Button variant="ghost" class="h-9 px-3 text-sm">
                                <LogIn class="mr-2 h-4 w-4" /> Login
                            </Button>
                            </Link>
                            <Link v-if="canRegister" :href="route('admin.register.form')">
                            <Button variant="default" class="h-9 px-3 text-sm">
                                <UserPlus class="mr-2 h-4 w-4" /> Registrieren
                            </Button>
                            </Link>
                        </div>
                    </template>
                    <template v-else-if="user">
                        <DropdownMenu>
                            <DropdownMenuTrigger :as-child="true">
                                <Button
                                    variant="ghost"
                                    class="relative h-9 w-9 rounded-full focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                >
                                    <Avatar class="size-8">
                                        <AvatarImage :src="user.avatar || defaultAvatar" :alt="user.name ?? 'User Avatar'" />
                                        <AvatarFallback class="bg-muted font-semibold text-black dark:text-white">
                                            {{ getInitials(user.name ?? '') }}
                                        </AvatarFallback>
                                    </Avatar>
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end" class="w-56">
                                <UserMenuContent :user="user" />
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </template>
                </div>
            </div>
        </div>
        <div v-if="props.breadcrumbs && props.breadcrumbs.length > 0" class="flex w-full border-b border-sidebar-border/70">
            <div class="mx-auto flex h-12 w-full items-center justify-start px-4 text-sm text-muted-foreground md:max-w-7xl">
                <Breadcrumbs :breadcrumbs="props.breadcrumbs" />
            </div>
        </div>
    </div>
</template>
