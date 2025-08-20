<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import ContactFormInner from '@/components/ContactFormInner.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'contactForm',
        href: '/contactform',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
    <div class="py-8 px-4">
      <ContactFormInner />
    </div>
    </AppLayout>
</template>
