// resources/js/composables/useNavigation.ts
import { usePage } from '@inertiajs/vue3';
import { computed, type Component } from 'vue';
import { route } from 'ziggy-js';

// Importiere Icons - stelle sicher, dass alle verwendeten Icons hier sind.
// Info, Briefcase, SettingsIcon werden jetzt auch für die Kinder von "Über Mich" verwendet.
import {
    BookOpen, // Für "Dashboard" (falls es wieder in die Hauptnavigation käme)
    Briefcase,
    FileText, // Für "Testseite (Admin)" (falls es wieder in die Hauptnavigation käme)
    Folder,
    Home,
    Info, // Für "Projekte" (Kind von "Über Mich")
    Settings as SettingsIcon,
} from 'lucide-vue-next';

// Das AppNavItem Interface ist bereits gut vorbereitet mit optionalem href und children.
export interface AppNavItem {
    title: string;
    href?: string; // Optional, da ein Dropdown-Trigger selbst keinen Link haben muss
    icon: Component;
    showToGuests?: boolean;
    roles?: string[];
    children?: AppNavItem[]; // Array für Untermenüpunkte
}

export function useNavigation() {
    const page = usePage();
    const user = computed(() => page.props.auth.user);
    const userRoles = computed(() => user.value?.roles || []);
    const isGuest = computed(() => !user.value);
    const isAdmin = computed(() => userRoles.value.includes('Admin'));

    // Hauptnavigations-Items definieren
    const allMainNavItems: AppNavItem[] = [
        { title: 'Startseite', href: route('welcome'), icon: Home, showToGuests: true },
        // { title: 'Kontaktformular', href: route('Kontaktformular'), icon: FileText, showToGuests: true },
        {
            // --- ÄNDERUNG: "Über Mich" wird zum Dropdown-Parent ---
            title: 'Weitere Informationen',
            icon: Info, // Icon für den Hauptpunkt "Über Mich"
            // href: route('aboutme'), // Entferne oder behalte href, je nachdem, ob "Über Mich" selbst klickbar sein soll.
            // Wenn es nur das Dropdown öffnet, ist kein href nötig.
            // Wenn es auch eine eigene Seite hat, sollte ein Kind-Element darauf verlinken (siehe unten).
            roles: ['Company', 'Admin'], // Sichtbarkeit des Haupt-Dropdown-Punkts
            showToGuests: false,
            children: [
                // --- NEU: Untermenüpunkte für "Über Mich" ---
                {
                    title: 'Über Mich Seite', // Expliziter Link zur "Über Mich"-Inhaltsseite
                    href: route('aboutme'), // Verweist auf die existierende 'aboutme'-Route
                    icon: Info, // Kann dasselbe oder ein anderes Icon sein
                    roles: ['Company', 'Admin'],
                    showToGuests: false,
                },
                {
                    title: 'Projekte',
                    href: route('projects'),
                    icon: Briefcase, // Icon für Projekte
                    roles: ['Company', 'Admin'],
                    showToGuests: false,
                },
                {
                    title: 'Dienstleistungen',
                    href: route('services'),
                    icon: SettingsIcon, // Icon für Dienstleistungen
                    roles: ['Admin'], // Rollen spezifisch für dieses Subitem (ggf. anpassen)
                    showToGuests: false,
                },
            ],
        },
        // { title: 'Über Mich', href: route('aboutme'), icon: Info, roles: ['Company', 'Admin'], showToGuests: false }, // ALTER "Über Mich"-Eintrag ist jetzt Teil des Dropdowns
        // { title: 'Dashboard', href: route('dashboard'), icon: LayoutGrid, roles: ['Admin'] }, // Bereits aus der Hauptnavigation entfernt
        // { title: 'Projekte', href: route('projects'), icon: Briefcase, roles: ['Company', 'Admin'] }, // ALTER "Projekte"-Eintrag ist jetzt Kind von "Über Mich"
        // { title: 'Dienstleistungen', href: route('services'), icon: SettingsIcon, roles: ['Admin'] }, // ALTER "Dienstleistungen"-Eintrag ist jetzt Kind von "Über Mich"
        // { title: 'Testseite (Admin)', href: route('test'), icon: UserCog, roles: ['Admin'] }, // Bereits aus der Hauptnavigation entfernt
    ];

    // Die Filterlogik für filteredMainNavItems muss jetzt auch die Kinder berücksichtigen,
    // und entscheiden, ob ein Parent-Item (Dropdown-Trigger) angezeigt wird,
    // auch wenn es selbst keinen href hat, aber sichtbare Kinder.
    const filteredMainNavItems = computed(() => {
        return allMainNavItems
            .map((item) => {
                // Wenn das Item Kinder hat, filtere zuerst die Kinder
                if (item.children && item.children.length > 0) {
                    const visibleChildren = item.children.filter((child) => {
                        if (isGuest.value) return !!child.showToGuests;
                        if (child.showToGuests && (!child.roles || child.roles.length === 0)) return true;
                        if (!child.roles || child.roles.length === 0) return child.showToGuests !== false;
                        return child.roles.some((role) => userRoles.value.includes(role));
                    });

                    // Wenn es sichtbare Kinder gibt, gib das Parent-Item mit den gefilterten Kindern zurück
                    if (visibleChildren.length > 0) {
                        return { ...item, children: visibleChildren };
                    }
                    // Wenn keine Kinder sichtbar sind UND das Parent-Item selbst keinen Link hat, zeige es nicht an.
                    // Hat es einen Link, behandle es wie ein normales Item weiter unten.
                    if (!item.href) {
                        return null;
                    }
                }
                // Normale Filterung für Items ohne Kinder oder Parent-Items mit eigenem href (wenn keine Kinder sichtbar waren)
                if (isGuest.value) return !!item.showToGuests ? item : null;
                if (item.showToGuests && (!item.roles || item.roles.length === 0)) return item;
                if (!item.roles || item.roles.length === 0) return item.showToGuests !== false ? item : null;
                return item.roles.some((role) => userRoles.value.includes(role)) ? item : null;
            })
            .filter((item) => item !== null) as AppNavItem[]; // Entferne null-Einträge und typisiere korrekt
    });

    // Rechte Navigations-Items und deren Filterung bleiben wie zuvor
    const allRightNavItems: AppNavItem[] = [
        { title: 'Repository', href: 'https://github.com/dein-repo', icon: Folder, showToGuests: true },
        { title: 'Dokumentation', href: 'https://deine-doku.de', icon: BookOpen, showToGuests: true },
    ];
    const filteredRightNavItems = computed(() => {
        /* ... deine bestehende Filterlogik ... */
    });

    const canRegister = computed(() => page.props.canRegister);
    const showAdminSpecificLinks = isAdmin;

    return {
        filteredMainNavItems,
        filteredRightNavItems,
        isGuest,
        user,
        canRegister,
        isAdmin,
        showAdminSpecificLinks,
    };
}
