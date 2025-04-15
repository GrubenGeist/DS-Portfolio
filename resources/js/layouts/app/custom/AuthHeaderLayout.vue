<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import GuestAppHeader from '@/components/GuestAppHeader.vue';
import AppShell from '@/components/AppShell.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    
});
</script>

<template>
    <AppShell class="flex-col">
        <GuestAppHeader :breadcrumbs="breadcrumbs" />
        <AppContent>
            <slot />
        </AppContent>
    </AppShell>
</template>
