<!-- <script setup lang="ts">
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AppLayout>
</template>
-->

<script setup>

// Hier könntest du bei Bedarf weitere Logik für das Layout hinzufügen
</script>

<template>
  <div class="guest-layout container mx-auto">
    <header class="bg-gray-100 py-4">
      <div class="container mx-auto px-4">
        <slot name="header">
          Willkommen!
        </slot>
      </div>
    </header>

    <main class="py-8">
      <div class="container mx-auto px-4">
        <slot />
      </div>
    </main>

    <footer class="bg-gray-200 py-4 text-center text-gray-600">
      <slot name="footer">
        &copy; {{ new Date().getFullYear() }} Meine Webseite
      </slot>
    </footer>
  </div>
</template>


<style scoped>
/* Hier kannst du spezifische Stile für das GuestLayout hinzufügen */
.guest-layout {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

main {
  flex-grow: 1;
}
</style>
