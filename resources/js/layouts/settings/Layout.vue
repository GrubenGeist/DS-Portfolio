<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { type NavItem } from '@/types'; // Stelle sicher, dass NavItem hier 'href' und 'title' hat, aber nicht zwingend 'icon'
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue'; // computed importieren
import { route } from 'ziggy-js'; // route importieren, falls noch nicht geschehen (scheint aber schon da zu sein)

// Navigationsitems für die Sidebar der Settings-Seite
const sidebarNavItems: NavItem[] = [
    { title: 'Profile', href: route('settings.profile.edit') },
    { title: 'Password', href: route('settings.password.edit') },
    { title: 'Appearance', href: route('settings.appearance') },
];

const page = usePage(); // usePage<SharedData>() wenn du SharedData typisiert hast

const currentPath = computed(() => (page.props.ziggy?.location ? new URL(page.props.ziggy.location).pathname : ''));

// --- NEU: Admin-Status holen ---
const userRoles = computed(() => page.props.auth.user?.roles || []);
const isAdmin = computed(() => userRoles.value.includes('Admin'));
</script>

<template>
    <div class="px-4 py-6">
        <Heading title="Settings" description="Manage your profile and account settings" />

        <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-x-12 lg:space-y-0">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-x-0 space-y-1">
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="item.href"
                        variant="ghost"
                        :class="['w-full justify-start', { 'bg-muted': currentPath === item.href }]"
                        as-child
                    >
                        <Link :href="item.href">
                            {{ item.title }}
                        </Link>
                    </Button>

                    <Link
                        v-if="isAdmin"
                        :href="route('admin.register.form')"
                        class="mt-2 inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Neuen User Registrieren
                    </Link>
                </nav>
            </aside>

            <Separator class="my-6 md:hidden" />

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
