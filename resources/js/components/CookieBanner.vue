<script setup lang="ts">
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Cookie } from 'lucide-vue-next';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import { Switch } from '@/components/ui/switch';
import { Label } from '@/components/ui/label';
import { useConsent } from '@/composables/useConsent';

const { consentState, saveConsent } = useConsent();

const showSettingsModal = ref(false);

const localSwitches = ref({
  analytics: consentState.analytics,
  marketing: consentState.marketing,
});

const acceptAll = () => {
  saveConsent({
    analytics: true,
    marketing: true,
  });
};

const saveSelection = () => {
  saveConsent({
    analytics: localSwitches.value.analytics,
    marketing: localSwitches.value.marketing,
  });
  showSettingsModal.value = false;
};
</script>

<template>
  <!-- Der Banner wird nur angezeigt, wenn 'bannerVisible' aus dem globalen Zustand true ist -->
  <Transition
    enter-active-class="transition ease-out duration-300"
    enter-from-class="transform translate-y-full opacity-0"
    enter-to-class="transform translate-y-0 opacity-100"
    leave-active-class="transition ease-in duration-200"
    leave-from-class="transform translate-y-0 opacity-100"
    leave-to-class="transform translate-y-full opacity-0"
  >
    <div v-if="consentState.bannerVisible" class="fixed bottom-0 inset-x-0 z-50 p-2">
      <div class="dark:text-black max-w-7xl mx-auto p-6 text-white bg-gray-900/90 dark:bg-gray-100/90 backdrop-blur-sm rounded-lg shadow-2xl border border-border">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
          <div class="flex items-start gap-4 ">
            <Cookie class="h-8 w-8 text-primary flex-shrink-0 mt-1 dark:text-black text-white" />
            <div>
              <h3 class="font-semibold">{{ $t('cookie_banner.title') }}</h3>
              <p class="dark:text-black text-sm text-foreground/80 mt-1 text-white">
                {{ $t('cookie_banner.description') }}
              </p>
            </div>
          </div>
          <div class="flex gap-2 flex-shrink-0">
            <Button class="border border-stone-900/20 dark:bg-gray-600 dark:hover:bg-gray-500  dark:text-white text-black bg-gray-100" variant="outline" @click="showSettingsModal = true">{{ $t('cookie_banner.button_customize') }}</Button>
            <Button class="border border-stone-900/20 dark:bg-yellow-400 dark:hover:bg-yellow-300 dark:text-black bg-blue-800 hover:bg-blue-600 text-white hover:text-white" @click="acceptAll">{{ $t('cookie_banner.button_accept_all') }}</Button>
          </div>
        </div>
      </div>
    </div>
  </Transition>

  <!-- Das Einstellungs-Modal -->
  <Dialog :open="showSettingsModal" @update:open="showSettingsModal = $event">
    <DialogContent class="dark:bg-gray-100/90 dark:text-black text-white bg-gray-900 ">
      <DialogHeader>
        <DialogTitle>{{ $t('cookie_banner.modal.title') }}</DialogTitle>
        <DialogDescription class="dark:text-black text-white/70 text-xs pr-12">
          {{ $t('cookie_banner.modal.description') }}
        </DialogDescription>
      </DialogHeader>
      <div class="space-y-4 py-4 ">
        <div class="flex items-center justify-between">
          <Label for="necessary-cookies" class="font-semibold">{{ $t('cookie_banner.modal.label_necessary') }}</Label>
          <Switch class="border border-stone-900/20  dark:data-[state=checked]:bg-yellow-400 dark:data-[state=unchecked]:bg-yellow-900 data-[state=checked]:bg-blue-500 data-[state=unchecked]:bg-gray-400" id="necessary-cookies" :checked="true" disabled />
        </div>
        <div class="flex items-center justify-between">
          <Label for="analytics-cookies" class="cursor-pointer">{{ $t('cookie_banner.modal.label_analytics') }}</Label>
          <Switch class="border border-stone-900/20 dark:data-[state=checked]:bg-yellow-400 dark:data-[state=unchecked]:bg-yellow-900 data-[state=checked]:bg-blue-500 data-[state=unchecked]:bg-gray-400" id="analytics-cookies" v-model:checked="localSwitches.analytics" />
        </div>
        <div class="flex items-center justify-between ">
          <Label for="marketing-cookies" class="cursor-pointer ">{{ $t('cookie_banner.modal.label_marketing') }}</Label>
          <Switch class="border border-stone-900/20 dark:data-[state=checked]:bg-yellow-400 dark:data-[state=unchecked]:bg-yellow-900 data-[state=checked]:bg-blue-500 data-[state=unchecked]:bg-gray-400" id="marketing-cookies" v-model:checked="localSwitches.marketing" />
        </div>
      </div>
      <DialogFooter>
        <Button class="border border-stone-900/20 dark:bg-yellow-400 dark:hover:bg-yellow-300 dark:text-black bg-blue-800 hover:bg-blue-600 text-white hover:text-white" @click="saveSelection">{{ $t('cookie_banner.modal.button_save') }}</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
