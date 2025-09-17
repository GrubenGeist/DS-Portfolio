<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import type { BreadcrumbItem } from '@/types';

// LAYOUTS
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

// KOMPONENTEN
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import InputError from '@/components/InputError.vue';
import { LoaderCircle } from 'lucide-vue-next';

const { t } = useI18n();

// Wir binden die Seite an das Einstellungs-Layout.
defineOptions({
  layout: [AppLayout, SettingsLayout],
});

type Role = 'Company' | 'Admin' | 'Customer';

const form = useForm<{
  first_name: string;
  last_name: string;
  company?: string;
  email: string;
  password: string;
  password_confirmation: string;
  role: Role;
}>({
  first_name: '',
  last_name: '',
  company: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: 'Company',
});

const submit = () => {
  form.post(route('admin.register.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    { title: "Einstellungen", href: route('settings.profile.edit') },
    { title: "Benutzerverwaltung", href: route('admin.users.index') },
    { title: "Neuen Benutzer anlegen" },
]);
</script>

<template>
  <Head :title="t('auth.register.head_title')" />

  <Card class="mx-auto max-w-2xl">
    <CardHeader>
      <CardTitle>{{ t('auth.register.title') }}</CardTitle>
      <CardDescription>{{ t('auth.register.description') }}</CardDescription>
    </CardHeader>
    <CardContent>
      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid gap-2">
          <Label for="first_name">{{ $t('auth.register.label_firstname') }}</Label>
          <Input id="first_name" type="text" required autofocus v-model="form.first_name" :placeholder="t('auth.register.placeholder_firstname')" />
          <InputError :message="form.errors.first_name" />
        </div>

        <div class="grid gap-2">
          <Label for="last_name">{{ $t('auth.register.label_lastname') }}</Label>
          <Input id="last_name" type="text" required v-model="form.last_name" :placeholder="t('auth.register.placeholder_lastname')" />
          <InputError :message="form.errors.last_name" />
        </div>

        <div class="grid gap-2">
          <Label for="company">{{ $t('auth.register.label_company') }}</Label>
          <Input id="company" type="text" v-model="form.company" :placeholder="t('auth.register.placeholder_company')" />
          <InputError :message="form.errors.company" />
        </div>

        <div class="grid gap-2">
          <Label for="email">{{ $t('auth.register.label_email') }}</Label>
          <Input id="email" type="email" required v-model="form.email" :placeholder="t('auth.register.placeholder_email')" />
          <InputError :message="form.errors.email" />
        </div>

        <div class="grid gap-2">
          <Label for="password">{{ $t('auth.register.label_password') }}</Label>
          <Input id="password" type="password" required v-model="form.password" :placeholder="t('auth.register.placeholder_password')" />
          <InputError :message="form.errors.password" />
        </div>

        <div class="grid gap-2">
          <Label for="password_confirmation">{{ $t('auth.register.label_password_confirmation') }}</Label>
          <Input id="password_confirmation" type="password" required v-model="form.password_confirmation" :placeholder="t('auth.register.placeholder_password')" />
          <InputError :message="form.errors.password_confirmation" />
        </div>

        <div class="grid gap-2">
          <Label for="role">{{ $t('auth.register.label_role') }}</Label>
          <Select v-model="form.role">
            <SelectTrigger id="role">
              <SelectValue :placeholder="t('auth.register.placeholder_role')" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="Company">Company</SelectItem>
              <SelectItem value="Admin">Admin</SelectItem>
              <SelectItem value="Customer">Customer</SelectItem>
            </SelectContent>
          </Select>
          <InputError :message="form.errors.role" />
        </div>

        <div class="flex items-center gap-4">
            <Button type="submit" :disabled="form.processing" class="border border-stone-900/20 dark:bg-yellow-400 dark:hover:bg-yellow-300 dark:text-black bg-blue-800 hover:bg-blue-600 text-white hover:text-white items-center justify-center">
                <LoaderCircle v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                {{ $t('auth.register.button_create') }}
            </Button>
            <Button variant="ghost" as-child class="border border-stone-900/20 dark:bg-gray-600 dark:hover:bg-gray-500  dark:text-white text-black bg-gray-100">
                <Link :href="route('admin.users.index')"> {{t('settings.register.button_cancel')}} </Link>
            </Button>
        </div>
      </form>
    </CardContent>
  </Card>
</template>