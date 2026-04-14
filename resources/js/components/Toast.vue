<script setup lang="ts">
import { ref, watch } from 'vue';

const props = defineProps<{
    message?: string;
    type?: 'success' | 'error';
}>();

const visible = ref('');

watch(() => props.message, (val) => {
    if (val) {
        visible.value = val;
        setTimeout(() => visible.value = '', 3000);
    }
}, { immediate: true });
</script>

<template>
    <div
        v-if="visible"
        :class="[
            'fixed top-4 right-4 px-4 py-2 rounded shadow-lg transition-opacity duration-300 text-white',
            props.type === 'error' ? 'bg-red-500' : 'bg-green-500'
        ]"
    >
        {{ visible }}
    </div>
</template>