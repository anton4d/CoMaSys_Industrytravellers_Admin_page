<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CsvImport from '@/components/CsvImport.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Discounts', href: '/discounts' },
            { title: 'Import', href: '#' },
        ],
    },
});

defineProps<{ flash?: { success?: string } }>();

const model = { id: 'discounts', name: 'Discounts', hint: 'brand, title, description, expiration_date, user_type' };
</script>

<template>
    <Head title="Import Discounts" />
    <CsvImport :model="model" :flash="flash" />
</template>