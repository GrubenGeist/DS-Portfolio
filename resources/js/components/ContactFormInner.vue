<script setup lang="ts">
import axios, { type AxiosError } from 'axios';
import { ref, type Ref } from 'vue';
import { useI18n } from 'vue-i18n';

// Holen Sie sich die Übersetzungsfunktion `t`
const { t } = useI18n();

interface FormData {
  [x: string]: any;
  firstname: string;
  lastname: string;
  email: string;
  message: string;
  consent: boolean;
}

type ValidationErrors = Record<string, string[]>;

interface FeedbackMessage {
  text: string;
  type: 'success' | 'error';
}

const form: Ref<FormData> = ref({
  firstname: '',
  lastname: '',
  email: '',
  message: '',
  consent: false,
});

const errors: Ref<ValidationErrors> = ref({});
const feedbackMessage: Ref<FeedbackMessage> = ref({ text: '', type: 'error' });
const isLoading: Ref<boolean> = ref(false);

const resetForm = (): void => {
  form.value = {
    firstname: '',
    lastname: '',
    email: '',
    message: '',
    consent: false,
  };
  errors.value = {};
};

const submitForm = async (): Promise<void> => {
  isLoading.value = true;
  errors.value = {};
  feedbackMessage.value = { text: '', type: 'error' };

  try {
    const response = await axios.post<{ message: string }>('/api/contact', form.value);
    feedbackMessage.value = { text: response.data.message, type: 'success' };
    resetForm();
  } catch (err) {
    const error = err as AxiosError<{ message?: string; errors?: ValidationErrors }>;
    if (axios.isAxiosError(error) && error.response) {
      if (error.response.status === 422) {
        errors.value = (error.response.data.errors ?? {}) as ValidationErrors;
        feedbackMessage.value = {
          text: error.response.data.message || t('contact_form.error.validation_failed'),
          type: 'error',
        };
        if (errors.value.consent && errors.value.consent.length === 0) {
          errors.value.consent = [t('contact_form.error.consent_required')];
        }
      } else {
        feedbackMessage.value = {
          text: error.response.data?.message || t('contact_form.error.unexpected'),
          type: 'error',
        };
      }
    } else {
      feedbackMessage.value = {
        text: t('contact_form.error.network'),
        type: 'error',
      };
    }
  } finally {
    isLoading.value = false;
  }
};
</script>

<template>
  <div class="mx-auto max-w-2xl rounded-2xl bg-white dark:bg-gray-900 p-8 shadow-xl transition">
    <!-- Header -->
    <div class="mb-8 text-center">
      <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100">{{ $t('contact_form.title') }}</h2>
      <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $t('contact_form.subtitle') }}</p>
    </div>

    <form @submit.prevent="submitForm" class="space-y-6" novalidate>
      <!-- Vorname -->
      <div>
        <label for="firstname" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('contact_form.label_firstname') }}</label>
        <input
          id="firstname"
          v-model="form.firstname"
          type="text"
          :placeholder="t('contact_form.placeholder_firstname')"
          autocomplete="given-name"
          class="mt-2 block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
          :class="{ 'border-red-500': !!errors.firstname }"
        />
        <p v-if="errors.firstname" class="mt-2 text-sm text-red-600">{{ errors.firstname[0] }}</p>
      </div>

      <!-- Nachname -->
      <div>
        <label for="lastname" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('contact_form.label_lastname') }}</label>
        <input
          id="lastname"
          v-model="form.lastname"
          type="text"
          :placeholder="t('contact_form.placeholder_lastname')"
          autocomplete="family-name"
          class="mt-2 block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
          :class="{ 'border-red-500': !!errors.lastname }"
        />
        <p v-if="errors.lastname" class="mt-2 text-sm text-red-600">{{ errors.lastname[0] }}</p>
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('contact_form.label_email') }}</label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          :placeholder="t('contact_form.placeholder_email')"
          autocomplete="email"
          class="mt-2 block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
          :class="{ 'border-red-500': !!errors.email }"
        />
        <p v-if="errors.email" class="mt-2 text-sm text-red-600">{{ errors.email[0] }}</p>
      </div>

      <!-- Nachricht -->
      <div>
        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('contact_form.label_message') }}</label>
        <textarea
          id="message"
          v-model="form.message"
          rows="5"
          :placeholder="t('contact_form.placeholder_message')"
          class="mt-2 block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
          :class="{ 'border-red-500': !!errors.message }"
        ></textarea>
        <p v-if="errors.message" class="mt-2 text-sm text-red-600">{{ errors.message[0] }}</p>
      </div>

      <!-- DSGVO Checkbox -->
      <div class="flex items-start gap-2">
        <input
          id="consent"
          v-model="form.consent"
          type="checkbox"
          required
          class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
        />
        <label for="consent" class="text-sm text-gray-600 dark:text-gray-400">
          {{ $t('contact_form.consent_text') }}
        </label>
      </div>
      <p v-if="errors.consent" class="mt-2 text-sm text-red-600">{{ errors.consent[0] }}</p>

      <!-- Submit -->
      <button
        type="submit"
        :disabled="isLoading"
        class="w-full rounded-lg bg-indigo-600 dark:bg-yellow-400 px-5 py-3 font-semibold text-white dark:text-black shadow-md transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-70"
      >
        <span v-if="isLoading">{{ $t('contact_form.button_sending') }}</span>
        <span v-else>{{ $t('contact_form.button_send') }}</span>
      </button>

      <!-- Feedback -->
      <div
        v-if="feedbackMessage.text"
        :class="[
          'mt-4 rounded-lg p-4 text-sm font-medium',
          feedbackMessage.type === 'success'
            ? 'bg-green-100 text-green-800'
            : 'bg-red-100 text-red-800'
        ]"
        role="alert"
      >
        {{ feedbackMessage.text }}
      </div>
    </form>
  </div>
</template>
