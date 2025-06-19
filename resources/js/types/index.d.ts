import type { PageProps } from '@inertiajs/core';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href?: string;
}

export interface NavItem {
    title: string;
    href?: string; // Wird für Top-Level-Dropdown-Trigger optional
    icon: Component;
    showToGuests?: boolean;
    roles?: string[];
    children?: AppNavItem[]; // NEU: Für Untermenüpunkte
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string | null;
    updated_at: string | null;
}

export type BreadcrumbItemType = BreadcrumbItem;
