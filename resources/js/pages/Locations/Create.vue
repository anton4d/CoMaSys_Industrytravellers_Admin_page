<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { store } from '@/routes/locations';
import LocationForm from '@/components/LocationForm.vue';
import { Brand, LocationType } from '@/types';
import { ref } from 'vue';
import Toast from '@/components/Toast.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Locations', href: '/locations' },
            { title: 'Create Location', href: '/locations/create' },
        ],
    },
});

const props = defineProps<{
    types: LocationType[];
    brands: Brand[];
    flash?: { success?: string; city_not_found?: string };
}>();

const toast = ref(props.flash?.success ?? '');
if (toast.value) {
    setTimeout(() => toast.value = '', 3000);
}
</script>

<template>
    <Head title="Create Location" />
    <Toast :message="flash?.success" />
    <LocationForm
        :form-props="store.form()"
        button-text="Create Location"
        :types="types"
        :brands="brands"
        :flash="flash"
    />
</template>