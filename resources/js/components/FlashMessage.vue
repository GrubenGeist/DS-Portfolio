<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(false);

// Beobachtet die 'flash.success'-Prop, die Inertia vom Backend bereitstellt.
const message = computed(() => (page.props.flash as any)?.success);

// Wenn sich die Nachricht ändert (d.h. eine neue vom Server kommt),
// wird die Benachrichtigung angezeigt und ein Timer zum Ausblenden gestartet.
watch(message, () => {
  if (message.value) {
    show.value = true;
    setTimeout(() => {
      show.value = false;
      // Optional: Löscht die Nachricht, damit sie bei Zurück/Vorwärts-Navigation nicht erneut erscheint.
      if (page.props.flash) {
        (page.props.flash as any).success = null;
      }
    }, 3000); // 3 Sekunden anzeigen
  }
}, { immediate: true });
</script>

<template>
  <transition
    enter-active-class="ease-out duration-300"
    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
    leave-active-class="ease-in duration-200"
    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
  >
    <div v-if="show && message" class="fixed top-5 right-5 z-50 max-w-sm w-full bg-green-500 dark:bg-green-600 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
      <div class="p-4">
        <div class="flex items-start">
          <div class="flex-shrink-0">
            <!-- Checkmark Icon -->
            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <div class="ml-3 w-0 flex-1 pt-0.5">
            <p class="text-sm font-medium text-white">
              {{ message }}
            </p>
          </div>
          <div class="ml-4 flex-shrink-0 flex">
            <button @click="show = false" class="inline-flex text-white rounded-md hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400">
              <span class="sr-only">Close</span>
              <!-- X Icon -->
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>
