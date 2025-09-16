<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { defineProps, reactive, watch, computed } from 'vue';
import throttle from 'lodash/throttle';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useI18n } from 'vue-i18n';

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

const props = defineProps({
    users: {
        type: Array as () => any[],
        required: true,
    },
    filters: {
        type: Object as () => { search: string, role: string },
        required: true,
    },
});

defineOptions({ layout: AppLayout });

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    { title: t('users.breadcrumb_settings'), href: route('settings.index') },
    { title: t('users.breadcrumb_user_management') },
]);

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
    <section id="UserManagement-Section" class="py-10">
    <div id="UserManagement-Container" class="pl-0 pr-0 pt-0 pb-0"> 
        <div>
            <h1 class="mb-4 text-2xl font-semibold">{{ $t('users.main_headline') }}</h1>

            <div class="mb-4 flex items-center space-x-4 bg-white p-4 shadow-md dark:bg-gray-800 ">
                <div class="flex-1">
                    <Input
                        v-model="filterForm.search"
                        type="text"
                        :placeholder="t('users.filters.search_placeholder')"
                        class="w-full"
                    />
                </div>
                <div>
                    <Select v-model="filterForm.role">
                        <SelectTrigger class="w-[180px]">
                            <SelectValue :placeholder="t('users.filters.role_placeholder')" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">{{ $t('users.filters.role_all') }}</SelectItem>
                            <SelectItem value="Admin">{{ $t('users.filters.role_admin') }}</SelectItem>
                            <SelectItem value="Company">{{ $t('users.filters.role_company') }}</SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto bg-transparent pl-0 pr-0 pt-0 pb-0 shadow-md">
            <table class="min-w-full p-10 border">
                <thead class="bg-gray-100 text-sm dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">{{ $t('users.table.header_firstname') }}</th>
                        <th class="px-6 py-3 text-left text-sm  font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">{{ $t('users.table.header_lastname') }}</th>
                        <th class="px-6 py-3 text-left text-sm  font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">{{ $t('users.table.header_email') }}</th>
                        <th class="px-6 py-3 text-left text-sm  font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">{{ $t('users.table.header_role') }}</th>
                        <th class="px-6 py-3 text-left text-sm  font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">{{ $t('users.table.header_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800 ">
                    <tr v-if="users.length === 0">
                        <td colspan="5" class="whitespace-nowrap px-6 py-4 text-left text-sm text-gray-500">{{ $t('users.table.no_users_found') }}</td>
                    </tr>
                    <tr v-for="user in users" :key="user.id">
                        <td class="whitespace-nowrap px-6 py-4 text-left text-sm text-gray-900 dark:text-gray-100">
                            {{ user.first_name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-left text-sm text-gray-900 dark:text-gray-100">
                            {{ user.last_name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium text-left text-sm text-gray-500 dark:text-gray-300">{{ user.email }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-left text-sm text-gray-500 dark:text-gray-300">
                            <span v-if="user.roles && user.roles.length > 0">{{ user.roles[0].name }}</span>
                            <span v-else>{{ $t('users.table.no_role') }}</span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-left text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <Link :href="route('admin.users.editRole', user.id)" class="rounded-md bg-blue-600 px-3 py-1.5 text-sm  font-medium text-white hover:bg-blue-700">{{ $t('users.table.button_edit_role') }}</Link>
                                <button @click="destroy(user.id)" class="rounded-md bg-red-600 px-3 py-1.5 text-sm  font-medium text-white hover:bg-red-700">{{ $t('users.table.button_delete') }}</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </section>
</template>
