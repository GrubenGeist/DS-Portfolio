<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { reactive, watch, computed } from 'vue';
import throttle from 'lodash/throttle';
import { useI18n } from 'vue-i18n';
import type { User, Paginated } from '@/types';

// Layouts
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

// Komponenten
import Heading from '@/components/Heading.vue';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import UserInfo from '@/components/UserInfo.vue';
import Pagination from '@/components/Pagination.vue';

const { t } = useI18n();

const props = defineProps<{
  users: Paginated<User>;
  filters: {
    search: string;
    role: string;
  };
}>();

defineOptions({
  layout: [AppLayout, SettingsLayout],
});

const authUser = computed(() => usePage().props.auth.user as User);

const filterForm = reactive({
  search: props.filters.search || '',
  role: props.filters.role || 'all',
});

watch(filterForm, throttle(() => {
  router.get(route('admin.users.index'), filterForm, {
    preserveState: true,
    replace: true,
  });
}, 300));

const destroy = (userId: number) => {
  if (confirm(t('users.confirm_delete'))) {
    router.delete(route('admin.users.destroy', userId), {
      preserveScroll: true,
    });
  }
};
</script>

<template>
  <Head :title="t('users.head_title')" />
  <div class="dark:text-white dark:bg-white/10 space-y-6 md:p-6 p-2 rounded-xl">
    <!-- Kopfbereich -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
      <Heading :title="t('users.main_headline')" :description="t('users.description')" />
      <Button as-child class="w-full sm:w-auto flex-shrink-0 border border-stone-900/20 dark:bg-yellow-400 dark:hover:bg-yellow-300 dark:text-black bg-blue-800 hover:bg-blue-600 text-white hover:text-white items-center justify-center">
        <Link :href="route('admin.register.form')">{{ $t('users.add_new_button') }}</Link>
      </Button>
    </div>

    <!-- Filter -->
    <div class="dark:text-white dark:bg-white/5 flex flex-col sm:flex-row items-center gap-4 rounded-md border bg-background p-4 shadow-sm">
      <div class="flex-1 w-full">
        <Input
          id="search-filter"
          v-model="filterForm.search"
          type="text"
          :placeholder="t('users.filters.search_placeholder')"
          class="w-full dark:text-white dark:bg-white/5"
        />
      </div>
      <div class="w-full sm:w-auto">
        <Select v-model="filterForm.role">
          <SelectTrigger id="role-filter" class="dark:text-white dark:bg-white/5 w-full sm:w-[180px]">
            <SelectValue :placeholder="t('users.filters.role_placeholder')" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="all">{{ $t('users.filters.role_all') }}</SelectItem>
            <SelectItem value="Admin">{{ $t('users.filters.role_admin') }}</SelectItem>
            <SelectItem value="Company">{{ $t('users.filters.role_company') }}</SelectItem>
            <SelectItem value="Customer">{{ $t('users.filters.role_customer') }}</SelectItem>
          </SelectContent>
        </Select>
      </div>
    </div>

    <!-- Desktop Tabelle -->
    <div class="hidden md:block overflow-x-auto rounded-md border">
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead>{{ $t('users.table.header_user') }}</TableHead>
            <TableHead>{{ $t('users.table.header_role') }}</TableHead>
            <TableHead class="text-right">{{ $t('users.table.header_actions') }}</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-if="users.data.length === 0">
            <TableCell colspan="3" class="p-4 text-center text-sm text-muted-foreground">
              {{ $t('users.table.no_users_found') }}
            </TableCell>
          </TableRow>
          <TableRow v-for="user in users.data" :key="user.id">
            <TableCell>
              <UserInfo :user="user" :show-email="true" />
            </TableCell>
            <TableCell>
              <span v-for="role in user.roles" :key="role" class="mr-2 rounded-md bg-muted px-2 py-1 text-xs font-medium">
                {{ role }}
              </span>
            </TableCell>
            <TableCell class="text-right">
              <div v-if="user.id !== authUser.id" class=" flex items-center justify-end space-x-2">
                <Button variant="outline" size="sm" as-child class="border border-stone-900/20 dark:bg-yellow-400 dark:hover:bg-yellow-300 dark:text-black bg-blue-800 hover:bg-blue-600 text-white hover:text-white items-center justify-center">
                  <Link :href="route('admin.users.editRole', user.id)">
                    {{ t('users.table.button_edit_role') }}
                  </Link>
                </Button>
                <Button variant="destructive" size="sm" @click="destroy(user.id)">
                  {{ t('users.table.button_delete') }}
                </Button>
              </div>
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>

    <!-- Mobile Cards -->
<div class="md:hidden border dark:border-0 p-2 rounded-md">
  <div class="max-h-[600px] overflow-y-auto space-y-4 pr-1">
    <div
      v-for="user in users.data"
      :key="user.id"
      class="bg-blue-500/20 dark:bg-white/10 rounded-lg border p-4 shadow-sm "
    >
      <UserInfo :user="user" :show-email="true" />

      <div class="mt-2 flex flex-wrap gap-2">
        <span
          v-for="role in user.roles"
          :key="role"
          class="rounded-md bg-muted px-2 py-1 text-xs font-medium"
        >
          {{ role }}
        </span>
      </div>

      <div v-if="user.id !== authUser.id" class="mt-4 flex flex-col sm:flex-row gap-2">
        <Button size="sm" class="border border-stone-900/20 dark:bg-yellow-400 dark:hover:bg-yellow-300 dark:text-black bg-blue-800 hover:bg-blue-600 text-white hover:text-white items-center justify-center w-full ">
          <Link :href="route('admin.users.editRole', user.id)">
            {{ t('users.table.button_edit_role') }}
          </Link>
        </Button>
        <Button size="sm" variant="destructive" class="w-full" @click="destroy(user.id)">
          {{ t('users.table.button_delete') }}
        </Button>
      </div>
    </div>
  </div>
</div>

    <!-- Pagination -->
    <div v-if="users.meta && users.meta.links && users.meta.links.length > 3" class="flex justify-center pt-4">
      <Pagination :links="users.meta.links" />
    </div>
  </div>
</template>
