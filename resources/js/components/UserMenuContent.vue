<!-- resources/js/components/UserMenuContent.vue -->
<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import type { User } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import {
  LayoutGrid as DashboardIcon,
  LogOut,
  Settings,
  UserPlus as UserPlusIcon,
  Users as UsersIcon,
} from 'lucide-vue-next';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

interface Props { user: User }
const props = defineProps<Props>();

const page = usePage();
const currentUserRoles = computed(() => (page.props as any)?.auth?.user?.roles ?? []);
const isAdmin = computed(() => Array.isArray(currentUserRoles.value) && currentUserRoles.value.includes('Admin'));
</script>

<template>
  <DropdownMenuLabel class="p-0 font-normal" :aria-label="t('user_menu.aria.user_info')">
    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
      <UserInfo :user="props.user" :show-email="true" />
    </div>
  </DropdownMenuLabel>
  <DropdownMenuSeparator />

  <DropdownMenuGroup :aria-label="t('user_menu.aria.general_actions')">
    <DropdownMenuItem :as-child="true">
    <Link :href="route('settings.profile.edit')">
      <Settings class="mr-2 size-4" />
        <span>{{ $t('user_menu.settings') }}</span>
    </Link>
    </DropdownMenuItem>

    <template v-if="isAdmin">
      <DropdownMenuSeparator />
      <DropdownMenuGroup :aria-label="t('user_menu.aria.admin_actions')">
        <DropdownMenuItem :as-child="true">
          <Link class="block w-full" :href="route('dashboard')" as="button">
            <DashboardIcon class="mr-2 h-4 w-4" />
            {{ $t('user_menu.dashboard') }}
          </Link>
        </DropdownMenuItem>
        <DropdownMenuItem :as-child="true">
          <Link class="block w-full" :href="route('admin.users.index')" as="button">
            <UsersIcon class="mr-2 h-4 w-4" />
            {{ $t('user_menu.user_management') }}
          </Link>
        </DropdownMenuItem>
        <DropdownMenuItem :as-child="true">
          <Link class="block w-full" :href="route('admin.register.form')" as="button">
            <UserPlusIcon class="mr-2 h-4 w-4" />
            {{ $t('user_menu.create_user') }}
          </Link>
        </DropdownMenuItem>
      </DropdownMenuGroup>
    </template>
  </DropdownMenuGroup>

  <DropdownMenuSeparator />

  <DropdownMenuItem as-child>
    <Link method="post" :href="route('logout')" as="button" class="w-full">
      <LogOut class="mr-2 h-4 w-4" />
      {{ $t('user_menu.logout') }}
    </Link>
  </DropdownMenuItem>
</template>
