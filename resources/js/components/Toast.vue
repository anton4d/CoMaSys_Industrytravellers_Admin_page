<script setup lang="ts">
import { ref, watch } from 'vue';

const props = defineProps<{ message?: string }>();

const visible = ref(props.message ?? '');

watch(() => props.message, (val) => {
    if (val) {
        visible.value = val;
        setTimeout(() => visible.value = '', 3000);
    }
}, { immediate: true });
</script>

<template>
    <div v-if="visible"
        class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-300">
        {{ visible }}
    </div>
</template>