// resources/js/components/AppHeader.vue
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
import type { BreadcrumbItem as BreadcrumbItemType } from '@/types'; // Dein BreadcrumbItem-Typ
import { Link, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { Menu, Search, LogIn, UserPlus } from 'lucide-vue-next'; // Nur noch Icons, die direkt im Template genutzt werden
import { computed } from 'vue';
import { useNavigation } from '@/composables/useNavigation'; // Importiere das Composable

// Hol dir die aufbereiteten Navigationsdaten und Zustände vom Composable
const {
    filteredMainNavItems,
    filteredRightNavItems,
    isGuest,
    user, // Dieses 'user'-Objekt ist jetzt AppUser | null
    canRegister, // Sollte 'false' sein, da die öffentliche Route 'register' nicht mehr existiert
    // isAdmin, // Kann hier auch destrukturiert werden, wenn du es direkt im Template brauchst
    // showAdminSpecificLinks // Wird eher in UserMenuContent oder Settings/Index gebraucht
} = useNavigation();

// 'page' wird für 'isCurrentRoute' und die von der Seite kommenden 'props.breadcrumbs' benötigt
const page = usePage(); // PageProps sind global typisiert durch inertia.d.ts

// Pfad zum Standard-Avatar
const defaultAvatar = ''; // Stelle sicher, dass dieses Bild in public/images/ existiert

// Props, die AppHeader von außen empfängt (z.B. vom AppLayout)
interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}
const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

// Diese Logik bleibt in AppHeader.vue, da sie sich auf die Darstellung der Navigationslinks bezieht
const isCurrentRoute = computed(() => (url: string) => {
    if (page.url === url) return true;
    if (url !== '/' && page.url.startsWith(url + '/')) return true; // Einfacher Abgleich für aktive Unterseiten
    return false;
});

const activeItemStyles = computed(
    () => (url: string) => (isCurrentRoute.value(url) ? 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100' : ''),
);
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
                             <SheetTitle class="sr-only">Navigation</SheetTitle>
                             <SheetHeader class="flex justify-start text-left mb-4">
                                 <Link :href="route('welcome')">
                                    <AppLogoIcon class="size-7 fill-current text-black dark:text-white" />
                                 </Link>
                             </SheetHeader>
                             <div class="flex h-full flex-1 flex-col justify-between space-y-4">
                                 <nav class="-mx-3 space-y-1">
                                     <Link
                                         v-for="item in filteredMainNavItems"
                                         :key="item.title"
                                         :href="item.href"
                                         class="flex items-center gap-x-3 rounded-lg px-3 py-2.5 text-sm font-medium hover:bg-accent"
                                         :class="activeItemStyles(item.href)"
                                     >
                                         <component :is="item.icon" class="h-5 w-5 opacity-80" />
                                         {{ item.title }}
                                     </Link>
                                 </nav>
                                 <div class="flex flex-col space-y-4 border-t pt-4">
                                     <a
                                         v-for="item in filteredRightNavItems"
                                         :key="item.title"
                                         :href="item.href"
                                         target="_blank"
                                         rel="noopener noreferrer"
                                         class="flex items-center space-x-2 text-sm font-medium hover:text-primary"
                                     >
                                         <component :is="item.icon" class="h-5 w-5 opacity-80" />
                                         <span>{{ item.title }}</span>
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
                             <NavigationMenuItem v-for="item in filteredMainNavItems" :key="item.title" class="relative flex h-full items-center">
                                 <Link :href="item.href">
                                     <NavigationMenuLink
                                         :class="[navigationMenuTriggerStyle(), activeItemStyles(item.href), 'h-9 cursor-pointer px-3 text-sm']"
                                     >
                                         <component :is="item.icon" class="mr-1.5 h-4 w-4 opacity-80" />
                                         {{ item.title }}
                                     </NavigationMenuLink>
                                 </Link>
                                 <div
                                     v-if="isCurrentRoute(item.href)"
                                     class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-primary dark:bg-white"
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
                            <template v-for="item in filteredRightNavItems" :key="item.title">
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
                                        <TooltipContent side="bottom">
                                            <p>{{ item.title }}</p>
                                        </TooltipContent>
                                    </Tooltip>
                                </TooltipProvider>
                            </template>
                        </div>
                    </div>

                    <div v-if="isGuest" class="flex items-center space-x-1">
                        <Link :href="route('login')">
                            <Button variant="ghost" class="h-9 px-3 text-sm">
                                <LogIn class="mr-2 h-4 w-4" /> Login
                            </Button>
                        </Link>
                        <Link v-if="canRegister" :href="route('register')"> 
                             <Button variant="default" class="h-9 px-3 text-sm">
                                <UserPlus class="mr-2 h-4 w-4" /> Registrieren
                             </Button>
                        </Link>
                    </div>

                    <DropdownMenu v-else-if="user"> 
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