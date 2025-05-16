<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import type { User } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { LogOut, Settings, Users as UsersIcon, UserPlus as UserPlusIcon  } from 'lucide-vue-next';
import { computed } from 'vue';

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

        <template v-if="isAdmin">
            <DropdownMenuSeparator />
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
