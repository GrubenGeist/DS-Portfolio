// resources/js/types/index.d.ts
import type { PageProps } from '@inertiajs/core';
import type { Config } from 'ziggy-js';
import type { Component } from 'vue';

/* ---------- Grundtypen ---------- */
export interface BreadcrumbItem {
  title: string;
  href?: string;
}
export type BreadcrumbItemType = BreadcrumbItem;

/* Navigationseinträge (Icon optional, Kinder rekursiv) */
export interface NavItem {
  title: string;
  href?: string;
  icon?: Component;
  showToGuests?: boolean;
  roles?: string[];
  children?: NavItem[];
}

/* User + Auth */
export interface User {
  id: number;
  name: string;
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
