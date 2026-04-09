<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CsvImport from '@/components/CsvImport.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Locations', href: '/locations' },
            { title: 'Import', href: '#' },
        ],
    },
});

defineProps<{ flash?: { success?: string } }>();

const model = { id: 'locations', name: 'Locations', hint: 'brand, name, type, latitude, longitude, address, description, link, photo_path, discount_info' };
</script>

<template>
    <Head title="Import Locations" />
    <CsvImport :model="model" :flash="flash" />
</template>