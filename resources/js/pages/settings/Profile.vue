<script setup lang="ts">
// .../pages/settings/Profile.vue

import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';
import type { User } from '@/types';

// Layouts
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

// Komponenten
import DeleteUser from '@/components/DeleteUser.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';

defineOptions({
  layout: [AppLayout, SettingsLayout],
});

const { t } = useI18n();

defineProps<{
  mustVerifyEmail: boolean;
  status?: string;
}>();

const user = computed(() => usePage().props.auth.user as User);
const isCompanyUser = computed(() => Array.isArray(user.value.roles) && user.value.roles.includes('Company'));

// --- STATE MANAGEMENT ---
// NEU: Getrennte Zustände für jeden Bearbeitungsmodus
const isEditingProfile = ref(false);
const isEditingPassword = ref(false);

// --- FORMULARE ---
// Formular für Profilinformationen
const profileForm = useForm({
  first_name: user.value.first_name,
  last_name: user.value.last_name,
  email: user.value.email,
  company: user.value.company || '',
});

// Formular für Passwort-Update
const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
});

// --- FUNKTIONEN ---
const updateProfileInformation = () => {
  // KORREKTUR: 'userprofile.settings.profile.update' zu 'settings.profile.update'
  profileForm.patch(route('settings.profile.update'), {
    preserveScroll: true,
    onSuccess: () => {
      isEditingProfile.value = false;
      router.reload({ only: ['auth'] });
    },
  });
};

const cancelProfileEdit = () => {
    profileForm.reset();
    isEditingProfile.value = false;
};

const updatePassword = () => {
  passwordForm.put(route('userprofile.settings.password.update'), {
    preserveScroll: true,
    onSuccess: () => {
      passwordForm.reset();
      isEditingPassword.value = false;
    },
    onError: () => {
      if (passwordForm.errors.password) {
        passwordForm.reset('password', 'password_confirmation');
      }
      if (passwordForm.errors.current_password) {
        passwordForm.reset('current_password');
      }
    },
  });
};

const cancelPasswordEdit = () => {
    passwordForm.reset();
    isEditingPassword.value = false;
};
</script>

