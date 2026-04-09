<script setup lang="ts">
defineProps<{ title: string }>();
</script>

<template>
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">{{ title }}</h1>
        <div class="flex gap-2">
            <slot />
        </div>
    </div>
</template>