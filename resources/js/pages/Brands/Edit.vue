<script setup lang="ts">
import { Head} from '@inertiajs/vue3';
import { update } from '@/routes/brand';
import BrandForm from '@/components/BrandForm.vue';
import { Brand} from '@/types';

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
    brand: Brand;
}>();


</script>

<template>
    <Head title="Create Location" />
    <BrandForm :form-props="update.form(brand.id)" button-text="Update Brand":brand="brand""/>
</template>