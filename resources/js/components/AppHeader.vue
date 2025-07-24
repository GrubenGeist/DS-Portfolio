<script setup lang="ts">
// =============================================================================
// IMPORTS
// Hier werden alle externen Abhängigkeiten, Komponenten und Hilfsfunktionen geladen.
// =============================================================================

// Eigene, wiederverwendbare Vue-Komponenten
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Sun, Moon } from 'lucide-vue-next'; 
import { useAppearance } from '@/composables/useAppearance'; // Deinen bestehenden Composable importieren
import GhostButton from '@/components/GhostButton.vue';

// UI-Komponenten aus der shadcn-vue Bibliothek
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import {
    NavigationMenu, // Der Hauptcontainer für die Desktop-Navigation
    NavigationMenuItem, // Ein einzelner Punkt in der Navigationsleiste (<li>)
    NavigationMenuLink, // Ein klickbarer Link innerhalb der Navigation
    NavigationMenuList, // Die Liste, die die Items hält (<ul>)
    navigationMenuTriggerStyle, // Eine Hilfsfunktion, die CSS-Klassen für das Standard-Aussehen von Nav-Links liefert
} from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';

// Composables (wiederverwendbare Logik-Pakete in Vue)
import { getInitials } from '@/composables/useInitials'; // Holt die Initialen eines Namens (z.B. "Dennis Strauß" -> "DS")
import { useNavigation } from '@/composables/useNavigation'; // Stellt alle Navigationsdaten und den User-Status bereit

// TypeScript-Typen für Typsicherheit
import type { NavItem, BreadcrumbItem as BreadcrumbItemType } from '@/types';

// Framework-spezifische Helfer
import { Link, usePage } from '@inertiajs/vue3'; // Für nahtloses Routing in einer Laravel/Inertia-Anwendung
import { LogIn, Menu, Search, UserPlus } from 'lucide-vue-next'; // Icon-Bibliothek
import { route } from 'ziggy-js'; // Erzeugt Laravel-Routen im Frontend

// --- THEME-LOGIK ---
// Wir rufen deinen Composable auf, um den aktuellen Zustand und die Update-Funktion zu erhalten.
const { appearance, updateAppearance } = useAppearance();

// Neue Funktion, die zwischen Light und Dark umschaltet.
const toggleTheme = () => {
    const newAppearance = appearance.value === 'dark' ? 'light' : 'dark';
    updateAppearance(newAppearance);
};

// =============================================================================
// LOGIK (SCRIPT-TEIL)
// =============================================================================

// Holt die Navigationsdaten und den Authentifizierungsstatus aus unserem Composable.
const {
    filteredMainNavItems, // Array der Haupt-Navigationspunkte (z.B. Startseite, Weitere Informationen)
    filteredRightNavItems, // Array der rechten Navigationspunkte (z.B. externe Links wie GitHub)
    isGuest, // Boolean: Ist der aktuelle Benutzer ein Gast?
    user, // Objekt mit den Daten des eingeloggten Benutzers
    canRegister, // Boolean: Ist die Registrierung auf der Seite erlaubt?
} = useNavigation();

// `usePage` von Inertia gibt uns Zugriff auf seiten-spezifische Daten, z.B. die aktuelle URL.
const page = usePage();
// Fallback-Bild, falls ein Benutzer keinen Avatar hat.
const defaultAvatar = '';

// Definiert die Props, die diese Komponente von außen annehmen kann.
interface Props {
    breadcrumbs?: BreadcrumbItemType[]; // Eine optionale Liste von Breadcrumb-Links
}

// Setzt Standardwerte für die Props (in diesem Fall ein leeres Array für die Breadcrumbs).
const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

// `computed` bedeutet, dass dieser Wert reaktiv ist und sich automatisch neu berechnet, wenn sich `page.url` ändert.
// Diese Funktion prüft, ob ein Navigationspunkt (oder eines seiner Kinder) aktiv ist, indem die URL verglichen wird.
const isNavItemActive = computed(() => (item: NavItem) => { // KORREKTUR: Typ `NavItem` wird hier verwendet.
    if (!item) return false;
    const currentUrl = page.url;

    // Prüft die URL des Haupt-Items
    if (item.href) {
        if (currentUrl === item.href) return true;
        if (item.href !== '/' && currentUrl.startsWith(item.href + '/')) return true;
    }
    // Wenn das Item Kinder hat (ein Dropdown ist), prüfe auch die URLs der Kinder.
    if (item.children) {
        return item.children.some(
            (child) => child.href && (currentUrl === child.href || (child.href !== '/' && currentUrl.startsWith(child.href + '/'))),
        );
    }
    return false;
});

// Gibt basierend auf `isNavItemActive` die passenden CSS-Klassen für die Hervorhebung zurück.
const activeItemStyles = computed(
    () =>
        (
            item: NavItem, // KORREKTUR: Typ `NavItem` wird hier verwendet.
        ) => (isNavItemActive.value(item) ? 'text-neutral-900 dark:text-neutral-50 bg-muted dark:bg-neutral-800' : ''),
);

</script>