<template>
  <Head :title="t('userprofile.settings.head_title')" />

  <div class="dark:bg-white/10 bg-blue-200/20 p-4 sm:p-6 rounded-xl mx-auto max-w-2xl space-y-12">
    <Card class="dark:bg-stone-900">
      <CardHeader class="flex-col sm:flex-row sm:items-center justify-between">
        <div>
          <CardTitle>{{ t('userprofile.settings.title') }}</CardTitle>
          <CardDescription>{{ t('userprofile.settings.description') }}</CardDescription>
        </div>
        <Button 
          class="dark:bg-yellow-400 dark:hover:bg-yellow-300 dark:text-black bg-blue-900 hover:bg-blue-600 text-white hover:text-white mt-4 sm:mt-0" 
          v-if="!isEditingProfile" 
          variant="outline" 
          size="sm" 
          @click="isEditingProfile = true"
          :aria-label="t('userprofile.settings.aria_edit_profile')"
        >
        {{ t('userprofile.settings.button_change') }}
        </Button>
      </CardHeader>
      <CardContent>
        <div v-if="!isEditingProfile" class="space-y-4 text-sm">
          <div class="grid grid-cols-1 gap-1 sm:grid-cols-3">
            <dt class="font-medium text-muted-foreground">{{ t('userprofile.settings.label_firstname') }}</dt>
            <dd class="sm:col-span-2">{{ user.first_name }}</dd>
          </div>
          <div class="grid grid-cols-1 gap-1 sm:grid-cols-3">
            <dt class="font-medium text-muted-foreground">{{ t('userprofile.settings.label_lastname') }}</dt>
            <dd class="sm:col-span-2">{{ user.last_name }}</dd>
          </div>
          <div v-if="isCompanyUser" class="grid grid-cols-1 gap-1 sm:grid-cols-3">
            <dt class="font-medium text-muted-foreground">{{ t('userprofile.settings.label_company') }}</dt>
            <dd class="sm:col-span-2">{{ user.company || '-' }}</dd>
          </div>
          <div class="grid grid-cols-1 gap-1 sm:grid-cols-3">
            <dt class="font-medium text-muted-foreground">{{ t('userprofile.settings.label_email') }}</dt>
            <dd class="sm:col-span-2">{{ user.email }}</dd>
          </div>
        </div>
        <form v-else @submit.prevent="updateProfileInformation" class="space-y-6">
          <div class="grid gap-2">
            <Label for="first_name">{{ $t('categories.create.label_firstname') }}</Label>
            <Input id="first_name" v-model="profileForm.first_name" type="text" required />
            <InputError class="mt-2" :message="profileForm.errors.first_name" />
          </div>
          <div class="grid gap-2">
            <Label for="last_name">{{ $t('categories.create.label_lastname') }}</Label>
            <Input id="last_name" v-model="profileForm.last_name" type="text" required />
            <InputError class="mt-2" :message="profileForm.errors.last_name" />
          </div>
          <div v-if="isCompanyUser" class="grid gap-2">
            <Label for="company">{{ $t('categories.create.label_company') }}</Label>
            <Input id="company" v-model="profileForm.company" type="text" />
            <InputError class="mt-2" :message="profileForm.errors.company" />
          </div>
          <div class="grid gap-2">
            <Label for="email">{{ $t('userprofile.settings.label_email') }}</Label>
            <Input id="email" v-model="profileForm.email" type="email" required />
            <InputError class="mt-2" :message="profileForm.errors.email" />
          </div>
          <div class="flex flex-col sm:flex-row items-center gap-4">
            <Button class=" border border-stone-900/20 dark:bg-yellow-400 dark:hover:bg-yellow-300 dark:text-black bg-blue-800 hover:bg-blue-600 text-white hover:text-white w-full sm:w-auto" :disabled="profileForm.processing">{{ t('userprofile.settings.button_save') }}</Button>
            <Button class="border border-stone-900/20 dark:bg-gray-600 dark:hover:bg-gray-500  dark:text-white text-black bg-gray-100 w-full sm:w-auto" type="button" variant="ghost" @click="cancelProfileEdit">{{ t('userprofile.settings.button_cancel') }}</Button>
            <Transition>
              <p v-if="profileForm.recentlySuccessful" class="text-sm text-gray-600">{{ $t('userprofile.settings.save_success_message') }}</p>
            </Transition>
          </div>
        </form>
      </CardContent>
    </Card>

    <Card class="dark:bg-stone-900">
      <CardHeader>
        <CardTitle>{{ t('userprofile.settings.password.title') }}</CardTitle>
        <CardDescription>{{ t('userprofile.settings.password.description') }}</CardDescription>
      </CardHeader>
      <CardContent>
        <form v-if="isEditingPassword" @submit.prevent="updatePassword" class="space-y-6">
          <div class="grid gap-2">
            <Label for="current_password">{{ t('userprofile.settings.password.label_current') }}</Label>
            <Input id="current_password" v-model="passwordForm.current_password" type="password" required />
            <InputError class="mt-2" :message="passwordForm.errors.current_password" />
          </div>
          <div class="grid gap-2">
            <Label for="password">{{ t('userprofile.settings.password.label_new') }}</Label>
            <Input id="password" v-model="passwordForm.password" type="password" required />
            <InputError class="mt-2" :message="passwordForm.errors.password" />
          </div>
          <div class="grid gap-2">
            <Label for="password_confirmation">{{ t('userprofile.settings.password.label_confirm') }}</Label>
            <Input id="password_confirmation" v-model="passwordForm.password_confirmation" type="password" required />
            <InputError class="mt-2" :message="passwordForm.errors.password_confirmation" />
          </div>
           <div class="flex flex-col sm:flex-row items-center gap-4">
            <Button class="border border-stone-900/20 dark:bg-yellow-400 dark:hover:bg-yellow-300 dark:text-black bg-blue-800 hover:bg-blue-600 text-white hover:text-white w-full sm:w-auto" variant="outline" :disabled="passwordForm.processing">{{ t('userprofile.settings.password.button_save') }}</Button>
            <Button type="button" class="border border-stone-900/20 dark:bg-gray-600 dark:hover:bg-gray-500  dark:text-white text-black bg-gray-100 w-full sm:w-auto" variant="outline" @click="cancelPasswordEdit">{{ t('userprofile.settings.password.button_cancel') }}</Button>
            <Transition>
              <p v-if="passwordForm.recentlySuccessful" class="text-sm text-gray-600">{{ $t('userprofile.settings.password.save_success_message') }}</p>
            </Transition>
          </div>
        </form>
        <div v-else class="flex">
          <Button 
            class="border border-stone-900/20 dark:bg-yellow-400 dark:hover:bg-yellow-300 dark:text-black bg-blue-800 hover:bg-blue-600 text-white hover:text-white" 
            variant="outline" 
            @click="isEditingPassword = true"
            :aria-label="t('userprofile.settings.password.aria_change_password')"
          >
           {{ t('userprofile.settings.password.button_change') }}
          </Button>
        </div>
      </CardContent>
    </Card>

    <Card class="dark:bg-stone-900 border-destructive">
      <CardHeader>
        <DeleteUser />
      </CardHeader>
    </Card>
  </div>
</template>