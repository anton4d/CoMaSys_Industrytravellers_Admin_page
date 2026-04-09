<script setup lang="ts">
import { Head} from '@inertiajs/vue3';
import { store } from '@/routes/brand';
import BrandForm from '@/components/BrandForm.vue';
import { Brand,UserType } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            {title: 'Brands', href: '/brands'},
            { title: 'Create Brand', href: '/brands/create' },
        ],
    },
});
const props = defineProps<{
}>();


</script>

<template>
    <Head title="Create Location" />
    <BrandForm :form-props="store.form()" button-text="Create Brand"" />
</template>