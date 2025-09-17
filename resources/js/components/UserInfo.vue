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

const showAvatar = computed(() => {
  const a = props.user?.avatar;
  return typeof a === 'string' && a.length > 0;
});

const avatarAlt = computed(() => props.user?.name ?? 'User Avatar');
</script>

<template>
  <div v-if="user" class="flex items-center gap-3">
    <Avatar class="h-9 w-9">
      <AvatarImage v-if="showAvatar" :src="user.avatar || ''" :alt="avatarAlt" />
      <AvatarFallback>
        {{ getInitials(user.name ?? '') }}
      </AvatarFallback>
    </Avatar>

    <div class="grid flex-1 text-left text-sm leading-tight">
      <span class="truncate font-semibold">{{ user.name ?? '' }}</span>
      <span v-if="showEmail" class="truncate text-xs text-muted-foreground">{{ user.email ?? '' }}</span>
    </div>
  </div>
</template>