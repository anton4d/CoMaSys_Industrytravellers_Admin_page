<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CsvImport from '@/components/CsvImport.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Brands', href: '/brands' },
            { title: 'Import', href: '#' },
        ],
    },
});

defineProps<{ flash?: { success?: string } }>();

const model = { id: 'brands', name: 'Brands', hint: 'name, logo_url, website' };
</script>

<template>
    <Head title="Import Brands" />
    <CsvImport :model="model" :flash="flash" />
</template>