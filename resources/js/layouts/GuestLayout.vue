<script setup lang="ts">
import StartHeaderLayout from '@/layouts/app/custom/StartHeaderLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <StartHeaderLayout :breadcrumbs="breadcrumbs">
        <slot /> 
    </StartHeaderLayout>
</template>
