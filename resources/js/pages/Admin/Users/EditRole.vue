<script setup lang="ts">
// .../pages/Admin/Users/EditRole.vue

import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

// Layouts
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import type { BreadcrumbItem } from '@/types';

const { t } = useI18n();

const props = defineProps({
    user: {
        type: Object as () => {
            id: number;
            first_name: string;
            last_name: string;
            roles: { name: string }[];
        },
        required: true,
    },
    roles: {
        type: Array as () => { id: number; name: string }[],
        required: true,
    },
});

// KORREKTUR: Wir weisen das verschachtelte Einstellungs-Layout zu.
defineOptions({
  layout: [AppLayout, SettingsLayout],
});

const form = useForm({
    role: props.user.roles && props.user.roles.length > 0 ? props.user.roles[0].name : null,
});

const updateRole = () => {
    form.put(route('admin.users.updateRole', props.user.id));
};

// KORREKTUR: Die Breadcrumbs müssen auf die Profil-Seite als Startpunkt verweisen.
const breadcrumbs = computed<BreadcrumbItem[]>(() => {
    const userName = `${props.user.first_name} ${props.user.last_name}`;
    return [
        { title: t('edit_role.breadcrumb_settings'), href: route('settings.profile.edit') },
        { title: t('edit_role.breadcrumb_user_management'), href: route('admin.users.index') },
        { title: t('edit_role.breadcrumb_edit_user', { userName: userName }) },
    ];
});

const userFullName = computed(() => `${props.user.first_name} ${props.user.last_name}`);
</script>

<template>
    <Head :title="t('edit_role.head_title', { userName: userFullName })" />
    
    <div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
        <h1 class="mb-6 text-2xl font-semibold">
            {{ $t('edit_role.main_headline') }} <span class="font-bold">{{ userFullName }}</span>
        </h1>
        <form @submit.prevent="updateRole" class="space-y-6 rounded-lg bg-white p-6 shadow-md dark:bg-slate-800">
            <div>
                <label for="role-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('edit_role.form.label') }}</label>
                            <Select v-model="form.role">
                <SelectTrigger id="role-select" class="mt-1">
                        <SelectValue :placeholder="t('edit_role.form.no_role_option')" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem v-for="roleOption in roles" :key="roleOption.id" :value="roleOption.name">
                            {{ roleOption.name }}
                        </SelectItem>
                    </SelectContent>
                </Select>
                <div v-if="form.errors.role" class="mt-1 text-sm text-red-500">
                    {{ form.errors.role }}
                </div>
            </div>

            <div class="flex items-center justify-start space-x-4 pt-2">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                >
                    {{ $t('edit_role.button_save') }}
                </button>

                <Link
                    :href="route('admin.users.index')"
                    class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500"
                >
                    {{ $t('edit_role.button_cancel') }}
                </Link>
            </div>
        </form>
    </div>
</template>
