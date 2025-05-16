// resources/js/composables/useNavigation.ts
import { computed, type Component } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
// Die globalen PageProps sollten jetzt durch inertia.d.ts bekannt sein für usePage()

// Importiere deine Icons
import {
    Home,
    FileText,
    Info,
    LayoutGrid,
    Briefcase,
    Settings as SettingsIcon,
    UserCog,
    Folder,
    BookOpen,
    // Users as UsersIcon, // Nicht mehr in allMainNavItems hier, sondern im UserMenuContent
    // UserPlus as UserPlusIcon, // Nicht mehr in allMainNavItems hier, sondern im UserMenuContent oder Settings/Index
} from 'lucide-vue-next';

// Definiere den Typ für Navigations-Items
// Exportiere ihn, damit AppHeader.vue ihn ggf. für interne Typisierungen nutzen kann,
// obwohl es primär die gefilterten Listen verwendet.
export interface AppNavItem {
    title: string;
    href: string;
    icon: Component;
    showToGuests?: boolean;
    roles?: string[];
    // Du könntest hier auch 'target', 'rel' etc. für externe Links hinzufügen
}

export function useNavigation() {
    const page = usePage(); // Sollte PageProps aus inertia.d.ts verwenden

    // 'user' ist hier vom Typ AppUser | null, dank der globalen PageProps-Definition
    const user = computed(() => page.props.auth.user);
    const userRoles = computed(() => user.value?.roles || []);
    const isGuest = computed(() => !user.value);
    const isAdmin = computed(() => userRoles.value.includes('Admin'));

    const allMainNavItems: AppNavItem[] = [
        { title: 'Startseite', href: route('welcome'), icon: Home, showToGuests: true },
        { title: 'Kontaktformular', href: route('Kontaktformular'), icon: FileText, showToGuests: true },
        { title: 'Über Mich', href: route('aboutme'), icon: Info, roles: ['Company', 'Admin'], showToGuests: false },
        { title: 'Dashboard', href: route('dashboard'), icon: LayoutGrid, roles: ['Admin'] }, // Gemäß deiner web.php nur Admin
        { title: 'Projekte', href: route('projects'), icon: Briefcase, roles: ['Company', 'Admin'] },
        { title: 'Dienstleistungen', href: route('services'), icon: SettingsIcon, roles: ['Admin'] }, // Gemäß deiner web.php nur Admin
        { title: 'Testseite (Admin)', href: route('test'), icon: UserCog, roles: ['Admin'] }, // Gemäß deiner web.php nur Admin
    ];

    const filteredMainNavItems = computed(() => {
        return allMainNavItems.filter(item => {
            if (isGuest.value) {
                return !!item.showToGuests;
            }
            if (item.showToGuests && (!item.roles || item.roles.length === 0)) {
                return true;
            }
            if (!item.roles || item.roles.length === 0) {
                return item.showToGuests !== false;
            }
            return item.roles.some(role => userRoles.value.includes(role));
        });
    });

    const allRightNavItems: AppNavItem[] = [
        { title: 'Repository', href: 'https://github.com/dein-repo', icon: Folder, showToGuests: true }, // Bitte anpassen
        { title: 'Dokumentation', href: 'https://deine-doku.de', icon: BookOpen, showToGuests: true }, // Bitte anpassen
    ];

    const filteredRightNavItems = computed(() => {
        return allRightNavItems.filter(item => {
            if (isGuest.value) {
                return !!item.showToGuests;
            }
            return !item.roles || item.roles.length === 0 || item.roles.some(role => userRoles.value.includes(role));
        });
    });

    // 'canRegister' kommt von page.props und ist durch inertia.d.ts als boolean typisiert
    const canRegister = computed(() => page.props.canRegister);

    // Wird benötigt, um im UserMenuContent oder auf der Settings-Seite konditional Links anzuzeigen
    const showAdminSpecificLinks = isAdmin;

    return {
        filteredMainNavItems,
        filteredRightNavItems,
        isGuest,
        user, // Gibt das vollständige user-Objekt (AppUser | null) zurück
        canRegister, // Für den Fall, dass du es noch irgendwo brauchst (sollte jetzt false sein)
        isAdmin, // Um in AppHeader oder anderen Komponenten auf Admin-Status zu prüfen
        showAdminSpecificLinks, // Um Admin-Links im UserMenu oder Settings/Index zu steuern
    };
}