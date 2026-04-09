<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CsvImport from '@/components/CsvImport.vue';
import { ref, computed } from 'vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'CSV Import', href: '/csv-import' },
        ],
    },
});

const props = defineProps<{
    flash?: { success?: string },
    model?: string,
}>();

const models = [
    { id: 'brands',    name: 'Brands',    hint: 'name, logo_url, website' },
    { id: 'locations', name: 'Locations', hint: 'brand, name, type, latitude, longitude, address, description, link, photo_path, discount_info' },
    { id: 'discounts', name: 'Discounts', hint: 'brand, title, description, expiration_date, user_type' },
];

const selectedId = ref(props.model ?? models[0].id);
const selectedModel = computed(() => models.find(m => m.id === selectedId.value) ?? models[0]);
</script>

<template>
    <Head title="CSV Import" />

    <div class="p-6 max-w-xl space-y-4">
        <div class="grid gap-2">
            <label class="text-sm font-medium">Import Into</label>
            <select v-model="selectedId" class="input bg-background text-foreground">
                <option v-for="m in models" :key="m.id" :value="m.id">{{ m.name }}</option>
            </select>
        </div>

        <CsvImport :model="selectedModel" :flash="flash" />
    </div>
</template>