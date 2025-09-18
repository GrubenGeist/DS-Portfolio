// resources/js/types/index.d.ts
import type { PageProps } from '@inertiajs/core';
import type { Config } from 'ziggy-js';
import type { Component } from 'vue';

/* ---------- Grundtypen ---------- */
export interface BreadcrumbItem {
  title: string;
  href?: string;
}
/*export type BreadcrumbItemType = BreadcrumbItem;*/

/* Navigationseinträge (Icon optional, Kinder rekursiv) */
export interface NavItem {
  show: unknown;
  title: string;
  href?: string;
  icon?: Component;
  showToGuests?: boolean;
  roles?: string[];
  children?: NavItem[];
}

/* User + Auth */
export interface User {
    last_name: any;
    first_name: any;
    id: number;
    name: string;
    company?: string | null;
    email: string;
    avatar?: string | null | undefined;
    email_verified_at: string | null;
    created_at: string | null;
    updated_at: string | null;
    roles?: string[]; // optional – falls mal nicht mitgesendet
}
export interface Auth {
  user: User;
}
// generischen Typ für paginierte Daten
export type Paginated<T> = {
    data: T[];
    links: {
        first: string;
        last: string;
        prev: string | null;
        next: string | null;
    };
    meta: {
        current_page: number;
        from: number;
        last_page: number;
        path: string;
        per_page: number;
        to: number;
        total: number;
        links: { url: string | null; label: string; active: boolean }[];
    };
};

/* Inertia-Shared Props */
export interface SharedData extends PageProps {
  name?: string;
  quote?: { message: string; author: string };
  auth: Auth;
  ziggy: Config & { location: string };
}

/* Für deine Projects-Seite */
export interface Project {
  title: string;
  description: string;
  image: string;
  technologies: string[];
  liveUrl: string;
  repoUrl: string;
}
export interface Skill {
  name: string;
  color: string;
  logoUrl: string;
}

export {};
