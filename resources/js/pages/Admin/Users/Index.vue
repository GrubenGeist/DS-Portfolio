<template>
  <div>
    <h1>Benutzerverwaltung</h1>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>E-Mail</th>
          <th>Rolle</th>
          <th>Aktionen</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.role ? user.role.name : 'Keine Rolle' }}</td>
          <td>
            <Link :href="route('admin.users.editRole', user.id)">Rolle bearbeiten</Link>
            <button @click="destroy(user.id)">Löschen</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  users: {
    type: Array,
    required: true,
  },
});

const destroy = (id) => {
  if (confirm('Möchten Sie diesen Benutzer wirklich löschen?')) {
    useForm({}).delete(route('admin.users.destroy', id));
  }
};
</script>