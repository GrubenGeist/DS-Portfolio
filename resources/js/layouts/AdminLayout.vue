<template>
  <div>
    <nav>
      <ul>
        <li>
          <Link href="/admin/dashboard">Dashboard</Link>
        </li>
        <li>
          <Link :href="route('admin.users.index')">Benutzerverwaltung</Link>
        </li>
        </ul>
    </nav>
    <main>
      <slot />
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>