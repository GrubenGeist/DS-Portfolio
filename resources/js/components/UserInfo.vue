<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import type { User } from '@/types';
import { computed } from 'vue';

interface Props {
  user: User;
  showEmail?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  showEmail: false,
});

const { getInitials } = useInitials();

// garantiert boolean (nicht nur truthy string)
const showAvatar = computed(() => {
  const a = props.user?.avatar;
  return typeof a === 'string' && a.length > 0;
});

// sichere Strings für AvatarImage
const avatarSrc = computed(() => (typeof props.user?.avatar === 'string' ? props.user.avatar : ''));
const avatarAlt = computed(() => props.user?.name ?? 'User Avatar');
</script>

<template>
  <Avatar class="h-8 w-8 overflow-hidden rounded-lg">
    <AvatarImage v-if="showAvatar" :src="avatarSrc" :alt="avatarAlt" />
    <AvatarFallback class="rounded-lg text-black dark:text-white">
      {{ getInitials((user?.name ?? '')) }}
    </AvatarFallback>
  </Avatar>

  <div class="grid flex-1 text-left text-sm leading-tight">
    <span class="truncate font-medium">{{ user?.name ?? '' }}</span>
    <span v-if="showEmail" class="truncate text-xs text-muted-foreground">{{ user?.email ?? '' }}</span>
  </div>
</template>