<template>
    <div>
        <div class="border-b border-sidebar-border/80 dark:bg-stone-900">
            <div class="flex h-16 w-full items-center px-2 md:px-2">

                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button variant="secondary" size="lg" class="mr-2 h-9 w-9">
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-300px] p-6">
                            <SheetTitle class="sr-only">Navigation</SheetTitle>
                            <SheetHeader class="mb-4 flex justify-start text-left">
                                <Link :href="route('welcome')">
                                    <AppLogoIcon class="size-7 fill-current text-black dark:text-white" />
                                </Link>
                            </SheetHeader>
                            <div class="flex h-full flex-1 flex-col justify-between space-y-4">
                                <nav class="grid items-start gap-2 px-2 text-sm font-medium">
                                    <template v-for="item in filteredMainNavItems" :key="item.title">

                                        <div v-if="item.children && item.children.length > 0" class="space-y-1">
                                            <h4 class="px-3 py-2 font-semibold text-muted-foreground">{{ item.title }}</h4>
                                            <Link
                                                v-for="child in item.children"
                                                :key="child.title"
                                                :href="child.href!"
                                                class="flex items-center gap-3 rounded-lg border border-border px-3 py-2 text-foreground transition-colors hover:bg-accent"
                                                :class="{ 'bg-primary text-primary-foreground hover:bg-primary/90': isNavItemActive(child) }"
                                            >
                                                <component :is="child.icon" class="h-4 w-4" />
                                                {{ child.title }}
                                            </Link>
                                        </div>
                                    
                                        <Link
                                            v-else
                                            :href="item.href!"
                                            class="flex items-center gap-3 rounded-lg border border-border px-3 py-2 text-foreground transition-colors hover:bg-accent"
                                            :class="{ 'bg-primary text-primary-foreground hover:bg-primary/90': isNavItemActive(item) }"
                                        >
                                            <component :is="item.icon" class="h-4 w-4" />
                                            {{ item.title }}
                                        </Link>
                                        


                                    </template>

                                    <GhostButton :tracking-data="{ category: 'Easter Egg', label: 'MobileNavbar Ghostbutton' }"/>


                                </nav>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <div class="hidden h-full items-center lg:flex">
                    <Link :href="route('welcome')" class="mr-12">
                        <AppLogoIcon class="size-7 fill-current text-black dark:text-white" />
                    </Link>
                    
                    <NavigationMenu class="relative">
                        <NavigationMenuList class="flex space-x-1">
                            
                            <template v-for="item in filteredMainNavItems" :key="item.title">
                                <NavigationMenuItem>
                                    
                                    <template v-if="item.children && item.children.length > 0">
                                        <DropdownMenu>
                                            <DropdownMenuTrigger as-child>
                                                <Button
                                                    variant="ghost"
                                                    :class="[navigationMenuTriggerStyle(), 'h-9 px-3 text-sm focus-visible:ring-0', activeItemStyles(item)]"
                                                >
                                                    <component :is="item.icon" class="mr-1.5 h-4 w-4 opacity-80" />
                                                    {{ item.title }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="relative top-[1px] ml-1 h-3 w-3 transition duration-200 group-data-[state=open]:rotate-180"><path d="m6 9 6 6 6-6"></path></svg>
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
                                                    <Link :href="child.href!" :class="activeItemStyles(child)">
                                                        <component v-if="child.icon" :is="child.icon" class="mr-2 h-4 w-4" />
                                                        <span>{{ child.title }}</span>
                                                    </Link>
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </template>
                                    
                                    <template v-else-if="item.href">
                                        <Link :href="item.href" legacy-behavior passHref>
                                            <NavigationMenuLink
                                                :active="isNavItemActive(item)"
                                                :class="[navigationMenuTriggerStyle(), activeItemStyles(item), 'h-9 px-3 text-sm']"
                                            >
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

                <div class="ml-auto flex items-center space-x-4">
                    <button
                        @click="toggleTheme"
                        type="button"
                        class="relative inline-flex h-7 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-slate-200 dark:bg-slate-700 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2"
                        role="switch"
                        :aria-checked="appearance === 'dark'"
                    >
                        <span class="sr-only">Theme umschalten</span>

                        <span
                            aria-hidden="true"
                            :class="appearance === 'dark' ? 'translate-x-7' : 'translate-x-0'"
                            class="pointer-events-none relative inline-block h-6 w-6 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"
                        >
                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity" :class="appearance === 'dark' ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200'"></span>
                            <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity" :class="appearance === 'dark' ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100'"></span>

                            <Sun v-if="appearance !== 'dark'" class="absolute inset-0 h-full w-full p-1 text-yellow-500" />
                            <Moon v-else class="absolute inset-0 h-full w-full p-1 text-slate-800" />
                        </span>
                    </button>   

                    
                    <template v-if="isGuest">
                        <div class="flex items-center space-x-4">
                            <GhostButton v-track-click="{ category: 'Ghostbutton', label: 'Ghostbutton Nav' }" />
                        </div>



                    </template>
                        <template v-else-if="user">
                            <div class="flex items-center pr-4">
                                <DropdownMenu>
                                    <DropdownMenuTrigger :as-child="true">
                                        <Button variant="ghost" class="relative h-10 w-10 rounded-full ">
                                            <Avatar class="size-11">
                                                <AvatarImage :src="user.avatar || defaultAvatar" :alt="user.name ?? 'User Avatar'" />
                                                <AvatarFallback class="bg-muted ...">
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

        <div v-if="props.breadcrumbs && props.breadcrumbs.length > 0" class="flex w-full border-b border-sidebar-border/70">
            <div class="flex h-12 w-full items-center justify-start px-2 md:px-44 text-sm text-muted-foreground">
                <Breadcrumbs :breadcrumbs="props.breadcrumbs" />
            </div>
        </div>
    </div>
</template>

