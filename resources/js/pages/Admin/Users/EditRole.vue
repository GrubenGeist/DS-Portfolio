<script setup lang="ts">
import { route } from 'ziggy-js';
import { defineProps } from 'vue';
// useForm importieren (reactive ist nicht nötig, da useForm das intern macht)
import { useForm, Head } from '@inertiajs/vue3';
// router wird für put nicht mehr gebraucht

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  // Das sind ALLE verfügbaren Rollen (für die Auswahl)
  roles: {
    type: Array,
    required: true,
  },
});

// KORREKT: useForm verwenden
// Initialisiert das Formular mit der aktuellen Rolle des Benutzers (dem Namen der ersten Rolle)
const form = useForm({
  // Prüfe, ob user.roles existiert und nicht leer ist, nimm den Namen der ersten Rolle, sonst null
  role: props.user.roles && props.user.roles.length > 0 ? props.user.roles[0].name : null,
});

// KORREKT: Submit-Funktion mit form.put
const updateRole = () => {
  form.put(route('admin.users.updateRole', props.user.id), {
    // preserveScroll: true, // Optional: Scrollposition beibehalten
    // Optional: Callbacks definieren
    // onSuccess: () => alert('Erfolgreich!'),
    // onError: () => alert('Fehler!'),
  });
};
</script>


<template>
  <div>
    <h1>User Rolle bearbeiten für {{ user.name }}</h1>
    <form @submit.prevent="updateRole">
        <select v-model="form.role">
            <option :value="null">-- Keine Rolle --</option> <option v-for="roleOption in roles" :key="roleOption.id" :value="roleOption.name">
                {{ roleOption.name }}
            </option>
        </select>
        <div v-if="form.errors.role" class="text-red-500 text-sm mt-1">
            {{ form.errors.role }}
        </div>
      
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit" :disabled="form.processing">
            Speichern
        </button>
    </form>
  </div>
</template>

