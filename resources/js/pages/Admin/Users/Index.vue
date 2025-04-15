<script setup lang="ts">
import { defineProps } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthCustomLayout from '@/layouts/auth/custom/AuthCustomLayout.vue'; // Pfad anpassen!
import { type BreadcrumbItem } from '@/types';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { route } from 'ziggy-js';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User Index',
        href: '/user',
    },
];

// Props-Definition ist korrekt
const props = defineProps({
  users: {
    type: Array,
    required: true,
  },
});

// Destroy-Funktion ist korrekt
const destroy = (id) => {
  if (confirm('Möchten Sie diesen Benutzer wirklich löschen?')) {
    // Kleiner Tipp: Inertia's useForm ist reaktiv, man kann Optionen übergeben
    const form = useForm({}); // Leeres Formular für DELETE
    form.delete(route('admin.users.destroy', id), {
        preserveScroll: true, // Optional: Scrollposition nach Aktion beibehalten
        // onSuccess: () => { /* Optional: Aktion nach Erfolg */ },
        // onError: () => { /* Optional: Aktion bei Fehler */ },
    });
  }
};


</script>




<template>
  <Head title="User Index" />
  <AuthCustomLayout :breadcrumbs="breadcrumbs">
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
          
          <td>
            <span v-if="user.roles && user.roles.length > 0">
              {{ user.roles[0].name }}
            </span>
            <span v-else>
              Keine Rolle
            </span>
          </td>

          <!-- Mehrere Rollen Anzeigen falls user mehrere besitzen darf -->
          <!--
          <td>
            <span v-if="user.roles && user.roles.length > 0">
              {{ user.roles.map(role => role.name).join(', ') }} {/* Zeigt alle Rollennamen, durch Komma getrennt */}
            </span>
            <span v-else>
              Keine Rolle
            </span>
          </td>
          -->

          
          <td class= "grid grid-cols-2 grid-rows-1 gap-4 grid-flow-dense lg:grid-cols-3" >
            <Link class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :href="route('admin.users.editRole', user.id)">Rolle bearbeiten</Link>
            <button @click="destroy(user.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Löschen</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  </AuthCustomLayout>
</template>

<style scoped>
/* Füge hier deine Tabellen-Styles hinzu, damit es besser aussieht */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}
th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}
th {
  background-color: #f2f2f2;
}
</style>