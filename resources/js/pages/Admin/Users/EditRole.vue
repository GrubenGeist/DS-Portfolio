<template>
  <div>
    <h1>Rolle bearbeiten für {{ user.name }}</h1>
    <form @submit.prevent="updateRole">
      <label for="role">Rolle auswählen:</label>
      <select id="role" v-model="form.role">
        <option value="gast">Gast</option>
        <option value="betrieb">Betrieb</option>
        <option value="admin">Admin</option>
      </select>
      <button type="submit">Rolle aktualisieren</button>
    </form>
  </div>
</template>

<script setup>
import { defineProps, reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  roles: {
    type: Array,
    required: true,
  },
});

const form = reactive({
  role: props.user.role ? props.user.role.slug : 'gast', // Setzen Sie die aktuelle Rolle als Standardwert
});

const updateRole = () => {
  router.put(route('admin.users.updateRole', props.user.id), form);
};
</script>