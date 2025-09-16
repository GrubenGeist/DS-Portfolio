<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
  DialogClose,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import HeadingSmall from './HeadingSmall.vue';

const { t } = useI18n();
const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
  password: '',
});

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true;
  setTimeout(() => passwordInput.value?.focus(), 250);
};

const deleteUser = () => {
  form.delete(route('settings.profile.destroy'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value?.focus(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingUserDeletion.value = false;
  form.reset();
};
</script>

<template>
  <section class="flex flex-col space-y-6">
    <HeadingSmall 
      :title="t('settings.delete_account.title')" 
      :description="t('settings.delete_account.description')" 
    />

    <div class="flex"> <Dialog>
        <DialogTrigger as-child>
          <Button variant="destructive">{{ t('settings.delete_account.button_delete') }}</Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-md">
          <DialogHeader>
            <DialogTitle>{{ t('settings.delete_account.modal_title') }}</DialogTitle>
            <DialogDescription>
              {{ t('settings.delete_account.modal_description') }}
            </DialogDescription>
          </DialogHeader>
          <div class="grid gap-4 py-4">
              <div class="grid gap-2">
                  <Label for="password" class="sr-only">{{ t('settings.delete_account.password_label') }}</Label>
                  <Input
                      id="password"
                      ref="passwordInput"
                      v-model="form.password"
                      type="password"
                      class="mt-1 block w-full"
                      :placeholder="t('settings.delete_account.password_placeholder')"
                      @keyup.enter="deleteUser"
                  />
                  <InputError :message="form.errors.password" class="mt-2" />
              </div>
          </div>
          <DialogFooter class="sm:justify-end gap-2">
            <DialogClose as-child>
              <Button type="button" variant="secondary">
                {{ t('settings.delete_account.button_cancel') }}
              </Button>
            </DialogClose>
            <Button
              type="button"
              variant="destructive"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
              @click="deleteUser"
            >
              {{ t('settings.delete_account.button_confirm_delete') }}
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>
    </div>
  </section>
</template>