<script setup lang="ts">
import { ref } from 'vue';
import type { Ref } from 'vue';
import axios from 'axios'; // Stelle sicher, dass axios installiert ist: npm install axios

// Interface für die Struktur der Formulardaten
interface FormData {
  firstname: string;
  lastname: string;
  email: string;
  message: string;
}

// Interface für die Struktur der Validierungsfehler (wie von Laravel gesendet)
// Record<string, string[]> bedeutet ein Objekt, bei dem die Schlüssel Strings sind
// und die Werte Arrays von Strings (z.B. errors.email = ['Fehlermeldung 1', '...'])
type ValidationErrors = Record<string, string[]>;

// Interface für Feedback-Nachrichten
interface FeedbackMessage {
  text: string;
  type: 'success' | 'error';
}

const form: Ref<FormData> = ref({
  firstname: '',
  lastname: '',
  email: '',
  message: '',
});

const errors: Ref<ValidationErrors> = ref({});
const feedbackMessage: Ref<FeedbackMessage> = ref({ text: '', type: 'error' });
const isLoading: Ref<boolean> = ref(false);

const resetForm = (): void => {
  form.value.firstname = '';  
  form.value.lastname = '';
  form.value.email = '';
  form.value.message = '';
  errors.value = {};
};

const submitForm = async (): Promise<void> => {
  isLoading.value = true;
  errors.value = {};
  feedbackMessage.value = { text: '', type: 'error' }; // Feedback zurücksetzen

  try {
    // Die API-Route, die du in routes/api.php definiert hast
    const response = await axios.post<{ message: string }>('/api/contact', form.value);
    feedbackMessage.value = { text: response.data.message, type: 'success' };
    resetForm();
  } catch (error: any) { // any ist hier pragmatisch, man könnte es genauer typisieren
    if (axios.isAxiosError(error) && error.response) {
      if (error.response.status === 422) {
        // Validierungsfehler vom Laravel Backend
        errors.value = error.response.data.errors as ValidationErrors;
        feedbackMessage.value = { text: error.response.data.message || 'Bitte überprüfen Sie Ihre Eingaben.', type: 'error' };
      } else {
        // Andere Serverfehler (z.B. 500)
        feedbackMessage.value = { text: error.response.data.message || 'Ein unerwarteter Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.', type: 'error' };
      }
    } else {
      // Netzwerkfehler oder anderer Client-seitiger Fehler
      feedbackMessage.value = { text: 'Netzwerkfehler oder ein Problem ist aufgetreten. Bitte versuchen Sie es später erneut.', type: 'error' };
      console.error('Submission error:', error);
    }
  } finally {
    isLoading.value = false;
  }
};
</script>




<template>
  <div class="mx-auto max-w-xl rounded-lg bg-white p-6 shadow-lg sm:p-8 lg:p-10">
    <div class="text-center mb-8">
      <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Kontaktieren Sie uns</h2>
      <p class="mt-3 text-lg leading-8 text-gray-600">
        Wir freuen uns auf Ihre Nachricht!
      </p>
    </div>

    <form @submit.prevent="submitForm" class="space-y-6">
      
      <div>
        <label for="firstName" class="block text-sm font-semibold leading-6 text-gray-900">Vorname</label>
        <div class="mt-2.5">
          <input
            type="text"
            name="firstName"
            id="firstName"
            v-model="form.firstName"
            autocomplete="given-name"
            class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            :class="{ 'ring-red-500 focus:ring-red-500': errors.firstName }"
            aria-invalid="errors.firstName ? 'true' : 'false'"
            aria-describedby="firstName-error"
          />
          <p v-if="errors.firstName" id="firstName-error" class="mt-2 text-sm text-red-600">{{ errors.firstName[0] }}</p>
        </div>
      </div>

      <div>
        <label for="lastName" class="block text-sm font-semibold leading-6 text-gray-900">Nachname</label>
        <div class="mt-2.5">
          <input
            type="text"
            name="lastName"
            id="lastName"
            v-model="form.lastName"
            autocomplete="family-name"
            class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            :class="{ 'ring-red-500 focus:ring-red-500': errors.lastName }"
            aria-invalid="errors.lastName ? 'true' : 'false'"
            aria-describedby="lastName-error"
          />
          <p v-if="errors.lastName" id="lastName-error" class="mt-2 text-sm text-red-600">{{ errors.lastName[0] }}</p>
        </div>
      </div>

      <div>
        <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">E-Mail-Adresse</label>
        <div class="mt-2.5">
          <input
            type="email"
            name="email"
            id="email"
            v-model="form.email"
            autocomplete="email"
            class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            :class="{ 'ring-red-500 focus:ring-red-500': errors.email }"
            aria-invalid="errors.email ? 'true' : 'false'"
            aria-describedby="email-error"
          />
          <p v-if="errors.email" id="email-error" class="mt-2 text-sm text-red-600">{{ errors.email[0] }}</p>
        </div>
      </div>

      <div>
        <label for="message" class="block text-sm font-semibold leading-6 text-gray-900">Nachricht</label>
        <div class="mt-2.5">
          <textarea
            name="message"
            id="message"
            rows="4"
            v-model="form.message"
            class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            :class="{ 'ring-red-500 focus:ring-red-500': errors.message }"
            aria-invalid="errors.message ? 'true' : 'false'"
            aria-describedby="message-error"
          ></textarea>
          <p v-if="errors.message" id="message-error" class="mt-2 text-sm text-red-600">{{ errors.message[0] }}</p>
        </div>
      </div>

      <div class="mt-10 pt-4 border-t border-gray-200">
        <button
          type="submit"
          :disabled="isLoading"
          class="flex w-full items-center justify-center rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-75 disabled:cursor-not-allowed"
        >
          <svg v-if="isLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          {{ isLoading ? 'Wird gesendet...' : 'Nachricht senden' }}
        </button>
      </div>

      <div v-if="feedbackMessage.text" :class="['mt-4 rounded-md p-4', feedbackMessage.type === 'success' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700']" role="alert">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg v-if="feedbackMessage.type === 'success'" class="h-5 w-5 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <svg v-else class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium">{{ feedbackMessage.text }}</p>
          </div>
        </div>
      </div>
    </form>
  </div>
  </template>