<script setup lang="ts">
import { Head} from '@inertiajs/vue3';
import { store } from '@/routes/locations';
import LocationForm from '@/components/LocationForm.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Create Location', href: '/locations/create' },
        ],
    },
});
const props = defineProps<{
    types: { id: number; name: string }[];
}>();


</script>

<template>

    <Head title="Create Location" />
    <LocationForm :form-props="store.form()" button-text="Create Location" :types="types" />
</template>