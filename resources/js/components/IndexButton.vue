<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Eye, Pencil, Trash2 } from '@lucide/vue';

export type IndexButtonType = 'show' | 'edit' | 'delete';

const props = defineProps<{
    type: IndexButtonType;
    href?: string;
    onClick?: () => void;
}>();

const config = {
    show:   { variant: 'outline',     icon: Eye    },
    edit:   { variant: 'outline',     icon: Pencil },
    delete: { variant: 'destructive', icon: Trash2 },
} as const;
</script>

<template>
    <Button
        :variant="config[type].variant"
        size="sm"
        :as="href ? 'a' : 'button'"
        :href="href"
        @click="onClick"
    >
        <component :is="config[type].icon" class="w-4 h-4" />
    </Button>
</template>