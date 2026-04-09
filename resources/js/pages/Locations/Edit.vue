<script setup lang="ts">
import { Head, Form } from '@inertiajs/vue3';
import { update } from '@/routes/locations';
import LocationForm from '@/components/LocationForm.vue';
import type { Location,LocationType,Brand } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Locations', href: '/locations' },
            { title: 'Edit Location', href: '#' },
        ],
    },
});

const props = defineProps<{
    types: LocationType[];
    brands: Brand[];
    location: Location;
}>();

</script>

<template>
    <Head title="Edit Location" />
    <LocationForm :form-props="update.form(location.id)" button-text="Save Changes" :types="types" :brands="brands" :location="location" />
</template>