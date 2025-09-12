<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import type { PageProps } from '@inertiajs/core';
import type { User } from '@/types';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

// Importiere deine Layouts
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { BreadcrumbItem } from '@/types';

// HIER IST DIE KORREKTUR:
// Wir teilen Inertia mit, welche Layouts es verwenden soll.
// Da SettingsLayout in AppLayout verschachtelt ist, geben wir ein Array an.
defineOptions({
  layout: [AppLayout, SettingsLayout]
});

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

interface Props {
  mustVerifyEmail: boolean;
  status?: string;
}
defineProps<Props>();

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
  { title: t('settings.profile.breadcrumb'), href: route('settings.profile.edit') },
]);

const page = usePage<PageProps>();
const user = page.props.auth.user as User;

const form = useForm({
  name: user.name,
  email: user.email,
});

const submit = () => {
  form.patch(route('profile.update'), { preserveScroll: true });
};
</script>

<template>
    <Head :title="t('settings.profile.head_title')" />

    <div class="flex flex-col space-y-6">
      <HeadingSmall :title="t('settings.profile.title')" :description="t('settings.profile.description')" />

      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid gap-2">
          <Label for="name">{{ $t('settings.profile.label_name') }}</Label>
          <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name" :placeholder="t('settings.profile.placeholder_name')" />
          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="grid gap-2">
          <Label for="email">{{ $t('settings.profile.label_email') }}</Label>
          <Input
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autocomplete="username"
            :placeholder="t('settings.profile.placeholder_email')"
          />
          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div v-if="mustVerifyEmail && !user.email_verified_at">
          <p class="-mt-4 text-sm text-muted-foreground">
            {{ $t('settings.profile.unverified_email_text') }}
            <Link
              :href="route('verification.send')"
              method="post"
              as="button"
              class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:!decoration-current dark:decoration-neutral-500"
            >
              {{ $t('settings.profile.resend_verification_link') }}
            </Link>
          </p>

          <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
            {{ $t('settings.profile.verification_link_sent') }}
          </div>
        </div>

        <div class="flex items-center gap-4">
          <Button :disabled="form.processing">{{ $t('settings.profile.button_save') }}</Button>

          <Transition
            enter-active-class="transition ease-in-out"
            enter-from-class="opacity-0"
            leave-active-class="transition ease-in-out"
            leave-to-class="opacity-0"
          >
            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">{{ $t('settings.profile.save_success_message') }}</p>
          </Transition>
        </div>
      </form>
    </div>

    <DeleteUser />

</template>