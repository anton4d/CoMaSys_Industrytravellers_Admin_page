<script setup lang="ts">
import { Head} from '@inertiajs/vue3';
import { store } from '@/routes/locations';
import LocationForm from '@/components/LocationForm.vue';
import { Brand,LocationType } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            {title: 'Locations', href: '/locations'},
            { title: 'Create Location', href: '/locations/create' },
        ],
    },
});
const props = defineProps<{
    types: LocationType[];
    brands: Brand[];
}>();


</script>

<template>
    <Head title="Create Location" />
    <LocationForm :form-props="store.form()" button-text="Create Location" :types="types" :brands="brands" />
</template>