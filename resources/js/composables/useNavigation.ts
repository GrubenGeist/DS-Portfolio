// resources/js/composables/useNavigation.ts
import { usePage } from '@inertiajs/vue3';
import { computed, type Component } from 'vue';

// Icons
import {
  BookOpen,
  Briefcase,
  FileText,
  Folder,
  Home,
  Info,
  Settings as SettingsIcon,
} from 'lucide-vue-next';

export interface AppNavItem {
  title: string;
  href?: string;
  icon: Component;
  showToGuests?: boolean;
  roles?: string[];
  children?: AppNavItem[];
}

export function useNavigation() {
  const page = usePage();
  const user = computed(() => page.props.auth.user);
  const userRoles = computed<string[]>(() => user.value?.roles ?? []);
  const isGuest = computed(() => !user.value);
  const isAdmin = computed(() => userRoles.value.includes('Admin'));

  // Hauptnavigation
  const allMainNavItems: AppNavItem[] = [
    { title: 'Startseite', href: route('welcome'), icon: Home, showToGuests: true },
    
    {
      title: 'Weitere Informationen',
      icon: Info,
      roles: ['Company', 'Admin'],
      showToGuests: false,
      children: [
        {
          title: 'Über Mich Seite',
          href: route('aboutme'),
          icon: Info,
          roles: ['Company', 'Admin'],
          showToGuests: false,
        },
        {
          title: 'Projekte',
          href: route('projects'),
          icon: Briefcase,
          roles: ['Company', 'Admin'],
          showToGuests: false,
        },
        {
          title: 'Dienstleistungen',
          href: route('services'),
          icon: SettingsIcon,
          roles: ['Admin'],
          showToGuests: false,
        },
      ],
    },
    {
      title: 'Bewerbungs Unterlagen',
      icon: Info,
      roles: ['Company', 'Admin'],
      showToGuests: false,
      children: [
        {
          title: 'lebenslauf',
          href: route('lebenslauf'),
          icon: Info,
          roles: ['Company', 'Admin'],
          showToGuests: false,
        },
        {
          title: 'Projekte',
          href: route('projects'),
          icon: Briefcase,
          roles: ['Company', 'Admin'],
          showToGuests: false,
        },
        {
          title: 'Dienstleistungen',
          href: route('services'),
          icon: SettingsIcon,
          roles: ['Admin'],
          showToGuests: false,
        },
      ],
    },
  ];

  const filteredMainNavItems = computed(() => {
    return allMainNavItems
      .map((item) => {
        // Kinder nach Sichtbarkeit filtern
        if (item.children?.length) {
          const visibleChildren = item.children.filter((child) => {
            if (isGuest.value) return !!child.showToGuests;
            if (!child.roles?.length) return child.showToGuests !== false;
            return child.roles.some((r) => userRoles.value.includes(r));
          });

          if (visibleChildren.length > 0) return { ...item, children: visibleChildren };
          if (!item.href) return null; // parent ohne sichtbare Kinder nicht zeigen
        }

        // Item ohne Kinder (oder parent mit eigenem href)
        if (isGuest.value) return item.showToGuests ? item : null;
        if (!item.roles?.length) return item.showToGuests !== false ? item : null;
        return item.roles.some((r) => userRoles.value.includes(r)) ? item : null;
      })
      .filter(Boolean) as AppNavItem[];
  });

  // Rechte Navigation (externe Links etc.)
  const allRightNavItems: AppNavItem[] = [
    { title: 'Repository', href: 'https://github.com/dein-repo', icon: Folder, showToGuests: true },
    { title: 'Dokumentation', href: 'https://deine-doku.de', icon: BookOpen, showToGuests: true },
    // Beispiel für einen internen Admin-Link rechts:
    // { title: 'Testseite', href: route('test'), icon: FileText, roles: ['Admin'] },
  ];

  const filteredRightNavItems = computed(() => {
    return allRightNavItems.filter((item) => {
      if (isGuest.value) return !!item.showToGuests;
      if (!item.roles?.length) return item.showToGuests !== false;
      return item.roles.some((r) => userRoles.value.includes(r));
    });
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

/*

 Vorbereitung neuer PageController.php
 
 // resources/js/composables/useNavigation.ts
 import { usePage } from '@inertiajs/vue3';
 import { computed, type Component } from 'vue';
 
 // Icons
 import {
   BookOpen,
   Briefcase,
   FileText,
   Folder,
   Home,
   Info,
   Settings as SettingsIcon,
 } from 'lucide-vue-next';
 
 export interface AppNavItem {
   title: string;
   href?: string;
   icon: Component;
   showToGuests?: boolean;
   roles?: string[];
   children?: AppNavItem[];
 }
 
 export function useNavigation() {
   const page = usePage();
   const user = computed(() => page.props.auth.user);
   const userRoles = computed<string[]>(() => user.value?.roles ?? []);
   const isGuest = computed(() => !user.value);
   const isAdmin = computed(() => userRoles.value.includes('Admin'));
 
   // Hauptnavigation
   const allMainNavItems: AppNavItem[] = [
     { title: 'Startseite', href: route('welcome'), icon: Home, showToGuests: true },
 
     {
       title: 'Weitere Informationen',
       icon: Info,
       roles: ['Company', 'Admin'],
       showToGuests: false,
       children: [
         {
           title: 'Über Mich Seite',
           href: route('page.show', { page: 'ueber-mich' }),
           icon: Info,
           roles: ['Company', 'Admin'],
           showToGuests: false,
         },
         {
           title: 'Projekte',
           href: route('page.show', { page: 'projekte' }),
           icon: Briefcase,
           roles: ['Company', 'Admin'],
           showToGuests: false,
         },
         {
           title: 'Dienstleistungen',
           href: route('page.show', { page: 'dienstleistungen' }),
           icon: SettingsIcon,
           roles: ['Admin'],
           showToGuests: false,
         },
       ],
     },
     {
       title: 'Bewerbungs Unterlagen',
       icon: FileText,
       roles: ['Company', 'Admin'],
       showToGuests: false,
       children: [
         {
           title: 'Lebenslauf',
           href: route('page.show', { page: 'lebenslauf' }),
           icon: FileText,
           roles: ['Company', 'Admin'],
           showToGuests: false,
         },
         {
           title: 'Projekte',
           href: route('page.show', { page: 'projekte' }),
           icon: Briefcase,
           roles: ['Company', 'Admin'],
           showToGuests: false,
         },
         {
           title: 'Dienstleistungen',
           href: route('page.show', { page: 'dienstleistungen' }),
           icon: SettingsIcon,
           roles: ['Admin'],
           showToGuests: false,
         },
       ],
     },
   ];
 
   const filteredMainNavItems = computed(() => {
     return allMainNavItems
       .map((item) => {
         // Kinder nach Sichtbarkeit filtern
         if (item.children?.length) {
           const visibleChildren = item.children.filter((child) => {
             if (isGuest.value) return !!child.showToGuests;
             if (!child.roles?.length) return child.showToGuests !== false;
             return child.roles.some((r) => userRoles.value.includes(r));
           });
 
           if (visibleChildren.length > 0) return { ...item, children: visibleChildren };
           if (!item.href) return null; // parent ohne sichtbare Kinder nicht zeigen
         }
 
         // Item ohne Kinder (oder parent mit eigenem href)
         if (isGuest.value) return item.showToGuests ? item : null;
         if (!item.roles?.length) return item.showToGuests !== false ? item : null;
         return item.roles.some((r) => userRoles.value.includes(r)) ? item : null;
       })
       .filter(Boolean) as AppNavItem[];
   });
 
   // Rechte Navigation (externe Links etc.)
   const allRightNavItems: AppNavItem[] = [
     { title: 'Repository', href: 'https://github.com/dein-repo', icon: Folder, showToGuests: true },
     { title: 'Dokumentation', href: 'https://deine-doku.de', icon: BookOpen, showToGuests: true },
     // Beispiel für einen internen Admin-Link rechts:
     // { title: 'Testseite', href: route('page.show', { page: 'test' }), icon: FileText, roles: ['Admin'] },
   ];
 
   const filteredRightNavItems = computed(() => {
     return allRightNavItems.filter((item) => {
       if (isGuest.value) return !!item.showToGuests;
       if (!item.roles?.length) return item.showToGuests !== false;
       return item.roles.some((r) => userRoles.value.includes(r));
     });
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




*/
