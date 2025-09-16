<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils'; // Importiere das cn-Hilfsprogramm für Klassen

interface LinkData {
  url: string | null;
  label: string;
  active: boolean;
}

interface Props {
  links: LinkData[];
}

defineProps<Props>();
</script>

<template>
  <nav v-if="links.length > 3" role="navigation" aria-label="Pagination Navigation">
    <ul class="flex items-center justify-center space-x-1">
      <li
        v-for="(link, key) in links"
        :key="key"
      >
        <div
          v-if="link.url === null"
          class="flex h-10 w-10 items-center justify-center rounded-md text-sm text-muted-foreground"
          v-html="link.label"
        />

        <Link
          v-else
          :href="link.url"
          class="flex h-10 w-10 items-center justify-center rounded-md text-sm transition-colors"
          :class="{
            'bg-primary text-primary-foreground hover:bg-primary/90': link.active,
            'hover:bg-accent hover:text-accent-foreground': !link.active,
          }"
        >
          <span v-if="link.label.includes('Previous')" class="sr-only">Zurück</span>
          <ChevronLeft v-if="link.label.includes('Previous')" class="h-5 w-5" />

          <span v-else-if="link.label.includes('Next')" class="sr-only">Weiter</span>
          <ChevronRight v-else-if="link.label.includes('Next')" class="h-5 w-5" />
          
          <span v-else>{{ link.label }}</span>
        </Link>
      </li>
    </ul>
  </nav>
</template>