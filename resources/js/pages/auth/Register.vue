<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
// Select-Komponenten
import Select from '@/components/ui/select/Select.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

type Role = 'Company' | 'Admin';

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
</script>

<template>
  <AuthBase :title="t('auth.register.title')" :description="t('auth.register.description')">
    <Head :title="t('auth.register.head_title')" />

    <form @submit.prevent="submit" class="flex flex-col gap-6">
      <div class="grid gap-6">
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
            </SelectContent>
          </Select>
          <InputError :message="form.errors.role" />
        </div>

        <Button type="submit" class="mt-2 w-full" :disabled="form.processing">
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
          {{ $t('auth.register.button_create') }}
        </Button>
      </div>
    </form>
  </AuthBase>
</template>
