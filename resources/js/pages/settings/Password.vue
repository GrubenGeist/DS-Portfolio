<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { BreadcrumbItem } from '@/types';

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

const breadcrumbItems = computed<BreadcrumbItem[]>(() => [
  { title: t('settings.password.breadcrumb'), href: route('settings.password.edit') },
]);

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

const form = useForm<{
  current_password: string;
  password: string;
  password_confirmation: string;
}>({
  current_password: '',
  password: '',
  password_confirmation: '',
});

const updatePassword = () => {
  form.put(route('settings.password.update'), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: (errors: Record<string, string>) => {
      if (errors.password) {
        form.reset('password', 'password_confirmation');
        passwordInput.value?.focus();
      }
      if (errors.current_password) {
        form.reset('current_password');
        currentPasswordInput.value?.focus();
      }
    },
  });
};
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <Head :title="t('settings.password.head_title')" />

    <SettingsLayout>
      <div class="space-y-6">
        <HeadingSmall
          :title="t('settings.password.title')"
          :description="t('settings.password.description')"
        />

        <form @submit.prevent="updatePassword" class="space-y-6">
          <div class="grid gap-2">
            <Label for="current_password">{{ $t('settings.password.label_current') }}</Label>
            <Input
              id="current_password"
              ref="currentPasswordInput"
              v-model="form.current_password"
              type="password"
              class="mt-1 block w-full"
              autocomplete="current-password"
              :placeholder="t('settings.password.placeholder_current')"
            />
            <InputError :message="form.errors.current_password" />
          </div>

          <div class="grid gap-2">
            <Label for="password">{{ $t('settings.password.label_new') }}</Label>
            <Input
              id="password"
              ref="passwordInput"
              v-model="form.password"
              type="password"
              class="mt-1 block w-full"
              autocomplete="new-password"
              :placeholder="t('settings.password.placeholder_new')"
            />
            <InputError :message="form.errors.password" />
          </div>

          <div class="grid gap-2">
            <Label for="password_confirmation">{{ $t('settings.password.label_confirm') }}</Label>
            <Input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              class="mt-1 block w-full"
              autocomplete="new-password"
              :placeholder="t('settings.password.placeholder_confirm')"
            />
            <InputError :message="form.errors.password_confirmation" />
          </div>

          <div class="flex items-center gap-4">
            <Button type="submit" :disabled="form.processing">{{ $t('settings.password.button_save') }}</Button>

            <Transition
              enter-active-class="transition ease-in-out"
              enter-from-class="opacity-0"
              leave-active-class="transition ease-in-out"
              leave-to-class="opacity-0"
            >
              <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">{{ $t('settings.password.save_success_message') }}</p>
            </Transition>
          </div>
        </form>
      </div>
    </SettingsLayout>
  </AppLayout>
</template>
