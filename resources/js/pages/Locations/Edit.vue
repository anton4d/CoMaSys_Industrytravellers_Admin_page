<script setup lang="ts">
import { Head, Form } from '@inertiajs/vue3';
import { update } from '@/routes/locations';
import LocationForm from '@/components/LocationForm.vue';

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
    types: { id: number; name: string }[];
    
    location: {
        id: number;
        name: string;
        type: number;
        latitude: number;
        longitude: number;
        expiration_date: string;
        info: {
            address: string;
            description: string | null;
            link: string | null;
            photo_path: string | null;
            discount_info: string | null;
        };
    };
}>();

</script>

<template>
    <Head title="Edit Location" />
    <LocationForm :form-props="update.form(location.id)" button-text="Save Changes" :types="types" :location="location" />
</template>