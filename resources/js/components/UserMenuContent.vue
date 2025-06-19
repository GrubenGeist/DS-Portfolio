<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import type { User } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import {
    LayoutGrid as DashboardIcon,
    LogOut,
    Settings, // Icon für Dashboard
    FileText as TestIcon, // Oder UserCog, je nachdem, welches Icon du für die Testseite möchtest
    UserPlus as UserPlusIcon,
    Users as UsersIcon,
} from 'lucide-vue-next';
import { computed } from 'vue';
import { route } from 'ziggy-js'; // Ziggy importieren

interface Props {
    user: User;
}
const props = defineProps<Props>();

const page = usePage();
const currentUserRoles = computed(() => page.props.auth.user?.roles || []);
const isAdmin = computed(() => currentUserRoles.value.includes('Admin'));
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <UserInfo :user="props.user" :show-email="true" />
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" :href="route('settings.index')" as="button">
                <Settings class="mr-2 h-4 w-4" />
                Einstellungen
            </Link>
        </DropdownMenuItem>

        <!--- Admin-spezifische Links --->
        <template v-if="isAdmin">
            <DropdownMenuSeparator />
            <!---{/* Optische Trennung für die Admin-Sektion */}-->

            <!---{/* NEU: Link zum Dashboard für Admins */}-->
            <DropdownMenuItem :as-child="true">
                <Link class="block w-full" :href="route('dashboard')" as="button">
                    <DashboardIcon class="mr-2 h-4 w-4" />
                    Dashboard
                </Link>
            </DropdownMenuItem>

            <!---{/* NEU: Link zur Testseite für Admins */}-->
            <DropdownMenuItem :as-child="true">
                <Link class="block w-full" :href="route('test')" as="button">
                    <TestIcon class="mr-2 h-4 w-4" />
                    <!---{/* Oder UserCog, wenn passender */}-->
                    Testseite (Admin)
                </Link>
            </DropdownMenuItem>

            <!---{/* Bestehende Admin-Links */}-->
            <DropdownMenuItem :as-child="true">
                <Link class="block w-full" :href="route('settings.users.index')" as="button">
                    <UsersIcon class="mr-2 h-4 w-4" />
                    Benutzerverwaltung
                </Link>
            </DropdownMenuItem>
            <DropdownMenuItem :as-child="true">
                <Link class="block w-full" :href="route('admin.register.form')" as="button">
                    <UserPlusIcon class="mr-2 h-4 w-4" />
                    Neuen Benutzer anlegen
                </Link>
            </DropdownMenuItem>
        </template>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuItem :as-child="true">
        <Link class="block w-full" method="post" :href="route('logout')" as="button">
            <LogOut class="mr-2 h-4 w-4" />
            Abmelden
        </Link>
    </DropdownMenuItem>
</template>
