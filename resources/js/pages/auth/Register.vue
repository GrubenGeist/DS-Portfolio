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
  <AuthBase title="Neuen Account erstellen" description="Fülle die Felder aus, um einen neuen Benutzer anzulegen.">
    <Head title="Benutzer erstellen" />

    <form @submit.prevent="submit" class="flex flex-col gap-6">
      <div class="grid gap-6">
        <div class="grid gap-2">
          <Label for="first_name">Vorname</Label>
          <Input id="first_name" type="text" required autofocus v-model="form.first_name" placeholder="Max" />
          <InputError :message="form.errors.first_name" />
        </div>

        <div class="grid gap-2">
          <Label for="last_name">Nachname</Label>
          <Input id="last_name" type="text" required v-model="form.last_name" placeholder="Mustermann" />
          <InputError :message="form.errors.last_name" />
        </div>

        <div class="grid gap-2">
          <Label for="company">Unternehmen (Optional)</Label>
          <Input id="company" type="text" v-model="form.company" placeholder="Firma GmbH" />
          <InputError :message="form.errors.company" />
        </div>

        <div class="grid gap-2">
          <Label for="email">E-Mail</Label>
          <Input id="email" type="email" required v-model="form.email" placeholder="email@example.com" />
          <InputError :message="form.errors.email" />
        </div>

        <div class="grid gap-2">
          <Label for="password">Passwort</Label>
          <Input id="password" type="password" required v-model="form.password" placeholder="••••••••" />
          <InputError :message="form.errors.password" />
        </div>

        <div class="grid gap-2">
          <Label for="password_confirmation">Passwort bestätigen</Label>
          <Input id="password_confirmation" type="password" required v-model="form.password_confirmation" placeholder="••••••••" />
          <InputError :message="form.errors.password_confirmation" />
        </div>

        <div class="grid gap-2">
          <Label for="role">Benutzerrolle</Label>
          <Select v-model="form.role">
            <SelectTrigger id="role">
              <SelectValue placeholder="Rolle auswählen" />
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
          Account anlegen
        </Button>
      </div>
    </form>
  </AuthBase>
</template>
