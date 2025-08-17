<script setup lang="ts">
import AuthLayout from '@/layouts/auth/AuthSplitLayout.vue';

defineProps<{ title?: string; description?: string }>();
</script>

<template>
  <a href="#main" class="sr-only-focusable">Zum Inhalt springen</a>

  <AuthLayout :title="title" :description="description">
    <main id="main" tabindex="-1" role="main" class="focus:outline-none">
      <h1 v-if="title" class="sr-only">{{ title }}</h1>
      <slot />
    </main>
  </AuthLayout>
</template>
